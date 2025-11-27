    // ===== state =====
    let players = [];
    const colors = ['#ef4444','#2563eb','#16a34a','#f97316','#7c3aed','#0f172a'];
    let currentPlayer = 0;
    let positions = [];
    let names = [];
    let gameStarted = false;
    let animating = false;
    let penalties = []; // list of penalty texts
    let penaltyPositions = []; // array of {pos, text, el}
    const penaltyMoveBack = 0; // move back value when hit penalty

    // track finished players (indices)
    let finishedPlayers = [];

    // ladders & snakes (original)
    const ladders = {4:26,8:51,28:46,39:60,52:68,44:80,64:85,69:93,71:92,84:98};
    const snakes = {11:9,36:14,57:19,43:22,66:47,94:48,90:49,81:63,96:65, 99:78};

    // DOM
    const playerCountEl = document.getElementById('playerCount');
    const playerNamesWrap = document.getElementById('playerNames');
    const startBtn = document.getElementById('openSetupBtn'); // repurposed
    const rollBtn = document.getElementById('rollBtn');
    const resetBtn = document.getElementById('resetBtn');
    const turnInfo = document.getElementById('turnInfo');
    const diceResult = document.getElementById('diceResult');
    const diceImage = document.getElementById('diceImage');
    const boardEl = document.getElementById('board');
    const logEl = document.getElementById('log');

    // setup modal elements
    const setupModal = document.getElementById('setupModal');
    const playerCountModal = document.getElementById('playerCountModal');
    const modalPlayerNames = document.getElementById('modalPlayerNames');
    const modalPenalties = document.getElementById('modalPenalties');
    const addModalPenalty = document.getElementById('addModalPenalty');
    const startFromModal = document.getElementById('startFromModal');
    const tabButtons = document.querySelectorAll('.tab-btn');

    // penalty hit modal
    const penaltyHitModal = document.getElementById('penaltyHitModal');
    const penaltyTextEl = document.getElementById('penaltyText');
    const penaltyOk = document.getElementById('penaltyOk');

    // ===== utilities =====
    function getPositionCoords(pos) {
      const rect = boardEl.getBoundingClientRect();
      const cellW = rect.width / 10;
      const cellH = rect.height / 10;
      const row = Math.floor((pos - 1) / 10);
      const col = (row % 2 === 0) ? (pos - 1) % 10 : 9 - (pos - 1) % 10;
      const x = col * cellW + cellW / 2;
      const y = (9 - row) * cellH + cellH / 2;
      return { x, y, cellW, cellH };
    }

    // Advance currentPlayer to the next not-finished player.
    function advanceToNextActivePlayer() {
      if (players.length === 0) return;
      if (finishedPlayers.length === players.length) {
        turnInfo.textContent = 'Semua pemain telah mencapai FINISH';
        rollBtn.disabled = true;
        gameStarted = false;
        return;
      }
      let tries = 0;
      do {
        currentPlayer = (currentPlayer + 1) % players.length;
        tries++;
      } while (finishedPlayers.includes(currentPlayer) && tries <= players.length);
      turnInfo.textContent = `Giliran: ${names[currentPlayer]}`;
    }

    /*
      generateNameInputs(countEl, container, readOnly)
      - readOnly when true will make the generated inputs disabled (for UI display only)
      - if names[] has values, fill the input values from names
    */
    function generateNameInputs(countEl, container, readOnly = false) {
      const count = Math.max(2, Math.min(6, parseInt(countEl.value) || 2));
      container.innerHTML = '';
      for (let i = 0; i < count; i++) {
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = `Nama Pemain ${i + 1}`;
        input.className = 'name-input';
        input.maxLength = 12;
        input.disabled = !!readOnly;
        if (names && names[i]) input.value = names[i];
        container.appendChild(input);
      }
    }

    // ===== setup modal (non-closable until start) =====
    function openSetupModal() {
      setupModal.style.display = 'flex';
    }
    function closeSetupModal() {
      setupModal.style.display = 'none';
    }

    // tab switching
    tabButtons.forEach(b => {
      b.addEventListener('click', () => {
        tabButtons.forEach(t => t.classList.remove('active'));
        b.classList.add('active');
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.getElementById(b.dataset.tab).classList.add('active');
      });
    });

    // modal initial state on page load: always show; user must configure before playing
    window.addEventListener('load', () => {
      openSetupModal();
      playerCountModal.value = playerCountEl.value || 2;
      generateNameInputs(playerCountModal, modalPlayerNames);
      loadPenaltiesFromStorage();
      renderModalPenalties();
      loadLog();
    });

    playerCountModal.addEventListener('change', () => generateNameInputs(playerCountModal, modalPlayerNames));

    function renderModalPenalties() {
      modalPenalties.innerHTML = '';
      if (!penalties.length) {
        const emptyText = document.createElement('div');
        emptyText.style.color = '#475569';
        emptyText.style.fontWeight = '600';
        emptyText.textContent = 'Belum ada hukuman. Tambahkan hukuman.';
        modalPenalties.appendChild(emptyText);
        return;
      }
      penalties.forEach((p, idx) => {
        const row = document.createElement('div');
        row.className = 'pen-input';
        const ta = document.createElement('textarea');
        ta.value = p;
        ta.addEventListener('input', (e) => {
          penalties[idx] = e.target.value;
        });
        const del = document.createElement('button');
        del.className = 'btn';
        del.textContent = 'Hapus';
        del.addEventListener('click', () => {
          penalties.splice(idx, 1);
          renderModalPenalties();
        });
        row.appendChild(ta);
        row.appendChild(del);
        modalPenalties.appendChild(row);
      });
    }

    addModalPenalty.addEventListener('click', () => {
      penalties.push('Hukuman baru');
      renderModalPenalties();
    });

    // ===== start game flow triggered from modal only =====
    startFromModal.addEventListener('click', () => {
      const count = Math.max(2, Math.min(6, parseInt(playerCountModal.value) || 2));
      const nameInputs = modalPlayerNames.querySelectorAll('input');
      if (nameInputs.length < 2) return alert('Minimal 2 pemain');

      names = [];
      nameInputs.forEach((input, i) => names.push((input.value.trim()) || `P${i+1}`));

      // ensure penalties present
      penalties = penalties.map(p => (p||'').trim()).filter(p => p);
      if (!penalties.length) {
        if (!confirm('Belum ada hukuman. Lanjutkan tanpa hukuman?')) return;
      } else {
        localStorage.setItem('penalties', JSON.stringify(penalties));
      }

      // apply names to UI: create disabled inputs showing players
      playerCountEl.value = count;
      generateNameInputs(playerCountEl, playerNamesWrap, true);
      const mainInputs = playerNamesWrap.querySelectorAll('input');
      mainInputs.forEach((i, idx) => i.value = names[idx] || '');

      closeSetupModal();
      initGameFromSetup(count);
    });

    function initGameFromSetup(count) {
      positions = new Array(count).fill(1);
      players = [];
      boardEl.innerHTML = '';
      logEl.innerHTML = '';
      penaltyPositions = [];
      players = [];
      finishedPlayers = []; // reset finished players on new game
      // create markers for players
      for (let i = 0; i < count; i++) {
        const div = document.createElement('div');
        div.className = 'player';
        div.style.background = colors[i % colors.length];
        div.textContent = names[i][0]?.toUpperCase() || (i+1);
        div.title = names[i];
        boardEl.appendChild(div);
        players.push(div);
      }
      // place penalties randomly on board
      placePenaltiesRandom();
      updatePositions();
      currentPlayer = 0;
      turnInfo.textContent = `Giliran: ${names[currentPlayer]}`;
      rollBtn.disabled = false;
      gameStarted = true;
      animating = false;
      saveLog('Game dimulai: ' + names.join(', '));
      document.getElementById('diceResult').textContent = '';
    }

    function resetGame() {
      if (!confirm('Reset permainan? Semua data posisi akan dikosongkan.')) return;
      names = [];
      positions = [];
      players = [];
      currentPlayer = 0;
      gameStarted = false;
      animating = false;
      boardEl.innerHTML = '';
      logEl.innerHTML = '';
      penaltyPositions = [];
      finishedPlayers = [];
      document.getElementById('turnInfo').textContent = '';
      document.getElementById('diceResult').textContent = '';
      document.getElementById('diceImage').innerHTML = '';
      rollBtn.disabled = true;
      startBtn.disabled = false;
      generateNameInputs(playerCountEl, playerNamesWrap, true);
      saveLog('Game direset');
      openSetupModal();
    }

    // ===== penalty placement & handling =====
    function loadPenaltiesFromStorage() {
      const p = JSON.parse(localStorage.getItem('penalties') || '[]');
      if (Array.isArray(p) && p.length) penalties = p;
    }

    function placePenaltiesRandom() {
      // clear existing
      penaltyPositions.forEach(pp => { if (pp.el && pp.el.parentElement) pp.el.remove(); });
      penaltyPositions = [];
      if (!penalties.length) return;
      const safePositions = Array.from({length: 100}, (_, i) => i+1)
        .filter(pos => pos !== 1 && pos !== 100)
        .filter(pos => !ladders[pos] && !snakes[pos]);
      const shuffled = safePositions.slice().sort(() => Math.random() - 0.5);
      const pickCount = Math.min(penalties.length, shuffled.length);
      for (let i = 0; i < pickCount; i++) {
        const pos = shuffled[i];
        const text = penalties[i] || penalties[i % penalties.length];
        const marker = document.createElement('div');
        marker.className = 'pen-mark';
        marker.title = text;
        marker.innerText = '!!';
        boardEl.appendChild(marker);
        penaltyPositions.push({pos, text, el: marker});
      }
      updatePenaltyMarkers();
    }

    function updatePenaltyMarkers() {
      penaltyPositions.forEach(pp => {
        const {x, y, cellW, cellH} = getPositionCoords(pp.pos);
        pp.el.style.left = `${x}px`;
        pp.el.style.top = `${y - cellH * 0.22}px`;
      });
    }

    function getPenaltyAt(pos) {
      return penaltyPositions.find(pp => pp.pos === pos);
    }

    function showPenaltyModal(pen, onOk) {
      penaltyTextEl.textContent = pen;
      penaltyHitModal.style.display = 'flex';
      const handler = () => {
        penaltyOk.removeEventListener('click', handler);
        penaltyHitModal.style.display = 'none';
        if (typeof onOk === 'function') onOk();
      };
      penaltyOk.addEventListener('click', handler);
    }

    // ===== dice & movement logic (adapted) =====
    function rollDice() {
      if (!gameStarted || players.length === 0 || animating) return;

      // skip players that already finished
      if (finishedPlayers.includes(currentPlayer)) {
        advanceToNextActivePlayer();
        if (!gameStarted || finishedPlayers.includes(currentPlayer)) return;
      }

      animating = true;
      diceResult.textContent = 'Mengocok...';
      diceImage.innerHTML = '<img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Alea_1.png" width="54" alt="dice">';
      rollBtn.disabled = true;

      setTimeout(() => {
        const dice = Math.floor(Math.random() * 6) + 1;
        diceResult.textContent = `${names[currentPlayer]} mendapatkan ${dice}`;
        diceImage.innerHTML = `<img src="https://upload.wikimedia.org/wikipedia/commons/${getDiceImage(dice)}" width="54" alt="dice">`;

        const steps = generateSteps(positions[currentPlayer], dice);
        animateSteps(steps, () => {
          const finalPos = positions[currentPlayer];
          if (ladders[finalPos]) {
            logAction(`${names[currentPlayer]} menemukan tangga! Naik dari ${finalPos} ke ${ladders[finalPos]}`);
            positions[currentPlayer] = ladders[finalPos];
            popToken(currentPlayer);
            updatePositions();
          } else if (snakes[finalPos]) {
            logAction(`${names[currentPlayer]} terkena ular! Turun dari ${finalPos} ke ${snakes[finalPos]}`);
            positions[currentPlayer] = snakes[finalPos];
            popToken(currentPlayer);
            updatePositions();
          }

          const penalty = getPenaltyAt(positions[currentPlayer]);
          if (penalty) {
            logAction(`${names[currentPlayer]} terkena hukuman di ${positions[currentPlayer]}: ${penalty.text}`);
            showPenaltyModal(penalty.text, () => {
              let target = positions[currentPlayer] - penaltyMoveBack;
              if (target < 1) target = 1;
              const stepsBack = [];
              for (let p = positions[currentPlayer] - 1; p >= target; p--) stepsBack.push(p);
              if (stepsBack.length) {
                animating = true;
                animateSteps(stepsBack, () => {
                  const newPos = positions[currentPlayer];
                  if (ladders[newPos]) {
                    logAction(`${names[currentPlayer]} menemukan tangga pasca hukuman! Naik dari ${newPos} ke ${ladders[newPos]}`);
                    positions[currentPlayer] = ladders[newPos];
                    popToken(currentPlayer);
                    updatePositions();
                  } else if (snakes[newPos]) {
                    logAction(`${names[currentPlayer]} terkena ular pasca hukuman! Turun dari ${newPos} ke ${snakes[newPos]}`);
                    positions[currentPlayer] = snakes[newPos];
                    popToken(currentPlayer);
                    updatePositions();
                  }
                  finalizeTurnAfterRoll(dice);
                });
                return;
              }
              finalizeTurnAfterRoll(dice);
            });
            return;
          }

          finalizeTurnAfterRoll(dice);
        });

      }, 350);
    }

    function finalizeTurnAfterRoll(dice) {
      // Jika pemain mencapai finish
      if (positions[currentPlayer] === 100) {
        if (!finishedPlayers.includes(currentPlayer)) {
          finishedPlayers.push(currentPlayer);
          logAction(`${names[currentPlayer]} mencapai FINISH!`);
          alert(`${names[currentPlayer]} telah mencapai FINISH!`);
        }

        if (finishedPlayers.length === players.length) {
          alert("Semua pemain telah mencapai FINISH! Permainan selesai.");
          rollBtn.disabled = true;
          gameStarted = false;
          animating = false;
          return;
        }

        // lanjutkan ke pemain berikutnya yang belum finish
        advanceToNextActivePlayer();
        rollBtn.disabled = false;
        animating = false;
        return;
      }

      // Pemain belum finish
      if (dice !== 6) {
        advanceToNextActivePlayer();
      } else {
        logAction(`${names[currentPlayer]} dapat 6 dan mendapat giliran lagi!`);
      }

      turnInfo.textContent = `Giliran: ${names[currentPlayer]}`;
      rollBtn.disabled = false;
      animating = false;
    }

    function generateSteps(start, dice) {
      const steps = [];
      let pos = start;
      let dir = 1;
      for (let i = 0; i < dice; i++) {
        let next = pos + dir;
        if (next > 100) {
          dir = -1;
          next = pos + dir;
        } else if (next < 1) {
          dir = 1;
          next = pos + dir;
        }
        pos = next;
        steps.push(pos);
      }
      return steps;
    }

    function animateSteps(steps, cb) {
      const delay = 240;
      let idx = 0;
      function step() {
        if (idx >= steps.length) {
          if (steps.length) positions[currentPlayer] = steps[steps.length - 1];
          updatePositions();
          cb();
          return;
        }
        positions[currentPlayer] = steps[idx];
        updatePositions();
        logAction(`${names[currentPlayer]} bergerak ke ${steps[idx]}`);
        idx++;
        setTimeout(step, delay);
      }
      step();
    }

    function popToken(index) {
      const el = players[index];
      if (!el) return;
      el.classList.add('pop');
      setTimeout(()=> el.classList.remove('pop'), 260);
    }

    function getDiceImage(val) {
      const map = {
        1: '2/2c/Alea_1.png',
        2: 'b/b8/Alea_2.png',
        3: '2/2f/Alea_3.png',
        4: '8/8d/Alea_4.png',
        5: '5/55/Alea_5.png',
        6: 'f/f4/Alea_6.png'
      };
      return map[val];
    }

    function updatePositions() {
      for (let i = 0; i < players.length; i++) {
        const { x, y, cellW, cellH } = getPositionCoords(positions[i]);
        const offset = Math.min(cellW, cellH) * 0.18;
        const angle = (i / players.length) * Math.PI * 2;
        const dx = Math.round(Math.cos(angle) * offset);
        const dy = Math.round(Math.sin(angle) * offset);
        players[i].style.left = `${x + dx}px`;
        players[i].style.top = `${y + dy}px`;
      }
      updatePenaltyMarkers();
    }

    // ===== logging =====
    function logAction(text) {
      const p = document.createElement('p');
      p.textContent = text;
      logEl.prepend(p);
      saveLog(text);
    }

    function saveLog(entry) {
      const existing = JSON.parse(localStorage.getItem('gameLog') || '[]');
      existing.unshift(entry);
      localStorage.setItem('gameLog', JSON.stringify(existing.slice(0, 50)));
    }

    function loadLog() {
      const existing = JSON.parse(localStorage.getItem('gameLog') || '[]');
      logEl.innerHTML = '';
      existing.forEach(entry => {
        const p = document.createElement('p');
        p.textContent = entry;
        logEl.appendChild(p);
      });
    }

    // ===== bindings & init =====
    startBtn.addEventListener('click', openSetupModal);
    rollBtn.addEventListener('click', rollDice);
    resetBtn.addEventListener('click', resetGame);

    window.addEventListener('resize', () => { if (gameStarted) updatePositions(); });
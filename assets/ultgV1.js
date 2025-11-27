    // ===== state =====
    let players = [];
    const colors = ['#ef4444','#2563eb','#16a34a','#f97316','#7c3aed','#0f172a'];
    let currentPlayer = 0;
    let positions = [];
    let names = [];
    let gameStarted = false;
    let animating = false;
    let penalties = [];

    // ladders & snakes (original)
    const ladders = {4:26,8:51,28:46,39:60,52:68,44:80,64:85,69:93,71:92,84:98};
    const snakes = {11:9,36:14,57:19,43:22,66:47,94:48,90:49,81:63,96:65, 99:78};

    // DOM
    const playerCountEl = document.getElementById('playerCount');
    const playerNamesWrap = document.getElementById('playerNames');
    const startBtn = document.getElementById('startBtn');
    const rollBtn = document.getElementById('rollBtn');
    const resetBtn = document.getElementById('resetBtn');
    const openPenaltyBtn = document.getElementById('openPenaltyBtn');
    const turnInfo = document.getElementById('turnInfo');
    const diceResult = document.getElementById('diceResult');
    const diceImage = document.getElementById('diceImage');
    const boardEl = document.getElementById('board');
    const logEl = document.getElementById('log');

    // penalty modal
    const penModal = document.getElementById('penModal');
    const penList = document.getElementById('penList');
    const addPenBtn = document.getElementById('addPenBtn');
    const savePenBtn = document.getElementById('savePenBtn');
    const cancelPenBtn = document.getElementById('cancelPenBtn');

    // wheel modal
    const wheelModal = document.getElementById('wheelModal');
    const wheel = document.getElementById('wheel');
    const wheelCanvas = document.getElementById('wheelCanvas');
    const spinBtn = document.getElementById('spinBtn');
    const closeWheel = document.getElementById('closeWheel');
    const wheelInfo = document.getElementById('wheelInfo');

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

    function generateNameInputs() {
      const count = Math.max(2, Math.min(6, parseInt(playerCountEl.value) || 2));
      playerNamesWrap.innerHTML = '';
      for (let i = 0; i < count; i++) {
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = `Nama Pemain ${i + 1}`;
        input.className = 'name-input';
        input.maxLength = 12;
        playerNamesWrap.appendChild(input);
      }
    }

    // ===== start / reset =====
    function startGame() {
      const count = Math.max(2, Math.min(6, parseInt(playerCountEl.value) || 2));
      const nameInputs = playerNamesWrap.querySelectorAll('input');
      if (nameInputs.length < 2) return alert('Minimal 2 pemain');

      // collect names
      names = [];
      nameInputs.forEach((input, i) => names.push((input.value.trim()) || `P${i+1}`));

      positions = new Array(count).fill(1);
      players = [];
      boardEl.innerHTML = '';
      logEl.innerHTML = '';

      // load penalties from storage if none set
      loadPenaltiesFromStorage();
      if (penalties.length === 0) {
        alert('Silakan atur hukuman terlebih dahulu (klik Atur Hukuman).');
        return;
      }

      for (let i = 0; i < count; i++) {
        const div = document.createElement('div');
        div.className = 'player';
        div.style.background = colors[i % colors.length];
        div.textContent = names[i][0]?.toUpperCase() || (i+1);
        div.title = names[i];
        boardEl.appendChild(div);
        players.push(div);
      }

      updatePositions();
      currentPlayer = 0;
      document.getElementById('turnInfo').textContent = `Giliran: ${names[currentPlayer]}`;
      document.getElementById('rollBtn').disabled = false;
      gameStarted = true;
      animating = false;
      startBtn.disabled = true; // disable start while running
      saveLog('Game dimulai: ' + names.join(', '));
      drawWheel(); // prepare wheel (with all names)
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
      document.getElementById('turnInfo').textContent = '';
      document.getElementById('diceResult').textContent = '';
      document.getElementById('diceImage').innerHTML = '';
      rollBtn.disabled = true;
      startBtn.disabled = false;
      generateNameInputs();
      saveLog('Game direset');
    }

    // ===== dice & movement (original logic preserved) =====
    function rollDice() {
      if (!gameStarted || players.length === 0 || animating) return;
      animating = true;
      diceResult.textContent = 'Mengocok...';
      diceImage.innerHTML = '<img src="https://upload.wikimedia.org/wikipedia/commons/2/2c/Alea_1.png" width="54" alt="dice">';
      rollBtn.disabled = true;

      setTimeout(() => {
        const dice = Math.floor(Math.random() * 6) + 1;
        diceResult.textContent = `${names[currentPlayer]} mendapatkan ${dice}`;
        diceImage.innerHTML = `<img src="https://upload.wikimedia.org/wikipedia/commons/${getDiceImage(dice)}" width="54" alt="dice">`;

        // steps with bounce-back near 100
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

          if (positions[currentPlayer] === 100) {
            setTimeout(() => {
              alert(`${names[currentPlayer]} menang!`);
              document.getElementById('turnInfo').textContent = `${names[currentPlayer]} MENANG!`;
              rollBtn.disabled = true;
              gameStarted = false;
              animating = false;
              startBtn.disabled = false;
              // open wheel modal to pick loser among others
              const candidates = names.filter((_, idx) => idx !== currentPlayer);
              if (candidates.length) openWheelModal(candidates);
            }, 250);
            return;
          }

          if (dice !== 6) {
            currentPlayer = (currentPlayer + 1) % players.length;
          } else {
            logAction(`${names[currentPlayer]} dapat 6 dan mendapat giliran lagi!`);
          }

          document.getElementById('turnInfo').textContent = `Giliran: ${names[currentPlayer]}`;
          document.getElementById('rollBtn').disabled = false;
          animating = false;
        });

      }, 350);
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

    // ===== penalties modal logic (Model A) =====
    function openPenaltyModal() {
      penModal.style.display = 'flex';
      renderPenList();
    }
    function closePenaltyModal() {
      penModal.style.display = 'none';
    }

    function renderPenList() {
      penList.innerHTML = '';
      if (!penalties.length) {
        const empty = document.createElement('div');
        empty.style.color = '#475569';
        empty.style.fontWeight = '600';
        empty.textContent = 'Belum ada hukuman. Tambahkan hukuman baru.';
        penList.appendChild(empty);
        return;
      }
      penalties.forEach((p, idx) => {
        const row = document.createElement('div');
        row.className = 'pen-row';
        const input = document.createElement('input');
        input.value = p;
        input.addEventListener('input', (e) => penalties[idx] = e.target.value);
        const del = document.createElement('button');
        del.className = 'icon-btn';
        del.textContent = '✖';
        del.title = 'Hapus';
        del.addEventListener('click', () => {
          penalties.splice(idx, 1);
          renderPenList();
        });
        row.appendChild(input);
        row.appendChild(del);
        penList.appendChild(row);
      });
    }

    function addPenaltyRow() {
      penalties.push('Hukuman baru');
      renderPenList();
    }

    function savePenalties() {
      // remove empty entries
      penalties = penalties.map(p => (p||'').trim()).filter(p => p);
      if (penalties.length === 0) { alert('Tambahkan minimal 1 hukuman'); return; }
      localStorage.setItem('penalties', JSON.stringify(penalties));
      closePenaltyModal();
      alert('Hukuman disimpan');
    }

    function loadPenaltiesFromStorage() {
      const p = JSON.parse(localStorage.getItem('penalties') || '[]');
      if (Array.isArray(p) && p.length) penalties = p;
    }

    addPenBtn.addEventListener('click', addPenaltyRow);
    savePenBtn.addEventListener('click', savePenalties);
    cancelPenBtn.addEventListener('click', () => { closePenaltyModal(); loadPenaltiesFromStorage(); });

    // close modal when clicking backdrop
    penModal.addEventListener('click', (e) => { if (e.target === penModal) closePenaltyModal(); });

    // ===== wheel drawing & spin (Model A: Wheel) =====
    function drawWheel(namesToUse) {
      // default to all players if not provided
      const namesArr = namesToUse || names;
      const ctx = wheelCanvas.getContext('2d');
      const dpr = window.devicePixelRatio || 1;
      const size = wheel.clientWidth;
      wheelCanvas.width = size * dpr;
      wheelCanvas.height = size * dpr;
      wheelCanvas.style.width = size + 'px';
      wheelCanvas.style.height = size + 'px';
      ctx.scale(dpr, dpr);

      const n = Math.max(1, namesArr.length);
      const cx = size / 2;
      const cy = size / 2;
      const r = size / 2 - 2;
      const seg = 360 / n;

      ctx.clearRect(0, 0, size, size);

      for (let i = 0; i < n; i++) {
        const start = (i * seg) * Math.PI / 180;
        const end = ((i + 1) * seg) * Math.PI / 180;
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.arc(cx, cy, r, start, end);
        ctx.closePath();
        ctx.fillStyle = i % 2 === 0 ? '#fff' : '#f3f4f6';
        ctx.fill();
        ctx.strokeStyle = '#e6eef8';
        ctx.stroke();

        ctx.save();
        ctx.translate(cx, cy);
        // rotate to middle of segment
        const mid = (start + end) / 2;
        ctx.rotate(mid);
        ctx.textAlign = 'right';
        ctx.fillStyle = '#0f172a';
        // font size responsive
        ctx.font = (Math.max(12, Math.min(16, size/28))) + 'px Arial';
        // draw name with ellipsis if long
        let text = namesArr[i];
        if (text.length > 18) text = text.slice(0, 15) + '...';
        ctx.fillText(text, r - 10, 6);
        ctx.restore();
      }
    }

    function openWheelModal(candidates) {
      if (!Array.isArray(candidates) || candidates.length === 0) return;
      wheelModal.style.display = 'flex';
      drawWheel(candidates);
      wheel.dataset.names = JSON.stringify(candidates);
      wheel.style.transform = 'rotate(0deg)';
      wheelInfo.textContent = `Kandidat: ${candidates.join(', ')}`;
    }

    function closeWheelModal() {
      wheelModal.style.display = 'none';
    }

    let spinning = false;
    spinBtn.addEventListener('click', () => {
      if (spinning) return;
      spinning = true;
      spinBtn.textContent = '...';
      const namesArr = JSON.parse(wheel.dataset.names || '[]');
      if (!namesArr.length) {
        alert('Tidak ada kandidat untuk dipilih');
        spinning = false;
        spinBtn.textContent = 'SPIN';
        return;
      }
      const seg = 360 / namesArr.length;
      // choose random target index
      const targetIndex = Math.floor(Math.random() * namesArr.length);
      const full = 6 + Math.floor(Math.random() * 4); // full rotations
      const segmentCenter = (targetIndex + 0.5) * seg;
      // small jitter so it doesn't land perfectly center every time
      const jitter = (Math.random() * (seg - 8)) - (seg / 2 - 4);
      const finalDeg = full * 360 + segmentCenter + jitter;

      wheel.style.transition = 'transform 4s cubic-bezier(.12,.84,.2,1)';
      wheel.style.transform = `rotate(${finalDeg}deg)`;

      function onEnd() {
        wheel.removeEventListener('transitionend', onEnd);
        // determine chosen index logically using finalDeg
        const normalized = finalDeg % 360;
        const angleFromTop = (normalized + 360) % 360;
        const idx = Math.floor(angleFromTop / seg) % namesArr.length;
        // because of draw orientation, compute chosen
        const chosen = namesArr[(namesArr.length - 1 - idx + namesArr.length) % namesArr.length];

        const penalty = penalties.length ? penalties[Math.floor(Math.random() * penalties.length)] : '(tidak ada hukuman)';
        wheelInfo.innerHTML = `<strong>${chosen}</strong> dipilih — Hukuman: <em>${penalty}</em>`;
        alert(`${chosen} mendapatkan hukuman: ${penalty}`);
        spinning = false;
        spinBtn.textContent = 'SPIN';
        // close wheel after selection (optional) - keep open so user can see result
      }

      wheel.addEventListener('transitionend', onEnd);
    });

    closeWheel.addEventListener('click', closeWheelModal);
    wheelModal.addEventListener('click', (e) => { if (e.target === wheelModal) closeWheelModal(); });

    // ===== apply penalty directly (compatibility, unused when using wheel) =====
    function applyPenalty() {
      const losers = names.filter((_, index) => index !== currentPlayer);
      if (!losers.length || penalties.length === 0) return;
      // open wheel to pick among losers
      openWheelModal(losers);
    }

    // ===== bindings & init =====
    playerCountEl.addEventListener('change', generateNameInputs);
    startBtn.addEventListener('click', startGame);
    rollBtn.addEventListener('click', rollDice);
    resetBtn.addEventListener('click', resetGame);
    openPenaltyBtn.addEventListener('click', openPenaltyModal);

    window.addEventListener('resize', () => { if (gameStarted) updatePositions(); drawWheel(); });
    window.addEventListener('load', () => {
      generateNameInputs();
      loadPenaltiesFromStorage();
      loadLog();
      // draw empty wheel
      drawWheel([]);
    });

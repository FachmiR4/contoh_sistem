<style>
    .barcode-entry {
        position: relative;
        padding-top: 20px;
    }
    .barcode-entry .btn-close {
        position: absolute;
        right: 10px;
        top: 6px;
        z-index: 2;
    }
    .item-group {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 18px;
        background: #f8f9fa;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .item-group .remove-barang-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        border: none;
        background: transparent;
        font-size: 1.3rem;
        color: #dc3545;
        cursor: pointer;
        z-index: 2;
    }
    .barcode-entry {
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-top: 8px;
    }
    .komponen-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #ced4da;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="card">
  <div class="card-body p-4">
    <h5 class="mb-4"><i class="bi bi-box-seam"></i> Input Item BAPB</h5>
    <form action="{{ route('bapbbarang.store') }}" method="POST">
      @csrf
      {{-- <input type="hidden" name="id_bapb" value="{{ $id }}"> --}}
      <input type="hidden" name="json_data" id="jsonData">
      <div id="form-barang-container"></div>
      <button type="button" class="btn btn-primary mb-3" onclick="addBarang()">
        <i class="bi bi-plus-lg"></i> Tambah Item
      </button>
      <hr>
      <button type="submit" class="btn btn-success" id="btnSimpan" style="display: none;">
        <i class="bi bi-save"></i> Simpan
      </button>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  let barangIndex = 0;
  let lastBarcode = {{ $lastBarcode ?? 2000 }};

  function addBarang() {
    const container = document.getElementById('form-barang-container');
    const html = `
      <div class="item-group" data-index="${barangIndex}">
        <button type="button" class="remove-barang-btn" onclick="this.parentElement.remove(); updateJson();">&times;</button>
        <div class="mb-3">
          <label class="form-label">Spesifik Barang</label>
          <input type="text" class="form-control" name="barang[${barangIndex}][keterangan]" required>
        </div>
        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">Pilih Barang</label>
            <select class="form-select select-barang" name="barang[${barangIndex}][id_barang]" required>
              <option selected disabled>Pilih Barang</option>
              
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" name="barang[${barangIndex}][qty]" value="1" min="1" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Total Price</label>
            <input type="number" class="form-control" name="barang[${barangIndex}][price]" min="1" required>
          </div>
          <div class="col-md-3">
            <label class="form-label d-block">&nbsp;</label>
            <button type="button" class="btn btn-secondary w-100" onclick="generateBarcode(this, ${barangIndex})" data-barang-idx="${barangIndex}">
              <i class="bi bi-upc-scan"></i> Barcode
            </button>
          </div>
        </div>
        <div class="form-check mt-3">
          <input type="checkbox" class="form-check-input" id="isComposite${barangIndex}" name="barang[${barangIndex}][is_composite]" onchange="toggleComposite(this)">
          <label class="form-check-label" for="isComposite${barangIndex}">
            Item Pecahan? (memiliki komponen yang akan dibarcode)
          </label>
        </div>
        <div class="komponen-container mt-3" style="display: none;"></div>
        <div class="barcodeContainer-parent mt-3"></div>
          <div class="barcodeContainer-komponen mt-3"></div>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    // Aktifkan select2 pada select barang baru
    setTimeout(() => {
      $('.select-barang').last().select2({ dropdownParent: $(container).parent() });
    }, 0);
    barangIndex++;
    updateJson();
  }

  function toggleComposite(checkbox) {
    const group = checkbox.closest('.item-group');
    const komponenDiv = group.querySelector('.komponen-container');
    const barcodeBtn = group.querySelector('button[data-barang-idx]');
    const barcodeDivParent = group.querySelector('.barcodeContainer-parent');
    const barcodeDivKomponen = group.querySelector('.barcodeContainer-komponen');

    if (checkbox.checked) {
      // Barang pecah (komponen)
      komponenDiv.style.display = 'block';
      komponenDiv.innerHTML = `
        <div class="komponen-actions">
          <button type="button" class="btn btn-outline-info btn-sm" onclick="addKomponen(this)">
            <i class="bi bi-plus-circle"></i> Tambah Komponen
          </button>
          <button type="button" class="btn btn-outline-success btn-sm" onclick="generateBarcodeKomponen(this)">
            <i class="bi bi-upc-scan"></i> Generate Barcode
          </button>
        </div>
        <div class="komponen-list"></div>
      `;

      // Sembunyikan tombol barcode parent
      if (barcodeBtn) barcodeBtn.style.display = 'none';

      // Hapus barcode parent (jika ada)
      if (barcodeDivParent) barcodeDivParent.innerHTML = '';
    } else {
      // Barang biasa (bukan pecah)
      komponenDiv.style.display = 'none';
      komponenDiv.innerHTML = '';

      if (barcodeBtn) barcodeBtn.style.display = 'block';

      if (barcodeDivKomponen) barcodeDivKomponen.innerHTML = '';
      if (barcodeDivParent) barcodeDivParent.innerHTML = '';
    }

    updateJson();
  }



  function addKomponen(button) {
    const komponenList = button.closest('.komponen-container').querySelector('.komponen-list');
    const el = document.createElement('div');
    el.className = 'border rounded p-2 mb-2';
    el.innerHTML = `
    <div class="position-relative">
      <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-1" 
        style="z-index:2;" 
        onclick="this.closest('div.border').remove(); updateJson();">
        <i class="bi bi-x"></i>
      </button>
      <div class="row g-2 align-items-center">
        <div class="col-md-4">
          <label class="form-label">Nama Komponen</label>
          <input type="text" class="form-control" name="komponen_nama[]" placeholder="Nama Komponen" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Pilih Barang</label>
          <select class="form-select select-komponen" name="komponen_id_barang[]" required>
            <option selected disabled>Pilih Barang</option>
           
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Qty</label>
          <input type="number" class="form-control" name="komponen_qty[]" min="1" value="1" required>
        </div>
        <div class="col-md-2">
          <label class="form-label">Harga Satuan</label>
          <input type="number" class="form-control" name="komponen_harga[]" placeholder="Harga Satuan" required>
        </div>
      </div>
    </div>
      `;
    komponenList.appendChild(el);
    // Aktifkan select2 pada select komponen baru
    setTimeout(() => {
      $(el).find('.select-komponen').select2({ dropdownParent: $(komponenList).parent() });
    }, 0);
    updateJson();
  }

  // Barcode untuk barang biasa
  function generateBarcode(button, index) {
    const group = button.closest('.item-group');
    const qty = parseInt(group.querySelector(`[name="barang[${index}][qty]"]`).value);
    const container = group.querySelector('.barcodeContainer-parent');
    container.innerHTML = '';
    if (isNaN(qty) || qty <= 0) {
      alert("Jumlah tidak valid");
      return;
    }

    for (let i = 1; i <= qty; i++) {
      lastBarcode++;
      const el = document.createElement('div');
      el.className = 'barcode-entry position-relative';
      el.innerHTML = `
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove(); updateJson();" aria-label="Close"></button>
        <label class="form-label">Barcode ${i}</label>
        <input type="text" class="form-control mb-2" name="barang[${index}][barcodes][]" value="${lastBarcode}" readonly>
        <label class="form-label">Keterangan</label>
        <textarea class="form-control" name="barang[${index}][keterangan_barcode][]"></textarea>
      `;
      container.appendChild(el);
    }

    updateJson();
  }


  // Barcode untuk barang pecah (komponen)
  function generateBarcodeKomponen(button) {
    const group = button.closest('.item-group');
    const komponenList = group.querySelectorAll('.komponen-list .border');
    const container = group.querySelector('.barcodeContainer-komponen');
    container.innerHTML = '';

    let totalKomponenQty = 0;
    komponenList.forEach(row => {
      const qty = parseInt(row.querySelector('[name="komponen_qty[]"]').value) || 0;
      totalKomponenQty += qty;
    });

    if (totalKomponenQty <= 0) {
      alert("Total qty komponen harus lebih dari 0");
      return;
    }

    let barcodeNum = 1;
    komponenList.forEach(row => {
      const nama = row.querySelector('[name="komponen_nama[]"]').value || '';
      const qty = parseInt(row.querySelector('[name="komponen_qty[]"]').value) || 0;

      for (let i = 1; i <= qty; i++) {
        lastBarcode++;
        const el = document.createElement('div');
        el.className = 'barcode-entry position-relative';
        el.innerHTML = `
          <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove(); updateJson();" aria-label="Close"></button>
          <label class="form-label">Barcode Komponen ${barcodeNum++} (${nama})</label>
          <input type="text" class="form-control mb-2" name="komponen_barcodes[]" value="${lastBarcode}" readonly>
          <label class="form-label">Keterangan</label>
          <textarea class="form-control" name="komponen_keterangan_barcode[]"></textarea>
        `;
        container.appendChild(el);
      }
    });

    updateJson();
  }


  function updateJson() {
    const groups = document.querySelectorAll('.item-group');
    const result = [];

    let adaData = false;

    groups.forEach((group, i) => {
      const id_barang = group.querySelector(`[name="barang[${i}][id_barang]"]`)?.value || null;
      const qty = group.querySelector(`[name="barang[${i}][qty]"]`)?.value || 0;
      const keterangan = group.querySelector(`[name="barang[${i}][keterangan]"]`)?.value || '';
      const isComposite = group.querySelector(`[name="barang[${i}][is_composite]"]`)?.checked || false;

      const barcodeInputs = group.querySelectorAll(`[name="barang[${i}][barcodes][]"]`);
      const noteInputs = group.querySelectorAll(`[name="barang[${i}][keterangan_barcode][]"]`);
      const barcodes = [];

      barcodeInputs.forEach((input, idx) => {
        barcodes.push({
          barcode: input.value,
          keterangan: noteInputs[idx]?.value || ''
        });
      });

      const komponenList = [];
      const komponenRows = group.querySelectorAll('.komponen-list .border');
      komponenRows.forEach(row => {
        komponenList.push({
          nama: row.querySelector('[name="komponen_nama[]"]').value,
          qty: row.querySelector('[name="komponen_qty[]"]').value,
          harga: row.querySelector('[name="komponen_harga[]"]').value
        });
      });

      const komponenBarcodeInputs = group.querySelectorAll('[name="komponen_barcodes[]"]');
      const komponenNoteInputs = group.querySelectorAll('[name="komponen_keterangan_barcode[]"]');
      const komponenBarcodes = [];

      komponenBarcodeInputs.forEach((input, idx) => {
        komponenBarcodes.push({
          barcode: input.value,
          keterangan: komponenNoteInputs[idx]?.value || ''
        });
      });

      // Deteksi apakah ada isian yang berarti
      if (id_barang || barcodes.length > 0 || komponenBarcodes.length > 0) {
        adaData = true;
      }

      result.push({
        id_barang: id_barang,
        qty: parseInt(qty),
        keterangan_barang: keterangan,
        is_composite: isComposite,
        barcodes: isComposite ? [] : barcodes,
        komponen: isComposite ? komponenList : [],
        komponen_barcodes: isComposite ? komponenBarcodes : []
      });
    });

    // Masukkan JSON ke input hidden
    document.getElementById('jsonData').value = JSON.stringify(result);

    // Tampilkan atau sembunyikan tombol simpan
    const btnSimpan = document.getElementById('btnSimpan');
    if (adaData) {
      btnSimpan.style.display = 'inline-block';
    } else {
      btnSimpan.style.display = 'none';
    }
  }


  // Inisialisasi select2 pada select yang sudah ada (jika ada)
  $(document).ready(function() {
    $('.select-barang').select2();
    $('.select-komponen').select2();
  });
</script>
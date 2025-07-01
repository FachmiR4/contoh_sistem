@push('css')
<style>
    .btn-toggle-detail {
        min-width: 220px;
        font-size: 1rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding-top: 0.6rem;
        padding-bottom: 0.6rem;
        white-space: nowrap;
    }
    @media (max-width: 600px) {
        .btn-toggle-detail {
            width: 100%;
            min-width: unset;
            font-size: 1rem;
        }
        .d-flex.gap-2.mb-4.flex-wrap {
            flex-direction: column !important;
            gap: 10px !important;
        }
    }
</style>
@endpush
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4">Tambah Data Barang BAPB</h5>

        <div class="d-flex gap-2 mb-4 flex-wrap">
            <button type="button" class="btn btn-toggle-detail btn-outline-primary" id="btn-barcode">
                <i class="bi bi-upc-scan"></i> Tambah Detail Barang Barcode
            </button>
            <button type="button" class="btn btn-toggle-detail btn-outline-secondary" id="btn-non-barcode">
                <i class="bi bi-box"></i> Tambah Detail Barang Non-Barcode
            </button>
        </div>

        <div id="form-barcode" style="display:none;">
            <form action="{{ Route('bapbbarang.store') }}" method="POST" class="row g-3">
                @csrf
                <input type="hidden" class="form-control" name="id_barang_parent" value="{{ $id }}">
                <div class="col-md-12">
                    <label class="form-label">Detail Barang<span class="bintang" style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="keterangan_barang" placeholder="Spesifik Barang" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Barang<span class="bintang" style="color: red;">*</span></label>
                    <select class="form-select" id="single-select-field" name="barang" required>
                        <option selected disabled>Pilih Barang</option>
                        @foreach ($barang as $i)
                            <option value="{{ $i['id'] }}">{{ $i['nama_barang'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Quantity<span class="bintang" style="color: red;">*</span></label>
                    <input type="number" class="form-control" id="qty-barcode" name="quantity" min="1" max="100" placeholder="Jumlah" required>
                </div>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="button" class="btn btn-secondary px-4 text-white" onclick="generateBarcode()">
                            <i class="bi bi-upc-scan"></i> Generate Barcode
                        </button>
                    </div>
                </div>
                <div class="col-md-12" id="barcodeContainer"></div>
                <div class="col-md-12" id="submitContainer" style="display:none;">
                    <button type="submit" class="btn btn-success px-4 text-white">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

        <div id="form-non-barcode" style="display:none;">
            <form action="{{ Route('bapbbarang.store') }}" method="POST" class="row g-3">
                @csrf
                <input type="hidden" name="id_barang_parent" value="{{ $id }}">
                <div class="col-md-12">
                    <label class="form-label">Detail Barang<span class="bintang" style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="keterangan_barang" placeholder="Spesifik Barang" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Jenis Barang<span class="bintang" style="color: red;">*</span></label>
                    <select class="form-select" id="single-select-field-2" name="barang" required>
                        <option selected disabled>Pilih Barang</option>
                        @foreach ($barang as $i)
                            <option value="{{ $i['id'] }}">{{ $i['nama_barang'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Quantity<span class="bintang" style="color: red;">*</span></label>
                    <input type="number" class="form-control" name="quantity" min="1" placeholder="Jumlah" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan"></textarea>
                </div>
                <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="submit" class="btn btn-success px-4 text-white">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let lastBarcode = {{ $lastBarcode ?? 0 }};

    // Toggle form
    document.getElementById('btn-barcode').addEventListener('click', function() {
        document.getElementById('form-barcode').style.display = 'block';
        document.getElementById('form-non-barcode').style.display = 'none';
        this.classList.add('btn-primary');
        this.classList.remove('btn-outline-primary');
        document.getElementById('btn-non-barcode').classList.remove('btn-secondary');
        document.getElementById('btn-non-barcode').classList.add('btn-outline-secondary');
    });
    document.getElementById('btn-non-barcode').addEventListener('click', function() {
        document.getElementById('form-barcode').style.display = 'none';
        document.getElementById('form-non-barcode').style.display = 'block';
        this.classList.add('btn-secondary');
        this.classList.remove('btn-outline-secondary');
        document.getElementById('btn-barcode').classList.remove('btn-primary');
        document.getElementById('btn-barcode').classList.add('btn-outline-primary');
    });

    // Default: tampilkan form barcode
    document.getElementById('btn-barcode').click();

    function generateBarcode() {
        const qty = parseInt(document.getElementById('qty-barcode').value);
        const container = document.getElementById('barcodeContainer');
        const submitContainer = document.getElementById('submitContainer');

        container.innerHTML = ''; // Reset container

        if (isNaN(qty) || qty <= 0) {
            alert("Masukkan quantity yang valid!");
            submitContainer.style.display = 'none';
            return;
        }

        for (let i = 1; i <= qty; i++) {
            lastBarcode++;

            const div = document.createElement('div');
            div.className = 'mb-3 p-3 border rounded';

            // Label untuk barcode
            const label = document.createElement('label');
            label.className = 'form-label';
            label.textContent = 'Barcode ' + i;

            // Input barcode
            const barcodeInput = document.createElement('input');
            barcodeInput.type = 'text';
            barcodeInput.name = 'no_barcode[]';
            barcodeInput.className = 'form-control mb-2';
            barcodeInput.value = lastBarcode;

            // Label untuk catatan
            const noteLabel = document.createElement('label');
            noteLabel.className = 'form-label';
            noteLabel.textContent = 'Keterangan';

            // Textarea catatan
            const noteTextarea = document.createElement('textarea');
            noteTextarea.name = 'keterangan[]';
            noteTextarea.className = 'form-control';
            noteTextarea.placeholder = 'Keterangan';

            // Gabungkan ke dalam satu div
            div.appendChild(label);
            div.appendChild(barcodeInput);
            div.appendChild(noteLabel);
            div.appendChild(noteTextarea);

            container.appendChild(div);
        }

        submitContainer.style.display = 'block';
    }
</script>
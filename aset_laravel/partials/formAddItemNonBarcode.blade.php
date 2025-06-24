<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        background: #fff;
        font-size: 1rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #495057;
        line-height: 24px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
        right: 10px;
    }
</style>

<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4"><i class="bi bi-box-seam"></i> Tambah Data Barang Non Barcode</h5>
        <form action="{{ Route('bapbbarang.store') }}" method="POST" class="row g-3">
            @csrf
            <input type="hidden" name="id_bapb" value="{{ $id }}">

            <div class="col-md-12">
                <label class="form-label">Spesifik Barang<span class="bintang" style="color: red;">*</span></label>
                <input type="text" class="form-control" name="keterangan_barang" placeholder="Spesifik Barang" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Barang<span class="bintang" style="color: red;">*</span></label>
                <select class="form-select select-barang-nonBarcode"  name="barang" required style="width: 100%;">
                    <option selected disabled>Pilih Barang</option>
                    @foreach ($barang as $i)
                        <option value="{{ $i['id'] }}">{{ $i['nama_barang'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Quantity<span class="bintang" style="color: red;">*</span></label>
                <input type="number" class="form-control" id="qty" name="quantity" min="1" placeholder="Jumlah" required>
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
<script>
    $(document).ready(function() {
        $('.select-barang-nonBarcode').select2({
            
        });
    });
</script>
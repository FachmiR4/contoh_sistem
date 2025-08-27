{{-- filepath: c:\Users\fachmi\Documents\Project\my-app\resources\views\pages\pencatatan\createDataAset2.blade.php --}}
@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <link href="{{ asset('layouts/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3">Pencatatan</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ Route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ Route('pencatatan.index') }}">Data Pencatatan Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Aset</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content-main')
<div class="card-body p-4">
    <h5 class="mb-4">Tambah Aset</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="bapb_id" class="form-label">Pilih BAPB</label>
            <select id="bapb_id" name="bapb_id" class="form-control">
                <option value="">-- Pilih BAPB --</option>
                @foreach($bapbs as $bapb)
                    <option value="{{ $bapb['id'] }}">{{ $bapb['no_bapb'] }} - {{ $bapb['keterangan'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <div id="barang-barcode-group">
                <label for="barang_id" class="form-label">Pilih Barang (Barcode)</label>
                <select id="barang_id" class="form-control" disabled>
                    <option value="">-- Pilih Barang --</option>
                </select>
            </div>
        </div>
    </div>
    <form id="productForm" action="{{ route('pencatatan.store') }}" method="POST" enctype="multipart/form-data" class="row g-3" style="display:none;">
        @csrf
        <input type="hidden" id="editMode" value="">
        <div class="col-md-3">
            <label class="form-label">No Aset</label>
            <input type="text" class="form-control" id="noAset" name="noAset" placeholder="No Aset" maxlength="11" readonly>
        </div>
        <div class="col-md-9">
            <label class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nmBarang" name="nama" placeholder="Nama Barang">
        </div>
        <div class="col-md-4">
            <label class="form-label">No PP/PU/PUR</label>
            <input type="text" class="form-control" id="noPP" name="noPP" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">No OP</label>
            <input type="text" class="form-control" id="noOP" name="noOP" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">No BAPB</label>
            <input type="text" class="form-control" id="noBAPB" name="noBAPB" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal PP</label>
            <input type="date" class="form-control" id="tglPP" name="tglPP" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal OP</label>
            <input type="date" class="form-control" id="tglOP" name="tglOP" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal BAPB</label>
            <input type="date" class="form-control" id="tglBAPB" name="tglBAPB" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label">Harga OP</label>
            <input type="number" class="form-control" id="hrgOP" name="hrgOP">
        </div>
        <div class="col-md-6">
            <label class="form-label">Pengguna</label>
            <select name="pggn" class="form-select" id="single-select-field" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Pengguna</option>
                @foreach ($dataEmployees as $karyawan)
                    <option value="{{ $karyawan['id'] }}">{{ $karyawan['nama']."| Nik: ".$karyawan['nik']."| Jabatan: ". $karyawan['jabatan'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Detail Pengguna</label>
            <input type="text" class="form-control" id="dtlPengguna" name="dtlPengguna">
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Aset</label>
            <select name="jnsAset" class="form-select" id="single-select-field-2" data-placeholder="Choose one thing">
                @foreach ($dataProducts as $barang)
                    <option value="{{ $barang['id'] }}">{{ $barang['nama_barang'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Devisi</label>
            <select name="dvs" class="form-select" id="single-select-field-3" data-placeholder="Choose one thing">
                @foreach ($dataDivisions as $devisi)
                    @if (!is_null($devisi['deskripsi']))
                        <option value="{{ $devisi['id'] }}">{{ $devisi['deskripsi'] }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Ruangan</label>
            <select name="rng" class="form-select" id="single-select-field-4" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Ruangan</option>
                @foreach ($dataRooms as $ruang)
                    <option value="{{ $ruang['id'] }}">{{ $ruang['deskripsi'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Satuan</label>
            <select name="stn" class="form-select" id="single-select-field-5" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Satuan</option>
                @foreach ($dataUnits as $satuan)
                    <option value="{{ $satuan['id'] }}">{{ $satuan['deskripsi'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Lokasi</label>
            <select name="lks" class="form-select" id="single-select-field-6" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Lokasi</option>
                @foreach ($dataLocations as $lokasi)
                    <option value="{{ $lokasi['kode'] }}">{{ $lokasi['keterangan'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" id="qty" name="qty" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="sts" class="form-select" id="single-select-field-7" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Status</option>
                @foreach ($dataConditions as $kondisi)
                    <option value="{{ $kondisi['id'] }}">{{ $kondisi['kondisi'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Kondisi</label>
            <select name="kds" class="form-select">
                <option selected disabled>Pilih Kondisi</option>
                <option value="AKTIF">Aktif</option>
                <option value="NON AKTIF">Non Aktif</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Aset</label>
            <input type="date" class="form-control" id="tglAset" name="tglAset">
        </div>
        <div class="col-md-12">
            <label class="form-label">Catatan</label>
            <textarea class="form-control" id="cttn" name="cttn" rows="3"></textarea>
        </div>
        <div class="col-md-12">
            <label class="form-label">Upload File</label>
            <div class="card">
                <div class="card-body">
                    <input id="image-uploadify"  name="images[]" type="file" accept=".jpg, .png, image/jpeg, image/png,.pdf" multiple>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="d-md-flex d-grid align-items-center gap-3">
                <button type="submit" class="btn btn-success px-4 text-white">Simpan Data</button>
                <button type="reset" class="btn btn-info px-4 text-white" onclick="resetForm()">Reset</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('layouts/assets/plugins/select2/js/select2-custom.js') }}"></script>
<script src="{{ asset('layouts/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#image-uploadify').imageuploadify();
        $('#bapb_id').select2({ theme: 'bootstrap-5', width: '100%' });
        $('#barang_id').select2({ theme: 'bootstrap-5', width: '100%' });

        const barangPerBapb = @json($barangPerBapb ?? []);
        const urlBarang = "{{ route('pencatatan.getBarang', ':id') }}";

        $('#bapb_id').on('change', function () {
            const bapbId = this.value;
            const $barangSelect = $('#barang_id');
            const barangGroup = document.getElementById('barang-barcode-group');
            const formAset = document.getElementById('productForm');
            $barangSelect.empty().append('<option value="">-- Pilih Barang --</option>');
            $barangSelect.prop('disabled', true).val('').trigger('change');
            barangGroup.style.display = 'none';
            formAset.style.display = 'none';

            if (
                bapbId &&
                barangPerBapb[bapbId] &&
                Array.isArray(barangPerBapb[bapbId]) &&
                barangPerBapb[bapbId].length > 0
            ) {
                barangPerBapb[bapbId].forEach(function(barang) {
                    $barangSelect.append(
                        $('<option>', {
                            value: barang.id,
                            text: `${barang.nama_barang} - ${barang.barcode}`,
                            'data-barcode': barang.barcode
                        })
                    );
                });
                $barangSelect.prop('disabled', false).trigger('change');
                barangGroup.style.display = 'block';
            } else {
                $barangSelect.empty().append('<option value="">-- Tidak ada barang Yang Terdaftar --</option>');
                $barangSelect.prop('disabled', true).trigger('change');
                barangGroup.style.display = 'block';
                formAset.style.display = 'none';
            }
        });

        $('#barang_id').on('change', function () {
            const barangId = this.value;
            const formAset = document.getElementById('productForm');
            let finalUrl = urlBarang.replace(':id', barangId);
            if (barangId) {
                fetch(finalUrl)
                    .then(response => response.json())
                    .then(res => {
                        if (res && res.barang) {
                            const createdAt = res.bapb.created_at;
                            formAset.style.display = 'flex';
                            document.getElementById('nmBarang').value =
                                res.barang.keterangan && res.barang.keterangan.trim() !== ''
                                    ? `${res.barang.nama_barang} ${res.barang.keterangan}`
                                    : (res.barang.nama_barang ?? '');
                            document.getElementById('noAset').value = res.barang.barcode ?? '';
                            document.getElementById('noPP').value = res.bapb.no_pp ?? '';
                            document.getElementById('noOP').value = res.bapb.no_op ?? '';
                            document.getElementById('noBAPB').value = res.bapb?.no_bapb ?? '';
                            document.getElementById('tglPP').value = res.bapb.tgl_pp ?? '';
                            document.getElementById('tglOP').value = res.bapb.tgl_op ?? '';
                             document.getElementById('qty').value = res.barang.qty ?? '';
                            document.getElementById('tglBAPB').value = res.bapb.tgl_bapb ?? '';
                            $('[name="dvs"]').val(res.bapb.divisi_id ?? '').trigger('change');
                            $('[name="jnsAset"]').val(res.barang.id_barang ?? '').trigger('change');
                        } else {
                            formAset.style.display = 'none';
                        }
                    })
                    .catch(() => {
                        formAset.style.display = 'none';
                    });
            } else {
                formAset.style.display = 'none';
            }
        });

        // Submit form ke controller
        $('#productForm').on('submit', function (e) {
            return true;
        });
    });

    function resetForm() {
        $('#productForm')[0].reset();
        $('#barang-barcode-group').hide();
        $('#bapb_id').val('').trigger('change');
        $('#barang_id').val('').trigger('change');
    }
</script>
@endpush
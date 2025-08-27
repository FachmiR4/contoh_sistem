@extends('layouts.app')
@section('title')
    Aplikasi Aset & Kendaraan | Stock Opname Aset
@endsection

@push('css') 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('layouts/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <style>
        body { background: #f4f7fa; }
        .card { border-radius: 18px; box-shadow: 0 4px 24px rgba(30,64,175,0.09); }
        .data-aset th { text-align: left; font-size: 20px; padding-bottom: 10px; color: #2563eb; }
        .data-aset td { padding: 4px 8px; font-size: 1.05em; }
        .label { font-weight: bold; width: 200px; color: #374151; }
        .modal-header { background: #1e40af; color: #fff; }
        .modal-title { color: #fff; }
        .btn:focus { box-shadow: 0 0 0 0.2rem rgba(30,64,175,0.15); }
        .form-label { font-weight: 500; color: #1e293b; }
        .select2-container--bootstrap-5 .select2-selection { border-radius: 8px; }
        .table-bordered { border-radius: 12px; overflow: hidden; }
        .table-bordered th, .table-bordered td { vertical-align: middle; }
        .modal-content { border-radius: 16px; }
        .modal-body input, .modal-body select, .modal-body textarea { border-radius: 8px; }
        .modal-footer { border-top: none; }
        .page-breadcrumb { margin-bottom: 18px; }
        .btn i { margin-right: 4px; }
        .modal-detail {font-weight: bold;width: 150px;color: #374151;}
    </style>
@endpush

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3">Data Master</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ Route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ Route('pencatatan.index') }}">Data Pencatatan Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Stock Opname</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content-main')
    <h6 class="mb-0 text-uppercase">Stock Opname Aset</h6>
    <hr>
    <div class="row g-4">
        {{-- SECTION 1: Detail Aset --}}
        <div class="col-12 col-xl-6 d-flex">
            <div class="card rounded-4 w-100 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4 text-primary">Gambar Barang Aset</h5>
                    <div class="mb-3">
                        <div class="card-header">
                            @if (!empty($dataHistori->file_name))
                                <div id="carouselSingleImage" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/uploads/' . $dataHistori->file_name) }}"
                                                class="d-block mx-auto img-fluid rounded shadow carousel-img-detail"
                                                style="height: 360px; object-fit: cover; cursor: pointer;"
                                                alt="Gambar Aset"
                                                data-img="{{ asset('storage/uploads/' . $dataHistori->file_name) }}">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        {{-- SECTION 2: Riwayat Stock Opname --}}
        <div class="col-12 col-xl-6 d-flex">
           <div class="card rounded-4 w-100 shadow-sm">
                <div class="card-body p-4">
                    <table class="data-aset">
                        <tr><th colspan="2">Data Detail Aset</th></tr>
                        <tr><td class="label">No Aset</td><td>: {{ $dataAset['no_aset'] }}</td></tr>
                        <tr><td class="label">Nama Barang</td><td>: {{ $dataAset['keterangan_barang'] }}</td></tr>
                        <tr><td class="label">No PP/PU/PUR</td><td>: {{ $dataAset['no_pp'] }}</td></tr>
                        <tr><td class="label">Tanggal PP/PU/PUR</td><td>: {{ $dataAset['tgl_pp'] }}</td></tr>
                        <tr><td class="label">No OP</td><td>: {{ $dataAset['no_op'] }}</td></tr>
                        <tr><td class="label">Tanggal OP</td><td>: {{ $dataAset['tgl_op'] }}</td></tr>
                        <tr><td class="label">No BAPB</td><td>: {{ $dataAset['no_bapb'] }}</td></tr>
                        <tr><td class="label">Tanggal BAPB</td><td>: {{ $dataAset['tgl_bapb'] }}</td></tr>
                        <tr><td class="label">Quantity</td><td>: {{ $dataAset['qty'] }}</td></tr>
                        <tr><td class="label">Harga OP</td><td>: Rp. {{ number_format($dataAset['harga_op'], 0, ',', '.') }}</td></tr>
                        <tr>
                            <td class="label">Satuan</td>
                            <td>: {{ $dataUnit[0]['deskripsi'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal">
                                    <i class="bi bi-eye me-1"></i> More Detail
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
         {{-- SECTION 3:  --}}
        <div class="col-12 col-xl-6 d-flex">
           <div class="card rounded-4 w-100 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4 text-primary">Pengguna Saat ini</h5>
                    <table class="data-aset">
                        <tr>
                            <td class="label">Nama Pengguna</td>
                            <td>: {{ $dataEmployee[0]['nama'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Divisi</td>
                            <td>: {{ $dataDivision[0]['name'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kondisi Barang</td>
                            <td>: {{ $dataAset['conditions']['kondisi'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        {{-- SECTION 4:  --}}
        <div class="col-12 col-xl-6 d-flex">
           <div class="card rounded-4 w-100 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4 text-primary">Lokasi Saat ini</h5>
                    <table class="data-aset">
                        <tr>
                            <td class="label">Lokasi Utama</td>
                            <td>: {{ $dataLokasiUtama[0]['keterangan'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Sub Lokasi</td>
                            <td>: {{ $dataLocation[0]['keterangan'] ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Ruangan</td>
                            <td>: {{ $dataRoom[0]['deskripsi'] ?? '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col d-flex align-items-end justify-content-between">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahHistoryModal">
                <i class="bi bi-plus-lg me-2"></i> Monitoring Aset
            </button>
            <a href="{{ Route('pencatatan.index') }}" class="btn btn-danger px-4 text-white">
                <i class="bi bi-arrow-right"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-4 text-primary">Historical Data Aset</h5>
            {!! $dataTable->table(['class' => 'table table-bordered'], true) !!}
        </div>
    </div>

    {{-- Modal Preview Gambar --}}
    <div class="modal fade" id="gambarModal" tabindex="-1" aria-labelledby="gambarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gambarModalLabel">Gambar Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Gambar Aset Full" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah, Edit, Delete --}}
    @include('pages.pencatatan.history.partials.modals')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('layouts/assets/plugins/select2/js/select2-custom.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).ready(function () {
            $('#image-uploadify').imageuploadify();
            $('#image-uploadify2').imageuploadify();
            $('#single-select-field').select2({ theme: 'bootstrap-5', dropdownParent: $('#tambahHistoryModal'), width: '100%' });
            $('#single-select-field-2').select2({ theme: 'bootstrap-5', dropdownParent: $('#tambahHistoryModal'), width: '100%' });
            $('#single-select-field-3').select2({ theme: 'bootstrap-5', dropdownParent: $('#tambahHistoryModal'), width: '100%' });
            $('#single-select-field-4').select2({ theme: 'bootstrap-5', dropdownParent: $('#tambahHistoryModal'), width: '100%' });
            $('#single-select-field-5').select2({ theme: 'bootstrap-5', dropdownParent: $('#tambahHistoryModal'), width: '100%' });

            $('#single-select-field-6').select2({ theme: 'bootstrap-5', dropdownParent: $('#editModal'), width: '100%' });
            $('#single-select-field-7').select2({ theme: 'bootstrap-5', dropdownParent: $('#editModal'), width: '100%' });
            $('#single-select-field-8').select2({ theme: 'bootstrap-5', dropdownParent: $('#editModal'), width: '100%' });
            $('#single-select-field-9').select2({ theme: 'bootstrap-5', dropdownParent: $('#editModal'), width: '100%' });
            $('#single-select-field-10').select2({ theme: 'bootstrap-5', dropdownParent: $('#editModal'), width: '100%' });
        });
      
    </script>
    <script>
        const urlEditHistory = "{{ route('stockopname.edit', ':id') }}";
        const routeUpdateHistory = "{{ route('stockopname.update', ':id') }}";
        const routeDeleteHistory = "{{ route('stockopname.destroy', ':id') }}";
        const form = document.getElementById("formTambah");
        $(document).on('click', '#btn-edit-history', function(){
            let id = $(this).data('id');
            const form = document.getElementById('editHistoryForm');
            form.action = routeUpdateHistory.replace(':id', id);
            let finalUrl = urlEditHistory.replace(':id', id);
            $.ajax({
                type: "get",
                url: finalUrl, 
                dataType: 'json',
                success: function(res){
                    $('input[name="edit-dtlPengguna"]').val(res.dtl_pengguna);
                    $('select[name="edit-pggn"]').val(res.id_karyawan).trigger('change');
                    $('select[name="edit-dvs"]').val(res.id_divisi).trigger('change');
                    $('select[name="edit-rng"]').val(res.id_ruangan).trigger('change');
                    $('select[name="mainlks"]').val(res.id_lokasi_utama).trigger('change');
                    setTimeout(function() {
                        $('select[name="edit-lks"]').val(res.locations ? res.locations.id : '');
                    }, 500);
                     setTimeout(function() {
                        $('select[name="edit-rng"]').val(res.rooms ? res.rooms.id : '');
                    }, 500);
                    $('select[name="edit-sts"]').val(res.status).trigger('change');
                    $('input[name="edit-tgl_pengadaan"]').val(res.tgl_riwayat ?? '');
                    $('textarea[name="edit-deskripsi"]').val(res.keterangan ?? '');
                }
            });            
        });
        $(document).on('click', '#btn-delete-history', function () {
            const id = $(this).data('id');
            const form = document.getElementById('deleteHistoryForm');
            form.action =  routeDeleteHistory.replace(':id', id);
        });
        function resetForm() {
            form.reset();
        }
    </script>
@endpush
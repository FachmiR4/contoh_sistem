@extends('layouts.app')
@section('title')
    Aplikasi Aset & Kendaraan | Data master Perlengkapan
@endsection
@push('css') 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('layouts/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <style>
        table.dataTable td {
            white-space: nowrap; 
            vertical-align: middle;
        }

        @media only screen and (max-width: 768px) {
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                float: none;
                text-align: center;
            }
            table.dataTable td {
                white-space: normal !important;
                word-wrap: break-word;
            }
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.2em;
        }
        .radio-group-horizontal {
            display: flex;
            gap: 2rem;
            align-items: center;
            margin: 1rem 0;
        }
    
        .form-check-input {
            transform: scale(1.2);
            margin-top: 0.3rem;
        }
    
        .form-check-label {
            font-weight: 500;
            margin-left: 0.5rem;
        }
    </style>
@endpush
@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3">Master Data</div>
        <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="{{ Route('home') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item " aria-current="page"><a href="javascript:;">Data Master Perlengkapan</a></li>
            </ol>
        </nav>
        </div>
    </div>
@endsection
@section('content-main')
    <h6 class="mb-0 text-uppercase">Data Master Perlengkapan</h6>
    <hr>
    <div class="col-auto">
        <div class="d-flex align-items-end gap-3 justify-content-lg-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahEquipmentModal">
                <i class="bi bi-plus-lg me-2"></i>Add Data Master Perlengkapan
            </button>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered'], true) !!}
        </div>
    </div>
    {{-- tambah modal --}}
    <div class="modal fade" id="tambahEquipmentModal" tabindex="-1" aria-labelledby="tambahEquipmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
            <h5 class="modal-title" id="tambahEquipmentModalLabel">Tambahkan Data Master Perlengkapan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ Route("masterEquipment.store") }}" method="POST" id="formTambah">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Nama Perlengkapan<span class="bintang" style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="nama-perlengkapan" name="nama_perlengkapan" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Kategori<span class="bintang" style="color: red;">*</span></label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        <option value="" disabled selected>-- Pilih kategori --</option>
                        <option value="Mobil">Mobil</option>
                        <option value="Petugas">Petugas</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                </div>
                <div class="radio-group-horizontal">
                    <label for="">Status<span class="bintang" style="color: red;">*</span></label>
                    <div class="form-check form-check-success d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="status" value="1">
                        <label class="form-check-label" for="flexRadioSuccess">
                            Aktif
                        </label>
                    </div>
                    <div class="form-check form-check-danger d-flex align-items-center">
                        <input class="form-check-input" type="radio" name="status" value="0">
                        <label class="form-check-label" for="flexRadioDanger">
                            Non Aktif
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info text-white">Tambahkan</button>
                <button type="button" class="btn btn-danger px-4 text-white" onclick="resetForm()">Reset</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    {{-- edit modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary ">
            <h5 class="modal-title text-white" id="tambahEquipmentModalLabel">Edit Data Master Perlengkapan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEquipmentForm" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Perlengkapan<span class="bintang" style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="edit-nama-perlengkapan" name="nama_perlengkapan" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Kategori<span class="bintang" style="color: red;">*</span></label>
                        <select name="kategori" id="edit-kategori" class="form-select" required>
                            <option value="" disabled selected>-- Pilih kategori --</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Petugas">Petugas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="edit-deskripsi" class="form-control"></textarea>
                    </div>
                    <div class="radio-group-horizontal">
                        <label for="">Status<span class="bintang" style="color: red;">*</span></label>
                        <div class="form-check form-check-success d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="edit-status" value="1">
                            <label class="form-check-label" for="flexRadioSuccess">
                                Aktif
                            </label>
                        </div>
                        <div class="form-check form-check-danger d-flex align-items-center">
                            <input class="form-check-input" type="radio" name="edit-status" value="0">
                            <label class="form-check-label" for="flexRadioDanger">
                                Non Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info text-white">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    {{-- modal delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <div class="d-flex align-items-center gap-2">
                        <span class="material-icons-outlined fs-2">delete_forever</span>
                        <h5 class="modal-title fw-bold mb-0 text-white" id="deleteModalLabel">
                            Hapus Data Master Perlengkapan
                        </h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteEquipmentForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center py-4">
                        <div class="mb-3">
                            <span class="material-icons-outlined text-danger" style="font-size: 4rem;">warning</span>
                        </div>
                        <p class="fs-5 fw-semibold mb-2">
                            Apakah Anda yakin ingin <span class="text-danger">menghapus</span> data ini?
                        </p>
                        <p class="text-muted fs-6 mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            Tindakan ini <span class="fw-bold">tidak dapat dibatalkan</span>
                        </p>
                    </div>
                    <div class="modal-footer justify-content-center border-0 pb-4">
                        <button type="submit" class="btn btn-danger px-4 rounded-pill shadow-sm">
                            <i class="lni lni-trash-can me-1"></i> Hapus
                        </button>
                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 
@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        const urlEditMasterPerlengkapan = "{{ route('masterEquipment.edit', ':id') }}";
        const routeUpdateMasterPerlengkapan = "{{ route('masterEquipment.update', ':id') }}";
        const routeDeleteMasterPerlengkapan = "{{ route('masterEquipment.destroy', ':id') }}";
        const form = document.getElementById("formTambah");
       $(document).on('click', '#btn-edit-Equipment', function(){
            let id = $(this).data('id');
            const form = document.getElementById('editEquipmentForm');
            form.action = routeUpdateMasterPerlengkapan.replace(':id', id);
            let finalUrl = urlEditMasterPerlengkapan.replace(':id', id);
            $.ajax({
                type: "get",
                url: finalUrl, 
                dataType: 'json',
                success: function(res){
                    $('#edit-nama-perlengkapan').val(res.nama_perlengkapan);
                    $('#edit-kategori').val(res.kategori);
                    $('#edit-deskripsi').val(res.deskripsi);
                    $('input[name="edit-status"]').filter(function(){
                        return ($(this).val() == res.status);
                    }).prop('checked', true);
                }
            });            
       });
       $(document).on('click', '#btn-delete-Equipment', function () {
            const id = $(this).data('id');
            const form = document.getElementById('deleteEquipmentForm');
            form.action = routeDeleteMasterPerlengkapan.replace(':id', id);
        });
        function resetForm() {
            form.reset();
        }
    </script>
@endpush
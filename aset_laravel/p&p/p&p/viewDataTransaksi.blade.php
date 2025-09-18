@extends('layouts.app')
@section('title')
    Aplikasi Aset & Kendaraan | Data Monitoring Penjadwalan P&P
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
        <div class="breadcrumb-title pe-3">Data Master</div>
        <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="{{ Route('home') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item " aria-current="page"><a href="javascript:;">Data Penjadwalan Mobil Dan Petugas</a></li>
            </ol>
        </nav>
        </div>
    </div>
@endsection
@section('content-main')
    {{-- @dd($dataAsets) --}}
    <h6 class="mb-0 text-uppercase">Data Penjadwalan Mobil Dan Petugas</h6>
    <hr>
    <div class="col-auto">
        <div class="d-flex align-items-end gap-3 justify-content-lg-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahVehicleBrandModal">
                <i class="bi bi-plus-lg me-2"></i>Add Monitoring Mobil
            </button>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered'], true) !!}
        </div>
    </div>
    {{-- modal tambah --}}
    <div class="modal fade" id="tambahVehicleBrandModal" tabindex="-1" aria-labelledby="tambahVehicleBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahVehicleBrandModalLabel">Tambahkan Monitoring Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('transaction.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="waktu_pemakaian" class="form-label">Tanggal Penjadwalan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="waktu_pemakaian" name="waktu_pemakaian" required>
                        </div>
                        <div class="mb-3">
                            <label for="shift" class="form-label">Shift <span class="text-danger">*</span></label>
                            <select class="form-select" name="shift" id="shift" required>
                                <option value="" selected disabled>-- Pilih Shift --</option>
                                <option value="1">Shift 1</option>
                                <option value="2">Shift 2</option>
                                <option value="3">Shift 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                            <select class="form-select" name="vehicle_id" id="vehicle_id" required>
                                <option value="" selected disabled>-- Pilih Kendaraan --</option>
                            </select>
                        </div>
                        {{-- Bagian Perlengkapan --}}
                        <div class="mb-3">
                            <label class="form-label">Perlengkapan</label>
                            <div id="perlengkapan-wrapper-mobil">
                                @if (isset($perlengkapan_mobil) && $perlengkapan_mobil->count() > 0)
                                    @foreach($perlengkapan_mobil as $item)
                                        <div class="row g-2 mb-2 perlengkapan-item" data-id="{{ $item->id }}">
                                            <div class="col-md-7">
                                                <input type="hidden" name="perlengkapan_id_mobil[]" value="{{ $item->id }}">
                                                <input type="text" class="form-control" value="{{ $item->nama_perlengkapan }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="jumlah-mobil[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                                            </div>
                                            <div class="col-md-2 d-grid">
                                                <button type="button" class="btn btn-danger remove-row"><i class="bx bx-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted">Tidak ada data perlengkapan.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white">Tambahkan</button>
                        <button type="button" class="btn btn-danger px-4 text-white" onclick="document.getElementById('formTambah').reset()">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit Kendaraan -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="editModalLabel">Edit Kendaraan</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <form id="form-edit-kendaraan">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="waktu_pemakaian" class="form-label">Tanggal Penjadwalan <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="edit-waktu_pemakaian" name="waktu_pemakaian" required>
                </div>
                <div class="mb-3">
                    <label for="shift" class="form-label">Shift <span class="text-danger">*</span></label>
                    <select class="form-select" name="shift" id="edit-shift" required>
                        <option value="" selected disabled>-- Pilih Shift --</option>
                        <option value="1">Shift 1</option>
                        <option value="2">Shift 2</option>
                        <option value="3">Shift 3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                    <select class="form-select" name="vehicle_id" id="edit-vehicle_id" required>
                        <option value="" selected disabled>-- Pilih Kendaraan --</option>
                        @if (isset($dataMobil) && $dataMobil->count() > 0)
                            @foreach($dataMobil as $item)
                                <option value="{{ $item->nomesin }}">{{ $item->nomesin }} - {{ $item->jenis }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                {{-- Bagian Perlengkapan --}}
                <div class="mb-3">
                    <label class="form-label">Perlengkapan</label>
                    <div id="perlengkapan-wrapper-mobil">
                        <div class="row g-2 mb-2 perlengkapan-item">
                            <div class="col-md-7">
                                <select name="perlengkapan_id_mobil[]" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Perlengkapan --</option>
                                    @if (isset($perlengkapan_mobil) && $perlengkapan_mobil->count() > 0)
                                        @foreach($perlengkapan_mobil as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_perlengkapan }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="jumlah-mobil[]" class="form-control" placeholder="Jumlah" min="1" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="form-edit-kendaraan" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Modal Tambah Petugas -->
    <div class="modal fade" id="tambahPetugas" tabindex="-1" aria-labelledby="tambahPetugasLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahPetugasLabel">Tambah Petugas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="form-tambah-petugas" method="POST">
                @csrf
                <div class="modal-body">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="mb-3">
                            <label for="employe_id{{ $i }}" class="form-label">Petugas {{ $i }}<span class="text-danger">*</span></label>
                            <select class="form-select employe-select" name="employe_id{{ $i }}" id="employe_id{{ $i }}" required>
                                <option value="" selected disabled>-- Pilih Petugas {{ $i }}--</option>
                            </select>
                        </div>
                    @endfor
                    {{-- Bagian Perlengkapan --}}
                    <div class="mb-3">
                        <label class="form-label">Perlengkapan</label>
                        <div id="perlengkapan-wrapper-petugas">
                            @if (isset($perlengkapan_petugas) && $perlengkapan_petugas->count() > 0)
                                @foreach($perlengkapan_petugas as $item)
                                    <div class="row g-2 mb-2 perlengkapan-item-petugas" data-id="{{ $item->id }}">
                                        <div class="col-md-7">
                                            <input type="hidden" name="perlengkapan_id_petugas[]" value="{{ $item->id }}">
                                            <input type="text" class="form-control" value="{{ $item->nama_perlengkapan }}" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="jumlah-petugas[]" class="form-control" placeholder="Jumlah" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2 d-grid">
                                            <button type="button" class="btn btn-danger remove-row-petugas"><i class="bx bx-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted">Tidak ada data perlengkapan.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="form-tambah-petugas" class="btn btn-success">Simpan</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Petugas -->
    <div class="modal fade" id="editPetugas" tabindex="-1" aria-labelledby="editPetugasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="editPetugasLabel">Edit Petugas</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <form id="form-edit-petugas">
            @csrf
            @method('PUT')
            <div class="modal-body">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="mb-3">
                        <label for="employe_id{{ $i }}" class="form-label">Petugas {{ $i }}<span class="text-danger">*</span></label>
                        <select class="form-select employe-select" name="employe_id{{ $i }}" id="edit-employe-id{{ $i }}" required>
                            <option value="" selected disabled>-- Pilih Petugas {{ $i }}--</option>
                            @if (isset($dataKaryawan) && $dataKaryawan->count() > 0)
                                @foreach($dataKaryawan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                @endfor
                {{-- Bagian Perlengkapan --}}
                <div class="mb-3">
                    <label class="form-label">Perlengkapan</label>
                    <div id="edit-perlengkapan-wrapper-petugas">
                        <div class="row g-2 mb-2 edit-perlengkapan-item">
                            <div class="col-md-7">
                                <select name="perlengkapan_id_petugas[]" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Perlengkapan --</option>
                                    @if (isset($perlengkapan_petugas) && $perlengkapan_petugas->count() > 0)
                                        @foreach($perlengkapan_petugas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_perlengkapan }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="jumlah-petugas[]" class="form-control" placeholder="Jumlah" min="1" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="form-edit-petugas" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Modal Perlengkapan Mobil -->
    <div class="modal fade" id="perlengkapanMobil" tabindex="-1" aria-labelledby="perlengkapanMobilLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3 shadow">
                
                <!-- Header -->
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="perlengkapanMobilLabel">
                        <i class="bi bi-tools me-2"></i> Perlengkapan Mobil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                
                <!-- Body -->
                <form id="form-perlengkapan-mobil" method="POST" action="{{ route('transaction.store_mobil') }}">
                    @csrf
                    <div class="modal-body">
                            <div class="row g-3">
                            </div>
                    </div>
                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Tutup
                        </button>
                        <button type="submit" form="form-perlengkapan-mobil" class="btn btn-info text-white">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Perlengkapan Petugas -->
    <div class="modal fade" id="perlengkapanPetugas" tabindex="-1" aria-labelledby="perlengkapanPetugasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow">
        <div class="modal-header bg-warning text-white">
            <h5 class="modal-title" id="perlengkapanPetugasLabel">Perlengkapan Petugas</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
            <form id="form-perlengkapan-petugas" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" form="form-perlengkapan-petugas" class="btn btn-warning text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 shadow">
        <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus data ini?</p>
            <input type="hidden" name="id" id="delete-id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="confirm-delete" class="btn btn-danger">Hapus</button>
        </div>
        </div>
    </div>
    </div>

@endsection 
@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    {{-- Inject route dan data perlengkapan ke window agar bisa diakses JS eksternal --}}
    <script>
        window.routeEditEquipmentVehicle = @json(route('transaction.edit', ':id'));
        window.routeUpdateEquipmentVehicle = @json(route('transaction.update', ':id'));
        window.routeDeleteEquipmentVehicle = @json(route('transaction.destroy', ':id'));
        window.routeGetMobil = @json(route('transaction.getVehicles'));
        window.routeGetEmployee = @json(route('transaction.employee', ':id'));
        window.routeStorePetugas = @json(route('transaction.store_petugas', ':id'));
        window.routeEditPetugas = @json(route('transaction.edit_petugas', ':id'));
        window.routeUpdatePetugas = @json(route('transaction.update_petugas', ':id'));
        window.routePerlengkapanGet = @json(route('perlengkapan.get', ':id'));
        window.routePerlengkapanPetugasGet = @json(route('perlengkapan_petugas.get', ':id'));
        window.perlengkapanMobil = @json($perlengkapan_mobil ?? []);
        window.perlengkapanPetugas = @json($perlengkapan_petugas ?? []);
    </script>
    <script src="{{ asset('layouts/assets/js/transaksi.js') }}"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    {{-- <script>
        const urlEditEquipmentVehicle = "{{ route('transaction.edit', ':id') }}";
        const routeUpdateEquipmentVehicle = "{{ route('transaction.update', ':id') }}";
        const routeDeleteEquipmentVehicle = "{{ route('transaction.destroy', ':id') }}";
        const routeGetMobil = "{{ route('transaction.getVehicles') }}";
        const routeGetEmployee = "{{ route('transaction.employee', ':id') }}";

        // Asynchronous: Edit kendaraan
        $(document).on('click', '.btn-edit-kendaraan', async function() {
            const id = $(this).data('id');
            const url = urlEditEquipmentVehicle.replace(':id', id);
            $('#form-edit-kendaraan').attr('action', routeUpdateEquipmentVehicle.replace(':id', id));
            $('#form-edit-kendaraan').attr('method', 'POST');
            try {
                const res = await fetch(url);
                const data = await res.json();
                $('#editModal #edit-waktu_pemakaian').val(data.tanggal_penjadwalan);
                $('#editModal #edit-shift').val(data.shift).trigger('change');
                $('#editModal #edit-vehicle_id').val(data.id_mobil).trigger('change');
                // Render perlengkapan
                const wrapper = $('#editModal #perlengkapan-wrapper-mobil');
                wrapper.empty();
                if (data.perlengkapan && data.perlengkapan.length > 0) {
                    data.perlengkapan.forEach(item => {
                        let options = '';
                        @foreach($perlengkapan_mobil as $p)
                            options += `<option value="{{ $p->id }}" ${item.perlengkapan_id == {{ $p->id }} ? 'selected' : ''}>{{ $p->nama_perlengkapan }}</option>`;
                        @endforeach
                        wrapper.append(`
                            <div class="row g-2 mb-2 perlengkapan-item">
                                <input type="hidden" name="perlengkapan_item_id[]" value="${item.id}">
                                <div class="col-md-7">
                                    <select name="perlengkapan_id_mobil[]" class="form-select" required>
                                        <option value="" disabled>-- Pilih Perlengkapan --</option>
                                        ${options}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="jumlah-mobil[]" class="form-control" placeholder="Jumlah" min="1" value="${item.jumlah}" required>
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="button" class="btn btn-danger remove-row"><i class="fadeIn animated bx bx-trash"></i></button>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    wrapper.append(`<p class="text-muted">Tidak ada perlengkapan yang dipilih.</p>`);
                }
                $('#editModal').modal('show');
            } catch (err) {
                alert('Gagal memuat data edit!');
            }
        });

        // Hapus perlengkapan mobil pada modal tambah
        $(document).on('click', '.remove-row', function () {
            $(this).closest('.perlengkapan-item').remove();
        });
        // Hapus perlengkapan petugas pada modal tambah petugas
        $(document).on('click', '.remove-row-petugas', function () {
            $(this).closest('.perlengkapan-item-petugas').remove();
        });
        
        $(document).on('click', '.remove-row', function () {
            $(this).closest('.perlengkapan-item').remove();
        });

        // Asynchronous: Get kendaraan by tanggal & shift
        $(document).ready(function () {
            function loadVehicles() {
                let tanggal = $('#waktu_pemakaian').val();
                let shift   = $('#shift').val();
                if (!tanggal || !shift) return;
                $('#vehicle_id').empty().append('<option value="" selected disabled>-- Pilih Kendaraan --</option>');
                $.ajax({
                    url: routeGetMobil,
                    type: 'GET',
                    data: { tanggal: tanggal, shift: shift },
                    dataType: 'json',
                    success: function (data) {
                        if (data.length === 0) {
                            $('#vehicle_id').append('<option disabled>Tidak ada kendaraan tersedia</option>');
                        } else {
                            data.forEach(function (vehicle) {
                                $('#vehicle_id').append(
                                    `<option value="${vehicle.nomesin}">${vehicle.nomesin} - ${vehicle.jenis ?? ''}</option>`
                                );
                            });
                        }
                    }
                });
            }
            $('#waktu_pemakaian, #shift').on('change', loadVehicles);
        });

        // Asynchronous: Tambah petugas
        $(document).on('click', '.btn-tambah-petugas', function () {
            let id = $(this).data('id');
            $('#form-tambah-petugas').attr('action', "{{ route('transaction.store_petugas', ':id') }}".replace(':id', id));
            function loadEmployee() {
                let $selects = $('.employe-select');
                $selects.empty().append('<option value="" selected disabled>-- Pilih Petugas --</option>');
                $.ajax({
                    url: routeGetEmployee.replace(':id', id),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        if (!data || data.length === 0) {
                            $selects.append('<option disabled>Tidak ada petugas tersedia</option>');
                        } else {
                            data.forEach(function (employee) {
                                let jabatan = employee.jabatan ? ` - ${employee.jabatan}` : '';
                                let option = `<option value="${employee.id}">${employee.nama}${jabatan}</option>`;
                                $selects.append(option);
                            });
                        }
                    }
                });
            }
            loadEmployee();
            $('#waktu_pemakaian, #shift').off('change.loadEmployee').on('change.loadEmployee', loadEmployee);
        });

        // Asynchronous: Edit petugas
        $(document).on('click', '.btn-edit-petugas', async function() {
            const id = $(this).data('id');
            const url = "{{ route('transaction.edit_petugas', ':id') }}".replace(':id', id);
            $('#form-edit-petugas').attr('action', "{{ route('transaction.update_petugas', ':id') }}".replace(':id', id));
            $('#form-edit-petugas').attr('method', 'POST');
            try {
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
                const data = await res.json();
                $('#edit-employe-id1').val(data.id_petugas_1).trigger('change');
                $('#edit-employe-id2').val(data.id_petugas_2).trigger('change');
                $('#edit-employe-id3').val(data.id_petugas_3).trigger('change');
                $('#edit-employe-id4').val(data.id_petugas_4).trigger('change');
                const wrapper = $('#editPetugas #edit-perlengkapan-wrapper-petugas');
                wrapper.empty();
                if (data.perlengkapan && data.perlengkapan.length > 0) {
                    data.perlengkapan.forEach(item => {
                        let options = '';
                        @foreach($perlengkapan_petugas as $p)
                            options += `<option value="{{ $p->id }}" ${item.perlengkapan_id == {{ $p->id }} ? 'selected' : ''}>{{ $p->nama_perlengkapan }}</option>`;
                        @endforeach
                        wrapper.append(`
                            <div class="row g-2 mb-2 edit-perlengkapan-item">
                                <input type="hidden" name="perlengkapan_item_id[]" value="${item.id}">
                                <div class="col-md-7">
                                    <select name="perlengkapan_id[]" class="form-select" required>
                                        <option value="" disabled>-- Pilih Perlengkapan --</option>
                                        ${options}
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="${item.jumlah}" required>
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="button" class="btn btn-danger remove-row"><i class="fadeIn animated bx bx-trash"></i></button>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    wrapper.append(`<p class="text-muted">Tidak ada perlengkapan yang dipilih.</p>`);
                }
                $('#editPetugas').modal('show');
            } catch (err) {
                alert('Gagal memuat data edit!');
            }
        });

        // Asynchronous: Perlengkapan Mobil & Petugas (checkbox)
        $(document).on('click', '.btn-perlengkapan-mobil', function () {
            let id = $(this).data('id');
            let url = "{{ route('perlengkapan.get', ':id') }}".replace(':id', id);
            $.get(url, function (res) {
                let container = $('#form-perlengkapan-mobil .row');
                container.empty();
                $.each(res.perlengkapan, function (i, item) {
                    let checked = res.perlengkapanTerpilih.some(p => p.id === item.id) ? 'checked' : '';
                    let html = `
                        <div class="col-md-6 col-lg-4">
                            <div class="form-check border rounded-3 p-2 shadow-sm h-100">
                                <input class="form-check-input" type="checkbox"
                                    id="check_${i}" name="barang[]"
                                    value="${item.id}" ${checked}>
                                <label class="form-check-label ms-1" for="check_${i}">
                                    ${item.master_perlengkapan.nama_perlengkapan} (qty: ${item.jumlah})
                                </label>
                            </div>
                        </div>`;
                    container.append(html);
                });
            });
        });
        $(document).on('click', '.btn-perlengkapan-petugas', function () {
            let id = $(this).data('id');
            let url = "{{ route('perlengkapan_petugas.get', ':id') }}".replace(':id', id);
            $.get(url, function (res) {
                let container = $('#form-perlengkapan-petugas .row');
                container.empty();
                $.each(res.perlengkapan, function (i, item) {
                    let checked = res.perlengkapanTerpilih.some(p => p.id === item.id) ? 'checked' : '';
                    let html = `
                        <div class="col-md-6 col-lg-4">
                            <div class="form-check border rounded-3 p-2 shadow-sm h-100">
                                <input class="form-check-input" type="checkbox"
                                    id="check_${i}" name="barang[]"
                                    value="${item.id}" ${checked}>
                                <label class="form-check-label ms-1" for="check_${i}">
                                    ${item.master_perlengkapan.nama_perlengkapan} (qty: ${item.jumlah})
                                </label>
                            </div>
                        </div>`;
                    container.append(html);
                });
            });
        });
    </script> --}}
@endpush
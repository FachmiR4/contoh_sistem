@extends('layouts.app')
@section('title')
    Aplikasi Aset & Kendaraan | Data Barang
@endsection
@push('css') 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('layouts/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
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
            <li class="breadcrumb-item " aria-current="page"><a href="javascript:;">Data Barang</a></li>
            </ol>
        </nav>
        </div>
    </div>
@endsection
@section('content-main')
    {{-- @dd($dataAsets) --}}
    <h6 class="mb-0 text-uppercase">Data Barang</h6>
    <hr>
    <div class="col-auto">
        <div class="d-flex align-items-end gap-3 justify-content-lg-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahManualBarangModal">
                <i class="bi bi-plus-lg me-2"></i>Add Data Barang Manual
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
    <div class="modal fade" id="tambahManualBarangModal" tabindex="-1" aria-labelledby="tambahManualBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
            <h5 class="modal-title" id="tambahManualBarangModalLabel">Tambah Data Barang Manual</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ Route('bapbbarang.store.manual') }}" method="POST" id="formTambah">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                <label for="kode" class="form-label">Barcode<span class="bintang" style="color: red;">*</span></label>
                <input type="text" class="form-control" id="barcode" name="barcode" maxlength="5" value="{{ $lastBarcode }}" required>
                </div>
                <div class="mb-3">
                <label for="" class="form-label">Nama Barang<span class="bintang" style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="nama-barang" name="nama_barang" required>
                </div>
                <div class="mb-3">
                        <label class="form-label">Satuan<span class="bintang" style="color: red;">*</span></label>
                        <select name="satuan" class="form-select" >
                            <option selected disabled>Pilih Satuan</option>
                            @foreach ($dataUnits as $satuan)
                                <option value="{{ $satuan['id'] }}">{{ $satuan['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Aset<span class="bintang" style="color: red;">*</span></label>
                            <select class="form-select" name="tipe_aset" required>
                                <option value="" selected disabled>Pilih Tipe Aset</option>
                                <option value="OPRASIONAL" >Operasional</option>
                                <option value="OFFICE" >Kantor</option>
                            </select>
                    </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Divisi Maintainer<span class="bintang" style="color: red;">*</span></label>
                    <select class="form-select" id="divisi" name="divisi" required>
                        <option selected disabled>Pilih Divisi</option>
                        @foreach ($divisions as $division)
                            @if (!is_null($division['name']))
                                <option value="{{ $division['id'] }}">{{ $division['name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">kategori Barang<span class="bintang" style="color: red;">*</span></label>
                    <select class="form-select" name="kategori_barang" id="single-select-field-2" data-placeholder="Choose one thing" required>
                        <option selected disabled>Pilih Kategori Barang</option>
                        @foreach ($kategori_barang as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->keterangan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sub Barang<span class="bintang" style="color: red;">*</span></label>
                    <select class="form-select" name="jenis_barang" id="single-select-field-4" data-placeholder="Choose one thing" required>
                        <option selected disabled>Pilih Jenis Barang</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Barang</label>
                    <input type="text" class="form-control" name="harga_display" id="harga_display" oninput="formatHarga(this, 'harga')" autocomplete="off" required>
                    <input type="hidden" name="harga" id="harga">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah<span class="bintang" style="color: red;">*</span></label>
                    <input type="number" class="form-control" name="jumlah" id="input-jumlah-detail" required>
                </div>
            </div>
                <div class="modal-footer justify-content-between border-0 pb-4">
                    <button type="button" class="btn btn-danger px-4 text-white" onclick="this.form.reset()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-success px-4 text-white">
                        <i class="bi bi-save me-1"></i> Tambahkan
                    </button>
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
            <h5 class="modal-title text-white" id="editManualBarangModalLabel">Edit Data Barang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editManualBarangForm" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode" class="form-label">Barcode<span class="bintang" style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="edit-barcode" name="edit_barcode_barang" maxlength="5" value="{{ $lastBarcode }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Barang<span class="bintang" style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="edit-nama-barang" name="edit_nama_barang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan<span class="bintang" style="color: red;">*</span></label>
                        <select id="edit-satuan" name="edit_satuan" class="form-select" >
                            <option selected disabled>Pilih Satuan</option>
                            @foreach ($dataUnits as $satuan)
                                <option value="{{ $satuan['id'] }}">{{ $satuan['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Aset<span class="bintang" style="color: red;">*</span></label>
                            <select class="form-select" name="edit-tipe_aset" required>
                                <option value="" selected disabled>Pilih Tipe Aset</option>
                                <option value="OPRASIONAL" >Operasional</option>
                                <option value="OFFICE" >Kantor</option>
                            </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Divisi Maintainer<span class="bintang" style="color: red;">*</span></label>
                        <select class="form-select" id="edit-divisi" name="edit-divisi" required>
                            <option selected disabled>Pilih Divisi</option>
                            @foreach ($divisions as $division)
                                @if (!is_null($division['name']))
                                    <option value="{{ $division['id'] }}">{{ $division['name'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">kategori Barang<span class="bintang" style="color: red;">*</span></label>
                        <select class="form-select" name="edit_kategori_barang" id="single-select-field-5" data-placeholder="Choose one thing" required>
                            <option selected disabled>Pilih Kategori Barang</option>
                            @foreach ($kategori_barang as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->keterangan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sub Barang<span class="bintang" style="color: red;">*</span></label>
                        <select class="form-select" name="edit_jenis_barang" id="single-select-field-6" data-placeholder="Choose one thing" required>
                            <option selected disabled>Pilih Jenis Barang</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Barang</label>
                        <input type="text" class="form-control" name="edit_harga_display" id="edit-harga-display" oninput="formatHarga(this, 'edit-harga')" autocomplete="off" required>
                        <input type="hidden" name="edit_harga" id="edit-harga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah<span class="bintang" style="color: red;">*</span></label>
                        <input type="number" class="form-control" name="edit_jumlah" id="edit-jumlah" required>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Close
                        </button>
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
                            Hapus Data Barang Manual
                        </h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteManualBarangForm" method="POST">
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
        const urlEditManualBarang = "{{ route('bapbbarang.edit', ':id') }}";
        const routeGetSubBarang = "{{ route('sub-barang.get', ':id') }}";
        const routeUpdateManualBarang = "{{ route('bapbbarang.update.manual', ':id') }}";
        const routeDeleteManualBarang = "{{ route('bapbbarang.destroy.manual', ':id') }}";
        const form = document.getElementById("formTambah");
        // Handle select option tambah
        $(document).ready(function() {
            $('#single-select-field-2').change(function() {
                var kategoriId = $(this).val();
                var subBarangSelect = $('#single-select-field-4');
                if (kategoriId) {
                    $.ajax({
                        url: routeGetSubBarang.replace(':id', kategoriId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            subBarangSelect.empty();
                            subBarangSelect.append('<option value="">Pilih Sub Barang</option>');
                            $.each(data, function(index, subBarang) {
                                subBarangSelect.append('<option value="' + subBarang.id + '">' + subBarang.nama_barang + '</option>');
                            });
                        }
                    });
                } else {
                    subBarangSelect.empty().append('<option value="">Pilih Sub Barang</option>');
                }
            });
        });
        // Handle select option Edit
        $(document).ready(function() {
            $('#single-select-field-5').change(function() {
                var editBarangId = $(this).val();
                var editSubBarangSelect = $('#single-select-field-6');
                if (editBarangId) {
                    $.ajax({
                        url: routeGetSubBarang.replace(':id', editBarangId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            editSubBarangSelect.empty();
                            editSubBarangSelect.append('<option value="">Pilih Sub Barang</option>');
                            $.each(data, function(index, subBarang) {
                                editSubBarangSelect.append('<option value="' + subBarang.id + '">' + subBarang.nama_barang + '</option>');
                            });
                        }
                    });
                } else {
                    editSubBarangSelect.empty().append('<option value="">Pilih Sub Barang</option>');
                }
            });
        });
        // Format harga saat input pada tambah dan edit
        function formatHarga(input, hiddenId) {
            let number = input.value.replace(/[^\d]/g, '');
            document.getElementById(hiddenId).value = number;
            input.value = formatRupiah(number);
        }

        function formatRupiah(angka) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   	 = number_string.split(','),
                sisa     	 = split[0].length % 3,
                rupiah     	 = split[0].substr(0, sisa),
                ribuan     	 = split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        $(document).on('click', '#btn-edit-manual-barang', function(){
            let id = $(this).data('id');
            const form = document.getElementById('editManualBarangForm');
            form.action = routeUpdateManualBarang.replace(':id', id);
            let finalUrl = urlEditManualBarang.replace(':id', id);
            $.ajax({
                type: "get",
                url: finalUrl, 
                dataType: 'json',
                success: function(res){
                    console.log(res);
                    $('#edit-barcode').val(res.barcode ? res.barcode : 'Non Barcode');
                    $('#edit-nama-barang').val(res.detail_barang);
                    $('#edit-satuan').val(res.id_satuan).trigger('change');
                    $('select[name="edit-tipe_aset"]').val(res.tipe_aset).trigger('change');
                    $('#edit-divisi').val(res.divisi_maintain).trigger('change');
                    $('#single-select-field-5').val(res.id_katagori_barang).trigger('change');
                    setTimeout(function() {
                        $('#single-select-field-6').val(res.product ? res.product.id : '').trigger('change');
                    }, 500);
                    $('#edit-harga-display').val(formatRupiah(res.harga ? res.harga.toString() : ''));
                    $('#edit-harga').val(res.harga);
                    $('#edit-jumlah').val(res.qty);
                }
            });            
        });

        $(document).on('click', '#btn-delete-manual-barang', function () {
            const id = $(this).data('id');
            const form = document.getElementById('deleteManualBarangForm');
            form.action = routeDeleteManualBarang.replace(':id', id);
        });
    </script>
@endpush
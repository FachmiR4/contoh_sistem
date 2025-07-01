{{-- filepath: c:\Users\fachmi\Documents\Project\my-app\resources\views\pages\bapb\createDataBapb.blade.php --}}
@extends('layouts.app')

@section('title')
    Aplikasi Aset & Kendaraan | Edit Data Pencacatan Aset
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .action-barang-btns {
            display: flex;
            gap: 16px;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }
        .action-barang-btns .right-btns {
            display: flex;
            gap: 12px;
        }
        .radio-group-horizontal {
            display: flex;
            gap: 2rem;
            align-items: center;
            margin: 2.3rem 21px;
        }
        .barang-form, .list-barang-form {
            background: #f8fafc;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(37,99,235,0.06);
            padding: 1.5rem 1.2rem 1.2rem 1.2rem;
            margin-bottom: 1.2rem;
            position: relative;
        }
        .barang-form .btn-outline-danger,
        .list-barang-form .btn-outline-danger {
            top: 10px !important;
            right: 10px !important;
            z-index: 2;
        }
        .barang-form label, .list-barang-form label {
            font-weight: 500;
            color: #0b0b0c;
        }
        .barang-form textarea, .list-barang-form textarea {
            resize: vertical;
        }
        .barang-form .btn-primary,
        .list-barang-form .btn-primary {
            margin-top: 10px;
        }
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
        .form-label .bintang {
            font-size: 1.1em;
            margin-left: 2px;
        }
        .barang-form h4 {
            font-size: 1.08rem;
            color: #0d6efd;
            font-weight: 600;
            margin-bottom: 1.2rem;
            letter-spacing: 0.5px;
        }
        .list-barang-form h5 {
            font-size: 1rem;
            color: #2563eb;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }
        @media (max-width: 600px) {
            .action-barang-btns {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }
            .action-barang-btns .right-btns {
                flex-direction: column;
                gap: 10px;
            }
            .barang-form, .list-barang-form {
                padding: 1rem 0.7rem;
            }
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3">Pencacatan Aset</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="{{ Route('home') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ Route('bapb.index') }}">Data BABP</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data BAPB</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content-main')
<div class="card-body p-4">
    <h5 class="mb-4 form-section-title"><i class="bi bi-file-earmark-plus"></i> Tambah Data BAPB</h5>
    <form id="form-bapb" action="{{ route('bapb.store') }}" method="POST" autocomplete="off">
        @csrf

        {{-- Kategori Dokumen --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Kategori Dokumen<span class="bintang" style="color: red;">*</span></label>
            <select class="form-select" id="kategori_dokumen" name="kategori_dokumen" required>
                <option selected disabled>Pilih Kategori</option>
                <option value="KONTRAK">KONTRAK</option>
                <option value="P U R">P U R</option>
                <option value="OP/PP">OP/PP</option>
            </select>
        </div>

        {{-- KONTRAK --}}
        <div id="form_kontrak" class="form-partial" style="display:none;">
            @include('pages.bapb.form.formKontrakBapb')
        </div>

        {{-- PUR --}}
        <div id="form_pur" class="form-partial" style="display:none;">
            @include('pages.bapb.form.formPurBapb')
        </div>

        {{-- OP/PP --}}
        <div id="form_oppp" class="form-partial" style="display:none;">
            @include('pages.bapb.form.formOpBapb')
        </div>

        <hr class="my-4">

        <div class="action-barang-btns" id="action-barang-btns" style="display: none;">
            <div class="right-btns">
                <button type="button" class="btn btn-primary" onclick="addBarangForm()">
                    <i class="bi bi-plus-lg"></i> Tambah List Barang
                </button>
            </div>
            <a href="{{ Route('bapb.index') }}" class="btn btn-danger px-4 text-white">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <h5 class="mb-3 form-section-title"><i class="bi bi-box-seam"></i> Tambah List Data Barang</h5>
        <div id="barang-list"></div>

        <div class="mt-4 text-start" id="submit-barang-btn" style="display: none;">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-save"></i> Simpan Seluruh Data
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/metismenu@3.0.7/dist/metisMenu.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('.metismenu').length) {
            $('.metismenu').metisMenu();
        }
    });

    let barangIndex = 0;

    function updateSubmitButtonVisibility() {
        const barangList = document.getElementById('barang-list');
        const submitBtn = document.getElementById('submit-barang-btn');
        if (barangList.querySelector('.barang-form')) {
            submitBtn.style.display = 'block';
        } else {
            submitBtn.style.display = 'none';
        }
    }

    function addBarangForm() {
        const container = document.getElementById('barang-list');
        const html = `
            <div class="barang-form border rounded p-3 mb-3 position-relative" data-index="${barangIndex}">
                <h4>Form List Barang ${barangIndex + 1}</h4>
                <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2" onclick="this.closest('.barang-form').remove(); updateSubmitButtonVisibility();">
                    <i class="bi bi-x"></i>
                </button>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label">Nama Barang<span class="bintang" style="color: red;">*</span></label>
                        <input type="text" class="form-control nama-barang-input" name="barang[${barangIndex}][nama]" placeholder="Nama Barang" required oninput="updateDetailBarangTitles(this)">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Satuan<span class="bintang" style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="barang[${barangIndex}][satuan]" placeholder="Satuan" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jumlah<span class="bintang" style="color: red;">*</span></label>
                        <input type="number" class="form-control" name="barang[${barangIndex}][jumlah]" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Total Harga Barang<span class="bintang" style="color: red;">*</span></label>
                        <input type="number" class="form-control" name="barang[${barangIndex}][price]" min="1000" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Keterangan</label>
                        <textarea  name="barang[${barangIndex}][keterangan]" class="form-control" placeholder="Keterangan" rows="4"></textarea>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button type="button" class="btn btn-outline-primary" onclick="addDetailBarangForm(this)">
                            <i class="bi bi-plus-lg"></i> Tambah Detail Barang
                        </button>
                    </div>
                </div>
                <div class="barang-detail mt-3"></div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        barangIndex++;
        updateSubmitButtonVisibility();
    }

    function addDetailBarangForm(btn) {
        const barangForm = btn.closest('.barang-form');
        const detailContainer = barangForm.querySelector('.barang-detail');
        let detailIndex = detailContainer.querySelectorAll('.list-barang-form').length;
        const jumlahInput = barangForm.querySelector('input[name^="barang"][name$="[jumlah]"]');
        const namaBarangInput = barangForm.querySelector('.nama-barang-input');
        const namaBarang = namaBarangInput ? namaBarangInput.value : '';
        const barangFormIndex = barangForm.getAttribute('data-index');
        const radioName = `detail[${barangFormIndex}][${detailIndex}][status]`;
        const html = `
            <div class="list-barang-form border rounded p-3 mb-3 position-relative" data-index="${detailIndex}">
                <h5 class="detail-barang-title">Detail Barang (${namaBarang}) ${detailIndex + 1}</h5>
                <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2" onclick="this.closest('.list-barang-form').remove(); refreshBarangFormNumbering(barangForm); updateSubmitButtonVisibility();">
                    <i class="bi bi-x"></i>
                </button>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label">Detail Barang<span class="bintang" style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="detail[${barangFormIndex}][${detailIndex}][nama]" placeholder="Nama Detail Barang" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pilih Barang<span class="bintang" style="color: red;">*</span></label>
                        <select class="form-select select-barang" name="detail[${barangFormIndex}][${detailIndex}][id_barang]" required>
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $i)
                                <option value="{{ $i['id'] }}">{{ $i['nama_barang'] }} - {{ $i['satuan'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jumlah<span class="bintang" style="color: red;">*</span></label>
                        <input type="number" class="form-control" name="detail[${barangFormIndex}][${detailIndex}][jumlah]" min="1" value="${parseInt(jumlahInput.value)}" required>
                    </div>
                    <div class="col-md-3">
                        <div class="radio-group-horizontal">
                            <div class="form-check form-check-success d-flex align-items-center">
                                <input class="form-check-input" type="radio" name="${radioName}" id="flexRadioSuccess${barangFormIndex}_${detailIndex}" value="1" required>
                                <label class="form-check-label" for="flexRadioSuccess${barangFormIndex}_${detailIndex}">
                                    Barcode
                                </label>
                            </div>
                            <div class="form-check form-check-danger d-flex align-items-center">
                                <input class="form-check-input" type="radio" name="${radioName}" id="flexRadioDanger${barangFormIndex}_${detailIndex}" value="0">
                                <label class="form-check-label" for="flexRadioDanger${barangFormIndex}_${detailIndex}">
                                    Non Barcode
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        detailContainer.insertAdjacentHTML('beforeend', html);
        setTimeout(() => {
            $(barangForm).find('.select-barang').last().select2({
                theme: 'default',
                width: '100%',
                dropdownParent: $(barangForm)
            });
        }, 0);
        refreshBarangFormNumbering(barangForm);
        updateSubmitButtonVisibility();
    }

    // Update all detail-barang-title in a barang-form when nama barang changes
    function updateDetailBarangTitles(input) {
        const barangForm = input.closest('.barang-form');
        const namaBarang = input.value;
        barangForm.querySelectorAll('.list-barang-form').forEach((el, idx) => {
            const h5 = el.querySelector('.detail-barang-title');
            if (h5) h5.textContent = `Detail Barang (${namaBarang}) ${idx + 1}`;
        });
    }

    // Reset numbering detail barang per barang-form
    function refreshBarangFormNumbering(barangForm = null) {
        if (barangForm) {
            const namaBarangInput = barangForm.querySelector('.nama-barang-input');
            const namaBarang = namaBarangInput ? namaBarangInput.value : '';
            barangForm.querySelectorAll('.barang-detail .list-barang-form').forEach((el, idx) => {
                const h5 = el.querySelector('.detail-barang-title');
                if (h5) h5.textContent = `Detail Barang (${namaBarang}) ${idx + 1}`;
            });
        } else {
            document.querySelectorAll('.barang-form').forEach(form => {
                const namaBarangInput = form.querySelector('.nama-barang-input');
                const namaBarang = namaBarangInput ? namaBarangInput.value : '';
                form.querySelectorAll('.barang-detail .list-barang-form').forEach((el, idx) => {
                    const h5 = el.querySelector('.detail-barang-title');
                    if (h5) h5.textContent = `Detail Barang (${namaBarang}) ${idx + 1}`;
                });
            });
        }
    }

    function setPartialInputsState(partialId, enabled) {
        const partial = document.getElementById(partialId);
        if (!partial) return;
        const inputs = partial.querySelectorAll('input, select, textarea');
        inputs.forEach(el => {
            if (enabled) {
                el.removeAttribute('disabled');
            } else {
                el.setAttribute('disabled', 'disabled');
            }
        });
    }

    function showFormKategori() {
        const val = document.getElementById('kategori_dokumen').value;
        const formKontrak = document.getElementById('form_kontrak');
        const formPur = document.getElementById('form_pur');
        const formOppp = document.getElementById('form_oppp');
        const actionBtns = document.getElementById('action-barang-btns');

        // Hide all forms and disable their inputs
        formKontrak.style.display = 'none'; setPartialInputsState('form_kontrak', false);
        formPur.style.display = 'none'; setPartialInputsState('form_pur', false);
        formOppp.style.display = 'none'; setPartialInputsState('form_oppp', false);
        actionBtns.style.display = 'none';

        // Show the selected form and enable its inputs
        if (val === 'KONTRAK') {
            formKontrak.style.display = '';
            setPartialInputsState('form_kontrak', true);
            actionBtns.style.display = 'flex';
        } else if (val === 'P U R') {
            formPur.style.display = '';
            setPartialInputsState('form_pur', true);
            actionBtns.style.display = 'flex';
        } else if (val === 'OP/PP') {
            formOppp.style.display = '';
            setPartialInputsState('form_oppp', true);
            actionBtns.style.display = 'flex';
        }
    }

    document.getElementById('kategori_dokumen').addEventListener('change', showFormKategori);

    document.addEventListener('DOMContentLoaded', function() {
        showFormKategori();
        $('.select-barang').select2({
            theme: 'default',
            width: '100%',
            dropdownParent: $('#barang-list')
        });
        updateSubmitButtonVisibility();
    });
</script>
@endpush
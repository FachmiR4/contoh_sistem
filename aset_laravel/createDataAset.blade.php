@extends('layouts.app')
@section('title')
    Aplikasi Aset & Kendaraan | Tambah Data Aset
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <link href="{{ asset('layouts/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .select-scroll {
            max-height: 200px;
            overflow-y: auto;
        }
        @media screen and (max-width: 768px) {
            select.form-select {
                font-size: 14px;
                max-width: 100%;
            }
        }
    </style>
@endpush
@php
    $p = isset($prefix) ? $prefix : '';
@endphp
@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3">Pencatatan</div>
        <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="{{ Route('home') }}"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item " aria-current="page"><a href="{{ Route('pencatatan.index') }}">Data Pencatatan Aset</a></li>
            <li class="breadcrumb-item " aria-current="page"><a href="javascript:;">Tambah Data Aset </a></li>
            </ol>
        </nav>
        </div>
    </div>
@endsection
@section('content-main')
<div class="card-body p-4">
    <h5 class="mb-4">Tambah Aset</h5>
    <form id="productForm" action="javascript:void(0);" class="row g-3">
        @csrf
        <input type="hidden" id="editMode" value="">
        <div class="col-md-3">
            <label class="form-label">Code barcode</label>
            <input type="text" class="form-control" id="noAset" placeholder="No Aset" maxlength="11" value="{{ $newNumber }}" readonly>
        </div>
        <div class="col-md-9">
            <label class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="{{ $p }}nmBarang" placeholder="Nama Barang">
        </div>
        <div class="col-md-4">
            <label class="form-label">No PP/PU/PUR</label>
            <input type="text" class="form-control" id="{{ $p }}noPP">
        </div>
        <div class="col-md-4">
            <label class="form-label">No OP</label>
            <input type="text" class="form-control" id="{{ $p }}noOP">
        </div>
        <div class="col-md-4">
            <label class="form-label">No BAPB</label>
            <input type="text" class="form-control" id="{{ $p }}noBAPB">
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal PP</label>
            <input type="date" class="form-control" id="{{ $p }}tglPP">
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal OP</label>
            <input type="date" class="form-control" id="{{ $p }}tglOP">
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal BAPB</label>
            <input type="date" class="form-control" id="{{ $p }}tglBAPB">
        </div>
        <div class="col-md-6">
            <label class="form-label">Harga OP</label>
            <input type="number" class="form-control" id="{{ $p }}hrgOP">
        </div>
        <div class="col-md-6">
            <label class="form-label">Pengguna</label>
            <select name="pggn" class="form-select"  id="single-select-field" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Pengguna</option>
                @foreach ($dataEmployees as $karyawan)
                    <option value="{{ $karyawan['id'] }}">{{ $karyawan['nama']."| Nik: ".$karyawan['nik']."| Jabatan: ". $karyawan['jabatan'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Detail Pengguna</label>
            <input type="text" class="form-control" id="{{ $p }}dtlPengguna">
        </div>
        <div class="col-md-6">
            <label class="form-label">Jenis Aset</label>
            <select  name="jnsAset" class="form-select"  id="single-select-field-2" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Jenis Aset</option>
                @foreach ($dataProducts as $barang)
                    <option value="{{ $barang['id'] }}">{{ $barang['nama_barang'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Devisi</label>
            <select  name="dvs" class="form-select"  id="single-select-field-3" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Devisi</option>
                @foreach ($dataDivisions as $devisi)
                    @if (!is_null($devisi['deskripsi']))
                        <option value="{{ $devisi['id'] }}">{{ $devisi['deskripsi'] }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Ruangan</label>
            <select  name="rng" class="form-select"  id="single-select-field-4" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Ruangan</option>
                @foreach ($dataRooms as $ruang)
                    <option value="{{ $ruang['id'] }}">{{ $ruang['deskripsi'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Satuan</label>
            <select  name="stn" class="form-select"  id="single-select-field-5" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Satuan</option>
                @foreach ($dataUnits as $satuan)
                    <option value="{{ $satuan['id'] }}">{{ $satuan['deskripsi'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Lokasi</label>
            <select  name="lks" class="form-select"  id="single-select-field-6" data-placeholder="Choose one thing">
                <option selected disabled>Pilih Lokasi</option>
                @foreach ($dataLocations as $lokasi)
                    <option value="{{ $lokasi['kode'] }}">{{ $lokasi['keterangan'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" id="{{ $p }}qty">
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select  name="sts" class="form-select"  id="single-select-field-7" data-placeholder="Choose one thing">
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
            <input type="date" class="form-control" id="{{ $p }}tglAset">
        </div>
        <div class="col-md-12">
            <label class="form-label">Catatan</label>
            <textarea class="form-control" id="{{ $p }}cttn" rows="3"></textarea>
        </div>
        <div class="col-md-12">
            <label class="form-label">Upload File</label>
            <div class="card">
                <div class="card-body">
                    <input id="image-uploadify" type="file" accept=".jpg, .png, image/jpeg, image/png,.pdf" multiple>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="d-md-flex d-grid align-items-center gap-3">
                <button type="submit" id="submitButton" class="btn btn-danger px-4 text-white">Draft</button>
                <button type="reset" class="btn btn-info px-4 text-white" onclick="resetForm()">Reset</button>
            </div>
        </div>
    </form>
</div>

<div class="card-body p-4">
    <h5 class="mb-4">Draft Data</h5>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
               <table class="table mb-0" id="productTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Aset</th>
                            <th>Nama Barang</th>
                            <th>No PP</th>
                            <th>No OP</th>
                            <th>No BAPB</th>
                            <th>Tgl PP</th>
                            <th>Tgl OP</th>
                            <th>Tgl BAPB</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table> 
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary px-4 text-white mt-3" id="saveButton" onclick="submitToDatabase()" style="display: none;">Simpan Data</button>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('layouts/assets/plugins/select2/js/select2-custom.js') }}"></script>
<script src="{{ asset('layouts/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#image-uploadify').imageuploadify();
    })
</script>
<script>
    let productList = [];

    const form = document.getElementById("productForm");
    const tbody = document.querySelector("#productTable tbody");
    const editModeInput = document.getElementById("editMode");
    const submitButton = document.getElementById("submitButton");

    form.addEventListener("submit", handleFormSubmit);

    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('noAset').value = generateNextAssetNumber();
    });

    async function handleFormSubmit(event) {
        event.preventDefault();

        const fileInput = document.getElementById("image-uploadify");
        let uploadedFiles = [];
        if (fileInput && fileInput.files.length > 0) {
            uploadedFiles = await uploadFiles(fileInput.files);
        }

        const product = getFormData();
        product.uploadedFiles = uploadedFiles; 

        if (!product.nama || !product.noPP || !product.noOP || !product.noBAPB) {
            alert("Harap isi semua field yang wajib.");
            return;
        }

        const editIndex = editModeInput.value;

        if (editIndex !== "") {
            productList[editIndex] = product;
        } else {
            product.noAset = generateNextAssetNumber();
            productList.push(product);
        }
        resetForm();
        renderTable();
    }

    function getFormData() {
        const get = id => document.getElementById(id)?.value?.trim() || '';
        const getSelect = name => document.querySelector(`[name="${name}"]`)?.value?.trim() || '';
        console.log("getSelect:", getSelect('pggn'), getSelect('jnsAset'), getSelect('dvs'), getSelect('rng'), getSelect('stn'), getSelect('sts'));
        return {
            noAset: get('noAset'),
            nama: get('nmBarang'),
            noPP: get('noPP'),
            noOP: get('noOP'),
            noBAPB: get('noBAPB'),
            tglPP: get('tglPP'),
            tglOP: get('tglOP'),
            tglBAPB: get('tglBAPB'),
            hrgOP: parseFloat(get('hrgOP')) || 0,
            pggn: getSelect('pggn'),
            dtlPengguna: get('dtlPengguna'),
            jnsAset: getSelect('jnsAset'),
            dvs: getSelect('dvs'),
            rng: getSelect('rng'),
            stn: getSelect('stn'),
            lks: getSelect('lks'),
            qty: parseInt(get('qty')) || 0,
            sts: getSelect('sts'),
            kds: getSelect('kds'),
            tglAset: get('tglAset'),
            cttn: get('cttn')
        };
    }

    function renderTable() {
        console.log("Rendering table with productList:", productList);
        tbody.innerHTML = "";
        productList.forEach((product, index) => {
            const fileList = (product.uploadedFiles && product.uploadedFiles.length)
                ? product.uploadedFiles.map(f => `<span class="badge bg-secondary">${f}</span>`).join('<br>')
                : '-';
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${product.noAset}</td>
                <td>${product.nama}</td>
                <td>${product.noPP}</td>
                <td>${product.noOP}</td>
                <td>${product.noBAPB}</td>
                <td>${product.tglPP}</td>
                <td>${product.tglOP}</td>
                <td>${product.tglBAPB}</td>
                <td>${fileList}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editProduct(${index})">Edit</button>
                    <button class="btn btn-success btn-sm" onclick="copyProduct(${index})">Copy</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(${index})">Hapus</button>
                </td>`;
            tbody.appendChild(row);
        });
        document.getElementById("saveButton").style.display = productList.length ? "inline-block" : "none";
    }

    async function uploadFiles(files) {
        const uploadedFileNames = [];
        for (let file of files) {
            const formData = new FormData();
            formData.append("file", file);

            await $.ajax({
                url: "{{ route('pencatatan.upload') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(result) {
                    if (result.success) {
                        uploadedFileNames.push(result.filename);
                        console.log("File berhasil diunggah:", result.filename);
                    } else {
                        console.warn("Upload gagal:", result);
                    }
                },
                error: function(xhr) {
                    console.error("Gagal mengunggah file:", xhr.responseText);
                }
            });
        }
        return uploadedFileNames;
    }

    function editProduct(index) {
        const product = productList[index];
        for (const key in product) {
            let el = document.getElementById(keyMap(key));
            if (!el) el = document.querySelector(`[name="${key}"]`);
            if (el && el.type !== 'file') el.value = product[key];
        }
        editModeInput.value = index;
        submitButton.textContent = "Update Data";
    }

    function copyProduct(index) {
        const original = productList[index];
        const copied = { ...original };
        copied.noAset = generateNextAssetNumber(); 
        productList.push(copied);
        renderTable();
    }

    function keyMap(key) {
        return key === "nama" ? "nmBarang" : key;
    }

    function deleteProduct(index) {
        productList.splice(index, 1);
        renderTable();
        resetForm();
    }

    function resetForm() {
        form.reset();
        editModeInput.value = "";
        submitButton.textContent = "Draft";
        document.getElementById('noAset').value = generateNextAssetNumber();

        // Reset image-uploadify preview
        const fileInput = $('#image-uploadify');
        if (fileInput.data('imageuploadify')) {
            fileInput.imageuploadify('reset');
        } else {
            fileInput.val('');
        }
    }

    function submitToDatabase() {
        $.ajax({
            url: "{{ route('pencatatan.store') }}",
            type: "POST",
            data: JSON.stringify({ items: productList }),
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                const toastHTML = `
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                        <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show" id="toastSuccess">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white">
                                    <span class="material-icons-outlined fs-2">check_circle</span>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Success Simpan data</h6>
                                    <div class="text-white">${data.message || 'Data berhasil disimpan!'}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', toastHTML);
                setTimeout(() => {
                    const toast = document.getElementById('toastSuccess');
                    if (toast) {
                        toast.classList.remove('show');
                        setTimeout(() => {
                            toast.remove();
                        }, 150);
                    }
                }, 3000);

                productList = [];
                renderTable();
            },
            error: function(xhr) {
                console.error("Gagal mengirim:", xhr.responseText);
                alert("Gagal menyimpan data ke controller.");
            }
        });
    }

    function generateNextAssetNumber() {
        const asetNumbers = productList.map(p => parseInt(p.noAset)).filter(n => !isNaN(n));
        const maxNumber = asetNumbers.length ? Math.max(...asetNumbers) : parseInt('{{ $newNumber}}') || 1;
        return String(maxNumber + 1);
    }
</script>
@endpush
@extends('layouts.app')

@section('title')
    Aplikasi Aset & Kendaraan | Tambah Data Barang BAPB
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
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
                    <a href="{{ Route('bapb.index') }}">Data BAPB</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Data Barang BAPB</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content-main')
<div class="card shadow-sm">
    <div class="card-body">
        <ul class="nav nav-tabs nav-fill w-100 mb-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="tab-1-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-1"
                    type="button"
                    role="tab"
                    aria-controls="tab-1"
                    aria-selected="true"
                >
                    <i class="bi bi-plus me-1"></i> Barcode
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="tab-2-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-2"
                    type="button"
                    role="tab"
                    aria-controls="tab-2"
                    aria-selected="false"
                >
                    <i class="bi bi-plus me-1"></i> Non Barcode
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="tab-3-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-3"
                    type="button"
                    role="tab"
                    aria-controls="tab-3"
                    aria-selected="false"
                >
                    <i class="bi bi-table me-1"></i> Barcode
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="tab-4-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#tab-4"
                    type="button"
                    role="tab"
                    aria-controls="tab-4"
                    aria-selected="false"
                >
                    <i class="bi bi-table me-1"></i> Non Barcode
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div
                class="tab-pane fade show active"
                id="tab-1"
                role="tabpanel"
                aria-labelledby="tab-1-tab"
            >
                <div class="p-3">
                    @include('pages.bapb.item.partials.formAddItemBarcode')
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="tab-2"
                role="tabpanel"
                aria-labelledby="tab-2-tab"
            >
                <div class="p-3">
                    @include('pages.bapb.item.partials.formAddItemNonBarcode')
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="tab-3"
                role="tabpanel"
                aria-labelledby="tab-3-tab"
            >
                <div class="p-3">
                    @include('pages.bapb.item.partials.tableItemBarcode')
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="tab-4"
                role="tabpanel"
                aria-labelledby="tab-4-tab"
            >
                <div class="p-3">
                    @include('pages.bapb.item.partials.tableItemNonBarcode')
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ Route('bapb.index') }}" class="btn btn-danger px-4 text-white">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('layouts/assets/plugins/select2/js/select2-custom.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const lastTab = localStorage.getItem("lastActiveTab");
        if (lastTab) {
            const triggerEl = document.querySelector(`[data-bs-target="${lastTab}"]`);
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }
        document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((tabButton) => {
            tabButton.addEventListener("shown.bs.tab", function (event) {
                const target = event.target.getAttribute("data-bs-target");
                localStorage.setItem("lastActiveTab", target);
            });
        });

        if (window.jQuery) {
            $('.form-select').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }
    });
</script>
@endpush
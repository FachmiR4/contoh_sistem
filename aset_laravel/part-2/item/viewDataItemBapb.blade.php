@extends('layouts.app')

@section('title')
    Aplikasi Aset & Kendaraan | Edit Data Pencacatan Aset
@endsection

@push('css')
    <link href="{{ asset('layouts/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <style>
        table.dataTable td {
            white-space: nowrap;
            vertical-align: middle;
        }
        .custom-btn {
            transition: 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .custom-btn:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
        }
        .card {
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .card-header {
            background: linear-gradient(90deg, #0d6efd 0%, #0dcaf0 100%);
            color: #fff;
            border-radius: 18px 18px 0 0;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
            flex-wrap: wrap;
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
            .action-bar {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.2em;
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
                    <li class="breadcrumb-item active" aria-current="page">Data Barang BAPB</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content-main')
    <h6 class="mb-0 text-uppercase">Data Barang BAPB</h6>
    <hr>
    <div class="action-bar">
        <a href="{{ route('bapb.index') }}" class="btn btn-danger custom-btn">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="button" class="btn btn-primary custom-btn" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
            <i class="bi bi-plus-lg me-2"></i>Add Data Barang
        </button>
    </div>
    <div class="card">
        <div class="card-header text-white">
            <i class="bi bi-table me-2"></i> Data Barang BAPB
        </div>
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-hover align-middle mb-0'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
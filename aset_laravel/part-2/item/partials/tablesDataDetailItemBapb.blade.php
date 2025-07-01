{{-- filepath: c:\Users\fachmi\Documents\Project\my-app\resources\views\pages\bapb\item\partials\tablesDataDetailItemBapb.blade.php --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" />
<style>
    .dataTables_length select {
        min-width: 60px;
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        font-size: 1rem;
        height: 32px;
        margin: 0 6px;
        display: inline-block;
        background: #fff;
    }
    .dataTables_length label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 1rem;
        font-weight: 400;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.2em;
    }
    table.dataTable {
        table-layout: auto !important;
        width: 100% !important;
    }
    table.dataTable th, table.dataTable td {
        white-space: nowrap;
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis;
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
        display: flex;
        align-items: center;
        gap: 10px;
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
        table.dataTable th, table.dataTable td {
            white-space: normal !important;
            word-wrap: break-word;
        }
        .action-bar {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }
    }
</style>
@endpush

<div class="card mb-4">
    <div class="card-header text-white">
        <i class="bi bi-table me-2"></i> Data Detail Barang BAPB
    </div>
    <div class="card-body">
        <div class="table-responsive">
            {!! $dataTable->table([
                'class' => 'table table-bordered table-hover align-middle mb-0 display responsive nowrap',
                'style' => 'width:100%;'
            ], true) !!}
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
<?php

namespace App\DataTables;

use App\Models\transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use App\Models\transactionDateOfVehicleAndEmployee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class transactionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle dropdown-toggle-nocaret" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-edit-kendaraan" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal">
                                    <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-tambah-petugas" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#tambahPetugas">
                                    <i class="bx bx-user-plus me-2 text-success"></i> Tambah Petugas
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-perlengkapan-mobil" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#perlengkapanMobil">
                                    <i class="bx bx-list-check me-2 text-info"></i> Perlengkapan Mobil
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-perlengkapan-petugas" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#perlengkapanPetugas">
                                    <i class="bx bx-user-check me-2 text-warning"></i> Perlengkapan Petugas
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item text-danger btn-delete-kendaraan" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                                    <i class="bi bi-trash me-2"></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </div>
                ';
            })->addColumn('action', function ($row) {
                // Cek apakah sudah ada petugas
                $hasPetugas = $row->id_petugas_1 || $row->id_petugas_2 || $row->id_petugas_3 || $row->id_petugas_4;
                $html = '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle dropdown-toggle-nocaret" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-edit-kendaraan" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal">
                                    <i class="bi bi-pencil me-2 text-primary"></i> Edit Kendaraan
                                </a>
                            </li>';
                if (!$hasPetugas) {
                    $html .= '
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-tambah-petugas" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#tambahPetugas">
                                    <i class="bx bx-user-plus me-2 text-success"></i> Tambah Petugas
                                </a>
                            </li>';
                } else {
                    $html .= '
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-edit-petugas" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editPetugas">
                                    <i class="bi bi-pencil me-2 text-secondary"></i> Edit Petugas
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-perlengkapan-petugas" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#perlengkapanPetugas">
                                    <i class="bx bx-user-check me-2 text-warning"></i> Perlengkapan Petugas
                                </a>
                            </li>';
                }
                $html .= '
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item btn-perlengkapan-mobil" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#perlengkapanMobil">
                                    <i class="bx bx-list-check me-2 text-info"></i> Perlengkapan Mobil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a href="javascript:void(0)" 
                                class="dropdown-item text-danger btn-delete-kendaraan" 
                                data-id="'.$row->id.'" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                                    <i class="bi bi-trash me-2"></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </div>';
                return $html;
            })
            ->addColumn('nomesin',function ($row) {
                return $row->vehicle
                    ? $row->vehicle->nomesin 
                    : '-';
            })
            ->addColumn('mobil', function ($row) {
                return $row->vehicle
                    ? $row->vehicle->jenis 
                    : '-';
            })
            ->addColumn('karyawan_1',function ($row) {
                return $row->employee_1
                    ? $row->employee_1->nama 
                    : '-';
            })
             ->addColumn('karyawan_2',function ($row) {
                return $row->employee_2
                    ? $row->employee_2->nama 
                    : '-';
            })
             ->addColumn('karyawan_3',function ($row) {
                return $row->employee_3
                    ? $row->employee_3->nama 
                    : '-';
            })
             ->addColumn('karyawan_4',function ($row) {
                return $row->employee_4
                    ? $row->employee_4->nama 
                    : '-';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(transactionDateOfVehicleAndEmployee $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('transaction-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->responsive(true)
                    ->parameters([
                        'responsive' => true,
                        'autoWidth' => false,
                        'pageLength' => 10,
                        'lengthMenu' => [[10, 20, 50, 100], [10, 20, 50, 100]],
                        'language' => [
                        'search' => '<span class="me-2"><i class="bi bi-search"></i></span>',
                        'searchPlaceholder' => 'Cari data transaksi...',
                        'lengthMenu' => 'Tampilkan _MENU_ data',
                        'info' => 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                        'paginate' => [
                            'previous' => '<i class="bi bi-chevron-left"></i>',
                            'next' => '<i class="bi bi-chevron-right"></i>',
                        ],
                    ],
                    ])
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->exportable(false)
                ->printable(false)
                ->width(20)
                ->title('No')
                ->addClass('text-center'),
            Column::make('nomesin')->title('No Mesin'),
            Column::make('mobil')->title('Jenis Mobil'),
            Column::make('karyawan_1')->title('Petugas 1'),
            Column::make('karyawan_2')->title('Petugas 2'),
            Column::make('karyawan_3')->title('Petugas 3'),
            Column::make('karyawan_4')->title('Petugas 4'),
            Column::make('shift')->title('Shift'),
            Column::make('tanggal_penjadwalan')->title('Tanggal Penjadwalan'),
            Column::make('status')->title('Status'),
            Column::computed('action')->title('Aksi')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'transaction_' . date('YmdHis');
    }
}

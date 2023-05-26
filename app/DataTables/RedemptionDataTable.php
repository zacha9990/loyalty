<?php

namespace App\DataTables;

use App\Models\Redemption;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class RedemptionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('customer_name', function ($redemption) {
                return $redemption->customer->name;
            })
            ->addColumn('customer_phone', function ($redemption) {
                return $redemption->customer->phone;
            })
            ->addColumn('created_time', function ($point) {
                return Carbon::parse($point->created_at)->locale('id')->format('d F Y, H:i:s');
            })
            // ->addColumn('action', function ($redemption) {
            //     // Add your action buttons here
            //     return '<button class="btn btn-sm btn-danger">Delete</button>';
            // })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Redemption $model): QueryBuilder
    {
        return $model->newQuery()->select('id', 'customer_id', 'lottery_coupons', 'is_used', 'created_at', 'updated_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('redemption-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->lengthMenu([5, 10, 25, 50], [5])
        ->dom('Bfrtip')
        ->orderBy(1)
        ->selectStyleSingle()
        ->buttons([
            Button::make('excel')->extend('excelHtml5', ['exportOptions' => ['page' => 'all']]),
            Button::make('csv')->extend('csvHtml5', ['exportOptions' => ['page' => 'all']]),
            Button::make('pdf')->extend('pdfHtml5', ['exportOptions' => ['page' => 'all']]),
            Button::make('print')->extend('print', ['exportOptions' => ['page' => 'all']]),
        ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('customer_name')->title('Customer Name'),
            Column::make('customer_phone')->title('Customer Phone'),
            Column::make('lottery_coupons')->title('Lottery Coupons'),
            Column::make('created_time')->title('Created Time'),
            // Column::computed('action')->title('Action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(120)
            //       ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Redemption_' . date('YmdHis');
    }
}

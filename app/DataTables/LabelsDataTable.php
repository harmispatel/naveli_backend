<?php

namespace App\DataTables;

use App\Models\Label;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LabelsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
    }

    public function query(Label $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('labels-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('export','CSV')
                    );
    }
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
                Column::make('label_name'),
                Column::make('total_plays'),
                Column::make('associated_songs'),
        ];
    }

    protected function filename()
    {
        return 'Labels_' . date('YmdHis');
    }
}

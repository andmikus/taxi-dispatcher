<?php

namespace App\DataTables;

use App\Entities\User;
use Yajra\DataTables\Services\DataTable;

class DriversDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('status', function(User $user) {
                return ($user->inShift()) ? '+' : '-';
            })
            ->addColumn('action', function(User $user) {
                return ($user->inShift()) ? view('order.driver-select', compact('user')) : '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->driver()->select('users.*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'class' => 'text-center'])
            ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'name',
            'status' => ['title' => 'In shift', 'class' => 'text-center'],
        ];
    }

    public function getBuilderParameters()
    {
        return [
            'info'    => FALSE,
            'dom'     => '',
            'buttons' => '',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}

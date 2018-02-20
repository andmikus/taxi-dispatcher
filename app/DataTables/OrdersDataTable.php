<?php

namespace App\DataTables;

use App\Entities\Order;
use App\Repos\GoogleMapService;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    /**
     * @var GoogleMapService
     */
    private $mapService;

    public function __construct(GoogleMapService $mapService)
    {
        $this->mapService = $mapService;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('origin', function(Order $order) {
                $map = $this->mapService->map('origin', $order->origin_location);
                $staticHelper = $this->mapService->staticBuilder();

                return $order->origin_address . '<br><img src="' . $staticHelper->render(   $map) . '" />';
            })
            ->editColumn('destination', function(Order $order) {
                $map = $this->mapService->map('origin', $order->destination_location);
                $staticHelper = $this->mapService->staticBuilder();

                return $order->destination_address . '<br><img src="' . $staticHelper->render($map) . '" />';
            })
            ->addColumn('action', function(Order $order) {
                return view('order.action', compact('order'));
            })
            ->rawColumns(['origin', 'destination', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param User $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->newQuery()
            ->where('status', '<>', 'completed')
            ->with('driver')
            ->select('orders.*');
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
            'origin',
            'destination',
            'start_time',
            'status',
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

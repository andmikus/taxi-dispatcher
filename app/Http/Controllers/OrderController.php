<?php namespace App\Http\Controllers;

use App\DataTables\DriversDataTable;
use App\DataTables\OrdersDataTable;
use App\Entities\Order;
use App\Http\Requests\OrderFormRequest;
use App\Repos\GoogleMapService;
use Illuminate\Support\Facades\DB;
use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Helper\Builder\PlaceAutocompleteHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Place\Autocomplete;
use Ivory\GoogleMap\Place\AutocompleteComponentType;

class OrderController extends Controller {

    protected $mapService;

    public function __construct(GoogleMapService $mapService)
    {
        $this->middleware('auth');

        $this->mapService = $mapService;
    }

    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('order.index');
    }

    public function create(DriversDataTable $dataTable)
    {
        $origAutocomplete = $this->mapService->placeAutocomplete('origin');
        $destAutocomplete = $this->mapService->placeAutocomplete('destination');

        $autocompleteHelper = $this->mapService->placeAutoconmpleteBuilder();
        $apiHelper = $this->mapService->apiBuilder();

        return $dataTable->render('order.create',
            compact('apiHelper', 'autocompleteHelper', 'origAutocomplete', 'destAutocomplete', 'dataTable'));
    }

    public function store(OrderFormRequest $request)
    {
        try {

            DB::beginTransaction();

                $order = Order::create($request->all());

            DB::commit();

        } catch (\Exception $e) {

            logger()->error($e->getMessage());

            return redirect()->back()->withInput();
        }

        return redirect()->route('order.index');
    }

    public function edit(Order $order, DriversDataTable $dataTable)
    {
        $origAutocomplete = $this->mapService->placeAutocomplete('origin', $order->origin_address);
        $destAutocomplete = $this->mapService->placeAutocomplete('destination', $order->destination_address);

        $autocompleteHelper = $this->mapService->placeAutoconmpleteBuilder();
        $apiHelper = $this->mapService->apiBuilder();

        return $dataTable->render('order.edit',
            compact('order', 'apiHelper', 'autocompleteHelper', 'origAutocomplete', 'destAutocomplete', 'dataTable'));
    }

    public function update(Order $order, OrderFormRequest $request)
    {
        try {

            DB::beginTransaction();

                $order->fill($request->all());
                $order->save();

            DB::commit();

        } catch (\Exception $e) {

            logger()->error($e->getMessage());

            return redirect()->back()->withInput();
        }

        return redirect()->route('order.index');
    }
}

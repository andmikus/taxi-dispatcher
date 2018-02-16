<?php namespace App\Http\Controllers;

use App\DataTables\DriversDataTable;
use App\Entities\Order;
use App\Http\Requests\OrderFormRequest;
use App\Repos\GoogleMapService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Illuminate\Support\Facades\DB;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Helper\Builder\PlaceAutocompleteHelperBuilder;
use Ivory\GoogleMap\Map;
use Illuminate\Http\Request;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\MapHelperBuilder;
use Ivory\GoogleMap\Place\Autocomplete;
use Ivory\GoogleMap\Place\AutocompleteComponentType;
use Ivory\GoogleMap\Place\AutocompleteType;
use Ivory\GoogleMap\Service\Base\Location\AddressLocation;
use Ivory\GoogleMap\Service\Direction\DirectionService;
use Ivory\GoogleMap\Service\Direction\Request\DirectionRequest;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;

class OrderController extends Controller {

    protected $mapService;

    public function __construct(GoogleMapService $mapService)
    {
        $this->middleware('auth');

        $this->mapService = $mapService;
    }

    public function index()
    {
        return view('order.index');
    }

    public function create(DriversDataTable $dataTable)
    {
        $origAutocomplete = new Autocomplete();
        $origAutocomplete->setComponents([AutocompleteComponentType::COUNTRY => 'lt']);
        $origAutocomplete->setInputAttributes([
            'name'  => 'start_address',
            'class' => 'form-control',
            'value' => old('start_address', ''),
            'placeholder' => ''
        ]);
        $origAutocomplete->setInputId('origin');
        $event = new Event(
            $origAutocomplete->getVariable(),
            'click',
            'function(){alert("Marker clicked!");}'
        );


        $destAutocomplete = new Autocomplete();
        $destAutocomplete->setComponents([AutocompleteComponentType::COUNTRY => 'lt']);
        $destAutocomplete->setInputAttributes([
            'name'  => 'end_address',
            'class' => 'form-control',
            'value' => old('end_address', ''),
            'placeholder' => ''
        ]);
        $destAutocomplete->setInputId('destination');

        $placeAutocompleteHelperBuilder = PlaceAutocompleteHelperBuilder::create();
        $placeAutocompleteHelperBuilder->getFormatter()->setDebug(true);
        $placeAutocompleteHelperBuilder->getFormatter()->setIndentationStep(4);
//        $placeAutocompleteHelperBuilder->addSubscriber('map_placement');
        $autocompleteHelper = $placeAutocompleteHelperBuilder->build();

        $apiHelper = ApiHelperBuilder::create()
            ->setKey(env('GOOGLE_KEY'))
            ->setLanguage('lt')
            ->build();

        return $dataTable->render('order.create',
            compact('apiHelper', 'autocompleteHelper', 'origAutocomplete', 'destAutocomplete', 'dataTable'));
    }

    public function store(OrderFormRequest $request)
    {
        dd($request->all());

        $request->merge([
            'start_location' => json_encode($this->mapService->coordinates($request->start_address)),
            'end_location' => json_encode($this->mapService->coordinates($request->end_address))
        ]);

        dump($request->all());

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
}

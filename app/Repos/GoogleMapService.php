<?php namespace App\Repos;

use Cache\Adapter\Predis\PredisCachePool;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Event\Event;
use Http\Adapter\Guzzle6\Client;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Place\Autocomplete;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Place\AutocompleteComponentType;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\Base\Distance;
use Ivory\GoogleMap\Service\Base\Duration;
use Ivory\GoogleMap\Service\Base\Location\AddressLocation;
use Ivory\GoogleMap\Service\DistanceMatrix\DistanceMatrixService;
use Ivory\GoogleMap\Service\DistanceMatrix\Request\DistanceMatrixRequest;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Ivory\GoogleMap\Helper\Builder\StaticMapHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\PlaceAutocompleteHelperBuilder;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;
use Ivory\GoogleMap\Service\Serializer\SerializerBuilder;

class GoogleMapService {

    protected $psr6Pool;

    protected $defaultLocation = [
        "lat" => 54.686076, "lng" => 25.287760
    ];

    public function __construct()
    {
        $client = new \Predis\Client(config('database.redis.default'));
        $this->psr6Pool = new PredisCachePool($client);
    }

    public function placeAutocomplete($target, $default = '')
    {
        $autocomplete = new Autocomplete();
        $autocomplete->setComponents([AutocompleteComponentType::COUNTRY => 'lt']);
        $autocomplete->setInputAttributes([
            'name'  => $target . '_address',
            'class' => 'form-control address-input',
            'value' => old($target . '_address', $default),
            'placeholder' => ''
        ]);
        $autocomplete->setInputId($target);
        $autocomplete->setVariable($target . 'Variable');
        $event = new Event(
            $autocomplete->getVariable(),
            'place_changed',
            $this->autocompleteTemplate($target)
        );
        $autocomplete->getEventManager()->addEvent($event);

        return $autocomplete;

    }

    private function autocompleteTemplate($target)
    {
        return "function(){
                var place = this.getPlace();
                if (place.geometry) {
                    var lat = place.geometry.location.lat();
                    var lng = place.geometry.location.lng();
                    $('#$target-location').val(JSON.stringify(place.geometry.location));
                    $('#$target-location-feedback').html('<a href=\"https://www.google.lt/maps/place/'+lat+','+lng+'\" target=\"_new\">Location: '+lat+', '+lng+'</a>');
                    $('#$target').addClass('is-valid');
                } else {
                    $('#$target').removeClass('is-valid');
                    $('#origin-location').val('');
                }
            }";
    }

    public function placeAutoconmpleteBuilder()
    {
        $placeAutocompleteHelperBuilder = PlaceAutocompleteHelperBuilder::create();
//        $placeAutocompleteHelperBuilder->getFormatter()->setDebug(true);
//        $placeAutocompleteHelperBuilder->getFormatter()->setIndentationStep(4);

        return $placeAutocompleteHelperBuilder->build();
    }

    public function apiBuilder()
    {
        return ApiHelperBuilder::create()
            ->setKey(env('GOOGLE_KEY'))
            ->setLanguage('lt')
            ->build();
    }

    public function staticBuilder()
    {
        return StaticMapHelperBuilder::create()
            ->setKey(env('GOOGLE_KEY'))
            ->build();
    }

    public function map($target = 'map', $location = NULL)
    {
        $map = new Map();
        $map->setVariable($target);
        $map->setHtmlId($target . '_map');
        $map->setAutoZoom(false);
        $map->setCenter($this->coordinate($location));
        $map->getOverlayManager()->addMarker(new Marker($this->coordinate($location)));
        $map->setMapOption('zoom', 16);
//        $map->setStaticOption('width', 100);
//        $map->setStaticOption('height', 100);

        return $map;
    }

    private function coordinate($location)
    {
        $prop = ($location) ? (array) json_decode($location) : (array) $this->defaultLocation;

        return new Coordinate(array_get($prop, 'lat'), array_get($prop, 'lng'));
    }

    public function distanceMatrix($originAddress, $destinationAddress)
    {
        $distanceMatrix = new DistanceMatrixService(
            new Client(),
            new GuzzleMessageFactory(),
            SerializerBuilder::create($this->psr6Pool)
        );

        return $distanceMatrix->process(new DistanceMatrixRequest(
            [new AddressLocation($originAddress)],
            [new AddressLocation($destinationAddress)]
        ));
    }

    public function getDistance($distanceMatrix)
    {
        $distance = [];

        foreach ($distanceMatrix->getRows() as $row) {
            foreach ($row->getElements() as $element) {
                $distance[] = $element->getDistance();
            }
        }

        return array_map(function(Distance $distance) {
            return $distance->getText();
        }, $distance);
    }

    public function getDuration($distanceMatrix)
    {
        $duration = [];

        foreach ($distanceMatrix->getRows() as $row) {
            foreach ($row->getElements() as $element) {
                $duration[] = $element->getDuration();
            }
        }

        return array_map(function(Duration $duration) {
            return $duration->getText();
        }, $duration);
    }

    public function coordinates($address)
    {
        $request = new GeocoderAddressRequest($address);

        $geocoder = new GeocoderService(
            new Client(),
            new GuzzleMessageFactory(),
            SerializerBuilder::create($this->psr6Pool)
        );

        $response = $geocoder->geocode($request);

        if ($response->getStatus() == 'OK') {
            foreach ($response->getResults() as $result) {
                return $this->formatCoordinatesResponse($result->getGeometry()->getLocation());
            }
        }

        return NULL;
    }

    private function formatCoordinatesResponse(Coordinate $coordinate)
    {
        return [
            'latitude' => $coordinate->getLatitude(),
            'longitude' => $coordinate->getLongitude()
        ];
    }
}
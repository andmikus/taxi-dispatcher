<?php namespace App\Repos;

use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;

class GoogleMapService {

    private $geocoder;

    public function __construct()
    {
        $this->geocoder = new GeocoderService(
            new Client(),
            new GuzzleMessageFactory()
//            SerializerBuilder::create($psr6Pool)
        );
    }


    public function coordinates($address)
    {
        $request = new GeocoderAddressRequest($address);

        $response = $this->geocoder->geocode($request);

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
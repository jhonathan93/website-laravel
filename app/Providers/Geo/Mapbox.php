<?php

namespace App\Providers\Geo;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use App\Contracts\Providers\Geo\GeocodingProvider;

class Mapbox implements GeocodingProvider {

    private const string NAME = 'Mapbox';

    private const string BASE_URL = 'https://nominatim.openstreetmap.org/search';

    /**
     * @var string
     */
    private string $apiKey;

    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return self::NAME;
    }

    /**
     * @param Address $address
     * @return array|null
     */
    public function geocode(Address $address): ?array {
        try {
            $url = self::BASE_URL . http_build_query([
                'country' => $address->country,
                'address_number' => $address->number,
                'street' => urlencode($address->street),
                'postcode' => $address->zipCode,
                'place' => urlencode("$address->city $address->state"),
                'access_token' => $this->apiKey,
            ]);

            $response = Http::get($url);

            $data = $response->json();

            if ($response->successful() && !empty($data['features'])) {
                return [
                    'latitude' => $data['features'][0]['geometry']['coordinates'][1],
                    'longitude' => $data['features'][0]['geometry']['coordinates'][0],
                    'provider' => self::NAME,
                ];
            }

            return null;
        } catch (ConnectionException $e) {
            return null;
        }
    }
}

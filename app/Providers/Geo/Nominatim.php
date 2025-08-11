<?php

namespace App\Providers\Geo;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use App\Contracts\Providers\Geo\GeocodingProvider;

class Nominatim implements GeocodingProvider {

    private const string NAME = 'Nominatim';

    private const string BASE_URL = 'https://api.geoapify.com/v1/geocode/search';

    /**
     * @var string
     */
    private string $apiKey;

    public function __construct(string $apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * @param Address $address
     * @return array|null
     */
    public function geocode(Address $address): ?array {
        try {
            $response = Http::withHeaders(['User-Agent' => config('app.name')])->get(self::BASE_URL, [
                'apiKey' => $this->apiKey,
                'text' => urlencode($address->full_address),
                'format' => 'json',
                'limit' => 1,
                'country' => 'Brazil'
            ]);

            $data = $response->json();

            if ($response->successful() && !empty($data)) {
                return [
                    'latitude' => $data[0]['lat'],
                    'longitude' => $data[0]['lon'],
                    'provider' => self::NAME,
                ];
            }

            return null;
        } catch (ConnectionException $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getName(): string {
        return self::NAME;
    }
}

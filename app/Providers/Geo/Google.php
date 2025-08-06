<?php

namespace App\Providers\Geo;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use App\Contracts\Providers\Geo\GeocodingProvider;

class Google implements GeocodingProvider {

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
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $address,
                'key' => $this->apiKey,
                'region' => 'br',
            ]);

            $data = $response->json();

            if ($response->successful() && !empty($data['results'])) {
                $location = $data['results'][0]['geometry']['location'];

                return [
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                    'provider' => 'google',
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
        return 'google';
    }
}

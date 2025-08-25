<?php

namespace App\Services\Geo;

use App\Models\Address;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use App\Contracts\Providers\Geo\GeocodingServiceInterface;

class GoogleService implements GeocodingServiceInterface {

    private const string NAME = 'Google';

    private const string BASE_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

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
            $response = Http::get(self::BASE_URL, [
                'address' => urlencode($address->full_address),
                'key' => $this->apiKey,
                'region' => 'br',
            ]);

            $data = $response->json();

            if ($response->successful() && !empty($data['results'])) {
                $location = $data['results'][0]['geometry']['location'];

                return [
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                    'provider' => self::NAME,
                ];
            }

            return null;
        } catch (ConnectionException $e) {
            return null;
        }
    }
}

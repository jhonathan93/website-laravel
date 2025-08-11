<?php

namespace App\Contracts\Providers\Geo;

use App\Models\Address;

interface GeocodingProvider {

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param Address $address
     * @return array|null
     */
    public function geocode(Address $address): ?array;
}

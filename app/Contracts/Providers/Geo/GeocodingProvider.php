<?php

namespace App\Contracts\Providers\Geo;

use App\Models\Address;

interface GeocodingProvider {

    /**
     * @param Address $address
     * @return array|null
     */
    public function geocode(Address $address): ?array;

    /**
     * @return string
     */
    public function getName(): string;
}

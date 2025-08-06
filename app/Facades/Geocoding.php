<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Geocoding extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string {
        return 'geocoding';
    }
}

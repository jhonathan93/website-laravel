<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Cep extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string {
        return 'cep';
    }
}

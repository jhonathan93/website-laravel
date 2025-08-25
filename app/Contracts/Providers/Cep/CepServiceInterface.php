<?php

namespace App\Contracts\Providers\Cep;

interface CepServiceInterface {

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $cep
     * @return array|null
     */
    public function cep(string $cep): ?array;
}

<?php

namespace App\Contracts\Providers\Validator;

interface ValidatorServiceInterface {

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $value
     * @param bool $validateFormat
     * @param bool $cacheResult
     * @return array
     */
    public function validate(string $value, bool $validateFormat = true, bool $cacheResult = false): array;
}

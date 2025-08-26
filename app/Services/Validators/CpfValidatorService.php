<?php

namespace App\Services\Validators;

use Illuminate\Support\Facades\Cache;
use App\Contracts\Providers\Validator\ValidatorServiceInterface;

class CpfValidatorService implements ValidatorServiceInterface {

    private const string NAME = 'Cpf';

    /**
     * @return string
     */
    public function getName(): string {
        return self::NAME;
    }

    /**
     * @param string $value
     * @param bool $validateFormat
     * @param bool $cacheResult
     * @return array
     */
    public function validate(string $value, bool $validateFormat = true, bool $cacheResult = true): array {
        $cacheKey = 'cpf_validation_' . md5($value);
        if ($cacheResult && Cache::has($cacheKey)) return Cache::get($cacheKey);

        $cleanedCpf = preg_replace('/[^0-9]/', '', $value);

        if ($validateFormat && !$this->isValidFormat($cleanedCpf)) {
            return $this->formatResponse(false, 'Formato do CPF inválido');
        }

        if (preg_match('/^(\d)\1{10}$/', $cleanedCpf)) {
            return $this->formatResponse(false, 'CPF com dígitos repetidos é inválido');
        }

        if (!$this->validateVerificationDigits($cleanedCpf)) {
            return $this->formatResponse(false, 'Dígitos verificadores do CPF inválidos');
        }

        $response = $this->formatResponse(true, 'CPF válido');

        if ($cacheResult) {
            Cache::put($cacheKey, $response, now()->addHours(24));
        }

        return $response;
    }

    /**
     * @param string $cpf
     * @return bool
     */
    private function isValidFormat(string $cpf): bool {
        return strlen($cpf) === 11;
    }

    /**
     * @param string $cpf
     * @return bool
     */
    private function validateVerificationDigits(string $cpf): bool {

        $digit1 = (int) $cpf[9];
        $digit2 = (int) $cpf[10];


        $sum1 = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum1 += (int) $cpf[$i] * (10 - $i);
        }

        $remainder1 = $sum1 % 11;
        $calculatedDigit1 = ($remainder1 < 2) ? 0 : 11 - $remainder1;

        if ($calculatedDigit1 !== $digit1) {
            return false;
        }

        $sum2 = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum2 += (int) $cpf[$i] * (11 - $i);
        }

        $remainder2 = $sum2 % 11;
        $calculatedDigit2 = ($remainder2 < 2) ? 0 : 11 - $remainder2;

        return $calculatedDigit2 === $digit2;
    }

    /**
     * @param bool $isValid
     * @param string $message
     * @return array
     */
    private function formatResponse(bool $isValid, string $message): array {
        return [
            'isValid' => $isValid,
            'message' => $message,
            'timestamp' => now()->toIso8601String()
        ];
    }
}

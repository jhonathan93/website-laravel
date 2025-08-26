<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValidator implements ValidationRule {
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!self::checkCpf((string) $value)) $fail('The provided CPF is not valid.');
    }

    public static function isValid(string $cpf): bool {
        return self::checkCpf($cpf);
    }

    private static function checkCpf(string $value): bool {
        $cpf = preg_replace('/\D/', '', $value);

        if (strlen($cpf) !== 11) return false;

        if (preg_match('/^(\d)\1+$/', $cpf)) return false;

        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $cpf[$i] * (10 - $i);
        }

        $digit1 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
        if ($digit1 !== (int) $cpf[9]) return false;

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += (int) $cpf[$i] * (11 - $i);
        }

        $digit2 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        if ($digit2 !== (int) $cpf[10]) return false;

        return true;
    }
}

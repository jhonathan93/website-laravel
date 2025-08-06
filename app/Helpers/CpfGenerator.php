<?php

namespace App\Helpers;

class CpfGenerator {
    public static function fake(bool $formatted = false): string {
        $n = [];
        for ($i = 0; $i < 9; $i++) {
            $n[] = rand(0, 9);
        }

        $d1 = 0;
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $d1 += $n[$i] * $j;
        }
        $d1 = 11 - ($d1 % 11);
        $d1 = ($d1 >= 10) ? 0 : $d1;

        $d2 = 0;
        for ($i = 0, $j = 11; $i < 9; $i++, $j--) {
            $d2 += $n[$i] * $j;
        }
        $d2 += $d1 * 2;
        $d2 = 11 - ($d2 % 11);
        $d2 = ($d2 >= 10) ? 0 : $d2;

        $cpf = implode('', $n) . $d1 . $d2;

        if ($formatted) {
            return substr($cpf, 0, 3) . '.' .
                substr($cpf, 3, 3) . '.' .
                substr($cpf, 6, 3) . '-' .
                substr($cpf, 9, 2);
        }

        return $cpf;
    }
}

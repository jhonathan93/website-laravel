<?php

namespace App\Helpers;

class PhoneGenerator {

    private static array $ddds = [
        11, 12, 13, 14, 15, 16, 17, 18, 19,
        21, 22, 24, 27, 28,
        31, 32, 33, 34, 35, 37, 38,
        41, 42, 43, 44, 45, 46,
        47, 48, 49,
        51, 53, 54, 55,
        61, 62, 63, 64,
        65, 66, 67,
        68, 69,
        71, 73, 74, 75, 77,
        79,
        81, 82, 83, 84, 85, 86, 87, 88, 89,
        91, 92, 93, 94, 95, 96, 97, 98, 99
    ];

    /**
     * Gera um número de telefone brasileiro válido
     *
     * @param int $type Se true, gera um número de celular; senão, fixo
     * @param bool $formatted Se true, retorna com máscara: (XX) XXXXX-XXXX
     * @return string
     */
    public static function fake(int $type, bool $formatted = false): string {
        $ddd = self::$ddds[array_rand(self::$ddds)];

        if ($type === 1) {
            $number = '9' . str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        } else {
            $inicio = rand(2, 5);
            $number = $inicio . str_pad((string) rand(0, 9999999), 7, '0', STR_PAD_LEFT);
        }

        $numberComplete = $ddd . $number;

        if ($formatted) {
            if ($type === 1) {
                return "($ddd) " . substr($number, 0, 5) . '-' . substr($number, 5);
            } else {
                return "($ddd) " . substr($number, 0, 4) . '-' . substr($number, 4);
            }
        }

        return $numberComplete;
    }
}

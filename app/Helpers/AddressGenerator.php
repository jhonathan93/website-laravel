<?php

namespace App\Helpers;

use Exception;

class AddressGenerator {
    private static array $ceps = [
        'AC' => ['69960970', '69932970'],
        'AL' => ['57960970', '57925970'],
        'AM' => ['69057970', '69005971'],
        'AP' => ['68903971', '68990970'],
        'BA' => ['47655970', '44001970'],
        'DF' => ['71200982', '71608971'],
        'GO' => ['73870970', '73801250'],
        'CE' => ['62340970', '62740970'],
        'ES' => ['29190971', '29931971'],
        'MA' => ['65921970', '65922970'],
        'MT' => ['78080970', '78400970'],
        'MS' => ['79041972', '79092970'],
        'MG' => ['35200970', '38400988'],
        'PA' => ['68521970', '68675970'],
        'PB' => ['58323970', '58338970'],
        'PR' => ['84640970', '86037752'],
        'PE' => ['55002970', '55650970'],
        'PI' => ['64855970', '64077971'],
        'RJ' => ['23080970', '28010972'],
        'RN' => ['59596970', '59800970'],
        'RS' => ['98118971', '99680970'],
        'RO' => ['76930970', '76960973'],
        'RR' => ['69314126', '69310753'],
        'SC' => ['89654970', '89886971'],
        'SP' => ['14700970', '14960970'],
        'SE' => ['49950970', '49010902'],
        'TO' => ['77490970', '77450970'],
    ];

    public static function fake(): ?array {
        $ufs = array_keys(self::$ceps);
        $uf = $ufs[array_rand($ufs)];
        $cep = self::$ceps[$uf][array_rand(self::$ceps[$uf])];

        $url = "https://viacep.com.br/ws/{$cep}/json/";

        try {
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            if (isset($data['erro']) || !$data) return null;

            return [
                'zip_code'  => str_replace('-', '', $data['cep']),
                'street'    => $data['logradouro'],
                'district'  => $data['bairro'],
                'city'      => $data['localidade'],
                'state'     => $data['uf']
            ];
        } catch (Exception $e) {
            return null;
        }
    }
}

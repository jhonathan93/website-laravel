<?php

namespace App\Views\Forms;

class AddressesFormSchema {

    /**
     * @return array[]
     */
    public static function fields(): array {
        return [
            'zip_code' => [
                'type' => 'text',
                'label' => 'CEP',
                'required' => false,
                'placeholder' => '00000-000',
                'data-mask' => 'cep',
                'colspan' => 'md:col-span-2',
                'before_input' => '<div class="flex">',
                'after_input' => '<button type="button" wire:click="searchZipCode" class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition-colors">Buscar</button></div>'
            ],
            'street' => [
                'type' => 'text',
                'required' => false,
                'label' => 'Rua',
                'placeholder' => 'Rua, Avenida, etc.',
                'colspan' => 'md:col-span-2'
            ],
            'number' => [
                'type' => 'text',
                'required' => false,
                'label' => 'Número',
                'placeholder' => 'Nº',
                'colspan' => ''
            ],
            'complement' => [
                'type' => 'text',
                'required' => false,
                'label' => 'Complemento',
                'placeholder' => 'Apto, Bloco, etc.',
                'colspan' => ''
            ],
            'district' => [
                'type' => 'text',
                'required' => false,
                'label' => 'Bairro',
                'placeholder' => 'Seu bairro',
                'colspan' => ''
            ],
            'city' => [
                'type' => 'text',
                'required' => false,
                'label' => 'Cidade',
                'placeholder' => 'Sua cidade',
                'colspan' => ''
            ],
            'state' => [
                'type' => 'select',
                'required' => false,
                'label' => 'Estado',
                'colspan' => '',
                'options' => [
                    'AC' => 'Acre',
                    'AL' => 'Alagoas',
                    'AP' => 'Amapá',
                    'AM' => 'Amazonas',
                    'BA' => 'Bahia',
                    'CE' => 'Ceará',
                    'DF' => 'Distrito Federal',
                    'ES' => 'Espírito Santo',
                    'GO' => 'Goiás',
                    'MA' => 'Maranhão',
                    'MT' => 'Mato Grosso',
                    'MS' => 'Mato Grosso do Sul',
                    'MG' => 'Minas Gerais',
                    'PA' => 'Pará',
                    'PB' => 'Paraíba',
                    'PR' => 'Paraná',
                    'PE' => 'Pernambuco',
                    'PI' => 'Piauí',
                    'RJ' => 'Rio de Janeiro',
                    'RN' => 'Rio Grande do Norte',
                    'RS' => 'Rio Grande do Sul',
                    'RO' => 'Rondônia',
                    'RR' => 'Roraima',
                    'SC' => 'Santa Catarina',
                    'SP' => 'São Paulo',
                    'SE' => 'Sergipe',
                    'TO' => 'Tocantins'
                ]
            ],
            'country' => [
                'type' => 'select',
                'required' => false,
                'label' => 'País',
                'colspan' => '',
                'options' => ['Brasil' => 'Brasil'],
                'default' => 'Brasil'
            ],
            'is_primary' => [
                'type' => 'checkbox',
                'required' => false,
                'label' => 'Endereço principal',
                'colspan' => 'md:col-span-2',
                'wrapper_class' => 'flex items-center'
            ]
        ];
    }
}

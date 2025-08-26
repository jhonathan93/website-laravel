<?php

namespace App\Livewire\Components\Forms\Addresses;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class AddressesForm extends Component {

    /**
     * @var array
     */
    public array $fields = [];

    /**
     * @var array
     */
    public array $formData = [];

    /**
     * @var bool
     */
    public bool $isEditing = false;
    public $addressId = null;
    public $userId = null;

    /**
     * @return array[]
     */
    protected function getFieldConfig(): array {
        return [
            'zip_code' => [
                'type' => 'text',
                'required' => true,
                'label' => 'CEP',
                'placeholder' => '00000-000',
                'class' => 'flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'data-mask' => 'cep',
                'colspan' => 'md:col-span-2',
                'before_input' => '<div class="flex">',
                'after_input' => '<button type="button" wire:click="searchZipCode" class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition-colors">Buscar</button></div>',
                'value' => null
            ],
            'street' => [
                'type' => 'text',
                'required' => true,
                'label' => 'Rua',
                'placeholder' => 'Rua, Avenida, etc.',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => 'md:col-span-2',
                'value' => null
            ],
            'number' => [
                'type' => 'text',
                'required' => true,
                'label' => 'Número',
                'placeholder' => 'Nº',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
            ],
            'complement' => [
                'type' => 'text',
                'required' => false,
                'label' => 'Complemento',
                'placeholder' => 'Apto, Bloco, etc.',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
            ],
            'district' => [
                'type' => 'text',
                'required' => true,
                'label' => 'Bairro',
                'placeholder' => 'Seu bairro',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
            ],
            'city' => [
                'type' => 'text',
                'required' => true,
                'label' => 'Cidade',
                'placeholder' => 'Sua cidade',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
            ],
            'state' => [
                'type' => 'select',
                'required' => true,
                'label' => 'Estado',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'options' => [
                    '' => 'Selecione',
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
                ],
                'value' => null
            ],
            'country' => [
                'type' => 'select',
                'required' => true,
                'label' => 'País',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'options' => ['Brasil' => 'Brasil'],
                'default' => 'Brasil'
            ],
            'is_primary' => [
                'type' => 'checkbox',
                'required' => false,
                'label' => 'Endereço principal',
                'class' => 'h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded',
                'colspan' => 'md:col-span-2',
                'wrapper_class' => 'flex items-center'
            ]
        ];
    }

    /**
     * @param $userId
     * @param $address
     * @return void
     */
    public function mount($userId = null, $address = null): void {
        $this->fields = $this->getFieldConfig();
        $this->userId = $userId;

        foreach ($this->fields as $field => $config) {
            $this->formData[$field] = $config['default'] ?? '';
        }

        if ($address) {
            $this->isEditing = true;
            $this->addressId = $address->id;
            $this->formData = array_merge($this->formData, $address->toArray());
        }
    }

    /**
     * @return void
     */
    public function searchZipCode(): void {
        $zipCode = preg_replace('/[^0-9]/', '', $this->formData['zip_code']);

        if (strlen($zipCode) === 8) {
            $this->formData['zip_code'] = substr($zipCode, 0, 5) . '-' . substr($zipCode, 5);

            $addressData = app('cep.viacep')->cep($zipCode);

            if ($addressData) {
                $this->formData = array_merge($this->formData, $addressData);

                $this->dispatch('triggerNotification', message: "Endereço carregado com sucesso para o CEP $zipCode", type: 'success');
            }
        }
    }

    /**
     * @return View|Application|Factory
     */
    public function render(): View|Application|Factory {
        return view('livewire.components.forms.addresses.addresses-form', [
            'fieldConfig' => $this->fields
        ]);
    }
}

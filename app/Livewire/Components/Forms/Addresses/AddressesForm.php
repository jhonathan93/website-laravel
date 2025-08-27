<?php

namespace App\Livewire\Components\Forms\Addresses;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Helpers\Support\FormRenderer;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use App\Views\Forms\AddressesFormSchema;

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
     * @param $userId
     * @param $address
     * @return void
     */
    public function mount($userId = null, $address = null): void {
        $this->fields = FormRenderer::applyDefaults(AddressesFormSchema::fields());
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

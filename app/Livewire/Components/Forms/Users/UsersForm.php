<?php

namespace App\Livewire\Components\Forms\Users;

use Livewire\Component;
use App\Rules\CpfValidator;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class UsersForm extends Component {

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
            'name' => [
                'type' => 'text',
                'required' => true,
                'label' => 'Nome',
                'placeholder' => 'Fulano da silva',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => 'md:col-span-2',
                'value' => null
            ],
            'email' => [
                'type' => 'email',
                'required' => true,
                'label' => 'Email',
                'placeholder' => 'fulano.silva@email.com',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
            ],
            'date_of_birth' => [
                'type' => 'date',
                'required' => false,
                'label' => 'Data de Nascimento',
                'placeholder' => '99/99/9999',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
            ],
            'cpf' => [
                'type' => 'text',
                'required' => true,
                'label' => 'CPF',
                'placeholder' => '000.000.000-00',
                'data-mask' => 'cpf',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'wire:blur' => 'validateCpfField',
                'value' => null
            ],
            'password' => [
                'type' => 'password',
                'required' => true,
                'label' => 'Senha',
                'placeholder' => '*********',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
            ],
            'confirm_password' => [
                'type' => 'password',
                'required' => true,
                'label' => 'Confirmar Senha',
                'placeholder' => '*********',
                'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent',
                'colspan' => '',
                'value' => null
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
    public function validateCpfField(): void {
        if (!CpfValidator::isValid($this->formData['cpf'] ?? '')) {
            $this->addError('cpf', 'CPF inválido. Por favor, verifique o número digitado.');
        } else {
            $this->resetErrorBag('cpf');
        }
    }

    /**
     * @return View|Application|Factory
     */
    public function render(): View|Application|Factory {
        return view('livewire.components.forms.users.users-form', [
            'fieldConfig' => $this->fields
        ]);
    }
}

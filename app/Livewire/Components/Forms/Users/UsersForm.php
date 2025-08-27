<?php

namespace App\Livewire\Components\Forms\Users;

use Livewire\Component;
use App\Rules\CpfValidator;
use Illuminate\Contracts\View\View;
use App\Views\Forms\UsersFormSchema;
use App\Helpers\Support\FormRenderer;
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

    public ?int $addressId = null;
    public ?int $userId = null;

    /**
     * Inicializa o formulário
     *
     * @param int|null $userId
     * @param object|null $address
     */
    public function mount(int $userId = null, object $address = null): void {
        $this->fields = FormRenderer::applyDefaults(UsersFormSchema::fields());
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
     * Valida o campo CPF isoladamente
     */
    public function validateCpfField(): void {
        if (!CpfValidator::isValid($this->formData['cpf'] ?? '')) {
            $this->addError('cpf', 'CPF inválido. Por favor, verifique o número digitado.');
        } else {
            $this->resetErrorBag('cpf');
        }
    }

    /**
     * Renderiza a view
     *
     * @return View|Application|Factory
     */
    public function render(): View|Application|Factory {
        return view('livewire.components.forms.users.users-form', [
            'fieldConfig' => $this->fields
        ]);
    }
}

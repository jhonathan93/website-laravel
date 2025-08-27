<?php

namespace App\Views\Forms;

class UsersFormSchema {
    public static function fields(): array {
        return [
            'name' => [
                'type' => 'text',
                'label' => 'Nome',
                'placeholder' => 'Fulano da Silva',
                'required' => false,
                'colspan' => 'md:col-span-2',
            ],
            'email' => [
                'type' => 'email',
                'label' => 'Email',
                'placeholder' => 'fulano@email.com',
                'required' => false,
            ],
            'date_of_birth' => [
                'type' => 'date',
                'label' => 'Data de Nascimento',
                'placeholder' => '99/99/9999',
            ],
            'cpf' => [
                'type' => 'text',
                'label' => 'CPF',
                'placeholder' => '000.000.000-00',
                'required' => false,
                'data-mask' => 'cpf',
                'wire:blur' => 'validateCpfField',
            ],
            'password' => [
                'type' => 'password',
                'label' => 'Senha',
                'placeholder' => '********',
                'required' => false,
            ],
            'password_confirmation' => [
                'type' => 'password',
                'label' => 'Confirmar Senha',
                'placeholder' => '********',
                'required' => false,
            ],
        ];
    }
}

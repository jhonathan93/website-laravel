<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'date_of_birth' => 'nullable|date',
            'cpf' => 'required|string|cpf|unique:users,cpf',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string|same:password',
            'street' => 'required|string',
            'number' => 'required|string',
            'complement' => 'nullable|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
            'is_primary' => 'nullable|string',
            'terms' => 'accepted'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser um texto.',

            'email.required' => 'O campo e-mail é obrigatório.',
            'email.string' => 'O campo e-mail deve ser um texto.',
            'email.email' => 'O e-mail informado não é válido.',
            'email.unique' => 'Este e-mail já está em uso.',

            'date_of_birth.date' => 'A data de nascimento deve ser uma data válida.',

            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.string' => 'O campo CPF deve ser um texto.',
            'cpf.cpf' => 'O CPF informado não é válido.',
            'cpf.unique' => 'Este CPF já está cadastrado.',

            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser um texto.',
            'password.confirmed' => 'A confirmação de senha não corresponde.',

            'password_confirmation.required' => 'O campo confirmação de senha é obrigatório.',
            'password_confirmation.string' => 'O campo confirmação de senha deve ser um texto.',
            'password_confirmation.same' => 'A confirmação de senha deve ser igual à senha.',

            'street.required' => 'O campo rua é obrigatório.',
            'street.string' => 'O campo rua deve ser um texto.',

            'number.required' => 'O campo número é obrigatório.',
            'number.string' => 'O campo número deve ser um texto.',

            'complement.string' => 'O campo complemento deve ser um texto.',

            'district.required' => 'O campo bairro é obrigatório.',
            'district.string' => 'O campo bairro deve ser um texto.',

            'city.required' => 'O campo cidade é obrigatório.',
            'city.string' => 'O campo cidade deve ser um texto.',

            'state.required' => 'O campo estado é obrigatório.',
            'state.string' => 'O campo estado deve ser um texto.',

            'zip_code.required' => 'O campo CEP é obrigatório.',
            'zip_code.string' => 'O campo CEP deve ser um texto.',

            'country.required' => 'O campo país é obrigatório.',
            'country.string' => 'O campo país deve ser um texto.',

            'is_primary.string' => 'O campo endereço principal deve ser um texto.',

            'terms.accepted' => 'Você deve aceitar os termos e condições.'
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed {
        throw new HttpResponseException(
            back()->withErrors($validator)->withInput()
        );
    }
}

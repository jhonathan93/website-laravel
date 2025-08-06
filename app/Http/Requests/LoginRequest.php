<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest {

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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array {
        return [
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'Por favor, insira um email válido',
            'password.required' => 'O campo senha é obrigatório',
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

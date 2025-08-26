<?php

namespace App\Providers;

use App\Rules\CpfValidator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Validator::extend('cpf', function ($attribute, $value, $parameters, $validator) {
            return CpfValidator::isValid($value);
        });

        Validator::replacer('cpf', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'O campo :attribute não contém um CPF válido.');
        });
    }

    /**
     * Register any application services.
     */
    public function register() {}
}

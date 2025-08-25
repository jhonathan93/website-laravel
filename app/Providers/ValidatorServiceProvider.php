<?php

namespace App\Providers;

use Carbon\Laravel\ServiceProvider;
use App\Providers\Validators\ValidatorManager;
use App\Services\Validators\CpfValidatorService;

class ValidatorServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void  {
        $this->app->bind('validator.cpf', fn() => new CpfValidatorService());

        $this->app->singleton(ValidatorManager::class, function ($app) {
            return new ValidatorManager([
                $app->make('validator.cpf'),
            ], 'Cpf');
        });

        $this->app->alias(ValidatorManager::class, 'validator');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

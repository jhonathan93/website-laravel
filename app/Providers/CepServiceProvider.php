<?php

namespace App\Providers;

use App\Providers\Cep\ViaCep;
use Carbon\Laravel\ServiceProvider;
use App\Services\Cep\CepService;

class CepServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void  {
        $this->app->bind('cep.viacep', fn() => new ViaCep());

        $this->app->singleton(CepService::class, function ($app) {
            return new CepService([
                $app->make('cep.viacep'),
            ], config('services.cep.default', 'viacep'));
        });

        $this->app->alias(CepService::class, 'cep');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

<?php

namespace App\Providers;

use App\Providers\Cep\CepManager;
use App\Services\Cep\ViaCepService;
use Carbon\Laravel\ServiceProvider;

class CepServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void  {
        $this->app->bind('cep.viacep', fn() => new ViaCepService());

        $this->app->singleton(CepManager::class, function ($app) {
            return new CepManager([
                $app->make('cep.viacep'),
            ], config('services.cep.default', 'viacep'));
        });

        $this->app->alias(CepManager::class, 'cep');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

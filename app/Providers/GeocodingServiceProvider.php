<?php

namespace App\Providers;

use App\Services\Geo\GoogleService;
use App\Services\Geo\MapboxService;
use App\Providers\Geo\GeocodingManager;
use Illuminate\Support\ServiceProvider;

class GeocodingServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void  {
        $this->app->bind('geocoding.google', fn() => new GoogleService(
            config('services.google.maps_api_key')
        ));

        $this->app->bind('geocoding.mapbox', fn() => new MapboxService(
            config('services.mapbox.access_token')
        ));

        $this->app->singleton(GeocodingManager::class, function ($app) {
            return new GeocodingManager([
                $app->make('geocoding.google'),
                $app->make('geocoding.mapbox'),
            ], config('services.geocoding.default', 'google'));
        });

        $this->app->alias(GeocodingManager::class, 'geocoding');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

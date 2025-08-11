<?php

namespace App\Providers;

use App\Providers\Geo\Google;
use App\Providers\Geo\Mapbox;
use App\Services\Geo\GeocodingService;
use Illuminate\Support\ServiceProvider;

class GeocodingServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void  {
        $this->app->bind('geocoding.google', fn() => new Google(
            config('services.google.maps_api_key')
        ));

        $this->app->bind('geocoding.mapbox', fn() => new Mapbox(
            config('services.mapbox.access_token')
        ));

        $this->app->singleton(GeocodingService::class, function ($app) {
            return new GeocodingService([
                $app->make('geocoding.google'),
                $app->make('geocoding.mapbox'),
            ], config('services.geocoding.default', 'google'));
        });

        $this->app->alias(GeocodingService::class, 'geocoding');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

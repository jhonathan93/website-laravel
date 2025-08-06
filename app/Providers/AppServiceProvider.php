<?php

namespace App\Providers;

use App\Services\Image\ImageService;
use App\Services\Storage\MinioService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(MinioService::class, function ($app) {
            return new MinioService('minio');
        });

        $this->app->bind(ImageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

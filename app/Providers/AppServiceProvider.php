<?php

namespace App\Providers;

use App\Modules\Generator\Services\ImageUploadService;
use Illuminate\Support\ServiceProvider;
use App\Modules\Generator\GeneratorModule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(GeneratorModule::class);

        $this->app->singleton(ImageUploadService::class, function () {
            return new ImageUploadService(config('app.imageBB.apiKey'), config('app.imageBB.apiHost'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

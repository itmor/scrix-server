<?php

namespace App\Providers;

use App\Modules\Generator\Services\FirebaseStorageService;
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

        $this->app->singleton(FirebaseStorageService::class, function () {
            return new FirebaseStorageService();
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

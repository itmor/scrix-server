<?php

namespace App\Providers;

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

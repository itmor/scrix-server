<?php

namespace App\Modules\Generator;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;


class GeneratorRoutingModule extends ServiceProvider
{
    protected $namespace = 'App\Modules\Generator\Controllers';

    public function map()
    {
        Route::prefix('generator')
            ->namespace($this->namespace . '\Generator')
            ->group(function() {
                /** @see GeneratorController::store() */
                Route::post('store', 'GeneratorController@store');
            });
    }
}

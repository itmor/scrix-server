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
            ->group(function () {
                /** @see GeneratorController::load() */
                Route::post('load', 'GeneratorController@load');
                /** @see GeneratorController::addResource() */
                Route::post('add_resource', 'GeneratorController@addResource');
                /** @see GeneratorController::getResource() */
                Route::post('get_resource', 'GeneratorController@getResource');
                /** @see GeneratorController::addImage() */
                Route::post('add_image', 'GeneratorController@addImage');
            });
    }
}

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
                /** @see GeneratorController::getImages) */
                Route::post('get_images', 'GeneratorController@getImages');
                /** @see GeneratorController::addResource() */
                Route::post('add_resource', 'GeneratorController@addResource');
                /** @see GeneratorController::getResource() */
                Route::post('get_resource', 'GeneratorController@getResource');
                /** @see GeneratorController::addImage() */
                Route::post('add_image', 'GeneratorController@addImage');
                /** @see GeneratorController::removeResource() */
                Route::post('remove_resource', 'GeneratorController@removeResource');
                /** @see GeneratorController::fixSession() */
                Route::post('fix_session', 'GeneratorController@fixSession');
                /** @see GeneratorController::downloadFile() */
                Route::get('download_file', 'GeneratorController@downloadFile');
            });
    }
}

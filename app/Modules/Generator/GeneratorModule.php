<?php

namespace App\Modules\Generator;

use Illuminate\Support\ServiceProvider;



class GeneratorModule extends ServiceProvider
{
    public function register()
    {
        $this->app->register(GeneratorRoutingModule::class);
    }

}

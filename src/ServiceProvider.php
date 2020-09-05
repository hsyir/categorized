<?php

namespace Hsy\Categories;

use Illuminate\Support\ServiceProvider as SP;

class ServiceProvider extends SP
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/categorize.php', 'categorize');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->publishes([__DIR__ . '/../config/categorize.php' => config_path('categorize.php'),], 'config');

        $this->publishes([
            __DIR__ . '/../database/' => database_path('migrations')
        ], 'migrations');
    }
}

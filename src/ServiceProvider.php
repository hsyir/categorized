<?php

namespace Hsy\Categorize;

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
        $this->mergeConfigFrom(__DIR__ . '/../config/categories.php', 'categories');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([__DIR__ . '/../config/categories.php' => config_path('categories.php'),], 'config');

        $this->publishes([
            __DIR__ . '/../database/' => database_path('migrations')
        ], 'migrations');
    }
}

<?php

namespace Hsy\Categorize;

use Illuminate\Support\ServiceProvider as SP;

class HsyCategorizeServiceProvider extends SP
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/categories.php', 'categories');

        $this->registerFacades();
        $this->registerConfigs();
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
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ], 'migrations');
    }

    private function registerFacades()
    {
        app()->singleton("Categorize",CategoryManager::class);
    }

    private function registerConfigs()
    {
        $this->mergeConfigFrom(__DIR__."/../config/categories.php","categorize");
    }
}

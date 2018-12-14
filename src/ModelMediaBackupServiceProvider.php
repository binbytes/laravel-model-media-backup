<?php

namespace BinBytes\ModelMediaBackup;

use BinBytes\ModelMediaBackup\Commands\ModelMediaBackup;
use Illuminate\Support\ServiceProvider;

class ModelMediaBackupServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'modelmediabackup');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/modelmediabackup.php', 'modelmediabackup');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modelmediabackup'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/modelmediabackup.php' => config_path('modelmediabackup.php'),
        ], 'modelmediabackup.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/modelmediabackup'),
        ], 'modelmediabackup.views');

        // Registering package commands.
        $this->commands([
            ModelMediaBackup::class
        ]);
    }
}

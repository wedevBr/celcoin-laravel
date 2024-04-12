<?php

namespace WeDevBr\Celcoin;

use Illuminate\Support\ServiceProvider;

class CelcoinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('celcoin.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'celcoin');

        // Register the card management class to use with the facade
        $this->app->singleton('celcoin', function () {
            return new Celcoin();
        });
    }
}

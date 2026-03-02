<?php

namespace Romeldev\SusaludX12;

use Illuminate\Support\ServiceProvider;
use Romeldev\SusaludX12\Services\SusaludX12Manager;

class SusaludX12ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/susalud-x12.php', 'susalud-x12');

        $this->app->singleton('susalud-x12', function () {
            return new SusaludX12Manager();
        });

        $this->app->alias('susalud-x12', SusaludX12Manager::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/susalud-x12.php' => config_path('susalud-x12.php'),
            ], 'susalud-x12-config');
        }
    }
}

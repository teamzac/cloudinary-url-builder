<?php

namespace TeamZac\Cloudinary;

use Cloudinary;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('cloudinary.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/cloudinary'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/cloudinary'),
            ], 'assets');*/
        }

        // set some defaults
        $this->bootCloudinaryConfig();
    }

    protected function bootCloudinaryConfig()
    {
        $config = [];

        if ($this->app->config['cloudinary.cloud_name']) {
            $config['cloud_name'] = $this->app->config['cloudinary.cloud_name'];
        }

        if (count($config)) {
            Cloudinary::config($config);
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'cloudinary');

        // Register the main class to use with the facade
        $this->app->singleton('cloudinary', function () {
            return new Cloudinary;
        });
    }
}

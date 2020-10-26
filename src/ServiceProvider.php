<?php

namespace TeamZac\Cloudinary;

use Cloudinary as BaseCloudinary;
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
            BaseCloudinary::config($config);
        }

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'cloudinary');
    }
}

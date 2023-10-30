<?php

namespace CarmineRumma\YousignLaravel;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class YousignLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind('yousign.laravel', function($app) {
        return new YousignLaravel();
      });
    }

}

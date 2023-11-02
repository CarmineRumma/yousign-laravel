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
      $this->publishes([
        __DIR__.'/../config/yousign.php' => config_path('yousign.php'),
      ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->mergeConfigFrom(
        __DIR__.'/../config/yousign.php', 'yousign'
      );

      $this->app->alias('yousign.laravel', YousignLaravel::class);

      $this->app->bind('yousign.laravel', function($app) {
        return new YousignLaravel();
      });
    }

}

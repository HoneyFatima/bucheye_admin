<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\services\productService;
use App\services\categoryServics;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\services\productService', function ($app) {
            return new productService();
        });
        $this->app->singleton('App\services\categoryServics', function ($app) {
            return new categoryServics();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $shareFrontend = [];
            $shareFrontend['noImage'] = config('web_default.frontend.noImage');
            $view->with('shareFrontend', $shareFrontend);
        });
    }
}

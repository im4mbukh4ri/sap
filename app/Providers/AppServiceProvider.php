<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        /**
         * Added manually for https access
         */
        $domain = Request::getHttpHost();
        if($domain == "adminlama.smartinpays.com"){
            URL::forceSchema('https');
        }
        //URL::forceSchema('https');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

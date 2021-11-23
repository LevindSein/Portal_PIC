<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $rand = "123456789";
        $rand = str_shuffle($rand);
        $rand = substr($rand, 0, 5);

        View::share('rand', $rand);

        $agent = new Agent();
        View::share('agent', $agent);
    }
}

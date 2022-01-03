<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;
use App\Models\Period;

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

        //Initialize Period
        $data = Period::exists();
        if(!$data){
            \Artisan::call('period:new');

            \Artisan::call('period:dayoff');
        }
        //End Initialize period
    }
}

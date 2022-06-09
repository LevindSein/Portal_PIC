<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Group;
use App\Models\Periode;

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
        view()->composer('*', function ($view)
        {
            if(Auth::check()){
                View::share('level', Auth::user()->level);
            }
        });

        if(Schema::hasTable('groups')){
            View::share('groups', Group::orderBy('nicename', 'asc')->get());
        }

        if(Schema::hasTable('periode')){
            View::share('periode', Periode::orderBy('name', 'desc')->get());
        }
    }
}

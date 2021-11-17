<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->stt_aktif == 0){
                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return Redirect('login')->with('error','Akun sudah dinonaktifkan.');
            }
            return $next($request);
        }
        else{
            return redirect('login')->with('warning', 'Silakan Login terlebih dahulu.');
        }
    }
}

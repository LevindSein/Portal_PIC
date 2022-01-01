<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\Period;

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
        //Auth Check
        if(Auth::check()){
            $response = $next($request);
            if(Auth::user()->active == 0){
                $temp = Session::get("_token");
                Session::flush();
                Session::put('_token', $temp);
                Auth::logout();
                return Redirect('login')->with('error','Account has been disabled.');
            }

            if(is_null($request->cookie('first_come'))){
                return $response->withCookie(cookie()->forever('first_come', Auth::user()->id));
            }
            else{
                $first_come = $request->cookie('first_come');
                $explode = explode(',',$first_come);
                if(in_array(Auth::user()->id, $explode))
                    return $response;
                else
                    return $response->withCookie(cookie()->forever('first_come', $first_come.','.Auth::user()->id));
            }
        }
        else{
            return redirect('login')->with('warning', 'Please login.');
        }
        //End Auth Check
    }
}

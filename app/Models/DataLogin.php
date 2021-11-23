<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Jenssegers\Agent\Agent;

class DataLogin extends Model
{
    use HasFactory;

    protected $table = 'data_login';
    protected $fillable = [
        'username',
        'name',
        'level',
        'active',
        'platform',
        'status'
    ];

    public static function success(){
        $agent = new Agent();

        $data['username'] = Auth::user()->username;
        $data['name'] = Auth::user()->name;
        $data['level'] = Auth::user()->level;
        $data['active'] = Auth::user()->active;
        $data['status'] = 1;
        $data['platform'] = $agent->platform()." ".$agent->version($agent->platform())." ".$agent->browser()." ".$agent->version($agent->browser());

        self::create($data);
    }

    public static function error(){
        $agent = new Agent();

        $data['username'] = Auth::user()->username;
        $data['name'] = Auth::user()->name;
        $data['level'] = Auth::user()->level;
        $data['active'] = Auth::user()->active;
        $data['status'] = 0;
        $data['platform'] = $agent->platform()." ".$agent->version($agent->platform())." ".$agent->browser()." ".$agent->version($agent->browser());

        self::create($data);
    }

    public static function anonym($request){
        $ip = \Request::ip();

        $agent = new Agent();

        $data['username'] = $ip;
        $data['name'] = $request->username;
        $data['status'] = 0;
        $data['platform'] = $agent->platform()." ".$agent->version($agent->platform())." ".$agent->browser()." ".$agent->version($agent->browser());

        self::create($data);
    }
}

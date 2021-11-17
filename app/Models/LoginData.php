<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Jenssegers\Agent\Agent;

class LoginData extends Model
{
    use HasFactory;

    protected $table = 'login_data';
    protected $fillable = [
        'username',
        'nama',
        'level',
        'stt_aktif',
        'platform',
        'status'
    ];

    public static function success(){
        $agent = new Agent();

        $data['username'] = Auth::user()->username;
        $data['nama'] = Auth::user()->name;
        $data['level'] = Auth::user()->level;
        $data['stt_aktif'] = Auth::user()->stt_aktif;
        $data['status'] = 1;
        $data['platform'] = $agent->platform()." ".$agent->version($agent->platform())." ".$agent->browser()." ".$agent->version($agent->browser());

        self::create($data);
    }

    public static function error(){
        $agent = new Agent();

        $data['username'] = Auth::user()->username;
        $data['nama'] = Auth::user()->name;
        $data['level'] = Auth::user()->level;
        $data['stt_aktif'] = Auth::user()->stt_aktif;
        $data['status'] = 0;
        $data['platform'] = $agent->platform()." ".$agent->version($agent->platform())." ".$agent->browser()." ".$agent->version($agent->browser());

        self::create($data);
    }

    public static function anonym(){
        $ip = \Request::ip();

        $agent = new Agent();

        $data['username'] = $ip;
        $data['nama'] = $ip;
        $data['status'] = 0;
        $data['platform'] = $agent->platform()." ".$agent->version($agent->platform())." ".$agent->browser()." ".$agent->version($agent->browser());

        self::create($data);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Identity extends Model
{
    use HasFactory;

    public static function make($type){
        if($type == 'uid'){
            $data = substr(str_shuffle(str_repeat("abcdefghkmnprstuwy",3)), 0, 5).mt_rand(111,999);
        }
        else if($type == 'member'){
            $data = 'BP3C'.mt_rand(11111111, 99999999);
        }
        else if($type == 'password'){
            $data = mt_rand(11111111, 99999999);
        }

        if(User::where($type, $data)->exists())
            return self::make($type);
        else
            return $data;
    }
}

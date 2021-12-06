<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\TListrik;
use App\Models\TAirBersih;

class Identity extends Model
{
    use HasFactory;

    public static function make($type){
        if($type == 'uid'){
            $data = substr(str_shuffle(str_repeat("abcdefghkmnprstuwy",3)), 0, 5).mt_rand(111,999);
        }
        else if($type == 'member'){
            $data = 'BP3C'.mt_rand(00000001, 99999999);
        }
        else if($type == 'password'){
            $data = mt_rand(00000001, 99999999);
        }

        if(User::where($type, $data)->exists())
            return self::make($type);
        else
            return $data;
    }

    public static function listrikCode(){
        $data = 'ML'.mt_rand(00001, 99999);
        if(TListrik::where('code', $data)->exists())
            return self::listrikCode();
        else
            return $data;
    }

    public static function airBersihCode(){
        $data = 'MA'.mt_rand(00001, 99999);
        if(TAirBersih::where('code', $data)->exists())
            return self::listrikCode();
        else
            return $data;
    }
}

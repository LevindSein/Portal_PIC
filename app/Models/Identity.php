<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Identity extends Model
{
    use HasFactory;

    public static function make($type){
        if($type == 'username'){
            $data = "aabbccddeeffgghhkkmmnnppqqrrssttwwyy2233445566778899";
            $data = str_shuffle($data);
            $data = substr($data, 0, 8);
        }
        else if($type == 'member'){
            $data = "11223344556677889900";
            $data = str_shuffle($data);
            $data = substr($data, 0, 8);
        }
        else if($type == 'password'){
            $data = "111222333444555666777888999";
            $data = str_shuffle($data);
            $data = substr($data, 0, 8);
            return $data;
        }

        $user = User::where($type, $data)->count();
        if($user != 0)
            return self::make($type);
        else
            return $data;
    }
}

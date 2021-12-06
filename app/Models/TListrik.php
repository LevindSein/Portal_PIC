<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TListrik extends Model
{
    use HasFactory;
    protected $table = 't_listrik';
    protected $fillable = [
        'code',
        'name',
        'meter',
        'power',
        'data'
    ];

    public static function available($data){
        if($data == 1){
            $data = "<span class='text-success'>Tersedia</span>";
        }
        else{
            $data = "<span class='text-danger'>Digunakan</span>";
        }
        return $data;
    }

    public static function paid($data){
        if($data == 1){
            $data = "<span class='text-success>Dibayar</span>";
        }
        else{
            $data = "<span class='text-info'>Idle</span>";
        }
        return $data;
    }
}

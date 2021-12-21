<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PLain extends Model
{
    use HasFactory;
    protected $table = 'p_lain';
    protected $fillable = [
        'name',
        'price',
        'satuan',
        'data'
    ];

    public static function satuan($data){
        return ($data == 2) ? "per-Los" : "per-Kontrol";
    }

    public static function tagihan($tarif, $jml){
        $tarif = self::find($tarif);

        if($tarif->satuan == 2){
            return $tarif->price * $jml;
        }
        else{
            return $tarif->price;
        }
    }
}

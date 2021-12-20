<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKebersihan extends Model
{
    use HasFactory;
    protected $table = 'p_kebersihan';
    protected $fillable = [
        'name',
        'price',
        'data'
    ];

    public static function tagihan($tarif, $jml){
        $tarif = self::find($tarif);

        return $tarif->price * $jml;
    }
}

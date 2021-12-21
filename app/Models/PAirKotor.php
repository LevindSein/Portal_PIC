<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAirKotor extends Model
{
    use HasFactory;
    protected $table = 'p_airkotor';
    protected $fillable = [
        'name',
        'price',
        'data'
    ];

    public static function tagihan($tarif){
        $tarif = self::find($tarif);

        return $tarif->price;
    }
}

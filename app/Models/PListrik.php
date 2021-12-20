<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PListrik extends Model
{
    use HasFactory;

    protected $table = 'p_listrik';
    protected $fillable = [
        'name',
        'data'
    ];

    public static function tagihan($tarif, $awal, $akhir, $daya){
        $tarif = self::find($tarif);
        $tarif = json_decode($tarif->data);

        $pakai = $akhir - $awal;

        $standar = round(($daya * $tarif->standar) / 1000);
        $blok1 = $tarif->blok1 * $standar;

        $blok2 = $pakai - $standar;
        $blok2 = $tarif->blok2 * $blok2;

        $beban = $daya * $tarif->beban;

        $sub = $blok1 + $blok2 + $beban;

        $pju = ($tarif->pju / 100) * $sub;

        $total = $sub + $pju;

        return $total;
    }
}

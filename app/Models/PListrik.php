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

        $pakai = self::pakai($awal, $akhir);

        $standar = self::standar($tarif->standar, $daya);

        $blok1 = self::blok1($tarif->blok1, $standar);

        $blok2 = self::blok2($tarif->blok2, $pakai, $standar);

        $beban = self::beban($tarif->beban, $daya);

        $sub = $blok1 + $blok2 + $beban;

        $pju = self::pju($tarif->pju, $sub);

        $total = $sub + $pju;

        $ppn = self::ppn($tarif->ppn, $total);

        $tagihan = $total + $ppn;

        return $tagihan;
    }

    public static function pakai($awal, $akhir){
        return $akhir - $awal;
    }

    public static function standar($standar, $daya){
        return ceil(($standar * $daya) / 1000);
    }

    public static function blok1($blok1, $standar){
        return $blok1 * $standar;
    }

    public static function blok2($blok2, $pakai, $standar){
        return $blok2 * ($pakai - $standar);
    }

    public static function beban($beban, $daya){
        return $beban * $daya;
    }

    public static function pju($pju, $sub){
        return ceil(($pju / 100) * $sub);
    }

    public static function ppn($ppn, $total){
        return ceil(($ppn / 100) * $total);
    }
}

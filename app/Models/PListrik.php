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

        $rekmin = self::rekmin($tarif->rekmin, $standar, $pakai, $daya);

        $blok1 = self::blok1($tarif->blok1, $standar, $rekmin);

        $blok2 = self::blok2($tarif->blok2, $standar, $pakai, $rekmin);

        $beban = self::beban($tarif->beban, $daya, $rekmin);

        $sub = $blok1 + $blok2 + $beban + $rekmin;

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
        return round(($standar * $daya) / 1000);
    }

    public static function rekmin($rekmin, $standar, $pakai, $daya){
        if($pakai >= $standar){
            return 0;
        } else {
            return round($rekmin * $daya);
        }
    }

    public static function blok1($blok1, $standar, $rekmin){
        if($rekmin > 0){
            return 0;
        } else {
            return $blok1 * $standar;
        }
    }

    public static function blok2($blok2, $standar, $pakai, $rekmin){
        if($rekmin > 0){
            return 0;
        } else {
            return $blok2 * ($pakai - $standar);
        }
    }

    public static function beban($beban, $daya, $rekmin){
        if($rekmin > 0){
            return 0;
        } else {
            return $beban * $daya;
        }
    }

    public static function pju($pju, $sub){
        return ceil(($pju / 100) * $sub);
    }

    public static function ppn($ppn, $total){
        return round(($ppn / 100) * $total);
    }
}

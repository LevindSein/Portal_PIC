<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAirBersih extends Model
{
    use HasFactory;
    protected $table = 'p_airbersih';
    protected $fillable = [
        'name',
        'data'
    ];

    public static function tagihan($tarif, $awal, $akhir){
        $tarif = self::find($tarif);
        $tarif = json_decode($tarif->data);

        $pakai = self::pakai($awal, $akhir);

        $bayar = self::bayar($pakai, $tarif->tarif1, $tarif->tarif2);

        $pemeliharaan = self::pemeliharaan($tarif->pemeliharaan);

        $beban = self::beban($tarif->beban);

        $airkotor = self::arkot($tarif->airkotor, $bayar);

        $total = $bayar + $pemeliharaan + $beban + $airkotor;

        $ppn = self::ppn($tarif->ppn, $total);

        $tagihan = $total + $ppn;

        return $tagihan;
    }

    public static function pakai($awal, $akhir){
        return $akhir - $awal;
    }

    public static function bayar($pakai, $tarif1, $tarif2){
        if($pakai > 10){
            $tarif1 = 10 * $tarif1;
            $tarif2 = ($pakai - 10) * $tarif2;
            $bayar = $tarif1 + $tarif2;
        }
        else{
            $bayar = $pakai * $tarif1;
        }
        return $bayar;
    }

    public static function pemeliharaan($pemeliharaan){
        return $pemeliharaan;
    }

    public static function beban($beban){
        return $beban;
    }

    public static function arkot($arkot, $bayar){
        return ($arkot / 100) * $bayar;
    }

    public static function ppn($ppn, $total){
        return ($ppn / 100) * $total;
    }
}

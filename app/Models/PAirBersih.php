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

        $pakai = $akhir - $awal;

        if($pakai > 10){
            $tarif1 = 10 * $tarif->tarif1;
            $tarif2 = ($pakai - 10) * $tarif->tarif2;
            $bayar = $tarif1 + $tarif2;

            $pemeliharaan = $tarif->pemeliharaan;
            $beban = $tarif->beban;
            $airkotor = ($tarif->airkotor / 100) * $bayar;

            $total = $bayar + $pemeliharaan + $beban + $airkotor;
        }
        else{
            $bayar = $pakai * $tarif->tarif1;

            $pemeliharaan = $tarif->pemeliharaan;
            $beban = $tarif->beban;
            $airkotor = ($tarif->airkotor / 100) * $bayar;

            $total = $bayar + $pemeliharaan + $beban + $airkotor;
        }

        return $total;
    }
}

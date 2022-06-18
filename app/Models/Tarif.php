<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Tarif extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tarif';

    protected $fillable = [
        'name',
        'level',
        'data',
        'status'
    ];

    public function getDataAttribute($value) {
        return json_decode($value);
    }

    public function getStatusAttribute($value) {
        if($value == 1)
            return 'per-Kontrol';
        else
            return 'per-Los';
    }

    protected static $ignoreChangedAttributes = ['data', 'updated_at'];
    protected static $logName = 'tarif';
    protected static $logAttributes = [
        'name',
        'level'
    ];

    public static function level($val) {
        switch ($val) {
            case 1:
                return 'Listrik';
                break;
            case 2:
                return 'Air Bersih';
                break;
            case 3:
                return 'Keamanan & IPK';
                break;
            case 4:
                return 'Kebersihan';
                break;
            case 5:
                return 'Air Kotor';
                break;
            default:
                return 'Lainnya';
                break;
        }
    }

    public static function tagihanL($tarif, $pakai, $daya, $diff, $diskon){
        $standar = self::standarL($tarif->Standar_Operasional, $daya);

        $blok1 = self::blok1L($tarif->Tarif_Blok_1, $standar);

        $blok2 = self::blok2L($tarif->Tarif_Blok_2, $pakai, $standar);

        $rekmin = self::rekminL($tarif->Tarif_Rekmin, $daya);

        $beban = self::bebanL($tarif->Tarif_Beban, $daya);

        $sub = $blok1 + $blok2 + $beban;

        $pju = self::pjuL($tarif->PJU, $sub);

        if($tarif->Tarif_Rekmin > 0){
            $batas = round(18 * $daya /1000);
            if($pakai <= $batas){
                $pju = self::pjuL($tarif->PJU, $rekmin);
                $blok1 = 0;
                $blok2 = 0;
                $beban = 0;
            }
            else{
                $rekmin = 0;
            }
        } else {
            $rekmin = 0;
        }

        $subtotal = $pju + $blok1 + $blok2 + $beban + $rekmin;

        $ppn = self::ppnL($tarif->PPN, $subtotal);

        $total = $subtotal + $ppn;

        $diskon = round(($diskon / 100) * $total);

        if($daya > 4400){
            $denda = round(($diff * ($tarif->Denda_2 / 100)) * $total);
        } else {
            $denda = $diff * $tarif->Denda_1;
        }

        $total = round($total + $denda - $diskon);

        return [
            'pakai'     => $pakai,
            'standar'   => $standar,
            'blok1'     => $blok1,
            'blok2'     => $blok2,
            'rekmin'    => $rekmin,
            'beban'     => $beban,
            'pju'       => $pju,
            'subtotal'  => $subtotal,
            'ppn'       => $ppn,
            'denda'     => $denda,
            'diskon'    => $diskon,
            'total'     => $total
        ];
    }

    public static function pakaiL($awal, $akhir){
        return $akhir - $awal;
    }

    public static function standarL($standar, $daya){
        return round(($standar * $daya) / 1000);
    }

    public static function blok1L($blok1, $standar){
        return $blok1 * $standar;
    }

    public static function blok2L($blok2, $pakai, $standar){
        return $blok2 * ($pakai - $standar);
    }

    public static function rekminL($rekmin, $daya){
        return $rekmin * $daya;
    }

    public static function bebanL($beban, $daya){
        return $beban * $daya;
    }

    public static function pjuL($pju, $sub){
        return round(($pju / 100) * $sub);
    }

    public static function ppnL($ppn, $total){
        return round(($ppn / 100) * $total);
    }
}

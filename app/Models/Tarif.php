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

    protected static $logName = 'tarif';
    protected static $logAttributes = [
        'name',
        'level',
        'data.Tarif',
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

    //BEGIN Listrik
    public static function listrik($tarif_id, $pakai, $daya, $diff, $diskon){
        $tarif = self::find($tarif_id)->data;

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

        $ppn = self::ppn($tarif->PPN, $subtotal);

        $total = $subtotal + $ppn;

        $diskon = round(($diskon / 100) * $total);

        if($daya > 4400){
            $denda = round(($diff * ($tarif->Denda_2 / 100)) * $total);
        } else {
            $denda = $diff * $tarif->Denda_1;
        }

        $total = $total + $denda - $diskon;

        return json_encode([
            'pakai'     => (int)$pakai,
            'standar'   => (int)$standar,
            'blok1'     => (int)$blok1,
            'blok2'     => (int)$blok2,
            'rekmin'    => (int)$rekmin,
            'beban'     => (int)$beban,
            'pju'       => (int)$pju,
            'subtotal'  => (int)$subtotal,
            'ppn'       => (int)$ppn,
            'denda'     => (int)$denda,
            'diskon'    => (int)$diskon,
            'total'     => (int)$total,
        ]);
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
    //END Listrik

    //BEGIN Air Bersih
    public static function airbersih($tarif_id, $pakai, $diff, $diskon){
        $tarif = self::find($tarif_id)->data;

        $bayar = self::bayar($pakai, $tarif->Tarif_1, $tarif->Tarif_2);

        $pemeliharaan = self::pemeliharaan($tarif->Tarif_Pemeliharaan);

        $beban = self::bebanAB($tarif->Tarif_Beban);

        $airkotor = self::arkot($tarif->Tarif_Air_Kotor, $bayar);

        $subtotal = $bayar + $pemeliharaan + $beban + $airkotor;

        $ppn = self::ppn($tarif->PPN, $subtotal);

        $total = $subtotal + $ppn;

        $diskon = round(($diskon / 100) * $total);

        $denda = $diff * $tarif->Denda;

        $total = $total + $denda - $diskon;

        return json_encode([
            'pakai'         => (int)$pakai,
            'bayar'         => (int)$bayar,
            'pemeliharaan'  => (int)$pemeliharaan,
            'beban'         => (int)$beban,
            'airkotor'      => (int)$airkotor,
            'subtotal'      => (int)$subtotal,
            'ppn'           => (int)$ppn,
            'denda'         => (int)$denda,
            'diskon'        => (int)$diskon,
            'total'         => (int)$total
        ]);
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

    public static function bebanAB($beban){
        return $beban;
    }

    public static function arkot($arkot, $bayar){
        return round(($arkot / 100) * $bayar);
    }
    //END Air Bersih

    public static function pakai($awal, $akhir){
        return $akhir - $awal;
    }

    public static function ppn($ppn, $subtotal){
        return round(($ppn / 100) * $subtotal);
    }

    //BEGIN Keamanan IPK
    public static function keamananipk($tarif_id, $jml_los, $diskon){
        $tarif = self::find($tarif_id)->data;

        $persen = self::persenKI($tarif->Tarif, $tarif->Persen_Keamanan);

        $keamanan = $persen['keamanan'] * $jml_los;
        $ipk = $persen['ipk'] * $jml_los;

        $subtotal = ($keamanan + $ipk);

        $total = $subtotal - $diskon;

        return json_encode([
            'keamanan'      => (int)$keamanan,
            'ipk'           => (int)$ipk,
            'subtotal'      => (int)$subtotal,
            'diskon'        => (int)$diskon,
            'total'         => (int)$total
        ]);
    }

    public static function persenKI($tarif, $persen){
        $keamanan = ($tarif * ($persen / 100));
        $ipk = $tarif - $keamanan;
        return [
            'keamanan'  => $keamanan,
            'ipk'       => $ipk
        ];
    }
    //END Keamanan IPK

    //BEGIN Kebersihan
    public static function kebersihan($tarif_id, $jml_los, $diskon){
        $tarif = self::find($tarif_id)->data;

        $subtotal = $tarif->Tarif * $jml_los;

        $total = $subtotal - $diskon;

        return json_encode([
            'subtotal'      => (int)$subtotal,
            'diskon'        => (int)$diskon,
            'total'         => (int)$total
        ]);
    }
    //END Kebersihan

    //BEGIN Air Kotor
    public static function airkotor($tarif_id, $jml_los, $diskon){
        $tarif = self::find($tarif_id)->data;

        if($tarif->status == 'per-Los'){
            $subtotal = $tarif->Tarif * $jml_los;
        } else {
            $subtotal = $tarif->Tarif;
        }

        $total = $subtotal - $diskon;

        return json_encode([
            'subtotal'      => (int)$subtotal,
            'diskon'        => (int)$diskon,
            'total'         => (int)$total
        ]);
    }
    //END Air Kotor

    //BEGIN Lainnya
    public static function lainnya($tarif_id, $jml_los){
        $tarif = self::find($tarif_id)->data;

        if($tarif->status == 'per-Los'){
            $subtotal = $tarif->Tarif * $jml_los;
        } else {
            $subtotal = $tarif->Tarif;
        }

        $total = $subtotal;

        return json_encode([
            'subtotal'      => (int)$subtotal,
            'total'         => (int)$total
        ]);
    }
    //END Lainnya
}

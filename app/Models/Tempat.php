<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Tempat extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tempat';

    protected $fillable = [
        'name',
        'nicename',
        'group_id',
        'los',
        'jml_los',
        'pengguna_id',
        'pemilik_id',
        'alat_listrik_id',
        'alat_airbersih_id',
        'trf_listrik_id',
        'trf_airbersih_id',
        'trf_keamananipk_id',
        'trf_kebersihan_id',
        'trf_airkotor_id',
        'trf_lainnya_id',
        'diskon',
        'ket',
        'status'
    ];

    protected static $logName = 'tempat';
    protected static $logAttributes = [
        'name',
        'group.name',
        'jml_los',
        'pengguna.name',
        'pemilik.name',
        'listrik.name',
        'airbersih.name',
        'keamananipk.name',
        'kebersihan.name',
        'airkotor.name',
        'diskon.listrik',
        'diskon.airbersih',
        'diskon.keamananipk',
        'diskon.kebersihan',
        'diskon.airkotor',
        'ket',
        'status',
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'tempat_id');
    }

    public function alatListrik()
    {
        return $this->belongsTo(Alat::class, 'alat_listrik_id');
    }

    public function alatAirBersih()
    {
        return $this->belongsTo(Alat::class, 'alat_airbersih_id');
    }

    public function listrik()
    {
        return $this->belongsTo(Tarif::class, 'trf_listrik_id');
    }

    public function airbersih()
    {
        return $this->belongsTo(Tarif::class, 'trf_airbersih_id');
    }

    public function keamananipk()
    {
        return $this->belongsTo(Tarif::class, 'trf_keamananipk_id');
    }

    public function kebersihan()
    {
        return $this->belongsTo(Tarif::class, 'trf_kebersihan_id');
    }

    public function airkotor()
    {
        return $this->belongsTo(Tarif::class, 'trf_airkotor_id');
    }

    // public function lainnya()
    // {
    //     return $this->belongsTo(Tarif::class, 'trf_lainnya_id->lainnya_id');
    // }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id')->withDefault([
            'id' => null,
            'name' => '-'
        ]);
    }

    public function pemilik(){
        return $this->belongsTo(User::class, 'pemilik_id')->withDefault([
            'id' => null,
            'name' => '-'
        ]);
    }

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function getLosAttribute($value){
        return json_decode($value);
    }

    public function getDiskonAttribute($value){
        return json_decode($value);
    }

    public function getTrfLainnyaIdAttribute($value){
        return json_decode($value);
    }

    public static function generate($group, $los){
        $kontrol = "";
        if(is_numeric($los) == TRUE){
            if($los < 10){
                $kontrol = $group."-"."00".$los;
            }
            else if($los < 100){
                $kontrol = $group."-"."0".$los;
            }
            else{
                $kontrol = $group."-".$los;
            }
        }
        else{
            $num = 0;
            $strnum = 0;
            for($i=0; $i < strlen($los); $i++){
                if (is_numeric($los[$i]) == TRUE){
                    $num++;
                }
                else{
                    $strnum = 1;
                    break;
                }
            }

            if($num == 1){
                $kontrol = $group."-"."00".$los;
            }
            else if($num == 2){
                $kontrol = $group."-"."0".$los;
            }
            else if($num >= 3 || $strnum == 1){
                $kontrol = $group."-".$los;
            }
        }
        return $kontrol;
    }

    public static function status($value){
        switch($value){
            case 2:
                return 'Bebas Bayar';
                break;
            case 1:
                return 'Aktif';
                break;
            default:
                return 'Nonaktif';
                break;
        }
    }
}

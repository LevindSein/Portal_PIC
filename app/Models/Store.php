<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $fillable = [
        'kd_kontrol',
        'nicename',
        'group',
        'no_los',
        'jml_los',
        'id_pengguna',
        'id_pemilik',
        'komoditi',
        'status',
        'ket',
        'info',
        'id_tlistrik',
        'id_tairbersih',
        'fas_listrik',
        'fas_airbersih',
        'fas_keamananipk',
        'fas_kebersihan',
        'fas_airkotor',
        'fas_lain',
        'data'
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna')->withDefault([
            'id' => null,
            'name' => '-'
        ]);
    }

    public function pemilik(){
        return $this->belongsTo(User::class, 'id_pemilik')->withDefault([
            'id' => null,
            'name' => '-'
        ]);
    }

    public function tlistrik()
    {
        return $this->belongsTo(TListrik::class, 'id_tlistrik')->withDefault([
            'name' => '-'
        ]);
    }

    public function plistrik()
    {
        return $this->belongsTo(PListrik::class, 'fas_listrik');
    }

    public function tairbersih()
    {
        return $this->belongsTo(TAirBersih::class, 'id_tairbersih')->withDefault([
            'name' => '-'
        ]);
    }

    public function pairbersih()
    {
        return $this->belongsTo(PAirBersih::class, 'fas_airbersih');
    }

    public function pkeamananipk()
    {
        return $this->belongsTo(PKeamananIpk::class, 'fas_keamananipk');
    }

    public function pkebersihan()
    {
        return $this->belongsTo(PKebersihan::class, 'fas_kebersihan');
    }

    public function pairkotor()
    {
        return $this->belongsTo(PAirKotor::class, 'fas_airkotor');
    }

    public static function status($data){
        if($data === 2){
            return '<span class="text-info">Bebas Bayar</span>';
        }
        else if($data == 1){
            return '<span class="text-success">Aktif</span>';
        }
        else if($data == 0){
            return '<span class="text-danger">Nonaktif</span>';
        }
        else{
            return $data;
        }
    }

    public static function kontrol($group, $los){
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

    public static function penggunaDeletePermanent($id)
    {
        $existing = self::find($id);
        $existing->id_pengguna = NULL;
        $existing->save();
    }

    public static function pemilikDeletePermanent($id)
    {
        $existing = self::find($id);
        $existing->id_pemilik = NULL;
        $existing->save();
    }
}

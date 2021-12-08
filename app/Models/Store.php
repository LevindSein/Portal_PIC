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
        'lokasi',
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
            'name' => '-'
        ]);
    }

    public function pemilik(){
        return $this->belongsTo(User::class, 'id_pemilik')->withDefault([
            'name' => '-'
        ]);
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

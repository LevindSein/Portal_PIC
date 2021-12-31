<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $table = 'bills';
    protected $fillable = [
        'code',
        'id_period',
        'stt_publish',
        'stt_lunas',
        'name',
        'kd_kontrol',
        'nicename',
        'group',
        'no_los',
        'jml_los',
        'code_tlistrik',
        'code_tairbersih',
        'b_listrik',
        'b_airbersih',
        'b_keamananipk',
        'b_kebersihan',
        'b_airkotor',
        'b_lain',
        'b_tagihan',
        'data',
        'active',
        'deleted'
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'id_period');
    }

    public static function publish($data){
        if($data == 1){
            return '<span class="text-success">Published</span>';
        }
        else if($data == 0){
            return '<span class="text-danger">Unpublished</span>';
        }
        else{
            return $data;
        }
    }

    public static function lunas($data){
        if($data == 1){
            return '<span class="text-success">Lunas</span>';
        }
        else if($data == 0){
            return '<span class="text-danger">Belum Lunas</span>';
        }
        else{
            return $data;
        }
    }

    public static function syncById($id){
        $bill = self::find($id);

        $lunas = 1;
        $sub_tagihan = 0;
        $denda = 0;
        $diskon = 0;
        $ttl_tagihan = 0;
        $rea_tagihan = 0;
        $sel_tagihan = 0;

        if($bill->b_listrik){
            $json = json_decode($bill->b_listrik);

            $lunas *= $json->lunas;
            $sub_tagihan += $json->sub_tagihan;
            $denda += $json->denda;
            $diskon += $json->diskon;
            $ttl_tagihan += $json->ttl_tagihan;
            $rea_tagihan += $json->rea_tagihan;
            $sel_tagihan += $json->sel_tagihan;
        }

        if($bill->b_airbersih){
            $json = json_decode($bill->b_airbersih);

            $lunas *= $json->lunas;
            $sub_tagihan += $json->sub_tagihan;
            $denda += $json->denda;
            $diskon += $json->diskon;
            $ttl_tagihan += $json->ttl_tagihan;
            $rea_tagihan += $json->rea_tagihan;
            $sel_tagihan += $json->sel_tagihan;
        }

        if($bill->b_keamananipk){
            $json = json_decode($bill->b_keamananipk);

            $lunas *= $json->lunas;
            $sub_tagihan += $json->sub_tagihan;
            $diskon += $json->diskon;
            $ttl_tagihan += $json->ttl_tagihan;
            $rea_tagihan += $json->rea_tagihan;
            $sel_tagihan += $json->sel_tagihan;
        }

        if($bill->b_kebersihan){
            $json = json_decode($bill->b_kebersihan);

            $lunas *= $json->lunas;
            $sub_tagihan += $json->sub_tagihan;
            $diskon += $json->diskon;
            $ttl_tagihan += $json->ttl_tagihan;
            $rea_tagihan += $json->rea_tagihan;
            $sel_tagihan += $json->sel_tagihan;
        }

        if($bill->b_airkotor){
            $json = json_decode($bill->b_airkotor);

            $lunas *= $json->lunas;
            $sub_tagihan += $json->sub_tagihan;
            $diskon += $json->diskon;
            $ttl_tagihan += $json->ttl_tagihan;
            $rea_tagihan += $json->rea_tagihan;
            $sel_tagihan += $json->sel_tagihan;
        }

        if($bill->b_lain){
            $json = json_decode($bill->b_lain);

            foreach ($json as $i => $val) {
                $lunas *= $val->lunas;
                $sub_tagihan += $val->sub_tagihan;
                $ttl_tagihan += $val->ttl_tagihan;
                $rea_tagihan += $val->rea_tagihan;
                $sel_tagihan += $val->sel_tagihan;
            }
        }

        $bill->stt_lunas = $lunas;

        $json = json_decode($bill->b_tagihan);
        $json->lunas = $lunas;
        $json->sub_tagihan = $sub_tagihan;
        $json->denda = $denda;
        $json->diskon = $diskon;
        $json->ttl_tagihan = $ttl_tagihan;
        $json->rea_tagihan = $rea_tagihan;
        $json->sel_tagihan  = $sel_tagihan;
        $bill->b_tagihan = json_encode($json);
        $bill->save();
    }
}

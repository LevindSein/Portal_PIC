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
        'nonactive'
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
}

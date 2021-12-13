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
        'stt_bayar',
        'stt_lunas',
        'name',
        'kd_kontrol',
        'group',
        'no_los',
        'jml_los',
        'b_listrik',
        'b_airbersih',
        'b_keamananipk',
        'b_kebersihan',
        'b_airkotor',
        'b_lain',
        'b_tagihan',
        'data'
    ];
}

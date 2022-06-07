<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Tagihan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tagihan';
    protected $fillable = [
        'code',
        'periode_id',
        'stt_publish',
        'stt_lunas',
        'name',
        'kontrol',
        'nicename',
        'group_id',
        'los',
        'jml_los',
        'code_listrik',
        'code_airbersih',
        'listrik',
        'airbersih',
        'keamananipk',
        'kebersihan',
        'airkotor',
        'lainnya',
        'tagihan',
        'status'
    ];

    public function getListrikAttribute($value){
        return json_decode($value);
    }

    public function getAirbersihAttribute($value){
        return json_decode($value);
    }

    public function getKeamananipkAttribute($value){
        return json_decode($value);
    }

    public function getKebersihanAttribute($value){
        return json_decode($value);
    }

    public function getAirKotorAttribute($value){
        return json_decode($value);
    }

    public function getLainnyaAttribute($value){
        return json_decode($value);
    }

    protected static $logName = 'tagihan';
    protected static $logFillable = true;
}
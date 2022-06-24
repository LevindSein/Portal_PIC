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
        'nicename',
        'pengguna_id',
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

    protected static $logName = 'tagihan';
    protected static $logAttributes = [
        'name',
        'pengguna.name',
        'jml_los',
        'listrik.awal',
        'listrik.akhir',
        'listrik.total',
        'airbersih.awal',
        'airbersih.akhir',
        'airbersih.total',
        'keamananipk.jml_los',
        'keamananipk.total',
        'kebersihan.jml_los',
        'kebersihan.total',
        'airkotor.jml_los',
        'airkotor.total',
        'lainnya.jml_los',
        'lainnya.total',
        'tagihan.total'
    ];

    public function getLosAttribute($value){
        return json_decode($value);
    }

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

    public function getAirkotorAttribute($value){
        return json_decode($value);
    }

    public function getLainnyaAttribute($value){
        return json_decode($value);
    }

    public function getTagihanAttribute($value){
        return json_decode($value);
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public static function code(){
        return hexdec(uniqid("333")); //333 = Tagihan
    }
}

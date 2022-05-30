<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Alat extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'alat';

    protected $fillable = [
        'code',
        'name',
        'level',
        'stand',
        'daya',
        'status',
    ];

    protected static $logName = 'alat';
    protected static $logFillable = true;

    public static function code(){
        return hexdec(uniqid("222")); //222 = Alat
    }
}

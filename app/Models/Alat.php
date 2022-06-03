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

    public function getStatusAttribute($value) {
        switch ($value) {
            case 1:
                return 'Tersedia';
                break;
            default:
                return 'Digunakan';
                break;
        }
    }

    public static function level($val) {
        switch ($val) {
            case 1:
                return 'Listrik';
                break;
            default:
                return 'Air Bersih';
                break;
        }
    }
}

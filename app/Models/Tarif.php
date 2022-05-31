<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Tarif extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tarif';

    protected $fillable = [
        'name',
        'level',
        'data'
    ];

    protected static $logName = 'tarif';
    protected static $logFillable = true;

    public static function level($val) {
        switch ($val) {
            case 1:
                return 'Listrik';
                break;
            case 2:
                return 'Air Bersih';
                break;
            case 3:
                return 'Keamanan & IPK';
                break;
            case 4:
                return 'Kebersihan';
                break;
            case 5:
                return 'Air Kotor';
                break;
            default:
                return 'Lainnya';
                break;
        }
    }
}

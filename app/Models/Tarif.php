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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Group extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'nicename',
        'data'
    ];

    protected static $logName = 'groups';
    protected static $logFillable = true;
}

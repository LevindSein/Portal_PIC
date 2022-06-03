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
        'blok',
        'nomor',
        'data',
        'terpakai',
        'available'
    ];

    protected static $ignoreChangedAttributes = ['data', 'terpakai', 'available', 'updated_at'];
    protected static $logName = 'groups';
    protected static $logAttributes = [
        'name',
        'nicename',
        'blok',
        'nomor'
    ];
}

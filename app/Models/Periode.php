<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Periode extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'periode';

    protected $fillable = [
        'name',
        'nicename',
        'new',
        'due',
        'year',
        'faktur',
        'surat',
        'status'
    ];

    protected static $logName = 'groups';
    protected static $logFillable = true;
}

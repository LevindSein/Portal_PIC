<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    use HasFactory;

    protected $table = 'change_logs';
    protected $fillable = [
        'release_date',
        'release_str',
        'data',
    ];
}

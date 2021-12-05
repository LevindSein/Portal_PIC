<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKeamananIpk extends Model
{
    use HasFactory;
    protected $table = 'p_keamananipk';
    protected $fillable = [
        'name',
        'price',
        'data'
    ];
}

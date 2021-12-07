<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TAirBersih extends Model
{
    use HasFactory;
    protected $table = 't_airbersih';
    protected $fillable = [
        'code',
        'name',
        'meter',
        'stt_available',
        'data'
    ];
}

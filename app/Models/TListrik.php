<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TListrik extends Model
{
    use HasFactory;
    protected $table = 't_listrik';
    protected $fillable = [
        'code',
        'name',
        'meter',
        'power',
        'data'
    ];
}

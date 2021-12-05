<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PLain extends Model
{
    use HasFactory;
    protected $table = 'p_lain';
    protected $fillable = [
        'name',
        'price',
        'data'
    ];
}

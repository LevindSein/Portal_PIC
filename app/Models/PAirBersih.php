<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAirBersih extends Model
{
    use HasFactory;
    protected $table = 'p_airbersih';
    protected $fillable = [
        'name',
        'data'
    ];
}

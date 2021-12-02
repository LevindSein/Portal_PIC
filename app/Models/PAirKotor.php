<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAirKotor extends Model
{
    use HasFactory;
    protected $table = 'p_airkotor';
    protected $fillable = [
        'name',
        'data'
    ];
}

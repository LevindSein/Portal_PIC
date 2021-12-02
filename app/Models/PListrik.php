<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PListrik extends Model
{
    use HasFactory;

    protected $table = 'p_listrik';
    protected $fillable = [
        'name',
        'data'
    ];
}

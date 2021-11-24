<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{
    use HasFactory;

    protected $table = 'activation_code';
    protected $fillable = [
        'code',
        'available',
        'user_id',
        'submit',
    ];
}

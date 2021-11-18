<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeAktivasi extends Model
{
    use HasFactory;

    protected $table = 'kode_aktivasi';
    protected $fillable = [
        'kode',
        'available',
        'user_id',
        'submit',
    ];
}

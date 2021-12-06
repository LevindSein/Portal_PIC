<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Shops extends Model
{
    use HasFactory;
    protected $table = 'shops';
    protected $fillable = [
        'kd_kontrol',
        'blok',
        'no_los',
        'jml_los',
        'id_pengguna',
        'id_pemilik',
        'stt_tempat',
        'usaha',
        'fas_listrik',
        'fas_airbersih',
        'fas_keamananipk',
        'fas_kebersihan',
        'fas_airkotor',
        'fas_lain',
        'data'
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}

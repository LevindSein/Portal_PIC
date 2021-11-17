<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'users';
    protected $fillable = [
        'username',
        'name',
        'level',
        'phone',
        'email',
        'anggota',
        'ktp',
        'npwp',
        'alamat',
        'otoritas',
        'stt_aktif',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function level($data){
        if($data == 1){
            return 'Super Admin';
        }
        else if($data == 2){
            return 'Admin';
        }
        else if($data == 3){
            return 'Nasabah';
        }
        else if($data == 4){
            return 'Kasir';
        }
        else if($data == 5){
            return 'Keuangan';
        }
        else if($data == 6){
            return 'Manajer';
        }
        else{
            return $data;
        }
    }

    public static function sttAktif($data){
        if($data === 0){
            return '<span class="text-danger">Nonaktif</span>';
        }
        else if($data == 1){
            return '<span class="text-success">Aktif</span>';
        }
        else if($data == 2){
            return '<span class="text-info">Proses Pendaftaran</span>';
        }
        else{
            return $data;
        }
    }
}

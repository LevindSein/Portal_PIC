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
        'photo',
        'uid',
        'name',
        'level',
        'country_id',
        'phone',
        'email',
        'member',
        'ktp',
        'npwp',
        'address',
        'authority',
        'active',
        'password',
        'nonactive',
        'activation_code',
        'available',
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
            return 'Organisator';
        }
        else if($data == 3){
            return 'Nasabah';
        }
        else{
            return $data;
        }
    }

    public static function active($data){
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

    public function pengguna(){
        return $this->hasMany(Store::class, 'id_pengguna');
    }

    public function pemilik(){
        return $this->hasMany(Store::class, 'id_pemilik');
    }
}

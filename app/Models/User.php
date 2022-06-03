<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Activitylog\Traits\LogsActivity;

use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticationLoggable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'phone',
        'member',
        'ktp',
        'npwp',
        'address',
        'email',
        'password',
        'level',
        'otoritas',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $ignoreChangedAttributes = ['password', 'otoritas', 'updated_at'];
    protected static $logName = 'users';
    protected static $logAttributes = [
        'username',
        'name',
        'phone',
        'member',
        'ktp',
        'npwp',
        'address',
        'email',
        'level',
        'status'
    ];

    public function getOtoritasAttribute($value) {
        return json_decode($value);
    }

    public static function level($val) {
        switch ($val) {
            case 1:
                return 'Super';
                break;
            case 2:
                return 'Admin';
                break;
            case 3:
                return 'Kasir';
                break;
            case 4:
                return 'Keuangan';
                break;
            case 5:
                return 'Manajer';
                break;
            case 6:
                return 'Nasabah';
                break;
            default:
                return 'Semua';
                break;
        }
    }

    public static function badgeLevel($val) {
        switch ($val) {
            case 1:
                return 'badge-success';
                break;
            case 2:
                return 'badge-success';
                break;
            case 3:
                return 'badge-info';
                break;
            case 4:
                return 'badge-warning';
                break;
            case 5:
                return 'badge-primary';
                break;
            case 6:
                return 'badge-danger';
                break;
            default:
                return 'badge-danger';
                break;
        }
    }

    public static function status($val) {
        if(is_numeric($val)){
            if($val == 1){
                return 'Aktif';
            } else {
                return 'Nonaktif';
            }
        } else {
            return 'Semua';
        }
    }

    public static function code(){
        return hexdec(uniqid("333")); //333 = Pedagang
    }
}

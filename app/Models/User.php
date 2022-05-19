<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AuthenticationLoggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
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

    public static function level(int $val) {
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
            default:
                return 'Manajer';
                break;
        }
    }

    public static function badgeLevel(int $val) {
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
            default:
                return 'badge-primary';
                break;
        }
    }
}

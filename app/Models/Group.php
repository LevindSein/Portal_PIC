<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'nicename',
        'blok',
        'nomor',
        'data'
    ];

    public function tempat() {
        return $this->hasMany(Tempat::class, 'group_id');
    }

    public function tagihan() {
        return $this->hasMany(Tagihan::class, 'group_id');
    }
}

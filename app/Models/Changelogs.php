<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changelogs extends Model
{
    use HasFactory;

    protected $table = 'changelogs';

    protected $fillable = [
        'code',
        'times',
        'title',
        'data',
        'causer_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public static function code(){
        return hexdec(uniqid("111")); //111 = Changelogs
    }
}

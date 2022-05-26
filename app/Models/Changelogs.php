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
        $data = mt_rand(000000000000001, 999999999999999);

        if(self::where('code', $data)->exists())
            return self::code();
        else
            return $data;
    }
}

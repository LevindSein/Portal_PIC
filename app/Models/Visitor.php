<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitors';
    protected $fillable = [
        'visit_per_day',
        'day_count',
        'visit_on_day'
    ];

    public static function visitOnDay(){
        $data = self::first();
        if(is_null($data)){
            \Artisan::call('visitor:run');
        }
        else{
            $data->increment('visit_on_day');
        }
    }
}

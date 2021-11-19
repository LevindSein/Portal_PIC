<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $table = 'visitor';
    protected $fillable = [
        'visit_per_day',
        'day_count',
        'visit_on_day'
    ];

    public static function visitOnDay(){
        $data = self::first();
        $data->visit_on_day++;
        $data->save();
    }
}

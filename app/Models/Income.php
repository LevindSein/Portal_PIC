<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Period;
use Carbon\Carbon;

class Income extends Model
{
    use HasFactory;

    protected $table = 'income';
    protected $fillable = [
        'code',
        'faktur',
        'id_period',
        'kd_kontrol',
        'nicename',
        'pengguna',
        'info',
        'tagihan',
        'ids_tagihan',
        'active',
    ];

    public static function make($type){
        $data = '';
        if($type == 'code'){
            $data = substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNPQRSTUWXYZ",3)), 0, 10);

            if(self::where($type, $data)->exists()) return self::make($type);
        }
        else if($type == 'faktur'){
            $period = Period::where('name', Carbon::now()->format('Y-m'))->first();
            $period->faktur++;

            $nomor = $period->faktur;

            if($nomor < 10)
                $nomor = '000'.$nomor;
            else if($nomor >= 10 && $nomor < 100)
                $nomor = '00'.$nomor;
            else if($nomor >= 100 && $nomor < 1000)
                $nomor = '0'.$nomor;
            else
                $nomor = $nomor;

            $data = $nomor . '/' . str_replace('-', '/', Carbon::now()->format('Y-m-d'));

            $period->save();

            if(self::where($type, $data)->exists()) return self::make($type);
        }
        else if($type == 'period'){
            $period = Period::where('name', Carbon::now()->format('Y-m'))->first();
            $data = $period->id;
        }

        return $data;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Tempat extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tempat';

    protected $fillable = [
        'name',
        'nicename',
        'new',
        'due',
        'year',
        'faktur',
        'surat',
        'status'
    ];

    protected static $logName = 'tempat';
    protected static $logFillable = true;

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id')->withDefault([
            'id' => null,
            'name' => '-'
        ]);
    }

    public function pemilik(){
        return $this->belongsTo(User::class, 'pemilik_id')->withDefault([
            'id' => null,
            'name' => '-'
        ]);
    }

    public static function generate($group, $los){
        $kontrol = "";
        if(is_numeric($los) == TRUE){
            if($los < 10){
                $kontrol = $group."-"."00".$los;
            }
            else if($los < 100){
                $kontrol = $group."-"."0".$los;
            }
            else{
                $kontrol = $group."-".$los;
            }
        }
        else{
            $num = 0;
            $strnum = 0;
            for($i=0; $i < strlen($los); $i++){
                if (is_numeric($los[$i]) == TRUE){
                    $num++;
                }
                else{
                    $strnum = 1;
                    break;
                }
            }

            if($num == 1){
                $kontrol = $group."-"."00".$los;
            }
            else if($num == 2){
                $kontrol = $group."-"."0".$los;
            }
            else if($num >= 3 || $strnum == 1){
                $kontrol = $group."-".$los;
            }
        }
        return $kontrol;
    }
}

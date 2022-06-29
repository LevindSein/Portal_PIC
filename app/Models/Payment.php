<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tagihan;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'name',
        'nicename',
        'los',
        'jml_los',
        'pengguna_id',
        'ket',
        'tagihan_ids',
        'tagihan'
    ];

    public function getTagihanIdsAttribute($value){
        return json_decode($value);
    }

    public function pengguna(){
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public static function sync($kontrol){
        //Check kontrol sudah ada di payment atau belum
        if(self::where('name', $kontrol)->exists()){
            //Apabila sudah ada di Payment
        } else {
            //Apabila tidak ada di Payment
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Tagihan;

class Payment extends Model
{
    use HasFactory;

    private $kontrol;

    public function __construct($kontrol = '')
    {
        $this->kontrol   = $kontrol;
    }

    protected $table = 'payments';

    protected $fillable = [
        'name',
        'nicename',
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

    public function __toString()
    {
        return "Payment updated.";
    }
}

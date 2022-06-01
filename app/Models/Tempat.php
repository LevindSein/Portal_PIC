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
}

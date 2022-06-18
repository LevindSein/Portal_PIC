<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

use Carbon\Carbon;

class Periode extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'periode';

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

    protected static $logName = 'periode';
    protected static $logFillable = true;

    public static function diffInMonth($periode)
    {
        $diff = 0;
        $now = Carbon::now()->format('Y-m-d');
        foreach (Periode::where('due', '>=', $periode->due)->get() as $key) {
            if($now >= new Carbon($key->due)){
                $diff++;
            }
        }

        return $diff;
    }
}

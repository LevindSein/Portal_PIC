<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;

class Tagihan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tagihan';
    protected $fillable = [
        'code',
        'periode_id',
        'stt_publish',
        'stt_lunas',
        'name',
        'nicename',
        'pengguna_id',
        'group_id',
        'los',
        'jml_los',
        'code_listrik',
        'code_airbersih',
        'listrik',
        'airbersih',
        'keamananipk',
        'kebersihan',
        'airkotor',
        'lainnya',
        'tagihan',
        'status'
    ];

    protected static $logName = 'tagihan';
    protected static $logAttributes = [
        'name',
        'pengguna.name',
        'jml_los',
        'tagihan.total'
    ];

    public function getLosAttribute($value){
        return json_decode($value);
    }

    public function getListrikAttribute($value){
        return json_decode($value);
    }

    public function getAirbersihAttribute($value){
        return json_decode($value);
    }

    public function getKeamananipkAttribute($value){
        return json_decode($value);
    }

    public function getKebersihanAttribute($value){
        return json_decode($value);
    }

    public function getAirkotorAttribute($value){
        return json_decode($value);
    }

    public function getLainnyaAttribute($value){
        return json_decode($value);
    }

    public function getTagihanAttribute($value){
        return json_decode($value);
    }

    public function pengguna(){
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function periode(){
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }

    public static function code(){
        return hexdec(uniqid("333")); //333 = Tagihan
    }

    public static function single($tempat_id, $periode_id){
        $data = Tempat::with('alatListrik', 'alatAirBersih', 'listrik')->find($tempat_id);

        $dataset['code'] = self::code();
        $dataset['periode_id'] = $periode_id;
        $dataset['name'] = $data->name;
        $dataset['nicename'] = $data->nicename;
        $dataset['pengguna_id'] = $data->pengguna_id;
        $dataset['group_id'] = $data->group_id;
        $dataset['los'] = json_encode($data->los);
        $dataset['jml_los'] = $data->jml_los;

        $diff_month = Periode::diffInMonth($periode_id);

        $subtotal = 0;
        $ppn = 0;
        $denda = 0;
        $diskon = 0;
        $total = 0;

        if($data->listrik){
            $pakai = 0;
            $disc = 0;
            $reset = 0;

            if($data->alatListrik->old > $data->alatListrik->stand){
                $pakai = (str_repeat(9, strlen($data->alatListrik->old)) - $data->alatListrik->old) + $data->alatListrik->stand;
                $reset = 1;
            } else {
                $pakai = $data->alatListrik->stand - $data->alatListrik->old;
            }

            if(!empty($data->diskon->listrik)){
                $disc = $data->diskon->listrik;
            }

            $tagihan = Tarif::listrik($data->trf_listrik_id, $pakai, $data->alatListrik->daya, $diff_month, $disc);

            $tagihan = json_decode($tagihan);

            $listrik['lunas'] = 0;
            $listrik['kasir'] = null;
            $listrik['tarif'] = $data->trf_listrik_id;
            $listrik['alat']  = $data->alat_listrik_id;
            $listrik['daya']  = $data->alatListrik->daya;
            $listrik['awal']  = $data->alatListrik->old;
            $listrik['akhir'] = $data->alatListrik->stand;
            $listrik['reset'] = $reset;
            $listrik['pakai'] = $pakai;
            $listrik['standar'] = $tagihan->standar;
            $listrik['blok1'] = $tagihan->blok1;
            $listrik['blok2'] = $tagihan->blok2;
            $listrik['rekmin'] = $tagihan->rekmin;
            $listrik['beban'] = $tagihan->beban;
            $listrik['pju'] = $tagihan->pju;
            $listrik['subtotal'] = $tagihan->subtotal;
            $listrik['ppn'] = $tagihan->ppn;
            $listrik['denda'] = $tagihan->denda;
            $listrik['diskon'] = $tagihan->diskon;
            $listrik['total'] = $tagihan->total;
            $listrik['realisasi'] = 0;
            $listrik['selisih'] = $tagihan->total;

            $dataset['listrik'] = json_encode($listrik);

            $subtotal += $tagihan->subtotal;
            $ppn += $tagihan->ppn;
            $denda += $tagihan->denda;
            $diskon += $tagihan->diskon;
            $total += $tagihan->total;
        }

        $dataset['tagihan'] = json_encode([
            'subtotal'  => $subtotal,
            'ppn'       => $ppn,
            'denda'     => $denda,
            'diskon'    => $diskon,
            'total'     => $total,
            'realisasi' => 0,
            'selisih'   => $total
        ]);

        self::create($dataset);
    }
}

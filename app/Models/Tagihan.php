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

    public static function singleCreate($tempat_id, $periode_id){
        $data = Tempat::with('alatListrik', 'alatAirBersih', 'listrik', 'airbersih', 'keamananipk', 'kebersihan', 'airkotor')->find($tempat_id);

        $dataset['code']        = self::code();
        $dataset['periode_id']  = $periode_id;
        $dataset['name']        = $data->name;
        $dataset['nicename']    = $data->nicename;
        $dataset['group_id']    = $data->group_id;
        $dataset['pengguna_id'] = $data->pengguna_id;
        $dataset['los']         = json_encode($data->los);
        $dataset['jml_los']     = $data->jml_los;

        $diff_month = Periode::diffInMonth($periode_id);

        $subtotal = 0;
        $ppn      = 0;
        $denda    = 0;
        $diskon   = 0;
        $total    = 0;

        if($data->listrik){
            $pakai = 0;
            $disc  = 0;
            $reset = 0;

            if($data->alatListrik->old > $data->alatListrik->stand){
                $pakai = (str_repeat(9, strlen($data->alatListrik->old)) - $data->alatListrik->old) + $data->alatListrik->stand + 1;
                $reset = 1;
            } else {
                $pakai = $data->alatListrik->stand - $data->alatListrik->old;
            }

            if(!empty($data->diskon->listrik)){
                $disc = $data->diskon->listrik;
            }

            $tagihan = Tarif::listrik($data->trf_listrik_id, $pakai, $data->alatListrik->daya, $diff_month, $disc);

            $tagihan = json_decode($tagihan);

            $listrik['lunas']     = 0;
            $listrik['kasir']     = null;
            $listrik['tarif']     = $data->trf_listrik_id;
            $listrik['alat']      = $data->alat_listrik_id;
            $listrik['daya']      = $data->alatListrik->daya;
            $listrik['awal']      = $data->alatListrik->old;
            $listrik['akhir']     = $data->alatListrik->stand;
            $listrik['reset']     = $reset;
            $listrik['pakai']     = $pakai;
            $listrik['standar']   = $tagihan->standar;
            $listrik['blok1']     = $tagihan->blok1;
            $listrik['blok2']     = $tagihan->blok2;
            $listrik['rekmin']    = $tagihan->rekmin;
            $listrik['beban']     = $tagihan->beban;
            $listrik['pju']       = $tagihan->pju;
            $listrik['subtotal']  = $tagihan->subtotal;
            $listrik['ppn']       = $tagihan->ppn;
            $listrik['denda']     = $tagihan->denda;
            $listrik['diskon']    = $tagihan->diskon;
            $listrik['total']     = $tagihan->total;
            $listrik['realisasi'] = 0;
            $listrik['selisih']   = $tagihan->total;

            $dataset['listrik']   = json_encode($listrik);

            $subtotal += $tagihan->subtotal;
            $ppn      += $tagihan->ppn;
            $denda    += $tagihan->denda;
            $diskon   += $tagihan->diskon;
            $total    += $tagihan->total;
        }

        if($data->airbersih){
            $pakai = 0;
            $disc  = 0;
            $reset = 0;

            if($data->alatAirBersih->old > $data->alatAirBersih->stand){
                $pakai = (str_repeat(9, strlen($data->alatAirBersih->old)) - $data->alatAirBersih->old) + $data->alatAirBersih->stand + 1;
                $reset = 1;
            } else {
                $pakai = $data->alatAirBersih->stand - $data->alatAirBersih->old;
            }

            if(!empty($data->diskon->airbersih)){
                $disc = $data->diskon->airbersih;
            }

            $tagihan = Tarif::airbersih($data->trf_airbersih_id, $pakai, $diff_month, $disc);

            $tagihan = json_decode($tagihan);

            $airbersih['lunas']        = 0;
            $airbersih['kasir']        = null;
            $airbersih['tarif']        = $data->trf_airbersih_id;
            $airbersih['alat']         = $data->alat_airbersih_id;
            $airbersih['awal']         = $data->alatAirBersih->old;
            $airbersih['akhir']        = $data->alatAirBersih->stand;
            $airbersih['reset']        = $reset;
            $airbersih['pakai']        = $pakai;
            $airbersih['bayar']        = $tagihan->bayar;
            $airbersih['pemeliharaan'] = $tagihan->pemeliharaan;
            $airbersih['beban']        = $tagihan->beban;
            $airbersih['airkotor']     = $tagihan->airkotor;
            $airbersih['subtotal']     = $tagihan->subtotal;
            $airbersih['ppn']          = $tagihan->ppn;
            $airbersih['denda']        = $tagihan->denda;
            $airbersih['diskon']       = $tagihan->diskon;
            $airbersih['total']        = $tagihan->total;
            $airbersih['realisasi']    = 0;
            $airbersih['selisih']      = $tagihan->total;

            $dataset['airbersih']      = json_encode($airbersih);

            $subtotal += $tagihan->subtotal;
            $ppn      += $tagihan->ppn;
            $denda    += $tagihan->denda;
            $diskon   += $tagihan->diskon;
            $total    += $tagihan->total;
        }

        if($data->keamananipk){
            $disc  = 0;

            if(!empty($data->diskon->keamananipk)){
                $disc = $data->diskon->keamananipk;
            }

            $tagihan = Tarif::keamananipk($data->trf_keamananipk_id, $data->jml_los, $disc);

            $tagihan = json_decode($tagihan);

            $keamananipk['lunas']     = 0;
            $keamananipk['kasir']     = null;
            $keamananipk['tarif']     = $data->trf_keamananipk_id;
            $keamananipk['jml_los']   = $data->jml_los;
            $keamananipk['keamanan']  = $tagihan->keamanan;
            $keamananipk['ipk']       = $tagihan->ipk;
            $keamananipk['subtotal']  = $tagihan->subtotal;
            $keamananipk['diskon']    = $tagihan->diskon;
            $keamananipk['total']     = $tagihan->total;
            $keamananipk['realisasi'] = 0;
            $keamananipk['selisih']   = $tagihan->total;

            $dataset['keamananipk']   = json_encode($keamananipk);

            $subtotal += $tagihan->subtotal;
            $diskon   += $tagihan->diskon;
            $total    += $tagihan->total;
        }

        if($data->kebersihan){
            $disc  = 0;

            if(!empty($data->diskon->kebersihan)){
                $disc = $data->diskon->kebersihan;
            }

            $tagihan = Tarif::kebersihan($data->trf_kebersihan_id, $data->jml_los, $disc);

            $tagihan = json_decode($tagihan);

            $kebersihan['lunas']     = 0;
            $kebersihan['kasir']     = null;
            $kebersihan['tarif']     = $data->trf_kebersihan_id;
            $kebersihan['jml_los']   = $data->jml_los;
            $kebersihan['subtotal']  = $tagihan->subtotal;
            $kebersihan['diskon']    = $tagihan->diskon;
            $kebersihan['total']     = $tagihan->total;
            $kebersihan['realisasi'] = 0;
            $kebersihan['selisih']   = $tagihan->total;

            $dataset['kebersihan']   = json_encode($kebersihan);

            $subtotal += $tagihan->subtotal;
            $diskon   += $tagihan->diskon;
            $total    += $tagihan->total;
        }

        if($data->airkotor){
            $disc  = 0;

            if(!empty($data->diskon->airkotor)){
                $disc = $data->diskon->airkotor;
            }

            $tagihan = Tarif::airkotor($data->trf_airkotor_id, $data->jml_los, $disc);

            $tagihan = json_decode($tagihan);

            $airkotor['lunas']     = 0;
            $airkotor['kasir']     = null;
            $airkotor['tarif']     = $data->trf_airkotor_id;
            $airkotor['jml_los']   = $data->jml_los;
            $airkotor['subtotal']  = $tagihan->subtotal;
            $airkotor['diskon']    = $tagihan->diskon;
            $airkotor['total']     = $tagihan->total;
            $airkotor['realisasi'] = 0;
            $airkotor['selisih']   = $tagihan->total;

            $dataset['airkotor']   = json_encode($airkotor);

            $subtotal += $tagihan->subtotal;
            $diskon   += $tagihan->diskon;
            $total    += $tagihan->total;
        }

        if($data->trf_lainnya_id){
            $lainnya['lunas'] = 0;
            $lainnya['kasir'] = null;

            $subtotal_lainnya = 0;
            $total_lainnya    = 0;
            $data_lainnya     = [];

            $lains = $data->trf_lainnya_id;
            foreach ($lains as $item) {
                $d = json_decode(Tarif::lainnya($item, $data->jml_los));
                $data_lainnya[] = [
                    'tarif' => $item,
                    'total' => $d->total
                ];

                $subtotal_lainnya += $d->subtotal;
                $total_lainnya    += $d->total;
            }
            $lainnya['data']      = $data_lainnya;
            $lainnya['jml_los']   = $data->jml_los;
            $lainnya['subtotal']  = $subtotal_lainnya;
            $lainnya['total']     = $total_lainnya;
            $lainnya['realisasi'] = 0;
            $lainnya['selisih']   = $total_lainnya;

            $dataset['lainnya']   = json_encode($lainnya);

            $subtotal += $subtotal_lainnya;
            $total    += $total_lainnya;
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

    public static function singleUpdate($tagihan_id, $periode_id){
        $tagihan_data = self::findOrFail($tagihan_id);
        $data = Tempat::where('name', $tagihan_data->name)->with('alatListrik', 'alatAirBersih', 'listrik', 'airbersih', 'keamananipk', 'kebersihan', 'airkotor')->first();

        $dataset['pengguna_id'] = $data->pengguna_id;
        $dataset['los']         = json_encode($data->los);
        $dataset['jml_los']     = $data->jml_los;

        $diff_month = Periode::diffInMonth($periode_id);

        $subtotal  = 0;
        $ppn       = 0;
        $denda     = 0;
        $diskon    = 0;
        $total     = 0;
        $realisasi = 0;
        $selisih   = 0;

        if($data->listrik){
            if($tagihan_data->listrik && $tagihan_data->listrik->lunas){
                $subtotal  += $tagihan_data->listrik->subtotal;
                $ppn       += $tagihan_data->listrik->ppn;
                $denda     += $tagihan_data->listrik->denda;
                $diskon    += $tagihan_data->listrik->diskon;
                $total     += $tagihan_data->listrik->total;
                $realisasi += $tagihan_data->listrik->realisasi;
                $selisih   += $tagihan_data->listrik->selisih;
            } else {
                $pakai = 0;
                $disc  = 0;
                $reset = 0;

                if($data->alatListrik->old > $data->alatListrik->stand){
                    $pakai = (str_repeat(9, strlen($data->alatListrik->old)) - $data->alatListrik->old) + $data->alatListrik->stand + 1;
                    $reset = 1;
                } else {
                    $pakai = $data->alatListrik->stand - $data->alatListrik->old;
                }

                if(!empty($data->diskon->listrik)){
                    $disc = $data->diskon->listrik;
                }

                $tagihan = Tarif::listrik($data->trf_listrik_id, $pakai, $data->alatListrik->daya, $diff_month, $disc);

                $tagihan = json_decode($tagihan);

                $listrik['lunas']     = 0;
                $listrik['kasir']     = null;
                $listrik['tarif']     = $data->trf_listrik_id;
                $listrik['alat']      = $data->alat_listrik_id;
                $listrik['daya']      = $data->alatListrik->daya;
                $listrik['awal']      = $data->alatListrik->old;
                $listrik['akhir']     = $data->alatListrik->stand;
                $listrik['reset']     = $reset;
                $listrik['pakai']     = $pakai;
                $listrik['standar']   = $tagihan->standar;
                $listrik['blok1']     = $tagihan->blok1;
                $listrik['blok2']     = $tagihan->blok2;
                $listrik['rekmin']    = $tagihan->rekmin;
                $listrik['beban']     = $tagihan->beban;
                $listrik['pju']       = $tagihan->pju;
                $listrik['subtotal']  = $tagihan->subtotal;
                $listrik['ppn']       = $tagihan->ppn;
                $listrik['denda']     = $tagihan->denda;
                $listrik['diskon']    = $tagihan->diskon;
                $listrik['total']     = $tagihan->total;
                $listrik['realisasi'] = 0;
                $listrik['selisih']   = $tagihan->total;

                $dataset['listrik']   = json_encode($listrik);

                $subtotal  += $tagihan->subtotal;
                $ppn       += $tagihan->ppn;
                $denda     += $tagihan->denda;
                $diskon    += $tagihan->diskon;
                $total     += $tagihan->total;
                $realisasi += 0;
                $selisih   += $tagihan->total;
            }
        } else {
            if($tagihan_data->listrik && $tagihan_data->listrik->lunas){
                $subtotal  += $tagihan_data->listrik->subtotal;
                $ppn       += $tagihan_data->listrik->ppn;
                $denda     += $tagihan_data->listrik->denda;
                $diskon    += $tagihan_data->listrik->diskon;
                $total     += $tagihan_data->listrik->total;
                $realisasi += $tagihan_data->listrik->realisasi;
                $selisih   += $tagihan_data->listrik->selisih;
            } else {
                $dataset['listrik'] = null;
            }
        }

        if($data->airbersih){
            if($tagihan_data->airbersih && $tagihan_data->airbersih->lunas){
                $subtotal  += $tagihan_data->airbersih->subtotal;
                $ppn       += $tagihan_data->airbersih->ppn;
                $denda     += $tagihan_data->airbersih->denda;
                $diskon    += $tagihan_data->airbersih->diskon;
                $total     += $tagihan_data->airbersih->total;
                $realisasi += $tagihan_data->airbersih->realisasi;
                $selisih   += $tagihan_data->airbersih->selisih;
            } else {
                $pakai = 0;
                $disc  = 0;
                $reset = 0;

                if($data->alatAirBersih->old > $data->alatAirBersih->stand){
                    $pakai = (str_repeat(9, strlen($data->alatAirBersih->old)) - $data->alatAirBersih->old) + $data->alatAirBersih->stand + 1;
                    $reset = 1;
                } else {
                    $pakai = $data->alatAirBersih->stand - $data->alatAirBersih->old;
                }

                if(!empty($data->diskon->airbersih)){
                    $disc = $data->diskon->airbersih;
                }

                $tagihan = Tarif::airbersih($data->trf_airbersih_id, $pakai, $diff_month, $disc);

                $tagihan = json_decode($tagihan);

                $airbersih['lunas']        = 0;
                $airbersih['kasir']        = null;
                $airbersih['tarif']        = $data->trf_airbersih_id;
                $airbersih['alat']         = $data->alat_airbersih_id;
                $airbersih['awal']         = $data->alatAirBersih->old;
                $airbersih['akhir']        = $data->alatAirBersih->stand;
                $airbersih['reset']        = $reset;
                $airbersih['pakai']        = $pakai;
                $airbersih['bayar']        = $tagihan->bayar;
                $airbersih['pemeliharaan'] = $tagihan->pemeliharaan;
                $airbersih['beban']        = $tagihan->beban;
                $airbersih['airkotor']     = $tagihan->airkotor;
                $airbersih['subtotal']     = $tagihan->subtotal;
                $airbersih['ppn']          = $tagihan->ppn;
                $airbersih['denda']        = $tagihan->denda;
                $airbersih['diskon']       = $tagihan->diskon;
                $airbersih['total']        = $tagihan->total;
                $airbersih['realisasi']    = 0;
                $airbersih['selisih']      = $tagihan->total;

                $dataset['airbersih']      = json_encode($airbersih);

                $subtotal  += $tagihan->subtotal;
                $ppn       += $tagihan->ppn;
                $denda     += $tagihan->denda;
                $diskon    += $tagihan->diskon;
                $total     += $tagihan->total;
                $realisasi += 0;
                $selisih   += $tagihan->total;
            }
        } else {
            if($tagihan_data->airbersih && $tagihan_data->airbersih->lunas){
                $subtotal  += $tagihan_data->airbersih->subtotal;
                $ppn       += $tagihan_data->airbersih->ppn;
                $denda     += $tagihan_data->airbersih->denda;
                $diskon    += $tagihan_data->airbersih->diskon;
                $total     += $tagihan_data->airbersih->total;
                $realisasi += $tagihan_data->airbersih->realisasi;
                $selisih   += $tagihan_data->airbersih->selisih;
            } else {
                $dataset['airbersih'] = null;
            }
        }

        if($data->keamananipk){
            if($tagihan_data->keamananipk && $tagihan_data->keamananipk->lunas){
                $subtotal  += $tagihan_data->keamananipk->subtotal;
                $diskon    += $tagihan_data->keamananipk->diskon;
                $total     += $tagihan_data->keamananipk->total;
                $realisasi += $tagihan_data->keamananipk->realisasi;
                $selisih   += $tagihan_data->keamananipk->selisih;
            } else {
                $disc  = 0;

                if(!empty($data->diskon->keamananipk)){
                    $disc = $data->diskon->keamananipk;
                }

                $tagihan = Tarif::keamananipk($data->trf_keamananipk_id, $data->jml_los, $disc);

                $tagihan = json_decode($tagihan);

                $keamananipk['lunas']     = 0;
                $keamananipk['kasir']     = null;
                $keamananipk['tarif']     = $data->trf_keamananipk_id;
                $keamananipk['jml_los']   = $data->jml_los;
                $keamananipk['keamanan']  = $tagihan->keamanan;
                $keamananipk['ipk']       = $tagihan->ipk;
                $keamananipk['subtotal']  = $tagihan->subtotal;
                $keamananipk['diskon']    = $tagihan->diskon;
                $keamananipk['total']     = $tagihan->total;
                $keamananipk['realisasi'] = 0;
                $keamananipk['selisih']   = $tagihan->total;

                $dataset['keamananipk']   = json_encode($keamananipk);

                $subtotal  += $tagihan->subtotal;
                $diskon    += $tagihan->diskon;
                $total     += $tagihan->total;
                $realisasi += 0;
                $selisih   += $tagihan->total;
            }
        } else {
            if($tagihan_data->keamananipk && $tagihan_data->keamananipk->lunas){
                $subtotal  += $tagihan_data->keamananipk->subtotal;
                $diskon    += $tagihan_data->keamananipk->diskon;
                $total     += $tagihan_data->keamananipk->total;
                $realisasi += $tagihan_data->keamananipk->realisasi;
                $selisih   += $tagihan_data->keamananipk->selisih;
            } else {
                $dataset['keamananipk'] = null;
            }
        }

        if($data->kebersihan){
            if($tagihan_data->kebersihan && $tagihan_data->kebersihan->lunas){
                $subtotal  += $tagihan_data->kebersihan->subtotal;
                $diskon    += $tagihan_data->kebersihan->diskon;
                $total     += $tagihan_data->kebersihan->total;
                $realisasi += $tagihan_data->kebersihan->realisasi;
                $selisih   += $tagihan_data->kebersihan->selisih;
            } else {
                $disc  = 0;

                if(!empty($data->diskon->kebersihan)){
                    $disc = $data->diskon->kebersihan;
                }

                $tagihan = Tarif::kebersihan($data->trf_kebersihan_id, $data->jml_los, $disc);

                $tagihan = json_decode($tagihan);

                $kebersihan['lunas']     = 0;
                $kebersihan['kasir']     = null;
                $kebersihan['tarif']     = $data->trf_kebersihan_id;
                $kebersihan['jml_los']   = $data->jml_los;
                $kebersihan['subtotal']  = $tagihan->subtotal;
                $kebersihan['diskon']    = $tagihan->diskon;
                $kebersihan['total']     = $tagihan->total;
                $kebersihan['realisasi'] = 0;
                $kebersihan['selisih']   = $tagihan->total;

                $dataset['kebersihan']   = json_encode($kebersihan);

                $subtotal  += $tagihan->subtotal;
                $diskon    += $tagihan->diskon;
                $total     += $tagihan->total;
                $realisasi += 0;
                $selisih   += $tagihan->total;
            }
        } else {
            if($tagihan_data->kebersihan && $tagihan_data->kebersihan->lunas){
                $subtotal  += $tagihan_data->kebersihan->subtotal;
                $diskon    += $tagihan_data->kebersihan->diskon;
                $total     += $tagihan_data->kebersihan->total;
                $realisasi += $tagihan_data->kebersihan->realisasi;
                $selisih   += $tagihan_data->kebersihan->selisih;
            } else {
                $dataset['kebersihan'] = null;
            }
        }

        if($data->airkotor){
            if($tagihan_data->airkotor && $tagihan_data->airkotor->lunas){
                $subtotal  += $tagihan_data->airkotor->subtotal;
                $diskon    += $tagihan_data->airkotor->diskon;
                $total     += $tagihan_data->airkotor->total;
                $realisasi += $tagihan_data->airkotor->realisasi;
                $selisih   += $tagihan_data->airkotor->selisih;
            } else {
                $disc  = 0;

                if(!empty($data->diskon->airkotor)){
                    $disc = $data->diskon->airkotor;
                }

                $tagihan = Tarif::airkotor($data->trf_airkotor_id, $data->jml_los, $disc);

                $tagihan = json_decode($tagihan);

                $airkotor['lunas']     = 0;
                $airkotor['kasir']     = null;
                $airkotor['tarif']     = $data->trf_airkotor_id;
                $airkotor['jml_los']   = $data->jml_los;
                $airkotor['subtotal']  = $tagihan->subtotal;
                $airkotor['diskon']    = $tagihan->diskon;
                $airkotor['total']     = $tagihan->total;
                $airkotor['realisasi'] = 0;
                $airkotor['selisih']   = $tagihan->total;

                $dataset['airkotor']   = json_encode($airkotor);

                $subtotal  += $tagihan->subtotal;
                $diskon    += $tagihan->diskon;
                $total     += $tagihan->total;
                $realisasi += 0;
                $selisih   += $tagihan->total;
            }
        } else {
            if($tagihan_data->airkotor && $tagihan_data->airkotor->lunas){
                $subtotal  += $tagihan_data->airkotor->subtotal;
                $diskon    += $tagihan_data->airkotor->diskon;
                $total     += $tagihan_data->airkotor->total;
                $realisasi += $tagihan_data->airkotor->realisasi;
                $selisih   += $tagihan_data->airkotor->selisih;
            } else {
                $dataset['airkotor'] = null;
            }
        }

        if($data->trf_lainnya_id){
            if($tagihan_data->lainnya && $tagihan_data->lainnya->lunas){
                $subtotal  += $tagihan_data->lainnya->subtotal;
                $total     += $tagihan_data->lainnya->total;
                $realisasi += $tagihan_data->lainnya->realisasi;
                $selisih   += $tagihan_data->lainnya->selisih;
            } else {
                $lainnya['lunas'] = 0;
                $lainnya['kasir'] = null;

                $subtotal_lainnya = 0;
                $total_lainnya    = 0;
                $data_lainnya     = [];

                $lains = $data->trf_lainnya_id;
                foreach ($lains as $item) {
                    $d = json_decode(Tarif::lainnya($item, $data->jml_los));
                    $data_lainnya[] = [
                        'tarif' => $item,
                        'total' => $d->total
                    ];

                    $subtotal_lainnya += $d->subtotal;
                    $total_lainnya    += $d->total;
                }
                $lainnya['data']      = $data_lainnya;
                $lainnya['jml_los']   = $data->jml_los;
                $lainnya['subtotal']  = $subtotal_lainnya;
                $lainnya['total']     = $total_lainnya;
                $lainnya['realisasi'] = 0;
                $lainnya['selisih']   = $total_lainnya;

                $dataset['lainnya']   = json_encode($lainnya);

                $subtotal  += $subtotal_lainnya;
                $total     += $total_lainnya;
                $realisasi += 0;
                $selisih   += $total_lainnya;
            }
        } else {
            if($tagihan_data->lainnya && $tagihan_data->lainnya->lunas){
                $subtotal  += $tagihan_data->lainnya->subtotal;
                $total     += $tagihan_data->lainnya->total;
                $realisasi += $tagihan_data->lainnya->realisasi;
                $selisih   += $tagihan_data->lainnya->selisih;
            } else {
                $dataset['lainnya'] = null;
            }
        }

        $dataset['tagihan'] = json_encode([
            'subtotal'  => $subtotal,
            'ppn'       => $ppn,
            'denda'     => $denda,
            'diskon'    => $diskon,
            'total'     => $total,
            'realisasi' => $realisasi,
            'selisih'   => $selisih
        ]);

        $tagihan_data->update($dataset);
    }
}

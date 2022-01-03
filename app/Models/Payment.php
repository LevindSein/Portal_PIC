<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Bill;
use App\Models\Store;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $fillable = [
        'kd_kontrol',
        'nicename',
        'no_los',
        'pengguna',
        'info',
        'tagihan',
        'ids_tagihan'
    ];

    public static function syncAll(){
        $success = 0;
        $error = 0;

        $group = Bill::select('kd_kontrol')
        ->where([
            ['stt_publish', 1],
            ['stt_lunas', 0]
        ])
        ->groupBy('kd_kontrol')
        ->get();


        self::truncate();

        if(count($group) > 0){
            foreach($group as $i){
                $data = Bill::select('id', 'name', 'no_los', 'b_tagihan')
                ->where([
                    ['kd_kontrol', $i->kd_kontrol],
                    ['stt_publish', 1],
                    ['stt_lunas', 0]
                ])
                ->orderBy('id','asc')
                ->get();

                $ids_tagihan = NULL;
                $pengguna = NULL;
                $tagihan = 0;
                $no_los = '';
                foreach($data as $j){
                    $ids_tagihan .= $j->id . ",";
                    $tagihan += json_decode($j->b_tagihan)->sel_tagihan;
                    $pengguna = $j->name;

                    $no_los = $j->no_los;
                }
                $ids_tagihan = rtrim($ids_tagihan, ',');

                $store = Store::select('info')->where('kd_kontrol', $i->kd_kontrol)->first();
                $info = NULL;
                if($store){
                    $info = $store->info;
                }

                $dataset = [
                    'kd_kontrol' => $i->kd_kontrol,
                    'nicename' => str_replace('-', '', $i->kd_kontrol),
                    'no_los' => $no_los,
                    'pengguna' => $pengguna,
                    'info' => $info,
                    'ids_tagihan' => $ids_tagihan,
                    'tagihan' => $tagihan,
                ];

                try{
                    self::create($dataset);
                    $success++;
                } catch (\Exception $e){
                    $error++;
                }
            }
        }

        \Log::info("Payment sync all with success : " . $success . ", and error : " . $error);
    }

    public static function syncByKontrol($kontrol){
        $data = Bill::select('id', 'name', 'no_los', 'b_tagihan')
        ->where([
            ['kd_kontrol', $kontrol],
            ['stt_publish', 1],
            ['stt_lunas', 0]
        ])
        ->orderBy('id','asc')
        ->get();

        $ids_tagihan = NULL;
        $pengguna = NULL;
        $tagihan = 0;
        $no_los = '';
        foreach($data as $j){
            $ids_tagihan .= $j->id . ",";
            $tagihan += json_decode($j->b_tagihan)->sel_tagihan;
            $pengguna = $j->name;

            $no_los = $j->no_los;
        }
        $ids_tagihan = rtrim($ids_tagihan, ',');

        $store = Store::select('info')->where('kd_kontrol', $kontrol)->first();
        $info = NULL;
        if($store){
            $info = $store->info;
        }

        $payment = self::where('kd_kontrol', $kontrol)->first();
        if($payment){
            if(count($data) == 0){
                $payment->delete();
            }
            else{
                $payment->kd_kontrol = $kontrol;
                $payment->nicename = str_replace('-', '', $kontrol);
                $payment->no_los = $no_los;
                $payment->pengguna = $pengguna;
                $payment->info= $info;
                $payment->ids_tagihan= $ids_tagihan;
                $payment->tagihan= $tagihan;

                $payment->save();
            }
        }
        else{
            if(count($data) > 0){
                $dataset = [
                    'kd_kontrol' => $kontrol,
                    'nicename' => str_replace('-', '', $kontrol),
                    'no_los' => $no_los,
                    'pengguna' => $pengguna,
                    'info' => $info,
                    'ids_tagihan' => $ids_tagihan,
                    'tagihan' => $tagihan,
                ];

                self::create($dataset);
            }
        }
    }
}

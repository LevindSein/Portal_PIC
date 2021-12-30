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
        'pengguna',
        'info',
        'tagihan',
        'data_master',
        'ids_tagihan'
    ];

    public static function syncAll(){
        $success = 0;
        $updated = 0;
        $error = 0;

        $group = Bill::select('kd_kontrol')
        ->where([
            ['stt_publish', 1],
            ['stt_lunas', 0]
        ])
        ->groupBy('kd_kontrol')
        ->get();
        foreach($group as $i){
            $store = Store::select('info')->where('kd_kontrol', $i->kd_kontrol)->first();
            $info = '';
            if($store){
                $info = $store->info;
            }

            $data = Bill::select('id', 'name', 'b_tagihan')
            ->where([
                ['kd_kontrol', $i->kd_kontrol],
                ['stt_publish', 1],
                ['stt_lunas', 0]
            ])
            ->orderBy('id','asc')
            ->get();

            $ids_tagihan = '';
            $pengguna = '';
            $tagihan = 0;
            foreach($data as $j){
                $ids_tagihan .= $j->id . ",";
                $tagihan += json_decode($j->b_tagihan)->sel_tagihan;
                $pengguna = $j->name;
            }
            $ids_tagihan = rtrim($ids_tagihan, ',');

            $payment = self::where('kd_kontrol', $i->kd_kontrol)->first();
            if($payment){
                try{
                    $payment->kd_kontrol = $i->kd_kontrol;
                    $payment->nicename = str_replace('-', '', $i->kd_kontrol);
                    $payment->pengguna = $pengguna;
                    $payment->info= $info;
                    $payment->ids_tagihan= $ids_tagihan;
                    $payment->tagihan= $tagihan;

                    $payment->save();
                    $updated++;
                } catch (\Exception $e){
                    $error++;
                }
            }
            else{
                $dataset = [
                    'kd_kontrol' => $i->kd_kontrol,
                    'nicename' => str_replace('-', '', $i->kd_kontrol),
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

        \Log::info("Payment sync all with create : " . $success . ", updated : " . $updated . ", and error : " . $error);
    }
}

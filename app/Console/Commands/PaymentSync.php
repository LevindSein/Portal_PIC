<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\Store;

class PaymentSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize payment on bills';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
                $tagihan += json_decode($j->b_tagihan)->ttl_tagihan;
                $pengguna = $j->name;
            }
            $ids_tagihan = rtrim($ids_tagihan, ',');

            $payment = Payment::where('kd_kontrol', $i->kd_kontrol)->first();
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
                    Payment::create($dataset);
                    $success++;
                } catch (\Exception $e){
                    $error++;
                }
            }
        }

        \Log::info("Payment synchronize success, with Success : " . $success . ", Updated: " . $updated . ", Error : " . $error);
    }
}

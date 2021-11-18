<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Models\User;

class DeleteUserPermanently extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:deleteuserpermanently';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Permanently Data Penghapusan User.';

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
        $user = User::where([['stt_aktif',0],['nonaktif','!=',NULL]])->get();

        $deleted = 0;
        $undeleted = 0;
        foreach($user as $d){
            $json = json_decode($d->nonaktif);
            $history = count($json);
            $awal = new Carbon($json[$history - 1] -> timestamp);
            $akhir = Carbon::now()->toDateTimeString();

            $interval = $awal->diffInSeconds($akhir);

            if($interval > 86340){
                if($history > 5){
                    $length = $history - 5;
                    array_splice($json, 0, $length);
                }

                // Get last id
                $last_item    = end($json);
                $last_item_id = $last_item->id;

                $id = ++$last_item_id;

                $person = [
                    'foto' => $d->foto,
                    'nama' => $d->name,
                    'phone' => $d->phone,
                    'email' => $d->email,
                    'anggota' => $d->anggota,
                    'ktp' => $d->ktp,
                    'npwp' => $d->npwp,
                    'alamat' => $d->alamat,
                ];

                $json[] = array(
                    'id' => $id,
                    'status' => 'delete permanently',
                    'stt_aktif' => $d->stt_aktif,
                    'anggota' => 'by Sistem',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'data' => $person,
                );
                $nonaktif = json_encode($json);

                $d->phone = NULL;
                $d->email = NULL;
                $d->email_verified_at = NULL;
                $d->ktp = NULL;
                $d->npwp = NULL;
                $d->alamat = NULL;
                $d->otoritas = NULL;

                $d->stt_aktif = NULL;
                $d->nonaktif = $nonaktif;
                $d->save();
                $deleted++ ;
            }
            else{
                $undeleted++;
            }
        }

        return \Log::info("DeleteUserPermanently success : " . $deleted . " Deleted & " . $undeleted . " < 24 hours");
    }
}

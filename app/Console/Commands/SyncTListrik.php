<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use App\Models\TListrik;
use App\Models\Identity;
use Carbon\Carbon;

class SyncTListrik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:tlistrik';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //Copy dulu data dan struktur database meteran_listrik ke sync_tlistrik
        //Model TListrik tambahkan column 'id'
        $data = DB::table('sync_tlistrik')->get();

        foreach ($data as $d) {
            $json = json_encode([
                'created_by_id' => 1598,
                'created_by_name' => "Super Admin",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_by_id' => 1598,
                'updated_by_name' => "Super Admin",
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            $code = Identity::listrikCode();

            $dataset['id'] = $d->id;
            $dataset['code'] = $code;
            $dataset['name'] = $d->nomor;
            $dataset['power'] = $d->daya;
            $dataset['meter'] = $d->akhir;
            if($d->stt_sedia == 1){
                $dataset['stt_available'] = 0;
            } else {
                $dataset['stt_available'] = 1;
            }
            $dataset['data'] = $json;

            TListrik::create($dataset);
        }
    }
}

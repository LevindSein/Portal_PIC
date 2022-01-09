<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use App\Models\Period;
use App\Models\IndoDate;

class SyncPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:period';

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
        //Copy dulu data dan struktur database sinkronisasi ke sync_period
        //AppServiceProvider Initialize Period komentar dulu
        $data = DB::table('sync_period')->get();

        foreach ($data as $d) {
            $name = substr($d->sinkron, 0, 7);
            Period::create([
                'name' => $name,
                'nicename' => IndoDate::bulan($name, ' '),
                'new_period' => substr($d->sinkron, 0, 8) . "23",
                'due_date' => substr($d->sinkron, 0, 8) . "15",
                'year' => substr($d->sinkron, 0, 4),
                'faktur' => $d->faktur,
                'surat' => $d->surat
            ]);
        }

        //Manual
        //Edit Due Date pada Period
        //Agustus 2021 -> 2021-08-16
    }
}

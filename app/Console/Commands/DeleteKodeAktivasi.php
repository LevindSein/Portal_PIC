<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\KodeAktivasi;

use Carbon\Carbon;

class DeleteKodeAktivasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:deletekodeaktivasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Kode Aktivasi Unsubmitted';

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
        $deleted = 0;
        $now = Carbon::now()->toDateTimeString();

        $kode = KodeAktivasi::where('available', '<', $now)->get();

        foreach ($kode as $d) {
            $d->delete();
            $deleted++;
        }
        return \Log::info("DeleteKodeAktivasi success : " . $deleted . " deleted");
    }
}

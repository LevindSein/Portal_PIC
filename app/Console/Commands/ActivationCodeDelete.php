<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ActivationCode;

use Carbon\Carbon;

class ActivationCodeDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activationcode:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unsubmitted Activation Code';

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
        $code = ActivationCode::where('available', '<', $now)->get();

        foreach ($code as $d) {
            $from = new Carbon($d->available);
            $interval = $from->diffInSeconds($now);

            if($interval > 900){
                $d->delete();
                $deleted++;
            }
        }

        \Log::info("ActivationCodeDelete success : " . $deleted . " deleted");
    }
}

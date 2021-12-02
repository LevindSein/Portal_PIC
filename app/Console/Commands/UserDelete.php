<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Models\User;

class UserDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Data User unregistered and permanently.';

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
        //permanently
        $user = User::where([['active',0],['nonactive','!=',NULL]])->get();

        $deleted = 0;
        $undeleted = 0;
        foreach($user as $d){
            $json = json_decode($d->nonactive);
            $history = count($json);
            $from = new Carbon($json[$history - 1] -> timestamp);
            $end = Carbon::now()->toDateTimeString();

            $interval = $from->diffInSeconds($end);

            if($interval > 2592000){
                $d->delete();
                $deleted++ ;
            }
            else{
                $undeleted++;
            }
        }

        \Log::info("UserDelete success. permanent: " . $deleted . " Deleted & " . $undeleted . " < 30 days");

        //unregistered
        $user = User::where('active',2)->get();

        $now = Carbon::now()->toDateTimeString();

        $deleted = 0;
        foreach($user as $d){
            if($now > $d->available){
                $d->delete();
                $deleted++;
            }
        }

        \Log::info("UserDelete success. unregistered: " . $deleted . " Deleted");
    }
}

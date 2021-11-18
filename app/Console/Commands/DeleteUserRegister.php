<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use Carbon\Carbon;

class DeleteUserRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:deleteuserregister';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete User Registered Nonactivate';

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
        $user = User::where('stt_aktif',2)->get();

        $now = Carbon::now()->toDateTimeString();

        $deleted = 0;
        foreach($user as $d){
            if($now > $d->available){
                $d->delete();
                $deleted++;
            }
        }

        return \Log::info('DeleteUserRegister success : ' . $deleted . ' Deleted');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\LoginData;

class DataLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:logindata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear 3000 login data if > 7000';

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
        if(LoginData::count() > 7000){
            LoginData::orderBy('id','asc')->limit(3000)->delete();
        }
    }
}

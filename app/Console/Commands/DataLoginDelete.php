<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\DataLogin;

class DataLoginDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datalogin:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete login data if > 5000';

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
        if(DataLogin::count() > 5000){
            $delete = DataLogin::count() - 5000;
            DataLogin::orderBy('id','asc')->limit($delete)->delete();
        }

        \Log::info('DataLoginDelete success.');
    }
}

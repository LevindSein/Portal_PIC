<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Income;

use Carbon\Carbon;

class RestorePayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Payment available to restore.';

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
        Income::select('id', 'active', 'created_at')
        ->where([
            ['active', 1],
            ['created_at', '<', Carbon::now()->subDay()],
        ])
        ->update([
            'active' => 0
        ]);
    }
}

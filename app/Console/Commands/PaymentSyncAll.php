<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Payment;

class PaymentSyncAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:syncall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize all payment';

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
        Payment::syncAll();
        \Log::info("Synchronized all payment success.");
    }
}

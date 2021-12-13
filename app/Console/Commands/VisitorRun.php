<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Visitor;

class VisitorRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitor:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Counting how much visitor';

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
        $data = Visitor::firstOrCreate([
            'visit_per_day' => 0,
            'day_count' => 0,
            'visit_on_day' => 0
        ]);
        $data->day_count++;

        $visit_per_day = ($data->visit_on_day + ($data->visit_per_day * $data->day_count)) / $data->day_count;

        $data->visit_per_day = ceil($visit_per_day);
        $data->visit_on_day = 0;
        $data->save();

        \Log::info("VisitorRun success");
    }
}

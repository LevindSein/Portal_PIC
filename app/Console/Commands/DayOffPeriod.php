<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\DayOff;
use App\Models\Period;

use Carbon\Carbon;

class DayOffPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'period:dayoff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update day off for new period';

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
        $data = Period::orderBy('name','desc')->first();

        $due = Carbon::parse($data->due_date);

        if(DayOff::where('date', $due)->exists()){
            do{
                $dayoff = DayOff::where('date', $due)->first();
                if (!is_null($dayoff)){
                    $due->addDays(1)->format('Y-m-d');
                    $done = FALSE;
                }
                else{
                    $done = TRUE;
                }
            }
            while(!$done);
            $data->due_date = $due;
            $data->save();

            \Log::info('Day Off updated.');
        }
    }
}

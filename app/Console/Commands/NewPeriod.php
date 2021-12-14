<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Period;
use App\Models\IndoDate;

use Carbon\Carbon;

class NewPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'period:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Period';

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
        $data = Period::exists();
        $expired = Carbon::now()->format('Y-m-15');
        $now = Carbon::now()->format('Y-m-d');
        if($data){
            $new = Period::orderBy('name','desc')->first();
            $period = $new->new_period;
            if($now >= $period){
                Period::create([
                    'name' => Carbon::parse($period)->addMonth(1)->format('Y-m'),
                    'nicename' => IndoDate::bulan(Carbon::parse($period)->addMonth(1)->format('Y-m'), ' '),
                    'new_period' => Carbon::parse($period)->addMonth(1)->format('Y-m-23'),
                    'due_date' => Carbon::parse($period)->addMonth(1)->format('Y-m-15'),
                ]);
            }
        }
        else{
            $period = Carbon::now()->format('Y-m-23');
            if($now >= $period || $now > $expired){
                Period::create([
                    'name' => Carbon::now()->addMonth(1)->format('Y-m'),
                    'nicename' => IndoDate::bulan(Carbon::now()->addMonth(1)->format('Y-m'), ' '),
                    'new_period' => Carbon::now()->addMonth(1)->format('Y-m-23'),
                    'due_date' => Carbon::now()->addMonth(1)->format('Y-m-15'),
                ]);
            }
            else{
                Period::create([
                    'name' => Carbon::now()->format('Y-m'),
                    'nicename' => IndoDate::bulan(Carbon::now()->format('Y-m'), ' '),
                    'new_period' => Carbon::now()->format('Y-m-23'),
                    'due_date' => Carbon::now()->format('Y-m-15'),
                ]);
            }
        }

        \Log::info('Period Updated');
    }
}

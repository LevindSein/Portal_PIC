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

            if($interval > 86340){
                if($history > 5){
                    $length = $history - 5;
                    array_splice($json, 0, $length);
                }

                // Get last id
                $last_item    = end($json);
                $last_item_id = $last_item->id;

                $id = ++$last_item_id;

                $person = [
                    'photo' => $d->photo,
                    'name' => $d->name,
                    'phone' => $d->phone,
                    'email' => $d->email,
                    'member' => $d->member,
                    'ktp' => $d->ktp,
                    'npwp' => $d->npwp,
                    'address' => $d->address,
                ];

                $json[] = array(
                    'id' => $id,
                    'status' => 'delete permanently',
                    'active' => $d->active,
                    'member' => 'by Sistem',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                    'data' => $person,
                );
                $nonactive = json_encode($json);

                $d->phone = NULL;
                $d->email = NULL;
                $d->email_verified_at = NULL;
                $d->ktp = NULL;
                $d->npwp = NULL;
                $d->address = NULL;
                $d->authority = NULL;

                $d->active = NULL;
                $d->nonactive = $nonactive;
                $d->save();
                $deleted++ ;
            }
            else{
                $undeleted++;
            }
        }

        \Log::info("UserDelete success. permanent: " . $deleted . " Deleted & " . $undeleted . " < 24 hours");

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

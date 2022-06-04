<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'super_admin',
                'name'     => 'Super Admin',
                'password' => Hash::make(sha1(md5(hash('gost', 'bp3cmaster')))),
                'level'    => 1
            ]
        ]);
    }
}

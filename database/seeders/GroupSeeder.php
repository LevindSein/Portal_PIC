<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name'     => 'A-1',
                'nicename' => 'A1',
                'data'     => json_encode(["1","2","3","3A","4"])
            ],
            [
                'name'     => 'A-2',
                'nicename' => 'A2',
                'data'     => json_encode(["1","2","3","3A","4"])
            ],
            [
                'name'     => 'B-1',
                'nicename' => 'B1',
                'data'     => json_encode(["1","2","3","3A","4"])
            ],
            [
                'name'     => 'B-2',
                'nicename' => 'B2',
                'data'     => json_encode(["1","2","3","3A","4"])
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ReferalTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('referal_types')->insert([
            'name' => 'points',
        ]);

        DB::table('referal_types')->insert([
            'name' => 'offers',
        ]);
    }
}

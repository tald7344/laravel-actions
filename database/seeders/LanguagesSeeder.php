<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('languages')->insert([
            'name' => 'English',
            'code' => 'en',
        ]);

        DB::table('languages')->insert([
            'name' => 'French',
            'code' => 'fr',
        ]);
        
        // Add other languages if needed...
    }
}

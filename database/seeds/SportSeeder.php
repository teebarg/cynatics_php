<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sports')->truncate();

        $sports = [
            ['name' => 'Soccer'],
            ['name' => 'Wrestling'],
            ['name' => 'MMA'],
            ['name' => 'Baseball'],
            ['name' => 'Basketball'],
            ['name' => 'Lawn Tennis']
        ];

        DB::table('sports')->insert($sports);
    }
}

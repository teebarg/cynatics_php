<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarketSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('markets')->truncate();

        $markets= [
            ['name' => 'Double Chance'],
            ['name' => 'Correct Score'],
            ['name' => 'Multi Goal'],
            ['name' => '1X2']
        ];

        DB::table('markets')->insert($markets);
    }
}

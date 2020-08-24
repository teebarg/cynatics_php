<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OddSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('odds')->truncate();

        $odds = [
            ['name' => '1X', 'market_id' => 1],
            ['name' => '12', 'market_id' => 1],
            ['name' => '2-0', 'market_id' => 2],
            ['name' => '1-1', 'market_id' => 2],
            ['name' => '1', 'market_id' => 4],
            ['name' => 'X', 'market_id' => 4]
        ];

        DB::table('odds')->insert($odds);
    }
}

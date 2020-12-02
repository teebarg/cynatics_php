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
            ['name' => 'Double Chance', 'slug' => 'double-chance'],
            ['name' => 'Correct Score', 'slug' => 'correct-score'],
            ['name' => 'Multi Goal', 'slug' => 'multi-goal'],
            ['name' => 'Hot Pick', 'slug' => 'hot-pick'],
            ['name' => 'Free Pick', 'slug' => 'free-pick'],
            ['name' => '1X2', 'slug' => '1x2']
        ];

        DB::table('markets')->insert($markets);
    }
}

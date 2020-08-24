<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookmakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookmakers')->truncate();

        $bookmakers = [
            ['name' => 'Bet9ja'],
            ['name' => 'Naira Bet'],
            ['name' => '1XBet'],
        ];

        DB::table('bookmakers')->insert($bookmakers);
    }
}

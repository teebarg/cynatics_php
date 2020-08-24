<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('competitions')->truncate();

        $competitions = [
            ['name' => 'English Premier league', 'alias' => 'EPL', 'country_id' => 1],
            ['name' => 'French Ligue 1', 'alias' => 'FPL', 'country_id' => 6],
            ['name' => 'Capital One', 'alias' => 'CPO', 'country_id' => 1],
            ['name' => 'La Liga', 'alias' => 'LAL', 'country_id' => 7],
            ['name' => 'Bundesliga', 'alias' => 'BDL', 'country_id' => 1],
            ['name' => 'Serie A', 'alias' => 'SER', 'country_id' => 1],
            ['name' => 'English FA Cup', 'FAC' => 'TOT', 'country_id' => 8],
            ['name' => 'Tim Cup', 'alias' => 'TIM', 'country_id' => 2],
            ['name' => 'Copa Del Rey', 'CDR' => 'BRN', 'country_id' => 1],
        ];

        DB::table('competitions')->insert($competitions);
    }
}

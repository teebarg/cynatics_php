<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clubs')->truncate();

        $clubs = [
            ['name' => 'Arsenal', 'alias' => 'ARS', 'country_id' => 1],
            ['name' => 'Man United', 'alias' => 'MAN', 'country_id' => 6],
            ['name' => 'Chelsea', 'alias' => 'CHE', 'country_id' => 1],
            ['name' => 'Man City', 'alias' => 'MAC', 'country_id' => 7],
            ['name' => 'Liverpool', 'alias' => 'LIV', 'country_id' => 1],
            ['name' => 'Everton', 'alias' => 'EVE', 'country_id' => 1],
            ['name' => 'Tottenham', 'alias' => 'TOT', 'country_id' => 8],
            ['name' => 'Southampton', 'alias' => 'SOU', 'country_id' => 2],
            ['name' => 'Burnley', 'alias' => 'BRN', 'country_id' => 1],
            ['name' => 'Real Madrid', 'alias' => 'RMD', 'country_id' => 2],
            ['name' => 'Barcelona', 'alias' => 'BAR', 'country_id' => 3],
            ['name' => 'Bayern Munich', 'alias' => 'BYM', 'country_id' => 5],
            ['name' => 'Juventus', 'alias' => 'JUV', 'country_id' => 4]
        ];

        DB::table('clubs')->insert($clubs);
    }
}

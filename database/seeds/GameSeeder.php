<?php

use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                CountrySeeder::class,
                CompetitionSeeder::class,
                ClubSeeder::class,
                MarketSeeder::class,
                OddSeeder::class,
                GameStatusSeeder::class,
                SportSeeder::class,
                BookmakerSeeder::class,
            ]);
    }
}

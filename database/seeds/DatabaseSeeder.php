<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
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
                 PermissionSeeder::class,
                 RoleSeeder::class,
                 UserSeeder::class,
                 CountrySeeder::class,
                 CompetitionSeeder::class,
                 ClubSeeder::class,
                 MarketSeeder::class,
                 OddSeeder::class,
                 GameStatusSeeder::class,
                 SportSeeder::class,
                 BookmakerSeeder::class,
                 AdSlotSeeder::class
             ]);
    }
}

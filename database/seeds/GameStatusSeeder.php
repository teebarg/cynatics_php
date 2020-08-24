<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('game_statuses')->truncate();

        $sports = [
            ['status' => 'active'],
            ['status' => 'won'],
            ['status' => 'loss'],
            ['status' => 'void']
        ];

        DB::table('game_statuses')->insert($sports);
    }
}

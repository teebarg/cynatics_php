<?php

use App\Models\AdSlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ad_slots')->truncate();

        $ad_slots = [
            ['name' => AdSlot::BANNER],
            ['name' => AdSlot::FREE_BET],
        ];

        DB::table('ad_slots')->insert($ad_slots);
    }
}

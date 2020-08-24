<?php

use App\Helpers\SpatieHelper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (SpatieHelper::PERMISSIONS as $permission) {
            if (Permission::where('name', $permission)->count()) {
                $this->command->warn("Permission $permission already exists, skipping...");
                continue;
            }
            Permission::create(['name' => $permission]);
        }
    }
}

<?php

use App\Helpers\SpatieHelper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => SpatieHelper::SUPER_ADMIN]);

        $role2 = Role::create(['name' => SpatieHelper::ADMIN]);
        $role2->givePermissionTo(SpatieHelper::PERMISSIONS[0]);
        $role2->givePermissionTo(SpatieHelper::PERMISSIONS[1]);

        $role3 = Role::create(['name' => SpatieHelper::USER]);
        $role3->givePermissionTo(SpatieHelper::PERMISSIONS[0]);
    }
}

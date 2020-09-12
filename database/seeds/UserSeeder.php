<?php

use App\Helpers\SpatieHelper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Factory(App\User::class)->create([
            'username' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole(Role::where('name', SpatieHelper::SUPER_ADMIN)->first());
        $user->syncPermissions(Permission::all());

        $user = Factory(App\User::class)->create([
            'username' => 'Admin',
            'email' => 'admin2@admin.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole(Role::where('name', SpatieHelper::ADMIN)->first());

        $user = Factory(App\User::class)->create([
            'username' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password')
        ]);
        $user->assignRole(Role::where('name', SpatieHelper::USER)->first());
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Permissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (Permissions::flatten() as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        foreach (Permissions::roleMap() as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            if ($perms === ['*']) {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($perms);
            }
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@ma-assaadah.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['Super Administrator']);
    }
}

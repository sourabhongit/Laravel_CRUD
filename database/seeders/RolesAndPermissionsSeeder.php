<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Define permissions
        $permissions = [
            'create user',
            'edit user',
            'delete user',
        ];

        // Create permissions in the database
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Define roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        // Assign permissions to roles
        $adminRole->syncPermissions($permissions);
        $editorRole->givePermissionTo('create user', 'edit user');
    }
}
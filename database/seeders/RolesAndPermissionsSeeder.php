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
        // $permissions = [
        //     'import data',
        //     'export data',
        // ];

        // Create permissions in the database
        // foreach ($permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // Assign new permissions to roles
        $adminRole = Role::findByName('editor');
        $permissions = Permission::whereIn('name', ['export data'])->get();

        foreach ($permissions as $permission) {
            $adminRole->givePermissionTo($permission);
        }

        // Assign permissions to roles - Previous permissions for the role will be deleted.
        // $adminRole = Role::findByName('admin');
        // $permissions = Permission::whereIn('name', ['import data', 'export data'])->get();
        // $adminRole->syncPermissions($permissions);

        // Define roles and assign permissions
        // $adminRole = Role::create(['name' => 'admin']);
        // $editorRole = Role::create(['name' => 'editor']);
        // $adminRole->syncPermissions($permissions);
        // $editorRole->givePermissionTo('export data');
    }
}

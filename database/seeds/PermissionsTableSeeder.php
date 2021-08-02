<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create([
            'name' => 'Access Category Page',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Create Category',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Edit Category',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Delete Category',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Access Product Page',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Create Product',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Edit Product',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Delete Product',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Access Business Unit Page',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Create Business Unit',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Edit Business Unit',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Delete Business Unit',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Access Outlet Page',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Create Outlet',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Edit Outlet',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Delete Outlet',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Access Employee Page',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Create Employee',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Edit Employee',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Delete Employee',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Access Role Page',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Create Role',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Delete Role',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Access Permission Page',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Edit Permission',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'Access Mobile Apps',
            'guard_name' => 'web'
        ]);
    }
}

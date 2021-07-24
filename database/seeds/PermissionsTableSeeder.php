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

        $role = Role::where('name', 'Admin')->get()->first();
        $role->givePermissionTo(Permission::all());
    }
}

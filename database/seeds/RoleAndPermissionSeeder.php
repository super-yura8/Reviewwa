<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'publish review']);
        Permission::create(['name' => 'write comment']);
        Permission::create(['name' => 'edit reviews']);
        Permission::create(['name' => 'unpublish review']);
        Permission::create(['name' => 'ban user']);
        Permission::create(['name' => 'unban user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'edit comments']);
        Permission::create(['name' => 'unpublish comment']);
        Permission::create(['name' => 'create admin']);

        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['publish review', 'write comment']);
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['unpublish comment' ,'unpublish review', 'ban user', 'unban user']);
        $role = Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());

    }
}

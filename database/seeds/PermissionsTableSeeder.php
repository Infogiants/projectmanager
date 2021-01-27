<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $permission->name = 'Create Permission';
        $permission->slug = 'create-permission';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Edit Permission';
        $permission->slug = 'edit-permission';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Delete Permission';
        $permission->slug = 'delete-permission';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Create Role';
        $permission->slug = 'create-role';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Edit Role';
        $permission->slug = 'edit-role';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Delete Role';
        $permission->slug = 'delete-role';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Create User';
        $permission->slug = 'create-user';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Edit User';
        $permission->slug = 'edit-user';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Delete User';
        $permission->slug = 'delete-user';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Create Contact';
        $permission->slug = 'create-contact';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Edit Contact';
        $permission->slug = 'edit-contact';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Delete Contact';
        $permission->slug = 'delete-contact';
        $permission->save();
    }
}

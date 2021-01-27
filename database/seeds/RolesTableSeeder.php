<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'Admin';
        $role->slug = 'admin';
        $role->save();

        $permissions = Permission::orderBy('id', 'asc')->pluck('id')->toArray();
        $role->permissions()->sync(Permission::whereIn('id', ($permissions) ?? [])->get());
    
        $role = new Role();
        $role->name = 'User';
        $role->slug = 'user';
        $role->save();
        $role->permissions()->sync(Permission::whereIn('id', ([10,11,12]) ?? [])->get());
    }
}
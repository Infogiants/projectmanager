<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = new User();
        $adminUser->name = 'Admin User';
        $adminUser->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $adminUser->email = 'admin@example.com';
        $adminUser->password = bcrypt('admin');
        $adminUser->save();

        $roles = Role::orderBy('id', 'desc')->pluck('id')->toArray();
        $adminUser->roles()->sync(Role::whereIn('id', ([1]) ?? [])->get());

        $user = new User();
        $user->name = 'User';
        $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->email = 'user@example.com';
        $user->password = bcrypt('user');
        $user->save();
        $user->roles()->sync(Role::whereIn('id', ([2]) ?? [])->get());
    }
}

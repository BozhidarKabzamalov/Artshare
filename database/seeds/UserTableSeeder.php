<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'Admin')->first();

        $user = new User();
        $user->first_name = 'Bozhidar';
        $user->last_name = 'Kabzamalov';
        $user->username = 'Admin';
        $user->password = bcrypt('Admin');
        $user->email = 'bojidar_s_k@abv.bg';
        $user->image_file_name = 'default.jpg';
        $user->save();
        $user->roles()->attach($role_admin);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRole("customer");
        $this->createRole("admin");

        $user1 = $this->createUser("win", "win@gmail.com", "123", "Yangon", "09123456");
        $user2 = $this->createUser("myo", "myo@gmail.com", "123", "Mandalay", "09123456");
        $user3 = $this->createUser("aung", "aung@gmail.com", "123", "Yangon", "09123456");

        $user1->roles()->attach([1, 2]);
        $user2->roles()->attach([1]);
        $user3->roles()->attach([1]);
    }

    function createRole($roleName)
    {
        $role = new Role;
        $role->name = $roleName;
        $role->save();
    }

    function createUser($name, $email, $password, $address, $phone)
    {
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->address = $address;
        $user->phone = $phone;
        $user->save();

        return $user;
    }

}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createCustomer("Thaw", "thaw@gmail.com", "Yangon", "09123455");
        $this->createCustomer("Win", "win@gmail.com", "Mandalay", "09123455");
        $this->createCustomer("Myo", "myo@gmail.com", "Yangon", "09123455");
    }

    function createCustomer($name, $email, $address, $phone)
    {
        $customer = new Customer;
        $customer->name = $name;
        $customer->email = $email;
        $customer->address = $address;
        $customer->phone = $phone;
        $customer->save();
    }
}

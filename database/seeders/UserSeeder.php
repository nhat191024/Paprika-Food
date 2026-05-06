<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@paprika.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole(Role::Admin->value);

        $staff = Staff::firstOrCreate(
            ['email' => 'staff@paprika.com'],
            [
                'name' => 'Staff',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $staff->assignRole(Role::Staff->value);

        Customer::factory(10)->create()->each(function (Customer $customer) {
            $customer->assignRole(Role::Customer->value);
        });
    }
}

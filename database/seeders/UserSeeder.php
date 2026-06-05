<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@adgon.com',
            'password' => Hash::make('password123'),
            'phone' => '9876543210',
            'address' => '123 Admin Street',
            'city' => 'New Delhi',
            'state' => 'Delhi',
            'zipcode' => '110001',
            'country' => 'India',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Customer user
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@adgon.com',
            'password' => Hash::make('password123'),
            'phone' => '9876543211',
            'address' => '456 Customer Avenue',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'zipcode' => '400001',
            'country' => 'India',
            'role' => 'customer',
            'is_active' => true,
        ]);
    }
}

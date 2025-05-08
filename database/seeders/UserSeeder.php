<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '09123456789',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create restaurant owner
        $owner = User::create([
            'name' => 'صاحب رستوران',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '09123456790',
            'is_active' => true,
        ]);
        $owner->assignRole('restaurant_owner');

        // Create regular user
        $user = User::create([
            'name' => 'کاربر عادی',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '09123456791',
            'is_active' => true,
        ]);
        $user->assignRole('user');
    }
} 
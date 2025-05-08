<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $restaurantOwnerRole = Role::create(['name' => 'restaurant_owner']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        $permissions = [
            'manage_restaurants',
            'manage_menus',
            'manage_reservations',
            'manage_users',
            'manage_reviews',
            'make_reservations',
            'write_reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions);
        $restaurantOwnerRole->givePermissionTo([
            'manage_restaurants',
            'manage_menus',
            'manage_reservations',
            'manage_reviews',
        ]);
        $userRole->givePermissionTo([
            'make_reservations',
            'write_reviews',
        ]);

        // اختصاص نقش ادمین به کاربر ادمین
        $admin = User::where('email', 'admin@example.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
} 
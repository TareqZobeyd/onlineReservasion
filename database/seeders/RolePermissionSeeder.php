<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

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

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        $restaurantOwnerRole = Role::create(['name' => 'restaurant_owner']);
        $restaurantOwnerRole->givePermissionTo([
            'manage_restaurants',
            'manage_menus',
            'manage_reservations',
            'manage_reviews',
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'make_reservations',
            'write_reviews',
        ]);

        // Assign admin role to the first user
        $admin = User::first();
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
} 
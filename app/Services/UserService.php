<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new user
     *
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User
    {
        return User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'phone_number' => $userData['phone_number'],
            'address' => $userData['address'],
            'role' => 'user',
            'is_active' => true,
        ]);
    }
} 
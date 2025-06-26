<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create super_admin user
        $hashed_password = Hash::make('admin12345');
        $super_admin_user = User::create([
            'name' => 'Admin Admin',
            'email' => 'admin@example.com',
            'password' => $hashed_password,
        ]);

        $super_admin_user->assignRole('super_admin');

        //create regular user
        $hashed_password = Hash::make('password');
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => $hashed_password,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'username' => 'testuser',
            'phone' => '0123456789',
            'address' => 'Test Address',
            'date_of_birth' => '2000-01-01',
            'role' => 'customer',
            'password' => Hash::make('password'),
        ]);

        \App\Models\User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '0000000000',
            'address' => 'Admin Address',
            'date_of_birth' => '2000-01-01',
            'role' => 'admin',
            'password' => Hash::make('123456789'),
        ]);

        $this->call(DefaultProductSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create([
            'role' => 'customer',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);

        User::factory()->count(3)->create([
            'role' => 'seller',
            'status' => 'active',
            'password' => Hash::make('password'),
        ]);
    }
}

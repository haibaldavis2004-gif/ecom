<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Optionally create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 👇 Add this line to call your RolePermissionSeeder
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);

    }
}


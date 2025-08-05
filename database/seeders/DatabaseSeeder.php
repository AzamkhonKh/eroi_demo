<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users if they don't exist
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin User']
        );

        // Create additional users for testing
        User::factory(3)->create();

        // Seed traffic sources and marketing expenses
        $this->call([
            TrafficSourceSeeder::class,
            MarketingExpenseSeeder::class,
        ]);
    }
}

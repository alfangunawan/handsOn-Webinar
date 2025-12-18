<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Katering\Database\Seeders\KateringDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo user
        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@meallink.com',
        ]);

        // Seed Katering module data
        $this->call(KateringDatabaseSeeder::class);
    }
}

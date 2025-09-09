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
        // Create admin user
        User::factory()->create([
            'name' => 'Admin Buku Cerita',
            'email' => 'admin@bukucerita.com',
        ]);

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create additional users
        User::factory(5)->create();

        // Seed categories and books
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}

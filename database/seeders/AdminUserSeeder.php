<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main admin user
        $mainAdmin = User::firstOrCreate(
            ['email' => 'admin@bukucerita.my.id'],
            [
                'name' => 'Admin Buku Cerita',
                'password' => Hash::make('BukuCeritaMyId2025!'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully:');
    }
}

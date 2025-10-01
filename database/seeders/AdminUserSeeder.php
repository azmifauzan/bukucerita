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

        // Additional admin users requested
        $userAzmi = User::firstOrCreate(
            ['email' => 'azmifauzan@gmail.com'],
            [
                'name' => 'Azmi Fauzan',
                'password' => Hash::make('BukuCerita12345!'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $userMeilati = User::firstOrCreate(
            ['email' => 'meilati.fanita@gmail.com'],
            [
                'name' => 'Meilati Fanita',
                'password' => Hash::make('BukuCerita12345!'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Admin users created/ensured successfully:');
        $this->command->line('- ' . $mainAdmin->email);
        $this->command->line('- ' . $userAzmi->email);
        $this->command->line('- ' . $userMeilati->email);
    }
}

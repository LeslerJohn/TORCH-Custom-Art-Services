<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ClientProfile;
use App\Models\ArtistProfile;
use App\Models\Commission;
use App\Models\Delivery;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Seed admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_admin' => true
        ]);
        
        $this->call([
            ArtistSeeder::class,
            ClientSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            CategoryTagSeeder::class,
            ServiceSeeder::class,
            AddressSeeder::class,
            RequestSeeder::class,
            DeliverySeeder::class,
            CommissionSeeder::class,
        ]);
    }
}
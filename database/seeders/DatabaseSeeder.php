<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ClientProfile;
use App\Models\ArtistProfile;

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

        // Seed client user and profile
        $client = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'client'
        ]);

        ClientProfile::create([
            'id' => $client->id,
            'rating' => 4.5,
            'is_suspended' => false,
        ]);

        // Seed first artist user and profile
        $artist = User::factory()->create([
            'name' => 'Artist User',
            'email' => 'artist@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'artist'
        ]);

        ArtistProfile::create([
            'id' => $artist->id,
            'phone_number' => '123-456-7890',
            'location' => 'New York',
            'gender' => 'Male',
            'username' => 'artist1',
            'birthdate' => '1990-01-01',
            'bio' => 'An amazing artist.',
            'is_suspended' => false,
            'rating' => 5.0,
            'available' => true,
        ]);
    }
}
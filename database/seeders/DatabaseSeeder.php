<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'client'
        ]);

        ClientProfile::create([
            'id' => 1,
            'rating' => 4.5,
            'is_suspended' => false,
        ]);
        
        ArtistProfile::create([
            'id' => 1,
            'phone_number' => '123-456-7890',
            'location' => 'New York',
            'gender' => 'Male',
            'username' => 'artist1',
            'birthdate' => '1990-01-01',
            'bio' => 'An amazing artist.',
            'verified' => true,
            'is_suspended' => false,
            'rating' => 5.0,
            'available' => true,
        ]);
    }
}
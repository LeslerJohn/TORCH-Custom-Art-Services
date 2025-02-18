<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ArtistProfile;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = [
            [
                'name' => 'Artist User 1',
                'email' => 'artist1@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'artist',
                'created_at' => '2025-01-01 12:00:00',
                'updated_at' => '2025-01-01 12:00:00',
                'phone_number' => '123-456-7890',
                'location' => 'New York',
                'gender' => 'Male',
                'username' => 'artist1',
                'birthdate' => '1990-01-01',
                'bio' => 'An amazing artist.',
                'status' => 'fully-verified',
                'is_suspended' => false,
                'rating' => 5.0,
                'available' => true
            ],
            [
                'name' => 'Artist User 2',
                'email' => 'artist2@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'artist',
                'created_at' => '2025-01-15 14:30:00',
                'updated_at' => '2025-01-15 14:30:00',
                'phone_number' => '234-567-8901',
                'location' => 'Los Angeles',
                'gender' => 'Female',
                'username' => 'artist2',
                'birthdate' => '1991-02-01',
                'bio' => 'A talented artist.',
                'status' => 'unverified',
                'is_suspended' => false,
                'rating' => 4.5,
                'available' => true
            ],
            [
                'name' => 'Artist User 3',
                'email' => 'artist3@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'artist',
                'created_at' => '2025-02-01 09:45:00',
                'updated_at' => '2025-02-01 09:45:00',
                'phone_number' => '345-678-9012',
                'location' => 'Chicago',
                'gender' => 'Non-binary',
                'username' => 'artist3',
                'birthdate' => '1992-03-01',
                'bio' => 'A creative artist.',
                'status' => 'pending',
                'is_suspended' => false,
                'rating' => 4.8,
                'available' => true
            ],
            [
                'name' => 'Artist User 4',
                'email' => 'artist4@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'artist',
                'created_at' => '2025-02-15 16:00:00',
                'updated_at' => '2025-02-15 16:00:00',
                'phone_number' => '456-789-0123',
                'location' => 'Houston',
                'gender' => 'Male',
                'username' => 'artist4',
                'birthdate' => '1993-04-01',
                'bio' => 'An inspiring artist.',
                'status' => 'semi-verified',
                'is_suspended' => false,
                'rating' => 4.9,
                'available' => true
            ]
        ];

        foreach ($artists as $artistData) {
            $artist = User::factory()->create([
                'name' => $artistData['name'],
                'email' => $artistData['email'],
                'password' => $artistData['password'],
                'role' => $artistData['role'],
                'created_at' => $artistData['created_at'],
                'updated_at' => $artistData['updated_at']
            ]);

            ArtistProfile::create([
                'id' => $artist->id,
                'phone_number' => $artistData['phone_number'],
                'location' => $artistData['location'],
                'gender' => $artistData['gender'],
                'username' => $artistData['username'],
                'birthdate' => $artistData['birthdate'],
                'bio' => $artistData['bio'],
                'status' => $artistData['status'],
                'is_suspended' => $artistData['is_suspended'],
                'rating' => $artistData['rating'],
                'available' => $artistData['available'],
                'created_at' => $artistData['created_at'],
                'updated_at' => $artistData['updated_at']
            ]);
        }
    }
}

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
        User::factory(10)->create([
            'role' => 'artist',
            'is_admin' => false,
        ])->each(function ($artist) {
            ArtistProfile::factory()->create([
                'user_id' => $artist->id,
            ]);
        });
    }
}

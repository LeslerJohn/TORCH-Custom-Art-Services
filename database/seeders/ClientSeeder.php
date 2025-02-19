<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClientProfile;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create([
            'role' => 'client',
            'is_admin' => false,
        ])->each(function ($client) {
            ClientProfile::factory()->create([
                'id' => $client->id,
            ]);
        });
    }
}

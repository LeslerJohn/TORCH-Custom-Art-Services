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
        // Seed client user and profile
        $clients = [
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'client',
                'created_at' => '2025-01-01 10:00:00',
                'updated_at' => '2025-01-01 10:00:00',
                'rating' => 4.5,
                'is_suspended' => false
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'client',
                'created_at' => '2025-01-15 11:00:00',
                'updated_at' => '2025-01-15 11:00:00',
                'rating' => 4.7,
                'is_suspended' => false
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'client',
                'created_at' => '2025-02-01 12:00:00',
                'updated_at' => '2025-02-01 12:00:00',
                'rating' => 4.8,
                'is_suspended' => false
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bob@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'client',
                'created_at' => '2025-02-15 13:00:00',
                'updated_at' => '2025-02-15 13:00:00',
                'rating' => 4.6,
                'is_suspended' => false
            ]
        ];

        foreach ($clients as $clientData) {
            $client = User::factory()->create([
                'name' => $clientData['name'],
                'email' => $clientData['email'],
                'password' => $clientData['password'],
                'role' => $clientData['role'],
                'created_at' => $clientData['created_at'],
                'updated_at' => $clientData['updated_at']
            ]);

            ClientProfile::create([
                'id' => $client->id,
                'rating' => $clientData['rating'],
                'is_suspended' => $clientData['is_suspended'],
                'created_at' => $clientData['created_at'],
                'updated_at' => $clientData['updated_at']
            ]);
        }
    }
}

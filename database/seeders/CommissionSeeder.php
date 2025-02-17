<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Commission;
use Carbon\Carbon;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example data: Adjust these IDs and fields to match your actual setup
        Commission::create([
            'request_id'  => 1,
            'delivery_id' => 1,
            'deadline'    => Carbon::create(2024, 12, 15),
            'status'      => 'pending',
            'created_at'  => Carbon::create(2024, 12, 15),
            'updated_at'  => Carbon::create(2024, 12, 15),
        ]);

        Commission::create([
            'request_id'  => 2,
            'delivery_id' => 2,
            'deadline'    => Carbon::create(2024, 12, 30),
            'status'      => 'ready',
            'created_at'  => Carbon::create(2024, 12, 30),
            'updated_at'  => Carbon::create(2024, 12, 30),
        ]);

        Commission::create([
            'request_id'  => 3,
            'delivery_id' => 3,
            'deadline'    => Carbon::create(2025, 1, 15),
            'status'      => 'wip',
            'created_at'  => Carbon::create(2025, 1, 15),
            'updated_at'  => Carbon::create(2025, 1, 15),
        ]);

        Commission::create([
            'request_id'  => 4,
            'delivery_id' => 4,
            'deadline'    => Carbon::create(2025, 1, 30),
            'status'      => 'completed',
            'created_at'  => Carbon::create(2025, 1, 30),
            'updated_at'  => Carbon::create(2025, 1, 30),
        ]);

        Commission::create([
            'request_id'  => 5,
            'delivery_id' => 5,
            'deadline'    => Carbon::create(2025, 2, 15),
            'status'      => 'done',
            'created_at'  => Carbon::create(2025, 2, 15),
            'updated_at'  => Carbon::create(2025, 2, 15),
        ]);
    }
}

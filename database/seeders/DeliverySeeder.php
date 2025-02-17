<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Delivery;
use Carbon\Carbon;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample Delivery 1
        Delivery::create([
            'contact_number'    => '555-123-4567',
            'address_id'        => 1, 
            'expected_delivery' => Carbon::now()->addDays(7),
            'status'            => 'pending',
        ]);
        Delivery::create([
            'contact_number'    => '555-987-6543',
            'address_id'        => 2,
            'expected_delivery' => Carbon::now()->addDays(14),
            'status'            => 'in-transit',
        ]);
        Delivery::create([
            'contact_number'    => '555-555-5555',
            'address_id'        => 3,
            'expected_delivery' => Carbon::now()->addDays(3),
            'status'            => 'completed',
        ]);
        Delivery::create([
            'contact_number'    => '555-553-5555',
            'address_id'        => 4,
            'expected_delivery' => Carbon::now()->addDays(3),
            'status'            => 'cancelled',
        ]);
        Delivery::create([
            'contact_number'    => '555-553-5555',
            'address_id'        => 5,
            'expected_delivery' => Carbon::now()->addDays(3),
            'status'            => 'completed',
        ]);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Sample Service 1
        $service1 = Service::create([
            'artist_id'      => 2,        // Ensure this artist exists
            'category_id'    => 1,        // Ensure this category exists
            'price_rate'     => 100.00,
            'rush_price_rate'=> 150.00,
            'normal_timeframe' => 7,       // in days
            'rush_timeframe'   => 3,       // in days
            'status'         => 'active', // Example status; adjust as needed
        ]);

        // Attach tags to Service 1 (adjust tag IDs as appropriate)
        $service1->tags()->attach([1, 2]);

        // Sample Service 2
        $service2 = Service::create([
            'artist_id'      => 3,
            'category_id'    => 2,
            'price_rate'     => 200.00,
            'rush_price_rate'=> 250.00,
            'normal_timeframe' => 10,
            'rush_timeframe'   => 5,
            'status'         => 'inactive',
        ]);

        // Attach a tag to Service 2
        $service2->tags()->attach([3]);

        // Sample Service 3
        $service3 = Service::create([
            'artist_id'      => 4,
            'category_id'    => 3,
            'price_rate'     => 300.00,
            'rush_price_rate'=> 350.00,
            'normal_timeframe' => 14,
            'rush_timeframe'   => 7,
            'status'         => 'active',
        ]);

        // Attach tags to Service 3
        $service3->tags()->attach([4, 5]);

        // Sample Service 4
        $service4 = Service::create([
            'artist_id'      => 5,
            'category_id'    => 4,
            'price_rate'     => 400.00,
            'rush_price_rate'=> 450.00,
            'normal_timeframe' => 21,
            'rush_timeframe'   => 10,
            'status'         => 'inactive',
        ]);

        // Attach a tag to Service 4
        $service4->tags()->attach([6]);

        // Sample Service 5
        $service5 = Service::create([
            'artist_id'      => 3,
            'category_id'    => 5,
            'price_rate'     => 500.00,
            'rush_price_rate'=> 550.00,
            'normal_timeframe' => 30,
            'rush_timeframe'   => 15,
            'status'         => 'active',
        ]);

        // Attach tags to Service 5
        $service5->tags()->attach([7, 8]);
    }
}

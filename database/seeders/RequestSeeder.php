<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Request;
use Carbon\Carbon;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Request::create([
            'client_id'   => 6,
            'total_price' => 500,
            'description' => 'A sample request for a portrait painting.',
            'height'      => 1080,
            'width'       => 1920,
            'deadline'    => Carbon::now()->addDays(14),
            'service_id'  => 1,
            'status'      => 'pending',
            'unit'        => 'cm',
        ]);

        Request::create([
            'client_id'   => 7,
            'total_price' => 800,
            'description' => 'Commission for a digital illustration.',
            'height'      => 800,
            'width'       => 600,
            'deadline'    => Carbon::now()->addDays(30),
            'service_id'  => 2,
            'status'      => 'in-progress',
            'unit'        => 'cm',
        ]);

        Request::create([
            'client_id'   => 8,
            'total_price' => 1200,
            'description' => 'Custom artwork for a game character concept.',
            'height'      => 1200,
            'width'       => 800,
            'deadline'    => Carbon::now()->addDays(21),
            'service_id'  => 3,
            'status'      => 'completed',
            'unit'        => 'cm',
        ]);

        Request::create([
            'client_id'   => 9,
            'total_price' => 1500,
            'description' => 'A mural painting for a community center.',
            'height'      => 2000,
            'width'       => 3000,
            'deadline'    => Carbon::now()->addDays(45),
            'service_id'  => 4,
            'status'      => 'pending',
            'unit'        => 'cm', 
        ]);

        Request::create([
            'client_id'   => 8,
            'total_price' => 2000,
            'description' => 'A custom tattoo design for a client.',
            'height'      => 400,
            'width'       => 600,
            'deadline'    => Carbon::now()->addDays(60),
            'service_id'  => 5,
            'status'      => 'in-progress',
            'unit'        => 'cm',
        ]);
    }
}
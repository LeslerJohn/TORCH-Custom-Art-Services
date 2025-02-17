<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $addresses = [
            [
                'client_id'    => 6,
                'street'       => 'Main Street',
                'barangay'     => 'Barangay Uno',
                'zip_code'     => '1000',
                'house_number' => '123',
            ],
            [
                'client_id'    => 7,
                'street'       => 'Second Avenue',
                'barangay'     => 'Barangay Dos',
                'zip_code'     => '1001',
                'house_number' => '456',
            ],
            [
                'client_id'    => 8,
                'street'       => 'Third Boulevard',
                'barangay'     => 'Barangay Tres',
                'zip_code'     => '1002',
                'house_number' => '789',
            ],
            [
                'client_id'    => 9,
                'street'       => 'Fourth Road',
                'barangay'     => 'Barangay Quatro',
                'zip_code'     => '1003',
                'house_number' => '101',
            ],
            [
                'client_id'    => 9,
                'street'       => 'Fifth Street',
                'barangay'     => 'Barangay Cinco',
                'zip_code'     => '1004',
                'house_number' => '112',
            ],
        ];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}

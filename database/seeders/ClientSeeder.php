<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ClientProfile;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Attachment;

class ClientSeeder extends Seeder
{
    private string $sourceImagePath = 'images/anime-girl.jpg';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding clients with complete profiles...');

        $clientsData = [
            [
                'name' => 'Pedro Jose Gonzales',
                'email' => 'pedro.gonzales@example.com',
                'phone_number' => '+63 920 111 2222',
                'profile' => [
                    'rating' => 4.8,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Maginhawa Street',
                    'barangay' => 'Teachers Village East',
                    'house_number' => '123',
                    'zip_code' => '1101',
                ],
            ],
            [
                'name' => 'Rosa Maria Villanueva',
                'email' => 'rosa.villanueva@example.com',
                'phone_number' => '+63 921 222 3333',
                'profile' => [
                    'rating' => 4.9,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Makati Avenue',
                    'barangay' => 'Poblacion',
                    'house_number' => '456-A',
                    'zip_code' => '1210',
                ],
            ],
            [
                'name' => 'Carlos Miguel Mendoza',
                'email' => 'carlos.mendoza@example.com',
                'phone_number' => '+63 922 333 4444',
                'profile' => [
                    'rating' => 4.7,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Gorordo Avenue',
                    'barangay' => 'Lahug',
                    'house_number' => '789',
                    'zip_code' => '6000',
                ],
            ],
            [
                'name' => 'Isabella Grace Tan',
                'email' => 'isabella.tan@example.com',
                'phone_number' => '+63 923 444 5555',
                'profile' => [
                    'rating' => 5.0,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Session Road',
                    'barangay' => 'Burnham-Legarda',
                    'house_number' => '25',
                    'zip_code' => '2600',
                ],
            ],
            [
                'name' => 'Antonio Luis Garcia',
                'email' => 'antonio.garcia@example.com',
                'phone_number' => '+63 924 555 6666',
                'profile' => [
                    'rating' => 4.5,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'J.P. Laurel Avenue',
                    'barangay' => 'Bajada',
                    'house_number' => '100',
                    'zip_code' => '8000',
                ],
            ],
            [
                'name' => 'Maricel Joy Ramos',
                'email' => 'maricel.ramos@example.com',
                'phone_number' => '+63 925 666 7777',
                'profile' => [
                    'rating' => 4.6,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Real Street',
                    'barangay' => 'Tacloban City Proper',
                    'house_number' => '88',
                    'zip_code' => '6500',
                ],
            ],
            [
                'name' => 'Roberto James Santos',
                'email' => 'roberto.santos@example.com',
                'phone_number' => '+63 926 777 8888',
                'profile' => [
                    'rating' => 4.4,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Rizal Boulevard',
                    'barangay' => 'Poblacion',
                    'house_number' => '55',
                    'zip_code' => '6200',
                ],
            ],
            [
                'name' => 'Christine Anne Lim',
                'email' => 'christine.lim@example.com',
                'phone_number' => '+63 927 888 9999',
                'profile' => [
                    'rating' => 4.9,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Tomas Morato Avenue',
                    'barangay' => 'South Triangle',
                    'house_number' => '201',
                    'zip_code' => '1103',
                ],
            ],
            [
                'name' => 'Mark Anthony Aquino',
                'email' => 'mark.aquino@example.com',
                'phone_number' => '+63 928 999 0000',
                'profile' => [
                    'rating' => 4.3,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Lacson Street',
                    'barangay' => 'Bacolod City Proper',
                    'house_number' => '77',
                    'zip_code' => '6100',
                ],
            ],
            [
                'name' => 'Jennifer Mae Torres',
                'email' => 'jennifer.torres@example.com',
                'phone_number' => '+63 929 000 1111',
                'profile' => [
                    'rating' => 4.7,
                    'is_suspended' => false,
                ],
                'address' => [
                    'street' => 'Governor Camins Avenue',
                    'barangay' => 'Zone IV',
                    'house_number' => '33',
                    'zip_code' => '7000',
                ],
            ],
        ];

        foreach ($clientsData as $data) {
            // Create profile image attachment using Storage
            $profileAttachment = $this->storeImage('profiles', 'client-profile');

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'role' => 'client',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_admin' => false,
                'profile_image_id' => $profileAttachment->id,
            ]);

            // Create client profile with same ID
            ClientProfile::create(array_merge(
                ['id' => $user->id],
                $data['profile']
            ));

            // Create address
            Address::create(array_merge(
                ['client_id' => $user->id],
                $data['address']
            ));

            // Create cart
            Cart::create([
                'client_id' => $user->id,
            ]);
        }

        $this->command->info('Created ' . count($clientsData) . ' clients with complete profiles, addresses, and carts.');
    }

    /**
     * Store image to storage disk and create attachment record
     * Similar to: $file->store('folder', 'public')
     */
    private function storeImage(string $folder, string $prefix): Attachment
    {
        // Get the source file from public directory
        $sourcePath = public_path($this->sourceImagePath);
        $originalFilename = basename($this->sourceImagePath);
        
        // Generate unique filename
        $filename = $prefix . '-' . Str::uuid() . '.jpg';
        
        // Read file content
        $fileContent = File::get($sourcePath);
        
        // Store to public disk (similar to $file->store('folder', 'public'))
        $path = $folder . '/' . $filename;
        Storage::disk('public')->put($path, $fileContent);

        // Get mime type
        $mimeType = File::mimeType($sourcePath);

        // Create and return attachment record
        return Attachment::create([
            'filename' => $originalFilename,
            'path' => $path,
            'mime_type' => $mimeType,
        ]);
    }
}

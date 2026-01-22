<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ArtistProfile;
use App\Models\ArtistPayment;
use App\Models\Attachment;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\Artwork;
use App\Models\ArtworkImage;

class ArtistSeeder extends Seeder
{
    private string $sourceImagePath = 'images/anime-girl.jpg';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding artists with complete profiles...');

        // Get existing tags
        $tags = Tag::all()->keyBy('name');
        $categories = Category::all()->keyBy('name');

        $artistsData = [
            [
                'name' => 'Maria Clara Santos',
                'email' => 'maria.santos@example.com',
                'phone_number' => '+63 917 123 4567',
                'profile' => [
                    'location' => 'Cebu City, Cebu',
                    'gender' => 'female',
                    'username' => 'maria_arts',
                    'birthdate' => '1995-03-15',
                    'bio' => 'Award-winning portrait and oil painting artist from Cebu. Specializing in realistic portraits and vibrant Filipino cultural themes. Graduate of UP College of Fine Arts with 8 years of professional experience.',
                    'max_commissions' => 5,
                    'status' => 'fully-verified',
                    'is_suspended' => false,
                    'rating' => 4.8,
                    'available' => true,
                ],
                'payment' => [
                    'payment_method' => 'GCash',
                    'account_number' => '09171234567',
                    'account_name' => 'Maria Clara Santos',
                ],
                'tags' => ['Oil Paint', 'Acrylic', 'Charcoal'],
                'services' => [
                    [
                        'category' => 'Portrait',
                        'price_rate' => 2500.00,
                        'rush_price_rate' => 4000.00,
                        'normal_timeframe' => '7 days',
                        'rush_timeframe' => '3 days',
                        'tags' => ['Oil', 'Acrylic', 'Charcoal'],
                    ],
                    [
                        'category' => 'Painting',
                        'price_rate' => 3500.00,
                        'rush_price_rate' => 5500.00,
                        'normal_timeframe' => '14 days',
                        'rush_timeframe' => '7 days',
                        'tags' => ['Oil Paint', 'Acrylic', 'Watercolor'],
                    ],
                ],
                'artworks' => [
                    [
                        'category' => 'Portrait',
                        'title' => 'Filipina Beauty',
                        'description' => 'A vibrant portrait celebrating the natural beauty and grace of the Filipina woman. Features bold colors and expressive brushwork inspired by traditional Filipino aesthetics.',
                        'width' => 24, 'height' => 36, 'unit' => 'inches',
                        'price' => 8500.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Oil Paint'],
                    ],
                    [
                        'category' => 'Painting',
                        'title' => 'Sunset in Bantayan',
                        'description' => 'Capturing the magical golden hour at Bantayan Island. The warm hues of the sunset reflect on the crystal-clear waters of this Cebuano paradise.',
                        'width' => 30, 'height' => 40, 'unit' => 'inches',
                        'price' => 12000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Acrylic', 'Watercolor'],
                    ],
                ],
            ],
            [
                'name' => 'Juan Paulo dela Cruz',
                'email' => 'juan.delacruz@example.com',
                'phone_number' => '+63 918 234 5678',
                'profile' => [
                    'location' => 'Quezon City, Metro Manila',
                    'gender' => 'male',
                    'username' => 'juan_murals',
                    'birthdate' => '1988-07-22',
                    'bio' => 'Professional muralist and landscape artist with over 15 years of experience. Featured in multiple galleries across Metro Manila. Commissioned for public art installations in BGC and Makati.',
                    'max_commissions' => 3,
                    'status' => 'fully-verified',
                    'is_suspended' => false,
                    'rating' => 4.9,
                    'available' => true,
                ],
                'payment' => [
                    'payment_method' => 'Bank Transfer',
                    'account_number' => '1234567890123',
                    'account_name' => 'Juan Paulo dela Cruz',
                ],
                'tags' => ['Spray Paint', 'Oil', 'Acrylic'],
                'services' => [
                    [
                        'category' => 'Landscape',
                        'price_rate' => 4000.00,
                        'rush_price_rate' => 6500.00,
                        'normal_timeframe' => '21 days',
                        'rush_timeframe' => '10 days',
                        'tags' => ['Oil', 'Acrylic', 'Watercolor'],
                    ],
                    [
                        'category' => 'Mural',
                        'price_rate' => 15000.00,
                        'rush_price_rate' => 25000.00,
                        'normal_timeframe' => '30 days',
                        'rush_timeframe' => '14 days',
                        'tags' => ['Spray Paint', 'Acrylic'],
                    ],
                ],
                'artworks' => [
                    [
                        'category' => 'Landscape',
                        'title' => 'Rice Terraces at Dawn',
                        'description' => 'The majestic Banaue Rice Terraces bathed in the soft light of early morning. Showcasing the incredible agricultural heritage of the Ifugao people.',
                        'width' => 48, 'height' => 36, 'unit' => 'inches',
                        'price' => 18000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Oil', 'Acrylic'],
                    ],
                    [
                        'category' => 'Mural',
                        'title' => 'Jeepney Culture',
                        'description' => 'A large-scale artwork celebrating the iconic Filipino jeepney. Vibrant colors and intricate details capture the spirit of Philippine street culture.',
                        'width' => 96, 'height' => 72, 'unit' => 'inches',
                        'price' => 45000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Spray Paint', 'Acrylic'],
                    ],
                ],
            ],
            [
                'name' => 'Ana Marie Reyes',
                'email' => 'ana.reyes@example.com',
                'phone_number' => '+63 919 345 6789',
                'profile' => [
                    'location' => 'Davao City, Davao del Sur',
                    'gender' => 'female',
                    'username' => 'ana_sketches',
                    'birthdate' => '1998-11-08',
                    'bio' => 'Young emerging artist specializing in detailed pencil drawings and charcoal portraits. Known for capturing emotions and stories through simple strokes. Featured in Davao Art Festival 2024.',
                    'max_commissions' => 8,
                    'status' => 'fully-verified',
                    'is_suspended' => false,
                    'rating' => 4.7,
                    'available' => true,
                ],
                'payment' => [
                    'payment_method' => 'PayMaya',
                    'account_number' => '09193456789',
                    'account_name' => 'Ana Marie Reyes',
                ],
                'tags' => ['Charcoal', 'Pencil', 'Graphite', 'Pastels'],
                'services' => [
                    [
                        'category' => 'Drawing',
                        'price_rate' => 1500.00,
                        'rush_price_rate' => 2500.00,
                        'normal_timeframe' => '5 days',
                        'rush_timeframe' => '2 days',
                        'tags' => ['Charcoal', 'Pencil', 'Graphite'],
                    ],
                    [
                        'category' => 'Portrait',
                        'price_rate' => 2000.00,
                        'rush_price_rate' => 3500.00,
                        'normal_timeframe' => '7 days',
                        'rush_timeframe' => '3 days',
                        'tags' => ['Charcoal', 'Graphite', 'Pastels'],
                    ],
                ],
                'artworks' => [
                    [
                        'category' => 'Drawing',
                        'title' => 'Street Vendor',
                        'description' => 'A detailed charcoal study of a sari-sari store vendor. Capturing the quiet dignity and resilience of everyday Filipino life.',
                        'width' => 18, 'height' => 24, 'unit' => 'inches',
                        'price' => 3500.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Charcoal', 'Graphite'],
                    ],
                    [
                        'category' => 'Portrait',
                        'title' => 'Lola\'s Hands',
                        'description' => 'A touching portrait focusing on the weathered hands of a Filipino grandmother, telling stories of a lifetime of love and labor.',
                        'width' => 20, 'height' => 24, 'unit' => 'inches',
                        'price' => 5500.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Charcoal', 'Pastels'],
                    ],
                ],
            ],
            [
                'name' => 'Miguel Angelo Bautista',
                'email' => 'miguel.bautista@example.com',
                'phone_number' => '+63 920 456 7890',
                'profile' => [
                    'location' => 'Baguio City, Benguet',
                    'gender' => 'male',
                    'username' => 'miguel_canvas',
                    'birthdate' => '1992-01-20',
                    'bio' => 'Baguio-based artist inspired by the Cordillera mountains and indigenous culture. Specializes in landscape paintings with a focus on nature and environmental themes.',
                    'max_commissions' => 4,
                    'status' => 'fully-verified',
                    'is_suspended' => false,
                    'rating' => 4.6,
                    'available' => true,
                ],
                'payment' => [
                    'payment_method' => 'GCash',
                    'account_number' => '09204567890',
                    'account_name' => 'Miguel Angelo Bautista',
                ],
                'tags' => ['Oil Paint', 'Acrylic', 'Watercolor'],
                'services' => [
                    [
                        'category' => 'Landscape',
                        'price_rate' => 3500.00,
                        'rush_price_rate' => 5500.00,
                        'normal_timeframe' => '14 days',
                        'rush_timeframe' => '7 days',
                        'tags' => ['Oil', 'Acrylic', 'Watercolor'],
                    ],
                ],
                'artworks' => [
                    [
                        'category' => 'Landscape',
                        'title' => 'Strawberry Fields Forever',
                        'description' => 'The famous strawberry farms of La Trinidad with the morning mist rolling over the Cordillera mountains.',
                        'width' => 36, 'height' => 24, 'unit' => 'inches',
                        'price' => 14000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Oil Paint', 'Acrylic'],
                    ],
                ],
            ],
            [
                'name' => 'Sofia Isabelle Cruz',
                'email' => 'sofia.cruz@example.com',
                'phone_number' => '+63 921 567 8901',
                'profile' => [
                    'location' => 'Iloilo City, Iloilo',
                    'gender' => 'female',
                    'username' => 'sofia_watercolors',
                    'birthdate' => '1996-05-12',
                    'bio' => 'Watercolor specialist from the City of Love. Creates dreamy, ethereal artworks inspired by Ilonggo heritage and the beautiful churches of Iloilo.',
                    'max_commissions' => 6,
                    'status' => 'semi-verified',
                    'is_suspended' => false,
                    'rating' => 4.5,
                    'available' => true,
                ],
                'payment' => [
                    'payment_method' => 'GCash',
                    'account_number' => '09215678901',
                    'account_name' => 'Sofia Isabelle Cruz',
                ],
                'tags' => ['Watercolor', 'Pastels', 'Ink'],
                'services' => [
                    [
                        'category' => 'Painting',
                        'price_rate' => 2000.00,
                        'rush_price_rate' => 3500.00,
                        'normal_timeframe' => '10 days',
                        'rush_timeframe' => '5 days',
                        'tags' => ['Watercolor', 'Pastels'],
                    ],
                ],
                'artworks' => [
                    [
                        'category' => 'Painting',
                        'title' => 'Miagao Church',
                        'description' => 'A watercolor interpretation of the UNESCO World Heritage Miagao Church, showcasing its unique baroque architecture.',
                        'width' => 24, 'height' => 18, 'unit' => 'inches',
                        'price' => 7500.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Watercolor'],
                    ],
                ],
            ],
        ];

        foreach ($artistsData as $data) {
            // Create profile image attachment using Storage
            $profileAttachment = $this->storeImage('profiles', 'profile');
            $coverAttachment = $this->storeImage('covers', 'cover');

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'role' => 'artist',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'is_admin' => false,
                'profile_image_id' => $profileAttachment->id,
                'cover_image_id' => $coverAttachment->id,
            ]);

            // Create artist profile with same ID
            $profile = ArtistProfile::create(array_merge(
                ['id' => $user->id],
                $data['profile']
            ));

            // Create artist payment info
            ArtistPayment::create(array_merge(
                ['artist_id' => $user->id],
                $data['payment']
            ));

            // Attach tags to artist
            $tagIds = [];
            foreach ($data['tags'] as $tagName) {
                if (isset($tags[$tagName])) {
                    $tagIds[] = $tags[$tagName]->id;
                }
            }
            if (!empty($tagIds)) {
                $profile->tags()->attach($tagIds);
            }

            // Create services
            foreach ($data['services'] as $serviceData) {
                $category = $categories[$serviceData['category']] ?? null;
                if (!$category) continue;

                $service = Service::create([
                    'artist_id' => $user->id,
                    'category_id' => $category->id,
                    'price_rate' => $serviceData['price_rate'],
                    'rush_price_rate' => $serviceData['rush_price_rate'],
                    'normal_timeframe' => $serviceData['normal_timeframe'],
                    'rush_timeframe' => $serviceData['rush_timeframe'],
                    'status' => 'open',
                ]);

                // Add service image using Storage
                $serviceAttachment = $this->storeImage('services', 'service');
                ServiceImage::create([
                    'service_id' => $service->id,
                    'attachment_id' => $serviceAttachment->id,
                ]);

                // Add service tags
                $serviceTagIds = [];
                foreach ($serviceData['tags'] as $tagName) {
                    if (isset($tags[$tagName])) {
                        $serviceTagIds[] = $tags[$tagName]->id;
                    }
                }
                if (!empty($serviceTagIds)) {
                    $service->tags()->attach($serviceTagIds);
                }
            }

            // Create artworks
            foreach ($data['artworks'] as $artworkData) {
                $category = $categories[$artworkData['category']] ?? null;
                if (!$category) continue;

                $artwork = Artwork::create([
                    'artist_id' => $user->id,
                    'category_id' => $category->id,
                    'title' => $artworkData['title'],
                    'description' => $artworkData['description'],
                    'width' => $artworkData['width'],
                    'height' => $artworkData['height'],
                    'unit' => $artworkData['unit'],
                    'price' => $artworkData['price'],
                    'stock' => $artworkData['stock'],
                    'is_showcase' => $artworkData['is_showcase'],
                    'status' => $artworkData['status'],
                ]);

                // Add artwork image using Storage
                $artworkAttachment = $this->storeImage('artworks', 'artwork');
                ArtworkImage::create([
                    'artwork_id' => $artwork->id,
                    'attachment_id' => $artworkAttachment->id,
                ]);

                // Add artwork tags
                $artworkTagIds = [];
                foreach ($artworkData['tags'] as $tagName) {
                    if (isset($tags[$tagName])) {
                        $artworkTagIds[] = $tags[$tagName]->id;
                    }
                }
                if (!empty($artworkTagIds)) {
                    $artwork->tags()->attach($artworkTagIds);
                }
            }
        }

        $this->command->info('Created ' . count($artistsData) . ' artists with complete profiles, services, and artworks.');
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

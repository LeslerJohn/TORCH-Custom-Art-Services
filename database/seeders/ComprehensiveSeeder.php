<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\User;
use App\Models\ClientProfile;
use App\Models\ArtistProfile;
use App\Models\ArtistPayment;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Attachment;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\Artwork;
use App\Models\ArtworkImage;
use App\Models\Discount;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ClientLiked;
use App\Models\Request;
use App\Models\RequestImage;
use App\Models\Delivery;
use App\Models\Commission;
use App\Models\Draft;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderReview;
use App\Models\CommissionReview;
use App\Models\Payment;
use App\Models\Payout;

class ComprehensiveSeeder extends Seeder
{
    /**
     * Source image path for seeding
     */
    private string $sourceImagePath = 'images/anime-girl.jpg';

    /**
     * Store created entities for reference
     */
    private array $artists = [];
    private array $clients = [];
    private array $services = [];
    private array $artworks = [];

    /**
     * Categories and tags collections
     */
    private $categories;
    private $tags;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Comprehensive Seeder...');

        // Run DatabaseSeeder first to ensure categories and tags exist
        $this->call(DatabaseSeeder::class);

        // Get existing categories and tags
        $this->categories = Category::all()->keyBy('name');
        $this->tags = Tag::all()->keyBy('name');

        // Debug: Check if categories and tags are loaded
        $this->command->info('Loaded ' . $this->categories->count() . ' categories and ' . $this->tags->count() . ' tags.');

        // Seed Artists with full profiles, services, and artworks
        $this->seedArtists();

        // Seed Clients with addresses and carts
        $this->seedClients();

        // Seed client interactions (likes, cart items)
        $this->seedClientInteractions();

        // Seed complete order flow
        $this->seedOrders();

        // Seed complete commission flow
        $this->seedCommissions();

        $this->command->info('Comprehensive Seeder completed successfully!');
        $this->command->info('Created: ' . count($this->artists) . ' artists, ' . count($this->services) . ' services, ' . count($this->artworks) . ' artworks, ' . count($this->clients) . ' clients');
    }

    /**
     * Store image to storage disk and create attachment record
     */
    private function storeImage(string $folder, string $prefix): Attachment
    {
        $sourcePath = public_path($this->sourceImagePath);
        $originalFilename = basename($this->sourceImagePath);
        $filename = $prefix . '-' . Str::uuid() . '.jpg';
        $fileContent = File::get($sourcePath);
        $path = $folder . '/' . $filename;
        Storage::disk('public')->put($path, $fileContent);
        $mimeType = File::mimeType($sourcePath);

        return Attachment::create([
            'filename' => $originalFilename,
            'path' => $path,
            'mime_type' => $mimeType,
        ]);
    }

    /**
     * Seed artists with complete profiles, services, and artworks
     */
    private function seedArtists(): void
    {
        $this->command->info('Seeding artists with services and artworks...');

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
                        'discount' => ['type' => 'off_product', 'value' => 10, 'value_type' => 'percentage'],
                    ],
                    [
                        'category' => 'Painting',
                        'title' => 'Sunset in Bantayan',
                        'description' => 'Capturing the magical golden hour at Bantayan Island. The warm hues of the sunset reflect on the crystal-clear waters of this Cebuano paradise.',
                        'width' => 30, 'height' => 40, 'unit' => 'inches',
                        'price' => 12000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Acrylic', 'Watercolor'],
                    ],
                    [
                        'category' => 'Portrait',
                        'title' => 'The Elder',
                        'description' => 'A powerful portrait of a Visayan elder, capturing the wisdom and stories etched in every wrinkle.',
                        'width' => 20, 'height' => 24, 'unit' => 'inches',
                        'price' => 6500.00, 'stock' => 1, 'is_showcase' => false, 'status' => 'sale',
                        'tags' => ['Charcoal'],
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
                        'discount' => ['type' => 'off_product', 'value' => 5000, 'value_type' => 'fixed'],
                    ],
                    [
                        'category' => 'Landscape',
                        'title' => 'Manila Bay Sunset',
                        'description' => 'The legendary Manila Bay sunset that has inspired artists for generations. Golden light illuminates the iconic Manila skyline.',
                        'width' => 40, 'height' => 30, 'unit' => 'inches',
                        'price' => 22000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Oil', 'Acrylic'],
                    ],
                    [
                        'category' => 'Landscape',
                        'title' => 'Palawan Paradise',
                        'description' => 'Crystal clear waters and limestone cliffs of El Nido, Palawan. A tribute to one of the world\'s most beautiful islands.',
                        'width' => 36, 'height' => 24, 'unit' => 'inches',
                        'price' => 16000.00, 'stock' => 1, 'is_showcase' => false, 'status' => 'sale',
                        'tags' => ['Acrylic', 'Watercolor'],
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
                    [
                        'category' => 'Drawing',
                        'title' => 'Tarsier Study',
                        'description' => 'An intimate pencil portrait of the Philippine tarsier, one of the world\'s smallest primates. Every detail of its expressive eyes is meticulously rendered.',
                        'width' => 12, 'height' => 16, 'unit' => 'inches',
                        'price' => 2800.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Pencil', 'Graphite'],
                    ],
                    [
                        'category' => 'Drawing',
                        'title' => 'Fisherman at Work',
                        'description' => 'A dynamic sketch capturing the movement and strength of a Filipino fisherman casting his net at sunrise.',
                        'width' => 16, 'height' => 20, 'unit' => 'inches',
                        'price' => 3200.00, 'stock' => 1, 'is_showcase' => false, 'status' => 'sale',
                        'tags' => ['Charcoal'],
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
                    [
                        'category' => 'Painting',
                        'price_rate' => 4000.00,
                        'rush_price_rate' => 6000.00,
                        'normal_timeframe' => '14 days',
                        'rush_timeframe' => '7 days',
                        'tags' => ['Oil Paint', 'Acrylic'],
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
                    [
                        'category' => 'Landscape',
                        'title' => 'Pine Trees of Baguio',
                        'description' => 'The iconic pine trees of the Summer Capital, standing tall against the cool mountain breeze.',
                        'width' => 30, 'height' => 40, 'unit' => 'inches',
                        'price' => 16000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Oil', 'Acrylic'],
                    ],
                    [
                        'category' => 'Painting',
                        'title' => 'Igorot Warrior',
                        'description' => 'A powerful depiction of a traditional Igorot warrior, celebrating the rich heritage of the Cordillera people.',
                        'width' => 24, 'height' => 36, 'unit' => 'inches',
                        'price' => 18000.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Oil Paint'],
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
                    [
                        'category' => 'Painting',
                        'title' => 'Jaro Cathedral',
                        'description' => 'The historic Jaro Cathedral at sunset, painted in soft watercolor hues that capture the spiritual atmosphere.',
                        'width' => 20, 'height' => 16, 'unit' => 'inches',
                        'price' => 6500.00, 'stock' => 1, 'is_showcase' => true, 'status' => 'sale',
                        'tags' => ['Watercolor', 'Pastels'],
                    ],
                    [
                        'category' => 'Painting',
                        'title' => 'Iloilo River Esplanade',
                        'description' => 'A peaceful evening scene along the Iloilo River Esplanade, with city lights reflecting on the water.',
                        'width' => 30, 'height' => 20, 'unit' => 'inches',
                        'price' => 8500.00, 'stock' => 1, 'is_showcase' => false, 'status' => 'sale',
                        'tags' => ['Watercolor'],
                    ],
                ],
            ],
        ];

        foreach ($artistsData as $data) {
            $profileAttachment = $this->storeImage('profiles', 'profile');
            $coverAttachment = $this->storeImage('covers', 'cover');

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

            $profile = ArtistProfile::create(array_merge(
                ['id' => $user->id],
                $data['profile']
            ));

            ArtistPayment::create(array_merge(
                ['artist_id' => $user->id],
                $data['payment']
            ));

            // Attach tags to artist
            $tagIds = [];
            foreach ($data['tags'] as $tagName) {
                if (isset($this->tags[$tagName])) {
                    $tagIds[] = $this->tags[$tagName]->id;
                }
            }
            if (!empty($tagIds)) {
                $profile->tags()->attach($tagIds);
            }

            // Create services
            foreach ($data['services'] as $serviceData) {
                $category = $this->categories[$serviceData['category']] ?? null;
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

                // Add multiple service images
                for ($i = 0; $i < 2; $i++) {
                    $serviceAttachment = $this->storeImage('services', 'service');
                    ServiceImage::create([
                        'service_id' => $service->id,
                        'attachment_id' => $serviceAttachment->id,
                    ]);
                }

                $serviceTagIds = [];
                foreach ($serviceData['tags'] as $tagName) {
                    if (isset($this->tags[$tagName])) {
                        $serviceTagIds[] = $this->tags[$tagName]->id;
                    }
                }
                if (!empty($serviceTagIds)) {
                    $service->tags()->attach($serviceTagIds);
                }

                $this->services[] = $service;
            }

            // Create artworks
            foreach ($data['artworks'] as $artworkData) {
                $category = $this->categories[$artworkData['category']] ?? null;
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

                // Add multiple artwork images
                for ($i = 0; $i < 2; $i++) {
                    $artworkAttachment = $this->storeImage('artworks', 'artwork');
                    ArtworkImage::create([
                        'artwork_id' => $artwork->id,
                        'attachment_id' => $artworkAttachment->id,
                    ]);
                }

                $artworkTagIds = [];
                foreach ($artworkData['tags'] as $tagName) {
                    if (isset($this->tags[$tagName])) {
                        $artworkTagIds[] = $this->tags[$tagName]->id;
                    }
                }
                if (!empty($artworkTagIds)) {
                    $artwork->tags()->attach($artworkTagIds);
                }

                // Create discount if specified
                if (isset($artworkData['discount'])) {
                    Discount::create([
                        'artwork_id' => $artwork->id,
                        'type' => $artworkData['discount']['type'],
                        'value' => $artworkData['discount']['value'],
                        'value_type' => $artworkData['discount']['value_type'],
                        'status' => 'active',
                    ]);
                }

                $this->artworks[] = $artwork;
            }

            $this->artists[] = $user;
        }

        $this->command->info('Created ' . count($this->artists) . ' artists with ' . count($this->services) . ' services and ' . count($this->artworks) . ' artworks.');
    }

    /**
     * Seed clients with addresses and carts
     */
    private function seedClients(): void
    {
        $this->command->info('Seeding clients...');

        $clientsData = [
            [
                'name' => 'Pedro Jose Gonzales',
                'email' => 'pedro.gonzales@example.com',
                'phone_number' => '+63 920 111 2222',
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
                'address' => [
                    'street' => 'J.P. Laurel Avenue',
                    'barangay' => 'Bajada',
                    'house_number' => '100',
                    'zip_code' => '8000',
                ],
            ],
        ];

        foreach ($clientsData as $data) {
            $profileAttachment = $this->storeImage('profiles', 'client-profile');

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

            ClientProfile::create([
                'id' => $user->id,
                'rating' => fake()->randomFloat(1, 4.0, 5.0),
                'is_suspended' => false,
            ]);

            Address::create(array_merge(
                ['client_id' => $user->id],
                $data['address']
            ));

            Cart::create([
                'client_id' => $user->id,
            ]);

            $this->clients[] = $user;
        }

        $this->command->info('Created ' . count($this->clients) . ' clients.');
    }

    /**
     * Seed client interactions (likes, cart items)
     */
    private function seedClientInteractions(): void
    {
        $this->command->info('Seeding client interactions...');

        if (empty($this->clients) || empty($this->artworks)) {
            return;
        }

        // Each client likes multiple artworks
        foreach ($this->clients as $clientIndex => $client) {
            // Each client likes 3-5 random artworks
            $artworksToLike = array_rand($this->artworks, min(4, count($this->artworks)));
            if (!is_array($artworksToLike)) {
                $artworksToLike = [$artworksToLike];
            }
            
            foreach ($artworksToLike as $artworkIndex) {
                ClientLiked::create([
                    'client_id' => $client->id,
                    'artwork_id' => $this->artworks[$artworkIndex]->id,
                ]);
            }
        }

        // Add items to carts
        foreach ($this->clients as $index => $client) {
            $cart = Cart::where('client_id', $client->id)->first();
            if ($cart && isset($this->artworks[$index]) && $this->artworks[$index]->status === 'sale') {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'artwork_id' => $this->artworks[$index]->id,
                ]);
            }
        }

        $this->command->info('Created client interactions (likes and cart items).');
    }

    /**
     * Seed complete order flow with payments and reviews
     */
    private function seedOrders(): void
    {
        $this->command->info('Seeding orders with complete flow...');

        if (empty($this->clients) || empty($this->artworks)) {
            return;
        }

        // Create 2 completed orders
        $ordersData = [
            ['client_index' => 0, 'artwork_index' => 0, 'rating' => 5, 'comment' => 'Absolutely stunning artwork! The colors are even more vibrant in person. Highly recommended!'],
            ['client_index' => 1, 'artwork_index' => 6, 'rating' => 4, 'comment' => 'Beautiful piece, very happy with my purchase. Shipping was fast and packaging was excellent.'],
        ];

        foreach ($ordersData as $orderData) {
            if (!isset($this->clients[$orderData['client_index']]) || !isset($this->artworks[$orderData['artwork_index']])) {
                continue;
            }

            $client = $this->clients[$orderData['client_index']];
            $artwork = $this->artworks[$orderData['artwork_index']];
            $address = Address::where('client_id', $client->id)->first();

            if (!$address) continue;

            $delivery = Delivery::create([
                'address_id' => $address->id,
                'expected_delivery' => Carbon::now()->addDays(7),
                'status' => 'delivered',
            ]);

            $order = Order::create([
                'client_id' => $client->id,
                'total' => $artwork->price,
                'delivery_id' => $delivery->id,
                'status' => 'completed',
                'created_at' => Carbon::now()->subDays(14),
                'updated_at' => Carbon::now(),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'artwork_id' => $artwork->id,
                'price' => $artwork->price,
            ]);

            $transactionId = 'GCASH-' . Carbon::now()->format('YmdHis') . '-' . Str::random(6);
            $payment = Payment::create([
                'client_id' => $client->id,
                'order_id' => $order->id,
                'amount' => $artwork->price,
                'payment_method' => 'GCash',
                'transaction_id' => $transactionId,
                'status' => 'completed',
            ]);

            $serviceFee = 10;
            $companyCut = $artwork->price * ($serviceFee / 100);
            $netAmount = $artwork->price - $companyCut;

            Payout::create([
                'artist_id' => $artwork->artist_id,
                'payment_id' => $payment->id,
                'amount' => $artwork->price,
                'service_fee' => $serviceFee,
                'net_amount' => $netAmount,
                'company_cut' => $companyCut,
                'payout_type' => 'order',
                'payout_method' => 'GCash',
                'status' => 'completed',
                'transaction_id' => 'PAYOUT-' . Str::random(10),
            ]);

            OrderReview::create([
                'order_id' => $order->id,
                'rating' => $orderData['rating'],
                'comment' => $orderData['comment'],
            ]);

            $artwork->update(['status' => 'sold', 'stock' => 0]);
        }

        $this->command->info('Created ' . count($ordersData) . ' completed orders with payments and reviews.');
    }

    /**
     * Seed complete commission flow
     */
    private function seedCommissions(): void
    {
        $this->command->info('Seeding commissions with complete flow...');

        if (count($this->clients) < 3 || empty($this->services)) {
            return;
        }

        $commissionsData = [
            [
                'client_index' => 2,
                'service_index' => 0,
                'description' => 'Custom family portrait with 4 people - parents and 2 children. Prefer oil painting style.',
                'order_type' => 'rush',
                'status' => 'completed',
                'rating' => 5,
                'comment' => 'Amazing work! The artist captured our family perfectly. Will definitely commission again!',
            ],
            [
                'client_index' => 3,
                'service_index' => 2,
                'description' => 'Landscape painting of our family farm in Batangas. Would like to include the mountains in the background.',
                'order_type' => 'normal',
                'status' => 'wip',
                'rating' => null,
                'comment' => null,
            ],
        ];

        foreach ($commissionsData as $commData) {
            if (!isset($this->clients[$commData['client_index']]) || !isset($this->services[$commData['service_index']])) {
                continue;
            }

            $client = $this->clients[$commData['client_index']];
            $service = $this->services[$commData['service_index']];
            $address = Address::where('client_id', $client->id)->first();

            if (!$address) continue;

            $deadline = Carbon::now()->addDays($commData['order_type'] === 'rush' ? 7 : 21);
            $price = $commData['order_type'] === 'rush' ? $service->rush_price_rate : $service->price_rate;

            $request = Request::create([
                'client_id' => $client->id,
                'service_id' => $service->id,
                'description' => $commData['description'],
                'height' => '24',
                'width' => '36',
                'unit' => 'inches',
                'quantity' => 1,
                'deadline' => $deadline,
                'total_price' => $price,
                'order_type' => $commData['order_type'],
                'status' => 'accepted',
                'created_at' => Carbon::now()->subDays(21),
            ]);

            $requestAttachment = $this->storeImage('references', 'reference');
            RequestImage::create([
                'request_id' => $request->id,
                'attachment_id' => $requestAttachment->id,
            ]);

            $deliveryStatus = $commData['status'] === 'completed' ? 'delivered' : 'pending';
            $delivery = Delivery::create([
                'address_id' => $address->id,
                'expected_delivery' => $deadline->copy()->addDays(3),
                'status' => $deliveryStatus,
            ]);

            $commission = Commission::create([
                'request_id' => $request->id,
                'delivery_id' => $delivery->id,
                'deadline' => $deadline,
                'is_extended' => false,
                'status' => $commData['status'],
                'created_at' => Carbon::now()->subDays(21),
            ]);

            // Create draft
            $draftAttachment = $this->storeImage('drafts', 'draft');
            Draft::create([
                'commission_id' => $commission->id,
                'description' => 'Initial concept sketch - please review and provide feedback.',
                'attachment_id' => $draftAttachment->id,
            ]);

            // Create payment
            $transactionId = 'GCASH-' . Carbon::now()->format('YmdHis') . '-' . Str::random(6);
            $payment = Payment::create([
                'client_id' => $client->id,
                'commission_id' => $commission->id,
                'request_id' => $request->id,
                'amount' => $price,
                'payment_method' => 'GCash',
                'transaction_id' => $transactionId,
                'status' => 'completed',
            ]);

            // Create payout only for completed commissions
            if ($commData['status'] === 'completed') {
                $serviceFee = 10;
                $companyCut = $price * ($serviceFee / 100);
                $netAmount = $price - $companyCut;

                Payout::create([
                    'artist_id' => $service->artist_id,
                    'payment_id' => $payment->id,
                    'amount' => $price,
                    'service_fee' => $serviceFee,
                    'net_amount' => $netAmount,
                    'company_cut' => $companyCut,
                    'payout_type' => 'commission',
                    'payout_method' => 'GCash',
                    'status' => 'completed',
                    'transaction_id' => 'PAYOUT-' . Str::random(10),
                ]);

                // Create review
                if ($commData['rating']) {
                    CommissionReview::create([
                        'commission_id' => $commission->id,
                        'rating' => $commData['rating'],
                        'comment' => $commData['comment'],
                    ]);
                }
            }
        }

        $this->command->info('Created ' . count($commissionsData) . ' commissions with payments.');
    }
}

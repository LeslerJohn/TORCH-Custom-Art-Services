<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ClientProfile;
use App\Models\ArtistProfile;
use App\Models\Category;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Seed admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_admin' => true
        ]);

        $categories = [
            'Painting' => ['Oil Paint', 'Acrylic', 'Watercolor'],
            'Drawing' => ['Charcoal', 'Ink', 'Pencil'],
            'Sculpture' => ['Clay', 'Stone', 'Metal'],
            'Photography' => ['Digital', 'Film', 'Drone'],
            'Digital Art' => ['Photoshop', 'Illustrator', 'Procreate'],
        ];

        foreach ($categories as $categoryName => $tags) {
            $category = Category::factory()->create(['name' => $categoryName]);
            $tagModels = collect($tags)->map(function ($tagName) {
            return Tag::factory()->create(['name' => $tagName]);
            });
            $category->tags()->attach($tagModels);
        }
        
        $this->call([
            ArtistSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
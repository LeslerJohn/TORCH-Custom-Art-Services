<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_admin' => true
        ]);

        $categories = [
            'Painting' => ['Oil Paint', 'Acrylic', 'Watercolor', 'Tempera', 'Enamel'],
            'Drawing' => ['Charcoal', 'Ink', 'Pencil', 'Pastels', 'Colored Pencils', 'Graphite', 'Markers'],
            'Landscape' => ['Acrylic', 'Oil', 'Watercolor', 'Pastels'],
            'Mural' => ['Acrylic', 'Spray Paint', 'Oil', 'Latex Paint'],
            'Portrait' => ['Oil', 'Acrylic', 'Charcoal', 'Graphite', 'Colored Pencils', 'Pastels'],
        ];

        foreach ($categories as $categoryName => $tags) {
            $category = Category::factory()->create(['name' => $categoryName]);

            $tagIds = collect($tags)->map(function ($tagName) {
                return Tag::factory()->create(['name' => $tagName])->id;
            })->toArray();

            $category->tags()->attach($tagIds);
        }

        $this->call([
            ArtistSeeder::class,
            ClientSeeder::class
        ]);
    }
}

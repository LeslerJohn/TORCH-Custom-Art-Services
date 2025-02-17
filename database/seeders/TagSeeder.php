<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        // Create some sample tags
        Tag::create(['name' => 'Digital Art']);
        Tag::create(['name' => 'Portrait']);
        Tag::create(['name' => 'Landscape']);
        Tag::create(['name' => 'Abstract']);
        Tag::create(['name' => 'Realism']);
        Tag::create(['name' => 'Surrealism']);
        Tag::create(['name' => 'Impressionism']);
        Tag::create(['name' => 'Expressionism']);
        Tag::create(['name' => 'Cubism']);
        Tag::create(['name' => 'Minimalism']);
    }
}

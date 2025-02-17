<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Portrait'],
            ['name' => 'Landscape'],
            ['name' => 'Abstract'],
            ['name' => 'Realism'],
            ['name' => 'Surrealism'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

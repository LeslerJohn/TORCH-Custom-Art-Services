<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryTag;

class CategoryTagSeeder extends Seeder
{
    public function run()
    {
        // Make sure the category_id and tag_id values exist in their respective tables.
        $categoryTags = [
            ['category_id' => 1, 'tag_id' => 1],
            ['category_id' => 1, 'tag_id' => 2],
            ['category_id' => 2, 'tag_id' => 3],
            ['category_id' => 2, 'tag_id' => 4],
            ['category_id' => 3, 'tag_id' => 5],
            // Add more pivot records as needed...
        ];

        foreach ($categoryTags as $record) {
            CategoryTag::create($record);
        }
    }
}

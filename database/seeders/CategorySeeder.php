<?php

namespace Database\Seeders;

use App\Models\category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        $categories = json_decode(file_get_contents(database_path('data/categories.json')), true);

        foreach ($categories as $category) {
            category::create(array_merge($category, [
                'uuid' => fake()->uuid()
            ]));
        }
    }
}

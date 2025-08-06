<?php

namespace Database\Seeders;

use App\Models\CategoryMovie;
use Illuminate\Database\Seeder;

class CategoryMovieSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        $categoriesMovies = json_decode(file_get_contents(database_path('data/category_movie.json')), true);

        foreach ($categoriesMovies as $categoryMovie) {
            CategoryMovie::create(array_merge($categoryMovie, [
                'uuid' => fake()->uuid()
            ]));
        }
    }
}

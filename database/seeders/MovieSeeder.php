<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        $movies = json_decode(file_get_contents(database_path('data/movies.json')), true);

        foreach ($movies as $movie) {
            Movie::create(array_merge($movie, [
                'uuid' => fake()->uuid(),
            ]));
        }
    }
}

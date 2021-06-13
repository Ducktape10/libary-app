<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BookSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(UserSeeder::class);

        // Generate relations between books and genres
        $genres = Genre::all();
        $genres_count = $genres->count();

        Book::all()->each(function ($post) use (&$genres, &$genres_count) {
            $category_ids = $genres->random(rand(1, $genres_count))->pluck('id')->toArray();
            $post->genres()->attach($category_ids);
        });
    }
}

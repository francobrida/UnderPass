<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = ['Techno', 'House', 'Minimal', 'Acid', 'Tech-House', 'Melodic Techno', 'Progressive', 'Experimental'];

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre,
                'slug' => str($genre)->slug(), // This will create a slug from the genre name.
            ]);
        }
    }
}

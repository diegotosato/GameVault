<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Azione',
            'Avventura',
            'RPG',
            'FPS',
            'TPS',
            'Strategia',
            'Simulazione',
            'Sport',
            'Racing',
            'Battle royale',
            'Survival',
            'Platform',
            'MMO',
            'Horror'
        ];

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre,
                'slug' => Str::slug($genre)
            ]);
        }
    }
}

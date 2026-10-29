<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DevelopersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developers = [
            'Rockstar Games',
            'CD Projekt Red',
            'Ubisoft',
            'Electronic Arts',
            'Activision',
            'Blizzard Entertainment',
            'Bethesda Game Studios',
            'Naughty Dog',
            'Insomniac Games',
            'FromSoftware',
            'Riot Games',
            'Epic Games',
            'Valve',
            'Mojang Studios',
            'Bungie'
        ];

        foreach ($developers as $dev) {
            Developer::create([
                'name' => $dev,
                'slug' => Str::slug($dev),
            ]);
        }
    }
}

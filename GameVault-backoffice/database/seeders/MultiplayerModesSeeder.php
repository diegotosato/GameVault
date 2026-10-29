<?php

namespace Database\Seeders;

use App\Models\MultiplayerMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MultiplayerModesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes = [
            'Coop',
            'Competitivo',
            'PvP',
            'PvE',
            'MMO',
            'Battle royale',
            'Online',
            'Locale'
        ];

        foreach ($modes as $mode) {
            MultiplayerMode::create([
                'name' => $mode,
                'slug' => Str::slug($mode),
            ]);
        }
    }
}

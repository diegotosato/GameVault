<?php

namespace Database\Seeders;

use App\Models\Console;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConsolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consoles = [
            'PC' => '#00ADEF',
            'Playstation' => '#003791',
            'XBOX' => '#107C10',
            'Nintendo' => '#E60012',
        ];

        foreach ($consoles as $key => $value) {
            Console::create([
                'name' => $key,
                'slug' => Str::slug($key),
                'color' => $value,
            ]);
        }
    }
}

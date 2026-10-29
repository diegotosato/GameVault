<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 50; $i++) {
            User::create([
                'name' => $faker->firstName() . " " . $faker->lastName(),
                'email' => $faker->email(),
                'password' => $faker->password(),
                'role' => 'user'
            ]);
        }
    }
}

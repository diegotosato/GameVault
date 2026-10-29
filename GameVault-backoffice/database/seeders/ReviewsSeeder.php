<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Videogame;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $users = User::all();
        $videogames = Videogame::all();

        foreach ($videogames as $game) {
            foreach ($users as $user) {
                $newReview = new Review();

                $newReview->content = $faker->text();
                $newReview->videogame_id = $game->id;
                $newReview->user_id = $user->id;
                $newReview->user_name = $user->name;
                $newReview->created_at = $faker->dateTimeBetween('-6 months', 'now');
                $newReview->updated_at = $newReview->created_at;

                $newReview->save();
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {

        $newReview = new Review();

        $newReview->content = $request->review_text;
        $newReview->videogame_id = $request->videogame_id;
        $newReview->user_id = $request->user_id;
        $newReview->user_name = $request->user_name;

        $newReview->save();

        return response()->json([
            'success' => true,
            'review' => $newReview
        ], 201);
    }
}

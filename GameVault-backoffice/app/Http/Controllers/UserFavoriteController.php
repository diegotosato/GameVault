<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Videogame;
use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // tutti i giochi in wishlist dell'utente loggato
        $wishlist = Favorite::where('user_id', $userId)->with('videogame')->get();

        return response()->json([
            'wishlist' => $wishlist
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'videogame_id' => 'required|integer|exists:videogames,id',
        ]);

        $userId = $request->user()->id;

        // se esiste già, non lo aggiungo
        $exists = Favorite::where('user_id', $userId)
            ->where('videogame_id', $request->videogame_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Game already in wishlist'
            ], 200);
        }

        // Se non esiste, lo aggiungiamo
        $newFav = Favorite::create([
            'user_id' => $userId,
            'videogame_id' => $request->videogame_id,
        ]);

        $wishlist = Favorite::where('user_id', $userId)->get();

        return response()->json([
            'success' => true,
            'message' => 'Videogioco aggiunto alla wishlist',
            'wishlist' => $wishlist,
        ], 201);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'videogame_id' => 'required|integer',
        ]);

        $userId = $request->user()->id;

        Favorite::where('user_id', $userId)
            ->where('videogame_id', $request->videogame_id)
            ->delete();

        $wishlist = Favorite::where('user_id', $userId)->with('videogame')->get();

        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist',
            'wishlist' => $wishlist
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Videogame;
use Illuminate\Http\Request;

class VideogameController extends Controller
{
    public function index(Request $request)
    {
        $query = Videogame::query();

        // filtri console
        if ($request->has('console')) {
            $query->whereHas('consoles', fn($consoleQuery) => $consoleQuery->whereIn('slug', $request->input('console')));
        }

        // filtri generi
        if ($request->has('genre')) {
            $query->whereHas('genres', fn($genreQuery) => $genreQuery->whereIn('slug', $request->input('genre')));
        }

        // filtri multiplayer
        if ($request->has('multi')) {
            $query->whereHas('multiplayerModes', fn($multiModeQuery) => $multiModeQuery->whereIn('slug', $request->input('multi')));
        }

        // ricerca
        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $paginated = $query->with(['consoles', 'genres', 'developer', 'multiplayerModes'])->paginate(10);

        return response()->json([
            'paginated' => $paginated,
            'totalGames' => $query->count()
        ]);
    }

    public function show(Videogame $slug)
    {
        $game = $slug->load(['developer', 'consoles', 'genres', 'multiplayerModes', 'reviews']);
        $reviews = $slug->reviews()->orderBy("created_at", "desc")->paginate(10);

        return response()->json([
            'game' => $game,
            'reviews' => $reviews
        ]);
    }
}

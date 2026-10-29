<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Console;
use App\Models\Developer;
use App\Models\Genre;
use App\Models\MultiplayerMode;
use App\Models\Videogame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideogameController extends Controller
{
    public function index()
    {
        $games = Videogame::with(['developer', 'consoles', 'genres'])->paginate(10);

        return view('admin.videogames.index', compact('games'));
    }

    public function create()
    {
        $consoles = Console::all();
        $genres = Genre::all();
        $developers = Developer::all();
        $multiplayerModes = MultiplayerMode::all();

        return view('admin.videogames.create', compact('consoles', 'genres', 'developers', 'multiplayerModes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'image' => 'required|image|max:4096',
            'developer_id' => 'required|exists:developers,id',
            'consoles' => 'nullable|array',
            'genres' => 'nullable|array',
            'multiplayer_modes' => 'nullable|array',
        ]);

        $slug      = Str::slug($request->name);
        $imagePath = $request->file('image')->store('uploads', 'public');

        $game = Videogame::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'image' => $imagePath,
            'image_alt' => $slug . '-cover',
            'developer_id' => $request->developer_id,
        ]);

        $game->consoles()->sync($request->consoles ?? []);
        $game->genres()->sync($request->genres ?? []);
        $game->multiplayerModes()->sync($request->multiplayer_modes ?? []);

        return redirect()->route('admin.videogames.index')->with('success', 'Videogioco aggiunto con successo.');
    }

    public function show(Videogame $videogame)
    {
        $videogame->load(['consoles', 'genres', 'multiplayerModes']);

        $consoles  = Console::all();
        $genres  = Genre::all();
        $developer  = Developer::all()->where('id', $videogame->developer_id);
        $multiplayerModes = MultiplayerMode::all();

        return view('admin.videogames.show',  compact('videogame', 'consoles', 'genres', 'developer', 'multiplayerModes'));
    }

    public function edit(Videogame $videogame)
    {
        $videogame->load(['consoles', 'genres', 'multiplayerModes']);

        $consoles  = Console::all();
        $genres  = Genre::all();
        $developers  = Developer::all();
        $multiplayerModes = MultiplayerMode::all();

        return view('admin.videogames.edit', compact('videogame', 'consoles', 'genres', 'developers', 'multiplayerModes'));
    }

    public function update(Request $request, Videogame $videogame)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'image' => 'nullable|image|max:4096',
            'developer_id' => 'required|exists:developers,id',
            'consoles' => 'nullable|array',
            'genres' => 'nullable|array',
            'multiplayer_modes' => 'nullable|array',
        ]);

        $slug = Str::slug($request->name);

        $videogame->name = $request->name;
        $videogame->slug = $slug;
        $videogame->description = $request->description;
        $videogame->release_date = $request->release_date;
        $videogame->developer_id = $request->developer_id;
        $videogame->image_alt = $slug . '-cover';

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($videogame->image);
            $videogame->image = $request->file('image')->store('uploads', 'public');
        }

        $videogame->save();

        $videogame->consoles()->sync($request->consoles ?? []);
        $videogame->genres()->sync($request->genres ?? []);
        $videogame->multiplayerModes()->sync($request->multiplayer_modes ?? []);

        return redirect()->route('admin.videogames.index')->with('success', 'Videogioco aggiornato con successo.');
    }

    public function destroy(Videogame $videogame)
    {
        Storage::disk('public')->delete($videogame->image);
        $videogame->delete();

        return redirect()->route('admin.videogames.index')->with('success', 'Videogioco eliminato con successo.');
    }
}

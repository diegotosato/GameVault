<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\MultiplayerMode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MultiplayerModeController extends Controller
{
    public function index()
    {
        $modes = MultiplayerMode::all();

        return view('admin.multiplayer_modes.index', compact('modes'));
    }

    public function create()
    {
        return view('admin.multiplayer_modes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        MultiplayerMode::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.multiplayer_modes.index')->with('success', 'Modalità multiplayer aggiunta con successo.');
    }

    public function edit(MultiplayerMode $multiplayer_mode)
    {
        return view('admin.multiplayer_modes.edit', ['mode' => $multiplayer_mode]);
    }

    public function update(Request $request, MultiplayerMode $multiplayer_mode)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $multiplayer_mode->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.multiplayer_modes.index')->with('success', 'Modalità multiplayer aggiornata con successo.');
    }

    public function destroy(MultiplayerMode $multiplayer_mode)
    {
        $multiplayer_mode->delete();

        return redirect()->route('admin.multiplayer_modes.index')->with('success', 'Modalità multiplayer eliminata con successo.');
    }
}

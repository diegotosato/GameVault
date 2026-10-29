<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Videogame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newGame = new Videogame();

        $newGame->name = $request->name;
        $newGame->slug = $request->slug;
        $newGame->description = $request->description;
        $newGame->release_date = $request->release_date;
        $newGame->image = Storage::disk('public')->putFile('uploads', $request['image']);
        $newGame->image_alt = $request->image_alt;
        $newGame->developer_id = $request->developer_id;

        $newGame->save();

        if ($request->has('consoles')) {
            $newGame->consoles()->attach($request->consoles);
        }

        if ($request->has('genres')) {
            $newGame->genres()->attach($request->genres);
        }

        if ($request->has('multiplayer_modes')) {
            $newGame->multiplayerModes()->attach($request->multiplayer_modes);
        }

        return response()->json([
            'success' => true,
            'videogame' => $newGame->load(['developer', 'consoles', 'genres', 'multiplayerModes'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videogame $admin)
    {
        $admin->name = $request->name;
        $admin->slug = $request->slug;
        $admin->description = $request->description;
        $admin->release_date = $request->release_date;

        if ($request->hasFile('image')) {
            $existingImage = $admin->image;
            if ($existingImage) {
                Storage::disk('public')->delete($existingImage);
            }

            $admin->image = Storage::disk('public')->putFile('uploads', $request['image']);
            $admin->image_alt = $request->image_alt;
        }
        $admin->developer_id = $request->developer_id;

        $admin->save();

        if ($request->has('consoles')) {
            $admin->consoles()->sync($request->consoles);
        }

        if ($request->has('genres')) {
            $admin->genres()->sync($request->genres);
        }

        if ($request->has('multiplayer_modes')) {
            $admin->multiplayerModes()->sync($request->multiplayer_modes);
        }

        return response()->json([
            'success' => true,
            'videogame' => $admin->load(['developer', 'consoles', 'genres', 'multiplayerModes'])
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Videogame $admin)
    {
        $admin->delete();

        return response()->json(['success' => true]);
    }
}

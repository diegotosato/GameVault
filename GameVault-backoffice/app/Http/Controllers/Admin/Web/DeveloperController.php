<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeveloperController extends Controller
{
    public function index()
    {
        $developers = Developer::all();

        return view('admin.developers.index', compact('developers'));
    }

    public function create()
    {
        return view('admin.developers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Developer::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.developers.index')->with('success', 'Sviluppatore aggiunto con successo.');
    }

    public function edit(Developer $developer)
    {
        return view('admin.developers.edit', compact('developer'));
    }

    public function update(Request $request, Developer $developer)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $developer->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.developers.index')->with('success', 'Sviluppatore aggiornato con successo.');
    }

    public function destroy(Developer $developer)
    {
        $developer->delete();

        return redirect()->route('admin.developers.index')->with('success', 'Sviluppatore eliminato con successo.');
    }
}

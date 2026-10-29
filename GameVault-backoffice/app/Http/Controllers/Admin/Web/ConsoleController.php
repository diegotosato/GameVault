<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Console;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsoleController extends Controller
{
    public function index()
    {
        $consoles = Console::all();

        return view('admin.consoles.index', compact('consoles'));
    }

    public function create()
    {
        return view('admin.consoles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        Console::create([
            'name'  => $request->name,
            'slug'  => Str::slug($request->name),
            'color' => $request->color,
        ]);

        return redirect()->route('admin.consoles.index')->with('success', 'Console aggiunta con successo.');
    }

    public function edit(Console $console)
    {
        return view('admin.consoles.edit', compact('console'));
    }

    public function update(Request $request, Console $console)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $console->update([
            'name'  => $request->name,
            'slug'  => Str::slug($request->name),
            'color' => $request->color,
        ]);

        return redirect()->route('admin.consoles.index')->with('success', 'Console aggiornata con successo.');
    }

    public function destroy(Console $console)
    {
        $console->delete();

        return redirect()->route('admin.consoles.index')->with('success', 'Console eliminata con successo.');
    }
}

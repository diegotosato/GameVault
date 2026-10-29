<?php

namespace App\Http\Controllers;

use App\Models\MultiplayerMode;
use Illuminate\Http\Request;

class MultiplayerModeController extends Controller
{
    public function index()
    {
        $multi_modes = MultiplayerMode::all();

        return response()->json($multi_modes);
    }
}

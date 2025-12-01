<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('name')->select('id', 'name')->get();

        return response()->json([
            'genres' => $genres,
            'success' => true,
        ]);
    }
}

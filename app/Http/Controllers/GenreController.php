<?php

namespace App\Http\Controllers;

use App\Models\Genre;

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

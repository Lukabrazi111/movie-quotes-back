<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(private readonly MovieService $movieService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        list($movies, $count) = $this->movieService->getUserMovies();

        return response()->json([
            'movies' => $movies,
            'count' => $count,
            'success' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        try {
            $movie = $this->movieService->createMovie($validated, $request);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'movie' => $movie,
            'message' => 'Movie created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        $movie->load(['genres', 'quotes']);

        return response()->json([
            'movie' => $movie,
            'success' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

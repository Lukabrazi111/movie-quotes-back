<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieCollectionResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class MovieController extends Controller
{
    public function __construct(private readonly MovieService $movieService)
    {
    }

    public function getMovies(): \Illuminate\Http\JsonResponse
    {
        $movies = Movie::select('id', 'title')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'movies' => $movies,
            'success' => true,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        list($movies, $count) = $this->movieService->getUserMovies();

        return MovieCollectionResource::collection($movies)->additional([
            'count' => $count,
            'success' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();

        try {
            $movie = $this->movieService->createMovie($validated, $request);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'movie' => new MovieResource($movie),
            'message' => 'Movie created successfully',
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): \Illuminate\Http\JsonResponse
    {
        $movie->load([
            'quotes' => function ($query) {
                $query->with('user')->orderBy('created_at', 'desc')->withCount(['comments', 'likes']);
            },
            'genres',
        ])->loadCount('quotes');

        return response()->json([
            'movie' => new MovieResource($movie),
            'success' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        try {
            $movie = $this->movieService->updateMovie($request, $validated, $id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json([
            'movie' => new MovieResource($movie),
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): \Illuminate\Http\JsonResponse
    {
        $movie->delete();

        return response()->json([
            'message' => 'Movie deleted successfully',
            'success' => true,
        ]);
    }
}

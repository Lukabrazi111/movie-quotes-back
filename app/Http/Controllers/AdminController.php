<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Output all movies
    public function index()
    {
        $quotes = Quote::all();

        return view('admin-panel.index', ['quotes' => $quotes]);
    }

    public function addMovie()
    {
        return view('admin-panel.add-movie');
    }

    // Add movie & quote
    public function store()
    {
        request()->validate([
            'movie-name' => 'required',
            'movie-name-geo' => 'required',
            'quote' => 'required',
            'quote-geo' => 'required',
        ]);

        $movie = Movie::create(['name' => [
            'en' => request()->input('movie-name'),
            'ka' => request()->input('movie-name-geo'),
        ]]);

        $quote = Quote::create(['quote' => [
            'en' => request()->input('quote'),
            'ka' => request()->input('quote-geo'),
        ],
            'movie_id' => $movie->id]);

        return redirect('/admin/panel')->with('success', 'Movie Added!');
    }

    // Show movie
    public function show($id)
    {
        $quotes = Quote::find($id);

        return view('admin-panel.edit', ['quotes' => $quotes]);
    }

    // Update movie
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'textarea' => 'required',
        ]);

        $quote = Quote::find($id);
        $movie = Movie::find($id);

        $movie->name = $request->input('name');
        $quote->quote = $request->input('textarea');
        $quote->save();
        $movie->save();

        return redirect('/admin/panel')->with('success', 'Movie Updated!');
    }

    // Delete movie
    public function destroy($id)
    {
        $quote = Quote::find($id);

        $quote->delete();

        return redirect('/admin/panel')->with('success', 'Movie Removed!');
    }
}

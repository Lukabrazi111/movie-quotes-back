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

//        Quote::where($id)->update(['name' => $request->input('name')]);
//        Movie::where($id)->update(['textarea' => $request->input('textarea')]);

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

<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Output all posts (movies)
    public function index()
    {
        $quotes = Quote::all();

        return view('admin-panel.index', ['quotes' => $quotes]);
    }

    // Show post
    public function show($id)
    {
        $quotes = Quote::find($id);

        return view('admin-panel.edit', ['quotes' => $quotes]);
    }

    // Update post
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'text' => 'required',
            'textarea' => 'required',
        ]);

        $quote = Quote::find($id);

        $quote->movies->name = $request->input('text');
        $quote->quote = $request->input('textarea');
        $quote->save();

        return redirect('/admin/panel');
    }
}

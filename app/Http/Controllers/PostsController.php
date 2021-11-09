<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index() {

        return view('posts.index', ['posts' => $posts]);
    }

    public function show() {

        return view('posts.show', ['posts' => $posts]);
    }
}

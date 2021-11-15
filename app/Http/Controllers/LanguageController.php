<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index($language) {
        session(['language' => "$language"]);
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FlagshipProduct;

class AppsSolutionsController extends Controller
{
    public function index()
    {
        $solutions = FlagshipProduct::latest()->get();

        return view('apps-solutions', compact('solutions'));
    }
}

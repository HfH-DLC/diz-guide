<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class MaterialController extends Controller
{
    public function show()
    {
        return Inertia::render('Material', []);
    }
}

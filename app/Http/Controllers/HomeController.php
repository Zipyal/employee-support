<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::query()->orderBy('created_at', 'desc')->get();

        return view('home', [
            'materials' => $materials,
        ]);
    }
}



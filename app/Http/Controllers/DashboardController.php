<?php

namespace App\Http\Controllers;

use App\Models\Pet;

class DashboardController extends Controller
{
    public function index()
    {
        $pets = Pet::all();

        return view('dashboard', compact('pets'));
    }
}

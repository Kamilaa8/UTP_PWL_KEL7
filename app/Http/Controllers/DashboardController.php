<?php

namespace App\Http\Controllers;

use App\Models\Pet;

class DashboardController extends Controller
{
    public function index()
    {
        $pets = Pet::latest()->get();

        return view('dashboard', compact('pets'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PengajuanAdopsi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pets = Pet::latest()->get();

        $pendingPetIds = (Auth::check() && !Auth::user()->isAdmin())
            ? PengajuanAdopsi::where('user_id', Auth::id())
                ->where('status', 'menunggu')
                ->pluck('pet_id')
                ->toArray()
            : [];

        return view('dashboard', compact('pets', 'pendingPetIds'));
    }
}

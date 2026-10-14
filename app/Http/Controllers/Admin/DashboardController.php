<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanAdopsi;
use App\Models\Pet;

class DashboardController extends Controller
{
    public function index()
    {
        $totalHewan = Pet::count();
        $hewanTersedia = Pet::where('status', 'tersedia')->count();
        $hewanDiadopsi = Pet::where('status', 'diadopsi')->count();

        $totalPengajuan = PengajuanAdopsi::count();

        $perStatus = [
            'menunggu' => PengajuanAdopsi::where('status', 'menunggu')->count(),
            'disetujui' => PengajuanAdopsi::where('status', 'disetujui')->count(),
            'ditolak' => PengajuanAdopsi::where('status', 'ditolak')->count(),
        ];

        $pengajuanTerbaru = PengajuanAdopsi::with(['user', 'pet'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalHewan',
            'hewanTersedia',
            'hewanDiadopsi',
            'totalPengajuan',
            'perStatus',
            'pengajuanTerbaru'
        ));
    }
}
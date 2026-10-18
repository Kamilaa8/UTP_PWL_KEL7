<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\PengajuanAdopsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function create(Pet $pet)
    {
        if (Auth::user()->isAdmin()) {
            abort(403, 'Administrator tidak dapat mengajukan adopsi.');
        }

        if ($pet->status !== 'tersedia') {
            return redirect()->route('dashboard')
                ->with('error', 'Maaf, ' . $pet->name . ' saat ini sudah tidak tersedia untuk diadopsi.');
        }

        $pengajuanAktif = PengajuanAdopsi::where('user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->where('status', 'menunggu')
            ->first();

        if ($pengajuanAktif) {
            return redirect()->route('pengajuan.riwayat')
                ->with('error', 'Anda sudah mengajukan adopsi untuk ' . $pet->name . ' dan saat ini sedang menunggu persetujuan admin.');
        }

        return view('pengajuan.create', compact('pet'));
    }

    public function store(Request $request, Pet $pet)
    {
        if (Auth::user()->isAdmin()) {
            abort(403, 'Administrator tidak dapat mengajukan adopsi.');
        }

        if ($pet->status !== 'tersedia') {
            return redirect()->route('dashboard')
                ->with('error', 'Maaf, hewan ini sudah tidak tersedia untuk diadopsi.');
        }

        $validated = $request->validate([
            'alasan_adopsi' => ['required', 'string', 'min:15', 'max:2000'],
        ], [
            'alasan_adopsi.required' => 'Alasan adopsi wajib diisi.',
            'alasan_adopsi.min' => 'Mohon tulis alasan adopsi lebih lengkap (minimal 15 karakter).',
            'alasan_adopsi.max' => 'Alasan adopsi tidak boleh melebihi 2000 karakter.',
        ]);

        $sudahAda = PengajuanAdopsi::where('user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->where('status', 'menunggu')
            ->first();

        if ($sudahAda) {
            return redirect()->route('pengajuan.riwayat')
                ->with('error', 'Anda sudah mengajukan adopsi untuk ' . $pet->name . ' dan sedang menunggu keputusan.');
        }

        PengajuanAdopsi::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            'alasan_adopsi' => $validated['alasan_adopsi'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('pengajuan.riwayat')
            ->with('success', 'Pengajuan adopsi untuk ' . $pet->name . ' berhasil dikirim! Silakan tunggu konfirmasi admin.');
    }

    public function riwayat()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.pengajuan.index')
                ->with('error', 'Administrator tidak memiliki riwayat pengajuan pribadi.');
        }

        $userId = Auth::id();

        $riwayat = PengajuanAdopsi::with('pet')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => PengajuanAdopsi::where('user_id', $userId)->count(),
            'menunggu' => PengajuanAdopsi::where('user_id', $userId)->where('status', 'menunggu')->count(),
            'disetujui' => PengajuanAdopsi::where('user_id', $userId)->where('status', 'disetujui')->count(),
            'ditolak' => PengajuanAdopsi::where('user_id', $userId)->where('status', 'ditolak')->count(),
        ];

        return view('pengajuan.riwayat', compact('riwayat', 'stats'));
    }
}
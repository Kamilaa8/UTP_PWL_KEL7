<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanAdopsi;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $cari = trim((string) $request->query('cari'));

        $pengajuan = PengajuanAdopsi::with(['user', 'pet'])
            ->when(
                in_array($status, ['menunggu', 'disetujui', 'ditolak'], true),
                fn ($q) => $q->where('status', $status)
            )
            ->when($cari !== '', function ($q) use ($cari) {
                $q->where(function ($q) use ($cari) {
                    $q->whereHas('user', fn ($u) => $u->where('name', 'ilike', "%{$cari}%"))
                      ->orWhereHas('pet', fn ($p) => $p->where('name', 'ilike', "%{$cari}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengajuan.index', compact('pengajuan', 'status', 'cari'));
    }

    public function show(PengajuanAdopsi $pengajuan)
    {
        $pengajuan->load(['user', 'pet']);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function setujui(PengajuanAdopsi $pengajuan)
    {
        $pengajuan->update([
            'status' => 'disetujui',
            'alasan_penolakan' => null,
        ]);

        if ($pengajuan->pet) {
            $pengajuan->pet->update(['status' => 'diadopsi']);
        }

        return redirect()->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan adopsi disetujui. Status hewan diperbarui menjadi "diadopsi".');
    }

    public function tolak(Request $request, PengajuanAdopsi $pengajuan)
    {
        $request->validate([
            'alasan_penolakan' => ['nullable', 'string', 'max:1000'],
        ]);

        $pengajuan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan ?: 'Pengajuan belum memenuhi kriteria adopsi.',
        ]);

        return redirect()->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
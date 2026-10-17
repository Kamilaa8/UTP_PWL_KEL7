<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanAdopsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($pengajuan->status !== 'menunggu') {
            abort(400, 'Pengajuan ini sudah tidak berstatus menunggu.');
        }

        $pengajuan->loadMissing('pet');

        if (!$pengajuan->pet || $pengajuan->pet->status !== 'tersedia') {
            return redirect()->route('admin.pengajuan.show', $pengajuan)
                ->with('error', 'Hewan ini sudah tidak tersedia atau sudah diadopsi oleh pemohon lain.');
        }

        DB::transaction(function () use ($pengajuan) {
            $pengajuan->update([
                'status' => 'disetujui',
                'alasan_penolakan' => null,
            ]);

            $pengajuan->pet->update([
                'status' => 'diadopsi',
            ]);

            PengajuanAdopsi::where('pet_id', $pengajuan->pet_id)
                ->where('id', '!=', $pengajuan->id)
                ->where('status', 'menunggu')
                ->update([
                    'status' => 'ditolak',
                    'alasan_penolakan' => 'Hewan ini telah disetujui untuk diadopsi oleh pemohon lain.',
                ]);
        });

        return redirect()->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan adopsi disetujui. Status hewan diperbarui menjadi "diadopsi" dan pengajuan lain untuk hewan ini otomatis ditolak.');
    }

    public function tolak(Request $request, PengajuanAdopsi $pengajuan)
    {
        if ($pengajuan->status !== 'menunggu') {
            abort(400, 'Pengajuan ini sudah tidak berstatus menunggu.');
        }

        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'max:1000'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.max' => 'Alasan penolakan tidak boleh melebihi 1000 karakter.',
        ]);

        $pengajuan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
        ]);

        return redirect()->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
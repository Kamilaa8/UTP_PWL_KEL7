@extends('layouts.app', ['title' => 'Detail Pengajuan - PawPal'])

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-bold text-gray-900">Detail Pengajuan</h1>
    <a href="{{ route('admin.pengajuan.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">&larr; Kembali</a>
</div>

<div class="bg-white border border-gray-200 rounded-xl p-6 space-y-5">
    <div class="flex items-center justify-between">
        <span class="text-sm text-gray-500">Status</span>
        @if($pengajuan->status === 'disetujui')
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700">Disetujui</span>
        @elseif($pengajuan->status === 'ditolak')
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Ditolak</span>
        @else
            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">Menunggu</span>
        @endif
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <div class="text-xs text-gray-400 mb-1">Pemohon</div>
            <div class="font-medium text-gray-800">{{ $pengajuan->user->name }}</div>
            <div class="text-sm text-gray-500">{{ $pengajuan->user->email }}</div>
        </div>
        <div>
            <div class="text-xs text-gray-400 mb-1">Hewan</div>
            <div class="font-medium text-gray-800">{{ $pengajuan->pet->name }}</div>
            <div class="text-xs text-gray-500">Status Hewan: <span class="font-semibold">{{ $pengajuan->pet->status }}</span></div>
        </div>
        <div>
            <div class="text-xs text-gray-400 mb-1">Tanggal pengajuan</div>
            <div class="text-gray-700">{{ $pengajuan->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>

    <div>
        <div class="text-xs text-gray-400 mb-1">Alasan adopsi</div>
        <p class="text-gray-700 whitespace-pre-line">{{ $pengajuan->alasan_adopsi }}</p>
    </div>

    @if($pengajuan->status === 'ditolak' && $pengajuan->alasan_penolakan)
        <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="text-xs font-bold uppercase tracking-wider text-red-700 mb-1">Alasan Penolakan</div>
            <p class="text-sm text-red-800 whitespace-pre-line">{{ $pengajuan->alasan_penolakan }}</p>
        </div>
    @endif

    @if($pengajuan->status === 'menunggu')
        <div class="pt-6 border-t border-gray-100 space-y-4">
            <h3 class="text-sm font-semibold text-gray-800">Tindakan Admin:</h3>
            <div class="flex flex-wrap items-center gap-3">
                <form method="POST" action="{{ route('admin.pengajuan.setujui', $pengajuan) }}" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI pengajuan adopsi ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setujui Pengajuan
                    </button>
                </form>

                <button type="button" onclick="document.getElementById('form-tolak-container').classList.toggle('hidden')" class="px-5 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-xl transition flex items-center gap-2" data-warn-leave>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Tolak Pengajuan...
                </button>
            </div>

            <div id="form-tolak-container" class="hidden mt-4 p-5 bg-red-50/50 border border-red-200 rounded-xl space-y-3">
                <h4 class="text-sm font-bold text-red-900">Konfirmasi Penolakan Pengajuan</h4>
                <p class="text-xs text-red-700">Tuliskan alasan penolakan agar pemohon mengetahui hal yang perlu diperbaiki atau dipersiapkan.</p>
                <form method="POST" action="{{ route('admin.pengajuan.tolak', $pengajuan) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="alasan_penolakan" class="block text-xs font-semibold text-gray-700 mb-1">Alasan Penolakan</label>
                        <textarea name="alasan_penolakan" id="alasan_penolakan" rows="3" required
                                  placeholder="Contoh: Rumah pemohon belum memiliki pagar pengaman untuk hewan jenis ini..."
                                  class="w-full text-sm border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-500 bg-white"></textarea>
                        @error('alasan_penolakan')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg transition shadow-sm">
                            Kirim Penolakan
                        </button>
                        <button type="button" onclick="document.getElementById('form-tolak-container').classList.add('hidden')" class="px-3 py-2 text-xs font-medium text-gray-600 hover:bg-gray-200 rounded-lg transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
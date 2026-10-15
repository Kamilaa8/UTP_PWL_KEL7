@extends('layouts.app', ['title' => 'Riwayat Pengajuan Adopsi - PawPal'])

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Riwayat Pengajuan Adopsi</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau perkembangan status pengajuan adopsi hewan kesayangan Anda.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Jelajahi Hewan Siap Adopsi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <span class="text-xs font-medium text-gray-500">Total Pengajuan</span>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white border border-amber-200 rounded-xl p-4 shadow-sm">
            <span class="text-xs font-semibold text-amber-700">Menunggu</span>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['menunggu'] }}</p>
        </div>
        <div class="bg-white border border-emerald-200 rounded-xl p-4 shadow-sm">
            <span class="text-xs font-semibold text-emerald-700">Disetujui</span>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['disetujui'] }}</p>
        </div>
        <div class="bg-white border border-red-200 rounded-xl p-4 shadow-sm">
            <span class="text-xs font-semibold text-red-700">Ditolak</span>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['ditolak'] }}</p>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($riwayat as $item)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:border-gray-300 transition space-y-4">
                {{-- Header Card: Hewan + Status --}}
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-4 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 relative">
                            @if($item->pet && $item->pet->photo)
                                <img src="{{ asset('storage/' . $item->pet->photo) }}" alt="{{ $item->pet->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-emerald-50">
                                    <svg class="w-8 h-8 text-emerald-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9c.83 0 1.5-.67 1.5-1.5S7.83 8 7 8s-1.5.67-1.5 1.5S6.17 11 7 11zm10 0c.83 0 1.5-.67 1.5-1.5S17.83 8 17 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-5-3c.83 0 1.5-.67 1.5-1.5S12.83 5 12 5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 7.5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5zm5 0c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $item->pet->name ?? 'Hewan Tidak Ditemukan' }}</h3>
                                @if($item->pet)
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                        {{ $item->pet->species }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $item->pet->breed ?? 'Campuran' }} &bull; {{ $item->pet->gender ?? '-' }} &bull; {{ $item->pet->age ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Diajukan pada: <span class="font-medium text-gray-600">{{ $item->created_at->format('d M Y, H:i') }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div>
                        @if($item->status === 'menunggu')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Persetujuan
                            </span>
                        @elseif($item->status === 'disetujui')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Disetujui
                            </span>
                        @elseif($item->status === 'ditolak')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Alasan Pengajuan User --}}
                <div class="bg-gray-50 rounded-xl p-4 text-xs text-gray-700">
                    <span class="font-semibold text-gray-600 block mb-1">Alasan Pengajuan Anda:</span>
                    <p class="leading-relaxed whitespace-pre-line">{{ $item->alasan_adopsi }}</p>
                </div>

                @if($item->status === 'ditolak')
                    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-xs text-red-900 space-y-1">
                        <div class="font-bold flex items-center gap-1.5 text-red-800">
                            <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Alasan Penolakan dari Admin:
                        </div>
                        <p class="text-red-700 leading-relaxed pl-5">
                            {{ $item->alasan_penolakan ?? 'Pengajuan belum memenuhi kriteria kelayakan adopsi saat ini.' }}
                        </p>
                    </div>
                @elseif($item->status === 'disetujui')
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 space-y-1">
                        <div class="font-bold flex items-center gap-1.5 text-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Informasi Serah Terima:
                        </div>
                        <p class="text-emerald-700 leading-relaxed pl-5">
                            Selamat! Permohonan adopsi Anda telah disetujui. Silakan kunjungi shelter PawPal dengan membawa kartu identitas untuk menyelesaikan proses serah terima sahabat baru Anda.
                        </p>
                    </div>
                @else
                    <div class="text-xs text-gray-500 italic flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pengajuan Anda sedang dalam tahap verifikasi oleh tim PawPal. Mohon cek status secara berkala.
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white border border-dashed border-gray-300 rounded-2xl p-12 text-center space-y-4">
                <div class="w-16 h-16 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9c.83 0 1.5-.67 1.5-1.5S7.83 8 7 8s-1.5.67-1.5 1.5S6.17 11 7 11zm10 0c.83 0 1.5-.67 1.5-1.5S17.83 8 17 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-5-3c.83 0 1.5-.67 1.5-1.5S12.83 5 12 5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 7.5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5zm5 0c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">Belum Ada Pengajuan Adopsi</h3>
                    <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                        Anda belum pernah mengajukan adopsi hewan apapun. Mulai temukan sahabat setia Anda di katalog hewan kami.
                    </p>
                </div>
                <div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl transition shadow-sm">
                        Lihat Hewan yang Tersedia
                    </a>
                </div>
            </div>
        @endforelse

        @if($riwayat->hasPages())
            <div class="pt-4">
                {{ $riwayat->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

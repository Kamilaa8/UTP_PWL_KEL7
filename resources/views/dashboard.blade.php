@extends('layouts.app', ['title' => 'Dashboard Pengguna - PawPal'])

@section('content')
<div class="space-y-8">
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                Selamat datang, <span class="text-emerald-600">{{ auth()->user()->name }}</span>!
            </h1>
            <p class="text-gray-500 mt-1">
                @if(auth()->user()->isAdmin())
                    Kelola data hewan dan proses pengajuan adopsi dari Panel Admin.
                @else
                    Temukan sahabat baru dan ajukan adopsi hewan yang Anda sukai.
                @endif
            </p>
        </div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
                class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm">
                Buka Panel Admin
            </a>
        @endif
    </div>

    <div>
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Daftar Hewan</h2>
                <p class="text-sm text-gray-500">Melihat seluruh hewan peliharaan yang terdaftar</p>
            </div>
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                Total: {{ $pets->count() }} Hewan
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pets as $pet)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm flex flex-col">
                    <div class="h-48 w-full bg-gray-100 relative">
                        @if($pet->photo)
                            <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 mb-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9c.83 0 1.5-.67 1.5-1.5S7.83 8 7 8s-1.5.67-1.5 1.5S6.17 11 7 11zm10 0c.83 0 1.5-.67 1.5-1.5S17.83 8 17 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-5-3c.83 0 1.5-.67 1.5-1.5S12.83 5 12 5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 7.5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5zm5 0c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5z"/>
                                </svg>
                                <span class="text-xs">Foto belum tersedia</span>
                            </div>
                        @endif
                        <span class="absolute top-3 right-3 px-2.5 py-1 bg-white/90 backdrop-blur-sm text-xs font-semibold text-emerald-700 rounded-full shadow-sm">
                            {{ $pet->species }}
                        </span>
                    </div>

                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-lg font-bold text-gray-900">{{ $pet->name }}</h3>
                                <span class="text-xs text-gray-500 font-medium">{{ $pet->gender }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">{{ $pet->breed ?? 'Campuran' }} &bull; {{ $pet->age }}</p>
                            @if($pet->description)
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $pet->description }}</p>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Status:</span>
                            @if($pet->status === 'tersedia')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                    Sudah Diadopsi
                                </span>
                            @endif
                        </div>

                        @if(!auth()->user()->isAdmin())
                            <div class="pt-2">
                                @if($pet->status === 'tersedia')
                                    @if(in_array($pet->id, $pendingPetIds ?? []))
                                        <a href="{{ route('pengajuan.riwayat') }}" class="w-full text-center px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                            Sedang Diajukan (Cek Riwayat)
                                        </a>
                                    @else
                                        <a href="{{ route('pengajuan.create', $pet->id) }}" class="w-full text-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center justify-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            Ajukan Adopsi
                                        </a>
                                    @endif
                                @else
                                    <button disabled class="w-full text-center px-4 py-2.5 bg-gray-100 text-gray-400 text-xs font-medium rounded-xl cursor-not-allowed">
                                        Sudah Diadopsi
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center bg-white rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500 text-sm">Belum ada data hewan yang terdaftar.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

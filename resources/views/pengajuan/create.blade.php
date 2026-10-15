@extends('layouts.app', ['title' => 'Form Pengajuan Adopsi ' . $pet->name . ' - PawPal'])

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Daftar Hewan
        </a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Pengajuan Adopsi</span>
    </div>

    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Formulir Pengajuan Adopsi</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi informasi di bawah ini untuk mengajukan permohonan adopsi sahabat baru Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-5 bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm sticky top-24">
            <div class="h-64 w-full bg-emerald-50 relative overflow-hidden">
                @if($pet->photo)
                    <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-emerald-300">
                        <svg class="w-20 h-20 mb-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9c.83 0 1.5-.67 1.5-1.5S7.83 8 7 8s-1.5.67-1.5 1.5S6.17 11 7 11zm10 0c.83 0 1.5-.67 1.5-1.5S17.83 8 17 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-5-3c.83 0 1.5-.67 1.5-1.5S12.83 5 12 5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 7.5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5zm5 0c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5z"/>
                        </svg>
                        <span class="text-xs font-medium text-gray-400">Belum ada foto</span>
                    </div>
                @endif
                <span class="absolute top-3 right-3 px-3 py-1 bg-white/95 backdrop-blur-sm text-xs font-bold text-emerald-700 rounded-full shadow-sm">
                    {{ $pet->species }}
                </span>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $pet->name }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                            {{ ucfirst($pet->status) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $pet->breed ?? 'Campuran' }} &bull; {{ $pet->age }} &bull; {{ $pet->gender }}</p>
                </div>

                @if($pet->description)
                    <div class="bg-gray-50 p-3.5 rounded-xl text-xs text-gray-600 leading-relaxed border border-gray-100">
                        <span class="font-semibold text-gray-700 block mb-1">Tentang {{ $pet->name }}:</span>
                    </div>
                @endif

                <div class="p-3.5 bg-emerald-50/60 rounded-xl border border-emerald-100 text-xs text-emerald-800 space-y-1">
                    <p class="font-semibold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                        Komitmen Menyayangi
                    </p>
                    <p class="text-emerald-700">Pastikan Anda siap berkomitmen memberikan perawatan, makanan sehat, serta tempat tinggal yang aman bagi {{ $pet->name }}.</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-900">Data & Alasan Pengajuan</h3>
                <p class="text-xs text-gray-500 mt-1">Admin PawPal akan meninjau kelayakan pengajuan Anda berdasarkan informasi yang Anda berikan.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <div>
                    <span class="text-xs text-gray-500 block">Nama Pemohon</span>
                    <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500 block">Email Pemohon</span>
                    <span class="text-sm font-semibold text-gray-900">{{ auth()->user()->email }}</span>
                </div>
            </div>

            <form action="{{ route('pengajuan.store', $pet->id) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="alasan_adopsi" class="block text-sm font-semibold text-gray-800 mb-1.5">
                        Alasan Ingin Mengadopsi {{ $pet->name }} <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-2">
                        Ceritakan motivasi Anda, pengalaman merawat hewan, lingkungan tempat tinggal, serta komitmen Anda untuk merawat {{ $pet->name }}.
                    </p>
                    <textarea 
                        name="alasan_adopsi" 
                        id="alasan_adopsi" 
                        rows="6" 
                        required
                        placeholder="Contoh: Saya memiliki rumah dengan halaman aman dan sudah terbiasa merawat kucing. Saya ingin memberikan kasih sayang dan perawatan terbaik untuk {{ $pet->name }}..." 
                        class="w-full text-sm border rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition @error('alasan_adopsi') border-red-500 focus:ring-red-400 @else border-gray-300 @enderror">{{ old('alasan_adopsi') }}</textarea>
                    
                    @error('alasan_adopsi')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-400">Minimal 15 karakter.</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-xl transition text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim Pengajuan Adopsi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

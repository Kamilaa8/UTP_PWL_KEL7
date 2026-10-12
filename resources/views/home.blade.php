@extends('layouts.app', ['title' => 'PawPal - Sistem Informasi Adopsi Hewan'])

@section('content')
<div class="space-y-16">
    <div class="bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-800 rounded-3xl text-white p-8 sm:p-16 shadow-lg text-center relative overflow-hidden">
        <div class="max-w-3xl mx-auto space-y-6">
            <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-sm text-white rounded-full text-xs font-semibold uppercase tracking-wider">
                Sistem Informasi Adopsi Hewan
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Beri Rumah Penuh Kasih untuk Sahabat Baru
            </h1>
            <p class="text-emerald-100 text-base sm:text-lg max-w-2xl mx-auto">
                PawPal hadir menghubungkan calon pemilik dengan hewan terlantar yang membutuhkan keluarga baru. Setiap nyawa berharga dan pantas disayangi.
            </p>
            <div class="pt-4 flex flex-wrap justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-emerald-800 hover:bg-emerald-50 font-bold rounded-xl transition shadow-md">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-emerald-800/80 hover:bg-emerald-800 text-white font-medium rounded-xl border border-white/20 transition">
                        Masuk ke Akun
                    </a>
                @else
                    <div class="inline-block px-6 py-3 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 font-medium">
                        Halo, {{ auth()->user()->name }}! Anda masuk sebagai <span class="font-bold uppercase text-emerald-200">{{ auth()->user()->role }}</span>.
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <div>
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Alur Mudah Adopsi Hewan</h2>
            <p class="text-gray-500 mt-2 text-sm">Proses adopsi yang terstruktur, aman, dan transparan bagi semua pihak.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm text-center space-y-4 hover:border-emerald-500 transition">
                <div class="w-14 h-14 mx-auto bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center font-bold text-xl">
                    1
                </div>
                <h3 class="text-lg font-bold text-gray-900">Pilih Hewan</h3>
                <p class="text-sm text-gray-600">
                    Lihat katalog hewan peliharaan yang siap diadopsi, mulai dari kucing, anjing, hingga kelinci.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm text-center space-y-4 hover:border-emerald-500 transition">
                <div class="w-14 h-14 mx-auto bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center font-bold text-xl">
                    2
                </div>
                <h3 class="text-lg font-bold text-gray-900">Isi Pengajuan</h3>
                <p class="text-sm text-gray-600">
                    Kirim formulir pengajuan adopsi dengan menyertakan alasan dan komitmen Anda untuk merawat hewan.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm text-center space-y-4 hover:border-emerald-500 transition">
                <div class="w-14 h-14 mx-auto bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center font-bold text-xl">
                    3
                </div>
                <h3 class="text-lg font-bold text-gray-900">Verifikasi & Serah Terima</h3>
                <p class="text-sm text-gray-600">
                    Admin meninjau pengajuan Anda. Setelah disetujui, Anda dapat menjemput hewan peliharaan baru Anda.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection

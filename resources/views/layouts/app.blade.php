<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PawPal - Sistem Informasi Adopsi Hewan' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16">

                {{-- KIRI: logo --}}
                <div class="flex-1">
                    <a href="{{ auth()->check() ? route('dashboard') : route('home') }}"
                        class="inline-flex items-center gap-2 text-xl font-bold text-emerald-600">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9c.83 0 1.5-.67 1.5-1.5S7.83 8 7 8s-1.5.67-1.5 1.5S6.17 11 7 11zm10 0c.83 0 1.5-.67 1.5-1.5S17.83 8 17 8s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-5-3c.83 0 1.5-.67 1.5-1.5S12.83 5 12 5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5zm-2.5 7.5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5zm5 0c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5.67 1.5 1.5 1.5 1.5-.67 1.5-1.5z" />
                        </svg>
                        <span>PawPal</span>
                    </a>
                </div>

                {{-- TENGAH: menu --}}
                <div class="flex items-center gap-4 sm:gap-6">
                    @guest
                        <a href="{{ route('home') }}"
                            class="text-sm font-medium {{ request()->routeIs('home') ? 'text-emerald-600 font-semibold' : 'text-gray-600 hover:text-emerald-600' }}">Beranda</a>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-emerald-600 font-semibold' : 'text-gray-600 hover:text-emerald-600' }}">Dashboard</a>
                        <a href="{{ route('pengajuan.riwayat') }}"
                            class="text-sm font-medium whitespace-nowrap {{ request()->routeIs('pengajuan.riwayat') ? 'text-emerald-600 font-semibold' : 'text-gray-600 hover:text-emerald-600' }}">Riwayat Pengajuan</a>
                        <a href="{{ route('profile.edit') }}"
                            class="text-sm font-medium {{ request()->routeIs('profile.*') ? 'text-emerald-600 font-semibold' : 'text-gray-600 hover:text-emerald-600' }}">Profil</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-sm font-medium whitespace-nowrap {{ request()->is('admin*') ? 'text-emerald-600 font-semibold' : 'text-gray-600 hover:text-emerald-600' }}">Panel Admin</a>
                        @endif
                    @endauth
                </div>

                {{-- KANAN: akun --}}
                <div class="flex-1 flex items-center justify-end gap-3">
                    @auth
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</div>
                            <div class="text-xs uppercase tracking-wider text-emerald-600 font-bold">
                                {{ auth()->user()->role }}</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-emerald-600 transition">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition shadow-sm">Daftar</a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    @if(session('success') || session('error'))
        <div
            class="fixed top-20 left-1/2 -translate-x-1/2 z-[60] flex flex-col gap-2 w-max max-w-[calc(100%-2rem)] pointer-events-none">
            @if(session('success'))
                <div data-flash
                    class="pointer-events-auto p-4 rounded-lg shadow-lg bg-emerald-50 border border-emerald-200 text-emerald-800 transition-opacity duration-500">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="pointer-events-auto p-4 rounded-lg shadow-lg bg-red-50 border border-red-200 text-red-800 flex items-center justify-between gap-3">
                    <span>{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()"
                        class="text-xl leading-none opacity-60 hover:opacity-100" aria-label="Tutup">&times;</button>
                </div>
            @endif
        </div>
    @endif

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-12 text-center text-sm text-gray-500">
        <p>&copy; {{ date('Y') }} PawPal - Sistem Informasi Adopsi Hewan. Dikembangkan oleh Kelompok 7.</p>
    </footer>

    <script>
        document.querySelectorAll('[data-flash]').forEach(function (el) {
            setTimeout(function () {
                el.classList.add('opacity-0');
                setTimeout(function () { el.remove(); }, 500);
            }, 3000);
        });
    </script>
</body>

</html>
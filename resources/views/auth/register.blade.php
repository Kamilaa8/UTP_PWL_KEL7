@extends('layouts.app', ['title' => 'Daftar Akun - PawPal'])

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Buat Akun PawPal</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar untuk mulai mengadopsi hewan peliharaan</p>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
            <x-password-input name="password" id="password" required />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
            <x-password-input name="password_confirmation" id="password_confirmation" required />
        </div>

        <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition shadow-sm">
            Daftar Akun
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-500">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="text-emerald-600 font-semibold hover:underline">Masuk</a>
    </div>
</div>
@endsection
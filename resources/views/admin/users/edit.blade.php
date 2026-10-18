@extends('layouts.app', ['title' => 'Edit Pengguna - PawPal'])

@section('content')
<div class="max-w-xl mx-auto bg-white p-5 sm:p-8 border border-gray-200 rounded-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Pengguna</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5" data-warn-leave>
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            @if($user->is(auth()->user()))
                <input type="hidden" name="role" value="{{ $user->role }}">
                <input type="text" value="{{ ucfirst($user->role) }}" disabled
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-500">
                <p class="mt-1 text-xs text-gray-500">Role akun sendiri tidak bisa diubah.</p>
            @else
                <select name="role"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
            @endif
            @error('role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input type="password" name="password"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
            @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">
                Simpan
            </button>
            <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
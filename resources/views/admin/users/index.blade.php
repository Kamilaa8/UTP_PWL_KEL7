@extends('layouts.app', ['title' => 'Kelola Pengguna - PawPal'])

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
        <p class="text-sm text-gray-500">Total: {{ $users->total() }} pengguna</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.dashboard') }}"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
            &larr; Dashboard
        </a>
        <a href="{{ route('admin.users.create') }}"
            class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">
            + Tambah Pengguna
        </a>
    </div>
</div>

<form method="GET" action="{{ route('admin.users.index') }}"
    class="mb-6 bg-white border border-gray-200 rounded-xl p-4 flex flex-wrap gap-3">
    <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari nama atau email..."
        class="flex-1 min-w-[220px] px-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
    <select name="role"
        class="px-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
        <option value="">Semua role</option>
        <option value="user" @selected($role === 'user')>User</option>
        <option value="admin" @selected($role === 'admin')>Admin</option>
    </select>
    <button type="submit"
        class="px-5 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">
        Cari
    </button>
    @if($role || $cari)
        <a href="{{ route('admin.users.index') }}"
            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Reset</a>
    @endif
</form>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500">
                    <th class="py-3 px-4 font-medium">Nama</th>
                    <th class="py-3 px-4 font-medium">Email</th>
                    <th class="py-3 px-4 font-medium">Role</th>
                    <th class="py-3 px-4 font-medium">Pengajuan</th>
                    <th class="py-3 px-4 font-medium">Terdaftar</th>
                    <th class="py-3 px-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr class="border-t border-gray-100">
                        <td class="py-3 px-4 font-medium text-gray-900">
                            {{ $u->name }}
                            @if($u->is(auth()->user()))
                                <span class="ml-1 text-xs font-normal text-gray-400">(Anda)</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-gray-600">{{ $u->email }}</td>
                        <td class="py-3 px-4">
                            @if($u->isAdmin())
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Admin</span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">User</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $u->pengajuan_adopsi_count }}</td>
                        <td class="py-3 px-4 text-gray-500">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $u) }}"
                                    class="px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition">
                                    Edit
                                </a>
                                @unless($u->is(auth()->user()))
                                    <form action="{{ route('admin.users.destroy', $u) }}" method="POST"
                                        onsubmit="return confirm(@js('Hapus pengguna ' . $u->name . '?'))">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-400">Tidak ada pengguna yang cocok.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
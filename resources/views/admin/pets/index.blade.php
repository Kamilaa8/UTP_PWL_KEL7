@extends('layouts.app', ['title' => 'Kelola Hewan - PawPal'])

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Data Hewan</h1>
        <p class="text-sm text-gray-500">Total: {{ $pets->count() }} hewan</p>
    </div>
    <a href="{{ route('admin.pets.create') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">
        + Tambah Hewan
    </a>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-500">
                    <th class="py-3 px-4 font-medium">Foto</th>
                    <th class="py-3 px-4 font-medium">Nama</th>
                    <th class="py-3 px-4 font-medium">Jenis</th>
                    <th class="py-3 px-4 font-medium">Umur</th>
                    <th class="py-3 px-4 font-medium">Status</th>
                    <th class="py-3 px-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pets as $pet)
                    <tr class="border-t border-gray-100">
                        <td class="py-3 px-4">
                            @if($pet->photo)
                                <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}"
                                    class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-100"></div>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $pet->name }}</td>
                        <td class="py-3 px-4">{{ $pet->species }}</td>
                        <td class="py-3 px-4">{{ $pet->age }}</td>
                        <td class="py-3 px-4">
                            @if($pet->status === 'tersedia')
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Tersedia</span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">Diadopsi</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.pets.edit', $pet) }}"
                                    class="px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.pets.destroy', $pet) }}" method="POST"
                                    onsubmit="return confirm(@js('Hapus ' . $pet->name . '?'))">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-10 px-4 text-center text-gray-500">Belum ada data hewan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
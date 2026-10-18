@php $p = $pet ?? null; @endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="name" value="{{ old('name', $p->name ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis (kucing, anjing, dll)</label>
        <input type="text" name="species" value="{{ old('species', $p->species ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        @error('species')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Ras (opsional)</label>
        <input type="text" name="breed" value="{{ old('breed', $p->breed ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        @error('breed')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Umur (contoh: 3 bulan)</label>
        <input type="text" name="age" value="{{ old('age', $p->age ?? '') }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        @error('age')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
        <select name="gender"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            @foreach(['Jantan', 'Betina'] as $g)
                <option value="{{ $g }}" @selected(old('gender', $p->gender ?? '') === $g)>{{ $g }}</option>
            @endforeach
        </select>
        @error('gender')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status Adopsi</label>
        <select name="status"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <option value="tersedia" @selected(old('status', $p->status ?? 'tersedia') === 'tersedia')>Tersedia</option>
            <option value="diadopsi" @selected(old('status', $p->status ?? '') === 'diadopsi')>Sudah Diadopsi</option>
        </select>
        @error('status')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
    <textarea name="description" rows="4"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('description', $p->description ?? '') }}</textarea>
    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-5">
    <label class="block text-sm font-medium text-gray-700 mb-1">Foto (maks 2 MB)</label>
    @if($p && $p->photo)
        <img src="{{ asset('storage/' . $p->photo) }}" alt="Foto {{ $p->name }}" class="h-28 rounded-lg mb-2 object-cover">
    @endif
    <input type="file" name="photo" accept="image/*" class="text-sm text-gray-600">
    @error('photo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-6 flex gap-3">
    <button type="submit"
        class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition">
        Simpan
    </button>
    <a href="{{ route('admin.pets.index') }}"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition">
        Batal
    </a>
</div>
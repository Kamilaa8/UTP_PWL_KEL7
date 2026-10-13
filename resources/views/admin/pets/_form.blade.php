@php $p = $pet ?? null; @endphp

<div class="pets-form-grid">
    <div>
        <label class="pets-label">Nama</label>
        <input type="text" name="name" value="{{ old('name', $p->name ?? '') }}" class="pets-input">
        @error('name')<p class="pets-error">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="pets-label">Jenis (kucing, anjing, dll)</label>
        <input type="text" name="species" value="{{ old('species', $p->species ?? '') }}" class="pets-input">
        @error('species')<p class="pets-error">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="pets-label">Ras (opsional)</label>
        <input type="text" name="breed" value="{{ old('breed', $p->breed ?? '') }}" class="pets-input">
        @error('breed')<p class="pets-error">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="pets-label">Umur (contoh: 3 bulan)</label>
        <input type="text" name="age" value="{{ old('age', $p->age ?? '') }}" class="pets-input">
        @error('age')<p class="pets-error">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="pets-label">Jenis Kelamin</label>
        <select name="gender" class="pets-input">
            @foreach(['Jantan', 'Betina'] as $g)
                <option value="{{ $g }}" @selected(old('gender', $p->gender ?? '') === $g)>{{ $g }}</option>
            @endforeach
        </select>
        @error('gender')<p class="pets-error">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="pets-label">Status Adopsi</label>
        <select name="status" class="pets-input">
            <option value="tersedia" @selected(old('status', $p->status ?? 'tersedia') === 'tersedia')>Tersedia</option>
            <option value="diadopsi" @selected(old('status', $p->status ?? '') === 'diadopsi')>Sudah Diadopsi</option>
        </select>
        @error('status')<p class="pets-error">{{ $message }}</p>@enderror
    </div>
</div>

<div class="pets-field-full">
    <label class="pets-label">Deskripsi</label>
    <textarea name="description" rows="4" class="pets-input">{{ old('description', $p->description ?? '') }}</textarea>
    @error('description')<p class="pets-error">{{ $message }}</p>@enderror
</div>

<div class="pets-field-full">
    <label class="pets-label">Foto (maks 2 MB)</label>
    @if($p && $p->photo)
        <img src="{{ asset('storage/' . $p->photo) }}" alt="Foto {{ $p->name }}" class="pets-preview">
    @endif
    <input type="file" name="photo" accept="image/*">
    @error('photo')<p class="pets-error">{{ $message }}</p>@enderror
</div>

<div class="pets-form-actions">
    <button type="submit" class="pets-btn pets-btn-primary">Simpan</button>
    <a href="{{ route('admin.pets.index') }}" class="pets-btn pets-btn-outline">Batal</a>
</div>
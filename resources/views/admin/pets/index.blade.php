@extends('layouts.app', ['title' => 'Kelola Hewan - PawPal'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-pets.css') }}">
@endpush

@section('content')
<div class="pets-header">
    <div>
        <h1 class="pets-title">Kelola Data Hewan</h1>
        <p class="pets-subtitle">Total: {{ $pets->count() }} hewan</p>
    </div>
    <a href="{{ route('admin.pets.create') }}" class="pets-btn pets-btn-primary">+ Tambah Hewan</a>
</div>

<div class="pets-table-wrap">
    <table class="pets-table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Umur</th>
                <th>Status</th>
                <th style="text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pets as $pet)
                <tr>
                    <td>
                        @if($pet->photo)
                            <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" class="pets-thumb">
                        @else
                            <div class="pets-thumb-empty"></div>
                        @endif
                    </td>
                    <td class="pets-name">{{ $pet->name }}</td>
                    <td>{{ $pet->species }}</td>
                    <td>{{ $pet->age }}</td>
                    <td>
                        @if($pet->status === 'tersedia')
                            <span class="pets-badge pets-badge-available">Tersedia</span>
                        @else
                            <span class="pets-badge pets-badge-adopted">Diadopsi</span>
                        @endif
                    </td>
                    <td>
                        <div class="pets-actions">
                            <a href="{{ route('admin.pets.edit', $pet) }}" class="pets-btn pets-btn-edit">Edit</a>
                            <form action="{{ route('admin.pets.destroy', $pet) }}" method="POST" class="pets-inline-form" onsubmit="return confirm('Hapus {{ $pet->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pets-btn pets-btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="pets-empty">Belum ada data hewan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
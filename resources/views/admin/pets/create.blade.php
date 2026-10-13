@extends('layouts.app', ['title' => 'Tambah Hewan - PawPal'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-pets.css') }}">
@endpush

@section('content')
<div class="pets-card">
    <h1 class="pets-title" style="margin-bottom: 24px;">Tambah Hewan</h1>
    <form action="{{ route('admin.pets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.pets._form')
    </form>
</div>
@endsection
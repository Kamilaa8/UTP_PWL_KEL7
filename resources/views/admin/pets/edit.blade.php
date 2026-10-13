@extends('layouts.app', ['title' => 'Edit Hewan - PawPal'])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-pets.css') }}">
@endpush

@section('content')
<div class="pets-card">
    <h1 class="pets-title" style="margin-bottom: 24px;">Edit Hewan</h1>
    <form action="{{ route('admin.pets.update', $pet) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pets._form')
    </form>
</div>
@endsection
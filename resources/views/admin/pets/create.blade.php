@extends('layouts.app', ['title' => 'Tambah Hewan - PawPal'])

@section('content')
<div class="max-w-3xl mx-auto bg-white p-5 sm:p-8 border border-gray-200 rounded-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Hewan</h1>
    <form action="{{ route('admin.pets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.pets._form')
    </form>
</div>
@endsection
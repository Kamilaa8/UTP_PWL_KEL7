@extends('layouts.app', ['title' => 'Edit Hewan - PawPal'])

@section('content')
<div class="max-w-3xl mx-auto bg-white p-5 sm:p-8 border border-gray-200 rounded-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Hewan</h1>
    <form action="{{ route('admin.pets.update', $pet) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.pets._form')
    </form>
</div>
@endsection
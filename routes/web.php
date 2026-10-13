<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin/pets', [PetController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.pets.index');
Route::get('/admin/pets/create', [PetController::class, 'create'])->middleware(['auth', 'admin'])->name('admin.pets.create');
Route::post('/admin/pets', [PetController::class, 'store'])->middleware(['auth', 'admin'])->name('admin.pets.store');
Route::get('/admin/pets/{pet}/edit', [PetController::class, 'edit'])->middleware(['auth', 'admin'])->name('admin.pets.edit');
Route::put('/admin/pets/{pet}', [PetController::class, 'update'])->middleware(['auth', 'admin'])->name('admin.pets.update');
Route::delete('/admin/pets/{pet}', [PetController::class, 'destroy'])->middleware(['auth', 'admin'])->name('admin.pets.destroy');

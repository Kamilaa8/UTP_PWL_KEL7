<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
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

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/pets/{pet}/adopt', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pets/{pet}/adopt', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/riwayat-pengajuan', [PengajuanController::class, 'riwayat'])->name('pengajuan.riwayat');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('pets', PetController::class)->except('show');
    Route::resource('users', UserController::class)->except('show');

    Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');
    Route::patch('/pengajuan/{pengajuan}/setujui', [AdminPengajuanController::class, 'setujui'])->name('pengajuan.setujui');
    Route::patch('/pengajuan/{pengajuan}/tolak', [AdminPengajuanController::class, 'tolak'])->name('pengajuan.tolak');
});
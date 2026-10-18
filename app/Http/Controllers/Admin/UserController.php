<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $cari = trim((string) $request->query('cari'));

        $users = User::withCount('pengajuanAdopsi')
            ->when(in_array($role, ['admin', 'user'], true), fn ($q) => $q->where('role', $role))
            ->when($cari !== '', function ($q) use ($cari) {
                $q->where(function ($q) use ($cari) {
                    $q->where('name', 'ilike', "%{$cari}%")
                      ->orWhere('email', 'ilike', "%{$cari}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'role', 'cari'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['user', 'admin'])],
        ], $this->pesan());

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['user', 'admin'])],
        ], $this->pesan());

        if ($user->is($request->user()) && $validated['role'] !== $user->role) {
            return back()->withInput()->with('error', 'Anda tidak bisa mengubah role akun sendiri.');
        }

        // password kosong = tidak diganti
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        if ($user->pengajuanAdopsi()->exists()) {
            return back()->with('error', 'Pengguna ini punya riwayat pengajuan, tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    private function pesan(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah dipakai pengguna lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.in' => 'Role tidak valid.',
        ];
    }
}
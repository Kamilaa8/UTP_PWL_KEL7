<?php

namespace Tests\Feature;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_beranda_dapat_diakses(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('PawPal');
    }

    public function test_halaman_login_dan_register_dapat_diakses(): void
    {
        $this->get(route('login'))->assertStatus(200);
        $this->get(route('register'))->assertStatus(200);
    }

    public function test_registrasi_pengguna_berhasil_dengan_role_user(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Fulan',
            'email' => 'fulan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'fulan@example.com',
            'role' => 'user',
        ]);
        $this->assertAuthenticated();
    }

    public function test_login_dan_logout_berhasil(): void
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'test@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
        ]);

        $loginResponse = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);

        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);

        $logoutResponse = $this->post(route('logout'));
        $logoutResponse->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_dashboard_user_hanya_bisa_diakses_setelah_login(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));

        $user = User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        Pet::create([
            'name' => 'Mochi',
            'species' => 'Kucing',
            'age' => '5 Bulan',
            'gender' => 'Betina',
            'status' => 'tersedia',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Pengguna');
        $response->assertSee('Mochi');
        $response->assertDontSee('Ajukan Adopsi');
    }

    public function test_admin_tidak_dapat_mengakses_dan_mengajukan_adopsi(): void
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'adm@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $pet = Pet::create([
            'name' => 'Choco',
            'species' => 'Anjing',
            'age' => '1 Tahun',
            'gender' => 'Jantan',
            'status' => 'tersedia',
        ]);

        $this->actingAs($admin)->get(route('pengajuan.create', $pet))->assertStatus(403);

        $this->actingAs($admin)->post(route('pengajuan.store', $pet), [
            'alasan_adopsi' => 'Saya ingin mengadopsi ini.',
        ])->assertStatus(403);

        $responseRiwayat = $this->actingAs($admin)->get(route('pengajuan.riwayat'));
        $responseRiwayat->assertRedirect(route('admin.pengajuan.index'));

        $dashboardResponse = $this->actingAs($admin)->get(route('dashboard'));
        $dashboardResponse->assertDontSee('Riwayat Pengajuan');
    }
}

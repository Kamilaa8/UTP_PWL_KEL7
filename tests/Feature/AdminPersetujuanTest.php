<?php

namespace Tests\Feature;

use App\Models\PengajuanAdopsi;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPersetujuanTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user1;
    private User $user2;
    private Pet $pet;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->user1 = User::create([
            'name' => 'Budi',
            'email' => 'budi@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->user2 = User::create([
            'name' => 'Siti',
            'email' => 'siti@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->pet = Pet::create([
            'name' => 'Mochi',
            'species' => 'Kucing',
            'age' => '6 Bulan',
            'gender' => 'Betina',
            'status' => 'tersedia',
        ]);
    }

    public function test_menyetujui_pengajuan_otomatis_menolak_pengajuan_lain_untuk_hewan_yang_sama(): void
    {
        $pengajuanBudi = PengajuanAdopsi::create([
            'user_id' => $this->user1->id,
            'pet_id' => $this->pet->id,
            'alasan_adopsi' => 'Sangat menyukai kucing.',
            'status' => 'menunggu',
        ]);

        $pengajuanSiti = PengajuanAdopsi::create([
            'user_id' => $this->user2->id,
            'pet_id' => $this->pet->id,
            'alasan_adopsi' => 'Ingin merawat kucing di rumah.',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pengajuan.setujui', $pengajuanBudi));
        $response->assertRedirect(route('admin.pengajuan.show', $pengajuanBudi));

        $this->assertDatabaseHas('pengajuan_adopsi', [
            'id' => $pengajuanBudi->id,
            'status' => 'disetujui',
        ]);

        $this->assertDatabaseHas('pets', [
            'id' => $this->pet->id,
            'status' => 'diadopsi',
        ]);

        $this->assertDatabaseHas('pengajuan_adopsi', [
            'id' => $pengajuanSiti->id,
            'status' => 'ditolak',
        ]);
    }

    public function test_tidak_bisa_menyetujui_jika_hewan_sudah_tidak_tersedia(): void
    {
        $this->pet->update(['status' => 'diadopsi']);

        $pengajuan = PengajuanAdopsi::create([
            'user_id' => $this->user1->id,
            'pet_id' => $this->pet->id,
            'alasan_adopsi' => 'Ingin mengadopsi hewan.',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pengajuan.setujui', $pengajuan));
        $response->assertRedirect(route('admin.pengajuan.show', $pengajuan));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('pengajuan_adopsi', [
            'id' => $pengajuan->id,
            'status' => 'menunggu',
        ]);
    }

    public function test_guard_menolak_aksi_pada_pengajuan_yang_bukan_menunggu(): void
    {
        $pengajuan = PengajuanAdopsi::create([
            'user_id' => $this->user1->id,
            'pet_id' => $this->pet->id,
            'alasan_adopsi' => 'Ingin mengadopsi hewan.',
            'status' => 'disetujui',
        ]);

        $responseSetujui = $this->actingAs($this->admin)->patch(route('admin.pengajuan.setujui', $pengajuan));
        $responseSetujui->assertStatus(400);

        $responseTolak = $this->actingAs($this->admin)->patch(route('admin.pengajuan.tolak', $pengajuan), [
            'alasan_penolakan' => 'Alasan penolakan',
        ]);
        $responseTolak->assertStatus(400);
    }

    public function test_menolak_pengajuan_wajib_mengisi_alasan_penolakan(): void
    {
        $pengajuan = PengajuanAdopsi::create([
            'user_id' => $this->user1->id,
            'pet_id' => $this->pet->id,
            'alasan_adopsi' => 'Ingin mengadopsi hewan.',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pengajuan.tolak', $pengajuan), [
            'alasan_penolakan' => '',
        ]);

        $response->assertSessionHasErrors('alasan_penolakan');

        $responseValid = $this->actingAs($this->admin)->patch(route('admin.pengajuan.tolak', $pengajuan), [
            'alasan_penolakan' => 'Kandang belum memadai.',
        ]);

        $responseValid->assertRedirect(route('admin.pengajuan.show', $pengajuan));
        $this->assertDatabaseHas('pengajuan_adopsi', [
            'id' => $pengajuan->id,
            'status' => 'ditolak',
            'alasan_penolakan' => 'Kandang belum memadai.',
        ]);
    }
}

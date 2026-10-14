<?php

namespace Database\Seeders;

use App\Models\PengajuanAdopsi;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengajuanAdopsiSeeder extends Seeder
{
    public function run(): void
    {
        $dataHewan = [
            ['name' => 'Mochi', 'species' => 'Kucing', 'breed' => 'Persia', 'age' => '2 tahun', 'gender' => 'Betina', 'status' => 'tersedia', 'description' => 'Kucing ramah dan suka bermain.'],
            ['name' => 'Bruno', 'species' => 'Anjing', 'breed' => 'Golden Retriever', 'age' => '1 tahun', 'gender' => 'Jantan', 'status' => 'tersedia', 'description' => 'Anjing aktif dan cocok untuk keluarga.'],
            ['name' => 'Luna', 'species' => 'Kucing', 'breed' => 'Domestik', 'age' => '6 bulan', 'gender' => 'Betina', 'status' => 'tersedia', 'description' => 'Anak kucing yang manja.'],
            ['name' => 'Coco', 'species' => 'Kelinci', 'breed' => 'Holland Lop', 'age' => '8 bulan', 'gender' => 'Jantan', 'status' => 'tersedia', 'description' => 'Kelinci jinak dan lucu.'],
            ['name' => 'Rocky', 'species' => 'Anjing', 'breed' => 'Beagle', 'age' => '3 tahun', 'gender' => 'Jantan', 'status' => 'diadopsi', 'description' => 'Sudah menemukan keluarga barunya.'],
        ];

        $pets = [];
        foreach ($dataHewan as $data) {
            $pets[$data['name']] = Pet::firstOrCreate(['name' => $data['name']], $data);
        }

        $dataUser = [
            ['name' => 'Budi Santoso', 'email' => 'budi@pawpal.com'],
            ['name' => 'Siti Rahma', 'email' => 'siti@pawpal.com'],
            ['name' => 'Andi Pratama', 'email' => 'andi@pawpal.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@pawpal.com'],
        ];

        $users = [];
        foreach ($dataUser as $data) {
            $users[$data['name']] = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ]
            );
        }

        if (PengajuanAdopsi::exists()) {
            return;
        }

        $pengajuan = [
            ['Budi Santoso', 'Mochi', 'Saya ingin merawat Mochi di rumah yang tenang.', 'menunggu', null],
            ['Siti Rahma', 'Mochi', 'Saya sudah lama ingin punya kucing Persia.', 'menunggu', null],
            ['Andi Pratama', 'Bruno', 'Anak-anak saya sangat ingin punya anjing.', 'menunggu', null],
            ['Dewi Lestari', 'Luna', 'Saya tinggal sendiri dan butuh teman di rumah.', 'ditolak', 'Rumah pemohon belum memenuhi syarat untuk anak kucing.'],
            ['Budi Santoso', 'Rocky', 'Saya punya halaman luas untuk Rocky bermain.', 'disetujui', null],
            ['Siti Rahma', 'Coco', 'Saya suka kelinci dan sudah menyiapkan kandangnya.', 'menunggu', null],
        ];

        foreach ($pengajuan as [$namaUser, $namaHewan, $alasan, $status, $alasanTolak]) {
            PengajuanAdopsi::create([
                'user_id' => $users[$namaUser]->id,
                'pet_id' => $pets[$namaHewan]->id,
                'alasan_adopsi' => $alasan,
                'status' => $status,
                'alasan_penolakan' => $alasanTolak,
            ]);
        }
    }
}
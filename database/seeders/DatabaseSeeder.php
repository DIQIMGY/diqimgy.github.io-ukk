<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin ────────────────────────────────────────────────────────
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@perpus.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // ─── Siswa ────────────────────────────────────────────────────────
        $siswa1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@siswa.sch.id',
            'password' => Hash::make('siswa123'),
            'role'     => 'siswa',
        ]);
        Anggota::create([
            'user_id' => $siswa1->id,
            'nis'     => '2024001',
            'nama'    => 'Budi Santoso',
            'kelas'   => 'XI-RPL-1',
            'telepon' => '081234567890',
            'status'  => 'aktif',
        ]);

        $siswa2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@siswa.sch.id',
            'password' => Hash::make('siswa123'),
            'role'     => 'siswa',
        ]);
        Anggota::create([
            'user_id' => $siswa2->id,
            'nis'     => '2024002',
            'nama'    => 'Siti Rahayu',
            'kelas'   => 'XI-RPL-2',
            'telepon' => '082345678901',
            'status'  => 'aktif',
        ]);

        // ─── Buku ─────────────────────────────────────────────────────────
        $buku = [
            ['BK001', 'Pemrograman Web dengan PHP', 'Betha Sidik', 'Informatika', 2022, 'Pemrograman', 5],
            ['BK002', 'Belajar Laravel dari Dasar', 'Ahmad Dahlan', 'Elex Media', 2023, 'Framework', 3],
            ['BK003', 'Database MySQL untuk Pemula', 'Ridwan Sanjaya', 'Andi', 2021, 'Database', 4],
            ['BK004', 'Jaringan Komputer Modern', 'James Kurose', 'Erlangga', 2020, 'Jaringan', 2],
            ['BK005', 'Algoritma dan Pemrograman', 'Rinaldi Munir', 'Informatika', 2019, 'Pemrograman', 6],
            ['BK006', 'Kecerdasan Buatan', 'Stuart Russell', 'Erlangga', 2022, 'AI', 3],
            ['BK007', 'Sistem Operasi Modern', 'Andrew Tanenbaum', 'Andi', 2021, 'Sistem Operasi', 4],
            ['BK008', 'UI/UX Design untuk Web', 'Doni Kusuma', 'Gramedia', 2023, 'Desain', 5],
        ];

        foreach ($buku as $b) {
            Buku::create([
                'kode_buku'    => $b[0],
                'judul'        => $b[1],
                'pengarang'    => $b[2],
                'penerbit'     => $b[3],
                'tahun_terbit' => $b[4],
                'kategori'     => $b[5],
                'stok'         => $b[6],
            ]);
        }
    }
}

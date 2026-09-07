<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada data anggota terlebih dahulu
        $anggota = Anggota::first();
        
        if (!$anggota) {
            $this->command->warn('⚠️  Belum ada data anggota. Jalankan AnggotaSeeder terlebih dahulu.');
            return;
        }

        // Ambil semua buku
        $bukuIds = Buku::pluck('id')->toArray();
        
        if (empty($bukuIds)) {
            $this->command->warn('⚠️  Belum ada data buku. Jalankan BukuSeeder terlebih dahulu.');
            return;
        }

        $peminjaman = [
            // === SEDANG DIPINJAM (3 data) ===
            [
                'kode_pinjam' => 'PJ' . str_pad(1, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[0] ?? 1, // Cantik Itu Luka
                'tanggal_pinjam' => Carbon::now()->subDays(5),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(9),
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'denda' => 0,
                'keterangan' => 'Sedang dibaca',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(2, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[1] ?? 2, // Dorian Gray
                'tanggal_pinjam' => Carbon::now()->subDays(3),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(11),
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'denda' => 0,
                'keterangan' => 'Baru pinjam',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(3, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[5] ?? 6, // Stardust
                'tanggal_pinjam' => Carbon::now()->subDays(10),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(4),
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'denda' => 0,
                'keterangan' => null,
            ],

            // === SUDAH DIKEMBALIKAN (3 data) ===
            [
                'kode_pinjam' => 'PJ' . str_pad(4, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[2] ?? 3, // Jane Eyre (baru dikembalikan)
                'tanggal_pinjam' => Carbon::now()->subDays(16),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(2),
                'tanggal_kembali_aktual' => Carbon::now()->subHours(5),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(5, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[3] ?? 4, // Pride & Prejudice
                'tanggal_pinjam' => Carbon::now()->subDays(19),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(5),
                'tanggal_kembali_aktual' => Carbon::now()->subHours(12),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(6, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[8] ?? 9, // Harry Potter
                'tanggal_pinjam' => Carbon::now()->subDays(15),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(1),
                'tanggal_kembali_aktual' => Carbon::now()->subHours(8),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],

            // === TERLAMBAT (1 data) ===
            [
                'kode_pinjam' => 'PJ' . str_pad(7, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[1] ?? 2, // Dorian Gray (dipinjam lagi)
                'tanggal_pinjam' => Carbon::now()->subDays(20),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(6),
                'tanggal_kembali_aktual' => null,
                'status' => 'terlambat',
                'denda' => 18000, // 6 hari x 3000
                'keterangan' => 'Belum dikembalikan, sudah terlambat',
            ],
        ];

        foreach ($peminjaman as $data) {
            Peminjaman::create($data);
        }

        $this->command->info('✅ 7 data peminjaman berhasil ditambahkan!');
        $this->command->info('   - 3 sedang dipinjam');
        $this->command->info('   - 3 sudah dikembalikan');
        $this->command->info('   - 1 terlambat');
    }
}

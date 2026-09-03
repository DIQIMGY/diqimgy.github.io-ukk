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
            // === SEDANG DIPINJAM (5 data) ===
            [
                'kode_pinjam' => 'PJ' . str_pad(1, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[0] ?? 1, // The Seven Husbands
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
                'buku_id' => $bukuIds[1] ?? 2, // The Night Circus
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
                'buku_id' => $bukuIds[3] ?? 4, // Addie LaRue
                'tanggal_pinjam' => Carbon::now()->subDays(10),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(4),
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'denda' => 0,
                'keterangan' => null,
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(4, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[15] ?? 16, // Happy Place
                'tanggal_pinjam' => Carbon::now()->subDays(2),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(12),
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'denda' => 0,
                'keterangan' => 'Weekend reading',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(5, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[16] ?? 17, // Fourth Wing
                'tanggal_pinjam' => Carbon::now()->subDays(7),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(7),
                'tanggal_kembali_aktual' => null,
                'status' => 'dipinjam',
                'denda' => 0,
                'keterangan' => null,
            ],

            // === SUDAH DIKEMBALIKAN (5 data) ===
            [
                'kode_pinjam' => 'PJ' . str_pad(6, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[10] ?? 11, // Catcher in the Rye (baru dikembalikan)
                'tanggal_pinjam' => Carbon::now()->subDays(16),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(2),
                'tanggal_kembali_aktual' => Carbon::now()->subHours(2),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(7, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[11] ?? 12, // Midnight Library
                'tanggal_pinjam' => Carbon::now()->subDays(19),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(5),
                'tanggal_kembali_aktual' => Carbon::now()->subHours(5),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(8, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[12] ?? 13, // Kite Runner
                'tanggal_pinjam' => Carbon::now()->subDays(15),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(1),
                'tanggal_kembali_aktual' => Carbon::now()->subMinutes(45),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(9, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[13] ?? 14, // Life of Pi
                'tanggal_pinjam' => Carbon::now()->subDays(17),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(3),
                'tanggal_kembali_aktual' => Carbon::now()->subHours(3),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(10, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[14] ?? 15, // Book Thief
                'tanggal_pinjam' => Carbon::now()->subDays(15),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(1),
                'tanggal_kembali_aktual' => Carbon::now()->subHour(),
                'status' => 'dikembalikan',
                'denda' => 0,
                'keterangan' => 'Tepat waktu',
            ],

            // === TERLAMBAT (2 data) ===
            [
                'kode_pinjam' => 'PJ' . str_pad(11, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[20] ?? 21, // Game of Thrones
                'tanggal_pinjam' => Carbon::now()->subDays(25),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(11),
                'tanggal_kembali_aktual' => Carbon::now()->subDays(8),
                'status' => 'dikembalikan',
                'denda' => 9000, // 3 hari x 3000
                'keterangan' => 'Terlambat 3 hari',
            ],
            [
                'kode_pinjam' => 'PJ' . str_pad(12, 5, '0', STR_PAD_LEFT),
                'anggota_id' => $anggota->id,
                'buku_id' => $bukuIds[4] ?? 5, // Good Girl's Guide
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

        $this->command->info('✅ 12 data peminjaman berhasil ditambahkan!');
        $this->command->info('   - 5 sedang dipinjam');
        $this->command->info('   - 5 sudah dikembalikan');
        $this->command->info('   - 2 terlambat');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration: Tambah sistem approval peminjaman
 * ──────────────────────────────────────────────────────
 * Mengimplementasikan alur approval:
 *   Siswa submit → 'pending' → Admin setujui/tolak
 *
 * PERUBAHAN:
 * 1. Kolom status: ENUM → VARCHAR(20)
 *    Mengapa? ENUM tidak bisa di-ALTER dengan mudah di MySQL.
 *    VARCHAR(20) lebih fleksibel untuk nilai status baru.
 *    Nilai baru yang ditambahkan: 'pending', 'ditolak'
 *
 * 2. Kolom baru:
 *    tanggal_pengajuan  → tanggal siswa mengajukan peminjaman
 *    approved_at        → timestamp saat admin menyetujui
 *    rejected_at        → timestamp saat admin menolak
 *    rejection_reason   → alasan penolakan (ditampilkan ke siswa)
 *
 * CATATAN STOK:
 *   Stok hanya berkurang saat approve() — BUKAN saat siswa submit.
 *   Ini berarti tanggal_pinjam dan tanggal_kembali_rencana
 *   perlu dibuat nullable (lihat migration 2026_10_07_000002).
 */
return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom status dari ENUM ke VARCHAR(20)
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status VARCHAR(20) NOT NULL DEFAULT 'dipinjam'");

        Schema::table('peminjaman', function (Blueprint $table) {
            // Tanggal siswa mengajukan pinjam (bisa berbeda dari tanggal_pinjam)
            $table->date('tanggal_pengajuan')->nullable()->after('kode_pinjam');
            // Waktu admin mengambil keputusan
            $table->timestamp('approved_at')->nullable()->after('keterangan');
            $table->timestamp('rejected_at')->nullable()->after('approved_at');
            // Alasan penolakan — ditampilkan ke siswa di halaman peminjaman
            $table->text('rejection_reason')->nullable()->after('rejected_at');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pengajuan', 'approved_at', 'rejected_at', 'rejection_reason']);
        });

        // Kembalikan ke ENUM (hanya nilai yang ada sebelum migration ini)
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'dipinjam'");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambah return_requested_at untuk sistem approval pengembalian
 * ──────────────────────────────────────────────────────
 * Mengimplementasikan alur approval pengembalian:
 *   Siswa minta kembalikan → 'pending_kembali' → Admin konfirmasi/tolak
 *
 * MENGAPA TIDAK PERLU ALTER STATUS?
 *   Kolom status sudah VARCHAR(20) sejak migration 2026_10_07_000001,
 *   sehingga nilai 'pending_kembali' langsung bisa dipakai
 *   tanpa perlu ALTER TABLE lagi.
 *
 * KOLOM BARU:
 *   return_requested_at → timestamp saat siswa mengajukan pengembalian
 *                         diisi di PengembalianController::proses()
 *                         dikosongkan kembali jika admin reject (siswa bisa ajukan ulang)
 *                         ditampilkan di card admin sebagai "Diajukan: ..."
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Ditempatkan setelah approved_at agar urutan kronologis
            $table->timestamp('return_requested_at')->nullable()->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('return_requested_at');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambah kolom status_launching dan tanggal_rilis ke tabel buku
 * ──────────────────────────────────────────────────────
 * Fitur "Segera Hadir" — buku bisa ditampilkan di landing page
 * sebelum fisiknya tersedia untuk dipinjam.
 *
 *   status_launching → 'tersedia' (bisa dipinjam) atau 'segera' (coming soon)
 *   tanggal_rilis    → untuk status 'segera': kapan buku akan tersedia
 *                      (opsional, dipakai untuk urutan tampil)
 *
 * LOGIKA DI CONTROLLER:
 *   Jika status_launching = 'segera' → tanggal_rilis WAJIB diisi
 *   Jika status_launching = 'tersedia' → tanggal_rilis dikosongkan
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            // Ditempatkan setelah is_featured agar urutan kolom logis
            $table->enum('status_launching', ['tersedia', 'segera'])
                  ->default('tersedia')
                  ->after('is_featured');
            $table->date('tanggal_rilis')->nullable()->after('status_launching');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['status_launching', 'tanggal_rilis']);
        });
    }
};

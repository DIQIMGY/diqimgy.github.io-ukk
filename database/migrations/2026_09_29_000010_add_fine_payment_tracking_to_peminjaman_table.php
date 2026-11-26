<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambah tracking pembayaran denda ke tabel peminjaman
 * ──────────────────────────────────────────────────────
 * Sebelumnya denda hanya disimpan nominalnya (kolom 'denda').
 * Migration ini menambahkan tracking apakah denda sudah dibayar.
 *
 *   denda_dibayar    → boolean, default false
 *                      true = admin sudah tandai denda sebagai lunas
 *   denda_dibayar_at → timestamp kapan denda ditandai lunas
 *                      (untuk audit trail)
 *
 * DIPAKAI DI:
 *   Admin\TransaksiController::tandaiDendaDibayar()
 *   View admin/transaksi/index.blade.php → badge "Lunas" / "Belum Lunas"
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->boolean('denda_dibayar')->default(false)->after('denda');
            $table->timestamp('denda_dibayar_at')->nullable()->after('denda_dibayar');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['denda_dibayar', 'denda_dibayar_at']);
        });
    }
};

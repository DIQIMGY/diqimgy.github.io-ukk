<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Buat tanggal_pinjam dan tanggal_kembali_rencana nullable
 * ──────────────────────────────────────────────────────
 * MENGAPA PERLU?
 *   Dengan sistem approval, peminjaman berstatus 'pending' belum
 *   punya tanggal pinjam. Tanggal baru diisi saat admin approve.
 *
 *   Sebelum migration ini:
 *     tanggal_pinjam           NOT NULL  ← error saat insert pending
 *     tanggal_kembali_rencana  NOT NULL  ← error saat insert pending
 *
 *   Sesudah migration ini:
 *     tanggal_pinjam           NULL  ← diisi saat approve()
 *     tanggal_kembali_rencana  NULL  ← diisi saat approve() (+7 hari)
 *
 * CATATAN VIEW:
 *   Di view, kedua kolom ini perlu dicek null sebelum format():
 *     $peminjaman->tanggal_pinjam?->format('d M Y') ?? '—'
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_pinjam')->nullable()->change();
            $table->date('tanggal_kembali_rencana')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_pinjam')->nullable(false)->change();
            $table->date('tanggal_kembali_rencana')->nullable(false)->change();
        });
    }
};

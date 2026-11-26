<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambah kolom approval_status ke tabel users
 * ──────────────────────────────────────────────────────
 * Dipakai untuk sistem persetujuan pendaftaran admin baru.
 * Admin yang baru daftar akan berstatus 'pending' sampai disetujui
 * oleh admin yang sudah aktif.
 *
 * Nilai:
 *   'approved' → admin aktif, bisa akses panel (default untuk user lama)
 *   'pending'  → menunggu persetujuan, diblokir masuk panel admin
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // NULL = tidak berlaku (untuk user siswa)
            // Hanya relevan untuk role 'admin'
            $table->enum('approval_status', ['pending', 'approved'])
                  ->nullable()
                  ->default(null)
                  ->after('role');
        });

        // Semua admin yang sudah ada di database → langsung 'approved'
        // agar tidak terkunci keluar setelah migration ini dijalankan
        DB::table('users')
            ->where('role', 'admin')
            ->update(['approval_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};

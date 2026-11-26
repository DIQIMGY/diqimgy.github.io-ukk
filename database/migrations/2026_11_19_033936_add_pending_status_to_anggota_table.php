<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambah nilai 'pending' ke enum status di tabel anggota
 * ──────────────────────────────────────────────────────────────────
 * Dipakai untuk sistem approval pendaftaran siswa baru.
 * Siswa yang baru daftar akan berstatus 'pending' sampai disetujui admin.
 *
 * Nilai status:
 *   'pending'  → baru daftar, menunggu persetujuan admin
 *   'aktif'    → sudah disetujui, bisa pinjam buku
 *   'nonaktif' → dinonaktifkan admin
 */
return new class extends Migration
{
    public function up(): void
    {
        // MySQL: ubah enum untuk tambah nilai 'pending'
        Schema::table('anggota', function (Blueprint $table) {
            $table->enum('status', ['pending', 'aktif', 'nonaktif'])
                  ->default('aktif')
                  ->change();
        });
    }

    public function down(): void
    {
        // Pastikan tidak ada data 'pending' sebelum revert
        DB::table('anggota')->where('status', 'pending')->update(['status' => 'nonaktif']);

        Schema::table('anggota', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'nonaktif'])
                  ->default('aktif')
                  ->change();
        });
    }
};

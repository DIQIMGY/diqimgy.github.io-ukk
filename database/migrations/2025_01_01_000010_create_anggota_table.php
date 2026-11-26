<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel anggota
 * ──────────────────────────────────────────────────────
 * Menyimpan data profil anggota perpustakaan.
 * Terpisah dari tabel users agar data autentikasi
 * dan data keanggotaan tidak bercampur.
 *
 * RELASI:
 *   anggota.user_id → users.id (cascade delete:
 *   jika user dihapus, data anggotanya ikut terhapus)
 *
 * STATUS:
 *   'aktif'    → bisa meminjam buku
 *   'nonaktif' → tidak bisa meminjam (diblokir admin)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');       // hapus anggota otomatis jika user dihapus
            $table->string('nis')->unique();   // Nomor Induk Siswa, unik per sekolah
            $table->string('nama');
            $table->string('kelas');           // contoh: "10 IPA 1"
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('foto')->nullable(); // path file di storage/public/anggota/
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};

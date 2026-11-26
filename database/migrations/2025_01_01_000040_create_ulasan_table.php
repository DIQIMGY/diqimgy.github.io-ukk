<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel ulasan
 * ──────────────────────────────────────────────────────
 * Menyimpan ulasan dan rating yang diberikan siswa
 * setelah mengembalikan buku.
 *
 * CONSTRAINT PENTING:
 *   unique('peminjaman_id') → satu peminjaman hanya bisa
 *   diberi ulasan SATU kali. Ini mencegah siswa spam rating.
 *
 * RELASI:
 *   ulasan.peminjaman_id → peminjaman.id (cascade delete)
 *   ulasan.buku_id       → buku.id       (cascade delete)
 *   ulasan.anggota_id    → anggota.id    (cascade delete)
 *
 * CATATAN:
 *   buku_id redundan (bisa diambil via peminjaman→buku),
 *   tapi disimpan langsung untuk query yang lebih mudah
 *   saat mencari "semua ulasan untuk buku X".
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')
                  ->constrained('peminjaman')
                  ->onDelete('cascade');        // ulasan ikut terhapus jika peminjaman dihapus
            $table->foreignId('buku_id')
                  ->constrained('buku')
                  ->onDelete('cascade');
            $table->foreignId('anggota_id')
                  ->constrained('anggota')
                  ->onDelete('cascade');
            $table->tinyInteger('rating');      // nilai 1–5 bintang
            $table->text('komentar')->nullable(); // teks ulasan, opsional
            $table->timestamps();

            // Satu peminjaman = satu ulasan (tidak bisa double submit)
            $table->unique('peminjaman_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};

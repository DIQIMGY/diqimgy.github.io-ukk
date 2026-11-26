<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel buku (struktur dasar)
 * ──────────────────────────────────────────────────────
 * Menyimpan data koleksi buku perpustakaan.
 * Ini migration pertama untuk tabel buku — hanya kolom dasar.
 * Kolom tambahan (isbn, rating, status_launching, dll)
 * ditambahkan di migration-migration berikutnya secara bertahap.
 *
 * KOLOM UTAMA:
 *   kode_buku  → identifikasi unik buku (misal: B001)
 *   stok       → jumlah fisik yang tersedia untuk dipinjam
 *   cover      → path file gambar sampul di storage/public/covers/
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku')->unique(); // kode katalog perpustakaan
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->year('tahun_terbit');           // format 4 digit: 2024
            $table->string('kategori');             // contoh: "Fiksi", "Sains"
            $table->integer('stok')->default(1);    // minimal 1 saat pertama input
            $table->string('cover')->nullable();    // opsional — bisa tanpa cover
            $table->text('deskripsi')->nullable();  // sinopsis buku
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};

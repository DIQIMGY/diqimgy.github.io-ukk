<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel pivot series_buku
 * ──────────────────────────────────────────────────────
 * Tabel penghubung antara series dan buku (many-to-many).
 * Setiap row = satu buku yang masuk ke dalam satu series,
 * beserta informasi posisi dan statusnya.
 *
 * KOLOM:
 *   series_id     → FK ke tabel series
 *   buku_id       → FK ke tabel buku
 *   urutan_baca   → urutan yang direkomendasikan untuk membaca (1, 2, 3, ...)
 *   urutan_terbit → urutan terbit asli (bisa berbeda dari urutan baca)
 *   is_penutup    → apakah buku ini adalah buku penutup/akhir seri
 *
 * CONSTRAINT:
 *   unique(series_id, buku_id) → satu buku hanya bisa masuk satu series sekali
 *   index(series_id, urutan_baca) → mempercepat query order by urutan_baca
 *
 * TIMESTAMPS:
 *   Hanya created_at — tidak ada updated_at karena kita tidak perlu
 *   tracking kapan urutan terakhir diubah di level tabel ini.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('series_id')
                  ->constrained('series')
                  ->onDelete('cascade');  // hapus pivot jika series dihapus
            $table->foreignId('buku_id')
                  ->constrained('buku')
                  ->onDelete('cascade');  // hapus pivot jika buku dihapus
            $table->unsignedSmallInteger('urutan_baca')->default(0);
            $table->unsignedSmallInteger('urutan_terbit')->default(0);
            $table->boolean('is_penutup')->default(false);
            $table->timestamp('created_at')->useCurrent(); // waktu buku ditambahkan ke series

            // Satu buku hanya bisa masuk ke series yang sama sekali
            $table->unique(['series_id', 'buku_id']);
            // Index untuk mempercepat sorting berdasarkan urutan_baca
            $table->index(['series_id', 'urutan_baca']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series_buku');
    }
};

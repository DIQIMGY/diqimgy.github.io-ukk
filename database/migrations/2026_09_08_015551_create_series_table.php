<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel series
 * ──────────────────────────────────────────────────────
 * Menyimpan data seri buku (kumpulan buku berurutan).
 * Relasi ke buku ada di tabel pivot series_buku
 * (migration berikutnya: 2026_09_08_015553).
 *
 * KOLOM:
 *   nama_series  → nama seri, disarankan unik
 *   penulis      → penulis seri (bisa berbeda dari pengarang tiap buku)
 *   deskripsi    → sinopsis/keterangan seri, opsional
 *   cover_series → gambar cover khusus seri (opsional,
 *                  fallback ke cover buku pertama jika tidak ada)
 *   slug         → versi URL-friendly dari nama_series
 *                  contoh: "Harry Potter" → "harry-potter"
 *                  dibuat otomatis oleh Model event 'creating'
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('nama_series');
            $table->string('penulis');
            $table->text('deskripsi')->nullable();
            $table->string('cover_series')->nullable(); // path file di storage
            $table->string('slug')->unique();           // untuk URL: /series/{slug}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};

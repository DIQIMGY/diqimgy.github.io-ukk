<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel landing_ads (struktur awal)
 * ──────────────────────────────────────────────────────
 * Menyimpan gambar iklan/banner untuk slider di landing page.
 * Ini migration awal — hanya kolom dasar.
 * Kolom title, description, youtube_url ditambahkan di
 * migration 2026_10_01_000001.
 *
 * KOLOM:
 *   image_path → path file gambar di storage/public/landing-ads/
 *   sort_order → urutan tampil di slider (angka kecil = tampil duluan)
 *   is_active  → false = disembunyikan dari landing page tanpa dihapus
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_ads', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');                   // wajib ada gambar
            $table->unsignedInteger('sort_order')->default(0); // urutan tampil
            $table->boolean('is_active')->default(true);    // langsung aktif setelah upload
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_ads');
    }
};

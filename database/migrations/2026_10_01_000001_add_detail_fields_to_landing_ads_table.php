<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambah detail fields ke tabel landing_ads
 * ──────────────────────────────────────────────────────
 * Sebelumnya iklan hanya punya gambar. Migration ini menambahkan
 * konten overlay yang tampil di atas gambar + opsi video YouTube.
 *
 *   title       → judul iklan (overlay di atas gambar), opsional
 *   description → deskripsi iklan (max ~1000 karakter), opsional
 *   youtube_url → link video YouTube terkait iklan, opsional
 *                 diparse oleh Model LandingAd menjadi:
 *                 youtube_id, youtube_embed, youtube_watch, youtube_thumbnail
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_ads', function (Blueprint $table) {
            $table->string('title')->nullable()->after('image_path');
            $table->text('description')->nullable()->after('title');
            $table->string('youtube_url')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('landing_ads', function (Blueprint $table) {
            $table->dropColumn(['title', 'description', 'youtube_url']);
        });
    }
};

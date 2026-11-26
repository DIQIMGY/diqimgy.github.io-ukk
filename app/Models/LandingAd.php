<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model LandingAd
 * ──────────────────────────────────────────────────────────────
 * Merepresentasikan satu item iklan/banner di halaman landing page.
 * Admin bisa upload gambar, tambah judul/deskripsi, link YouTube,
 * atur urutan tampil, dan aktifkan/nonaktifkan.
 *
 * KOLOM:
 *   image_path   → path file gambar di storage/public/landing-ads/
 *   title        → judul overlay (opsional)
 *   description  → deskripsi overlay (opsional, maks 1000 karakter)
 *   youtube_url  → link YouTube (opsional) — diparse jadi embed URL
 *   sort_order   → urutan tampil di slider (angka kecil = tampil duluan)
 *   is_active    → false = disembunyikan dari landing page tanpa dihapus
 *
 * ACCESSOR YOUTUBE:
 *   youtube_id        → ID video (11 karakter)
 *   youtube_embed     → URL untuk iframe src
 *   youtube_watch     → URL untuk dibuka di browser
 *   youtube_thumbnail → URL thumbnail gambar video
 * ──────────────────────────────────────────────────────────────
 */
class LandingAd extends Model
{
    protected $fillable = [
        'image_path',   // path gambar utama
        'title',        // judul overlay, opsional
        'description',  // deskripsi overlay, opsional
        'youtube_url',  // URL YouTube penuh (berbagai format didukung)
        'sort_order',   // posisi di slider (urut ascending)
        'is_active',    // apakah ditampilkan di landing page
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // =========================================================
    //  ACCESSOR YOUTUBE
    //  Semua diakses via $ad->youtube_id, $ad->youtube_embed, dst.
    // =========================================================

    /**
     * getYoutubeIdAttribute()
     * Ekstrak 11-karakter video ID dari berbagai format URL YouTube:
     *   youtu.be/ID
     *   youtube.com/watch?v=ID
     *   youtube.com/embed/ID
     *   youtube.com/shorts/ID
     * Mengembalikan null jika bukan URL YouTube valid.
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if (!$this->youtube_url) return null;

        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_\-]{11})/',
            $this->youtube_url,
            $m
        );

        return $m[1] ?? null;
    }

    /**
     * getYoutubeEmbedAttribute()
     * URL untuk dipakai sebagai src iframe YouTube.
     * rel=0          → tidak tampilkan video terkait dari channel lain
     * modestbranding → kurangi branding YouTube
     */
    public function getYoutubeEmbedAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id
            ? "https://www.youtube.com/embed/{$id}?rel=0&modestbranding=1"
            : null;
    }

    /**
     * getYoutubeWatchAttribute()
     * URL lengkap untuk dibuka langsung di YouTube.
     */
    public function getYoutubeWatchAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube.com/watch?v={$id}" : null;
    }

    /**
     * getYoutubeThumbnailAttribute()
     * URL thumbnail HQ untuk ditampilkan sebagai preview gambar video.
     */
    public function getYoutubeThumbnailAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : null;
    }
}

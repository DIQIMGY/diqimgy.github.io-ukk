<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Ulasan
 * ──────────────────────────────────────────────────────────────
 * Menyimpan ulasan/rating yang diberikan siswa setelah
 * mengembalikan buku.
 *
 * CONSTRAINT:
 *   - Satu peminjaman hanya bisa punya SATU ulasan (unique peminjaman_id)
 *   - Ulasan baru bisa diberikan setelah status peminjaman = 'dikembalikan'
 *
 * RELASI:
 *   Ulasan → Peminjaman (belongsTo) — 1 ulasan per 1 peminjaman
 *   Ulasan → Buku       (belongsTo) — shortcut ke buku yang diulas
 *   Ulasan → Anggota    (belongsTo) — siapa yang memberi ulasan
 *
 * CATATAN TABEL:
 *   Nama tabel 'ulasan' (bukan 'ulasans'), perlu eksplisit.
 * ──────────────────────────────────────────────────────────────
 */
class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'peminjaman_id', // FK → tabel peminjaman (unique: 1 peminjaman = 1 ulasan)
        'buku_id',       // FK → tabel buku (shortcut, bisa diambil via peminjaman juga)
        'anggota_id',    // FK → tabel anggota
        'rating',        // nilai 1–5 bintang
        'komentar',      // teks ulasan, opsional
    ];

    // =========================================================
    //  RELASI
    // =========================================================

    /**
     * peminjaman()
     * Ulasan ini berasal dari transaksi peminjaman tertentu.
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * buku()
     * Buku yang diulas — shortcut agar tidak perlu lewat peminjaman dulu.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * anggota()
     * Siswa yang memberi ulasan ini.
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // =========================================================
    //  ACCESSOR
    // =========================================================

    /**
     * getStarsAttribute()
     * Render nilai rating sebagai karakter bintang.
     * Contoh: rating=4 → "★★★★☆"
     * Akses via: $ulasan->stars
     */
    public function getStarsAttribute(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}

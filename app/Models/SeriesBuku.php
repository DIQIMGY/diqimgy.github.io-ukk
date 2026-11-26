<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model SeriesBuku
 * ──────────────────────────────────────────────────────────────
 * Model pivot yang merepresentasikan relasi Series ↔ Buku.
 * Setiap record = satu buku yang masuk ke dalam satu series,
 * beserta informasi posisi dan statusnya.
 *
 * KENAPA PAKAI MODEL (bukan pivot biasa)?
 *   Karena kita perlu operasi langsung ke tabel pivot:
 *   - Update urutan_baca satu per satu (updateUrutan)
 *   - Toggle is_penutup
 *   - Re-number urutan setelah hapus buku
 *   SeriesBuku::where(...)->update() lebih mudah daripada sync/attach.
 *
 * TIMESTAMPS:
 *   Tabel ini hanya punya created_at (tidak ada updated_at).
 *   $timestamps = false → Laravel tidak auto-manage timestamps.
 *   CREATED_AT diset manual, UPDATED_AT = null.
 *
 * UNIQUE CONSTRAINT di DB:
 *   Kombinasi (series_id, buku_id) harus unik →
 *   satu buku hanya bisa masuk ke series yang sama sekali.
 * ──────────────────────────────────────────────────────────────
 */
class SeriesBuku extends Model
{
    protected $table    = 'series_buku';
    public    $timestamps = false;      // tabel tidak punya updated_at

    const CREATED_AT = 'created_at';   // tetap tracking kapan buku ditambahkan
    const UPDATED_AT = null;           // tidak ada updated_at

    protected $fillable = [
        'series_id',     // FK ke tabel series
        'buku_id',       // FK ke tabel buku
        'urutan_baca',   // urutan membaca buku dalam seri (1 = pertama)
        'urutan_terbit', // urutan terbit asli (bisa beda dari urutan baca)
        'is_penutup',    // true = buku ini adalah buku penutup/akhir seri
    ];

    protected $casts = [
        'is_penutup'    => 'boolean',
        'urutan_baca'   => 'integer',
        'urutan_terbit' => 'integer',
    ];

    // =========================================================
    //  RELASI
    // =========================================================

    /**
     * series()
     * Pivot ini milik series mana.
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /**
     * buku()
     * Pivot ini merujuk ke buku mana.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}

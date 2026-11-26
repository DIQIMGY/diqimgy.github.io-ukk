<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Model Series
 * ──────────────────────────────────────────────────────────────
 * Merepresentasikan satu seri buku (kumpulan buku berurutan).
 * Contoh: "Harry Potter", "Bumi Manusia Tetralogi".
 *
 * STRUKTUR:
 *   Series ←→ Buku  (many-to-many via tabel pivot 'series_buku')
 *   Pivot menyimpan: urutan_baca, urutan_terbit, is_penutup
 *
 * SLUG:
 *   Dibuat otomatis dari nama_series saat record pertama kali dibuat.
 *   Dipakai di URL publik: /series/{slug}
 *   Contoh: "Harry Potter" → "harry-potter"
 * ──────────────────────────────────────────────────────────────
 */
class Series extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'nama_series',  // nama seri, harus unik
        'penulis',      // penulis seri (bisa beda dari pengarang tiap buku)
        'deskripsi',    // deskripsi singkat seri, opsional
        'cover_series', // path file cover khusus seri (opsional, fallback ke cover buku pertama)
        'slug',         // URL-friendly version dari nama_series
    ];

    // =========================================================
    //  MODEL EVENTS
    // =========================================================

    /**
     * booted()
     * Auto-generate slug dari nama_series saat record baru dibuat,
     * jika slug belum diisi secara manual.
     */
    protected static function booted(): void
    {
        static::creating(function (Series $s) {
            if (empty($s->slug)) {
                $s->slug = Str::slug($s->nama_series); // "Harry Potter" → "harry-potter"
            }
        });
    }

    // =========================================================
    //  RELASI
    // =========================================================

    /**
     * seriesBuku()
     * Akses langsung ke tabel pivot series_buku sebagai model.
     * Dipakai saat perlu update data pivot (urutan, is_penutup).
     * Terurut berdasarkan urutan_baca.
     */
    public function seriesBuku()
    {
        return $this->hasMany(SeriesBuku::class)
                    ->orderBy('urutan_baca');
    }

    /**
     * buku()
     * Semua buku dalam series ini, diakses via many-to-many.
     * withPivot → data pivot (urutan_baca, urutan_terbit, is_penutup)
     *             ikut disertakan saat query.
     * Terurut berdasarkan urutan_baca secara default.
     */
    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'series_buku')
                    ->withPivot(['urutan_baca', 'urutan_terbit', 'is_penutup'])
                    ->orderBy('series_buku.urutan_baca');
    }

    /**
     * bukuPreview()
     * Ambil maksimal 5 buku pertama untuk ditampilkan di card ringkasan.
     * Dipakai di landing page dan halaman daftar series.
     */
    public function bukuPreview()
    {
        return $this->belongsToMany(Buku::class, 'series_buku')
                    ->withPivot(['urutan_baca'])
                    ->orderBy('series_buku.urutan_baca')
                    ->limit(5);
    }

    // =========================================================
    //  HELPER
    // =========================================================

    /**
     * jumlahBuku()
     * Hitung jumlah buku dalam series ini.
     * Gunakan withCount('buku') di query untuk performa lebih baik
     * saat dipakai di loop/daftar.
     */
    public function jumlahBuku(): int
    {
        return $this->buku()->count();
    }
}

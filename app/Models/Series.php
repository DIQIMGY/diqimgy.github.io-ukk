<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Series extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'nama_series',
        'penulis',
        'deskripsi',
        'cover_series',
        'slug',
    ];

    // ── Auto-generate slug dari nama_series ──────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Series $s) {
            if (empty($s->slug)) {
                $s->slug = Str::slug($s->nama_series);
            }
        });
    }

    // ── Relasi ke tabel pivot series_buku ────────────────────────────────
    public function seriesBuku()
    {
        return $this->hasMany(SeriesBuku::class)
                    ->orderBy('urutan_baca');
    }

    // ── Buku-buku dalam series, urut urutan_baca ─────────────────────────
    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'series_buku')
                    ->withPivot(['urutan_baca', 'urutan_terbit', 'is_penutup'])
                    ->orderBy('series_buku.urutan_baca');
    }

    // ── Preview 5 judul buku pertama untuk card ringkasan ─────────────────
    public function bukuPreview()
    {
        return $this->belongsToMany(Buku::class, 'series_buku')
                    ->withPivot(['urutan_baca'])
                    ->orderBy('series_buku.urutan_baca')
                    ->limit(5);
    }

    // ── Helper: jumlah buku ───────────────────────────────────────────────
    public function jumlahBuku(): int
    {
        return $this->buku()->count();
    }
}

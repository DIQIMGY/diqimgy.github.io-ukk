<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeriesBuku extends Model
{
    protected $table    = 'series_buku';
    public    $timestamps = false;   // tabel hanya punya created_at

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'series_id',
        'buku_id',
        'urutan_baca',
        'urutan_terbit',
        'is_penutup',
    ];

    protected $casts = [
        'is_penutup'    => 'boolean',
        'urutan_baca'   => 'integer',
        'urutan_terbit' => 'integer',
    ];

    // ── Relasi ke Series ──────────────────────────────────────────────────
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    // ── Relasi ke Buku ────────────────────────────────────────────────────
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}

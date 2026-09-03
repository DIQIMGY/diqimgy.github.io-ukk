<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'isbn',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'stok',
        'cover',
        'deskripsi',
        'rating',
        'is_featured',
        'returned_at',
        'waitlist_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'returned_at' => 'datetime',
        'rating' => 'decimal:1',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}

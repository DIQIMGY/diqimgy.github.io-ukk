<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'stok',
        'cover',
        'deskripsi',
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

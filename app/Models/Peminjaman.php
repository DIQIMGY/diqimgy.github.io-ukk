<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_pinjam',
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'denda',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam'          => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual'  => 'date',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /**
     * Hitung denda berdasarkan keterlambatan (Rp 1.000/hari).
     */
    public function hitungDenda(): int
    {
        if ($this->tanggal_kembali_aktual && $this->tanggal_kembali_aktual->gt($this->tanggal_kembali_rencana)) {
            $selisih = $this->tanggal_kembali_rencana->diffInDays($this->tanggal_kembali_aktual);
            return $selisih * 1000;
        }
        return 0;
    }
}

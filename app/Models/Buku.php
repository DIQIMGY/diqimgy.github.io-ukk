<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Buku
 * ──────────────────────────────────────────────────────────────
 * Merepresentasikan satu judul buku dalam koleksi perpustakaan.
 *
 * KOLOM PENTING:
 *   stok             → jumlah fisik yang tersedia untuk dipinjam
 *                       berkurang saat approve peminjaman,
 *                       bertambah saat approve pengembalian
 *   status_launching → 'tersedia' (bisa dipinjam) atau 'segera' (coming soon)
 *   tanggal_rilis    → untuk buku 'segera', kapan akan tersedia
 *   waitlist_count   → berapa orang yang mengantri (stok = 0)
 *   is_featured      → untuk tampilan khusus di landing page
 *
 * CATATAN TABEL:
 *   Nama tabel 'buku' (bukan 'bukus'), perlu eksplisit.
 * ──────────────────────────────────────────────────────────────
 */
class Buku extends Model
{
    protected $table = 'buku'; // eksplisit karena nama tabel tidak standar

    protected $fillable = [
        'kode_buku',        // kode unik buku (misal: B001)
        'isbn',             // nomor ISBN, opsional
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'stok',             // jumlah tersedia untuk dipinjam
        'cover',            // path file cover di storage/public/covers/
        'deskripsi',
        'rating',           // rata-rata rating dari ulasan (disimpan sebagai cache)
        'is_featured',      // ditampilkan di section featured landing page
        'returned_at',      // timestamp terakhir kali buku ini dikembalikan
        'waitlist_count',   // jumlah siswa yang mengantri saat stok habis
        'status_launching', // 'tersedia' atau 'segera'
        'tanggal_rilis',    // tanggal rencana tersedia (untuk status 'segera')
    ];

    protected $casts = [
        'is_featured'      => 'boolean',
        'returned_at'      => 'datetime',
        'rating'           => 'decimal:1',  // satu angka di belakang koma
        'tanggal_rilis'    => 'date',
    ];

    // =========================================================
    //  RELASI
    // =========================================================

    /**
     * peminjaman()
     * Semua riwayat peminjaman untuk buku ini.
     * Dipakai untuk withCount('peminjaman') → kolom peminjaman_count.
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * ulasan()
     * Semua ulasan/rating yang diberikan untuk buku ini.
     * Dipakai untuk withAvg('ulasan', 'rating') → rata-rata rating.
     */
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }

    /**
     * series()
     * Series-series yang mengandung buku ini (many-to-many via pivot series_buku).
     * withPivot → ikut sertakan kolom urutan_baca, urutan_terbit, is_penutup.
     */
    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_buku')
                    ->withPivot(['urutan_baca', 'urutan_terbit', 'is_penutup']);
    }

    // =========================================================
    //  HELPER
    // =========================================================

    /**
     * isAvailable()
     * Cek apakah buku ini tersedia untuk dipinjam (stok > 0).
     * Dipakai di view untuk disable tombol pinjam.
     */
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}

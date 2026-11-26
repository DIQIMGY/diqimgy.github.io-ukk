<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Anggota
 * ──────────────────────────────────────────────────────────────
 * Menyimpan data profil anggota perpustakaan.
 * Setiap anggota terhubung ke satu akun User (untuk login).
 *
 * PERBEDAAN User vs Anggota:
 *   User    → data autentikasi (email, password, role)
 *   Anggota → data profil perpustakaan (NIS, kelas, alamat, foto)
 *
 * CATATAN TABEL:
 *   Nama tabel 'anggota' (bukan 'anggotas'), sehingga perlu
 *   protected $table = 'anggota' secara eksplisit.
 *   Route model binding menggunakan nama 'anggotum' karena
 *   Laravel men-singularize 'anggota' menjadi 'anggotum'.
 * ──────────────────────────────────────────────────────────────
 */
class Anggota extends Model
{
    protected $table = 'anggota'; // eksplisit karena nama tabel tidak standar

    protected $fillable = [
        'user_id',   // FK ke tabel users
        'nis',       // Nomor Induk Siswa — unik
        'nama',      // nama lengkap siswa
        'kelas',     // contoh: "10 IPA 1"
        'alamat',    // opsional
        'telepon',   // opsional
        'foto',      // path file foto di storage/public/anggota/
        'status',    // 'aktif' atau 'nonaktif' — nonaktif tidak bisa pinjam
    ];

    // =========================================================
    //  RELASI
    // =========================================================

    /**
     * user()
     * Satu anggota terhubung ke satu akun user (untuk login).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * peminjaman()
     * Semua riwayat peminjaman milik anggota ini (semua status).
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * peminjamanAktif()
     * Peminjaman yang masih aktif: pending, dipinjam, terlambat, atau pending_kembali.
     * Dipakai untuk cek apakah anggota masih punya tanggungan
     * sebelum diizinkan pinjam lagi atau dilakukan perubahan status.
     */
    public function peminjamanAktif()
    {
        return $this->hasMany(Peminjaman::class)
            ->whereIn('status', [
                Peminjaman::STATUS_PENDING,          // belum disetujui
                Peminjaman::STATUS_DIPINJAM,          // sedang dipinjam
                Peminjaman::STATUS_TERLAMBAT,         // melewati batas
                Peminjaman::STATUS_PENDING_KEMBALI,   // sudah ajukan kembali
            ]);
    }

    /**
     * ulasan()
     * Semua ulasan yang pernah ditulis anggota ini.
     */
    public function ulasan()
    {
        return $this->hasMany(\App\Models\Ulasan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User
 * ──────────────────────────────────────────────────────────────
 * Merepresentasikan akun login pengguna aplikasi.
 * Setiap user punya role: 'admin' atau 'siswa'.
 *
 * RELASI:
 *   User → Anggota (hasOne)
 *   Anggota menyimpan data profil lengkap (nama, NIS, kelas, dll).
 *   User hanya menyimpan data untuk keperluan autentikasi.
 *
 * CARA PAKAI ROLE:
 *   Auth::user()->isAdmin()  → cek apakah admin
 *   Auth::user()->isSiswa()  → cek apakah siswa
 *   Auth::user()->anggota    → akses data profil anggota
 * ──────────────────────────────────────────────────────────────
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi via mass assignment (create / fill)
    protected $fillable = [
        'name',     // nama tampil (sinkron dengan anggota.nama)
        'email',    // dipakai untuk login
        'password', // di-hash otomatis via cast 'hashed'
        'role',     // 'admin' atau 'siswa'
        'foto',     // path foto profil
    ];

    // Kolom yang disembunyikan saat model di-serialize (misal: toArray / toJson)
    // Penting: password tidak boleh bocor ke response API/view
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast tipe data kolom secara otomatis
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed', // Laravel otomatis hash saat assign
        ];
    }

    // =========================================================
    //  HELPER ROLE
    // =========================================================

    /**
     * isAdmin()
     * Cek apakah user ini adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * isSiswa()
     * Cek apakah user ini adalah siswa.
     * Dipakai di middleware SiswaMiddleware.
     */
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // =========================================================
    //  RELASI
    // =========================================================

    /**
     * anggota()
     * Satu user punya satu data anggota perpustakaan.
     * Akses via: Auth::user()->anggota
     */
    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }
}

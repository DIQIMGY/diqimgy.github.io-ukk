<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Peminjaman
 * ──────────────────────────────────────────────────────────────
 * Merepresentasikan satu transaksi peminjaman buku.
 *
 * ALUR STATUS LENGKAP:
 *
 *   [SISWA AJUKAN PINJAM]
 *        ↓
 *     pending          → menunggu admin setujui pinjam
 *        ↓ approve()       ↓ reject()
 *     dipinjam          ditolak
 *        ↓ (melewati batas)
 *     terlambat
 *        ↓ (siswa ajukan kembali)
 *     pending_kembali   → menunggu admin konfirmasi pengembalian
 *        ↓ approveKembali()   ↓ rejectKembali()
 *     dikembalikan       kembali ke dipinjam / terlambat
 *
 * CATATAN STOK:
 *   - Stok BERKURANG  → saat approve() peminjaman
 *   - Stok BERTAMBAH  → saat approveKembali() pengembalian
 *   - pending / ditolak / pending_kembali → stok TIDAK berubah
 * ──────────────────────────────────────────────────────────────
 */
class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    // =========================================================
    //  STATUS CONSTANTS
    //  Gunakan konstanta ini di seluruh kode — jangan hardcode string
    // =========================================================
    const STATUS_PENDING         = 'pending';          // pengajuan pinjam menunggu persetujuan admin
    const STATUS_DIPINJAM        = 'dipinjam';         // sudah disetujui, buku sedang dipinjam
    const STATUS_TERLAMBAT       = 'terlambat';        // melewati batas tanggal kembali
    const STATUS_PENDING_KEMBALI = 'pending_kembali';  // siswa ajukan pengembalian, menunggu konfirmasi admin
    const STATUS_DIKEMBALIKAN    = 'dikembalikan';     // pengembalian dikonfirmasi admin, selesai
    const STATUS_DITOLAK         = 'ditolak';          // pengajuan pinjam ditolak admin

    protected $fillable = [
        'kode_pinjam',
        'anggota_id',
        'buku_id',
        'tanggal_pengajuan',          // tanggal siswa mengajukan pinjam
        'tanggal_pinjam',             // diisi saat admin approve pinjam (nullable saat pending)
        'tanggal_kembali_rencana',    // diisi saat admin approve pinjam, 7 hari dari tanggal_pinjam
        'tanggal_kembali_aktual',     // diisi saat admin approve pengembalian
        'status',
        'denda',
        'denda_dibayar',
        'denda_dibayar_at',
        'keterangan',
        'approved_at',                // timestamp saat admin approve peminjaman
        'return_requested_at',        // timestamp saat siswa mengajukan pengembalian
        'rejected_at',                // timestamp saat admin tolak peminjaman
        'rejection_reason',           // alasan penolakan peminjaman
    ];

    protected $casts = [
        'tanggal_pengajuan'        => 'date',
        'tanggal_pinjam'           => 'date',
        'tanggal_kembali_rencana'  => 'date',
        'tanggal_kembali_aktual'   => 'date',
        'denda_dibayar'            => 'boolean',
        'denda_dibayar_at'         => 'datetime',
        'approved_at'              => 'datetime',
        'return_requested_at'      => 'datetime',
        'rejected_at'              => 'datetime',
    ];

    // =========================================================
    //  RELASI
    // =========================================================

    /** Relasi ke anggota yang meminjam */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    /** Relasi ke buku yang dipinjam */
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    /** Relasi ke ulasan (satu peminjaman → satu ulasan) */
    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }

    // =========================================================
    //  HELPER STATUS — cek status tanpa hardcode string
    // =========================================================

    /** Apakah pengajuan pinjam sedang menunggu persetujuan admin */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /** Apakah buku sedang aktif dipinjam (sudah diapprove, belum dikembalikan) */
    public function isDipinjam(): bool
    {
        return $this->status === self::STATUS_DIPINJAM;
    }

    /** Apakah peminjaman melewati batas tanggal kembali */
    public function isTerlambat(): bool
    {
        return $this->status === self::STATUS_TERLAMBAT;
    }

    /** Apakah siswa sudah mengajukan pengembalian dan menunggu konfirmasi admin */
    public function isPendingKembali(): bool
    {
        return $this->status === self::STATUS_PENDING_KEMBALI;
    }

    /** Apakah pengembalian sudah dikonfirmasi (transaksi selesai) */
    public function isDikembalikan(): bool
    {
        return $this->status === self::STATUS_DIKEMBALIKAN;
    }

    /** Apakah pengajuan pinjam ditolak admin */
    public function isDitolak(): bool
    {
        return $this->status === self::STATUS_DITOLAK;
    }

    /**
     * Apakah buku sedang aktif di tangan siswa
     * (dipinjam ATAU terlambat ATAU pending_kembali — buku belum kembali ke rak)
     */
    public function isAktif(): bool
    {
        return in_array($this->status, [
            self::STATUS_DIPINJAM,
            self::STATUS_TERLAMBAT,
            self::STATUS_PENDING_KEMBALI, // buku masih di tangan siswa, menunggu konfirmasi
        ]);
    }

    // =========================================================
    //  HITUNG DENDA
    // =========================================================

    /**
     * Hitung estimasi denda keterlambatan (Rp 1.000 per hari).
     * Dipakai untuk preview denda sebelum pengembalian dikonfirmasi.
     * Denda final dihitung & disimpan saat approveKembali() dijalankan admin.
     */
    public function hitungDenda(): int
    {
        if ($this->tanggal_kembali_aktual && $this->tanggal_kembali_aktual->gt($this->tanggal_kembali_rencana)) {
            $selisih = $this->tanggal_kembali_rencana->diffInDays($this->tanggal_kembali_aktual);
            return $selisih * 1000;
        }
        return 0;
    }

    // =========================================================
    //  LABEL & WARNA UNTUK UI
    // =========================================================

    /** Label teks status dalam Bahasa Indonesia */
    public function statusLabel(): string
    {
        return match($this->status) {
            self::STATUS_PENDING         => 'Menunggu Persetujuan',
            self::STATUS_DIPINJAM        => 'Dipinjam',
            self::STATUS_TERLAMBAT       => 'Terlambat',
            self::STATUS_PENDING_KEMBALI => 'Menunggu Konfirmasi Kembali',
            self::STATUS_DIKEMBALIKAN    => 'Dikembalikan',
            self::STATUS_DITOLAK         => 'Ditolak',
            default                      => ucfirst($this->status),
        };
    }

    /** Warna Bootstrap untuk badge status */
    public function statusColor(): string
    {
        return match($this->status) {
            self::STATUS_PENDING         => 'warning',
            self::STATUS_DIPINJAM        => 'primary',
            self::STATUS_TERLAMBAT       => 'danger',
            self::STATUS_PENDING_KEMBALI => 'info',
            self::STATUS_DIKEMBALIKAN    => 'success',
            self::STATUS_DITOLAK         => 'secondary',
            default                      => 'secondary',
        };
    }
}

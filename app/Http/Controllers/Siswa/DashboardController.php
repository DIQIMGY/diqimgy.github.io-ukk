<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Siswa\DashboardController
 * ──────────────────────────────────────────────────────────────
 * Menampilkan halaman dashboard siswa.
 * Berisi ringkasan aktivitas peminjaman dan rekomendasi buku.
 * ──────────────────────────────────────────────────────────────
 */
class DashboardController extends Controller
{
    /**
     * index()
     * Kumpulkan semua data untuk dashboard siswa:
     *  - Statistik peminjaman: sedang dipinjam, sudah dikembalikan, total denda belum lunas
     *  - 5 riwayat peminjaman terbaru
     *  - Semua riwayat denda (untuk tabel denda)
     *  - 8 buku populer global (rekomendasi)
     *
     * Juga menjalankan auto-update status 'dipinjam' → 'terlambat'
     * agar status di dashboard selalu akurat.
     */
    public function index()
    {
        $anggota = Auth::user()->anggota;

        // Default value jika anggota belum ada (misal: akun baru yang belum punya data anggota)
        $totalPinjam  = 0;
        $totalKembali = 0;
        $totalDenda   = 0;
        $riwayat      = collect();
        $riwayatDenda = collect();

        if ($anggota) {
            // ── Auto-update status terlambat ──────────────────────
            // Jalankan setiap buka dashboard agar status selalu fresh.
            // Hanya proses yang sudah diapprove (status 'dipinjam') dan melewati batas kembali.
            Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', Peminjaman::STATUS_DIPINJAM)
                ->where('tanggal_kembali_rencana', '<', Carbon::today())
                ->update(['status' => Peminjaman::STATUS_TERLAMBAT]);

            // ── Statistik ─────────────────────────────────────────
            // Jumlah buku yang sedang aktif di tangan siswa
            $totalPinjam  = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', [
                    Peminjaman::STATUS_DIPINJAM,
                    Peminjaman::STATUS_TERLAMBAT,
                    Peminjaman::STATUS_PENDING_KEMBALI, // sudah minta kembali, belum dikonfirmasi
                ])
                ->count();

            // Jumlah peminjaman yang sudah selesai dikembalikan
            $totalKembali = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', Peminjaman::STATUS_DIKEMBALIKAN)
                ->count();

            // Total denda yang belum dibayar (nominal rupiah)
            $totalDenda = Peminjaman::where('anggota_id', $anggota->id)
                ->where('denda', '>', 0)
                ->where('denda_dibayar', false)
                ->sum('denda');

            // ── 5 riwayat terbaru ─────────────────────────────────
            // Untuk widget "Aktivitas Terbaru" di dashboard
            $riwayat = Peminjaman::with('buku')
                ->where('anggota_id', $anggota->id)
                ->latest()
                ->take(5)
                ->get();

            // ── Riwayat semua denda ───────────────────────────────
            // Untuk tabel "Denda & Tagihan" di dashboard
            $riwayatDenda = Peminjaman::with('buku')
                ->where('anggota_id', $anggota->id)
                ->where('denda', '>', 0)
                ->latest('tanggal_kembali_aktual')
                ->get();
        }

        // ── Buku populer (semua siswa bisa lihat) ─────────────────
        // withCount('peminjaman') → kolom peminjaman_count untuk sorting
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(8)
            ->get();

        return view('siswa.dashboard', compact(
            'anggota',
            'totalPinjam',
            'totalKembali',
            'totalDenda',
            'riwayat',
            'riwayatDenda',
            'bukuPopuler'
        ));
    }
}

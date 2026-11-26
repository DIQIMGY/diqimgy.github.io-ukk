<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

/**
 * Admin\DashboardController
 * ──────────────────────────────────────────────────────────────
 * Menampilkan halaman utama panel admin.
 * Berisi ringkasan statistik perpustakaan dan data terbaru.
 * ──────────────────────────────────────────────────────────────
 */
class DashboardController extends Controller
{
    /**
     * index()
     * Kumpulkan semua data untuk ditampilkan di dashboard admin:
     *  - Angka statistik (jumlah buku, anggota, peminjaman aktif, dll)
     *  - 5 transaksi peminjaman terbaru
     *  - 5 buku paling sering dipinjam
     *  - 8 buku terbaru untuk bagian showcase/galeri
     */
    public function index()
    {
        // ── Statistik ringkas ────────────────────────────────────
        $totalBuku        = Buku::count();                                            // total judul buku
        $totalAnggota     = Anggota::count();                                         // total anggota terdaftar
        $totalTransaksi   = Peminjaman::count();                                      // total semua transaksi
        $totalPending     = Peminjaman::where('status', 'pending')->count();          // menunggu approval
        $totalPendingKembali = Peminjaman::where('status', Peminjaman::STATUS_PENDING_KEMBALI)->count();
        $totalDipinjam    = Peminjaman::where('status', 'dipinjam')->count();         // sedang dipinjam
        $totalTerlambat   = Peminjaman::where('status', 'terlambat')->count();        // melewati batas kembali
        $totalDikembalikan= Peminjaman::where('status', 'dikembalikan')->count();     // sudah dikembalikan
        $totalDendaBelumLunas = Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)
            ->where('denda', '>', 0)
            ->where('denda_dibayar', false)
            ->count();

        $pengembalianMenunggu = Peminjaman::with(['anggota', 'buku'])
            ->where('status', Peminjaman::STATUS_PENDING_KEMBALI)
            ->latest('return_requested_at')
            ->take(5)
            ->get();

        $dendaBelumLunas = Peminjaman::with(['anggota', 'buku'])
            ->where('status', Peminjaman::STATUS_DIKEMBALIKAN)
            ->where('denda', '>', 0)
            ->where('denda_dibayar', false)
            ->latest('tanggal_kembali_aktual')
            ->take(5)
            ->get();

        // ── Transaksi peminjaman terbaru ────────────────────────
        // Eager load anggota & buku supaya tidak terjadi N+1 query di view
        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(10)
            ->get();

        // ── Buku paling populer (paling banyak dipinjam) ────────
        // withCount('peminjaman') → tambah kolom peminjaman_count ke setiap buku
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'totalTransaksi',
            'totalPending',
            'totalPendingKembali',
            'totalDipinjam',
            'totalTerlambat',
            'totalDikembalikan',
            'totalDendaBelumLunas',
            'pengembalianMenunggu',
            'dendaBelumLunas',
            'peminjamanTerbaru',
            'bukuPopuler'
        ));
    }
}

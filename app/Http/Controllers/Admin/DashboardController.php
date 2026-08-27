<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku      = Buku::count();
        $totalAnggota   = Anggota::count();
        $totalPinjam    = Peminjaman::where('status', 'dipinjam')->count();
        $totalTerlambat = Peminjaman::where('status', 'terlambat')->count();
        $totalKembali   = Peminjaman::where('status', 'dikembalikan')->count();

        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        // Buku terpopuler — berdasarkan total semua transaksi
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'totalPinjam',
            'totalTerlambat',
            'totalKembali',
            'peminjamanTerbaru',
            'bukuPopuler'
        ));
    }
}

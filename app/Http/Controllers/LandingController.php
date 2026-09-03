<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class LandingController extends Controller
{
    public function index()
    {
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(6)->get();

        $bukuTerbaru = Buku::latest()->take(4)->get();

        $bukuStokTerbanyak = Buku::orderByDesc('stok')->take(4)->get();

        // Buku waitlist (stok = 0, punya waitlist_count)
        $bukuWaitlist = Buku::where('stok', 0)
            ->where('waitlist_count', '>', 0)
            ->orderByDesc('waitlist_count')
            ->take(6)
            ->get();

        // Buku baru dikembalikan (stok terbatas 1-3, ada history peminjaman)
        $bukuBaruKembali = Buku::whereBetween('stok', [1, 3])
            ->withCount('peminjaman')
            ->having('peminjaman_count', '>', 0)
            ->orderByDesc('peminjaman_count')
            ->take(6)
            ->get();

        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        $totalBuku  = Buku::count();
        $totalStok  = Buku::sum('stok');

        return view('landing', compact(
            'bukuPopuler', 'bukuTerbaru', 'bukuStokTerbanyak', 'bukuWaitlist', 'bukuBaruKembali',
            'kategoris', 'totalBuku', 'totalStok'
        ));
    }
}

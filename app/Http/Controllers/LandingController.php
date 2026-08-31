<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class LandingController extends Controller
{
    public function index()
    {
        // Buku populer (paling banyak dipinjam)
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(6)
            ->get();

        // Buku terbaru (berdasarkan created_at)
        $bukuTerbaru = Buku::latest()->take(4)->get();

        // Semua kategori
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        // Total statistik
        $totalBuku    = Buku::count();
        $totalStok    = Buku::sum('stok');

        return view('landing', compact(
            'bukuPopuler',
            'bukuTerbaru',
            'kategoris',
            'totalBuku',
            'totalStok'
        ));
    }
}

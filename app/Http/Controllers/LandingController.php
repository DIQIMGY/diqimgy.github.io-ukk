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

        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        $totalBuku  = Buku::count();
        $totalStok  = Buku::sum('stok');

        return view('landing', compact(
            'bukuPopuler', 'bukuTerbaru', 'bukuStokTerbanyak',
            'kategoris', 'totalBuku', 'totalStok'
        ));
    }
}

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

        // Koleksi Series — ringkasan untuk card
        // Ambil cover buku pertama (urutan_baca=1) + 5 judul preview untuk card ringkasan
        $semuaSeries = \App\Models\Series::withCount('buku')
            ->having('buku_count', '>', 0)
            ->orderBy('nama_series')
            ->with([
                // Cover buku pertama
                'buku' => function ($q) {
                    $q->where('series_buku.urutan_baca', 1)
                      ->select('buku.id', 'buku.judul', 'buku.cover', 'buku.pengarang');
                },
                // Preview 5 judul buku pertama untuk ditampilkan di card
                'bukuPreview' => function ($q) {
                    $q->orderBy('series_buku.urutan_baca')
                      ->limit(5)
                      ->select('buku.id', 'buku.judul');
                }
            ])
            ->get();

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

        // Buku segera hadir (coming soon)
        $bukuSegeraHadir = Buku::where('status_launching', 'segera')
            ->whereNotNull('tanggal_rilis')
            ->orderBy('tanggal_rilis')
            ->take(6)
            ->get();

        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        $totalBuku  = Buku::count();
        $totalStok  = Buku::sum('stok');

        return view('landing', compact(
            'bukuPopuler', 'bukuTerbaru', 'bukuStokTerbanyak', 'bukuWaitlist', 'bukuBaruKembali', 'bukuSegeraHadir',
            'semuaSeries',
            'kategoris', 'totalBuku', 'totalStok'
        ));
    }

    public function allBooks()
    {
        // Group buku berdasarkan kategori dengan pagination
        $kategoriList = \App\Models\Buku::select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->orderBy('kategori')
            ->pluck('kategori');
        
        // Pagination kategori - 1 kategori per halaman
        $perPage = 1;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        
        $kategoriPaginated = $kategoriList->slice($offset, $perPage);
        
        $bukuPerKategori = [];
        foreach($kategoriPaginated as $kat) {
            $books = \App\Models\Buku::where('kategori', $kat)
                ->orderBy('judul', 'asc')
                ->get();
            if($books->count() > 0) {
                $bukuPerKategori[$kat] = $books;
            }
        }
        
        // Manual pagination object
        $totalKategori = $kategoriList->count();
        $lastPage = ceil($totalKategori / $perPage);
        
        $pagination = (object)[
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'total' => $totalKategori,
            'per_page' => $perPage,
            'has_pages' => $totalKategori > $perPage,
            'has_more_pages' => $currentPage < $lastPage,
            'on_first_page' => $currentPage == 1,
        ];
        
        return view('buku.all', compact('bukuPerKategori', 'kategoriPaginated', 'pagination'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\LandingAd;

/**
 * LandingController
 * ──────────────────────────────────────────────────────────────
 * Menampilkan halaman publik yang bisa diakses siapa saja
 * (tidak perlu login): landing page, semua buku, semua ulasan.
 *
 * Semua method di sini hanya READ — tidak ada operasi tulis.
 * ──────────────────────────────────────────────────────────────
 */
class LandingController extends Controller
{
    /**
     * index()
     * Tampilkan halaman landing page utama perpustakaan.
     * Mengumpulkan berbagai kategori buku untuk ditampilkan di section berbeda:
     *
     *   - bukuPopuler       : 6 buku paling sering dipinjam
     *   - bukuTerbaru       : 4 buku yang paling baru ditambahkan
     *   - bukuStokTerbanyak : 4 buku dengan stok paling banyak
     *   - semuaSeries       : semua series dengan preview cover & judul
     *   - bukuWaitlist      : buku habis stok tapi punya antrian
     *   - bukuBaruKembali   : buku stok terbatas (1-3) yang baru dikembalikan
     *   - bukuSegeraHadir   : buku dengan status_launching = 'segera'
     *   - bukuRatingTinggi  : buku dengan rata-rata rating tertinggi
     *   - ulasanTerbaru     : 6 ulasan terbaru rating ≥ 4 untuk testimonial
     *   - landingAds        : banner/iklan yang aktif
     */
    public function index()
    {
        // ── Buku populer: paling banyak dipinjam ────────────────
        $bukuPopuler = Buku::withCount('peminjaman')
            ->withAvg('ulasan', 'rating')
            ->orderByDesc('peminjaman_count')
            ->take(6)->get();

        // ── Buku terbaru: baru ditambahkan ke koleksi ────────────
        $bukuTerbaru = Buku::latest()
            ->withAvg('ulasan', 'rating')
            ->take(4)->get();

        // ── Buku stok terbanyak: tersedia banyak untuk dipinjam ──
        $bukuStokTerbanyak = Buku::orderByDesc('stok')
            ->withAvg('ulasan', 'rating')
            ->take(4)->get();

        // ── Semua series: untuk card ringkasan series di landing ──
        // Ambil cover buku pertama (urutan_baca=1) sebagai cover series
        // dan 5 judul buku pertama untuk preview daftar
        $semuaSeries = \App\Models\Series::withCount('buku')
            ->having('buku_count', '>', 0)  // hanya series yang punya buku
            ->orderBy('nama_series')
            ->with([
                // Cover: hanya buku urutan pertama
                'buku' => function ($q) {
                    $q->where('series_buku.urutan_baca', 1)
                      ->select('buku.id', 'buku.judul', 'buku.cover', 'buku.pengarang');
                },
                // Preview 5 judul buku untuk ditampilkan di card
                'bukuPreview' => function ($q) {
                    $q->orderBy('series_buku.urutan_baca')
                      ->limit(5)
                      ->select('buku.id', 'buku.judul');
                }
            ])
            ->get();

        // ── Buku waitlist: stok habis, ada yang antre ────────────
        $bukuWaitlist = Buku::where('stok', 0)
            ->where('waitlist_count', '>', 0)
            ->withAvg('ulasan', 'rating')
            ->orderByDesc('waitlist_count')
            ->take(6)
            ->get();

        // ── Buku baru kembali: stok terbatas (1-3), ada riwayat pinjam ──
        // Ini menandakan buku yang baru saja dikembalikan
        $bukuBaruKembali = Buku::whereBetween('stok', [1, 3])
            ->whereHas('peminjaman')    // harus punya riwayat dipinjam
            ->withCount('peminjaman')
            ->withAvg('ulasan', 'rating')
            ->orderByDesc('peminjaman_count')
            ->take(6)
            ->get();

        // ── Buku segera hadir: coming soon ───────────────────────
        $bukuSegeraHadir = Buku::where('status_launching', 'segera')
            ->whereNotNull('tanggal_rilis')
            ->withAvg('ulasan', 'rating')
            ->orderBy('tanggal_rilis') // urut dari yang paling dekat tanggal rilisnya
            ->take(6)
            ->get();

        $kategoris  = Buku::select('kategori')->distinct()->pluck('kategori');
        $totalBuku  = Buku::count();
        $totalStok  = Buku::sum('stok');

        // ── Iklan landing page yang aktif ─────────────────────────
        $landingAds = LandingAd::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // ── Buku rating tertinggi ─────────────────────────────────
        // Ambil buku yang punya ulasan, urut dari avg rating tertinggi
        // Tiebreaker: jumlah ulasan lebih banyak → lebih atas
        $bukuRatingTinggi = Buku::where('stok', '>', 0)
            ->withAvg('ulasan', 'rating')
            ->withCount('ulasan')
            ->having('ulasan_avg_rating', '>', 0) // harus punya ulasan
            ->orderByDesc('ulasan_avg_rating')
            ->orderByDesc('ulasan_count')
            ->take(5)
            ->get();

        // Fallback: kalau belum ada ulasan sama sekali, tampilkan buku populer
        if ($bukuRatingTinggi->isEmpty()) {
            $bukuRatingTinggi = Buku::where('stok', '>', 0)
                ->withCount('peminjaman')
                ->withAvg('ulasan', 'rating')
                ->orderByDesc('peminjaman_count')
                ->take(5)
                ->get();
        }

        // Pisah: buku utama (featured) dan 4 buku kecil di sampingnya
        $ratingMainBook   = $bukuRatingTinggi->first();
        $ratingSmallBooks = $bukuRatingTinggi->skip(1)->take(4);

        // ── Ulasan terbaru untuk testimonial ─────────────────────
        // Hanya ulasan bagus (≥ 4 bintang) yang ada komentarnya
        $ulasanTerbaru = \App\Models\Ulasan::with(['buku', 'anggota.user'])
            ->where('rating', '>=', 4)
            ->whereNotNull('komentar')
            ->where('komentar', '!=', '')
            ->latest()
            ->take(6)
            ->get();

        return view('landing', compact(
            'bukuPopuler', 'bukuTerbaru', 'bukuStokTerbanyak',
            'bukuWaitlist', 'bukuBaruKembali', 'bukuSegeraHadir',
            'semuaSeries',
            'kategoris', 'totalBuku', 'totalStok',
            'landingAds', 'ulasanTerbaru',
            'ratingMainBook', 'ratingSmallBooks'
        ));
    }

    /**
     * allBooks()
     * Tampilkan halaman daftar semua buku dikelompokkan per kategori.
     * Menggunakan paginasi manual per kategori (1 kategori per halaman)
     * agar halaman tidak terlalu berat jika koleksi sangat banyak.
     *
     * Setiap kategori ditampilkan dengan semua bukunya, urut dari
     * yang paling banyak dipinjam → paling jarang.
     */
    public function allBooks()
    {
        // Ambil semua kategori yang unik, urut abjad
        $kategoriList = \App\Models\Buku::select('kategori')
            ->distinct()
            ->whereNotNull('kategori')
            ->orderBy('kategori')
            ->pluck('kategori');

        // Paginasi manual: 1 kategori per halaman
        $perPage     = 1;
        $currentPage = request()->get('page', 1);
        $offset      = ($currentPage - 1) * $perPage;

        // Slice kategori yang ditampilkan di halaman ini
        $kategoriPaginated = $kategoriList->slice($offset, $perPage);

        // Ambil buku-buku untuk kategori yang ditampilkan di halaman ini
        $bukuPerKategori = [];
        foreach ($kategoriPaginated as $kat) {
            $books = \App\Models\Buku::where('kategori', $kat)
                ->withCount('peminjaman')
                ->withAvg('ulasan', 'rating')
                ->orderByDesc('peminjaman_count')
                ->get();
            if ($books->count() > 0) {
                $bukuPerKategori[$kat] = $books;
            }
        }

        // Buat objek paginasi manual (karena tidak pakai Eloquent paginate())
        $totalKategori = $kategoriList->count();
        $lastPage      = ceil($totalKategori / $perPage);

        $pagination = (object)[
            'current_page'    => $currentPage,
            'last_page'       => $lastPage,
            'total'           => $totalKategori,
            'per_page'        => $perPage,
            'has_pages'       => $totalKategori > $perPage,
            'has_more_pages'  => $currentPage < $lastPage,
            'on_first_page'   => $currentPage == 1,
        ];

        return view('buku.all', compact('bukuPerKategori', 'kategoriPaginated', 'pagination'));
    }

    /**
     * allUlasan()
     * Tampilkan halaman semua ulasan publik.
     * Diakses dari footer / menu navigasi landing page.
     * Menampilkan ulasan dengan rating ≥ 1, 12 per halaman.
     */
    public function allUlasan()
    {
        $ulasan = \App\Models\Ulasan::with(['buku', 'anggota.user'])
            ->where('rating', '>=', 1)
            ->latest()
            ->paginate(12);

        $rataRata    = \App\Models\Ulasan::avg('rating');
        $totalUlasan = \App\Models\Ulasan::count();

        return view('ulasan.all', compact('ulasan', 'rataRata', 'totalUlasan'));
    }
}

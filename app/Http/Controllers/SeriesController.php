<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

/**
 * SeriesController (Publik)
 * ──────────────────────────────────────────────────────────────
 * Menampilkan halaman series buku untuk pengunjung publik
 * (tidak perlu login). Berbeda dengan Admin\SeriesController
 * yang untuk mengelola data series.
 *
 * Route prefix: /series  (tanpa prefix /admin)
 * ──────────────────────────────────────────────────────────────
 */
class SeriesController extends Controller
{
    /**
     * index()
     * Tampilkan halaman daftar semua series dalam grid kartu.
     * Setiap kartu menampilkan:
     *  - Cover 4 buku pertama (dalam urutan baca)
     *  - Nama series, penulis, jumlah buku
     *  - Preview 5 judul buku pertama
     *
     * Hanya tampilkan series yang punya buku (buku_count > 0).
     * Paginasi 12 series per halaman.
     */
    public function index()
    {
        $semuaSeries = Series::withCount('buku')
            ->having('buku_count', '>', 0)  // filter series kosong
            ->orderBy('nama_series')
            ->with([
                // 4 buku pertama: untuk ditampilkan covernya di kartu
                'buku' => function ($q) {
                    $q->orderBy('series_buku.urutan_baca')
                      ->limit(4)
                      ->select('buku.id', 'buku.judul', 'buku.cover', 'buku.pengarang');
                },
                // 5 judul pertama: untuk preview daftar di kartu
                'bukuPreview' => function ($q) {
                    $q->orderBy('series_buku.urutan_baca')
                      ->limit(5)
                      ->select('buku.id', 'buku.judul');
                }
            ])
            ->paginate(12);

        return view('series.index', compact('semuaSeries'));
    }

    /**
     * show()
     * Tampilkan halaman detail satu series.
     * Dicari berdasarkan slug (URL-friendly, contoh: "harry-potter").
     *
     * Menampilkan semua buku dalam series terurut berdasarkan urutan_baca,
     * beserta data pivot (urutan_baca, urutan_terbit, is_penutup).
     */
    public function show($slug)
    {
        // Cari series berdasarkan slug, 404 jika tidak ditemukan
        $series = Series::where('slug', $slug)
            ->withCount('buku')
            ->with(['buku' => function ($q) {
                // Ambil semua buku terurut sesuai urutan baca
                // withPivot = ikut sertakan data dari tabel pivot (series_buku)
                $q->orderBy('series_buku.urutan_baca')
                  ->withPivot(['urutan_baca', 'urutan_terbit', 'is_penutup']);
            }])
            ->firstOrFail();

        return view('series.show', compact('series'));
    }
}

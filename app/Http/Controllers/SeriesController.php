<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Halaman detail series - menampilkan semua buku dalam series tertentu
     * Diakses dari card series di landing page
     */
    public function show($slug)
    {
        // Ambil series berdasarkan slug, dengan semua buku terurut urutan_baca
        $series = Series::where('slug', $slug)
            ->withCount('buku')
            ->with(['buku' => function ($q) {
                $q->orderBy('series_buku.urutan_baca')
                  ->withPivot(['urutan_baca', 'urutan_terbit', 'is_penutup']);
            }])
            ->firstOrFail();

        return view('series.show', compact('series'));
    }

    /**
     * Halaman index - tampilkan semua series dalam grid
     */
    public function index()
    {
        $semuaSeries = Series::withCount('buku')
            ->having('buku_count', '>', 0)
            ->orderBy('nama_series')
            ->with([
                // Ambil 4 buku pertama untuk ditampilkan covernya di card
                'buku' => function ($q) {
                    $q->orderBy('series_buku.urutan_baca')
                      ->limit(4)
                      ->select('buku.id', 'buku.judul', 'buku.cover', 'buku.pengarang');
                },
                // Preview 5 judul untuk list
                'bukuPreview' => function ($q) {
                    $q->orderBy('series_buku.urutan_baca')
                      ->limit(5)
                      ->select('buku.id', 'buku.judul');
                }
            ])
            ->paginate(12);

        return view('series.index', compact('semuaSeries'));
    }
}

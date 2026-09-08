<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Series;
use App\Models\SeriesBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SeriesController extends Controller
{
    // ── Daftar semua series ───────────────────────────────────────────────
    public function index()
    {
        $series = Series::withCount('buku')
            ->orderBy('nama_series')
            ->paginate(10);

        return view('admin.series.index', compact('series'));
    }

    // ── Form tambah series ────────────────────────────────────────────────
    public function create()
    {
        $semuaBuku = Buku::orderBy('judul')->get(['id', 'judul', 'pengarang', 'cover']);
        return view('admin.series.create', compact('semuaBuku'));
    }

    // ── Simpan series baru ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama_series' => 'required|string|max:200|unique:series,nama_series',
            'penulis'     => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'buku_ids'    => 'nullable|array',
            'buku_ids.*'  => 'exists:buku,id',
        ]);

        $series = Series::create([
            'nama_series' => $request->nama_series,
            'penulis'     => $request->penulis,
            'deskripsi'   => $request->deskripsi,
            'slug'        => Str::slug($request->nama_series),
        ]);

        // Attach buku ke series dengan urutan_baca otomatis
        if ($request->filled('buku_ids')) {
            foreach ($request->buku_ids as $urutan => $bukuId) {
                SeriesBuku::create([
                    'series_id'    => $series->id,
                    'buku_id'      => $bukuId,
                    'urutan_baca'  => $urutan + 1,
                    'is_penutup'   => false,
                ]);
            }
        }

        return redirect()->route('admin.series.index')
            ->with('success', "Series \"{$series->nama_series}\" berhasil ditambahkan.");
    }

    // ── Form edit series ──────────────────────────────────────────────────
    public function edit(Series $series)
    {
        $series->load(['buku' => fn($q) => $q->orderBy('series_buku.urutan_baca')]);

        // Buku yang belum masuk series ini (untuk dropdown tambah buku)
        $bukuDalamSeries = $series->buku->pluck('id')->toArray();
        $bukuLainnya = Buku::orderBy('judul')
            ->whereNotIn('id', $bukuDalamSeries)
            ->get(['id', 'judul', 'pengarang', 'cover']);

        return view('admin.series.edit', compact('series', 'bukuLainnya'));
    }

    // ── Update data series ────────────────────────────────────────────────
    public function update(Request $request, Series $series)
    {
        $request->validate([
            'nama_series' => 'required|string|max:200|unique:series,nama_series,' . $series->id,
            'penulis'     => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
        ]);

        $series->update([
            'nama_series' => $request->nama_series,
            'penulis'     => $request->penulis,
            'deskripsi'   => $request->deskripsi,
            'slug'        => Str::slug($request->nama_series),
        ]);

        return redirect()->route('admin.series.edit', $series)
            ->with('success', 'Data series berhasil diperbarui.');
    }

    // ── Hapus series ──────────────────────────────────────────────────────
    public function destroy(Series $series)
    {
        $nama = $series->nama_series;
        // Hapus pivot (cascade via FK, tapi eksplisit lebih aman)
        SeriesBuku::where('series_id', $series->id)->delete();
        $series->delete();

        return redirect()->route('admin.series.index')
            ->with('success', "Series \"{$nama}\" berhasil dihapus.");
    }

    // ── Tambah buku ke series ─────────────────────────────────────────────
    public function tambahBuku(Request $request, Series $series)
    {
        $request->validate([
            'buku_id'    => 'required|exists:buku,id',
            'is_penutup' => 'nullable|boolean',
        ]);

        // Cek apakah buku sudah ada di series ini
        $sudahAda = SeriesBuku::where('series_id', $series->id)
            ->where('buku_id', $request->buku_id)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Buku ini sudah ada di series.');
        }

        // Urutan otomatis: ambil urutan_baca terbesar + 1
        $urutanMax = SeriesBuku::where('series_id', $series->id)
            ->max('urutan_baca') ?? 0;

        SeriesBuku::create([
            'series_id'   => $series->id,
            'buku_id'     => $request->buku_id,
            'urutan_baca' => $urutanMax + 1,
            'is_penutup'  => $request->boolean('is_penutup'),
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke series.');
    }

    // ── Hapus buku dari series ────────────────────────────────────────────
    public function hapusBuku(Series $series, Buku $buku)
    {
        SeriesBuku::where('series_id', $series->id)
            ->where('buku_id', $buku->id)
            ->delete();

        // Re-number urutan_baca agar tetap berurutan
        $bukuSeries = SeriesBuku::where('series_id', $series->id)
            ->orderBy('urutan_baca')
            ->get();

        foreach ($bukuSeries as $i => $pivot) {
            $pivot->update(['urutan_baca' => $i + 1]);
        }

        return back()->with('success', 'Buku berhasil dikeluarkan dari series.');
    }

    // ── Update urutan buku dalam series (via drag-drop / form) ────────────
    public function updateUrutan(Request $request, Series $series)
    {
        $request->validate([
            'urutan'   => 'required|array',
            'urutan.*' => 'exists:buku,id',
        ]);

        foreach ($request->urutan as $pos => $bukuId) {
            SeriesBuku::where('series_id', $series->id)
                ->where('buku_id', $bukuId)
                ->update(['urutan_baca' => $pos + 1]);
        }

        return back()->with('success', 'Urutan buku berhasil diperbarui.');
    }

    // ── Toggle is_penutup ─────────────────────────────────────────────────
    public function togglePenutup(Series $series, Buku $buku)
    {
        $pivot = SeriesBuku::where('series_id', $series->id)
            ->where('buku_id', $buku->id)
            ->firstOrFail();

        $pivot->update(['is_penutup' => !$pivot->is_penutup]);

        return back()->with('success', 'Status penutup berhasil diubah.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Series;
use App\Models\SeriesBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Admin\SeriesController
 * ──────────────────────────────────────────────────────────────
 * Mengelola koleksi "Series" buku perpustakaan.
 * Series = kumpulan beberapa buku yang berurutan (misal: trilogi, seri novel).
 *
 * STRUKTUR DATA:
 *   Tabel 'series'       → data seri (nama, penulis, deskripsi, slug)
 *   Tabel 'series_buku'  → pivot: buku mana saja yang masuk seri ini,
 *                          beserta urutan_baca dan is_penutup
 *
 * FITUR UTAMA:
 *   - CRUD series
 *   - Tambah/hapus buku ke dalam series
 *   - Atur urutan baca buku di dalam series (drag-drop / form)
 *   - Toggle is_penutup: tandai buku mana yang jadi penutup seri
 * ──────────────────────────────────────────────────────────────
 */
class SeriesController extends Controller
{
    /**
     * index()
     * Tampilkan daftar semua series dengan jumlah buku masing-masing.
     * Eager load buku (terurut urutan_baca) agar bisa preview di tabel.
     * Paginasi 10 series per halaman.
     */
    public function index()
    {
        $series = Series::withCount('buku')  // tambah kolom buku_count ke tiap series
            ->with(['buku' => fn($q) => $q->orderBy('series_buku.urutan_baca')])
            ->orderBy('nama_series')
            ->paginate(10)
            ->withQueryString();

        return view('admin.series.index', compact('series'));
    }

    /**
     * create()
     * Tampilkan form tambah series baru.
     * Kirim semua buku (id, judul, pengarang, cover) untuk dropdown pemilihan.
     */
    public function create()
    {
        // Ambil semua buku untuk dropdown
        $buku = Buku::orderBy('judul')->get(['id', 'judul', 'pengarang', 'cover']);
        return view('admin.series.create', compact('buku'));
    }

    /**
     * store()
     * Simpan series baru beserta buku-buku awalnya (opsional).
     *  1. Validasi data series dan daftar buku_ids
     *  2. Buat record Series dengan slug otomatis dari nama_series
     *  3. Attach setiap buku yang dipilih ke pivot series_buku
     *     dengan urutan_baca otomatis (1, 2, 3, ...)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_series' => 'required|string|max:200|unique:series,nama_series', // nama harus unik
            'penulis'     => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'buku_ids'    => 'nullable|array',
            'buku_ids.*'  => 'exists:buku,id', // setiap buku harus ada di tabel buku
        ]);

        // Buat record series, slug dibuat otomatis dari nama (untuk URL)
        $series = Series::create([
            'nama_series' => $request->nama_series,
            'penulis'     => $request->penulis,
            'deskripsi'   => $request->deskripsi,
            'slug'        => Str::slug($request->nama_series), // contoh: "harry-potter"
        ]);

        // Attach buku-buku awal jika ada yang dipilih
        if ($request->filled('buku_ids')) {
            foreach ($request->buku_ids as $urutan => $bukuId) {
                SeriesBuku::create([
                    'series_id'   => $series->id,
                    'buku_id'     => $bukuId,
                    'urutan_baca' => $urutan + 1, // urutan mulai dari 1
                    'is_penutup'  => false,        // default bukan penutup
                ]);
            }
        }

        return redirect()->route('admin.series.index', ['page' => request('page', 1)])
            ->with('success', "Series \"{$series->nama_series}\" berhasil ditambahkan.");
    }

    /**
     * edit()
     * Tampilkan form edit series.
     * Kirim:
     *  - Data series beserta buku-bukunya (terurut urutan_baca)
     *  - Daftar buku yang belum masuk series ini (untuk dropdown tambah buku baru)
     */
    public function edit(Series $series)
    {
        // Load buku dalam series ini, terurut sesuai urutan_baca
        $series->load(['buku' => fn($q) => $q->orderBy('series_buku.urutan_baca')]);

        // Daftar ID buku yang sudah ada di series ini
        $bukuDalamSeries = $series->buku->pluck('id')->toArray();

        // Semua buku untuk select dropdown
        $buku = Buku::orderBy('judul')->get(['id', 'judul', 'pengarang', 'cover']);

        return view('admin.series.edit', compact('series', 'buku'));
    }

    /**
     * update()
     * Simpan perubahan data series (nama, penulis, deskripsi).
     * Buku di dalam series dikelola via tambahBuku() / hapusBuku() / updateUrutan().
     * Slug di-regenerate dari nama_series yang baru.
     */
    public function update(Request $request, Series $series)
    {
        $request->validate([
            // unique kecuali untuk series ini sendiri
            'nama_series' => 'required|string|max:200|unique:series,nama_series,' . $series->id,
            'penulis'     => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
        ]);

        $series->update([
            'nama_series' => $request->nama_series,
            'penulis'     => $request->penulis,
            'deskripsi'   => $request->deskripsi,
            'slug'        => Str::slug($request->nama_series), // update slug jika nama berubah
        ]);

        return redirect()->route('admin.series.edit', ['series' => $series, 'page' => request('page', 1)])
            ->with('success', 'Data series berhasil diperbarui.');
    }

    /**
     * destroy()
     * Hapus series beserta semua relasi pivot-nya.
     *  1. Hapus semua record pivot series_buku dulu (lebih aman daripada cascade)
     *  2. Hapus record series
     */
    public function destroy(Series $series)
    {
        $nama = $series->nama_series;

        // Hapus pivot dulu — walau ada cascade FK, eksplisit lebih aman
        SeriesBuku::where('series_id', $series->id)->delete();
        $series->delete();

        return redirect()->route('admin.series.index', ['page' => request('page', 1)])
            ->with('success', "Series \"{$nama}\" berhasil dihapus.");
    }

    /**
     * tambahBuku()
     * Tambahkan satu buku ke dalam series.
     *  1. Cek apakah buku sudah ada di series (cegah duplikat)
     *  2. Tentukan urutan_baca otomatis (max urutan yang ada + 1)
     *  3. Insert ke pivot series_buku
     */
    public function tambahBuku(Request $request, Series $series)
    {
        $request->validate([
            'buku_id'    => 'required|exists:buku,id',
            'is_penutup' => 'nullable|boolean',
        ]);

        // Cek duplikat: buku ini sudah ada di series?
        $sudahAda = SeriesBuku::where('series_id', $series->id)
            ->where('buku_id', $request->buku_id)
            ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Buku ini sudah ada di series.');
        }

        // Urutan otomatis: ambil urutan_baca terbesar yang ada, lalu +1
        // Kalau belum ada buku sama sekali, ?? 0 membuatnya mulai dari 1
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

    /**
     * hapusBuku()
     * Hapus satu buku dari series.
     * Setelah dihapus, urutan_baca di-renumber ulang agar tetap berurutan rapat
     * (tidak ada gap: 1, 2, 4, 5 → jadi 1, 2, 3, 4).
     */
    public function hapusBuku(Series $series, Buku $buku)
    {
        // Hapus pivot buku ini dari series
        SeriesBuku::where('series_id', $series->id)
            ->where('buku_id', $buku->id)
            ->delete();

        // Re-number urutan_baca agar tidak ada gap setelah penghapusan
        $bukuSeries = SeriesBuku::where('series_id', $series->id)
            ->orderBy('urutan_baca')
            ->get();

        foreach ($bukuSeries as $i => $pivot) {
            $pivot->update(['urutan_baca' => $i + 1]); // mulai dari 1
        }

        return back()->with('success', 'Buku berhasil dikeluarkan dari series.');
    }

    /**
     * updateUrutan()
     * Simpan urutan baca buku dalam series (biasanya dipanggil setelah drag-drop di UI).
     * $request->urutan = array ID buku sesuai urutan baru [buku_id1, buku_id2, ...]
     * Posisi di array = urutan_baca baru (index 0 → urutan 1).
     */
    public function updateUrutan(Request $request, Series $series)
    {
        $request->validate([
            'urutan'   => 'required|array',
            'urutan.*' => 'exists:buku,id', // setiap ID harus valid
        ]);

        // Update urutan_baca setiap buku sesuai posisi di array
        foreach ($request->urutan as $pos => $bukuId) {
            SeriesBuku::where('series_id', $series->id)
                ->where('buku_id', $bukuId)
                ->update(['urutan_baca' => $pos + 1]);
        }

        return back()->with('success', 'Urutan buku berhasil diperbarui.');
    }

    /**
     * togglePenutup()
     * Ubah status is_penutup sebuah buku dalam series (toggle on/off).
     * is_penutup = true → tandai buku ini sebagai buku penutup / akhir series.
     * Dipakai untuk memberi penanda visual di halaman series.
     */
    public function togglePenutup(Series $series, Buku $buku)
    {
        // Ambil pivot record untuk buku ini dalam series ini
        $pivot = SeriesBuku::where('series_id', $series->id)
            ->where('buku_id', $buku->id)
            ->firstOrFail();

        // Toggle: kalau true → false, kalau false → true
        $pivot->update(['is_penutup' => !$pivot->is_penutup]);

        return back()->with('success', 'Status penutup berhasil diubah.');
    }
}

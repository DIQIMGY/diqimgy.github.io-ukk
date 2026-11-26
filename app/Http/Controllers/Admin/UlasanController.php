<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

/**
 * Admin\UlasanController
 * ──────────────────────────────────────────────────────────────
 * Menampilkan dan mengelola ulasan/rating yang diberikan siswa
 * setelah mengembalikan buku.
 *
 * Admin TIDAK bisa membuat ulasan — hanya bisa:
 *   - Melihat semua ulasan (dengan filter & statistik)
 *   - Menghapus ulasan yang tidak pantas
 * ──────────────────────────────────────────────────────────────
 */
class UlasanController extends Controller
{
    /**
     * index()
     * Tampilkan semua ulasan dengan:
     *  - Pencarian berdasarkan judul buku, nama anggota, atau isi komentar
     *  - Filter berdasarkan nilai rating (1–5 bintang)
     *  - Paginasi 15 ulasan per halaman
     *  - Statistik: total ulasan, rata-rata rating, distribusi per bintang
     */
    public function index(Request $request)
    {
        // Eager load relasi buku dan anggota (beserta usernya untuk email)
        $query = Ulasan::with(['buku', 'anggota.user']);

        // Pencarian: judul buku / nama anggota / isi komentar
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->whereHas('buku',    fn($b) => $b->where('judul', 'like', "%{$q}%"))
                   ->orWhereHas('anggota',fn($a) => $a->where('nama', 'like', "%{$q}%"))
                   ->orWhere('komentar', 'like', "%{$q}%");
            });
        }

        // Filter hanya tampilkan ulasan dengan rating tertentu
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $ulasan      = $query->latest()->paginate(15)->withQueryString();
        $totalUlasan = Ulasan::count();
        $rataRata    = round(Ulasan::avg('rating'), 1); // dibulatkan 1 desimal

        // Distribusi bintang: berapa ulasan untuk tiap nilai rating (5 s/d 1)
        $distribusi = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribusi[$i] = Ulasan::where('rating', $i)->count();
        }

        return view('admin.ulasan.index', compact('ulasan', 'totalUlasan', 'rataRata', 'distribusi'));
    }

    /**
     * destroy()
     * Hapus satu ulasan dari database.
     * Dipakai admin untuk menghapus ulasan yang tidak pantas atau spam.
     */
    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}

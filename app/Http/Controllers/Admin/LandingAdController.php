<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin\LandingAdController
 * ──────────────────────────────────────────────────────────────
 * Mengelola visual iklan / banner di halaman landing page publik.
 *
 * Setiap LandingAd = satu gambar iklan dengan:
 *   - image_path  : path file gambar di storage
 *   - sort_order  : urutan tampil (drag-drop bisa diubah)
 *   - is_active   : aktif/nonaktif (toggle tanpa hapus)
 *   - title       : judul opsional overlay
 *   - description : deskripsi opsional overlay
 *   - youtube_url : link video YouTube opsional
 * ──────────────────────────────────────────────────────────────
 */
class LandingAdController extends Controller
{
    /**
     * index()
     * Tampilkan halaman kelola iklan landing page.
     * Kirim semua iklan (terurut sort_order lalu id) dan 6 buku terbaru
     * sebagai referensi preview tampilan landing.
     */
    public function index()
    {
        // Ambil semua iklan, urut berdasarkan posisi tampil
        $ads = LandingAd::orderBy('sort_order')->orderBy('id')->get();

        // 6 buku terbaru untuk bagian preview showcase di halaman ini
        $bukuShowcase = \App\Models\Buku::latest()
            ->take(6)
            ->get(['id', 'judul', 'cover', 'pengarang', 'stok']);

        return view('admin.landing-ads.index', compact('ads', 'bukuShowcase'));
    }

    /**
     * store()
     * Upload satu atau lebih gambar iklan baru sekaligus.
     *  - Validasi: minimal 1 file, maks 5MB per gambar, format jpg/png/webp
     *  - Setiap gambar disimpan ke storage/public/landing-ads/
     *  - sort_order otomatis: iklan baru selalu di posisi terakhir
     *  - is_active default true (langsung aktif setelah upload)
     */
    public function store(Request $request)
    {
        $request->validate([
            'images'   => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120', // 5MB per file
        ]);

        // Posisi terakhir = max sort_order yang ada saat ini + 1
        $nextOrder = (int) LandingAd::max('sort_order') + 1;

        // Loop tiap file yang diupload, buat record terpisah per gambar
        foreach ($request->file('images', []) as $image) {
            LandingAd::create([
                'image_path' => $image->store('landing-ads', 'public'),
                'sort_order' => $nextOrder++, // inkrement per gambar
                'is_active'  => true,          // langsung aktif
            ]);
        }

        return back()->with('success', 'Foto iklan berhasil ditambahkan.');
    }

    /**
     * update()
     * Update detail iklan (judul, deskripsi, link YouTube, atau ganti gambar).
     *  - Semua field opsional — hanya update field yang diisi
     *  - Jika ada gambar baru, hapus gambar lama dulu sebelum simpan yang baru
     */
    public function update(Request $request, LandingAd $landingAd)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:120',
            'description' => 'nullable|string|max:1000',
            'youtube_url' => 'nullable|url|max:300',         // harus URL valid
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        // Ganti gambar jika ada file baru diunggah
        if ($request->hasFile('image')) {
            // Hapus file gambar lama dari storage agar tidak menumpuk
            Storage::disk('public')->delete($landingAd->image_path);
            $data['image_path'] = $request->file('image')->store('landing-ads', 'public');
            unset($data['image']); // hapus key 'image' karena field di DB adalah 'image_path'
        }

        $landingAd->update($data);

        return back()->with('success', 'Detail iklan berhasil disimpan.');
    }

    /**
     * toggle()
     * Aktifkan atau nonaktifkan iklan (tanpa menghapus).
     * Iklan yang nonaktif tidak akan tampil di landing page.
     */
    public function toggle(LandingAd $landingAd)
    {
        $landingAd->update(['is_active' => !$landingAd->is_active]);
        return back()->with('success', 'Status foto iklan berhasil diubah.');
    }

    /**
     * reorder()
     * Simpan urutan baru semua iklan setelah drag-drop di UI.
     * $request->order = array ID iklan sesuai urutan baru [id1, id2, id3, ...]
     * Posisi di array = sort_order baru (index 0 → posisi 1).
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:landing_ads,id', // setiap ID harus valid
        ]);

        foreach ($request->input('order') as $position => $id) {
            LandingAd::whereKey($id)->update(['sort_order' => $position + 1]);
        }

        return back()->with('success', 'Urutan foto iklan berhasil disimpan.');
    }

    /**
     * destroy()
     * Hapus iklan beserta file gambarnya dari storage.
     */
    public function destroy(LandingAd $landingAd)
    {
        // Hapus file fisik dari storage agar tidak ada file orphan
        Storage::disk('public')->delete($landingAd->image_path);
        $landingAd->delete();

        return back()->with('success', 'Foto iklan berhasil dihapus.');
    }
}

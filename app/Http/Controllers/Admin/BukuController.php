<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin\BukuController
 * ──────────────────────────────────────────────────────────────
 * Mengelola data koleksi buku perpustakaan (CRUD lengkap).
 * Fitur tambahan:
 *   - Upload / hapus cover buku
 *   - Filter & pencarian
 *   - Status launching (tersedia / segera hadir)
 * ──────────────────────────────────────────────────────────────
 */
class BukuController extends Controller
{
    /**
     * index()
     * Tampilkan daftar semua buku dengan fitur:
     *  - Pencarian berdasarkan judul, pengarang, kode buku, atau kategori
     *  - Filter berdasarkan kategori
     *  - Paginasi 30 buku per halaman
     *  - Dropdown kategori diambil dari data yang sudah ada di DB
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        // Pencarian multi-kolom: judul, pengarang, kode, kategori
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('judul',     'like', "%{$q}%")
                   ->orWhere('pengarang', 'like', "%{$q}%")
                   ->orWhere('kode_buku', 'like', "%{$q}%")
                   ->orWhere('kategori',  'like', "%{$q}%");
            });
        }

        // Filter hanya satu kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku      = $query->latest()->paginate(30)->withQueryString();
        // Ambil semua nilai kategori yang unik untuk dropdown filter
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        return view('admin.buku.index', compact('buku', 'kategoris'));
    }

    /**
     * create()
     * Tampilkan form tambah buku baru.
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * store()
     * Simpan buku baru ke database.
     *  1. Validasi semua field (termasuk validasi khusus status_launching)
     *  2. Upload cover jika ada
     *  3. Kalau status 'segera' → tanggal_rilis wajib ada
     *  4. Kalau status 'tersedia' → tanggal_rilis dikosongkan
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'        => 'required|string|unique:buku,kode_buku',          // kode unik per buku
            'judul'            => 'required|string|max:200',
            'pengarang'        => 'required|string|max:100',
            'penerbit'         => 'required|string|max:100',
            'tahun_terbit'     => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kategori'         => 'required|string|max:50',
            'stok'             => 'required|integer|min:0',
            'cover'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',     // maks 2MB
            'deskripsi'        => 'nullable|string',
            'status_launching' => 'required|in:tersedia,segera',
            'tanggal_rilis'    => 'nullable|date|after_or_equal:today',
        ]);

        // Ambil semua data kecuali cover (cover diproses terpisah)
        $data = $request->except('cover');

        // Validasi bisnis: buku "segera" wajib punya tanggal rilis
        if ($request->status_launching === 'segera' && !$request->tanggal_rilis) {
            return back()->withErrors(['tanggal_rilis' => 'Tanggal rilis harus diisi untuk buku "Segera Hadir"'])->withInput();
        }

        // Buku tersedia tidak butuh tanggal rilis — kosongkan supaya tidak ada data sampah
        if ($request->status_launching === 'tersedia') {
            $data['tanggal_rilis'] = null;
        }

        // Upload cover ke storage/public/covers/
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * edit()
     * Tampilkan form edit buku yang sudah ada.
     */
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * update()
     * Simpan perubahan data buku.
     *  1. Validasi input (kode_buku unik kecuali buku itu sendiri)
     *  2. Handle cover: kalau ada upload baru → hapus lama → simpan baru
     *  3. Logika tanggal_rilis sama seperti store()
     *  4. Redirect kembali ke halaman yang sama (pertahankan nomor halaman pagination)
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            // unique tapi kecuali ID buku ini sendiri (supaya tidak conflict saat tidak diubah)
            'kode_buku'        => 'required|string|unique:buku,kode_buku,' . $buku->id,
            'judul'            => 'required|string|max:200',
            'pengarang'        => 'required|string|max:100',
            'penerbit'         => 'required|string|max:100',
            'tahun_terbit'     => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kategori'         => 'required|string|max:50',
            'stok'             => 'required|integer|min:0',
            'cover'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi'        => 'nullable|string',
            'status_launching' => 'required|in:tersedia,segera',
            'tanggal_rilis'    => 'nullable|date|after_or_equal:today',
        ]);

        $data = $request->except('cover');

        // Validasi bisnis tanggal rilis (sama seperti store)
        if ($request->status_launching === 'segera' && !$request->tanggal_rilis) {
            return back()->withErrors(['tanggal_rilis' => 'Tanggal rilis harus diisi untuk buku "Segera Hadir"'])->withInput();
        }

        if ($request->status_launching === 'tersedia') {
            $data['tanggal_rilis'] = null;
        }

        // Ganti cover jika ada file baru diunggah
        if ($request->hasFile('cover')) {
            // Hapus file cover lama dari storage agar tidak menumpuk
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        // Kembali ke halaman pagination yang sama sebelum edit
        $page = $request->input('page', 1);
        return redirect()->route('admin.buku.index', ['page' => $page])
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * destroy()
     * Hapus buku dari database.
     *  1. Hapus file cover dari storage jika ada
     *  2. Hapus record buku
     *  3. Redirect kembali ke halaman pagination yang sama
     */
    public function destroy(Buku $buku)
    {
        // Hapus cover dari storage supaya tidak ada file orphan
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        // Pertahankan nomor halaman pagination setelah hapus
        $page = request('page', 1);
        return redirect()->route('admin.buku.index', ['page' => $page])
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * show()
     * Tampilkan halaman detail satu buku (read-only).
     */
    public function show(Buku $buku)
    {
        return view('admin.buku.show', compact('buku'));
    }
}

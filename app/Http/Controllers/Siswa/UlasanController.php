<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Siswa\UlasanController
 * ──────────────────────────────────────────────────────────────
 * Menangani pemberian ulasan/rating buku oleh siswa.
 * Ulasan hanya bisa diberikan setelah buku dikembalikan.
 * Satu peminjaman = satu ulasan (tidak bisa double).
 *
 * ALUR:
 *   Buku dikembalikan → siswa diarahkan ke form rating (create)
 *   Siswa beri bintang + komentar → store() menyimpan ulasan
 *   Atau siswa lewati → skip() redirect tanpa menyimpan ulasan
 * ──────────────────────────────────────────────────────────────
 */
class UlasanController extends Controller
{
    /**
     * create()
     * Tampilkan form rating/ulasan untuk satu peminjaman.
     *
     * Guard:
     *  - Peminjaman harus milik siswa yang login
     *  - Status peminjaman harus 'dikembalikan'
     *  - Cek apakah sudah pernah memberi ulasan untuk peminjaman ini
     */
    public function create(Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        // Pastikan peminjaman ini milik siswa yang sedang login
        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        // Hanya buku yang sudah dikembalikan yang bisa diberi ulasan
        if ($peminjaman->status !== Peminjaman::STATUS_DIKEMBALIKAN) {
            return redirect()->route('siswa.pengembalian.index')
                ->with('error', 'Hanya buku yang sudah dikembalikan yang bisa diberi ulasan.');
        }

        // Cek apakah sudah pernah beri ulasan untuk peminjaman ini
        // (kirim ke view agar bisa tampilkan pesan "sudah diulas" jika perlu)
        $sudahUlasan = Ulasan::where('peminjaman_id', $peminjaman->id)->exists();

        return view('siswa.ulasan.create', compact('peminjaman', 'sudahUlasan'));
    }

    /**
     * store()
     * Simpan ulasan/rating buku dari siswa.
     *
     * Guard:
     *  - Sama seperti create()
     *  - Cegah duplikat: satu peminjaman hanya boleh satu ulasan
     *
     * Data yang disimpan: rating (1–5), komentar (opsional),
     * dikaitkan ke peminjaman_id, buku_id, dan anggota_id.
     */
    public function store(Request $request, Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        if ($peminjaman->status !== Peminjaman::STATUS_DIKEMBALIKAN) {
            return redirect()->route('siswa.pengembalian.index')
                ->with('error', 'Hanya buku yang sudah dikembalikan yang bisa diberi ulasan.');
        }

        // Cegah duplikat ulasan untuk peminjaman yang sama
        if (Ulasan::where('peminjaman_id', $peminjaman->id)->exists()) {
            return redirect()->route('siswa.peminjaman.index')
                ->with('error', 'Kamu sudah memberikan ulasan untuk buku ini.');
        }

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ], [
            'rating.required' => 'Pilih bintang terlebih dahulu.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
            'komentar.max'    => 'Komentar maksimal 500 karakter.',
        ]);

        // Simpan ulasan — dikaitkan ke peminjaman, buku, dan anggota
        Ulasan::create([
            'peminjaman_id' => $peminjaman->id,
            'buku_id'       => $peminjaman->buku_id,   // dari relasi peminjaman
            'anggota_id'    => $anggota->id,
            'rating'        => $request->rating,
            'komentar'      => $request->komentar,      // boleh null jika tidak diisi
        ]);

        return redirect()->route('siswa.peminjaman.index')
            ->with('success', 'Terima kasih! Ulasan kamu berhasil disimpan. ⭐');
    }

    /**
     * skip()
     * Siswa memilih untuk melewati pemberian ulasan.
     * Tidak menyimpan apapun ke database — hanya redirect.
     * Tetap kasih pesan sukses pengembalian agar siswa tahu pengembaliannya berhasil.
     */
    public function skip(Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        // Pastikan yang skip adalah pemilik peminjaman ini
        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        return redirect()->route('siswa.peminjaman.index')
            ->with('success', 'Pengembalian buku berhasil.');
    }
}

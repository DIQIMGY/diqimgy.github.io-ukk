<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Siswa\PengembalianController
 * ──────────────────────────────────────────────────────────────
 * Menangani proses pengajuan pengembalian buku dari sisi siswa.
 *
 * ALUR PENGEMBALIAN (dengan approval):
 *   Siswa buka halaman → lihat buku aktif + pending_kembali
 *   Siswa klik "Kembalikan" → halaman konfirmasi (preview denda)
 *   Siswa konfirmasi → status jadi 'pending_kembali'
 *   Admin approve → status jadi 'dikembalikan', denda dihitung, stok +1
 *   Admin reject  → status kembali ke 'dipinjam' / 'terlambat'
 *
 * CATATAN:
 *   Siswa hanya bisa mengajukan — tidak langsung menyelesaikan transaksi.
 *   Penyelesaian final ada di Admin\TransaksiController::approveKembali()
 * ──────────────────────────────────────────────────────────────
 */
class PengembalianController extends Controller
{
    /**
     * index()
     * Tampilkan halaman daftar buku yang perlu dikembalikan.
     * Menampilkan:
     *  - Buku yang sedang aktif dipinjam (dipinjam / terlambat)
     *  - Buku yang sudah diajukan pengembalian tapi masih pending_kembali
     * Auto-update status 'dipinjam' → 'terlambat' jika sudah lewat batas.
     */
    public function index()
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Auto-update: kalau ada yang sudah lewat batas tapi masih 'dipinjam' → jadi 'terlambat'
        Peminjaman::where('anggota_id', $anggota->id)
            ->where('status', Peminjaman::STATUS_DIPINJAM)
            ->where('tanggal_kembali_rencana', '<', Carbon::today())
            ->update(['status' => Peminjaman::STATUS_TERLAMBAT]);

        // Ambil semua peminjaman yang perlu tindakan:
        // dipinjam, terlambat, ATAU sudah diajukan tapi belum dikonfirmasi admin
        $peminjaman = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->whereIn('status', [
                Peminjaman::STATUS_DIPINJAM,
                Peminjaman::STATUS_TERLAMBAT,
                Peminjaman::STATUS_PENDING_KEMBALI, // sudah diajukan, menunggu admin
            ])
            ->latest()
            ->paginate(10);

        // Rekomendasi buku: buku yang tersedia dan belum dipinjam siswa ini
        $bukuDipinjam = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_TERLAMBAT])
            ->pluck('buku_id');

        $recommendationSeed = Auth::id() . now()->format('Ymd');
        $rekomendasiBuku = Buku::where('stok', '>', 0)
            ->whereNotIn('id', $bukuDipinjam)
            ->get()
            ->sortBy(fn ($buku) => crc32($recommendationSeed . ':' . $buku->id))
            ->take(10)
            ->values();

        return view('siswa.pengembalian.index', compact('peminjaman', 'rekomendasiBuku'));
    }

    /**
     * konfirmasi()
     * Tampilkan halaman preview sebelum siswa mengajukan pengembalian.
     * Menampilkan detail buku + estimasi denda.
     *
     * Hanya bisa diakses jika status 'dipinjam' atau 'terlambat'.
     * Status 'pending_kembali' sudah tidak perlu konfirmasi lagi.
     */
    public function konfirmasi(Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        // Pastikan peminjaman ini milik siswa yang sedang login
        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        // Kalau sudah dikembalikan, tidak perlu proses lagi
        if ($peminjaman->status === Peminjaman::STATUS_DIKEMBALIKAN) {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        // Kalau sudah pending_kembali, berarti sudah pernah diajukan — arahkan ke index
        if ($peminjaman->status === Peminjaman::STATUS_PENDING_KEMBALI) {
            return redirect()->route('siswa.pengembalian.index')
                ->with('info', 'Pengajuan pengembalian buku ini sudah dikirim. Menunggu konfirmasi admin.');
        }

        // Hitung estimasi denda (bisa berubah saat admin konfirmasi nanti)
        $today = Carbon::today();
        $denda = 0;
        if ($today->gt($peminjaman->tanggal_kembali_rencana)) {
            $selisih = $peminjaman->tanggal_kembali_rencana->diffInDays($today);
            $denda   = $selisih * 1000;
        }

        return view('siswa.pengembalian.konfirmasi', compact('peminjaman', 'denda'));
    }

    /**
     * proses()
     * Siswa mengajukan pengembalian → status jadi 'pending_kembali'.
     *
     * Yang terjadi:
     *  1. Status berubah ke 'pending_kembali'
     *  2. return_requested_at = sekarang (catat waktu pengajuan)
     *  3. Stok TIDAK berubah (buku masih dianggap di tangan siswa)
     *  4. Denda BELUM dihitung (dihitung saat admin approve nanti)
     *
     * Admin akan konfirmasi di halaman transaksi admin.
     */
    public function proses(Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        // Cegah duplikat pengajuan
        if ($peminjaman->status === Peminjaman::STATUS_DIKEMBALIKAN) {
            return redirect()->route('siswa.pengembalian.index')
                ->with('error', 'Buku sudah dikembalikan.');
        }

        if ($peminjaman->status === Peminjaman::STATUS_PENDING_KEMBALI) {
            return redirect()->route('siswa.pengembalian.index')
                ->with('info', 'Pengajuan pengembalian sudah dikirim sebelumnya. Menunggu konfirmasi admin.');
        }

        // Hanya buku yang aktif dipinjam yang bisa diajukan kembali
        if (!in_array($peminjaman->status, [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_TERLAMBAT])) {
            return redirect()->route('siswa.pengembalian.index')
                ->with('error', 'Status peminjaman tidak valid untuk pengembalian.');
        }

        // Ubah status ke pending_kembali — menunggu konfirmasi admin
        $peminjaman->update([
            'status'               => Peminjaman::STATUS_PENDING_KEMBALI,
            'return_requested_at'  => now(), // catat waktu pengajuan
        ]);

        return redirect()->route('siswa.pengembalian.index')
            ->with('success', 'Pengajuan pengembalian buku "' . $peminjaman->buku->judul . '" berhasil dikirim. Menunggu konfirmasi dari admin.');
    }
}

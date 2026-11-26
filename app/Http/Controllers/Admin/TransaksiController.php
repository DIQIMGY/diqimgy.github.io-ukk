<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Admin\TransaksiController
 * ──────────────────────────────────────────────────────────────
 * Mengelola seluruh transaksi peminjaman buku dari sisi admin.
 *
 * ALUR PEMINJAMAN (dengan sistem approval):
 *   Siswa ajukan → status 'pending'
 *   Admin approve → status 'dipinjam', tanggal diisi, stok berkurang
 *   Admin reject  → status 'ditolak', stok tidak berubah
 *   Melewati batas → status otomatis jadi 'terlambat'
 *   Admin kembalikan → status 'dikembalikan', denda dihitung, stok bertambah
 *
 * CATATAN STOK:
 *   Stok HANYA berkurang saat approve() — BUKAN saat siswa submit.
 *   Stok bertambah lagi saat pengembalian() diproses.
 * ──────────────────────────────────────────────────────────────
 */
class TransaksiController extends Controller
{
    /**
     * index()
     * Tampilkan daftar semua transaksi peminjaman dengan:
     *  - Auto-update status 'dipinjam' → 'terlambat' jika melewati batas kembali
     *  - Pencarian berdasarkan kode, nama anggota, NIS, atau judul buku
     *  - Filter berdasarkan status transaksi
     *  - Paginasi 10 data per halaman
     *  - 6 angka statistik: total, pending, dipinjam, terlambat, kembali, ditolak
     */
    public function index(Request $request)
    {
        // ── Auto-update status terlambat ─────────────────────────
        // Jalankan setiap kali halaman ini dibuka agar status selalu akurat.
        // Hanya proses yang sudah diapprove (status 'dipinjam') dan lewat batas.
        Peminjaman::where('status', Peminjaman::STATUS_DIPINJAM)
            ->where('tanggal_kembali_rencana', '<', Carbon::today())
            ->update(['status' => Peminjaman::STATUS_TERLAMBAT]);

        // ── Query dasar dengan relasi ────────────────────────────
        $query = Peminjaman::with(['anggota', 'buku']);

        // Pencarian: kode transaksi / nama+NIS anggota / judul buku
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('kode_pinjam', 'like', "%{$q}%")
                   ->orWhereHas('anggota', fn($a) => $a->where('nama', 'like', "%{$q}%")
                                                        ->orWhere('nis', 'like', "%{$q}%"))
                   ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%{$q}%"));
            });
        }

        // Filters on this page are for browsing history only; action queues stay on the dashboard.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->input('denda') === 'belum_lunas') {
            $query->where('status', Peminjaman::STATUS_DIKEMBALIKAN)
                ->where('denda', '>', 0)
                ->where('denda_dibayar', false);
        }

        $transaksi = $query->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        if ($transaksi->currentPage() > $transaksi->lastPage()) {
            return redirect()->to($transaksi->url($transaksi->lastPage()));
        }

        // ── Statistik ringkas ────────────────────────────────────
        $statTotal         = Peminjaman::count();
        $statPending       = Peminjaman::where('status', Peminjaman::STATUS_PENDING)->count();
        $statDipinjam      = Peminjaman::where('status', Peminjaman::STATUS_DIPINJAM)->count();
        $statTerlambat     = Peminjaman::where('status', Peminjaman::STATUS_TERLAMBAT)->count();
        $statPendingKembali= Peminjaman::where('status', Peminjaman::STATUS_PENDING_KEMBALI)->count();
        $statKembali       = Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)->count();
        $statDitolak       = Peminjaman::where('status', Peminjaman::STATUS_DITOLAK)->count();
        $statDendaBelumLunas = Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)
            ->where('denda', '>', 0)
            ->where('denda_dibayar', false)
            ->count();

        return view('admin.transaksi.index', compact(
            'transaksi',
            'statTotal', 'statPending', 'statDipinjam',
            'statTerlambat', 'statPendingKembali', 'statKembali', 'statDitolak',
            'statDendaBelumLunas'
        ));
    }

    /**
     * create()
     * Tampilkan form tambah transaksi baru (khusus admin — langsung bypass approval).
     * Hanya tampilkan anggota aktif dan buku yang masih ada stok.
     */
    public function create()
    {
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku    = Buku::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('anggota', 'buku'));
    }

    /**
     * store()
     * Admin membuat transaksi langsung → langsung berstatus 'dipinjam' (bypass approval).
     * Dipakai saat admin ingin input transaksi manual (misal: peminjaman luar sistem).
     *  1. Validasi input termasuk tanggal
     *  2. Cek stok dan apakah anggota sudah meminjam buku yang sama
     *  3. Buat transaksi dengan status langsung 'dipinjam'
     *  4. Kurangi stok buku
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'              => 'required|exists:anggota,id',
            'buku_id'                 => 'required|exists:buku,id',
            'tanggal_pinjam'          => 'required|date',
            // tanggal kembali tidak boleh sebelum tanggal pinjam
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < 1) {
            return back()->withErrors(['buku_id' => 'Stok buku tidak tersedia.'])->withInput();
        }

        // Cegah anggota meminjam buku yang sama saat masih dipinjam/terlambat
        $sudahPinjam = Peminjaman::where('anggota_id', $request->anggota_id)
            ->where('buku_id', $request->buku_id)
            ->whereIn('status', [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_TERLAMBAT])
            ->exists();

        if ($sudahPinjam) {
            return back()->withErrors(['buku_id' => 'Anggota masih meminjam buku ini.'])->withInput();
        }

        $kode = 'TRX-' . strtoupper(uniqid());

        // Admin input langsung → langsung dipinjam, set approved_at sekarang
        Peminjaman::create([
            'kode_pinjam'             => $kode,
            'anggota_id'              => $request->anggota_id,
            'buku_id'                 => $request->buku_id,
            'tanggal_pengajuan'       => $request->tanggal_pinjam,   // samakan dengan tanggal pinjam
            'tanggal_pinjam'          => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status'                  => Peminjaman::STATUS_DIPINJAM, // langsung aktif
            'approved_at'             => now(),                       // langsung dianggap approved
        ]);

        // Kurangi stok karena buku langsung keluar
        $buku->decrement('stok');

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi peminjaman berhasil dibuat.');
    }

    /**
     * show()
     * Tampilkan detail satu transaksi peminjaman (halaman read-detail).
     * Muat relasi anggota & buku agar view bisa akses tanpa query tambahan.
     */
    public function show(Peminjaman $transaksi)
    {
        $transaksi->load(['anggota', 'buku']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * edit()
     * Tampilkan form edit transaksi.
     * Yang bisa diubah admin: tanggal_kembali_rencana & keterangan saja.
     */
    public function edit(Peminjaman $transaksi)
    {
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku    = Buku::all();
        return view('admin.transaksi.edit', compact('transaksi', 'anggota', 'buku'));
    }

    /**
     * update()
     * Simpan perubahan pada transaksi.
     * Admin hanya boleh mengubah batas tanggal kembali dan keterangan.
     */
    public function update(Request $request, Peminjaman $transaksi)
    {
        $request->validate([
            'tanggal_kembali_rencana' => 'required|date',
            'keterangan'              => 'nullable|string',
        ]);

        $transaksi->update([
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'keterangan'              => $request->keterangan,
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * approve()
     * Setujui pengajuan peminjaman siswa (pending → dipinjam).
     *
     * Yang terjadi saat approve:
     *  1. Status berubah ke 'dipinjam'
     *  2. tanggal_pinjam  = hari ini
     *  3. tanggal_kembali = hari ini + 7 hari
     *  4. approved_at     = timestamp sekarang
     *  5. Stok buku berkurang 1
     *
     * Hitungan hari dan denda mulai berjalan dari sini.
     * Kalau stok habis, approve TIDAK bisa dilakukan.
     */
    public function approve(Peminjaman $transaksi)
    {
        // Hanya peminjaman berstatus 'pending' yang bisa disetujui
        if ($transaksi->status !== Peminjaman::STATUS_PENDING) {
            return back()->with('error', 'Hanya pengajuan dengan status menunggu yang bisa disetujui.');
        }

        $buku = $transaksi->buku;

        // Pastikan stok masih ada sebelum approve
        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku tidak tersedia. Tidak dapat menyetujui pengajuan ini.');
        }

        $tanggalPinjam  = Carbon::today();
        $tanggalKembali = $tanggalPinjam->copy()->addDays(7); // batas kembali = 7 hari dari hari ini

        $transaksi->update([
            'status'                  => Peminjaman::STATUS_DIPINJAM,
            'tanggal_pinjam'          => $tanggalPinjam,
            'tanggal_kembali_rencana' => $tanggalKembali,
            'approved_at'             => now(),
        ]);

        // Stok baru berkurang setelah disetujui — bukan saat siswa mengajukan
        $buku->decrement('stok');

        return back()->with('success',
            'Pengajuan peminjaman "' . $buku->judul . '" oleh ' . $transaksi->anggota->nama . ' telah disetujui.'
        );
    }

    /**
     * reject()
     * Tolak pengajuan peminjaman siswa (pending → ditolak).
     *
     * Yang terjadi saat reject:
     *  1. Status berubah ke 'ditolak'
     *  2. rejected_at       = timestamp sekarang
     *  3. rejection_reason  = alasan yang diisi admin (opsional)
     *  4. Stok buku TIDAK berubah (karena belum pernah dikurangi)
     *
     * Alasan penolakan akan ditampilkan ke siswa di halaman peminjaman.
     */
    public function reject(Request $request, Peminjaman $transaksi)
    {
        // Hanya peminjaman berstatus 'pending' yang bisa ditolak
        if ($transaksi->status !== Peminjaman::STATUS_PENDING) {
            return back()->with('error', 'Hanya pengajuan dengan status menunggu yang bisa ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $transaksi->update([
            'status'           => Peminjaman::STATUS_DITOLAK,
            'rejected_at'      => now(),
            'rejection_reason' => $request->rejection_reason, // boleh kosong
        ]);

        return back()->with('success',
            'Pengajuan peminjaman "' . $transaksi->buku->judul . '" oleh ' . $transaksi->anggota->nama . ' telah ditolak.'
        );
    }

    /**
     * approveKembali()
     * Admin mengkonfirmasi pengembalian buku (pending_kembali → dikembalikan).
     *
     * Yang terjadi:
     *  1. Hitung denda final sampai tanggal siswa mengajukan pengembalian
     *  2. tanggal_kembali_aktual = tanggal pengajuan (admin tidak menambah denda saat menunggu)
     *  3. Status berubah ke 'dikembalikan'
     *  4. Stok buku bertambah 1 (buku sudah kembali ke rak)
     *
     * Jika tanggal pengajuan tidak tersedia (data lama), gunakan hari admin konfirmasi.
     */
    public function approveKembali(Peminjaman $transaksi)
    {
        // Hanya bisa approve jika status pending_kembali
        if ($transaksi->status !== Peminjaman::STATUS_PENDING_KEMBALI) {
            return back()->with('error', 'Hanya pengajuan pengembalian yang menunggu konfirmasi yang bisa disetujui.');
        }

        $tanggalKembali = $transaksi->return_requested_at
            ? Carbon::parse($transaksi->return_requested_at)->startOfDay()
            : Carbon::today();
        $denda          = 0;

        // Hitung denda: selisih hari dari batas kembali ke hari ini × Rp 1.000
        if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
            $selisih = $transaksi->tanggal_kembali_rencana->diffInDays($tanggalKembali);
            $denda   = $selisih * 1000;
        }

        $transaksi->update([
            'tanggal_kembali_aktual' => $tanggalKembali,
            'status'                 => Peminjaman::STATUS_DIKEMBALIKAN,
            'denda'                  => $denda,
        ]);

        // Stok bertambah — buku sudah resmi kembali ke rak perpustakaan
        $transaksi->buku->increment('stok');

        $msg = 'Pengembalian buku "' . $transaksi->buku->judul . '" oleh ' . $transaksi->anggota->nama . ' berhasil dikonfirmasi.';
        if ($denda > 0) {
            $msg .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $msg);
    }

    /**
     * rejectKembali()
     * Admin menolak pengajuan pengembalian (pending_kembali → kembali ke dipinjam/terlambat).
     *
     * Yang terjadi:
     *  1. Cek apakah batas kembali sudah terlewat → status kembali ke 'terlambat'
     *     Jika belum terlewat → status kembali ke 'dipinjam'
     *  2. return_requested_at dikosongkan (pengajuan dibatalkan)
     *  3. Stok TIDAK berubah (buku masih dianggap di tangan siswa)
     *
     * Pakai saat: buku belum benar-benar diserahkan, atau kondisi buku perlu dicek dulu.
     */
    public function rejectKembali(Peminjaman $transaksi)
    {
        if ($transaksi->status !== Peminjaman::STATUS_PENDING_KEMBALI) {
            return back()->with('error', 'Hanya pengajuan pengembalian yang menunggu konfirmasi yang bisa ditolak.');
        }

        // Tentukan status yang tepat: terlambat jika sudah lewat batas, dipinjam jika belum
        $statusKembali = Carbon::today()->gt($transaksi->tanggal_kembali_rencana)
            ? Peminjaman::STATUS_TERLAMBAT
            : Peminjaman::STATUS_DIPINJAM;

        $transaksi->update([
            'status'              => $statusKembali,
            'return_requested_at' => null, // reset pengajuan agar siswa bisa ajukan ulang
        ]);

        return back()->with('success',
            'Pengajuan pengembalian "' . $transaksi->buku->judul . '" ditolak. Status kembali ke "' . $transaksi->fresh()->statusLabel() . '".'
        );
    }

    /**
     * pengembalian()
     * Proses pengembalian buku oleh admin.
     *
     * Yang terjadi:
     *  1. Hitung denda jika terlambat (Rp 1.000 per hari)
     *  2. Status berubah ke 'dikembalikan'
     *  3. tanggal_kembali_aktual = hari ini
     *  4. Stok buku bertambah 1 kembali
     *
     * Hanya bisa diproses jika buku sedang aktif dipinjam (dipinjam / terlambat).
     */
    public function pengembalian(Peminjaman $transaksi)
    {
        // Cegah proses pengembalian ganda
        if ($transaksi->status === Peminjaman::STATUS_DIKEMBALIKAN) {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        // Hanya buku yang aktif dipinjam yang bisa dikembalikan
        // isAktif() = dipinjam / terlambat / pending_kembali
        if (!$transaksi->isAktif()) {
            return back()->with('error', 'Hanya peminjaman yang sedang aktif yang bisa diproses pengembaliannya.');
        }

        $tanggalKembali = Carbon::today();
        $denda          = 0;

        // Hitung denda: selisih hari × Rp 1.000, jika dikembalikan melebihi batas
        if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
            $selisih = $transaksi->tanggal_kembali_rencana->diffInDays($tanggalKembali);
            $denda   = $selisih * 1000;
        }

        $transaksi->update([
            'tanggal_kembali_aktual' => $tanggalKembali,
            'status'                 => Peminjaman::STATUS_DIKEMBALIKAN,
            'denda'                  => $denda,
        ]);

        // Kembalikan stok buku karena buku sudah kembali ke rak
        $transaksi->buku->increment('stok');

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Pengembalian berhasil. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    /**
     * tandaiDendaDibayar()
     * Tandai denda transaksi ini sudah dibayar oleh siswa.
     *  - denda_dibayar     = true
     *  - denda_dibayar_at  = waktu pembayaran dicatat
     *
     * Hanya bisa ditandai jika memang ada denda dan belum dibayar.
     */
    public function tandaiDendaDibayar(Peminjaman $transaksi)
    {
        if ($transaksi->status !== Peminjaman::STATUS_DIKEMBALIKAN) {
            return back()->with('error', 'Pembayaran denda hanya dapat dicatat setelah pengembalian dikonfirmasi.');
        }

        // Guard: tidak ada denda
        if ($transaksi->denda <= 0) {
            return back()->with('error', 'Transaksi ini tidak memiliki denda yang perlu dibayar.');
        }

        // Guard: denda sudah pernah ditandai lunas
        if ($transaksi->denda_dibayar) {
            return back()->with('error', 'Denda transaksi ini sudah ditandai lunas.');
        }

        $transaksi->update([
            'denda_dibayar'    => true,
            'denda_dibayar_at' => now(),
        ]);

        return back()->with('success',
            'Denda Rp ' . number_format($transaksi->denda, 0, ',', '.') . ' berhasil ditandai lunas.'
        );
    }

    /**
     * destroy()
     * Hapus transaksi peminjaman dari database.
     *
     * PENTING — logika stok:
     *  - Kalau status 'dipinjam' atau 'terlambat' (sudah diapprove, buku belum kembali)
     *    → stok dikembalikan dulu sebelum hapus
     *  - Kalau status 'pending' atau 'ditolak'
     *    → stok tidak perlu dikembalikan (belum pernah dikurangi)
     */
    public function destroy(Peminjaman $transaksi)
    {
        // isAktif() = status dipinjam ATAU terlambat
        if ($transaksi->isAktif()) {
            // Kembalikan stok karena buku dianggap kembali ke rak
            $transaksi->buku->increment('stok');
        }

        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

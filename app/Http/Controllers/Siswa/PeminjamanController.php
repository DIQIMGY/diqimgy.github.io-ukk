<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data anggota tidak ditemukan.');
        }

        // Update status terlambat — hanya peminjaman yang sudah disetujui
        Peminjaman::where('anggota_id', $anggota->id)
            ->where('status', Peminjaman::STATUS_DIPINJAM)
            ->where('tanggal_kembali_rencana', '<', Carbon::today())
            ->update(['status' => Peminjaman::STATUS_TERLAMBAT]);

        $query = Peminjaman::with(['buku', 'ulasan'])->where('anggota_id', $anggota->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(10)->withQueryString();

        // Buku yang sedang aktif dipinjam (exclude dari rekomendasi)
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

        $riwayatUlasan = \App\Models\Ulasan::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->get();

        return view('siswa.peminjaman.index', compact('peminjaman', 'rekomendasiBuku', 'riwayatUlasan'));
    }

    public function create(Request $request)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota || $anggota->status !== 'aktif') {
            return redirect()->route('siswa.dashboard')->with('error', 'Akun anggota Anda tidak aktif.');
        }

        $search = $request->get('search', '');
        $query  = Buku::where('stok', '>', 0);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $buku = $query->paginate(30)->withQueryString();

        return view('siswa.peminjaman.create', compact('buku', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        $anggota = Auth::user()->anggota;

        if (!$anggota || $anggota->status !== 'aktif') {
            return back()->with('error', 'Akun Anda tidak aktif.');
        }

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < 1) {
            return back()->with('error', 'Stok buku tidak tersedia saat ini.');
        }

        // Cek apakah ada peminjaman aktif atau pending untuk buku yang sama
        $sudahAdaRequest = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', [
                Peminjaman::STATUS_PENDING,
                Peminjaman::STATUS_DIPINJAM,
                Peminjaman::STATUS_TERLAMBAT,
            ])
            ->exists();

        if ($sudahAdaRequest) {
            return back()->with('error', 'Anda sudah memiliki pengajuan atau sedang meminjam buku ini.');
        }

        $kode = 'TRX-' . strtoupper(uniqid());

        // Simpan dengan status pending — TIDAK mengurangi stok dulu
        // Stok akan berkurang hanya setelah admin menyetujui
        Peminjaman::create([
            'kode_pinjam'      => $kode,
            'anggota_id'       => $anggota->id,
            'buku_id'          => $buku->id,
            'tanggal_pengajuan'=> Carbon::today(),
            'tanggal_pinjam'   => null, // diisi saat admin approve
            'tanggal_kembali_rencana' => null, // diisi saat admin approve
            'status'           => Peminjaman::STATUS_PENDING,
        ]);

        return redirect()
            ->route('siswa.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman buku "' . $buku->judul . '" berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function detail(Buku $buku)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota || $anggota->status !== 'aktif') {
            return redirect()->route('siswa.dashboard')->with('error', 'Akun anggota Anda tidak aktif.');
        }

        $bukuDipinjam = Peminjaman::where('anggota_id', $anggota->id)
            ->whereIn('status', [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_TERLAMBAT])
            ->pluck('buku_id');

        $recommendationSeed = Auth::id() . now()->format('Ymd');
        $rekomendasiBuku = Buku::where('stok', '>', 0)
            ->where('id', '!=', $buku->id)
            ->whereNotIn('id', $bukuDipinjam)
            ->get()
            ->sortBy(fn ($item) => crc32($recommendationSeed . ':' . $item->id))
            ->take(4)
            ->values();

        $bukuTerbaru = Buku::where('id', '!=', $buku->id)
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('siswa.peminjaman.detail', compact('buku', 'rekomendasiBuku', 'bukuTerbaru'));
    }

    public function show(Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        return view('siswa.peminjaman.show', compact('peminjaman'));
    }
}

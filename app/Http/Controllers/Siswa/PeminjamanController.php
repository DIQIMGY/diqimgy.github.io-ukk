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

        // Update status terlambat
        Peminjaman::where('anggota_id', $anggota->id)
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali_rencana', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

        $query = Peminjaman::with('buku')->where('anggota_id', $anggota->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(10)->withQueryString();

        return view('siswa.peminjaman.index', compact('peminjaman'));
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

        $buku = $query->paginate(9)->withQueryString();

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

        $sudahPinjam = Peminjaman::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Anda masih meminjam buku ini.');
        }

        $kode = 'TRX-' . strtoupper(uniqid());

        Peminjaman::create([
            'kode_pinjam'             => $kode,
            'anggota_id'              => $anggota->id,
            'buku_id'                 => $buku->id,
            'tanggal_pinjam'          => Carbon::today(),
            'tanggal_kembali_rencana' => Carbon::today()->addDays(7),
            'status'                  => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('siswa.peminjaman.index')->with('success', 'Peminjaman buku "' . $buku->judul . '" berhasil. Harap kembalikan dalam 7 hari.');
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

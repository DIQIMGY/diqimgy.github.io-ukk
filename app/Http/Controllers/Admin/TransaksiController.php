<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('kode_pinjam', 'like', "%{$q}%")
                   ->orWhereHas('anggota', fn($a) => $a->where('nama', 'like', "%{$q}%")->orWhere('nis', 'like', "%{$q}%"))
                   ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%{$q}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Update status terlambat otomatis
        Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali_rencana', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

        $transaksi = $query->latest()->paginate(10)->withQueryString();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku    = Buku::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'              => 'required|exists:anggota,id',
            'buku_id'                 => 'required|exists:buku,id',
            'tanggal_pinjam'          => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < 1) {
            return back()->withErrors(['buku_id' => 'Stok buku tidak tersedia.'])->withInput();
        }

        // Cek apakah anggota masih meminjam buku yang sama
        $sudahPinjam = Peminjaman::where('anggota_id', $request->anggota_id)
            ->where('buku_id', $request->buku_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sudahPinjam) {
            return back()->withErrors(['buku_id' => 'Anggota masih meminjam buku ini.'])->withInput();
        }

        $kode = 'TRX-' . strtoupper(uniqid());

        Peminjaman::create([
            'kode_pinjam'             => $kode,
            'anggota_id'              => $request->anggota_id,
            'buku_id'                 => $request->buku_id,
            'tanggal_pinjam'          => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status'                  => 'dipinjam',
        ]);

        // Kurangi stok
        $buku->decrement('stok');

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi peminjaman berhasil dibuat.');
    }

    public function show(Peminjaman $transaksi)
    {
        $transaksi->load(['anggota', 'buku']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    public function edit(Peminjaman $transaksi)
    {
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku    = Buku::all();
        return view('admin.transaksi.edit', compact('transaksi', 'anggota', 'buku'));
    }

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

    public function pengembalian(Peminjaman $transaksi)
    {
        if ($transaksi->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $tanggalKembali = Carbon::today();
        $denda          = 0;

        if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
            $selisih = $transaksi->tanggal_kembali_rencana->diffInDays($tanggalKembali);
            $denda   = $selisih * 1000;
        }

        $transaksi->update([
            'tanggal_kembali_aktual' => $tanggalKembali,
            'status'                 => 'dikembalikan',
            'denda'                  => $denda,
        ]);

        // Tambah stok kembali
        $transaksi->buku->increment('stok');

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Pengembalian berhasil. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    public function destroy(Peminjaman $transaksi)
    {
        // Kembalikan stok jika belum dikembalikan
        if (in_array($transaksi->status, ['dipinjam', 'terlambat'])) {
            $transaksi->buku->increment('stok');
        }
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

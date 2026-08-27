<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index()
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

        $peminjaman = Peminjaman::with('buku')
            ->where('anggota_id', $anggota->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()
            ->paginate(10);

        return view('siswa.pengembalian.index', compact('peminjaman'));
    }

    public function konfirmasi(Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        // Hitung denda
        $today = Carbon::today();
        $denda = 0;
        if ($today->gt($peminjaman->tanggal_kembali_rencana)) {
            $selisih = $peminjaman->tanggal_kembali_rencana->diffInDays($today);
            $denda   = $selisih * 1000;
        }

        return view('siswa.pengembalian.konfirmasi', compact('peminjaman', 'denda'));
    }

    public function proses(Peminjaman $peminjaman)
    {
        $anggota = Auth::user()->anggota;

        if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
            abort(403);
        }

        if ($peminjaman->status === 'dikembalikan') {
            return redirect()->route('siswa.pengembalian.index')->with('error', 'Buku sudah dikembalikan.');
        }

        $today = Carbon::today();
        $denda = 0;
        if ($today->gt($peminjaman->tanggal_kembali_rencana)) {
            $selisih = $peminjaman->tanggal_kembali_rencana->diffInDays($today);
            $denda   = $selisih * 1000;
        }

        $peminjaman->update([
            'tanggal_kembali_aktual' => $today,
            'status'                 => 'dikembalikan',
            'denda'                  => $denda,
        ]);

        $peminjaman->buku->increment('stok');

        $msg = 'Pengembalian buku berhasil diajukan.';
        if ($denda > 0) {
            $msg .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->route('siswa.pengembalian.index')->with('success', $msg);
    }
}

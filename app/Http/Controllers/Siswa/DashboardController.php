<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $anggota = Auth::user()->anggota;

        $totalPinjam  = 0;
        $totalKembali = 0;
        $totalDenda   = 0;
        $riwayat      = collect();

        if ($anggota) {
            // Update status terlambat
            Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', 'dipinjam')
                ->where('tanggal_kembali_rencana', '<', Carbon::today())
                ->update(['status' => 'terlambat']);

            $totalPinjam  = Peminjaman::where('anggota_id', $anggota->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])->count();
            $totalKembali = Peminjaman::where('anggota_id', $anggota->id)
                ->where('status', 'dikembalikan')->count();
            $totalDenda   = Peminjaman::where('anggota_id', $anggota->id)->sum('denda');

            $riwayat = Peminjaman::with('buku')
                ->where('anggota_id', $anggota->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // Buku terpopuler global (semua siswa bisa lihat)
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(6)
            ->get();

        return view('siswa.dashboard', compact(
            'anggota',
            'totalPinjam',
            'totalKembali',
            'totalDenda',
            'riwayat',
            'bukuPopuler'
        ));
    }
}

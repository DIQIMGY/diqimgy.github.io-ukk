<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * SiswaMiddleware
 * ──────────────────────────────────────────────────────────────
 * Melindungi semua route di prefix /siswa agar hanya bisa
 * diakses oleh user yang sudah login DAN memiliki role 'siswa'.
 *
 * Dipasang di routes/web.php:
 *   Route::middleware(['auth', 'siswa'])->group(...)
 *
 * ALUR:
 *   1. Cek apakah user sudah login (auth()->check())
 *   2. Cek apakah role-nya siswa (isSiswa() di Model User)
 *   3. Kalau salah satu tidak terpenuhi → abort 403
 *   4. Kalau lolos → lanjutkan ke request berikutnya
 *
 * CATATAN:
 *   Middleware 'auth' di depannya sudah memastikan user login,
 *   tapi double-check di sini lebih aman untuk menghindari
 *   admin yang nyasar ke halaman siswa.
 * ──────────────────────────────────────────────────────────────
 */
class SiswaMiddleware
{
    /**
     * handle()
     * Eksekusi middleware setiap ada request masuk ke route siswa.
     *
     * @param Request  $request  — request yang masuk
     * @param Closure  $next     — fungsi untuk lanjut ke handler berikutnya
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Tolak jika belum login atau bukan siswa
        if (!auth()->check() || !auth()->user()->isSiswa()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Siswa.');
        }

        // Blokir siswa yang anggotanya masih pending (belum disetujui admin)
        $anggota = auth()->user()->anggota;
        if ($anggota && $anggota->status === 'pending') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('warning', 'Akun kamu masih menunggu persetujuan admin. Silakan coba lagi setelah disetujui.');
        }

        // Lolos — lanjutkan ke controller
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AdminMiddleware
 * ──────────────────────────────────────────────────────────────
 * Melindungi semua route di prefix /admin agar hanya bisa
 * diakses oleh user yang sudah login DAN memiliki role 'admin'.
 *
 * Dipasang di routes/web.php:
 *   Route::middleware(['auth', 'admin'])->group(...)
 *
 * ALUR:
 *   1. Cek apakah user sudah login (auth()->check())
 *   2. Cek apakah role-nya admin (isAdmin() di Model User)
 *   3. Kalau salah satu tidak terpenuhi → abort 403
 *   4. Kalau lolos → lanjutkan ke request berikutnya
 * ──────────────────────────────────────────────────────────────
 */
class AdminMiddleware
{
    /**
     * handle()
     * Eksekusi middleware setiap ada request masuk ke route admin.
     *
     * @param Request  $request  — request yang masuk
     * @param Closure  $next     — fungsi untuk lanjut ke handler berikutnya
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Tolak jika belum login atau bukan admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin.');
        }

        // Lolos — lanjutkan ke controller
        return $next($request);
    }
}

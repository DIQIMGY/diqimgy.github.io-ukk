<?php

namespace App\Providers;

use App\Models\Peminjaman;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view): void {
            $adminPendingReturnCount = 0;
            $adminUnpaidFineCount = 0;
            $adminPendingSiswaCount = 0;

            if (auth()->check() && auth()->user()->isAdmin()) {
                $adminPendingReturnCount = Peminjaman::where(
                    'status',
                    Peminjaman::STATUS_PENDING_KEMBALI
                )->count();
                $adminUnpaidFineCount = Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)
                    ->where('denda', '>', 0)
                    ->where('denda_dibayar', false)
                    ->count();
                $adminPendingSiswaCount = \App\Models\Anggota::where('status', 'pending')->count();
            }

            $view->with(compact('adminPendingReturnCount', 'adminUnpaidFineCount', 'adminPendingSiswaCount'));
        });
    }
}

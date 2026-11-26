<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Siswa;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

// ── Landing Page ──────────────────────────────────────────────────────────────
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/buku', [LandingController::class, 'allBooks'])->name('buku.all');
Route::get('/ulasan', [LandingController::class, 'allUlasan'])->name('ulasan.all');

// ── Series ────────────────────────────────────────────────────────────────────
Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
Route::get('/series/{slug}', [SeriesController::class, 'show'])->name('series.show');

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Admin ─────────────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Buku
    Route::resource('buku', Admin\BukuController::class);

    // Anggota — pakai singular route model binding "anggotum" karena tabel "anggota"
    Route::get('/anggota',              [Admin\AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create',       [Admin\AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota',             [Admin\AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{anggotum}',   [Admin\AnggotaController::class, 'show'])->name('anggota.show');
    Route::get('/anggota/{anggotum}/edit',   [Admin\AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{anggotum}',   [Admin\AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggotum}',[Admin\AnggotaController::class, 'destroy'])->name('anggota.destroy');
    
    // Admin Management
    Route::get('/admin/{user}/edit',    [Admin\AnggotaController::class, 'editAdmin'])->name('admin.edit');
    Route::put('/admin/{user}',         [Admin\AnggotaController::class, 'updateAdmin'])->name('admin.update');
    Route::delete('/admin/{user}',      [Admin\AnggotaController::class, 'destroyAdmin'])->name('admin.destroy');

    // Persetujuan Siswa
    Route::get('/anggota-pending',               [Admin\AnggotaController::class, 'pendingSiswa'])->name('anggota.pending');
    Route::post('/anggota/{anggotum}/approve',   [Admin\AnggotaController::class, 'approveSiswa'])->name('anggota.approve');
    Route::post('/anggota/{anggotum}/reject',    [Admin\AnggotaController::class, 'rejectSiswa'])->name('anggota.reject');

    // Transaksi
    Route::get('/transaksi',                        [Admin\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create',                 [Admin\TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',                       [Admin\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}',            [Admin\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/edit',       [Admin\TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}',            [Admin\TransaksiController::class, 'update'])->name('transaksi.update');
    Route::post('/transaksi/{transaksi}/kembali',         [Admin\TransaksiController::class, 'pengembalian'])->name('transaksi.kembali');
    Route::post('/transaksi/{transaksi}/approve',         [Admin\TransaksiController::class, 'approve'])->name('transaksi.approve');
    Route::post('/transaksi/{transaksi}/reject',          [Admin\TransaksiController::class, 'reject'])->name('transaksi.reject');
    Route::post('/transaksi/{transaksi}/approve-kembali', [Admin\TransaksiController::class, 'approveKembali'])->name('transaksi.approve-kembali');
    Route::post('/transaksi/{transaksi}/reject-kembali',  [Admin\TransaksiController::class, 'rejectKembali'])->name('transaksi.reject-kembali');
    Route::post('/transaksi/{transaksi}/denda/lunas',     [Admin\TransaksiController::class, 'tandaiDendaDibayar'])->name('transaksi.denda.lunas');
    Route::delete('/transaksi/{transaksi}',         [Admin\TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    // Series
    Route::get('/series',                                        [Admin\SeriesController::class, 'index'])->name('series.index');
    Route::get('/series/create',                                 [Admin\SeriesController::class, 'create'])->name('series.create');
    Route::post('/series',                                       [Admin\SeriesController::class, 'store'])->name('series.store');
    Route::get('/series/{series}/edit',                          [Admin\SeriesController::class, 'edit'])->name('series.edit');
    Route::put('/series/{series}',                               [Admin\SeriesController::class, 'update'])->name('series.update');
    Route::delete('/series/{series}',                            [Admin\SeriesController::class, 'destroy'])->name('series.destroy');
    Route::post('/series/{series}/buku',                         [Admin\SeriesController::class, 'tambahBuku'])->name('series.buku.tambah');
    Route::delete('/series/{series}/buku/{buku}',                [Admin\SeriesController::class, 'hapusBuku'])->name('series.buku.hapus');
    Route::post('/series/{series}/urutan',                       [Admin\SeriesController::class, 'updateUrutan'])->name('series.urutan');
    Route::post('/series/{series}/buku/{buku}/penutup',          [Admin\SeriesController::class, 'togglePenutup'])->name('series.buku.penutup');

    // Visual Ads landing page
    Route::get('/landing-ads',                         [Admin\LandingAdController::class, 'index'])->name('landing-ads.index');
    Route::post('/landing-ads',                        [Admin\LandingAdController::class, 'store'])->name('landing-ads.store');
    Route::post('/landing-ads/reorder',                [Admin\LandingAdController::class, 'reorder'])->name('landing-ads.reorder');
    Route::post('/landing-ads/{landingAd}/toggle',     [Admin\LandingAdController::class, 'toggle'])->name('landing-ads.toggle');
    Route::post('/landing-ads/{landingAd}/update',     [Admin\LandingAdController::class, 'update'])->name('landing-ads.update');
    Route::delete('/landing-ads/{landingAd}',           [Admin\LandingAdController::class, 'destroy'])->name('landing-ads.destroy');

    // Ulasan
    Route::get('/ulasan', [Admin\UlasanController::class, 'index'])->name('ulasan.index');
    Route::delete('/ulasan/{ulasan}', [Admin\UlasanController::class, 'destroy'])->name('ulasan.destroy');
});

// ── Siswa ─────────────────────────────────────────────────────────────────────
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'siswa'])->group(function () {

    Route::get('/dashboard', [Siswa\DashboardController::class, 'index'])->name('dashboard');

    // Peminjaman
    Route::get('/peminjaman',                              [Siswa\PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/pinjam',                       [Siswa\PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::get('/peminjaman/pinjam/{buku}',                [Siswa\PeminjamanController::class, 'detail'])->name('peminjaman.detail');
    Route::post('/peminjaman',                             [Siswa\PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}',                 [Siswa\PeminjamanController::class, 'show'])->name('peminjaman.show');

    // Pengembalian
    Route::get('/pengembalian',                          [Siswa\PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{peminjaman}/konfirmasi',  [Siswa\PengembalianController::class, 'konfirmasi'])->name('pengembalian.konfirmasi');
    Route::post('/pengembalian/{peminjaman}/proses',     [Siswa\PengembalianController::class, 'proses'])->name('pengembalian.proses');

    // Profil Siswa (Kelola Anggota Mandiri)
    Route::get('/profil',                [Siswa\ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil',                [Siswa\ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password',       [Siswa\ProfilController::class, 'updatePassword'])->name('profil.password');

    // Ulasan / Rating
    Route::get('/ulasan/{peminjaman}',        [Siswa\UlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/ulasan/{peminjaman}',       [Siswa\UlasanController::class, 'store'])->name('ulasan.store');
    Route::post('/ulasan/{peminjaman}/skip',  [Siswa\UlasanController::class, 'skip'])->name('ulasan.skip');
});

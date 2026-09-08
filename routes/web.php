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

    // Transaksi
    Route::get('/transaksi',                        [Admin\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create',                 [Admin\TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',                       [Admin\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}',            [Admin\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/edit',       [Admin\TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}',            [Admin\TransaksiController::class, 'update'])->name('transaksi.update');
    Route::post('/transaksi/{transaksi}/kembali',   [Admin\TransaksiController::class, 'pengembalian'])->name('transaksi.kembali');
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
});

// ── Siswa ─────────────────────────────────────────────────────────────────────
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'siswa'])->group(function () {

    Route::get('/dashboard', [Siswa\DashboardController::class, 'index'])->name('dashboard');

    // Peminjaman
    Route::get('/peminjaman',                  [Siswa\PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/pinjam',           [Siswa\PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman',                 [Siswa\PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{peminjaman}',     [Siswa\PeminjamanController::class, 'show'])->name('peminjaman.show');

    // Pengembalian
    Route::get('/pengembalian',                          [Siswa\PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/{peminjaman}/konfirmasi',  [Siswa\PengembalianController::class, 'konfirmasi'])->name('pengembalian.konfirmasi');
    Route::post('/pengembalian/{peminjaman}/proses',     [Siswa\PengembalianController::class, 'proses'])->name('pengembalian.proses');
});

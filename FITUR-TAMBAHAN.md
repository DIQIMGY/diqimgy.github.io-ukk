# 🛠️ FITUR TAMBAHAN — SIAP TEMPEL
> Tiap PART sudah ada: Migration (kalau perlu), Route, Controller, dan View Blade.
> Baca instruksi "TEMPEL DI MANA" di tiap bagian sebelum copy-paste.

---

## DAFTAR FITUR

| # | Nama Fitur | Tingkat Kesulitan |
|---|-----------|-------------------|
| PART 1 | Perpanjang Masa Pinjam (Extend) | ⭐⭐ |
| PART 2 | Export Data Transaksi ke CSV | ⭐⭐ |
| PART 3 | Ubah Batas Denda per Hari (Setting) | ⭐⭐⭐ |
| PART 4 | Fitur Nonaktifkan Anggota (Ban/Unban) | ⭐ |
| PART 5 | Fitur Tandai Buku Rusak/Hilang | ⭐⭐ |
| PART 6 | Riwayat Peminjaman per Buku (di halaman show buku) | ⭐ |
| PART 7 | Notifikasi Flash Denda Aktif di Dashboard Siswa | ⭐ |
| PART 8 | Filter Transaksi by Tanggal (dari–sampai) | ⭐⭐ |
| PART 9 | Tambah Kolom Jumlah Peminjaman di Tabel Anggota | ⭐ |
| PART 10 | Fitur Cetak/Print Detail Transaksi | ⭐ |
| PART 11 | Tambah Field Nomor Telepon Wali di Anggota | ⭐⭐ |
| PART 12 | Fitur Bulk Approve/Reject Transaksi Pending | ⭐⭐⭐ |
| PART 13 | Tampilkan Estimasi Denda Real-time di Dashboard Siswa | ⭐⭐ |
| PART 14 | Fitur Reset Password oleh Admin | ⭐ |
| PART 15 | Tambah Buku ke Wishlist (Siswa) | ⭐⭐⭐ |

---

---

# PART 1 — PERPANJANG MASA PINJAM (EXTEND)
> Siswa atau admin bisa memperpanjang batas kembali +7 hari, maksimal 1x perpanjangan.

## Langkah 1: Migration
Buat file baru: `database/migrations/[tanggal]_add_perpanjangan_to_peminjaman_table.php`

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->boolean('sudah_diperpanjang')->default(false)->after('keterangan');
            $table->timestamp('diperpanjang_at')->nullable()->after('sudah_diperpanjang');
        });
    }
    public function down(): void {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn(['sudah_diperpanjang', 'diperpanjang_at']);
        });
    }
};
```
Jalankan: `php artisan migrate`

---

## Langkah 2: Tambah ke `$fillable` Peminjaman.php
**TEMPEL DI:** `app/Models/Peminjaman.php` — di dalam array `$fillable`

```php
// Tambahkan 2 baris ini ke dalam $fillable yang sudah ada:
'sudah_diperpanjang',
'diperpanjang_at',
```

Tambahkan juga cast:
```php
// Tambahkan ke dalam $casts:
'diperpanjang_at' => 'datetime',
'sudah_diperpanjang' => 'boolean',
```

---

## Langkah 3: Tambah Route
**TEMPEL DI:** `routes/web.php` — di dalam group admin, dekat route transaksi lainnya

```php
// Perpanjang masa pinjam (admin bisa untuk semua, siswa untuk miliknya sendiri)
Route::post('/transaksi/{transaksi}/perpanjang', [Admin\TransaksiController::class, 'perpanjang'])->name('transaksi.perpanjang');
```

Untuk siswa, tempel di group siswa:
```php
Route::post('/peminjaman/{peminjaman}/perpanjang', [Siswa\PeminjamanController::class, 'perpanjang'])->name('peminjaman.perpanjang');
```

---

## Langkah 4: Method Controller Admin
**TEMPEL DI:** `app/Http/Controllers/Admin/TransaksiController.php` — tambah method baru di akhir class

```php
/**
 * perpanjang()
 * Perpanjang batas kembali peminjaman +7 hari.
 * Hanya bisa dilakukan SATU kali per transaksi.
 */
public function perpanjang(Peminjaman $transaksi)
{
    // Hanya status dipinjam atau terlambat yang bisa diperpanjang
    if (!in_array($transaksi->status, [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_TERLAMBAT])) {
        return back()->with('error', 'Hanya transaksi aktif yang bisa diperpanjang.');
    }

    if ($transaksi->sudah_diperpanjang) {
        return back()->with('error', 'Perpanjangan sudah pernah dilakukan. Hanya bisa 1x per transaksi.');
    }

    $batasBarу = Carbon::parse($transaksi->tanggal_kembali_rencana)->addDays(7);

    $transaksi->update([
        'tanggal_kembali_rencana' => $batasBarу,
        'sudah_diperpanjang'      => true,
        'diperpanjang_at'         => now(),
        'status'                  => Peminjaman::STATUS_DIPINJAM, // reset dari terlambat jika diperpanjang
    ]);

    return back()->with('success',
        'Masa pinjam "' . $transaksi->buku->judul . '" diperpanjang sampai ' .
        $batasBarу->format('d M Y') . '.'
    );
}
```

## Method Controller Siswa
**TEMPEL DI:** `app/Http/Controllers/Siswa/PeminjamanController.php`

```php
public function perpanjang(Peminjaman $peminjaman)
{
    $anggota = Auth::user()->anggota;
    if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
        abort(403);
    }

    if (!in_array($peminjaman->status, [Peminjaman::STATUS_DIPINJAM, Peminjaman::STATUS_TERLAMBAT])) {
        return back()->with('error', 'Peminjaman tidak bisa diperpanjang.');
    }

    if ($peminjaman->sudah_diperpanjang) {
        return back()->with('error', 'Perpanjangan sudah pernah dilakukan. Hanya bisa 1x.');
    }

    $batasBaru = Carbon::parse($peminjaman->tanggal_kembali_rencana)->addDays(7);

    $peminjaman->update([
        'tanggal_kembali_rencana' => $batasBaru,
        'sudah_diperpanjang'      => true,
        'diperpanjang_at'         => now(),
        'status'                  => Peminjaman::STATUS_DIPINJAM,
    ]);

    return back()->with('success', 'Masa pinjam diperpanjang sampai ' . $batasBaru->format('d M Y') . '.');
}
```

---

## Langkah 5: Tombol di View
**TEMPEL DI:** `resources/views/admin/transaksi/show.blade.php` — di dekat tombol aksi lainnya

```blade
@if(in_array($transaksi->status, ['dipinjam','terlambat']) && !$transaksi->sudah_diperpanjang)
    <form action="{{ route('admin.transaksi.perpanjang', $transaksi) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-warning btn-sm"
            onclick="return confirm('Perpanjang masa pinjam +7 hari?')">
            <i class="bi bi-calendar-plus"></i> Perpanjang +7 Hari
        </button>
    </form>
@elseif($transaksi->sudah_diperpanjang)
    <span class="badge bg-secondary">
        <i class="bi bi-check-circle"></i> Sudah diperpanjang {{ $transaksi->diperpanjang_at?->format('d M Y') }}
    </span>
@endif
```

Untuk tampilan siswa di `resources/views/siswa/peminjaman/show.blade.php`:
```blade
@if(in_array($peminjaman->status, ['dipinjam','terlambat']) && !$peminjaman->sudah_diperpanjang)
    <form action="{{ route('siswa.peminjaman.perpanjang', $peminjaman) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning w-100 mt-2"
            onclick="return confirm('Perpanjang +7 hari? Hanya bisa 1x.')">
            <i class="bi bi-calendar-plus me-1"></i> Perpanjang Masa Pinjam
        </button>
    </form>
@elseif($peminjaman->sudah_diperpanjang)
    <div class="alert alert-secondary py-2 mt-2">
        <i class="bi bi-info-circle me-1"></i>
        Sudah diperpanjang pada {{ $peminjaman->diperpanjang_at?->format('d M Y') }}.
    </div>
@endif
```

---
---

# PART 2 — EXPORT DATA TRANSAKSI KE CSV
> Admin bisa download semua transaksi (atau yang terfilter) sebagai file CSV.

## Langkah 1: Route
**TEMPEL DI:** `routes/web.php` — di dalam group admin, dekat route transaksi

```php
Route::get('/transaksi/export', [Admin\TransaksiController::class, 'exportCsv'])->name('transaksi.export');
```
> ⚠️ Taruh SEBELUM `Route::get('/transaksi/{transaksi}', ...)` agar tidak bentrok dengan route model binding.

---

## Langkah 2: Method Controller
**TEMPEL DI:** `app/Http/Controllers/Admin/TransaksiController.php`

```php
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * exportCsv()
 * Download semua transaksi sebagai file CSV.
 * Mendukung filter status dari query string.
 */
public function exportCsv(Request $request): StreamedResponse
{
    $query = Peminjaman::with(['anggota', 'buku']);

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('search')) {
        $q = $request->search;
        $query->where(function ($q2) use ($q) {
            $q2->where('kode_pinjam', 'like', "%{$q}%")
               ->orWhereHas('anggota', fn($a) => $a->where('nama', 'like', "%{$q}%"))
               ->orWhereHas('buku',    fn($b) => $b->where('judul', 'like', "%{$q}%"));
        });
    }

    $transaksi = $query->orderByDesc('created_at')->get();

    $filename = 'transaksi_' . now()->format('Ymd_His') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function () use ($transaksi) {
        $handle = fopen('php://output', 'w');

        // Header kolom CSV
        fputcsv($handle, [
            'Kode Pinjam', 'Nama Anggota', 'NIS', 'Kelas',
            'Judul Buku', 'Pengarang',
            'Tanggal Pengajuan', 'Tanggal Pinjam', 'Batas Kembali',
            'Tanggal Kembali Aktual', 'Status',
            'Denda (Rp)', 'Denda Dibayar',
        ]);

        foreach ($transaksi as $t) {
            fputcsv($handle, [
                $t->kode_pinjam,
                $t->anggota->nama ?? '-',
                $t->anggota->nis  ?? '-',
                $t->anggota->kelas ?? '-',
                $t->buku->judul   ?? '-',
                $t->buku->pengarang ?? '-',
                $t->tanggal_pengajuan?->format('d/m/Y') ?? '-',
                $t->tanggal_pinjam?->format('d/m/Y')   ?? '-',
                $t->tanggal_kembali_rencana?->format('d/m/Y') ?? '-',
                $t->tanggal_kembali_aktual?->format('d/m/Y')  ?? '-',
                $t->statusLabel(),
                $t->denda,
                $t->denda_dibayar ? 'Ya' : 'Belum',
            ]);
        }

        fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
}
```

---

## Langkah 3: Tombol Export di View
**TEMPEL DI:** `resources/views/admin/transaksi/index.blade.php` — di dekat page header / tombol Tambah Transaksi

```blade
<a href="{{ route('admin.transaksi.export', request()->query()) }}"
   class="btn btn-success btn-sm">
    <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV
</a>
```
> `request()->query()` meneruskan filter yang sedang aktif ke URL export, jadi export ikut terfilter.

---
---

# PART 3 — PENGATURAN DENDA PER HARI (SETTING)
> Admin bisa ubah nilai denda per hari tanpa ubah kode. Disimpan di tabel `settings`.

## Langkah 1: Migration
Buat file: `database/migrations/[tanggal]_create_settings_table.php`

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label');      // label tampil di UI
            $table->string('type')->default('text'); // text, number, boolean
            $table->timestamps();
        });

        // Seed nilai awal
        DB::table('settings')->insert([
            ['key' => 'denda_per_hari', 'value' => '1000', 'label' => 'Denda per Hari (Rp)', 'type' => 'number', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maks_pinjam_hari', 'value' => '7', 'label' => 'Maks. Hari Pinjam', 'type' => 'number', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maks_buku_per_siswa', 'value' => '3', 'label' => 'Maks. Buku per Siswa', 'type' => 'number', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    public function down(): void {
        Schema::dropIfExists('settings');
    }
};
```

---

## Langkah 2: Model Setting
Buat file baru: `app/Models/Setting.php`

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'label', 'type'];

    // Helper statis — ambil nilai setting berdasarkan key
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Helper statis — set nilai setting
    public static function set(string $key, $value): void
    {
        static::where('key', $key)->update(['value' => $value]);
    }
}
```

---

## Langkah 3: Route
**TEMPEL DI:** `routes/web.php` — di dalam group admin

```php
Route::get('/settings',  [Admin\SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
```

---

## Langkah 4: Controller Setting
Buat file baru: `app/Http/Controllers/Admin/SettingController.php`

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings'   => 'required|array',
            'settings.*' => 'nullable|string|max:255',
        ]);

        foreach ($request->settings as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
```

---

## Langkah 5: Gunakan Setting di TransaksiController
**CARI DAN GANTI DI:** `app/Http/Controllers/Admin/TransaksiController.php`

Tambahkan use di atas:
```php
use App\Models\Setting;
```

Ganti semua angka `1000` (denda per hari) dengan:
```php
$dendaPerHari = (int) Setting::get('denda_per_hari', 1000);
// lalu pakai $dendaPerHari sebagai ganti 1000
$denda = $selisih * $dendaPerHari;
```

Ganti `addDays(7)` dengan:
```php
$maksPinjam = (int) Setting::get('maks_pinjam_hari', 7);
$tanggalKembali = $tanggalPinjam->copy()->addDays($maksPinjam);
```

---

## Langkah 6: View Settings
Buat folder `resources/views/admin/settings/` lalu buat file `index.blade.php`:

```blade
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h4 class="mb-4"><i class="bi bi-gear me-2"></i>Pengaturan Sistem</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @foreach($settings as $setting)
                <div class="mb-3 row align-items-center">
                    <label class="col-sm-4 col-form-label fw-semibold">{{ $setting->label }}</label>
                    <div class="col-sm-4">
                        <input
                            type="{{ $setting->type === 'number' ? 'number' : 'text' }}"
                            name="settings[{{ $setting->key }}]"
                            value="{{ $setting->value }}"
                            class="form-control @error('settings.'.$setting->key) is-invalid @enderror"
                            min="0"
                        >
                    </div>
                </div>
                @endforeach
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Pengaturan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
```

---
---

# PART 4 — NONAKTIFKAN / AKTIFKAN ANGGOTA (BAN/UNBAN)
> Admin bisa nonaktifkan anggota langsung dari halaman daftar tanpa perlu buka halaman edit.

## Langkah 1: Route
**TEMPEL DI:** `routes/web.php` — di dalam group admin, dekat route anggota

```php
Route::post('/anggota/{anggotum}/toggle-status', [Admin\AnggotaController::class, 'toggleStatus'])->name('anggota.toggle-status');
```

---

## Langkah 2: Method Controller
**TEMPEL DI:** `app/Http/Controllers/Admin/AnggotaController.php` — tambah di akhir class

```php
/**
 * toggleStatus()
 * Toggle status anggota antara aktif ↔ nonaktif.
 */
public function toggleStatus(Anggota $anggotum)
{
    if ($anggotum->status === 'aktif') {
        $anggotum->update(['status' => 'nonaktif']);
        $pesan = '"' . $anggotum->nama . '" berhasil dinonaktifkan.';
    } elseif ($anggotum->status === 'nonaktif') {
        $anggotum->update(['status' => 'aktif']);
        $pesan = '"' . $anggotum->nama . '" berhasil diaktifkan kembali.';
    } else {
        return back()->with('error', 'Status anggota tidak valid untuk diubah.');
    }

    return back()->with('success', $pesan);
}
```

---

## Langkah 3: Tombol di View
**TEMPEL DI:** `resources/views/admin/anggota/index.blade.php` — di dalam card anggota, dekat tombol Edit/Hapus

```blade
<form action="{{ route('admin.anggota.toggle-status', $a) }}" method="POST" class="d-inline">
    @csrf
    @if($a->status === 'aktif')
        <button type="submit" class="btn btn-warning btn-sm"
            onclick="return confirm('Nonaktifkan {{ $a->nama }}?')"
            title="Nonaktifkan">
            <i class="bi bi-person-slash"></i>
        </button>
    @elseif($a->status === 'nonaktif')
        <button type="submit" class="btn btn-success btn-sm"
            onclick="return confirm('Aktifkan kembali {{ $a->nama }}?')"
            title="Aktifkan">
            <i class="bi bi-person-check"></i>
        </button>
    @endif
</form>
```

---
---

# PART 5 — TANDAI BUKU RUSAK / HILANG
> Admin bisa tandai buku dengan kondisi tertentu. Buku yang hilang stoknya langsung dikurangi.

## Langkah 1: Migration
Buat: `database/migrations/[tanggal]_add_kondisi_to_buku_table.php`

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('buku', function (Blueprint $table) {
            $table->enum('kondisi', ['baik', 'rusak', 'hilang'])->default('baik')->after('stok');
            $table->text('catatan_kondisi')->nullable()->after('kondisi');
        });
    }
    public function down(): void {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['kondisi', 'catatan_kondisi']);
        });
    }
};
```

---

## Langkah 2: Tambah ke `$fillable` Buku.php
**TEMPEL DI:** `app/Models/Buku.php` — dalam array `$fillable`

```php
'kondisi',
'catatan_kondisi',
```

---

## Langkah 3: Route
**TEMPEL DI:** `routes/web.php` — dalam group admin, dekat route buku

```php
Route::post('/buku/{buku}/kondisi', [Admin\BukuController::class, 'updateKondisi'])->name('buku.kondisi');
```

---

## Langkah 4: Method Controller
**TEMPEL DI:** `app/Http/Controllers/Admin/BukuController.php`

```php
/**
 * updateKondisi()
 * Ubah kondisi buku (baik/rusak/hilang).
 * Jika hilang → stok otomatis dikurangi 1 (tidak bisa dipinjam).
 */
public function updateKondisi(Request $request, Buku $buku)
{
    $request->validate([
        'kondisi'          => 'required|in:baik,rusak,hilang',
        'catatan_kondisi'  => 'nullable|string|max:500',
    ]);

    $kondisiLama = $buku->kondisi ?? 'baik';
    $kondisiBaru = $request->kondisi;

    // Jika sekarang jadi hilang dan sebelumnya tidak hilang → kurangi stok
    if ($kondisiBaru === 'hilang' && $kondisiLama !== 'hilang') {
        if ($buku->stok > 0) {
            $buku->decrement('stok');
        }
    }

    // Jika sebelumnya hilang dan sekarang dikembalikan (baik/rusak) → tambah stok
    if ($kondisiLama === 'hilang' && $kondisiBaru !== 'hilang') {
        $buku->increment('stok');
    }

    $buku->update([
        'kondisi'         => $kondisiBaru,
        'catatan_kondisi' => $request->catatan_kondisi,
    ]);

    return back()->with('success', 'Kondisi buku "' . $buku->judul . '" diperbarui menjadi ' . ucfirst($kondisiBaru) . '.');
}
```

---

## Langkah 5: Form di View Show Buku
**TEMPEL DI:** `resources/views/admin/buku/show.blade.php`

```blade
<div class="card mt-3">
    <div class="card-header fw-semibold"><i class="bi bi-exclamation-triangle me-2"></i>Kondisi Buku</div>
    <div class="card-body">
        <form action="{{ route('admin.buku.kondisi', $buku) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kondisi</label>
                <select name="kondisi" class="form-select">
                    <option value="baik"   @selected(($buku->kondisi ?? 'baik') === 'baik')>✅ Baik</option>
                    <option value="rusak"  @selected(($buku->kondisi ?? 'baik') === 'rusak')>⚠️ Rusak</option>
                    <option value="hilang" @selected(($buku->kondisi ?? 'baik') === 'hilang')>❌ Hilang</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="catatan_kondisi" class="form-control" rows="2"
                    placeholder="Contoh: Halaman 50-60 robek">{{ $buku->catatan_kondisi }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-save me-1"></i> Simpan Kondisi
            </button>
        </form>
    </div>
</div>
```

---
---

# PART 6 — RIWAYAT PEMINJAMAN DI HALAMAN SHOW BUKU
> Tambahkan tabel riwayat siapa saja yang pernah/sedang meminjam buku ini.

## Langkah 1: Update Method show() di BukuController
**CARI DAN GANTI DI:** `app/Http/Controllers/Admin/BukuController.php`

```php
// GANTI method show() yang ada dengan ini:
public function show(Buku $buku)
{
    $riwayatPeminjaman = \App\Models\Peminjaman::with('anggota')
        ->where('buku_id', $buku->id)
        ->latest()
        ->paginate(10);

    $totalDipinjam   = \App\Models\Peminjaman::where('buku_id', $buku->id)->count();
    $sedangDipinjam  = \App\Models\Peminjaman::where('buku_id', $buku->id)
        ->whereIn('status', ['dipinjam','terlambat','pending_kembali'])
        ->count();
    $rataRating = $buku->ulasan()->avg('rating') ?? 0;

    return view('admin.buku.show', compact('buku', 'riwayatPeminjaman', 'totalDipinjam', 'sedangDipinjam', 'rataRating'));
}
```

---

## Langkah 2: Tambah Section di View Show Buku
**TEMPEL DI:** `resources/views/admin/buku/show.blade.php` — setelah info detail buku

```blade
{{-- Statistik Ringkas --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center border-0 bg-light">
            <div class="card-body py-2">
                <div class="fs-4 fw-bold text-primary">{{ $totalDipinjam }}</div>
                <div class="small text-muted">Total Dipinjam</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center border-0 bg-light">
            <div class="card-body py-2">
                <div class="fs-4 fw-bold text-warning">{{ $sedangDipinjam }}</div>
                <div class="small text-muted">Sedang Dipinjam</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center border-0 bg-light">
            <div class="card-body py-2">
                <div class="fs-4 fw-bold text-success">{{ number_format($rataRating, 1) }} ★</div>
                <div class="small text-muted">Rata-rata Rating</div>
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Peminjaman --}}
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman Buku Ini
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPeminjaman as $p)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $p->anggota->nama ?? '-' }}</div>
                            <small class="text-muted">{{ $p->anggota->nis ?? '' }}</small>
                        </td>
                        <td>{{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}</td>
                        <td>{{ $p->tanggal_kembali_rencana?->format('d M Y') ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $p->statusColor() }}">{{ $p->statusLabel() }}</span>
                        </td>
                        <td>
                            @if($p->denda > 0)
                                <span class="text-danger fw-semibold">Rp {{ number_format($p->denda,0,',','.') }}</span>
                                @if($p->denda_dibayar) <span class="badge bg-success ms-1">Lunas</span> @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum pernah dipinjam.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($riwayatPeminjaman->hasPages())
    <div class="card-footer">{{ $riwayatPeminjaman->links() }}</div>
    @endif
</div>
```

---
---

# PART 7 — NOTIFIKASI DENDA AKTIF DI DASHBOARD SISWA
> Tampilkan alert merah di atas halaman jika siswa punya denda yang belum lunas.

## Tempel di View
**TEMPEL DI:** `resources/views/siswa/dashboard.blade.php` — di paling atas section content, sebelum section pertama

```blade
{{-- Cek denda aktif --}}
@php
    $anggotaDashboard = Auth::user()->anggota;
    $dendaAktif = $anggotaDashboard
        ? \App\Models\Peminjaman::where('anggota_id', $anggotaDashboard->id)
            ->where('status', 'dikembalikan')
            ->where('denda', '>', 0)
            ->where('denda_dibayar', false)
            ->sum('denda')
        : 0;
    $jumlahTerlambat = $anggotaDashboard
        ? \App\Models\Peminjaman::where('anggota_id', $anggotaDashboard->id)
            ->whereIn('status', ['terlambat','pending_kembali'])
            ->count()
        : 0;
@endphp

@if($dendaAktif > 0)
<div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <div>
        Kamu punya denda belum lunas sebesar
        <strong>Rp {{ number_format($dendaAktif, 0, ',', '.') }}</strong>.
        Segera selesaikan dengan menghubungi petugas perpustakaan.
    </div>
</div>
@endif

@if($jumlahTerlambat > 0)
<div class="alert alert-warning d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-clock-fill fs-5"></i>
    <div>
        Ada <strong>{{ $jumlahTerlambat }} buku</strong> yang sudah melewati batas pengembalian!
        <a href="{{ route('siswa.pengembalian.index') }}" class="alert-link ms-2">Kembalikan Sekarang →</a>
    </div>
</div>
@endif
```

---
---

# PART 8 — FILTER TRANSAKSI BERDASARKAN RENTANG TANGGAL
> Admin bisa filter transaksi berdasarkan tanggal pinjam dari–sampai.

## Langkah 1: Tambah Filter di Controller
**CARI DI:** `app/Http/Controllers/Admin/TransaksiController.php` — di method `index()`, setelah blok filter `status`

```php
// Tempel SETELAH blok filter status yang sudah ada:
if ($request->filled('dari') && $request->filled('sampai')) {
    $query->whereBetween('tanggal_pinjam', [
        $request->dari,
        $request->sampai,
    ]);
} elseif ($request->filled('dari')) {
    $query->where('tanggal_pinjam', '>=', $request->dari);
} elseif ($request->filled('sampai')) {
    $query->where('tanggal_pinjam', '<=', $request->sampai);
}

if ($request->filled('dari_pengajuan') && $request->filled('sampai_pengajuan')) {
    $query->whereBetween('tanggal_pengajuan', [
        $request->dari_pengajuan,
        $request->sampai_pengajuan,
    ]);
}
```

---

## Langkah 2: Tambah Input di View
**TEMPEL DI:** `resources/views/admin/transaksi/index.blade.php` — di dalam form filter yang sudah ada

```blade
<div class="col-md-3">
    <label class="form-label small text-muted mb-1">Dari Tanggal</label>
    <input type="date" name="dari" class="form-control form-control-sm"
        value="{{ request('dari') }}">
</div>
<div class="col-md-3">
    <label class="form-label small text-muted mb-1">Sampai Tanggal</label>
    <input type="date" name="sampai" class="form-control form-control-sm"
        value="{{ request('sampai') }}">
</div>
```

---
---

# PART 9 — JUMLAH PEMINJAMAN DI TABEL ANGGOTA
> Tambah kolom "Total Pinjam" di tabel daftar anggota agar admin tahu siapa paling aktif.

## Langkah 1: Update Query di AnggotaController
**CARI DAN GANTI DI:** `app/Http/Controllers/Admin/AnggotaController.php` — di method `index()`, bagian Tab Siswa

```php
// GANTI baris ini:
$anggota = $query->latest()->paginate(10)->withQueryString();

// JADI ini (tambah withCount):
$anggota = $query->withCount([
    'peminjaman',
    'peminjaman as peminjaman_aktif_count' => function ($q) {
        $q->whereIn('status', ['dipinjam', 'terlambat', 'pending_kembali']);
    },
])->latest()->paginate(10)->withQueryString();
```

---

## Langkah 2: Tambah Kolom di View
**TEMPEL DI:** `resources/views/admin/anggota/index.blade.php` — di dalam card anggota, bisa di bawah baris email/kelas

```blade
{{-- Statistik peminjaman anggota --}}
<div class="d-flex gap-3 mt-1">
    <small class="text-muted">
        <i class="bi bi-book me-1"></i>
        Total pinjam: <strong>{{ $a->peminjaman_count ?? 0 }}</strong>
    </small>
    @if(($a->peminjaman_aktif_count ?? 0) > 0)
    <small class="text-warning">
        <i class="bi bi-exclamation-circle me-1"></i>
        Aktif: <strong>{{ $a->peminjaman_aktif_count }}</strong>
    </small>
    @endif
</div>
```

---
---

# PART 10 — CETAK / PRINT DETAIL TRANSAKSI
> Tombol print di halaman detail transaksi. Halaman berubah jadi tampilan bersih saat dicetak.

## Tempel di View
**TEMPEL DI:** `resources/views/admin/transaksi/show.blade.php`

Tambah tombol (di dekat tombol aksi lainnya):
```blade
<button onclick="window.print()" class="btn btn-secondary btn-sm">
    <i class="bi bi-printer me-1"></i> Cetak
</button>
```

Tambah CSS print di bagian `@push('styles')` atau di dalam `<style>`:
```blade
@push('styles')
<style>
@media print {
    /* Sembunyikan navbar, sidebar, tombol, dan elemen UI saat print */
    nav, aside, .sidebar, .btn, .breadcrumb,
    .no-print, header, footer, .alert {
        display: none !important;
    }
    /* Konten utama full width */
    .main-content, main, .container-fluid {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    body {
        font-size: 12pt;
        color: #000;
    }
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    /* Tampilkan header cetak */
    .print-header { display: block !important; }
}
.print-header { display: none; }
</style>
@endpush
```

Tambah header yang hanya muncul saat print, di paling atas konten:
```blade
<div class="print-header mb-3 text-center">
    <h4 class="fw-bold mb-0">PERPUSTAKAAN SEKOLAH</h4>
    <div class="text-muted small">Bukti Transaksi Peminjaman</div>
    <hr>
</div>
```

---
---

# PART 11 — TAMBAH FIELD NOMOR TELEPON WALI DI ANGGOTA
> Simpan nomor telepon wali/orang tua siswa untuk keperluan kontrol keterlambatan.

## Langkah 1: Migration
Buat: `database/migrations/[tanggal]_add_telepon_wali_to_anggota_table.php`

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('anggota', function (Blueprint $table) {
            $table->string('telepon_wali')->nullable()->after('telepon');
            $table->string('nama_wali')->nullable()->after('telepon_wali');
        });
    }
    public function down(): void {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['telepon_wali', 'nama_wali']);
        });
    }
};
```

---

## Langkah 2: Tambah ke `$fillable` Anggota.php
```php
// Tambahkan ke dalam $fillable:
'telepon_wali',
'nama_wali',
```

---

## Langkah 3: Tambah Validasi & Simpan di Controller
**CARI DI:** `app/Http/Controllers/Admin/AnggotaController.php` — method `store()` dan `update()`

Tambahkan ke dalam `$request->validate([...])`:
```php
'telepon_wali' => 'nullable|string|max:20',
'nama_wali'    => 'nullable|string|max:100',
```

Tambahkan ke dalam `Anggota::create([...])` dan `$anggotum->update([...])`:
```php
'telepon_wali' => $request->telepon_wali,
'nama_wali'    => $request->nama_wali,
```

---

## Langkah 4: Tambah Input di Form View
**TEMPEL DI:** `resources/views/admin/anggota/create.blade.php` dan `edit.blade.php` — setelah field telepon

```blade
<div class="mb-3">
    <label class="form-label">Nama Wali / Orang Tua</label>
    <input type="text" name="nama_wali" class="form-control"
        value="{{ old('nama_wali', $anggota->nama_wali ?? '') }}"
        placeholder="Contoh: Bapak Ahmad">
</div>
<div class="mb-3">
    <label class="form-label">No. Telepon Wali</label>
    <input type="text" name="telepon_wali" class="form-control"
        value="{{ old('telepon_wali', $anggota->telepon_wali ?? '') }}"
        placeholder="08xxxxxxxxxx">
</div>
```

---
---

# PART 12 — BULK APPROVE / REJECT TRANSAKSI PENDING
> Admin bisa centang beberapa transaksi sekaligus dan approve/reject semuanya.

## Langkah 1: Route
**TEMPEL DI:** `routes/web.php` — group admin, dekat route transaksi

```php
Route::post('/transaksi/bulk-approve', [Admin\TransaksiController::class, 'bulkApprove'])->name('transaksi.bulk-approve');
Route::post('/transaksi/bulk-reject',  [Admin\TransaksiController::class, 'bulkReject'])->name('transaksi.bulk-reject');
```
> ⚠️ Taruh SEBELUM `Route::get('/transaksi/{transaksi}', ...)`.

---

## Langkah 2: Method Controller
**TEMPEL DI:** `app/Http/Controllers/Admin/TransaksiController.php`

```php
/**
 * bulkApprove()
 * Setujui banyak transaksi pending sekaligus.
 */
public function bulkApprove(Request $request)
{
    $request->validate(['ids' => 'required|array', 'ids.*' => 'exists:peminjaman,id']);

    $berhasil = 0;
    $gagal    = 0;

    foreach ($request->ids as $id) {
        $transaksi = Peminjaman::with('buku')->find($id);

        if (!$transaksi || $transaksi->status !== Peminjaman::STATUS_PENDING) {
            $gagal++;
            continue;
        }

        if ($transaksi->buku->stok < 1) {
            $gagal++;
            continue;
        }

        $tanggalPinjam = Carbon::today();
        $transaksi->update([
            'status'                  => Peminjaman::STATUS_DIPINJAM,
            'tanggal_pinjam'          => $tanggalPinjam,
            'tanggal_kembali_rencana' => $tanggalPinjam->copy()->addDays(7),
            'approved_at'             => now(),
        ]);
        $transaksi->buku->decrement('stok');
        $berhasil++;
    }

    $msg = "{$berhasil} transaksi berhasil disetujui.";
    if ($gagal > 0) $msg .= " {$gagal} gagal (stok habis atau status tidak valid).";

    return back()->with('success', $msg);
}

/**
 * bulkReject()
 * Tolak banyak transaksi pending sekaligus.
 */
public function bulkReject(Request $request)
{
    $request->validate([
        'ids'              => 'required|array',
        'ids.*'            => 'exists:peminjaman,id',
        'rejection_reason' => 'nullable|string|max:500',
    ]);

    $berhasil = Peminjaman::whereIn('id', $request->ids)
        ->where('status', Peminjaman::STATUS_PENDING)
        ->update([
            'status'           => Peminjaman::STATUS_DITOLAK,
            'rejected_at'      => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

    return back()->with('success', "{$berhasil} transaksi berhasil ditolak.");
}
```

---

## Langkah 3: Tambah Checkbox & Form di View
**TEMPEL DI:** `resources/views/admin/transaksi/index.blade.php`

Tambah form wrapper dan tombol bulk di atas tabel:
```blade
<form id="form-bulk" method="POST">
@csrf

{{-- Tombol Bulk (muncul saat ada yang dicentang) --}}
<div id="bulk-actions" class="d-none mb-3 p-3 bg-light rounded border">
    <span id="bulk-count" class="me-3 fw-semibold text-primary">0 dipilih</span>

    <button type="submit" formaction="{{ route('admin.transaksi.bulk-approve') }}"
        class="btn btn-success btn-sm me-2"
        onclick="return confirm('Approve semua yang dipilih?')">
        <i class="bi bi-check-all me-1"></i> Approve Semua
    </button>

    <button type="submit" formaction="{{ route('admin.transaksi.bulk-reject') }}"
        class="btn btn-danger btn-sm"
        onclick="return confirm('Reject semua yang dipilih?')">
        <i class="bi bi-x-lg me-1"></i> Reject Semua
    </button>
</div>

{{-- Di dalam tiap card transaksi, tambah checkbox: --}}
{{-- Sesuaikan dengan struktur loop yang ada --}}
<div class="form-check mb-2">
    <input class="form-check-input bulk-cb" type="checkbox"
        name="ids[]" value="{{ $t->id }}"
        {{ $t->status !== 'pending' ? 'disabled' : '' }}>
    <label class="form-check-label small text-muted">Pilih</label>
</div>

</form> {{-- tutup form di bawah pagination --}}

@push('scripts')
<script>
// Tampilkan tombol bulk saat ada checkbox yang dicentang
document.querySelectorAll('.bulk-cb').forEach(cb => {
    cb.addEventListener('change', () => {
        const checked = document.querySelectorAll('.bulk-cb:checked').length;
        const panel   = document.getElementById('bulk-actions');
        const counter = document.getElementById('bulk-count');
        panel.classList.toggle('d-none', checked === 0);
        counter.textContent = checked + ' dipilih';
    });
});
</script>
@endpush
```

---
---

# PART 13 — ESTIMASI DENDA REAL-TIME DI DASHBOARD SISWA
> Hitung estimasi total denda yang sedang berjalan untuk buku yang belum dikembalikan.

## Tempel di View
**TEMPEL DI:** `resources/views/siswa/dashboard.blade.php` — di dalam kartu statistik atau di bawah tabel riwayat

```blade
@php
    use Carbon\Carbon;
    $anggotaDs = Auth::user()->anggota;
    $estimasiDenda = 0;

    if ($anggotaDs) {
        $aktif = \App\Models\Peminjaman::where('anggota_id', $anggotaDs->id)
            ->whereIn('status', ['terlambat', 'pending_kembali'])
            ->get();

        foreach ($aktif as $pj) {
            if ($pj->tanggal_kembali_rencana && Carbon::today()->gt($pj->tanggal_kembali_rencana)) {
                $selisih       = $pj->tanggal_kembali_rencana->diffInDays(Carbon::today());
                $estimasiDenda += $selisih * 1000;
            }
        }
    }
@endphp

@if($estimasiDenda > 0)
<div class="card border-danger mt-3">
    <div class="card-body d-flex align-items-center gap-3">
        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
            <i class="bi bi-currency-dollar fs-4 text-danger"></i>
        </div>
        <div>
            <div class="text-muted small">Estimasi Denda Berjalan</div>
            <div class="fs-5 fw-bold text-danger">Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</div>
            <div class="text-muted" style="font-size: 0.75rem;">Denda final dihitung saat pengembalian dikonfirmasi admin.</div>
        </div>
    </div>
</div>
@endif
```

---
---

# PART 14 — RESET PASSWORD OLEH ADMIN
> Admin bisa langsung reset password anggota tanpa perlu tahu password lama.

## Langkah 1: Route
**TEMPEL DI:** `routes/web.php` — group admin, dekat route anggota

```php
Route::post('/anggota/{anggotum}/reset-password', [Admin\AnggotaController::class, 'resetPassword'])->name('anggota.reset-password');
```

---

## Langkah 2: Method Controller
**TEMPEL DI:** `app/Http/Controllers/Admin/AnggotaController.php`

```php
/**
 * resetPassword()
 * Admin reset password anggota. Password baru dikirim via param request.
 * Jika tidak ada password_baru di form, gunakan password default = NIS anggota.
 */
public function resetPassword(Request $request, Anggota $anggotum)
{
    $request->validate([
        'password_baru' => 'nullable|string|min:6',
    ]);

    // Jika admin tidak isi password baru → gunakan NIS sebagai password default
    $passwordBaru = $request->filled('password_baru')
        ? $request->password_baru
        : $anggotum->nis;

    $anggotum->user->update([
        'password' => Hash::make($passwordBaru),
    ]);

    $info = $request->filled('password_baru')
        ? 'Password berhasil direset.'
        : 'Password berhasil direset ke NIS: ' . $anggotum->nis;

    return back()->with('success', $info);
}
```

---

## Langkah 3: Form di View Show Anggota
**TEMPEL DI:** `resources/views/admin/anggota/show.blade.php` — di bawah info profil

```blade
<div class="card mt-3 border-warning">
    <div class="card-header fw-semibold text-warning">
        <i class="bi bi-key me-2"></i>Reset Password
    </div>
    <div class="card-body">
        <form action="{{ route('admin.anggota.reset-password', $anggota) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Password Baru <span class="text-muted">(kosongkan = gunakan NIS sebagai password)</span></label>
                <input type="text" name="password_baru" class="form-control"
                    placeholder="Minimal 6 karakter, atau kosongkan untuk pakai NIS">
            </div>
            <button type="submit" class="btn btn-warning btn-sm"
                onclick="return confirm('Reset password {{ $anggota->nama }}?')">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Password
            </button>
        </form>
    </div>
</div>
```

---
---

# PART 15 — WISHLIST BUKU (SISWA)
> Siswa bisa simpan buku ke wishlist untuk dibaca nanti.

## Langkah 1: Migration
Buat: `database/migrations/[tanggal]_create_wishlist_table.php`

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['anggota_id', 'buku_id']); // tidak bisa wishlist buku yang sama 2x
        });
    }
    public function down(): void {
        Schema::dropIfExists('wishlist');
    }
};
```

---

## Langkah 2: Model Wishlist
Buat: `app/Models/Wishlist.php`

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';
    protected $fillable = ['anggota_id', 'buku_id'];

    public function anggota() { return $this->belongsTo(Anggota::class); }
    public function buku()    { return $this->belongsTo(Buku::class); }
}
```

Tambah relasi di `app/Models/Anggota.php`:
```php
public function wishlist() {
    return $this->hasMany(\App\Models\Wishlist::class);
}
public function wishlistBuku() {
    return $this->belongsToMany(Buku::class, 'wishlist');
}
```

---

## Langkah 3: Route
**TEMPEL DI:** `routes/web.php` — group siswa

```php
Route::get('/wishlist',               [Siswa\WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/{buku}',        [Siswa\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::delete('/wishlist/{buku}',      [Siswa\WishlistController::class, 'destroy'])->name('wishlist.destroy');
```

---

## Langkah 4: Controller Wishlist
Buat: `app/Http/Controllers/Siswa/WishlistController.php`

```php
<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $anggota  = Auth::user()->anggota;
        if (!$anggota) return redirect()->route('siswa.dashboard');

        $wishlist = Wishlist::with('buku')
            ->where('anggota_id', $anggota->id)
            ->latest()
            ->paginate(12);

        return view('siswa.wishlist.index', compact('wishlist'));
    }

    /**
     * toggle() — tambah jika belum ada, hapus jika sudah ada (toggle)
     */
    public function toggle(Buku $buku)
    {
        $anggota = Auth::user()->anggota;
        if (!$anggota) abort(403);

        $ada = Wishlist::where('anggota_id', $anggota->id)
            ->where('buku_id', $buku->id)
            ->first();

        if ($ada) {
            $ada->delete();
            return back()->with('info', '"' . $buku->judul . '" dihapus dari wishlist.');
        } else {
            Wishlist::create(['anggota_id' => $anggota->id, 'buku_id' => $buku->id]);
            return back()->with('success', '"' . $buku->judul . '" ditambahkan ke wishlist!');
        }
    }

    public function destroy(Buku $buku)
    {
        $anggota = Auth::user()->anggota;
        Wishlist::where('anggota_id', $anggota->id)->where('buku_id', $buku->id)->delete();
        return back()->with('success', 'Dihapus dari wishlist.');
    }
}
```

---

## Langkah 5: Tombol Toggle di Halaman Detail Buku
**TEMPEL DI:** `resources/views/siswa/peminjaman/detail.blade.php` — dekat tombol Pinjam

```blade
@php
    $anggotaW = Auth::user()->anggota;
    $diWishlist = $anggotaW
        ? \App\Models\Wishlist::where('anggota_id', $anggotaW->id)
            ->where('buku_id', $buku->id)->exists()
        : false;
@endphp

<form action="{{ route('siswa.wishlist.toggle', $buku) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn {{ $diWishlist ? 'btn-danger' : 'btn-outline-secondary' }} btn-sm">
        <i class="bi {{ $diWishlist ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>
        {{ $diWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}
    </button>
</form>
```

---

## Langkah 6: View Halaman Wishlist
Buat folder `resources/views/siswa/wishlist/` lalu buat `index.blade.php`:

```blade
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <h4 class="mb-0 me-auto"><i class="bi bi-heart-fill text-danger me-2"></i>Wishlist Saya</h4>
        <span class="badge bg-secondary">{{ $wishlist->total() }} buku</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show">
            {{ session('info') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($wishlist as $item)
    <div class="card mb-3">
        <div class="card-body d-flex gap-3 align-items-start">
            @if($item->buku->cover)
                <img src="{{ Storage::url($item->buku->cover) }}" alt="Cover"
                    class="rounded" style="width:60px;height:80px;object-fit:cover;">
            @else
                <div class="rounded bg-secondary d-flex align-items-center justify-content-center"
                    style="width:60px;height:80px;">
                    <i class="bi bi-book text-white fs-4"></i>
                </div>
            @endif
            <div class="flex-grow-1">
                <h6 class="mb-1">{{ $item->buku->judul }}</h6>
                <div class="text-muted small">{{ $item->buku->pengarang }}</div>
                <div class="mt-1">
                    @if($item->buku->stok > 0)
                        <span class="badge bg-success">Tersedia ({{ $item->buku->stok }} stok)</span>
                    @else
                        <span class="badge bg-secondary">Stok Habis</span>
                    @endif
                </div>
            </div>
            <div class="d-flex flex-column gap-2">
                @if($item->buku->stok > 0)
                <a href="{{ route('siswa.peminjaman.detail', $item->buku) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-book me-1"></i> Pinjam
                </a>
                @endif
                <form action="{{ route('siswa.wishlist.destroy', $item->buku) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-heart fs-1 d-block mb-3"></i>
        Belum ada buku di wishlist kamu.
        <br>
        <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-primary mt-3">Jelajahi Buku</a>
    </div>
    @endforelse

    {{ $wishlist->links() }}
</div>
@endsection
```

---
---

# BONUS KECIL-KECIL (Langsung Tempel di View)

## 🔹 Badge Stok Warna-Warni di Halaman Daftar Buku
**TEMPEL DI:** mana saja yang menampilkan stok buku

```blade
{{-- Ganti tampilan stok biasa dengan badge berwarna --}}
@php $stok = $buku->stok; @endphp
<span class="badge
    {{ $stok === 0  ? 'bg-danger'  : '' }}
    {{ $stok <= 2   && $stok > 0 ? 'bg-warning text-dark' : '' }}
    {{ $stok > 2   ? 'bg-success' : '' }}
">
    @if($stok === 0) Habis
    @elseif($stok <= 2) Tersisa {{ $stok }}
    @else Tersedia {{ $stok }}
    @endif
</span>
```

---

## 🔹 Tombol Salin Kode Transaksi
**TEMPEL DI:** `resources/views/admin/transaksi/show.blade.php` atau `siswa/peminjaman/show.blade.php`

```blade
<span id="kode-pinjam">{{ $transaksi->kode_pinjam }}</span>
<button class="btn btn-sm btn-outline-secondary ms-2" type="button"
    onclick="navigator.clipboard.writeText('{{ $transaksi->kode_pinjam }}').then(() => this.innerHTML = '<i class=\'bi bi-check\'></i> Disalin!')">
    <i class="bi bi-clipboard"></i> Salin
</button>
```

---

## 🔹 Countdown Batas Kembali di View Siswa
**TEMPEL DI:** `resources/views/siswa/peminjaman/index.blade.php` atau `show.blade.php`

```blade
@if($peminjaman->tanggal_kembali_rencana && $peminjaman->isAktif())
    @php
        $today  = \Carbon\Carbon::today();
        $batas  = $peminjaman->tanggal_kembali_rencana;
        $selisih = $today->diffInDays($batas, false); // negatif jika sudah lewat
    @endphp
    @if($selisih < 0)
        <span class="text-danger small"><i class="bi bi-exclamation-circle me-1"></i>Terlambat {{ abs($selisih) }} hari</span>
    @elseif($selisih <= 2)
        <span class="text-warning small"><i class="bi bi-clock-history me-1"></i>Sisa {{ $selisih }} hari</span>
    @else
        <span class="text-success small"><i class="bi bi-calendar-check me-1"></i>Sisa {{ $selisih }} hari</span>
    @endif
@endif
```

---

## 🔹 Konfirmasi JavaScript Sebelum Hapus
**TEMPEL DI:** semua form `DELETE` yang belum ada konfirmasinya

```blade
{{-- Ganti semua tombol hapus dengan pattern ini: --}}
<form action="{{ route('admin.buku.destroy', $buku) }}" method="POST"
    onsubmit="return confirm('Yakin ingin menghapus buku ini? Data tidak bisa dikembalikan.')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i> Hapus
    </button>
</form>
```

---

## 🔹 Tampilkan Foto Profil dengan Fallback ke Inisial
**TEMPEL DI:** mana saja yang perlu tampilkan foto user/anggota

```blade
@php $namaUser = $anggota->nama ?? Auth::user()->name; @endphp
@if($anggota->foto ?? false)
    <img src="{{ Storage::url($anggota->foto) }}" alt="Foto"
        class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
@else
    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
        style="width:40px;height:40px;font-size:1rem;">
        {{ strtoupper(substr($namaUser, 0, 1)) }}
    </div>
@endif
```

---

## 🔹 Pesan Kosong yang Bagus (Empty State)
**TEMPEL DI:** bagian `@empty` di setiap `@forelse`

```blade
@empty
<div class="text-center py-5">
    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
    <h6 class="text-muted">Tidak ada data</h6>
    <p class="text-muted small mb-0">Coba ubah filter pencarian atau tambah data baru.</p>
</div>
```

---

## 🔹 Auto-dismiss Alert Setelah 4 Detik
**TEMPEL DI:** `resources/views/layouts/app.blade.php` — di dalam `@push('scripts')` atau sebelum `</body>`

```blade
@push('scripts')
<script>
// Auto-dismiss semua alert Bootstrap setelah 4 detik
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 4000);
    });
});
</script>
@endpush
```

---

## 🔹 Tampilkan Waktu Relatif ("3 hari lalu", "baru saja")
**TEMPEL DI:** mana saja yang menampilkan `created_at` atau tanggal

```blade
{{-- Sebagai ganti {{ $item->created_at->format('d M Y') }} --}}
<span title="{{ $item->created_at->format('d M Y H:i') }}">
    {{ $item->created_at->diffForHumans() }}
    {{-- Output: "3 hari lalu", "1 bulan lalu", "baru saja" --}}
</span>
```
> `diffForHumans()` adalah method dari Carbon, otomatis tersedia karena kolom `created_at` sudah di-cast ke `datetime` oleh Eloquent.

---

*Semua snippet di atas kompatibel 100% dengan struktur proyek yang sudah ada. Tidak ada dependency tambahan — cukup tempel dan jalankan migration jika ada.* 🚀

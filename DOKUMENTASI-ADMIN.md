# 📚 DOKUMENTASI PEMBUATAN HALAMAN ADMIN
## Aplikasi Peminjaman Buku — Perpustakaan Sekolah Digital
**Framework:** Laravel 12 | **UI:** Bootstrap 5 + Custom CSS

---

## DAFTAR ISI
1. [Gambaran Umum](#1-gambaran-umum)
2. [Struktur File & Folder](#2-struktur-file--folder)
3. [Database & Migration](#3-database--migration)
4. [Model](#4-model)
5. [Middleware (Keamanan Akses)](#5-middleware-keamanan-akses)
6. [Routes (URL Admin)](#6-routes-url-admin)
7. [Layout Utama (layouts/app.blade.php)](#7-layout-utama)
8. [Dashboard Admin](#8-dashboard-admin)
9. [CRUD Buku](#9-crud-buku)
10. [CRUD Anggota](#10-crud-anggota)
11. [Transaksi Peminjaman & Pengembalian](#11-transaksi-peminjaman--pengembalian)
12. [Alur Kerja Lengkap](#12-alur-kerja-lengkap)

---

## 1. Gambaran Umum

Halaman admin adalah area khusus yang **hanya bisa diakses oleh pengguna dengan role `admin`**. Admin bisa mengelola:

| Fitur | Keterangan |
|---|---|
| Dashboard | Statistik ringkas dan aktivitas terbaru |
| Data Buku | Tambah, lihat, edit, hapus buku (CRUD) |
| Kelola Anggota | Tambah, lihat, edit, hapus anggota/siswa (CRUD) |
| Transaksi | Buat peminjaman, proses pengembalian, lihat riwayat |

Semua URL admin diawali dengan `/admin/` dan dilindungi oleh middleware `auth` + `admin`.

---

## 2. Struktur File & Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       ├── DashboardController.php   ← logika dashboard
│   │       ├── BukuController.php        ← CRUD buku
│   │       ├── AnggotaController.php     ← CRUD anggota
│   │       └── TransaksiController.php   ← peminjaman & pengembalian
│   └── Middleware/
│       └── AdminMiddleware.php           ← cek hak akses admin
├── Models/
│   ├── User.php        ← akun login
│   ├── Anggota.php     ← data profil siswa
│   ├── Buku.php        ← data buku
│   └── Peminjaman.php  ← data transaksi pinjam/kembali
│
database/
└── migrations/
    ├── 0001_01_01_000000_create_users_table.php
    ├── 2025_01_01_000010_create_anggota_table.php
    ├── 2025_01_01_000020_create_buku_table.php
    └── 2025_01_01_000030_create_peminjaman_table.php
│
resources/
└── views/
    ├── layouts/
    │   └── app.blade.php          ← template utama (sidebar + topbar)
    └── admin/
        ├── dashboard.blade.php
        ├── buku/
        │   ├── index.blade.php    ← daftar buku
        │   ├── create.blade.php   ← form tambah buku
        │   ├── edit.blade.php     ← form edit buku
        │   └── show.blade.php     ← detail buku
        ├── anggota/
        │   ├── index.blade.php    ← daftar anggota
        │   ├── create.blade.php   ← form tambah anggota
        │   ├── edit.blade.php     ← form edit anggota
        │   └── show.blade.php     ← detail anggota
        └── transaksi/
            ├── index.blade.php    ← daftar transaksi
            ├── create.blade.php   ← form buat peminjaman
            ├── edit.blade.php     ← form edit transaksi
            └── show.blade.php     ← detail transaksi
│
routes/
└── web.php   ← semua definisi URL
```

---

## 3. Database & Migration

Migration adalah file PHP yang mendefinisikan struktur tabel database. Dijalankan dengan perintah:
```bash
php artisan migrate
```

### Tabel `users`
File: `database/migrations/0001_01_01_000000_create_users_table.php`

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();                                          // kolom id auto increment
    $table->string('name');                                // nama lengkap
    $table->string('email')->unique();                     // email, harus unik
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');                            // password (disimpan hash)
    $table->enum('role', ['admin', 'siswa'])->default('siswa'); // peran pengguna
    $table->rememberToken();
    $table->timestamps();                                  // created_at & updated_at
});
```

Penjelasan: Tabel `users` menyimpan akun login. Kolom `role` membedakan siapa admin dan siapa siswa. Nilai defaultnya `siswa` karena kebanyakan pengguna adalah siswa.

---

### Tabel `anggota`
File: `database/migrations/2025_01_01_000010_create_anggota_table.php`

```php
Schema::create('anggota', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    // ↑ foreign key ke tabel users. Jika user dihapus, anggota ikut terhapus otomatis
    $table->string('nis')->unique();      // Nomor Induk Siswa, harus unik
    $table->string('nama');
    $table->string('kelas');             // contoh: XI-RPL-1
    $table->string('alamat')->nullable();
    $table->string('telepon')->nullable();
    $table->string('foto')->nullable();  // path file foto di storage
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});
```

Penjelasan: Tabel `anggota` menyimpan profil siswa. Terpisah dari `users` supaya data login (email/password) dipisahkan dari data personal (NIS, kelas, dll).

---

### Tabel `buku`
File: `database/migrations/2025_01_01_000020_create_buku_table.php`

```php
Schema::create('buku', function (Blueprint $table) {
    $table->id();
    $table->string('kode_buku')->unique();  // kode unik buku, contoh: BK001
    $table->string('judul');
    $table->string('pengarang');
    $table->string('penerbit');
    $table->year('tahun_terbit');
    $table->string('kategori');
    $table->integer('stok')->default(1);    // jumlah stok yang tersedia
    $table->string('cover')->nullable();    // path gambar cover
    $table->text('deskripsi')->nullable();
    $table->enum('status_launching', ['tersedia', 'segera'])->default('tersedia');
    // ↑ 'segera' = buku belum tersedia tapi akan segera ada (coming soon)
    $table->date('tanggal_rilis')->nullable(); // khusus untuk status 'segera'
    $table->timestamps();
});
```

---

### Tabel `peminjaman`
File: `database/migrations/2025_01_01_000030_create_peminjaman_table.php`

```php
Schema::create('peminjaman', function (Blueprint $table) {
    $table->id();
    $table->string('kode_pinjam')->unique();  // kode transaksi, contoh: TRX-ABC123
    $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
    $table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
    $table->date('tanggal_pinjam');
    $table->date('tanggal_kembali_rencana');  // batas pengembalian
    $table->date('tanggal_kembali_aktual')->nullable(); // tanggal saat dikembalikan
    $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
    $table->integer('denda')->default(0);     // denda dalam Rupiah
    $table->text('keterangan')->nullable();
    $table->timestamps();
});
```

Penjelasan kolom penting:
- `tanggal_kembali_rencana` = batas waktu pengembalian
- `tanggal_kembali_aktual` = kapan buku benar-benar dikembalikan (null jika belum)
- `status` berubah dari `dipinjam` → `terlambat` (otomatis) → `dikembalikan`
- `denda` = Rp 1.000 per hari keterlambatan

---

## 4. Model

Model adalah kelas PHP yang merepresentasikan tabel database. Menggunakan Eloquent ORM bawaan Laravel.

### `app/Models/User.php`

```php
<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Kolom yang boleh diisi lewat create()/update()
    protected $fillable = ['name', 'email', 'password', 'role'];

    // Kolom yang disembunyikan saat dikonversi ke array/JSON
    protected $hidden = ['password', 'remember_token'];

    // Otomatis hash password saat disimpan
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Method pembantu untuk cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // Relasi: 1 user punya 1 anggota
    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }
}
```

---

### `app/Models/Anggota.php`

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota'; // nama tabel di database
    protected $fillable = ['user_id', 'nis', 'nama', 'kelas', 'alamat', 'telepon', 'foto', 'status'];

    // Relasi: anggota milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: anggota punya banyak peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Relasi khusus: hanya peminjaman yang masih aktif
    public function peminjamanAktif()
    {
        return $this->hasMany(Peminjaman::class)->where('status', 'dipinjam');
    }
}
```

---

### `app/Models/Buku.php`

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = [
        'kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit',
        'kategori', 'stok', 'cover', 'deskripsi',
        'status_launching', 'tanggal_rilis',
    ];

    // Kolom yang perlu dikonversi tipe datanya
    protected $casts = [
        'tanggal_rilis' => 'date', // otomatis jadi objek Carbon
    ];

    // Relasi: 1 buku punya banyak peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Method pembantu
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}
```

---

### `app/Models/Peminjaman.php`

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'kode_pinjam', 'anggota_id', 'buku_id',
        'tanggal_pinjam', 'tanggal_kembali_rencana', 'tanggal_kembali_aktual',
        'status', 'denda', 'keterangan',
    ];

    // Konversi string tanggal → objek Carbon secara otomatis
    protected $casts = [
        'tanggal_pinjam'          => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual'  => 'date',
    ];

    // Relasi ke anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relasi ke buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Hitung denda: Rp 1.000 per hari keterlambatan
    public function hitungDenda(): int
    {
        if ($this->tanggal_kembali_aktual && 
            $this->tanggal_kembali_aktual->gt($this->tanggal_kembali_rencana)) {
            $selisih = $this->tanggal_kembali_rencana->diffInDays($this->tanggal_kembali_aktual);
            return $selisih * 1000;
        }
        return 0;
    }
}
```

---

## 5. Middleware (Keamanan Akses)

Middleware adalah "penjaga pintu" yang berjalan sebelum request masuk ke controller.

### `app/Http/Middleware/AdminMiddleware.php`

```php
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek: apakah pengguna sudah login DAN punya role admin?
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403); // Tampilkan error "Forbidden" jika bukan admin
        }

        return $next($request); // Lanjutkan request jika admin
    }
}
```

Middleware ini didaftarkan di `bootstrap/app.php` dengan alias `admin`:

```php
$middleware->alias([
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
]);
```

Cara pakai di routes: `->middleware(['auth', 'admin'])`
- `auth` = wajib login dulu
- `admin` = setelah login, dicek apakah rolenya admin

---

## 6. Routes (URL Admin)

File: `routes/web.php`

Semua route admin dibungkus dalam satu group agar lebih rapi:

```php
// Semua URL diawali /admin, nama diawali admin., dilindungi middleware auth + admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // ── Dashboard ──
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    // URL: GET /admin/dashboard | Nama: admin.dashboard

    // ── Buku (menggunakan resource route = 7 route sekaligus) ──
    Route::resource('buku', Admin\BukuController::class);
    // Ini otomatis membuat 7 route:
    // GET    /admin/buku              → index   (daftar)    → admin.buku.index
    // GET    /admin/buku/create       → create  (form baru) → admin.buku.create
    // POST   /admin/buku              → store   (simpan)    → admin.buku.store
    // GET    /admin/buku/{buku}       → show    (detail)    → admin.buku.show
    // GET    /admin/buku/{buku}/edit  → edit    (form edit) → admin.buku.edit
    // PUT    /admin/buku/{buku}       → update  (update)    → admin.buku.update
    // DELETE /admin/buku/{buku}       → destroy (hapus)     → admin.buku.destroy

    // ── Anggota (manual, bukan resource) ──
    // Catatan: parameter pakai {anggotum} bukan {anggota}
    // karena nama "anggota" bentrok dengan nama tabel di PHP
    Route::get('/anggota',                   [Admin\AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create',            [Admin\AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota',                  [Admin\AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{anggotum}',        [Admin\AnggotaController::class, 'show'])->name('anggota.show');
    Route::get('/anggota/{anggotum}/edit',   [Admin\AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{anggotum}',        [Admin\AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{anggotum}',     [Admin\AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // ── Transaksi ──
    Route::get('/transaksi',                          [Admin\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create',                   [Admin\TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',                         [Admin\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}',              [Admin\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/edit',         [Admin\TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}',              [Admin\TransaksiController::class, 'update'])->name('transaksi.update');
    Route::post('/transaksi/{transaksi}/kembali',     [Admin\TransaksiController::class, 'pengembalian'])->name('transaksi.kembali');
    Route::delete('/transaksi/{transaksi}',           [Admin\TransaksiController::class, 'destroy'])->name('transaksi.destroy');
});
```

> **Cara membaca route:**
> - `GET` = mengambil halaman (buka di browser)
> - `POST` = mengirim data baru (submit form tambah)
> - `PUT` = mengirim data yang diupdate (submit form edit)
> - `DELETE` = menghapus data

---

## 7. Layout Utama

File: `resources/views/layouts/app.blade.php`

Layout ini adalah "kerangka" yang dipakai oleh semua halaman admin. Strukturnya:

```
┌─────────────────────────────────────────────────┐
│  SIDEBAR (kiri, fixed 276px)                    │
│  ┌────────────────────────────────────────────┐ │
│  │  Logo + Nama Aplikasi                      │ │
│  │  ┌─────────────────────────────────────┐   │ │
│  │  │ 👤 Nama Admin | Badge: ADMIN        │   │ │
│  │  └─────────────────────────────────────┘   │ │
│  │  Overview                                  │ │
│  │  ▸ Dashboard                               │ │
│  │  Data Master                               │ │
│  │  ▸ Data Buku                               │ │
│  │  ▸ Kelola Anggota                          │ │
│  │  Transaksi                                 │ │
│  │  ▸ Peminjaman                              │ │
│  │  ─────────────────────────────────────     │ │
│  │  [Keluar]                                  │ │
│  └────────────────────────────────────────────┘ │
│                                                 │
│  AREA KONTEN (kanan)                            │
│  ┌──────────────────────────────────────────┐   │
│  │  TOPBAR: [≡] Judul Halaman | Tgl | User  │   │
│  ├──────────────────────────────────────────┤   │
│  │  [Flash message sukses/error/warning]    │   │
│  ├──────────────────────────────────────────┤   │
│  │                                          │   │
│  │  @yield('content')                       │   │
│  │  ← konten halaman masing-masing          │   │
│  │                                          │   │
│  └──────────────────────────────────────────┘   │
└─────────────────────────────────────────────────┘
```

Cara sebuah halaman admin "masuk" ke layout ini:

```php
{{-- Contoh di admin/dashboard.blade.php --}}

@extends('layouts.app')           {{-- pakai layout ini --}}
@section('title', 'Dashboard Admin')   {{-- isi tag <title> --}}
@section('page-title', 'Dashboard Admin')  {{-- isi judul di topbar --}}

@section('content')
    {{-- semua HTML konten halaman ditulis di sini --}}
    <h1>Halo Admin!</h1>
@endsection
```

### Flash Message (Notifikasi)

Setelah controller melakukan redirect, bisa mengirim pesan:
```php
// Di controller:
return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
return redirect()->back()->with('error', 'Terjadi kesalahan.');
```

Di layout, pesan ini ditampilkan otomatis:
```php
{{-- Di layouts/app.blade.php --}}
@if(session('success'))
<div class="flash-msg flash-success">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()">&times;</button>
</div>
@endif
```

---

## 8. Dashboard Admin

File: `app/Http/Controllers/Admin/DashboardController.php`

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total masing-masing untuk kartu statistik
        $totalBuku      = Buku::count();
        $totalAnggota   = Anggota::count();
        $totalPinjam    = Peminjaman::where('status', 'dipinjam')->count();
        $totalTerlambat = Peminjaman::where('status', 'terlambat')->count();
        $totalKembali   = Peminjaman::where('status', 'dikembalikan')->count();

        // 5 transaksi terbaru untuk ditampilkan di tabel
        $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
            ->latest()   // urut dari yang paling baru
            ->take(5)    // ambil 5 saja
            ->get();

        // 5 buku paling sering dipinjam
        $bukuPopuler = Buku::withCount('peminjaman')
            // withCount otomatis tambah kolom peminjaman_count
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku', 'totalAnggota', 'totalPinjam',
            'totalTerlambat', 'totalKembali',
            'peminjamanTerbaru', 'bukuPopuler'
        ));
    }
}
```

**Penjelasan query `with(['anggota', 'buku'])`:**
Ini disebut "eager loading". Tanpa ini, Laravel akan menjalankan query database tambahan untuk setiap baris (N+1 problem). Dengan `with()`, semua data anggota dan buku dimuat sekaligus dalam 3 query total.

---

## 9. CRUD Buku

### 9.1 Controller: `BukuController.php`

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // ──────────────────────────────────────────────
    // INDEX — Daftar semua buku
    // URL: GET /admin/buku
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Buku::query(); // mulai query

        // Filter pencarian (jika ada input search di URL)
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('judul',     'like', "%{$q}%")
                   ->orWhere('pengarang', 'like', "%{$q}%")
                   ->orWhere('kode_buku', 'like', "%{$q}%")
                   ->orWhere('kategori',  'like', "%{$q}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Paginate: tampilkan 30 buku per halaman
        $buku      = $query->latest()->paginate(30)->withQueryString();
        //                                            ↑ withQueryString() agar ?search= ikut di link halaman

        // Ambil semua kategori untuk dropdown filter
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        return view('admin.buku.index', compact('buku', 'kategoris'));
    }

    // ──────────────────────────────────────────────
    // CREATE — Form tambah buku baru
    // URL: GET /admin/buku/create
    // ──────────────────────────────────────────────
    public function create()
    {
        return view('admin.buku.create');
        // Tidak ada data yang perlu dikirim, cukup tampilkan form kosong
    }

    // ──────────────────────────────────────────────
    // STORE — Simpan buku baru ke database
    // URL: POST /admin/buku
    // ──────────────────────────────────────────────
    public function store(Request $request)
    {
        // Validasi input. Jika gagal, otomatis kembali ke form dengan error
        $request->validate([
            'kode_buku'    => 'required|string|unique:buku,kode_buku',
            // ↑ wajib diisi, harus unik di tabel buku kolom kode_buku
            'judul'        => 'required|string|max:200',
            'pengarang'    => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            // ↑ tepat 4 digit, antara 1900 dan tahun sekarang
            'kategori'     => 'required|string|max:50',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // ↑ opsional, kalau diisi harus gambar, max 2MB
            'deskripsi'    => 'nullable|string',
            'status_launching' => 'required|in:tersedia,segera',
            'tanggal_rilis'    => 'nullable|date|after_or_equal:today',
        ]);

        // Ambil semua data request kecuali field 'cover' (dihandle terpisah)
        $data = $request->except('cover');

        // Aturan bisnis: jika status "segera hadir", tanggal rilis wajib
        if ($request->status_launching === 'segera' && !$request->tanggal_rilis) {
            return back()
                ->withErrors(['tanggal_rilis' => 'Tanggal rilis harus diisi untuk buku Segera Hadir'])
                ->withInput();
        }

        // Jika status "tersedia", hapus tanggal rilis (tidak relevan)
        if ($request->status_launching === 'tersedia') {
            $data['tanggal_rilis'] = null;
        }

        // Upload cover jika ada
        if ($request->hasFile('cover')) {
            // Simpan ke folder 'covers' di storage/app/public/
            // File bisa diakses via /storage/covers/namafile.jpg
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data); // Buat record baru di database

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────
    // SHOW — Lihat detail satu buku
    // URL: GET /admin/buku/{id}
    // ──────────────────────────────────────────────
    public function show(Buku $buku)
    {
        // Laravel otomatis ambil data buku berdasarkan ID di URL
        // Ini disebut "Route Model Binding"
        return view('admin.buku.show', compact('buku'));
    }

    // ──────────────────────────────────────────────
    // EDIT — Form edit buku yang sudah ada
    // URL: GET /admin/buku/{id}/edit
    // ──────────────────────────────────────────────
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
        // Data buku dikirim ke view untuk mengisi form
    }

    // ──────────────────────────────────────────────
    // UPDATE — Simpan perubahan buku
    // URL: PUT /admin/buku/{id}
    // ──────────────────────────────────────────────
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kode_buku' => 'required|string|unique:buku,kode_buku,' . $buku->id,
            // ↑ unik, tapi KECUALI buku ini sendiri (ignore ID saat ini)
            'judul'        => 'required|string|max:200',
            'pengarang'    => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kategori'     => 'required|string|max:50',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi'    => 'nullable|string',
            'status_launching' => 'required|in:tersedia,segera',
            'tanggal_rilis'    => 'nullable|date',
        ]);

        $data = $request->except('cover');

        if ($request->status_launching === 'segera' && !$request->tanggal_rilis) {
            return back()->withErrors(['tanggal_rilis' => 'Tanggal rilis wajib diisi'])->withInput();
        }

        if ($request->status_launching === 'tersedia') {
            $data['tanggal_rilis'] = null;
        }

        // Jika ada cover baru yang diupload
        if ($request->hasFile('cover')) {
            // Hapus cover lama dari storage agar tidak membuang ruang
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data); // Update record yang sudah ada

        // Kembali ke halaman yang sama (bisa menyimpan nomor halaman dari form hidden input)
        $page = $request->input('page', 1);
        return redirect()->route('admin.buku.index', ['page' => $page])
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────
    // DESTROY — Hapus buku
    // URL: DELETE /admin/buku/{id}
    // ──────────────────────────────────────────────
    public function destroy(Buku $buku)
    {
        // Hapus file cover dari storage jika ada
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        
        $buku->delete(); // Hapus dari database

        $page = request('page', 1);
        return redirect()->route('admin.buku.index', ['page' => $page])
            ->with('success', 'Buku berhasil dihapus.');
    }
}
```

### 9.2 View: Daftar Buku (`admin/buku/index.blade.php`)

Halaman ini menampilkan buku seperti rak buku fisik. Buku ditampilkan sebagai "buku" dengan:
- Lampu sorot di atas
- Animasi buku terangkat saat hover
- Popup info (judul, pengarang, stok, tombol aksi) saat buku di-hover
- Di mobile: klik untuk buka modal

```php
@extends('layouts.app')
@section('title', 'Data Buku')
@section('page-title', 'Data Buku')

@section('content')
{{-- Toolbar: tombol tambah + form pencarian --}}
<div class="toolbar">
    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Buku
    </a>
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari judul, pengarang...">
        <select name="kategori">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                    {{ $kat }}
                </option>
            @endforeach
        </select>
        <button type="submit">Cari</button>
    </form>
</div>

{{-- Daftar buku (rak buku) --}}
<div class="book-grid">
    @foreach($buku as $b)
    <div class="book-card">
        <div class="book-cover">
            @if($b->cover)
                <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}">
            @else
                {{-- Placeholder jika tidak ada cover --}}
                <div class="book-ph g{{ $loop->index % 8 }}">
                    <i class="bi bi-book p-ico"></i>
                    <div class="p-ttl">{{ $b->judul }}</div>
                    <div class="p-ath">{{ $b->pengarang }}</div>
                </div>
            @endif
        </div>
        <div class="book-body">
            <div class="book-cat">{{ $b->kategori }}</div>
            <div class="book-title">{{ $b->judul }}</div>
            <div class="book-author">{{ $b->pengarang }}</div>
            <div class="book-footer">
                {{-- Tombol aksi --}}
                <a href="{{ route('admin.buku.show', $b) }}" class="btn btn-ico bv">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('admin.buku.edit', $b) }}" class="btn btn-ico be">
                    <i class="bi bi-pencil"></i>
                </a>
                <form method="POST" action="{{ route('admin.buku.destroy', $b) }}"
                      onsubmit="return confirm('Hapus buku ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ico bd">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="dt-pager">
    {{ $buku->links() }}
</div>
@endsection
```

### 9.3 View: Form Tambah Buku (`admin/buku/create.blade.php`)

```php
@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')

@section('content')
<form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
    {{-- CSRF token wajib ada di setiap form POST --}}
    @csrf

    <div class="form-card">
        {{-- Identitas Buku --}}
        <div class="row g-3">
            <div class="col-md-4">
                <label class="lbl">Kode Buku <span class="req">*</span></label>
                <input type="text" name="kode_buku" class="inp" 
                       value="{{ old('kode_buku') }}" placeholder="BK001" required>
                {{-- old('kode_buku') = isi ulang jika form gagal divalidasi --}}
                @error('kode_buku')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-8">
                <label class="lbl">Judul Buku <span class="req">*</span></label>
                <input type="text" name="judul" class="inp" 
                       value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="lbl">Pengarang <span class="req">*</span></label>
                <input type="text" name="pengarang" class="inp" value="{{ old('pengarang') }}" required>
            </div>

            <div class="col-md-6">
                <label class="lbl">Penerbit <span class="req">*</span></label>
                <input type="text" name="penerbit" class="inp" value="{{ old('penerbit') }}" required>
            </div>

            <div class="col-md-4">
                <label class="lbl">Tahun Terbit <span class="req">*</span></label>
                <input type="number" name="tahun_terbit" class="inp" 
                       value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}">
            </div>

            <div class="col-md-4">
                <label class="lbl">Kategori <span class="req">*</span></label>
                <input type="text" name="kategori" class="inp" value="{{ old('kategori') }}">
            </div>

            <div class="col-md-4">
                <label class="lbl">Stok <span class="req">*</span></label>
                <input type="number" name="stok" class="inp" value="{{ old('stok', 1) }}" min="0">
            </div>
        </div>

        {{-- Cover & Deskripsi --}}
        <div class="mt-4">
            <label class="lbl">Cover Buku</label>
            <input type="file" name="cover" accept="image/*" 
                   onchange="previewCover(this)">
            {{-- Preview gambar sebelum diupload --}}
            <img id="coverPreview" style="display:none;max-height:200px">
        </div>

        <div class="mt-3">
            <label class="lbl">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Status Launching --}}
        <div class="mt-3">
            <label class="lbl">Status <span class="req">*</span></label>
            <select name="status_launching" class="sel" onchange="toggleTanggalRilis(this)">
                <option value="tersedia">Tersedia</option>
                <option value="segera">Segera Hadir</option>
            </select>
        </div>

        <div id="tanggalRilisWrap" style="display:none" class="mt-3">
            <label class="lbl">Tanggal Rilis</label>
            <input type="date" name="tanggal_rilis" class="inp" min="{{ date('Y-m-d') }}">
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Simpan Buku
        </button>
        <a href="{{ route('admin.buku.index') }}" class="btn btn-ghost">Batal</a>
    </div>
</form>

<script>
// Preview gambar cover sebelum upload
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('coverPreview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Tampilkan/sembunyikan field tanggal rilis
function toggleTanggalRilis(select) {
    const wrap = document.getElementById('tanggalRilisWrap');
    wrap.style.display = select.value === 'segera' ? 'block' : 'none';
}
</script>
@endsection
```

### 9.4 View: Form Edit Buku (`admin/buku/edit.blade.php`)

Mirip dengan create, perbedaannya:
1. Form action mengarah ke `route('admin.buku.update', $buku)` 
2. Wajib ada `@method('PUT')` karena browser hanya support GET dan POST
3. Semua field pre-filled dengan data buku yang ada
4. Menampilkan preview cover yang sudah ada

```php
@extends('layouts.app')
@section('title', 'Edit Buku')
@section('page-title', 'Edit Buku')

@section('content')
<form method="POST" action="{{ route('admin.buku.update', $buku) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')  {{-- ← WAJIB ada untuk UPDATE --}}

    {{-- Hidden input untuk simpan nomor halaman agar setelah save kembali ke halaman yang sama --}}
    <input type="hidden" name="page" value="{{ request('page', 1) }}">

    <div class="form-card">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="lbl">Kode Buku <span class="req">*</span></label>
                {{-- old() mengambil nilai lama jika form gagal; fallback ke $buku->kode_buku --}}
                <input type="text" name="kode_buku" class="inp" 
                       value="{{ old('kode_buku', $buku->kode_buku) }}" required>
                @error('kode_buku')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- ... field lainnya sama, semua value="{{ old('field', $buku->field) }}" --}}

            <div class="col-md-4">
                <label class="lbl">Stok</label>
                <input type="number" name="stok" class="inp" 
                       value="{{ old('stok', $buku->stok) }}" min="0">
            </div>
        </div>

        {{-- Cover existing --}}
        <div class="mt-4">
            <label class="lbl">Cover Buku</label>
            @if($buku->cover)
                <div>
                    <p>Cover saat ini:</p>
                    <img src="{{ Storage::url($buku->cover) }}" style="max-height:150px">
                </div>
            @endif
            <input type="file" name="cover" accept="image/*">
            <small>Biarkan kosong jika tidak ingin mengganti cover</small>
        </div>
    </div>

    <button type="submit" class="btn btn-gold">
        <i class="bi bi-check-lg"></i> Perbarui Buku
    </button>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-ghost">Batal</a>
</form>
@endsection
```

---

## 10. CRUD Anggota

### 10.1 Controller: `AnggotaController.php`

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    // ──────────────────────────────────────────────
    // INDEX — Daftar semua anggota
    // URL: GET /admin/anggota
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Anggota::with('user'); // eager load data user sekaligus

        // Pencarian berdasarkan nama, NIS, atau kelas
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama',  'like', "%{$q}%")
                   ->orWhere('nis',   'like', "%{$q}%")
                   ->orWhere('kelas', 'like', "%{$q}%");
            });
        }

        // Filter status aktif/nonaktif
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $anggota = $query->latest()->paginate(10)->withQueryString();

        return view('admin.anggota.index', compact('anggota'));
    }

    // ──────────────────────────────────────────────
    // CREATE — Form tambah anggota baru
    // URL: GET /admin/anggota/create
    // ──────────────────────────────────────────────
    public function create()
    {
        return view('admin.anggota.create');
    }

    // ──────────────────────────────────────────────
    // STORE — Simpan anggota baru
    // URL: POST /admin/anggota
    // ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            // ↑ email harus unik di tabel users
            'password' => 'required|min:6',
            'nis'      => 'required|string|unique:anggota,nis',
            // ↑ NIS harus unik di tabel anggota
            'kelas'    => 'required|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:20',
            'status'   => 'required|in:aktif,nonaktif',
            'foto'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // LANGKAH 1: Buat akun login (User)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // hash password
            'role'     => 'siswa', // anggota yang ditambah admin selalu role siswa
        ]);

        // LANGKAH 2: Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('anggota', 'public');
        }

        // LANGKAH 3: Buat data anggota yang terhubung ke User
        Anggota::create([
            'user_id' => $user->id, // ← hubungkan ke User yang baru dibuat
            'nis'     => $request->nis,
            'nama'    => $request->name,
            'kelas'   => $request->kelas,
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
            'foto'    => $fotoPath,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    // ──────────────────────────────────────────────
    // SHOW — Detail satu anggota beserta riwayat pinjam
    // URL: GET /admin/anggota/{id}
    // ──────────────────────────────────────────────
    public function show(Anggota $anggotum)
    {
        // Load relasi peminjaman berikut data bukunya
        $anggotum->load(['peminjaman.buku']);
        return view('admin.anggota.show', ['anggota' => $anggotum]);
    }

    // ──────────────────────────────────────────────
    // EDIT — Form edit anggota
    // URL: GET /admin/anggota/{id}/edit
    // ──────────────────────────────────────────────
    public function edit(Anggota $anggotum)
    {
        return view('admin.anggota.edit', ['anggota' => $anggotum]);
    }

    // ──────────────────────────────────────────────
    // UPDATE — Simpan perubahan anggota
    // URL: PUT /admin/anggota/{id}
    // ──────────────────────────────────────────────
    public function update(Request $request, Anggota $anggotum)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email,' . $anggotum->user_id,
            // ↑ unique tapi KECUALI user ini sendiri (berdasarkan user_id)
            'nis'     => 'required|string|unique:anggota,nis,' . $anggotum->id,
            'kelas'   => 'required|string|max:20',
            'alamat'  => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'status'  => 'required|in:aktif,nonaktif',
            'foto'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Update data di tabel users (nama + email)
        $anggotum->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update password hanya jika diisi (opsional saat edit)
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $anggotum->user->update(['password' => Hash::make($request->password)]);
        }

        // Handle foto
        $fotoPath = $anggotum->foto; // simpan path foto lama

        // Jika checkbox "hapus foto" dicentang
        if ($request->has('hapus_foto')) {
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath); // hapus file dari disk
            }
            $fotoPath = null;
        }

        // Jika ada foto baru diupload
        if ($request->hasFile('foto')) {
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath); // hapus foto lama dulu
            }
            $fotoPath = $request->file('foto')->store('anggota', 'public');
        }

        // Update data di tabel anggota
        $anggotum->update([
            'nis'     => $request->nis,
            'nama'    => $request->name,
            'kelas'   => $request->kelas,
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
            'foto'    => $fotoPath,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────
    // DESTROY — Hapus anggota
    // URL: DELETE /admin/anggota/{id}
    // ──────────────────────────────────────────────
    public function destroy(Anggota $anggotum)
    {
        // Hapus foto dari storage jika ada
        if ($anggotum->foto && \Storage::disk('public')->exists($anggotum->foto)) {
            \Storage::disk('public')->delete($anggotum->foto);
        }

        $user = $anggotum->user; // simpan referensi user

        $anggotum->delete(); // hapus data anggota dulu
        $user->delete();     // lalu hapus akun login-nya

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
```

> **Mengapa ada dua langkah saat tambah/hapus anggota?**
> Karena sistem memisahkan data login (`users`) dan data profil (`anggota`) di tabel berbeda. Saat menambah anggota, kita perlu buat User (untuk login) sekaligus Anggota (untuk profil). Saat menghapus, keduanya harus dihapus.

---

## 11. Transaksi Peminjaman & Pengembalian

### 11.1 Controller: `TransaksiController.php`

```php
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
    // ──────────────────────────────────────────────
    // INDEX — Daftar semua transaksi
    // URL: GET /admin/transaksi
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku']);

        // Pencarian di kode pinjam, nama anggota, NIS, dan judul buku
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('kode_pinjam', 'like', "%{$q}%")
                   ->orWhereHas('anggota', function($a) use ($q) {
                       $a->where('nama', 'like', "%{$q}%")
                         ->orWhere('nis',  'like', "%{$q}%");
                   })
                   ->orWhereHas('buku', function($b) use ($q) {
                       $b->where('judul', 'like', "%{$q}%");
                   });
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ⚠️ UPDATE OTOMATIS STATUS TERLAMBAT
        // Setiap kali halaman ini dibuka, cek semua peminjaman aktif
        // yang sudah melewati tanggal kembali → ubah status jadi "terlambat"
        Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali_rencana', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

        $transaksi = $query->latest()->paginate(10)->withQueryString();

        return view('admin.transaksi.index', compact('transaksi'));
    }

    // ──────────────────────────────────────────────
    // CREATE — Form buat transaksi peminjaman baru
    // URL: GET /admin/transaksi/create
    // ──────────────────────────────────────────────
    public function create()
    {
        // Hanya tampilkan anggota aktif dan buku yang masih ada stok
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku    = Buku::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('anggota', 'buku'));
    }

    // ──────────────────────────────────────────────
    // STORE — Simpan transaksi peminjaman baru
    // URL: POST /admin/transaksi
    // ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'              => 'required|exists:anggota,id',
            'buku_id'                 => 'required|exists:buku,id',
            'tanggal_pinjam'          => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Validasi stok (cek ulang di server, bukan hanya di form)
        if ($buku->stok < 1) {
            return back()->withErrors(['buku_id' => 'Stok buku tidak tersedia.'])->withInput();
        }

        // Cegah peminjaman duplikat: anggota yang sama tidak boleh meminjam
        // buku yang sama jika belum dikembalikan
        $sudahPinjam = Peminjaman::where('anggota_id', $request->anggota_id)
            ->where('buku_id', $request->buku_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sudahPinjam) {
            return back()
                ->withErrors(['buku_id' => 'Anggota masih meminjam buku ini.'])
                ->withInput();
        }

        // Buat kode transaksi unik
        $kode = 'TRX-' . strtoupper(uniqid());
        // Contoh hasil: TRX-6745A8B2C1234

        // Simpan transaksi
        Peminjaman::create([
            'kode_pinjam'             => $kode,
            'anggota_id'              => $request->anggota_id,
            'buku_id'                 => $request->buku_id,
            'tanggal_pinjam'          => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'status'                  => 'dipinjam',
        ]);

        // Kurangi stok buku sebesar 1
        $buku->decrement('stok');

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi peminjaman berhasil dibuat.');
    }

    // ──────────────────────────────────────────────
    // SHOW — Detail satu transaksi
    // URL: GET /admin/transaksi/{id}
    // ──────────────────────────────────────────────
    public function show(Peminjaman $transaksi)
    {
        $transaksi->load(['anggota', 'buku']);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    // ──────────────────────────────────────────────
    // EDIT — Form edit transaksi
    // URL: GET /admin/transaksi/{id}/edit
    // ──────────────────────────────────────────────
    public function edit(Peminjaman $transaksi)
    {
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku    = Buku::all();
        return view('admin.transaksi.edit', compact('transaksi', 'anggota', 'buku'));
    }

    // ──────────────────────────────────────────────
    // UPDATE — Edit tanggal kembali / keterangan
    // URL: PUT /admin/transaksi/{id}
    // ──────────────────────────────────────────────
    public function update(Request $request, Peminjaman $transaksi)
    {
        $request->validate([
            'tanggal_kembali_rencana' => 'required|date',
            'keterangan'              => 'nullable|string',
        ]);

        // Hanya dua field yang boleh diubah lewat form edit biasa
        $transaksi->update([
            'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
            'keterangan'              => $request->keterangan,
        ]);

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────
    // PENGEMBALIAN — Proses buku dikembalikan
    // URL: POST /admin/transaksi/{id}/kembali
    // ──────────────────────────────────────────────
    public function pengembalian(Peminjaman $transaksi)
    {
        // Guard: cegah proses jika sudah dikembalikan sebelumnya
        if ($transaksi->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $tanggalKembali = Carbon::today(); // tanggal hari ini
        $denda = 0;

        // Hitung denda jika terlambat
        if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
            // gt() = "greater than" = lebih baru dari
            $selisih = $transaksi->tanggal_kembali_rencana->diffInDays($tanggalKembali);
            $denda   = $selisih * 1000; // Rp 1.000 per hari
        }

        // Update status transaksi
        $transaksi->update([
            'tanggal_kembali_aktual' => $tanggalKembali,
            'status'                 => 'dikembalikan',
            'denda'                  => $denda,
        ]);

        // Kembalikan stok buku sebesar 1
        $transaksi->buku->increment('stok');

        $dendaFormatted = number_format($denda, 0, ',', '.');
        return redirect()->route('admin.transaksi.index')
            ->with('success', "Pengembalian berhasil. Denda: Rp {$dendaFormatted}");
    }

    // ──────────────────────────────────────────────
    // DESTROY — Hapus transaksi
    // URL: DELETE /admin/transaksi/{id}
    // ──────────────────────────────────────────────
    public function destroy(Peminjaman $transaksi)
    {
        // Jika buku belum dikembalikan, kembalikan stok dulu
        if (in_array($transaksi->status, ['dipinjam', 'terlambat'])) {
            $transaksi->buku->increment('stok');
        }

        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
```

### 11.2 Form Pengembalian (di halaman show/index)

Pengembalian dilakukan lewat form POST sederhana karena tidak perlu input apapun dari admin — sistem otomatis menghitung denda berdasarkan tanggal:

```php
{{-- Di views/admin/transaksi/show.blade.php --}}
@if(in_array($transaksi->status, ['dipinjam', 'terlambat']))
<form method="POST" action="{{ route('admin.transaksi.kembali', $transaksi) }}"
      onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
    @csrf
    {{-- Tidak ada @method() karena route ini menggunakan POST --}}
    <button type="submit" class="btn btn-success">
        <i class="bi bi-box-arrow-in-left"></i> Proses Pengembalian
    </button>
</form>
@endif
```

---

## 12. Alur Kerja Lengkap

### Alur Tambah Buku Baru

```
1. Admin klik "Tambah Buku"
   → Browser: GET /admin/buku/create

2. BukuController@create dipanggil
   → Tampilkan form kosong (admin.buku.create)

3. Admin isi form + klik "Simpan"
   → Browser: POST /admin/buku (kirim data + file cover)

4. BukuController@store dipanggil
   ├─ Validasi semua input
   ├─ Jika gagal → kembali ke form dengan pesan error
   ├─ Upload cover ke storage/app/public/covers/
   ├─ Buku::create($data) → simpan ke database
   └─ Redirect ke /admin/buku dengan pesan "Buku berhasil ditambahkan"
```

### Alur Edit Buku

```
1. Admin klik tombol Edit di kartu buku
   → Browser: GET /admin/buku/{id}/edit

2. BukuController@edit dipanggil
   ├─ Laravel otomatis cari Buku berdasarkan ID (Route Model Binding)
   └─ Tampilkan form terisi data buku (admin.buku.edit)

3. Admin ubah data + klik "Perbarui"
   → Browser: POST /admin/buku/{id} dengan _method=PUT

4. BukuController@update dipanggil
   ├─ Validasi
   ├─ Jika ada cover baru: hapus lama, simpan baru
   ├─ $buku->update($data)
   └─ Redirect ke halaman yang sama
```

### Alur Hapus Buku

```
1. Admin klik tombol Hapus
   → Muncul dialog konfirmasi JavaScript (confirm())

2. Jika konfirmasi "OK":
   → Browser: POST /admin/buku/{id} dengan _method=DELETE

3. BukuController@destroy dipanggil
   ├─ Hapus file cover dari storage (jika ada)
   ├─ $buku->delete()
   └─ Redirect dengan pesan sukses
```

### Alur Peminjaman Buku

```
1. Admin klik "Tambah Peminjaman"
   → GET /admin/transaksi/create

2. TransaksiController@create
   ├─ Ambil anggota aktif
   ├─ Ambil buku dengan stok > 0
   └─ Tampilkan form (admin.transaksi.create)

3. Admin pilih anggota, pilih buku, isi tanggal → submit
   → POST /admin/transaksi

4. TransaksiController@store
   ├─ Validasi input
   ├─ Cek stok buku (server-side)
   ├─ Cek apakah anggota sudah pinjam buku yang sama
   ├─ Generate kode: TRX-XXXXXXXX
   ├─ Peminjaman::create(...)
   ├─ $buku->decrement('stok')  ← stok dikurangi 1
   └─ Redirect sukses
```

### Alur Pengembalian Buku

```
1. Admin klik "Proses Pengembalian" di halaman transaksi

2. TransaksiController@pengembalian dipanggil
   ├─ Cek: sudah dikembalikan? Jika ya → error
   ├─ Hitung keterlambatan: Carbon::today() vs tanggal_kembali_rencana
   ├─ Hitung denda: selisih_hari × Rp 1.000
   ├─ Update: status='dikembalikan', tanggal_kembali_aktual=hari ini, denda=X
   ├─ $transaksi->buku->increment('stok')  ← stok dikembalikan
   └─ Redirect dengan info denda
```

---

## Ringkasan Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Backend framework | Laravel 12 |
| Template engine | Blade (bawaan Laravel) |
| Database | MySQL |
| ORM (query builder) | Eloquent |
| CSS framework | Bootstrap 5.3 |
| Icons | Bootstrap Icons 1.11 |
| Font | Inter + Playfair Display (Google Fonts) |
| File storage | Laravel Storage (public disk) |
| Date/time | Carbon (bawaan Laravel) |

---

*Dokumen ini menjelaskan pembangunan halaman admin dari awal — database, model, middleware, routes, controllers, hingga views — lengkap dengan kode dan penjelasannya.*

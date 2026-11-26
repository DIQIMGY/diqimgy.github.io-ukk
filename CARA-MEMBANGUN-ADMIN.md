# 🛠️ CARA MEMBANGUN HALAMAN ADMIN
## Penjelasan Urut: Dari Nol Sampai Bisa Berfungsi
### Aplikasi Peminjaman Buku — Perpustakaan Sekolah Digital

---

> **Dokumen ini menjelaskan PROSES dan CARA KERJA** — bukan sekadar daftar kode.
> Kamu akan paham kenapa tiap bagian dibuat, bagaimana mereka saling terhubung,
> dan mengapa tampilan bisa muncul dan tombol bisa berfungsi.

---

## CARA BACA DOKUMEN INI

Bayangkan kamu membangun sebuah kantin sekolah dari nol:
- **Database** = gudang penyimpanan bahan makanan
- **Model** = daftar katalog apa saja yang ada di gudang
- **Controller** = koki yang mengambil bahan, mengolah, lalu menyajikan
- **View (blade)** = piring sajian yang dilihat pelanggan
- **Routes** = papan petunjuk jalan ke kantin
- **Middleware** = satpam pintu masuk

Semua bagian saling butuh satu sama lain. Kalau satu bagian hilang, sistem tidak bisa jalan.

---

## DAFTAR ISI

**BAGIAN 1 — FONDASI**
- [Step 1: Membuat Database & Tabel](#step-1-membuat-database--tabel)
- [Step 2: Membuat Model](#step-2-membuat-model)
- [Step 3: Membuat Middleware (Penjaga Pintu)](#step-3-membuat-middleware-penjaga-pintu)
- [Step 4: Mendaftarkan Routes (Peta URL)](#step-4-mendaftarkan-routes-peta-url)

**BAGIAN 2 — KERANGKA TAMPILAN**
- [Step 5: Membuat Layout Utama](#step-5-membuat-layout-utama)
- [Step 6: Sidebar Terhubung ke Siapa yang Login](#step-6-sidebar-terhubung-ke-siapa-yang-login)

**BAGIAN 3 — DASHBOARD**
- [Step 7: Dashboard Admin — Dari Query ke Tampilan](#step-7-dashboard-admin)

**BAGIAN 4 — CRUD BUKU**
- [Step 8: CRUD Buku — Konsep Dasar](#step-8-crud-buku--konsep-dasar)
- [Step 9: Menampilkan Daftar Buku (Read)](#step-9-menampilkan-daftar-buku-read)
- [Step 10: Form Tambah Buku (Create)](#step-10-form-tambah-buku-create)
- [Step 11: Menyimpan Buku ke Database (Store)](#step-11-menyimpan-buku-ke-database-store)
- [Step 12: Edit dan Update Buku](#step-12-edit-dan-update-buku)
- [Step 13: Menghapus Buku](#step-13-menghapus-buku)

**BAGIAN 5 — CRUD ANGGOTA**
- [Step 14: Kenapa Anggota Berbeda dari Buku](#step-14-kenapa-anggota-berbeda-dari-buku)
- [Step 15: Tambah Anggota — Dua Tabel Sekaligus](#step-15-tambah-anggota--dua-tabel-sekaligus)
- [Step 16: Edit dan Hapus Anggota](#step-16-edit-dan-hapus-anggota)

**BAGIAN 6 — TRANSAKSI**
- [Step 17: Peminjaman — Logika Bisnis](#step-17-peminjaman--logika-bisnis)
- [Step 18: Pengembalian dan Hitung Denda](#step-18-pengembalian-dan-hitung-denda)

**BAGIAN 7 — NYAMBUNGIN SEMUANYA**
- [Step 19: Bagaimana Data Mengalir dari Klik ke Database](#step-19-bagaimana-data-mengalir-dari-klik-ke-database)
- [Step 20: Pencarian — Bagaimana Filter Bekerja](#step-20-pencarian--bagaimana-filter-bekerja)

---

---

# BAGIAN 1 — FONDASI

---

## Step 1: Membuat Database & Tabel

Sebelum kode apapun bisa berjalan, kita butuh tempat menyimpan data.
Di Laravel, kita tidak buat tabel langsung di database — kita tulis **migration**.

### Apa itu Migration?

Migration adalah file PHP yang berisi instruksi "bikin tabel ini dengan kolom-kolom ini".
Keuntungannya: bisa di-version control (git), bisa dibatalkan, bisa diulang di komputer lain.

Jalankan perintah ini untuk buat file migration:
```bash
php artisan make:migration create_buku_table
```

Laravel akan buat file di `database/migrations/` dengan nama seperti:
`2025_01_01_000020_create_buku_table.php`

### Migration Tabel `buku`

```php
// database/migrations/2025_01_01_000020_create_buku_table.php

public function up(): void
{
    Schema::create('buku', function (Blueprint $table) {
        $table->id();                          // kolom "id" auto increment (1, 2, 3, ...)
        $table->string('kode_buku')->unique(); // teks, tidak boleh sama antar baris
        $table->string('judul');
        $table->string('pengarang');
        $table->string('penerbit');
        $table->year('tahun_terbit');
        $table->string('kategori');
        $table->integer('stok')->default(1);   // angka, nilai awal = 1
        $table->string('cover')->nullable();   // boleh kosong (null)
        $table->text('deskripsi')->nullable(); // teks panjang, boleh kosong
        $table->enum('status_launching', ['tersedia', 'segera'])->default('tersedia');
        $table->date('tanggal_rilis')->nullable();
        $table->timestamps(); // otomatis buat "created_at" dan "updated_at"
    });
}
```

Jalankan migration untuk membuat tabel di database:
```bash
php artisan migrate
```

### Kenapa perlu `user_id` di tabel `anggota`?

Tabel `anggota` punya kolom `user_id` yang merujuk ke tabel `users`:

```php
// Tabel anggota
$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
```

Ini namanya **foreign key** — penghubung antar tabel.
Artinya: setiap baris di tabel `anggota` dimiliki oleh satu baris di tabel `users`.

```
Tabel users:                    Tabel anggota:
┌────┬────────┬───────┐         ┌────┬─────────┬─────────┬───────────┐
│ id │ email  │ role  │         │ id │ user_id │ nis     │ nama      │
├────┼────────┼───────┤         ├────┼─────────┼─────────┼───────────┤
│  1 │ a@b.id │ siswa │ ←───────│  1 │    1    │ 2024001 │ Budi      │
│  2 │ c@d.id │ admin │         │  2 │    ?    │ ...     │ ...       │
└────┴────────┴───────┘         └────┴─────────┴─────────┴───────────┘
```

`onDelete('cascade')` = kalau user dihapus, data anggotanya ikut terhapus otomatis.

### Tabel `peminjaman` — Hubungan 3 Tabel

```php
$table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
$table->foreignId('buku_id')->constrained('buku')->onDelete('cascade');
```

Satu baris peminjaman menyimpan:
- **siapa** yang meminjam (anggota_id → merujuk ke tabel anggota)
- **buku apa** yang dipinjam (buku_id → merujuk ke tabel buku)

```
anggota: Budi (id=1)  ──┐
                         ├──→ peminjaman: Budi pinjam buku "Harry Potter" tgl 1 Jan
buku: Harry Potter (id=5) ──┘
```

---

## Step 2: Membuat Model

Setelah tabel ada, kita butuh cara untuk "bicara" dengan tabel tersebut lewat kode PHP. Itulah fungsi **Model**.

Buat model:
```bash
php artisan make:model Buku
```

### Model `Buku`

```php
// app/Models/Buku.php

class Buku extends Model
{
    protected $table = 'buku'; // nama tabel di database (kalau tidak ditulis,
                               // Laravel tebak sendiri: "bukus" — tebakan salah!)

    protected $fillable = [    // kolom mana yang BOLEH diisi lewat create()/update()
        'kode_buku', 'judul', 'pengarang', 'penerbit',
        'tahun_terbit', 'kategori', 'stok', 'cover',
        'deskripsi', 'status_launching', 'tanggal_rilis',
    ];

    // Relasi: 1 buku bisa dipinjam banyak kali (hasMany)
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
        // Artinya: cari semua baris di tabel peminjaman
        // yang buku_id-nya sama dengan id buku ini
    }
}
```

### Kenapa `$fillable` itu penting?

Bayangkan ada orang jahat yang kirim POST request dengan data:
```
kode_buku=BK001&judul=Harry Potter&role=admin
```

Kalau tidak ada `$fillable`, Laravel akan menyimpan kolom `role` juga ke database.
Dengan `$fillable`, hanya kolom yang disebutkan yang bisa diisi — yang lain diabaikan.
Ini namanya proteksi **Mass Assignment**.

### Relasi antar Model

```php
// Buku.php
public function peminjaman()
{
    return $this->hasMany(Peminjaman::class);
    // Buku punya BANYAK peminjaman
}

// Peminjaman.php
public function buku()
{
    return $this->belongsTo(Buku::class);
    // Peminjaman MILIK SATU buku
}

public function anggota()
{
    return $this->belongsTo(Anggota::class);
    // Peminjaman MILIK SATU anggota
}

// Anggota.php
public function user()
{
    return $this->belongsTo(User::class);
    // Anggota MILIK SATU user (akun login)
}

public function peminjaman()
{
    return $this->hasMany(Peminjaman::class);
    // Anggota punya BANYAK peminjaman
}
```

Dengan relasi ini, kita bisa akses data terkait dengan mudah:
```php
$peminjaman->buku->judul      // judul buku dari sebuah transaksi
$peminjaman->anggota->nama    // nama anggota dari sebuah transaksi
$anggota->peminjaman->count() // total peminjaman seorang anggota
$buku->peminjaman->count()    // berapa kali buku ini dipinjam
```

---

## Step 3: Membuat Middleware (Penjaga Pintu)

Halaman admin tidak boleh dibuka sembarang orang.
**Middleware** adalah kode yang berjalan sebelum request masuk ke halaman — seperti satpam.

```bash
php artisan make:middleware AdminMiddleware
```

```php
// app/Http/Middleware/AdminMiddleware.php

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek 1: sudah login?
        // Cek 2: rolenya admin?
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403); // tampilkan halaman error "Forbidden"
        }

        // Kalau lolos, teruskan request ke tujuan semula
        return $next($request);
    }
}
```

`auth()->check()` = apakah ada sesi login aktif?
`auth()->user()->isAdmin()` = method dari model User yang mengecek `$this->role === 'admin'`

### Mendaftarkan Middleware

Middleware tidak aktif sampai didaftarkan di `bootstrap/app.php`:

```php
// bootstrap/app.php

->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
    ]);
})
```

Sekarang kita bisa pakai kata kunci `'admin'` di routes untuk memanggil middleware ini.

---

## Step 4: Mendaftarkan Routes (Peta URL)

Routes adalah daftar URL yang bisa dikunjungi beserta controller yang menanganinya.
Tanpa route, URL apapun akan menghasilkan error 404.

```php
// routes/web.php

// Semua route admin dibungkus dalam satu group:
Route::prefix('admin')          // semua URL diawali /admin/
     ->name('admin.')           // semua nama route diawali admin.
     ->middleware(['auth', 'admin']) // wajib login + wajib role admin
     ->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
         ->name('dashboard');
    // ↑ Penjelasan:
    // - GET /admin/dashboard → panggil method index() di DashboardController
    // - Nama route: 'admin.dashboard' (dipakai di blade: route('admin.dashboard'))

    Route::resource('buku', Admin\BukuController::class);
    // ↑ Satu baris ini otomatis buat 7 route sekaligus!
    // GET    /admin/buku              → index()   → admin.buku.index
    // GET    /admin/buku/create       → create()  → admin.buku.create
    // POST   /admin/buku              → store()   → admin.buku.store
    // GET    /admin/buku/{buku}       → show()    → admin.buku.show
    // GET    /admin/buku/{buku}/edit  → edit()    → admin.buku.edit
    // PUT    /admin/buku/{buku}       → update()  → admin.buku.update
    // DELETE /admin/buku/{buku}       → destroy() → admin.buku.destroy
});
```

### Kenapa Anggota Tidak Pakai `Route::resource`?

```php
// Manual routes untuk anggota — pakai {anggotum} bukan {anggota}
Route::get('/anggota/{anggotum}', [AnggotaController::class, 'show'])->name('anggota.show');
```

Nama parameter `{anggotum}` dipakai karena kalau pakai `{anggota}`, Laravel bingung —
nama itu sama dengan nama tabel `anggota`. Dengan `{anggotum}`, Laravel tetap bisa
menemukan data yang tepat karena kita type-hint di controller:

```php
// Di controller, type-hint ini yang menghubungkan:
public function show(Anggota $anggotum)
{              // ↑ type Anggota, nama param $anggotum
    // Laravel baca URL /admin/anggota/5
    // Lalu cari: Anggota::find(5)
    // Hasilnya disimpan di $anggotum
}
```

Ini disebut **Route Model Binding** — Laravel otomatis ambil data dari database
berdasarkan ID di URL, tanpa kita perlu tulis `Anggota::find($id)` sendiri.

---

---

# BAGIAN 2 — KERANGKA TAMPILAN

---

## Step 5: Membuat Layout Utama

Semua halaman admin punya struktur yang sama: sidebar, topbar, area konten.
Kalau kita copy-paste struktur ini ke setiap halaman, saat mau ubah warna sidebar
kita harus buka puluhan file. Tidak efisien.

Solusinya: buat satu file layout yang jadi "kerangka induk".

```bash
# Buat file:
resources/views/layouts/app.blade.php
```

Isi file ini adalah HTML lengkap dengan "lubang" untuk konten:

```html
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Perpustakaan')</title>
    <!--           ↑ "lubang" untuk judul halaman -->
    <!-- Load CSS Bootstrap, Font, Icons... -->
    <style>/* semua CSS design system */</style>
</head>
<body>
<div class="app-wrap">

    <!-- SIDEBAR — muncul di semua halaman -->
    <nav class="sidebar">
        <!-- Logo, user info, menu navigasi -->
    </nav>

    <!-- KONTEN UTAMA -->
    <div class="app-main">
        <!-- TOPBAR — muncul di semua halaman -->
        <header class="topbar">
            <span>@yield('page-title', 'Dashboard')</span>
            <!--       ↑ "lubang" untuk judul di topbar -->
        </header>

        <!-- FLASH MESSAGES — notifikasi sukses/error -->
        @if(session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        <!-- ISI HALAMAN — diisi tiap halaman -->
        <main class="app-content">
            @yield('content')
            <!--   ↑ "lubang" untuk konten halaman -->
        </main>
    </div>

</div>
</body>
</html>
```

### Cara Halaman Admin Menggunakan Layout

Setiap halaman admin cukup "extends" layout ini dan mengisi "lubang"-nya:

```php
{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')
{{--       ↑ pakai kerangka dari layouts/app.blade.php --}}

@section('title', 'Dashboard Admin')
{{--               ↑ isi lubang @yield('title') --}}

@section('page-title', 'Dashboard Admin')
{{--                    ↑ isi lubang @yield('page-title') --}}

@section('content')
{{--               ↑ mulai mengisi lubang @yield('content') --}}

    <div>Ini konten dashboard</div>

@endsection
{{-- ↑ selesai mengisi lubang --}}
```

Hasilnya: browser menerima HTML lengkap dengan sidebar + topbar + konten dashboard.
Semua itu dari DUA file yang digabungkan Laravel secara otomatis.

---

## Step 6: Sidebar Terhubung ke Siapa yang Login

Sidebar menampilkan menu yang berbeda untuk admin dan siswa.
Ini menggunakan data dari sesi login yang aktif:

```php
{{-- Di layouts/app.blade.php --}}

{{-- Tampilkan nama pengguna yang sedang login --}}
<div class="sb-uname">{{ Str::limit(auth()->user()->name, 18) }}</div>

{{-- Tampilkan badge berbeda sesuai role --}}
@if(auth()->user()->isAdmin())
    <span class="sb-badge sb-badge-admin">Admin</span>
@else
    <span class="sb-badge sb-badge-siswa">Siswa</span>
@endif

{{-- Tampilkan menu yang sesuai --}}
@if(auth()->user()->isAdmin())
    {{-- Menu khusus admin --}}
    <a href="{{ route('admin.dashboard') }}" class="sb-item
        {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        {{--                                         ↑ kalau URL ini sedang aktif,
                                                        tambahkan class 'active' --}}
        Dashboard
    </a>
    <a href="{{ route('admin.buku.index') }}" class="sb-item
        {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
        {{--                                    ↑ active untuk semua URL admin.buku.xxx --}}
        Data Buku
    </a>
@else
    {{-- Menu khusus siswa --}}
    <a href="{{ route('siswa.dashboard') }}" class="sb-item ...">Dashboard</a>
    <a href="{{ route('siswa.peminjaman.create') }}" class="sb-item ...">Pinjam Buku</a>
@endif
```

Bagaimana `auth()->user()` tahu siapa yang login? Laravel menyimpan ID pengguna
di **session** (data sementara di server) saat login berhasil. Setiap request baru,
Laravel baca session itu dan ambil data User dari database berdasarkan ID tersebut.

---

---

# BAGIAN 3 — DASHBOARD

---

## Step 7: Dashboard Admin

Dashboard menampilkan angka statistik. Prosesnya:

### Langkah 1: Buat Controller

```bash
php artisan make:controller Admin/DashboardController
```

```php
// app/Http/Controllers/Admin/DashboardController.php

class DashboardController extends Controller
{
    public function index()
    {
        // Query ke database untuk ambil angka statistik
        $totalBuku    = Buku::count();     // SELECT COUNT(*) FROM buku
        $totalAnggota = Anggota::count();  // SELECT COUNT(*) FROM anggota

        $totalPinjam  = Peminjaman::where('status', 'dipinjam')->count();
        // SELECT COUNT(*) FROM peminjaman WHERE status = 'dipinjam'

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'totalBuku', 'totalAnggota', 'totalPinjam'
        ));
        // compact() = singkatan dari ['totalBuku' => $totalBuku, ...]
    }
}
```

### Langkah 2: Buat View dan Tampilkan Data

```php
{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')
@section('content')

{{-- Data dari controller langsung bisa dipakai di sini --}}
<div class="stat-card">
    <div class="stat-num">{{ $totalBuku }}</div>
    {{--                      ↑ ini angka yang dikirim dari controller --}}
    <div class="stat-lbl">Total Buku</div>
</div>

<div class="stat-card">
    <div class="stat-num">{{ $totalPinjam }}</div>
    <div class="stat-lbl">Sedang Dipinjam</div>
</div>

@endsection
```

### Bagaimana Data Mengalir dari Database ke Layar?

```
Browser buka URL /admin/dashboard
         ↓
Router: "URL ini → DashboardController@index"
         ↓
DashboardController@index() berjalan:
    - Buku::count() → kirim query ke MySQL → MySQL balas: 42
    - Peminjaman::where('status','dipinjam')->count() → MySQL balas: 7
    - return view('admin.dashboard', [...data...])
         ↓
Laravel ambil file admin/dashboard.blade.php
    - Gabungkan dengan layouts/app.blade.php
    - Isi {{ $totalBuku }} dengan 42
    - Isi {{ $totalPinjam }} dengan 7
    - Hasilkan HTML lengkap
         ↓
HTML dikirim ke browser → Browser render tampilan
```

---

---

# BAGIAN 4 — CRUD BUKU

---

## Step 8: CRUD Buku — Konsep Dasar

**CRUD** = Create (Tambah), Read (Tampilkan), Update (Edit), Delete (Hapus)

Untuk fitur CRUD buku, kita butuh:
1. **Controller** dengan 7 method: index, create, store, show, edit, update, destroy
2. **Route** yang mengarahkan URL ke method yang tepat
3. **Views** untuk setiap halaman

```bash
php artisan make:controller Admin/BukuController --resource
# --resource = otomatis buat 7 method di dalam controller
```

---

## Step 9: Menampilkan Daftar Buku (Read)

### Di Controller

```php
public function index(Request $request)
{
    $query = Buku::query(); // mulai membangun query, belum dieksekusi

    // Tambahkan kondisi filter jika ada input pencarian
    if ($request->filled('search')) {   // filled() = ada isinya (bukan kosong)
        $q = $request->search;          // ambil nilai dari URL: /admin/buku?search=harry
        $query->where(function ($q2) use ($q) {
            $q2->where('judul',     'like', "%{$q}%") // % = karakter apapun
               ->orWhere('pengarang', 'like', "%{$q}%");
        });
    }

    $buku = $query->latest()    // urut dari yang terbaru
                  ->paginate(30) // ambil 30 per halaman, sisanya halaman berikutnya
                  ->withQueryString(); // sertakan parameter URL di link pagination

    return view('admin.buku.index', compact('buku'));
}
```

### Di View

```php
{{-- resources/views/admin/buku/index.blade.php --}}

@foreach($buku as $b)
    {{-- $buku adalah koleksi objek Buku, $b adalah satu buku --}}

    {{-- Tampilkan cover --}}
    @if($b->cover)
        {{-- $b->cover menyimpan PATH file, bukan URL --}}
        {{-- Storage::url() mengubah path → URL yang bisa dibuka browser --}}
        <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}">
    @else
        <div>Tidak ada cover</div>
    @endif

    {{-- Tampilkan judul --}}
    <h3>{{ $b->judul }}</h3>

    {{-- Tombol aksi --}}
    <a href="{{ route('admin.buku.edit', $b) }}">Edit</a>
    {{--                                    ↑ $b akan diambil id-nya otomatis
                                              menghasilkan URL: /admin/buku/5/edit --}}

    <form method="POST" action="{{ route('admin.buku.destroy', $b) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Hapus</button>
    </form>
@endforeach

{{-- Tampilkan tombol navigasi halaman (halaman 1, 2, 3, dst) --}}
{{ $buku->links() }}
```

**Kenapa form hapus perlu `@method('DELETE')`?**

Browser hanya bisa kirim request GET (membuka URL) dan POST (submit form).
Tapi Laravel route untuk hapus menggunakan method DELETE.
Solusinya: tetap pakai form POST, tapi tambahkan hidden input `_method=DELETE`.
Laravel akan baca ini dan menganggap requestnya DELETE.

`@method('DELETE')` adalah shortcut Blade yang menghasilkan:
```html
<input type="hidden" name="_method" value="DELETE">
```

---

## Step 10: Form Tambah Buku (Create)

### Di Controller

```php
public function create()
{
    return view('admin.buku.create');
    // Tidak perlu data apapun — form ini kosong
}
```

### Di View

```php
{{-- resources/views/admin/buku/create.blade.php --}}

{{-- action: ke mana form dikirim saat submit --}}
{{-- method: POST (kirim data baru) --}}
{{-- enctype: WAJIB jika ada upload file --}}
<form method="POST"
      action="{{ route('admin.buku.store') }}"
      enctype="multipart/form-data">

    @csrf
    {{-- ↑ WAJIB ADA. Ini token keamanan.
         Laravel cek token ini untuk memastikan form dikirim dari website kita,
         bukan dari website orang lain (proteksi CSRF) --}}

    <input type="text" name="kode_buku" value="{{ old('kode_buku') }}">
    {{--                                         ↑ old() = isi ulang nilai sebelumnya
                                                   kalau form gagal validasi dan
                                                   dikembalikan ke form ini --}}

    {{-- Tampilkan pesan error untuk field ini jika validasi gagal --}}
    @error('kode_buku')
        <span style="color:red">{{ $message }}</span>
        {{--                       ↑ pesan error dari validator --}}
    @enderror

    <input type="text"   name="judul"      value="{{ old('judul') }}">
    <input type="text"   name="pengarang"  value="{{ old('pengarang') }}">
    <input type="text"   name="penerbit"   value="{{ old('penerbit') }}">
    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}">
    {{--                                                                     ↑ default nilai
                                                                               = tahun sekarang --}}
    <input type="number" name="stok" value="{{ old('stok', 1) }}">

    {{-- Upload file --}}
    <input type="file" name="cover" accept="image/*">

    <textarea name="deskripsi">{{ old('deskripsi') }}</textarea>

    <button type="submit">Simpan</button>
</form>
```

---

## Step 11: Menyimpan Buku ke Database (Store)

Ini adalah proses paling penting — saat admin klik "Simpan", data dikirim ke method ini.

```php
public function store(Request $request)
{
    // LANGKAH 1: VALIDASI
    // Cek apakah data yang dikirim sesuai aturan
    $request->validate([
        'kode_buku' => 'required|string|unique:buku,kode_buku',
        //              ↑         ↑      ↑ cek tabel buku, kolom kode_buku harus unik
        //              wajib diisi      
        'judul'     => 'required|string|max:200',
        'stok'      => 'required|integer|min:0',
        'cover'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        //                        ↑ kalau diisi, harus file gambar, max 2MB
    ]);
    // Kalau validasi GAGAL → Laravel otomatis:
    // 1. Tidak lanjutkan kode di bawah
    // 2. Redirect kembali ke form
    // 3. Kirim pesan error (ditampilkan oleh @error di form)
    // 4. Sertakan data lama (ditampilkan oleh old() di form)

    // LANGKAH 2: SIAPKAN DATA
    $data = $request->except('cover');
    // except() = ambil semua input KECUALI 'cover'
    // kenapa? karena 'cover' perlu diproses terpisah (upload file)

    // LANGKAH 3: UPLOAD FILE (kalau ada)
    if ($request->hasFile('cover')) {
        // Simpan file ke: storage/app/public/covers/namafile.jpg
        // Laravel otomatis beri nama unik supaya tidak bentrok
        $data['cover'] = $request->file('cover')->store('covers', 'public');
        // hasilnya: $data['cover'] = "covers/randomstring.jpg"
    }

    // LANGKAH 4: SIMPAN KE DATABASE
    Buku::create($data);
    // INSERT INTO buku (kode_buku, judul, pengarang, ...) VALUES (?, ?, ?, ...)
    // Eloquent otomatis set created_at dan updated_at

    // LANGKAH 5: REDIRECT DENGAN NOTIFIKASI
    return redirect()->route('admin.buku.index')
        ->with('success', 'Buku berhasil ditambahkan.');
    // ->with() menyimpan pesan di session (sementara)
    // Di layout, session('success') ditampilkan sebagai flash message
}
```

### Kenapa Validasi Bisa Kembali ke Form Dengan Pesan Error?

```
User submit form → store() dipanggil
                 ↓
          $request->validate([...]) gagal
                 ↓
Laravel buang exception ValidationException
                 ↓
Laravel tangkap exception itu secara otomatis
                 ↓
Redirect kembali ke halaman sebelumnya (form)
dengan membawa:
- Error messages (disimpan di session flash)
- Input lama (disimpan di session flash)
                 ↓
Form ditampilkan kembali
@error('kode_buku') menampilkan pesan error
old('kode_buku') mengisi kembali nilai yang sudah diketik
```

---

## Step 12: Edit dan Update Buku

### Perbedaan Create vs Edit

| | Create | Edit |
|---|---|---|
| URL | /admin/buku/create | /admin/buku/{id}/edit |
| Method | GET | GET |
| Form action | route('admin.buku.store') | route('admin.buku.update', $buku) |
| Form method | POST | POST + `@method('PUT')` |
| Field nilai | kosong | terisi data dari database |

### Di Controller

```php
public function edit(Buku $buku)
{
    // $buku sudah otomatis diambil Laravel dari database berdasarkan ID di URL
    // Tidak perlu Buku::find($id) — ini Route Model Binding
    return view('admin.buku.edit', compact('buku'));
}

public function update(Request $request, Buku $buku)
{
    $request->validate([
        'kode_buku' => 'required|unique:buku,kode_buku,' . $buku->id,
        //                                               ↑ ini penting!
        // Kalau kode_buku = "BK001" dan kita edit buku yang PUNYA kode BK001 itu,
        // tanpa ini validasi akan gagal karena "BK001 sudah ada"
        // Dengan tambahan ,{id}, validasi mengecualikan buku ini sendiri
    ]);

    if ($request->hasFile('cover')) {
        // Hapus cover lama sebelum simpan yang baru
        // Kalau tidak dihapus, file lama menumpuk di storage
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $data['cover'] = $request->file('cover')->store('covers', 'public');
    }

    $buku->update($data);
    // UPDATE buku SET judul=?, pengarang=?, ... WHERE id=?
    // Eloquent tahu ini UPDATE (bukan INSERT) karena objek $buku sudah punya ID
}
```

### Di View (form edit)

```php
{{-- Form edit: sama dengan create tapi ada dua perbedaan utama --}}

<form method="POST" action="{{ route('admin.buku.update', $buku) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')  {{-- ← PERBEDAAN 1: ini UPDATE bukan simpan baru --}}

    {{-- PERBEDAAN 2: value terisi data dari database --}}
    <input type="text" name="kode_buku"
           value="{{ old('kode_buku', $buku->kode_buku) }}">
    {{--                               ↑ kalau form belum pernah submit: pakai $buku->kode_buku
                                         kalau form pernah submit dan gagal validasi: pakai old() --}}

    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}">

    {{-- Tampilkan cover yang sudah ada --}}
    @if($buku->cover)
        <p>Cover saat ini:</p>
        <img src="{{ Storage::url($buku->cover) }}" style="max-height:120px">
    @endif
    <input type="file" name="cover">
    <small>Biarkan kosong jika tidak ingin mengganti cover</small>

    <button type="submit">Perbarui</button>
</form>
```

---

## Step 13: Menghapus Buku

```php
public function destroy(Buku $buku)
{
    // Hapus file cover dari storage dulu
    if ($buku->cover) {
        Storage::disk('public')->delete($buku->cover);
        // Kalau tidak dihapus: file gambar masih ada di server
        // tapi tidak bisa diakses karena record di database sudah hilang
    }

    $buku->delete();
    // DELETE FROM buku WHERE id = ?
    // Karena ada foreign key constraint, peminjaman yang merujuk ke buku ini
    // juga ikut terhapus (cascade)

    return redirect()->route('admin.buku.index')
        ->with('success', 'Buku berhasil dihapus.');
}
```

Di view, form hapus hanya tombol:

```php
<form method="POST"
      action="{{ route('admin.buku.destroy', $b) }}"
      onsubmit="return confirm('Yakin hapus buku ini?')">
      {{-- ↑ dialog konfirmasi browser sebelum submit --}}
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```

---

---

# BAGIAN 5 — CRUD ANGGOTA

---

## Step 14: Kenapa Anggota Berbeda dari Buku

Menambah buku = hanya update 1 tabel (`buku`).
Menambah anggota = update 2 tabel sekaligus (`users` + `anggota`).

Kenapa dipisah? Karena sistemnya memisahkan:
- **Credential login** (email, password) → tabel `users`
- **Data personal siswa** (NIS, kelas, foto) → tabel `anggota`

```
Admin isi form tambah anggota:
┌─────────────────────────────────────────────┐
│ Nama    : Budi Santoso                      │
│ Email   : budi@email.com    ← untuk login  │
│ Password: ••••••••          ← untuk login  │
│ NIS     : 2024001           ← data siswa   │
│ Kelas   : XI-RPL-1          ← data siswa   │
└─────────────────────────────────────────────┘

Setelah store():
┌───────────────────────────────┐
│ Tabel users:                  │
│ id=10, email=budi@email.com,  │
│ password=hash, role=siswa     │
└───────────────┬───────────────┘
                │ user_id=10
                ▼
┌───────────────────────────────┐
│ Tabel anggota:                │
│ id=5, user_id=10,             │
│ nis=2024001, nama=Budi,       │
│ kelas=XI-RPL-1                │
└───────────────────────────────┘
```

---

## Step 15: Tambah Anggota — Dua Tabel Sekaligus

```php
public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|unique:users,email',
        //                                      ↑ cek tabel users kolom email
        'password' => 'required|min:6',
        'nis'      => 'required|string|unique:anggota,nis',
        //                                        ↑ cek tabel anggota kolom nis
        'kelas'    => 'required|string|max:20',
        'status'   => 'required|in:aktif,nonaktif',
        'foto'     => 'nullable|image|max:2048',
    ]);

    // LANGKAH 1: Buat akun login di tabel users
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        //           ↑ JANGAN simpan password plain text!
        //             Hash::make() mengubah "rahasia123" → "hashed_string_panjang"
        //             Tidak bisa dibalik, jadi kalau database dicuri, password aman
        'role'     => 'siswa',
    ]);
    // Sekarang $user->id berisi ID yang baru dibuat (misal: 10)

    // LANGKAH 2: Upload foto (opsional)
    $fotoPath = null;
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('anggota', 'public');
    }

    // LANGKAH 3: Buat data profil di tabel anggota
    Anggota::create([
        'user_id' => $user->id, // ← hubungkan ke user yang baru dibuat
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
```

---

## Step 16: Edit dan Hapus Anggota

### Edit — Update Dua Tabel

```php
public function update(Request $request, Anggota $anggotum)
{
    // Validasi email: unik di tabel users, KECUALI user ini sendiri
    // Kalau tidak dikecualikan, edit email tanpa ganti isinya akan gagal
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $anggotum->user_id,
        //                                              ↑ ID yang dikecualikan
        'nis'   => 'required|unique:anggota,nis,' . $anggotum->id,
        //                                        ↑ sama untuk NIS
    ]);

    // Update tabel users (email dan nama)
    $anggotum->user->update([
        'name'  => $request->name,
        'email' => $request->email,
    ]);
    // $anggotum->user ← ini memanfaatkan relasi di model Anggota
    // Laravel otomatis jalankan: User::find($anggotum->user_id)

    // Password hanya diupdate kalau admin mengisi field password
    if ($request->filled('password')) {
        $anggotum->user->update(['password' => Hash::make($request->password)]);
    }

    // Update tabel anggota
    $anggotum->update([...]);
}
```

### Hapus — Dua Langkah

```php
public function destroy(Anggota $anggotum)
{
    // Hapus foto dari storage
    if ($anggotum->foto) {
        \Storage::disk('public')->delete($anggotum->foto);
    }

    $user = $anggotum->user; // Simpan referensi ke user SEBELUM anggota dihapus
                             // Karena setelah anggota dihapus, kita tidak bisa akses
                             // $anggotum->user lagi

    $anggotum->delete(); // Hapus data anggota
    $user->delete();     // Hapus akun login

    // Urutan ini penting:
    // Kalau user dihapus dulu, foreign key constraint akan mencegah
    // (karena anggota masih punya user_id yang merujuk ke user yang mau dihapus)
}
```

---

---

# BAGIAN 6 — TRANSAKSI

---

## Step 17: Peminjaman — Logika Bisnis

Membuat transaksi peminjaman lebih kompleks dari sekadar menyimpan data.
Ada aturan bisnis yang harus dijaga:

```
Aturan:
1. Buku harus punya stok > 0
2. Anggota tidak boleh pinjam buku yang SAMA dua kali (sebelum dikembalikan)
3. Saat berhasil pinjam → stok buku BERKURANG 1
4. Setiap transaksi punya kode unik
```

```php
public function store(Request $request)
{
    $request->validate([...]);

    $buku = Buku::findOrFail($request->buku_id);

    // ATURAN 1: Cek stok
    if ($buku->stok < 1) {
        return back()->withErrors(['buku_id' => 'Stok habis.'])->withInput();
        //     ↑ kembali ke form dengan pesan error di field buku_id
    }

    // ATURAN 2: Cek duplikat pinjaman
    $sudahPinjam = Peminjaman::where('anggota_id', $request->anggota_id)
                             ->where('buku_id',    $request->buku_id)
                             ->whereIn('status',   ['dipinjam', 'terlambat'])
                             ->exists(); // kembalikan true/false

    if ($sudahPinjam) {
        return back()->withErrors(['buku_id' => 'Anggota masih meminjam buku ini.'])->withInput();
    }

    // Generate kode unik
    $kode = 'TRX-' . strtoupper(uniqid());
    // uniqid() = string unik berdasarkan waktu sekarang (microsecond)
    // Contoh hasil: TRX-6745AB2C1E840

    // Simpan transaksi
    Peminjaman::create([
        'kode_pinjam'             => $kode,
        'anggota_id'              => $request->anggota_id,
        'buku_id'                 => $request->buku_id,
        'tanggal_pinjam'          => $request->tanggal_pinjam,
        'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
        'status'                  => 'dipinjam',
    ]);

    // ATURAN 3: Kurangi stok
    $buku->decrement('stok');
    // UPDATE buku SET stok = stok - 1 WHERE id = ?
    // Lebih aman dari: $buku->stok -= 1; $buku->save();
    // karena decrement() adalah operasi atomic di database
}
```

---

## Step 18: Pengembalian dan Hitung Denda

```php
public function pengembalian(Peminjaman $transaksi)
{
    // Cegah proses ganda
    if ($transaksi->status === 'dikembalikan') {
        return back()->with('error', 'Buku sudah dikembalikan.');
    }

    $tanggalKembali = Carbon::today();
    // Carbon adalah library tanggal bawaan Laravel
    // today() = tanggal hari ini (tanpa jam/menit)

    $denda = 0;

    // Hitung denda kalau terlambat
    if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
        //               ↑ gt() = "greater than" = lebih lambat dari batas

        $selisih = $transaksi->tanggal_kembali_rencana->diffInDays($tanggalKembali);
        // diffInDays() = hitung selisih hari antara dua tanggal
        // Contoh: batas 10 Jan, dikembalikan 13 Jan → selisih = 3

        $denda = $selisih * 1000;
        // Rp 1.000 per hari × 3 hari = Rp 3.000
    }

    // Simpan hasil pengembalian
    $transaksi->update([
        'tanggal_kembali_aktual' => $tanggalKembali,
        'status'                 => 'dikembalikan',
        'denda'                  => $denda,
    ]);

    // Kembalikan stok buku
    $transaksi->buku->increment('stok');
    // $transaksi->buku ← akses relasi: ambil objek Buku dari transaksi ini
    // increment('stok') ← UPDATE buku SET stok = stok + 1 WHERE id = ?

    return redirect()->route('admin.transaksi.index')
        ->with('success', 'Pengembalian berhasil. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    //                     number_format() = format angka: 3000 → "3.000"
}
```

### Update Status Terlambat Otomatis

Di method `index()`, ada kode yang berjalan setiap halaman transaksi dibuka:

```php
public function index()
{
    // Sebelum ambil data, ubah status yang sudah lewat batas waktu
    Peminjaman::where('status', 'dipinjam')
              ->where('tanggal_kembali_rencana', '<', Carbon::today())
              ->update(['status' => 'terlambat']);
    // UPDATE peminjaman
    // SET status = 'terlambat'
    // WHERE status = 'dipinjam'
    // AND tanggal_kembali_rencana < CURDATE()
    
    // Sekarang baru ambil data untuk ditampilkan
    $transaksi = Peminjaman::with([...])->paginate(10);
    ...
}
```

Jadi setiap kali admin buka halaman transaksi, sistem otomatis "cek" apakah ada
peminjaman yang sudah jatuh tempo dan belum dikembalikan — lalu ubah statusnya.

---

---

# BAGIAN 7 — NYAMBUNGIN SEMUANYA

---

## Step 19: Bagaimana Data Mengalir dari Klik ke Database

Mari trace perjalanan data dari klik "Simpan" di form tambah buku sampai muncul di daftar:

```
=== KLIK TOMBOL "SIMPAN BUKU" ===

1. BROWSER
   Mengumpulkan data dari semua <input> dan <file>
   Kirim HTTP POST request ke URL /admin/buku
   Header: Content-Type: multipart/form-data (karena ada upload file)
   Body: kode_buku=BK001&judul=Harry+Potter&cover=[binary file data]

2. LARAVEL FRAMEWORK
   Terima request
   Cek middleware: auth → user sudah login? ✓
   Cek middleware: admin → rolenya admin? ✓
   Cek routes: POST /admin/buku → Admin\BukuController@store

3. BukuController@store() DIJALANKAN
   $request berisi semua data yang dikirim browser

   a. Validasi:
      - kode_buku hadir? ✓
      - kode_buku unik di database? → query: SELECT id FROM buku WHERE kode_buku = 'BK001' → kosong ✓
      - cover adalah gambar? ✓ (cek MIME type file)

   b. Simpan file cover:
      - Ambil file dari request
      - Generate nama unik: "covers/6745a1b2c.jpg"
      - Salin file ke: storage/app/public/covers/6745a1b2c.jpg

   c. Simpan ke database:
      Buku::create([
          'kode_buku' => 'BK001',
          'judul'     => 'Harry Potter',
          'cover'     => 'covers/6745a1b2c.jpg', ← hanya simpan PATH, bukan file
          ...
      ])
      Eloquent jalankan: INSERT INTO buku (kode_buku, judul, cover, ...) VALUES (...)

   d. Redirect:
      return redirect()->route('admin.buku.index')
          ->with('success', 'Buku berhasil ditambahkan.')
      Session flash: ['success' => 'Buku berhasil ditambahkan.']

4. BROWSER
   Terima redirect response (HTTP 302) ke URL /admin/buku
   Otomatis buka URL /admin/buku

5. BukuController@index() DIJALANKAN
   $buku = Buku::latest()->paginate(30)
   → SELECT * FROM buku ORDER BY created_at DESC LIMIT 30
   → Buku baru yang barusan disimpan ada di sini!

6. VIEW admin/buku/index.blade.php DIRENDER
   @foreach($buku as $b) ... menampilkan tiap buku termasuk yang baru
   session('success') ada → tampilkan flash message "Buku berhasil ditambahkan"

7. BROWSER
   Tampilkan halaman daftar buku
   Notifikasi hijau: "Buku berhasil ditambahkan." ← dari session flash
   Buku baru muncul di posisi pertama ← karena latest()
```

---

## Step 20: Pencarian — Bagaimana Filter Bekerja

Saat admin ketik "Harry Potter" di kotak search dan tekan Enter:

```
=== PROSES PENCARIAN ===

1. BROWSER
   User ketik "Harry Potter" di <input name="search">
   Tekan Enter / klik tombol Cari
   Browser kirim GET request ke: /admin/buku?search=Harry+Potter
   (filter via URL, bukan POST, supaya bisa di-bookmark dan di-share)

2. BukuController@index() DIJALANKAN
   $request->get('search') → "Harry Potter"
   $request->filled('search') → true

3. QUERY DIBANGUN
   $query = Buku::query()  ← query kosong dulu

   $q = "Harry Potter"
   $query->where(function ($q2) use ($q) {
       $q2->where('judul', 'like', '%Harry Potter%')
          ->orWhere('pengarang', 'like', '%Harry Potter%')
   })

   Jadi SQL-nya:
   SELECT * FROM buku
   WHERE (judul LIKE '%Harry Potter%' OR pengarang LIKE '%Harry Potter%')
   ORDER BY created_at DESC
   LIMIT 30

   % di depan dan belakang = cocokkan apapun sebelum dan sesudah kata kuncinya
   Jadi "Harry Potter and the..." juga akan cocok

4. VIEW DITAMPILKAN
   @foreach($buku as $b) → hanya buku yang cocok
   
   Di form search:
   <input name="search" value="{{ request('search') }}">
   ↑ request('search') = "Harry Potter"
   → Kotak pencarian tetap terisi, tidak kosong setelah submit
   
   Di link pagination:
   $buku->links() dengan withQueryString()
   → Link halaman 2 jadi: /admin/buku?search=Harry+Potter&page=2
   → Search tidak hilang saat ganti halaman
```

---

## HUBUNGAN ANTAR KOMPONEN — RINGKASAN VISUAL

```
                    ┌─────────────────────────────────────────┐
                    │              BROWSER                     │
                    │  Ketik URL / klik link / submit form    │
                    └────────────────┬────────────────────────┘
                                     │ HTTP Request
                                     ▼
                    ┌─────────────────────────────────────────┐
                    │              MIDDLEWARE                  │
                    │  AdminMiddleware: cek auth & role       │
                    │  Kalau gagal → abort(403)               │
                    └────────────────┬────────────────────────┘
                                     │ Lolos cek
                                     ▼
                    ┌─────────────────────────────────────────┐
                    │              ROUTES (web.php)           │
                    │  Cocokkan URL → tentukan controller     │
                    │  /admin/buku → BukuController@index    │
                    └────────────────┬────────────────────────┘
                                     │ Panggil method
                                     ▼
          ┌──────────────────────────────────────────────────────┐
          │                   CONTROLLER                          │
          │  - Terima $request (data dari browser)               │
          │  - Validasi data                                     │
          │  - Panggil Model untuk query database                │
          │  - Kirim data ke View untuk ditampilkan             │
          └──────────┬─────────────────────────┬────────────────┘
                     │ query                   │ return view
                     ▼                         ▼
     ┌───────────────────────┐    ┌────────────────────────────┐
     │       MODEL           │    │           VIEW             │
     │  Buku::where(...)     │    │  admin/buku/index.blade.php│
     │  Eloquent ORM         │    │  @foreach($buku as $b)    │
     │  Terjemahkan ke SQL   │    │  {{ $b->judul }}           │
     └──────────┬────────────┘    └────────────────────────────┘
                │ SQL                          │
                ▼                             │ HTML
     ┌───────────────────────┐               ▼
     │       DATABASE        │    ┌────────────────────────────┐
     │  MySQL/MariaDB        │    │         BROWSER            │
     │  Jalankan SQL         │    │  Render HTML               │
     │  Kembalikan data      │    │  Tampilkan halaman         │
     └───────────────────────┘    └────────────────────────────┘
```

---

## PERTANYAAN UMUM

### "Kenapa tampilan bisa muncul?"
Karena controller memanggil `return view('admin.buku.index', $data)`.
Laravel ambil file `resources/views/admin/buku/index.blade.php`, gabungkan dengan layout induk, proses semua sintaks Blade (`{{ }}`, `@foreach`, `@if`), lalu kirim HTML murni ke browser.

### "Kenapa form bisa nyambung ke database?"
Form HTML punya `action` yang mengarah ke URL tertentu, dan `method` POST.
Saat submit, browser kirim data ke URL itu. Laravel cocokkan dengan routes, panggil controller method yang tepat, lalu method itu simpan data ke database lewat Model/Eloquent.

### "Kenapa tombol hapus tidak langsung hapus tanpa konfirmasi?"
Karena form hapus punya `onsubmit="return confirm('...')"`.
JavaScript `confirm()` menampilkan dialog browser. Kalau user klik "Cancel", `confirm()` return `false`, form tidak jadi disubmit. Kalau klik "OK", return `true`, form disubmit.

### "Kenapa link di sidebar aktif (highlighted) sesuai halaman yang dibuka?"
Karena di sidebar ada kondisi:
```php
class="sb-item {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}"
```
`request()->routeIs('admin.buku.*')` mengecek apakah URL yang sedang dibuka cocok dengan pola `admin.buku.xxx`. Kalau ya, class `active` ditambahkan → CSS memberi warna berbeda.

### "Kenapa stok berkurang otomatis saat ada peminjaman?"
Karena di `TransaksiController@store()` ada:
```php
$buku->decrement('stok');
```
Laravel menjalankan `UPDATE buku SET stok = stok - 1 WHERE id = ?` di database.
Tidak ada yang "otomatis" — ini kode yang kita tulis dengan sengaja.

### "Kenapa status berubah jadi 'terlambat' sendiri?"
Bukan benar-benar sendiri — ada kode di `TransaksiController@index()` yang berjalan setiap kali halaman transaksi dibuka:
```php
Peminjaman::where('status','dipinjam')
          ->where('tanggal_kembali_rencana','<',Carbon::today())
          ->update(['status'=>'terlambat']);
```
Jadi perubahan status terjadi saat ada yang membuka halaman itu.

---

*Dokumen ini menjelaskan proses dan koneksi antar komponen — dari database, model, middleware, routes, controller, sampai view — sehingga kamu paham kenapa dan bagaimana sistem ini bisa berjalan.*

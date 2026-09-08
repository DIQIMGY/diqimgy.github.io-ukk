# 🔧 DOKUMENTASI KODE — CARA KERJA SETIAP FITUR
### Penjelasan lengkap: kode apa, di file mana, hubungan antar file, kenapa bisa berfungsi

---

## DAFTAR ISI
1. [Cara Kerja Sistem Secara Keseluruhan](#1-cara-kerja-sistem-secara-keseluruhan)
2. [Fitur Login & Register](#2-fitur-login--register)
3. [Sistem Middleware — Penjaga Halaman](#3-sistem-middleware--penjaga-halaman)
4. [Fitur Landing Page](#4-fitur-landing-page)
5. [Fitur Dashboard Admin](#5-fitur-dashboard-admin)
6. [Fitur Kelola Buku (CRUD)](#6-fitur-kelola-buku-crud)
7. [Fitur Kelola Anggota (CRUD)](#7-fitur-kelola-anggota-crud)
8. [Fitur Kelola Transaksi (Admin)](#8-fitur-kelola-transaksi-admin)
9. [Fitur Dashboard Siswa](#9-fitur-dashboard-siswa)
10. [Fitur Pinjam Buku (Siswa)](#10-fitur-pinjam-buku-siswa)
11. [Fitur Pengembalian Buku (Siswa)](#11-fitur-pengembalian-buku-siswa)
12. [Sistem Seeder — Data Awal](#12-sistem-seeder--data-awal)
13. [Hubungan Antar File (Peta Lengkap)](#13-hubungan-antar-file-peta-lengkap)

---

## 1. CARA KERJA SISTEM SECARA KESELURUHAN

Sebelum masuk ke fitur satu per satu, pahami dulu bagaimana **satu request** dari
browser diproses sampai tampil di layar.

### Perjalanan Sebuah Request

```
[1] Browser kirim request
    Contoh: GET http://localhost/peminjaman_buku/public/siswa/peminjaman
         |
         v
[2] File: routes/web.php
    Laravel baca semua route yang terdaftar.
    Cocokkan URL dengan route:
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
         |
         v
[3] File: app/Http/Middleware/SiswaMiddleware.php
    Karena route ini pakai middleware 'siswa',
    middleware cek dulu: apakah user sudah login? Role-nya siswa?
    - Jika TIDAK → abort(403) / redirect login
    - Jika YA → lanjut ke Controller
         |
         v
[4] File: app/Http/Controllers/Siswa/PeminjamanController.php
    Method index() dijalankan.
    - Ambil data dari database via Model
    - Proses logika bisnis
    - Kirim data ke View
         |
         v
[5] File: app/Models/Peminjaman.php  (dan model lain)
    Model berkomunikasi dengan database MySQL.
    Mengembalikan data sebagai object PHP.
         |
         v
[6] File: resources/views/siswa/peminjaman/index.blade.php
    View menerima data, render HTML.
    Menggunakan Blade syntax: @foreach, {{ }}, @if
         |
         v
[7] Browser tampilkan halaman ke user
```

### File-File Kunci dan Fungsinya

```
routes/web.php                    → Peta URL seluruh aplikasi
bootstrap/app.php                 → Konfigurasi middleware alias
app/Http/Middleware/              → Penjaga/filter sebelum masuk Controller
app/Http/Controllers/             → Otak logika setiap fitur
app/Models/                       → Komunikasi dengan database
resources/views/                  → Tampilan HTML (Blade)
database/migrations/              → Definisi struktur tabel
database/seeders/                 → Data awal untuk testing
```

---

## 2. FITUR LOGIN & REGISTER

### File yang Terlibat
```
routes/web.php                           ← Daftar URL login/register
app/Http/Controllers/AuthController.php ← Logika login/register/logout
app/Models/User.php                      ← Model tabel users
app/Models/Anggota.php                   ← Model tabel anggota
resources/views/auth/login.blade.php     ← Tampilan form login
resources/views/auth/register.blade.php ← Tampilan form register
```

### Routes Login/Register

```php
// FILE: routes/web.php

// Middleware 'guest' artinya: hanya bisa diakses jika BELUM login
// Kalau sudah login, Laravel otomatis redirect ke home
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Logout pakai POST (bukan GET) untuk keamanan (mencegah CSRF)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')
    ->middleware('auth');
```

**Kenapa ada dua route untuk login?**
- `GET /login` → tampilkan form (method `showLogin`)
- `POST /login` → proses data form (method `login`)
Ini adalah pola standar web: GET untuk tampilkan, POST untuk kirim data.

---

### Model User — Pondasi Autentikasi

```php
// FILE: app/Models/User.php

class User extends Authenticatable  // ← extends Authenticatable, bukan Model biasa!
{
    protected $fillable = ['name', 'email', 'password', 'role'];

    // Kolom ini disembunyikan saat data di-convert ke JSON/array
    protected $hidden = ['password', 'remember_token'];

    // 'password' => 'hashed' artinya password otomatis di-hash saat diset
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Method helper untuk cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';  // true jika role = 'admin'
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';  // true jika role = 'siswa'
    }

    // Relasi: 1 user punya 1 data anggota
    public function anggota()
    {
        return $this->hasOne(Anggota::class);
        // hasOne = "1 user MEMILIKI 1 anggota"
        // Laravel otomatis cari kolom user_id di tabel anggota
    }
}
```

**Kenapa `extends Authenticatable` bukan `extends Model`?**
`Authenticatable` adalah class khusus Laravel yang menambahkan kemampuan login
(cek password, session, remember me). Class ini juga extend Model, jadi semua
fitur database tetap ada.

---

### Proses Login — Langkah per Langkah

```php
// FILE: app/Http/Controllers/AuthController.php

public function login(Request $request)
{
    // LANGKAH 1: Validasi format input
    // Kalau tidak valid, Laravel otomatis balik ke form + tampilkan error
    $request->validate([
        'email'    => 'required|email',      // wajib & format email valid
        'password' => 'required|min:6',      // wajib & minimal 6 karakter
    ]);

    // LANGKAH 2: Ambil hanya email & password dari request
    $credentials = $request->only('email', 'password');

    // LANGKAH 3: Coba login
    // Auth::attempt() melakukan:
    //   a) Cari user dengan email ini di database
    //   b) Hash password yang diinput, bandingkan dengan hash di database
    //   c) Jika cocok: buat session, return true
    //   d) Jika tidak cocok: return false
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // remember = true → simpan "remember me" cookie (login permanen)

        $request->session()->regenerate();
        // Regenerate session ID untuk keamanan (mencegah session fixation attack)

        return $this->redirectByRole();
        // Redirect ke dashboard sesuai role
    }

    // LANGKAH 4: Jika gagal, kembali ke form dengan error
    return back()
        ->withErrors(['email' => 'Email atau password salah.'])
        ->withInput(); // pertahankan nilai email di form (tidak perlu ketik ulang)
}

// Helper: redirect ke dashboard sesuai role
private function redirectByRole()
{
    return Auth::user()->isAdmin()
        ? redirect()->route('admin.dashboard')  // admin → /admin/dashboard
        : redirect()->route('siswa.dashboard'); // siswa → /siswa/dashboard
}
```

---

### Proses Register — Buat 2 Record Sekaligus

```php
// FILE: app/Http/Controllers/AuthController.php

public function register(Request $request)
{
    // LANGKAH 1: Validasi semua input
    $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|unique:users,email',
        // unique:users,email = email harus unik di tabel users kolom email
        'password' => 'required|min:6|confirmed',
        // confirmed = harus ada field 'password_confirmation' yang sama
        'nis'      => 'required|string|unique:anggota,nis',
        // unique:anggota,nis = NIS harus unik di tabel anggota
        'kelas'    => 'required|string|max:20',
    ]);

    // LANGKAH 2: Buat akun di tabel USERS
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        // Hash::make() = enkripsi password dengan bcrypt
        // Contoh: "siswa123" → "$2y$12$Abc123..."
        'role'     => 'siswa', // role selalu 'siswa' kalau register sendiri
    ]);

    // LANGKAH 3: Buat data profil di tabel ANGGOTA
    // Perlu user_id dari langkah 2 sebagai foreign key
    Anggota::create([
        'user_id'  => $user->id,  // ← hubungan ke tabel users
        'nis'      => $request->nis,
        'nama'     => $request->name,
        'kelas'    => $request->kelas,
        'alamat'   => $request->alamat,
        'telepon'  => $request->telepon,
        'status'   => 'aktif',  // otomatis aktif
    ]);

    // LANGKAH 4: Langsung login setelah register
    Auth::login($user);

    return redirect()->route('siswa.dashboard')
        ->with('success', 'Registrasi berhasil! Selamat datang.');
}
```

**Kenapa 2 tabel?**
Tabel `users` khusus untuk autentikasi (login). Tabel `anggota` untuk data
profil siswa (NIS, kelas, dll). Ini prinsip *separation of concerns* —
setiap tabel punya tanggung jawab berbeda.

---

## 3. SISTEM MIDDLEWARE — PENJAGA HALAMAN

Middleware adalah kode yang berjalan **sebelum** request sampai ke Controller.
Fungsinya seperti satpam: cek dulu sebelum boleh masuk.

### Pendaftaran Middleware

```php
// FILE: bootstrap/app.php

->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
    ]);
})
```

Ini mendaftarkan nama alias middleware. Setelah ini, di `routes/web.php` kita
bisa pakai nama pendek `'admin'` dan `'siswa'` alih-alih nama class panjang.

---

### AdminMiddleware — Penjaga Halaman Admin

```php
// FILE: app/Http/Middleware/AdminMiddleware.php

public function handle(Request $request, Closure $next): Response
{
    // Cek dua kondisi sekaligus:
    // 1. auth()->check()        → apakah user sudah login?
    // 2. auth()->user()->isAdmin() → apakah role-nya admin?

    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin.');
        // abort(403) = kirim response HTTP 403 Forbidden
        // Halaman error 403 ditampilkan ke user
    }

    // Kalau lolos: lanjutkan request ke Controller
    return $next($request);
    // $next = "teruskan ke handler berikutnya" (Controller)
}
```

### SiswaMiddleware — Penjaga Halaman Siswa

```php
// FILE: app/Http/Middleware/SiswaMiddleware.php

public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check() || !auth()->user()->isSiswa()) {
        abort(403, 'Akses ditolak. Halaman ini hanya untuk Siswa.');
    }
    return $next($request);
}
```

### Cara Middleware Dipasang di Route

```php
// FILE: routes/web.php

// Semua route di dalam group ini dilindungi middleware 'admin'
Route::prefix('admin')          // URL dimulai dengan /admin/
    ->name('admin.')             // Nama route dimulai dengan admin.
    ->middleware(['auth', 'admin']) // Harus login + harus admin
    ->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('dashboard');
    // Nama lengkap: 'admin.dashboard', URL: /admin/dashboard

    Route::resource('buku', Admin\BukuController::class);
    // resource() otomatis buat 7 route CRUD sekaligus:
    // GET    /admin/buku           → index()
    // GET    /admin/buku/create    → create()
    // POST   /admin/buku           → store()
    // GET    /admin/buku/{id}      → show()
    // GET    /admin/buku/{id}/edit → edit()
    // PUT    /admin/buku/{id}      → update()
    // DELETE /admin/buku/{id}      → destroy()
});
```

**Kenapa `['auth', 'admin']` dua middleware?**
- `auth` = middleware bawaan Laravel, cek apakah sudah login
- `admin` = middleware custom kita, cek apakah role admin
Keduanya harus lolos. Kalau belum login, `auth` akan redirect ke login page.

---

## 4. FITUR LANDING PAGE

### File yang Terlibat
```
routes/web.php                              ← Route '/'
app/Http/Controllers/LandingController.php ← Query semua data
resources/views/landing.blade.php          ← Tampilan (sangat panjang)
app/Models/Buku.php                        ← Model buku
app/Models/Peminjaman.php                  ← Untuk hitung populer
```

### LandingController — Query Berbeda untuk Setiap Section

```php
// FILE: app/Http/Controllers/LandingController.php

public function index()
{
    // ── SECTION: BUKU POPULER ──────────────────────────────────────────
    // withCount('peminjaman') = tambahkan kolom 'peminjaman_count'
    // yang isinya jumlah row di tabel peminjaman yang punya buku_id ini
    $bukuPopuler = Buku::withCount('peminjaman')
        ->orderByDesc('peminjaman_count')  // urutkan: paling banyak dipinjam
        ->take(6)                           // ambil 6 saja
        ->get();
    // Hasil SQL: SELECT buku.*, COUNT(peminjaman.id) AS peminjaman_count
    //            FROM buku LEFT JOIN peminjaman ON ...
    //            GROUP BY buku.id ORDER BY peminjaman_count DESC LIMIT 6

    // ── SECTION: BUKU TERBARU ─────────────────────────────────────────
    $bukuTerbaru = Buku::latest()  // latest() = ORDER BY created_at DESC
        ->take(4)
        ->get();

    // ── SECTION: STOK TERBANYAK ──────────────────────────────────────
    $bukuStokTerbanyak = Buku::orderByDesc('stok')->take(4)->get();

    // ── SECTION: WAITLIST ─────────────────────────────────────────────
    // Buku yang stok habis (0) tapi ada yang antri (waitlist_count > 0)
    $bukuWaitlist = Buku::where('stok', 0)
        ->where('waitlist_count', '>', 0)
        ->orderByDesc('waitlist_count')
        ->take(6)
        ->get();

    // ── SECTION: BARU KEMBALI ─────────────────────────────────────────
    // Buku yang stok sedikit (1-3) dan pernah dipinjam sebelumnya
    // Ini menunjukkan buku "baru saja dikembalikan"
    $bukuBaruKembali = Buku::whereBetween('stok', [1, 3])
        ->withCount('peminjaman')
        ->having('peminjaman_count', '>', 0)  // pernah ada yang pinjam
        ->orderByDesc('peminjaman_count')
        ->take(6)
        ->get();

    // ── SECTION: SEGERA HADIR ─────────────────────────────────────────
    $bukuSegeraHadir = Buku::where('status_launching', 'segera')
        ->whereNotNull('tanggal_rilis')
        ->orderBy('tanggal_rilis')  // urutkan dari yang paling cepat rilis
        ->take(6)
        ->get();

    // ── DATA TAMBAHAN ─────────────────────────────────────────────────
    $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
    // distinct() = tidak ada duplikat. pluck() = ambil satu kolom saja
    // Hasil: ["Fiksi Sastra", "Fantasy", "Romance", ...]

    $totalBuku = Buku::count();  // jumlah total buku
    $totalStok = Buku::sum('stok');  // total semua stok

    // Kirim semua data ke view sekaligus
    return view('landing', compact(
        'bukuPopuler', 'bukuTerbaru', 'bukuStokTerbanyak',
        'bukuWaitlist', 'bukuBaruKembali', 'bukuSegeraHadir',
        'kategoris', 'totalBuku', 'totalStok'
    ));
    // compact() = buat array dari nama variabel
    // ['bukuPopuler' => $bukuPopuler, 'bukuTerbaru' => $bukuTerbaru, ...]
}
```

### Cara Data Ditampilkan di Blade

```html
{{-- FILE: resources/views/landing.blade.php --}}

{{-- {{ }} = echo / cetak nilai variabel --}}
<span>{{ $totalBuku }}</span> {{-- cetak angka total buku --}}

{{-- @foreach = loop/perulangan --}}
@foreach($bukuPopuler as $buku)
    <div class="bk-card">
        {{-- Kondisi: tampilkan cover jika ada --}}
        @if($buku->cover)
            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}">
        @else
            <div class="no-cover">
                <i class="bi bi-book-fill"></i>
            </div>
        @endif

        <h3>{{ $buku->judul }}</h3>
        <p>{{ $buku->pengarang }}</p>
    </div>
@endforeach

{{-- @if untuk kondisi --}}
@if($bukuSegeraHadir->isNotEmpty())
    {{-- tampilkan section segera hadir --}}
@endif
```

---

## 5. FITUR DASHBOARD ADMIN

### File yang Terlibat
```
routes/web.php                                  ← Route /admin/dashboard
app/Http/Controllers/Admin/DashboardController.php ← Ambil statistik
resources/views/admin/dashboard.blade.php       ← Tampilan statistik
app/Models/Buku.php, Anggota.php, Peminjaman.php ← Sumber data
```

### DashboardController — Kumpulkan Statistik

```php
// FILE: app/Http/Controllers/Admin/DashboardController.php

public function index()
{
    // Hitung statistik utama
    $totalBuku      = Buku::count();
    // SQL: SELECT COUNT(*) FROM buku

    $totalAnggota   = Anggota::count();
    // SQL: SELECT COUNT(*) FROM anggota

    $totalPinjam    = Peminjaman::where('status', 'dipinjam')->count();
    // SQL: SELECT COUNT(*) FROM peminjaman WHERE status = 'dipinjam'

    $totalTerlambat = Peminjaman::where('status', 'terlambat')->count();

    $totalKembali   = Peminjaman::where('status', 'dikembalikan')->count();

    // 5 peminjaman terbaru untuk tabel di dashboard
    $peminjamanTerbaru = Peminjaman::with(['anggota', 'buku'])
        ->latest()
        ->take(5)
        ->get();
    // with(['anggota', 'buku']) = Eager Loading
    // Ambil data relasi sekaligus (1 query dengan JOIN)
    // Tanpa ini = N+1 problem (query terpisah untuk setiap row)

    // 5 buku paling populer
    $bukuPopuler = Buku::withCount('peminjaman')
        ->orderByDesc('peminjaman_count')
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalBuku', 'totalAnggota', 'totalPinjam',
        'totalTerlambat', 'totalKembali',
        'peminjamanTerbaru', 'bukuPopuler'
    ));
}
```

**Apa itu Eager Loading (`with()`)?**
```
TANPA with() — N+1 problem (BURUK):
Query 1: SELECT * FROM peminjaman LIMIT 5
Query 2: SELECT * FROM anggota WHERE id = 1
Query 3: SELECT * FROM buku WHERE id = 5
Query 4: SELECT * FROM anggota WHERE id = 2
Query 5: SELECT * FROM buku WHERE id = 3
... dst → 1 + 5×2 = 11 query!

DENGAN with(['anggota','buku']) — Eager Loading (BAGUS):
Query 1: SELECT * FROM peminjaman LIMIT 5
Query 2: SELECT * FROM anggota WHERE id IN (1,2,3,4,5)
Query 3: SELECT * FROM buku WHERE id IN (5,3,7,2,1)
Total: hanya 3 query!
```

---

## 6. FITUR KELOLA BUKU (CRUD)

CRUD = **C**reate (Tambah), **R**ead (Baca), **U**pdate (Edit), **D**elete (Hapus)

### File yang Terlibat
```
routes/web.php                              ← Route::resource('buku', ...)
app/Http/Controllers/Admin/BukuController.php ← Semua logika CRUD
app/Models/Buku.php                         ← Model buku
resources/views/admin/buku/index.blade.php  ← Daftar buku
resources/views/admin/buku/create.blade.php ← Form tambah
resources/views/admin/buku/edit.blade.php   ← Form edit
resources/views/admin/buku/show.blade.php   ← Detail buku
storage/app/public/covers/                  ← Folder simpan foto cover
```

### READ — Daftar Buku dengan Search & Filter

```php
// FILE: app/Http/Controllers/Admin/BukuController.php

public function index(Request $request)
{
    $query = Buku::query();
    // Buku::query() = mulai membangun query, belum dieksekusi

    // Filter search: cari di beberapa kolom sekaligus
    if ($request->filled('search')) {
        $q = $request->search;  // ambil nilai dari URL ?search=xxx

        $query->where(function ($q2) use ($q) {
            // use ($q) = import variabel $q ke dalam closure
            $q2->where('judul', 'like', "%{$q}%")
               // LIKE '%xxx%' = mengandung kata xxx di mana saja
               ->orWhere('pengarang', 'like', "%{$q}%")
               ->orWhere('kode_buku', 'like', "%{$q}%")
               ->orWhere('kategori', 'like', "%{$q}%");
        });
        // Dibungkus where() lagi agar OR tidak bocor ke kondisi lain
    }

    // Filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // Eksekusi query dengan pagination (10 per halaman)
    $buku = $query->latest()->paginate(10)->withQueryString();
    // withQueryString() = pertahankan parameter URL (?search=xxx)
    // di link pagination. Tanpa ini, klik halaman 2 akan hilangkan search.

    $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
    // Untuk dropdown filter kategori

    return view('admin.buku.index', compact('buku', 'kategoris'));
}
```

### CREATE — Tambah Buku Baru + Upload Foto

```php
// FILE: app/Http/Controllers/Admin/BukuController.php

public function store(Request $request)
{
    // Validasi semua input
    $request->validate([
        'kode_buku'    => 'required|string|unique:buku,kode_buku',
        // unique:buku,kode_buku = harus unik di tabel buku kolom kode_buku
        'judul'        => 'required|string|max:200',
        'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        // digits:4 = harus tepat 4 digit, max:date('Y') = tidak boleh masa depan
        'stok'         => 'required|integer|min:0',
        'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        // nullable = boleh kosong, image = harus file gambar,
        // mimes = ekstensi yang diizinkan, max:2048 = maksimal 2MB
        'status_launching' => 'required|in:tersedia,segera',
        // in:tersedia,segera = hanya boleh salah satu dari dua nilai ini
        'tanggal_rilis' => 'nullable|date|after_or_equal:today',
        // after_or_equal:today = tidak boleh tanggal yang sudah lewat
    ]);

    // Ambil semua data KECUALI cover (cover diproses terpisah)
    $data = $request->except('cover');

    // Logika bisnis: jika status 'segera', tanggal_rilis wajib
    if ($request->status_launching === 'segera' && !$request->tanggal_rilis) {
        return back()
            ->withErrors(['tanggal_rilis' => 'Tanggal rilis harus diisi untuk buku "Segera Hadir"'])
            ->withInput();
    }

    // Jika status 'tersedia', pastikan tanggal_rilis dikosongkan
    if ($request->status_launching === 'tersedia') {
        $data['tanggal_rilis'] = null;
    }

    // Upload cover jika ada file yang dikirim
    if ($request->hasFile('cover')) {
        $data['cover'] = $request->file('cover')->store('covers', 'public');
        // store('covers', 'public') = simpan ke storage/app/public/covers/
        // Laravel otomatis generate nama file acak, contoh: "covers/AbCdEf.jpg"
        // Ini mencegah nama file yang sama menimpa satu sama lain
    }

    // Simpan ke database
    Buku::create($data);
    // create() = INSERT INTO buku (...) VALUES (...)

    return redirect()->route('admin.buku.index')
        ->with('success', 'Buku berhasil ditambahkan.');
    // with('success', ...) = flash message: muncul sekali lalu hilang
}
```

**Bagaimana foto cover bisa diakses dari browser?**
```
File disimpan di:  storage/app/public/covers/AbCdEf.jpg
Diakses via URL:   /storage/covers/AbCdEf.jpg

Ini bisa karena ada symlink (symbolic link):
public/storage → storage/app/public

Dibuat dengan command: php artisan storage:link

Di Blade, kita pakai: {{ asset('storage/' . $buku->cover) }}
atau: {{ Storage::url($buku->cover) }}
```

### UPDATE — Edit Buku + Ganti Foto

```php
// FILE: app/Http/Controllers/Admin/BukuController.php

public function update(Request $request, Buku $buku)
// Parameter "Buku $buku" = Route Model Binding
// Laravel otomatis ambil buku berdasarkan ID di URL
// /admin/buku/5/edit → $buku = Buku::find(5) otomatis!
{
    // Validasi sama seperti store, tapi kode_buku boleh sama dengan milik sendiri
    $request->validate([
        'kode_buku' => 'required|string|unique:buku,kode_buku,' . $buku->id,
        // unique:buku,kode_buku,5 = unik di tabel buku kolom kode_buku
        //                          KECUALI row dengan id=5 (dirinya sendiri)
        // Tanpa pengecualian ini, edit tanpa ganti kode_buku akan error "sudah ada"
        ...
    ]);

    $data = $request->except('cover');

    if ($request->hasFile('cover')) {
        // Hapus foto LAMA dari storage sebelum simpan yang baru
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
            // Storage::disk('public')->delete() = hapus file dari storage/app/public/
        }
        $data['cover'] = $request->file('cover')->store('covers', 'public');
    }

    $buku->update($data);
    // UPDATE buku SET judul=?, pengarang=?, ... WHERE id = ?

    return redirect()->route('admin.buku.index')
        ->with('success', 'Data buku berhasil diperbarui.');
}
```

### DELETE — Hapus Buku + Foto

```php
// FILE: app/Http/Controllers/Admin/BukuController.php

public function destroy(Buku $buku)
{
    // Hapus file foto dari storage SEBELUM hapus data
    if ($buku->cover) {
        Storage::disk('public')->delete($buku->cover);
        // Jika lupa ini, foto akan tetap ada di server (file orphan / sampah)
    }

    $buku->delete();
    // DELETE FROM buku WHERE id = ?

    return redirect()->route('admin.buku.index')
        ->with('success', 'Buku berhasil dihapus.');
}
```

### Route Model Binding — Fitur Laravel yang Keren

```php
// Tanpa Route Model Binding (cara manual):
public function show($id)
{
    $buku = Buku::findOrFail($id); // harus cari manual
    // findOrFail = cari, kalau tidak ada → 404 error otomatis
}

// Dengan Route Model Binding (cara Laravel):
public function show(Buku $buku)
// Laravel otomatis cari Buku berdasarkan {buku} di URL
// Kalau tidak ada → otomatis 404
// Hemat 1 baris kode, lebih bersih
```

---

## 7. FITUR KELOLA ANGGOTA (CRUD)

### File yang Terlibat
```
app/Http/Controllers/Admin/AnggotaController.php ← Semua logika
app/Models/Anggota.php                            ← Model anggota
app/Models/User.php                               ← Model user (relasi)
resources/views/admin/anggota/                    ← Semua tampilan
```

### Hal Unik: Hapus Anggota = Hapus 2 Record

```php
// FILE: app/Http/Controllers/Admin/AnggotaController.php

public function destroy(Anggota $anggotum)
// Nama parameter 'anggotum' (bukan 'anggota') karena Laravel
// menggunakan singular dari nama resource untuk route model binding.
// Resource 'anggota' (sudah singular) jadi Laravel pakai 'anggotum'
{
    // Hapus foto jika ada
    if ($anggotum->foto && Storage::disk('public')->exists($anggotum->foto)) {
        Storage::disk('public')->delete($anggotum->foto);
    }

    // Simpan referensi ke user SEBELUM hapus anggota
    $user = $anggotum->user;
    // $anggotum->user = akses relasi, otomatis query:
    // SELECT * FROM users WHERE id = anggotum.user_id

    $anggotum->delete();  // Hapus dari tabel anggota
    $user->delete();      // Hapus dari tabel users

    // Urutan penting! Hapus anggota dulu, baru users.
    // Karena anggota punya foreign key ke users (user_id).
    // Kalau hapus users dulu, foreign key constraint akan error.
}
```

### Update Anggota — Update 2 Tabel Sekaligus

```php
// FILE: app/Http/Controllers/Admin/AnggotaController.php

public function update(Request $request, Anggota $anggotum)
{
    // Update tabel USERS (nama & email)
    $anggotum->user->update([
        'name'  => $request->name,
        'email' => $request->email,
    ]);
    // $anggotum->user → akses relasi hasOne, dapat object User
    // ->update() = langsung update object tersebut

    // Password hanya diupdate jika diisi (opsional saat edit)
    if ($request->filled('password')) {
        $request->validate(['password' => 'min:6']);
        $anggotum->user->update([
            'password' => Hash::make($request->password)
        ]);
    }

    // Handle foto: bisa upload baru, hapus, atau biarkan
    $fotoPath = $anggotum->foto; // pertahankan path foto lama

    if ($request->has('hapus_foto')) {
        // User klik tombol "Hapus Foto"
        if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
            Storage::disk('public')->delete($fotoPath);
        }
        $fotoPath = null;
    }

    if ($request->hasFile('foto')) {
        // User upload foto baru
        if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
            Storage::disk('public')->delete($fotoPath); // hapus foto lama
        }
        $fotoPath = $request->file('foto')->store('anggota', 'public');
    }

    // Update tabel ANGGOTA
    $anggotum->update([
        'nis'     => $request->nis,
        'nama'    => $request->name,
        'kelas'   => $request->kelas,
        'foto'    => $fotoPath,
        'status'  => $request->status,
        ...
    ]);
}
```

---

## 8. FITUR KELOLA TRANSAKSI (ADMIN)

### File yang Terlibat
```
app/Http/Controllers/Admin/TransaksiController.php ← Semua logika
app/Models/Peminjaman.php                          ← Model transaksi
resources/views/admin/transaksi/                   ← Semua tampilan
```

### Auto-Update Status Terlambat

```php
// FILE: app/Http/Controllers/Admin/TransaksiController.php

public function index(Request $request)
{
    // Setiap kali halaman transaksi dibuka, sistem otomatis update
    // status semua peminjaman yang sudah melewati deadline
    Peminjaman::where('status', 'dipinjam')
        ->where('tanggal_kembali_rencana', '<', Carbon::today())
        ->update(['status' => 'terlambat']);
    // SQL: UPDATE peminjaman SET status='terlambat'
    //      WHERE status='dipinjam' AND tanggal_kembali_rencana < TODAY()

    // Ini lebih efisien dari cek satu per satu!
    // 1 query = update semua yang terlambat sekaligus
```

### Search Multi-Tabel dengan whereHas

```php
// FILE: app/Http/Controllers/Admin/TransaksiController.php

if ($request->filled('search')) {
    $q = $request->search;
    $query->where(function ($q2) use ($q) {
        $q2->where('kode_pinjam', 'like', "%{$q}%")

        // Search berdasarkan nama/NIS anggota (tabel berbeda!)
        ->orWhereHas('anggota', function($a) use ($q) {
            $a->where('nama', 'like', "%{$q}%")
              ->orWhere('nis', 'like', "%{$q}%");
        })
        // whereHas = cari di relasi. "cari peminjaman yang PUNYA anggota
        // dengan nama mengandung $q"

        // Search berdasarkan judul buku (tabel berbeda!)
        ->orWhereHas('buku', function($b) use ($q) {
            $b->where('judul', 'like', "%{$q}%");
        });
    });
}
```

### Proses Pengembalian oleh Admin

```php
// FILE: app/Http/Controllers/Admin/TransaksiController.php

public function pengembalian(Peminjaman $transaksi)
{
    if ($transaksi->status === 'dikembalikan') {
        return back()->with('error', 'Buku sudah dikembalikan.');
        // Guard clause: keluar lebih awal jika kondisi tidak valid
    }

    $tanggalKembali = Carbon::today(); // tanggal hari ini
    $denda = 0;

    // Cek apakah terlambat
    if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
        // gt() = greater than (lebih besar dari / lebih muda dari)
        // Artinya: hari ini LEBIH LAMBAT dari batas kembali

        $selisih = $transaksi->tanggal_kembali_rencana
            ->diffInDays($tanggalKembali);
        // diffInDays() dari Carbon: hitung perbedaan hari

        $denda = $selisih * 1000; // Rp 1.000 per hari
    }

    // Update record peminjaman
    $transaksi->update([
        'tanggal_kembali_aktual' => $tanggalKembali,
        'status'                 => 'dikembalikan',
        'denda'                  => $denda,
    ]);

    // Tambah stok buku (karena sudah dikembalikan)
    $transaksi->buku->increment('stok');
    // increment() = UPDATE buku SET stok = stok + 1 WHERE id = ?
    // Lebih aman dari $buku->stok++ karena atomic (tidak ada race condition)

    return redirect()->route('admin.transaksi.index')
        ->with('success', 'Pengembalian berhasil. Denda: Rp ' .
            number_format($denda, 0, ',', '.'));
    // number_format(3000, 0, ',', '.') = "3.000"
}
```

---

## 9. FITUR DASHBOARD SISWA

### File yang Terlibat
```
app/Http/Controllers/Siswa/DashboardController.php ← Logika
resources/views/siswa/dashboard.blade.php           ← Tampilan
app/Models/Peminjaman.php                           ← Data transaksi
app/Models/Buku.php                                 ← Rekomendasi buku
```

### DashboardController Siswa

```php
// FILE: app/Http/Controllers/Siswa/DashboardController.php

public function index()
{
    // Ambil data anggota dari user yang sedang login
    $anggota = Auth::user()->anggota;
    // Auth::user() = object User yang sedang login
    // ->anggota = akses relasi hasOne ke tabel anggota
    // Setara dengan: SELECT * FROM anggota WHERE user_id = [id_user_login]

    // Auto-update status terlambat untuk siswa ini
    Peminjaman::where('anggota_id', $anggota->id)
        ->where('status', 'dipinjam')
        ->where('tanggal_kembali_rencana', '<', Carbon::today())
        ->update(['status' => 'terlambat']);

    // Statistik pribadi siswa
    $totalPinjam = Peminjaman::where('anggota_id', $anggota->id)
        ->whereIn('status', ['dipinjam', 'terlambat'])
        ->count();
    // whereIn = WHERE status IN ('dipinjam', 'terlambat')

    $totalDenda = Peminjaman::where('anggota_id', $anggota->id)
        ->sum('denda');
    // sum('denda') = SELECT SUM(denda) FROM peminjaman WHERE ...

    // 5 riwayat terbaru
    $riwayat = Peminjaman::with('buku')
        ->where('anggota_id', $anggota->id)
        ->latest()
        ->take(5)
        ->get();

    return view('siswa.dashboard', compact(...));
}
```

---

## 10. FITUR PINJAM BUKU (SISWA)

### File yang Terlibat
```
app/Http/Controllers/Siswa/PeminjamanController.php ← Semua logika
app/Models/Peminjaman.php                            ← Buat record baru
app/Models/Buku.php                                  ← Kurangi stok
resources/views/siswa/peminjaman/create.blade.php    ← Pilih buku
resources/views/siswa/peminjaman/index.blade.php     ← Riwayat
```

### Halaman Pilih Buku (create)

```php
// FILE: app/Http/Controllers/Siswa/PeminjamanController.php

public function create(Request $request)
{
    // Cek status akun siswa
    $anggota = Auth::user()->anggota;
    if (!$anggota || $anggota->status !== 'aktif') {
        return redirect()->route('siswa.dashboard')
            ->with('error', 'Akun anggota Anda tidak aktif.');
    }

    $search = $request->get('search', '');
    // get('search', '') = ambil ?search=xxx, default '' jika tidak ada

    // Hanya tampilkan buku yang stoknya tersedia
    $query = Buku::where('stok', '>', 0);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('pengarang', 'like', "%{$search}%")
              ->orWhere('kategori', 'like', "%{$search}%");
        });
    }

    $buku = $query->paginate(9)->withQueryString();
    // paginate(9) = 9 buku per halaman (cocok untuk grid 3×3)

    return view('siswa.peminjaman.create', compact('buku', 'search'));
}
```

### Proses Pinjam Buku (store) — Validasi Berlapis

```php
// FILE: app/Http/Controllers/Siswa/PeminjamanController.php

public function store(Request $request)
{
    // Validasi: buku_id harus ada di tabel buku
    $request->validate([
        'buku_id' => 'required|exists:buku,id',
        // exists:buku,id = cek bahwa nilai ada di tabel buku kolom id
        // Ini mencegah manipulasi ID dari luar
    ]);

    $anggota = Auth::user()->anggota;

    // GUARD 1: Akun harus aktif
    if (!$anggota || $anggota->status !== 'aktif') {
        return back()->with('error', 'Akun Anda tidak aktif.');
    }

    $buku = Buku::findOrFail($request->buku_id);

    // GUARD 2: Stok harus tersedia
    if ($buku->stok < 1) {
        return back()->with('error', 'Stok buku tidak tersedia saat ini.');
    }

    // GUARD 3: Tidak boleh pinjam buku yang sama 2 kali
    $sudahPinjam = Peminjaman::where('anggota_id', $anggota->id)
        ->where('buku_id', $buku->id)
        ->whereIn('status', ['dipinjam', 'terlambat'])
        ->exists();
    // exists() = lebih efisien dari count() > 0 untuk cek keberadaan

    if ($sudahPinjam) {
        return back()->with('error', 'Anda masih meminjam buku ini.');
    }

    // Semua validasi lolos → proses peminjaman

    // Generate kode unik untuk transaksi ini
    $kode = 'TRX-' . strtoupper(uniqid());
    // uniqid() = generate ID unik berdasarkan microtime
    // strtoupper() = jadikan huruf besar
    // Contoh hasil: "TRX-63F2A1B8C4E7D"

    // Buat record peminjaman baru
    Peminjaman::create([
        'kode_pinjam'             => $kode,
        'anggota_id'              => $anggota->id,
        'buku_id'                 => $buku->id,
        'tanggal_pinjam'          => Carbon::today(),
        'tanggal_kembali_rencana' => Carbon::today()->addDays(7),
        // addDays(7) = tambah 7 hari dari hari ini
        'status'                  => 'dipinjam',
    ]);

    // Kurangi stok buku
    $buku->decrement('stok');
    // decrement('stok') = UPDATE buku SET stok = stok - 1 WHERE id = ?
    // ATOMIC operation → aman dari race condition
    // (tidak seperti $buku->stok-- yang bisa salah jika 2 user pinjam bersamaan)

    return redirect()->route('siswa.peminjaman.index')
        ->with('success', 'Peminjaman buku "' . $buku->judul . '" berhasil. '
            . 'Harap kembalikan dalam 7 hari.');
}
```

### Rekomendasi Buku — Algoritma Pseudo-Random

```php
// FILE: app/Http/Controllers/Siswa/PeminjamanController.php

// Ambil ID buku yang sedang dipinjam siswa ini
$bukuDipinjam = Peminjaman::where('anggota_id', $anggota->id)
    ->whereIn('status', ['dipinjam', 'terlambat'])
    ->pluck('buku_id');
// pluck() = ambil satu kolom saja sebagai array
// Hasil: [3, 7, 12] (ID buku yang sedang dipinjam)

// Seed untuk random yang konsisten per user per hari
$recommendationSeed = Auth::id() . now()->format('Ymd');
// Contoh: "5" . "20260903" = "520260903"
// Setiap user dapat rekomendasi berbeda
// Setiap hari seed berubah (rekomendasi segar tiap hari)

$rekomendasiBuku = Buku::where('stok', '>', 0)
    ->whereNotIn('id', $bukuDipinjam)
    // Jangan rekomendasikan buku yang sedang dipinjam
    ->get()
    ->sortBy(fn ($buku) => crc32($recommendationSeed . ':' . $buku->id))
    // crc32() = hash function, menghasilkan angka konsisten dari string
    // Urutan "random" tapi konsisten: user yang sama hari yang sama
    // dapat urutan rekomendasi yang sama
    ->take(10)
    ->values(); // reset index array
```

---

## 11. FITUR PENGEMBALIAN BUKU (SISWA)

### File yang Terlibat
```
app/Http/Controllers/Siswa/PengembalianController.php ← Semua logika
resources/views/siswa/pengembalian/index.blade.php     ← Daftar dipinjam
resources/views/siswa/pengembalian/konfirmasi.blade.php← Konfirmasi + denda
```

### Alur 2 Langkah: Konfirmasi lalu Proses

```
Siswa klik "Kembalikan"
         ↓
GET /siswa/pengembalian/{id}/konfirmasi
→ konfirmasi() — tampilkan preview denda
         ↓
Siswa klik "Ya, Kembalikan"
         ↓
POST /siswa/pengembalian/{id}/proses
→ proses() — lakukan pengembalian sebenarnya
```

### konfirmasi() — Preview Denda Sebelum Konfirmasi

```php
// FILE: app/Http/Controllers/Siswa/PengembalianController.php

public function konfirmasi(Peminjaman $peminjaman)
{
    $anggota = Auth::user()->anggota;

    // Keamanan: pastikan peminjaman ini milik siswa yang login
    if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
        abort(403); // Forbidden - bukan miliknya
    }
    // Tanpa ini, siswa A bisa kembalikan buku siswa B dengan manipulasi URL!

    if ($peminjaman->status === 'dikembalikan') {
        return back()->with('error', 'Buku ini sudah dikembalikan.');
    }

    // Hitung denda (preview, belum disimpan)
    $today = Carbon::today();
    $denda = 0;
    if ($today->gt($peminjaman->tanggal_kembali_rencana)) {
        $selisih = $peminjaman->tanggal_kembali_rencana->diffInDays($today);
        $denda   = $selisih * 1000;
    }

    // Kirim denda ke view untuk ditampilkan ke siswa
    return view('siswa.pengembalian.konfirmasi', compact('peminjaman', 'denda'));
}
```

### proses() — Lakukan Pengembalian Sebenarnya

```php
// FILE: app/Http/Controllers/Siswa/PengembalianController.php

public function proses(Peminjaman $peminjaman)
{
    // Validasi kepemilikan (sama seperti konfirmasi)
    $anggota = Auth::user()->anggota;
    if (!$anggota || $peminjaman->anggota_id !== $anggota->id) {
        abort(403);
    }

    // Hitung ulang denda (jangan percaya data dari form/POST, hitung lagi di server)
    $today = Carbon::today();
    $denda = 0;
    if ($today->gt($peminjaman->tanggal_kembali_rencana)) {
        $selisih = $peminjaman->tanggal_kembali_rencana->diffInDays($today);
        $denda   = $selisih * 1000;
    }
    // Kenapa hitung ulang? Karena user bisa manipulasi data yang dikirim.
    // Selalu hitung di server, JANGAN percaya data dari client!

    // Update record peminjaman
    $peminjaman->update([
        'tanggal_kembali_aktual' => $today,
        'status'                 => 'dikembalikan',
        'denda'                  => $denda,
    ]);

    // Kembalikan stok
    $peminjaman->buku->increment('stok');
    // $peminjaman->buku = akses relasi belongsTo, dapat object Buku
    // ->increment('stok') = UPDATE buku SET stok = stok + 1

    // Pesan sukses yang informatif
    $msg = 'Pengembalian buku berhasil diajukan.';
    if ($denda > 0) {
        $msg .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
    }

    return redirect()->route('siswa.pengembalian.index')
        ->with('success', $msg);
}
```

---

## 12. SISTEM SEEDER — DATA AWAL

Seeder adalah script yang mengisi database dengan data awal secara otomatis.
Sangat berguna untuk development & testing agar tidak perlu input manual.

### File yang Terlibat
```
database/seeders/DatabaseSeeder.php  ← Induk: panggil seeder lain
database/seeders/BukuSeeder.php      ← 60 buku dari 10 kategori
database/seeders/PeminjamanSeeder.php← 7 contoh transaksi
```

### DatabaseSeeder — Orchestrator

```php
// FILE: database/seeders/DatabaseSeeder.php

public function run(): void
{
    // Buat user admin
    User::create([
        'name'     => 'Administrator',
        'email'    => 'admin@perpus.sch.id',
        'password' => Hash::make('admin123'),
        'role'     => 'admin',
    ]);

    // Buat user siswa + data anggota (2 tabel sekaligus)
    $siswa1 = User::create([...]);
    Anggota::create(['user_id' => $siswa1->id, ...]);

    // Panggil seeder lain
    $this->call(BukuSeeder::class);      // jalankan BukuSeeder
    $this->call(PeminjamanSeeder::class); // jalankan PeminjamanSeeder
}
```

### Cara Menjalankan Seeder

```bash
# Jalankan semua seeder
php artisan db:seed

# Hapus semua tabel, buat ulang, lalu seed
php artisan migrate:fresh --seed
# Ini yang paling sering dipakai saat development
```

---

## 13. HUBUNGAN ANTAR FILE — PETA LENGKAP

### Untuk Setiap Fitur, File Mana Terlibat?

```
FITUR               ROUTE       MIDDLEWARE      CONTROLLER              MODEL               VIEW
──────────────────────────────────────────────────────────────────────────────────────────────────
Landing Page        web.php     (publik)        LandingController       Buku                landing.blade.php
Login               web.php     guest           AuthController          User                auth/login.blade.php
Register            web.php     guest           AuthController          User, Anggota       auth/register.blade.php
Admin Dashboard     web.php     auth+admin      Admin/Dashboard         Buku,Anggota,Peminj admin/dashboard.blade.php
Kelola Buku         web.php     auth+admin      Admin/BukuController    Buku                admin/buku/
Kelola Anggota      web.php     auth+admin      Admin/AnggotaController Anggota, User       admin/anggota/
Kelola Transaksi    web.php     auth+admin      Admin/Transaksi         Peminjaman,Buku,Ang admin/transaksi/
Siswa Dashboard     web.php     auth+siswa      Siswa/Dashboard         Peminjaman, Buku    siswa/dashboard.blade.php
Pinjam Buku         web.php     auth+siswa      Siswa/Peminjaman        Peminjaman, Buku    siswa/peminjaman/
Pengembalian        web.php     auth+siswa      Siswa/Pengembalian      Peminjaman, Buku    siswa/pengembalian/
```

### Diagram Relasi Antar Model

```
User ──hasOne──► Anggota ──hasMany──► Peminjaman ──belongsTo──► Buku
 │                                        │
 │                                        └──belongsTo──► Anggota
 └──isAdmin() / isSiswa()  (method helper di model)


Dalam kode:
  $user->anggota          → dapat data anggota si user
  $anggota->peminjaman    → dapat semua peminjaman si anggota
  $peminjaman->buku       → dapat data buku yang dipinjam
  $peminjaman->anggota    → dapat data anggota yang meminjam
  $buku->peminjaman       → dapat semua peminjaman buku ini
```

### Alur Data Lengkap: Siswa Pinjam Buku

```
[browser]  POST /siswa/peminjaman
              |
[web.php]   Route::post → SiswaMiddleware → PeminjamanController::store()
              |
[middleware] SiswaMiddleware: auth()->check() && isSiswa() → lolos
              |
[controller] $request->validate(['buku_id' => 'required|exists:buku,id'])
              |
[controller] $anggota = Auth::user()->anggota
              |        ↑ Auth facade → User model → hasOne Anggota
              |
[controller] $buku = Buku::findOrFail($request->buku_id)
              |    ↑ Query: SELECT * FROM buku WHERE id = ?
              |
[controller] Validasi stok, duplikat pinjam
              |
[controller] Peminjaman::create([...])
              |    ↑ INSERT INTO peminjaman (...)
              |
[controller] $buku->decrement('stok')
              |    ↑ UPDATE buku SET stok = stok - 1 WHERE id = ?
              |
[controller] return redirect()->with('success', ...)
              |
[browser]   Tampil halaman riwayat + notif sukses
```

---

## RINGKASAN: KONSEP KUNCI YANG HARUS DIPAHAMI

| Konsep | Penjelasan Singkat | Contoh di Project |
|--------|-------------------|-------------------|
| **Route** | Peta URL → Controller | `Route::get('/login', [AuthController::class, 'showLogin'])` |
| **Middleware** | Filter sebelum Controller | `AdminMiddleware`: cek role admin |
| **Controller** | Otak logika | `BukuController::store()`: validasi + simpan + upload foto |
| **Model** | Jembatan ke database | `Buku::where('stok','>',0)->get()` |
| **View/Blade** | Template HTML dinamis | `@foreach($buku as $b) {{ $b->judul }} @endforeach` |
| **Eloquent ORM** | Query database pakai PHP | `Peminjaman::with('buku')->latest()->get()` |
| **Relasi** | Hubungan antar tabel | `hasOne`, `hasMany`, `belongsTo` |
| **Eager Loading** | Efisiensi query relasi | `with(['anggota', 'buku'])` |
| **Route Model Binding** | Auto-inject model dari URL | `function show(Buku $buku)` |
| **Flash Message** | Notif sekali tampil | `->with('success', 'Berhasil!')` |
| **Pagination** | Bagi data per halaman | `->paginate(10)` |
| **Storage** | Kelola file upload | `$request->file()->store('covers', 'public')` |
| **Carbon** | Manipulasi tanggal | `Carbon::today()->addDays(7)` |
| **Validation** | Validasi input otomatis | `'required\|email\|unique:users,email'` |
| **Hash** | Enkripsi password | `Hash::make('password123')` |
| **Auth Facade** | Akses user yang login | `Auth::user()->anggota` |
| **increment/decrement** | Update angka atomic | `$buku->decrement('stok')` |
| **withCount** | Hitung relasi | `Buku::withCount('peminjaman')` |

---

*Dokumentasi ini ditulis berdasarkan kode nyata yang ada di project.*
*Setiap potongan kode dapat ditemukan di file yang disebutkan di atasnya.*

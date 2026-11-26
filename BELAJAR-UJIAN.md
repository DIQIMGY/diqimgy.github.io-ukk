# 📚 DOKUMENTASI UJIAN — SISTEM PEMINJAMAN BUKU PERPUSTAKAAN
> Dibuat khusus untuk persiapan ujian. Baca dari atas ke bawah secara urut.

---

## DAFTAR ISI
1. [Gambaran Umum Proyek](#1-gambaran-umum-proyek)
2. [Teknologi yang Digunakan](#2-teknologi-yang-digunakan)
3. [Struktur Folder Lengkap](#3-struktur-folder-lengkap)
4. [Database & Migrasi](#4-database--migrasi)
5. [Model-Model](#5-model-model)
6. [Middleware & Autentikasi](#6-middleware--autentikasi)
7. [Routes (Semua URL)](#7-routes-semua-url)
8. [Controller — Admin](#8-controller--admin)
9. [Controller — Siswa](#9-controller--siswa)
10. [Alur Bisnis Utama](#10-alur-bisnis-utama)
11. [Kode-Kode Penting yang Sering Ditanya](#11-kode-kode-penting-yang-sering-ditanya)
12. [Pertanyaan Penguji + Jawaban Lengkap](#12-pertanyaan-penguji--jawaban-lengkap)

---

## 1. GAMBARAN UMUM PROYEK

**Nama Proyek:** Sistem Peminjaman Buku Perpustakaan Sekolah  
**Nama Database:** `peminjaman_buku`  
**URL Lokal:** `http://localhost/peminjaman_buku/public`

### Fungsi Utama
Aplikasi web untuk mengelola peminjaman buku di perpustakaan sekolah. Ada dua peran pengguna:
- **Admin** → mengelola buku, anggota, transaksi peminjaman/pengembalian
- **Siswa** → mendaftar, mengajukan pinjam, mengajukan kembali, memberi ulasan

### Yang Bisa Dilakukan Sistem
| Fitur | Admin | Siswa |
|-------|-------|-------|
| Kelola data buku (CRUD) | ✅ | ❌ |
| Kelola anggota (CRUD) | ✅ | ❌ |
| Setujui/tolak pinjam | ✅ | ❌ |
| Setujui/tolak pengembalian | ✅ | ❌ |
| Hitung & tandai denda lunas | ✅ | ❌ |
| Kelola series buku | ✅ | ❌ |
| Kelola banner landing page | ✅ | ❌ |
| Daftar akun sendiri | ❌ | ✅ |
| Ajukan pinjam buku | ❌ | ✅ |
| Ajukan pengembalian | ❌ | ✅ |
| Beri ulasan & rating | ❌ | ✅ |
| Edit profil | ❌ | ✅ |

---

## 2. TEKNOLOGI YANG DIGUNAKAN

### Backend
| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHP** | ≥ 8.2 | Bahasa pemrograman utama |
| **Laravel** | 12.x | Framework PHP (MVC) |
| **Carbon** | (bundled Laravel) | Manipulasi tanggal/waktu |

### Database
| Teknologi | Keterangan |
|-----------|------------|
| **MySQL** | Database utama |
| **Laravel Eloquent ORM** | Interaksi dengan database lewat kode PHP |
| **Laravel Migration** | Versi kontrol struktur database |

### Frontend
| Teknologi | Keterangan |
|-----------|------------|
| **Blade** | Template engine bawaan Laravel |
| **Bootstrap** | Framework CSS untuk tampilan |
| **HTML/CSS/JS** | Standar web |

### Tools Dev (hanya untuk development, tidak di production)
| Tool | Fungsi |
|------|--------|
| **Laragon** | Server lokal (PHP + MySQL + Apache) |
| **Laravel Pint** | Code formatter PHP |
| **Laravel Sail** | Docker untuk development |
| **PHPUnit** | Testing |

### Penting: Tidak ada package tambahan di production selain Laravel default!

---

## 3. STRUKTUR FOLDER LENGKAP

```
peminjaman_buku/               ← ROOT PROYEK
│
├── app/                       ← Kode aplikasi utama
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         ← Controller khusus admin
│   │   │   │   ├── AnggotaController.php
│   │   │   │   ├── BukuController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── LandingAdController.php
│   │   │   │   ├── SeriesController.php
│   │   │   │   ├── TransaksiController.php
│   │   │   │   └── UlasanController.php
│   │   │   ├── Siswa/         ← Controller khusus siswa
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── PeminjamanController.php
│   │   │   │   ├── PengembalianController.php
│   │   │   │   ├── ProfilController.php
│   │   │   │   └── UlasanController.php
│   │   │   ├── AuthController.php     ← Login, Register, Logout
│   │   │   ├── Controller.php         ← Base controller
│   │   │   ├── LandingController.php  ← Halaman publik
│   │   │   └── SeriesController.php   ← Halaman series publik
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php    ← Proteksi halaman admin
│   │       └── SiswaMiddleware.php    ← Proteksi halaman siswa
│   ├── Models/
│   │   ├── Anggota.php        ← Data profil anggota perpustakaan
│   │   ├── Buku.php           ← Data koleksi buku
│   │   ├── LandingAd.php      ← Banner/iklan di landing page
│   │   ├── Peminjaman.php     ← Transaksi peminjaman (MODEL TERPENTING)
│   │   ├── Series.php         ← Seri buku
│   │   ├── SeriesBuku.php     ← Pivot series ↔ buku
│   │   ├── Ulasan.php         ← Rating dan komentar buku
│   │   └── User.php           ← Akun login (email, password, role)
│   └── Providers/
│       └── AppServiceProvider.php  ← View composer untuk badge notifikasi
│
├── bootstrap/
│   ├── app.php                ← Registrasi middleware alias (PENTING!)
│   └── providers.php          ← Daftar service provider
│
├── config/
│   ├── app.php                ← Konfigurasi aplikasi (nama, timezone, locale)
│   ├── auth.php               ← Konfigurasi guard & provider autentikasi
│   ├── database.php           ← Konfigurasi koneksi database
│   └── ...
│
├── database/
│   ├── migrations/            ← 16 file migrasi (urutan penting!)
│   └── factories/             ← Factory untuk testing
│
├── resources/
│   └── views/                 ← Semua tampilan Blade
│       ├── layouts/
│       │   └── app.blade.php          ← Layout utama (navbar, sidebar)
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── landing.blade.php          ← Halaman depan publik
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── anggota/               ← index, create, edit, show, pending-siswa, edit-admin
│       │   ├── buku/                  ← index, create, edit, show
│       │   ├── transaksi/             ← index, create, show
│       │   ├── series/                ← index, create, edit
│       │   ├── ulasan/                ← index
│       │   └── landing-ads/           ← index
│       └── siswa/
│           ├── dashboard.blade.php
│           ├── peminjaman/            ← index, create, detail, show
│           ├── pengembalian/          ← index, konfirmasi
│           ├── profil/                ← index
│           └── ulasan/                ← create
│
├── routes/
│   └── web.php                ← SEMUA DEFINISI ROUTE (URL aplikasi)
│
├── storage/
│   └── app/public/            ← File upload (cover buku, foto anggota)
│       ├── covers/            ← Cover buku
│       └── anggota/           ← Foto profil anggota
│
├── .env                       ← Konfigurasi environment (database, dll)
├── artisan                    ← CLI Laravel
└── composer.json              ← Dependensi PHP
```

---

## 4. DATABASE & MIGRASI

### Konfigurasi Database (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peminjaman_buku
DB_USERNAME=root
DB_PASSWORD=
```

### Daftar Tabel (urutan migration)

#### Tabel `users`
```
id | name | email (unique) | email_verified_at | password | role (admin/siswa) | foto | remember_token | timestamps
```
- Role `admin` atau `siswa`
- Kolom `foto` ditambah via migration 2026_10_21

#### Tabel `anggota`
```
id | user_id (FK→users) | nis (unique) | nama | kelas | alamat | telepon | foto | status (aktif/nonaktif) | timestamps
```
- Status `aktif`/`nonaktif` — siswa yang mendaftar sendiri awalnya `pending`
- `user_id` cascade delete (anggota ikut terhapus jika user dihapus)
- Nama tabel: `anggota` (bukan `anggotas`)

#### Tabel `buku`
```
id | kode_buku (unique) | isbn | judul | pengarang | penerbit | tahun_terbit | kategori |
stok | cover | deskripsi | rating | is_featured | returned_at | waitlist_count |
status_launching (tersedia/segera) | tanggal_rilis | timestamps
```
- `stok` bertambah/berkurang sesuai transaksi
- `status_launching` = `tersedia` (bisa dipinjam) atau `segera` (coming soon)

#### Tabel `peminjaman`
```
id | kode_pinjam (unique) | anggota_id (FK) | buku_id (FK) |
tanggal_pengajuan | tanggal_pinjam (nullable) | tanggal_kembali_rencana (nullable) |
tanggal_kembali_aktual | status (VARCHAR 20) | denda | denda_dibayar | denda_dibayar_at |
keterangan | approved_at | return_requested_at | rejected_at | rejection_reason | timestamps
```
- `tanggal_pinjam` nullable karena saat `pending` belum ada tanggal
- Status awalnya ENUM, lalu diubah ke VARCHAR(20) supaya bisa tambah nilai baru

#### Tabel `ulasan`
```
id | peminjaman_id (FK, UNIQUE) | buku_id (FK) | anggota_id (FK) | rating | komentar | timestamps
```
- `peminjaman_id` UNIQUE → satu peminjaman hanya bisa satu ulasan

#### Tabel `series`
```
id | nama_series | penulis | deskripsi | cover_series | slug (unique) | timestamps
```

#### Tabel `series_buku` (pivot)
```
id | series_id (FK) | buku_id (FK) | urutan_baca | urutan_terbit | is_penutup | created_at
```
- `unique(series_id, buku_id)` → satu buku tidak bisa masuk seri yang sama dua kali
- Tidak ada `updated_at`

#### Tabel `landing_ads`
```
id | image_path | title | description | youtube_url | sort_order | is_active | timestamps
```

### Urutan Migrasi (PENTING — urutan ini harus diingat)
```
1. create_users_table             → tabel users + sessions + password_reset_tokens
2. create_cache_table             → tabel cache & cache_locks
3. create_jobs_table              → tabel jobs (queue)
4. create_anggota_table           → tabel anggota (FK ke users)
5. create_buku_table              → tabel buku (kolom dasar)
6. create_peminjaman_table        → tabel peminjaman (FK ke anggota & buku)
7. create_ulasan_table            → tabel ulasan (FK ke peminjaman, buku, anggota)
8. add_additional_fields_to_buku  → tambah isbn, rating, is_featured, dll ke buku
9. add_launching_status_to_buku   → tambah status_launching, tanggal_rilis ke buku
10. create_series_table           → tabel series
11. create_series_buku_table      → tabel pivot series_buku
12. create_landing_ads_table      → tabel landing_ads (kolom awal)
13. add_fine_payment_tracking     → tambah denda_dibayar, denda_dibayar_at ke peminjaman
14. add_detail_fields_to_landing_ads → tambah title, description, youtube_url
15. add_approval_fields_to_peminjaman → ubah status jadi VARCHAR, tambah tanggal_pengajuan, approved_at, dll
16. make_tanggal_pinjam_nullable  → tanggal_pinjam & tanggal_kembali_rencana jadi nullable
17. add_pending_kembali           → tambah return_requested_at ke peminjaman
18. add_foto_to_users_table       → tambah kolom foto ke users
19. add_approval_status_to_users  → tambah approval_status ke users
```

---

## 5. MODEL-MODEL

### User.php — Akun Login
```php
// Lokasi: app/Models/User.php

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role', 'foto'];
    protected $hidden   = ['password', 'remember_token']; // tidak tampil di JSON

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed', // Laravel auto-hash saat assign
        ];
    }

    // Helper role — DIPAKAI DI MIDDLEWARE
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isSiswa(): bool { return $this->role === 'siswa'; }

    // Relasi: 1 user punya 1 anggota
    public function anggota() { return $this->hasOne(Anggota::class); }
}
```

### Anggota.php — Profil Perpustakaan
```php
// Lokasi: app/Models/Anggota.php

class Anggota extends Model
{
    protected $table = 'anggota'; // ← WAJIB eksplisit karena nama tidak standar

    protected $fillable = ['user_id','nis','nama','kelas','alamat','telepon','foto','status'];

    public function user()     { return $this->belongsTo(User::class); }
    public function peminjaman() { return $this->hasMany(Peminjaman::class); }

    // Hanya peminjaman yang masih aktif (belum selesai)
    public function peminjamanAktif() {
        return $this->hasMany(Peminjaman::class)->whereIn('status', [
            Peminjaman::STATUS_PENDING,
            Peminjaman::STATUS_DIPINJAM,
            Peminjaman::STATUS_TERLAMBAT,
            Peminjaman::STATUS_PENDING_KEMBALI,
        ]);
    }
}
```

### Buku.php — Koleksi Buku
```php
// Lokasi: app/Models/Buku.php

class Buku extends Model
{
    protected $table = 'buku'; // ← WAJIB eksplisit

    protected $casts = [
        'is_featured'   => 'boolean',
        'rating'        => 'decimal:1',
        'tanggal_rilis' => 'date',
    ];

    public function peminjaman() { return $this->hasMany(Peminjaman::class); }
    public function ulasan()     { return $this->hasMany(Ulasan::class); }

    // Relasi many-to-many ke Series via tabel pivot series_buku
    public function series() {
        return $this->belongsToMany(Series::class, 'series_buku')
                    ->withPivot(['urutan_baca','urutan_terbit','is_penutup']);
    }

    public function isAvailable(): bool { return $this->stok > 0; }
}
```

### Peminjaman.php — Model Terpenting!
```php
// Lokasi: app/Models/Peminjaman.php

class Peminjaman extends Model
{
    protected $table = 'peminjaman'; // ← WAJIB eksplisit

    // ── STATUS CONSTANTS (gunakan ini, jangan hardcode string) ──
    const STATUS_PENDING         = 'pending';          // menunggu persetujuan admin
    const STATUS_DIPINJAM        = 'dipinjam';         // sudah disetujui, buku keluar
    const STATUS_TERLAMBAT       = 'terlambat';        // lewat batas kembali
    const STATUS_PENDING_KEMBALI = 'pending_kembali';  // siswa ajukan kembali
    const STATUS_DIKEMBALIKAN    = 'dikembalikan';     // selesai, buku kembali
    const STATUS_DITOLAK         = 'ditolak';          // pengajuan ditolak admin

    protected $casts = [
        'tanggal_pengajuan'       => 'date',
        'tanggal_pinjam'          => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual'  => 'date',
        'denda_dibayar'           => 'boolean',
        'approved_at'             => 'datetime',
        'return_requested_at'     => 'datetime',
        'rejected_at'             => 'datetime',
    ];

    public function anggota() { return $this->belongsTo(Anggota::class); }
    public function buku()    { return $this->belongsTo(Buku::class); }
    public function ulasan()  { return $this->hasOne(Ulasan::class); } // 1 peminjaman = 1 ulasan

    // Helper cek status
    public function isPending(): bool        { return $this->status === self::STATUS_PENDING; }
    public function isDipinjam(): bool       { return $this->status === self::STATUS_DIPINJAM; }
    public function isTerlambat(): bool      { return $this->status === self::STATUS_TERLAMBAT; }
    public function isPendingKembali(): bool { return $this->status === self::STATUS_PENDING_KEMBALI; }
    public function isDikembalikan(): bool   { return $this->status === self::STATUS_DIKEMBALIKAN; }
    public function isDitolak(): bool        { return $this->status === self::STATUS_DITOLAK; }

    // isAktif() = buku masih di tangan siswa (belum kembali ke rak)
    public function isAktif(): bool {
        return in_array($this->status, [
            self::STATUS_DIPINJAM,
            self::STATUS_TERLAMBAT,
            self::STATUS_PENDING_KEMBALI,
        ]);
    }

    // Hitung denda: Rp 1.000 per hari keterlambatan
    public function hitungDenda(): int {
        if ($this->tanggal_kembali_aktual &&
            $this->tanggal_kembali_aktual->gt($this->tanggal_kembali_rencana)) {
            $selisih = $this->tanggal_kembali_rencana->diffInDays($this->tanggal_kembali_aktual);
            return $selisih * 1000;
        }
        return 0;
    }

    // Label & warna untuk tampilan
    public function statusLabel(): string {
        return match($this->status) {
            self::STATUS_PENDING         => 'Menunggu Persetujuan',
            self::STATUS_DIPINJAM        => 'Dipinjam',
            self::STATUS_TERLAMBAT       => 'Terlambat',
            self::STATUS_PENDING_KEMBALI => 'Menunggu Konfirmasi Kembali',
            self::STATUS_DIKEMBALIKAN    => 'Dikembalikan',
            self::STATUS_DITOLAK         => 'Ditolak',
            default                      => ucfirst($this->status),
        };
    }

    public function statusColor(): string {
        return match($this->status) {
            self::STATUS_PENDING         => 'warning',   // kuning
            self::STATUS_DIPINJAM        => 'primary',   // biru
            self::STATUS_TERLAMBAT       => 'danger',    // merah
            self::STATUS_PENDING_KEMBALI => 'info',      // biru muda
            self::STATUS_DIKEMBALIKAN    => 'success',   // hijau
            self::STATUS_DITOLAK         => 'secondary', // abu
            default                      => 'secondary',
        };
    }
}
```

### Series.php — Seri Buku
```php
// Lokasi: app/Models/Series.php

class Series extends Model
{
    protected $table = 'series';

    // Auto-generate slug dari nama_series saat pertama dibuat
    protected static function booted(): void {
        static::creating(function (Series $s) {
            if (empty($s->slug)) {
                $s->slug = Str::slug($s->nama_series); // "Harry Potter" → "harry-potter"
            }
        });
    }

    // Relasi many-to-many ke Buku via tabel pivot series_buku
    public function buku() {
        return $this->belongsToMany(Buku::class, 'series_buku')
                    ->withPivot(['urutan_baca','urutan_terbit','is_penutup'])
                    ->orderBy('series_buku.urutan_baca');
    }
}
```

### Ulasan.php — Rating Buku
```php
// Lokasi: app/Models/Ulasan.php

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $fillable = ['peminjaman_id','buku_id','anggota_id','rating','komentar'];

    public function peminjaman() { return $this->belongsTo(Peminjaman::class); }
    public function buku()       { return $this->belongsTo(Buku::class); }
    public function anggota()    { return $this->belongsTo(Anggota::class); }

    // Accessor: tampilkan bintang ★★★★☆
    public function getStarsAttribute(): string {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
```

---

## 6. MIDDLEWARE & AUTENTIKASI

### Cara Middleware Didaftarkan (bootstrap/app.php)
```php
// Lokasi: bootstrap/app.php
// INILAH TEMPAT MIDDLEWARE ALIAS DIDAFTARKAN — BUKAN di Kernel.php (itu Laravel lama)

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
        ]);
    })
    ->create();
```
> **Laravel 12 tidak pakai Kernel.php!** Middleware alias didaftarkan langsung di `bootstrap/app.php`.

### AdminMiddleware.php
```php
// Lokasi: app/Http/Middleware/AdminMiddleware.php
// Melindungi semua route /admin — hanya admin yang boleh masuk

public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin.');
    }
    return $next($request);
}
```

### SiswaMiddleware.php
```php
// Lokasi: app/Http/Middleware/SiswaMiddleware.php
// Melindungi semua route /siswa — hanya siswa aktif yang boleh masuk

public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check() || !auth()->user()->isSiswa()) {
        abort(403, 'Akses ditolak. Halaman ini hanya untuk Siswa.');
    }

    // KHUSUS: Blokir siswa yang anggotanya masih pending (belum disetujui admin)
    $anggota = auth()->user()->anggota;
    if ($anggota && $anggota->status === 'pending') {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->with('warning', 'Akun kamu masih menunggu persetujuan admin.');
    }

    return $next($request);
}
```

### AppServiceProvider.php — View Composer
```php
// Lokasi: app/Providers/AppServiceProvider.php
// Mengirim data ke SEMUA halaman yang pakai layouts.app
// (badge notifikasi di navbar admin)

public function boot(): void
{
    View::composer('layouts.app', function ($view): void {
        $adminPendingReturnCount = 0;
        $adminUnpaidFineCount    = 0;
        $adminPendingSiswaCount  = 0;

        if (auth()->check() && auth()->user()->isAdmin()) {
            $adminPendingReturnCount = Peminjaman::where('status', Peminjaman::STATUS_PENDING_KEMBALI)->count();
            $adminUnpaidFineCount    = Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)
                ->where('denda', '>', 0)->where('denda_dibayar', false)->count();
            $adminPendingSiswaCount  = \App\Models\Anggota::where('status', 'pending')->count();
        }

        $view->with(compact('adminPendingReturnCount', 'adminUnpaidFineCount', 'adminPendingSiswaCount'));
    });
}
```

---

## 7. ROUTES (SEMUA URL)

### Halaman Publik (tidak perlu login)
```
GET  /                      → landing page utama
GET  /buku                  → semua buku per kategori
GET  /ulasan                → semua ulasan
GET  /series                → daftar seri buku
GET  /series/{slug}         → detail satu seri
```

### Auth
```
GET  /login                 → form login     (hanya untuk guest)
POST /login                 → proses login   (hanya untuk guest)
GET  /register              → form daftar    (hanya untuk guest)
POST /register              → proses daftar  (hanya untuk guest)
POST /logout                → logout         (butuh login)
```

### Admin (prefix /admin, middleware: auth + admin)
```
GET  /admin/dashboard

── Buku (pakai Route::resource) ──
GET    /admin/buku               → index
GET    /admin/buku/create        → form tambah
POST   /admin/buku               → simpan baru
GET    /admin/buku/{buku}        → detail
GET    /admin/buku/{buku}/edit   → form edit
PUT    /admin/buku/{buku}        → update
DELETE /admin/buku/{buku}        → hapus

── Anggota ──
GET    /admin/anggota                        → daftar siswa & admin
GET    /admin/anggota/create                 → form tambah anggota
POST   /admin/anggota                        → simpan anggota baru
GET    /admin/anggota/{anggotum}             → detail anggota
GET    /admin/anggota/{anggotum}/edit        → form edit
PUT    /admin/anggota/{anggotum}             → update
DELETE /admin/anggota/{anggotum}             → hapus
GET    /admin/anggota-pending                → daftar siswa menunggu approval
POST   /admin/anggota/{anggotum}/approve     → setujui siswa
POST   /admin/anggota/{anggotum}/reject      → tolak siswa
GET    /admin/admin/{user}/edit              → form edit admin
PUT    /admin/admin/{user}                   → update admin
DELETE /admin/admin/{user}                   → hapus admin

── Transaksi ──
GET    /admin/transaksi                            → daftar semua transaksi
GET    /admin/transaksi/create                     → form input manual
POST   /admin/transaksi                            → simpan transaksi manual
GET    /admin/transaksi/{transaksi}                → detail
GET    /admin/transaksi/{transaksi}/edit           → form edit
PUT    /admin/transaksi/{transaksi}                → update
POST   /admin/transaksi/{transaksi}/approve        → setujui pengajuan pinjam
POST   /admin/transaksi/{transaksi}/reject         → tolak pengajuan pinjam
POST   /admin/transaksi/{transaksi}/kembali        → langsung proses pengembalian
POST   /admin/transaksi/{transaksi}/approve-kembali → konfirmasi pengembalian
POST   /admin/transaksi/{transaksi}/reject-kembali  → tolak pengajuan pengembalian
POST   /admin/transaksi/{transaksi}/denda/lunas     → tandai denda sudah dibayar
DELETE /admin/transaksi/{transaksi}                → hapus transaksi

── Series, Landing Ads, Ulasan ──
(CRUD series, landing-ads, hapus ulasan — lihat routes/web.php)
```

### Siswa (prefix /siswa, middleware: auth + siswa)
```
GET  /siswa/dashboard

── Peminjaman ──
GET  /siswa/peminjaman                    → riwayat peminjaman siswa
GET  /siswa/peminjaman/pinjam             → pilih buku untuk dipinjam
GET  /siswa/peminjaman/pinjam/{buku}      → detail buku sebelum pinjam
POST /siswa/peminjaman                    → ajukan pinjam (status → pending)
GET  /siswa/peminjaman/{peminjaman}       → detail transaksi

── Pengembalian ──
GET  /siswa/pengembalian                        → daftar buku aktif
GET  /siswa/pengembalian/{peminjaman}/konfirmasi → preview denda
POST /siswa/pengembalian/{peminjaman}/proses     → ajukan kembali (→ pending_kembali)

── Profil ──
GET /siswa/profil          → halaman profil
PUT /siswa/profil          → update profil
PUT /siswa/profil/password → ganti password

── Ulasan ──
GET  /siswa/ulasan/{peminjaman}       → form beri ulasan
POST /siswa/ulasan/{peminjaman}       → simpan ulasan
POST /siswa/ulasan/{peminjaman}/skip  → lewati ulasan
```

---

## 8. CONTROLLER — ADMIN

### AuthController.php
```php
// Lokasi: app/Http/Controllers/AuthController.php

// LOGIN
public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    if (Auth::attempt($request->only('email','password'), $request->boolean('remember'))) {
        $request->session()->regenerate(); // ← cegah session fixation

        // Blokir siswa pending
        $user = Auth::user();
        if ($user->isSiswa() && $user->anggota && $user->anggota->status === 'pending') {
            Auth::logout();
            return redirect()->route('login')->with('warning', '...');
        }

        return $this->redirectByRole(); // admin → /admin/dashboard, siswa → /siswa/dashboard
    }

    return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
}

// REGISTER — siswa daftar sendiri
public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',   // ← harus ada field password_confirmation
        'nis'      => 'required|string|unique:anggota,nis',
        'kelas'    => 'required|string|max:20',
    ]);

    $user = User::create([
        'name' => $request->name, 'email' => $request->email,
        'password' => Hash::make($request->password), 'role' => 'siswa',
    ]);

    Anggota::create([
        'user_id' => $user->id, 'nis' => $request->nis, 'nama' => $request->name,
        'kelas' => $request->kelas, 'status' => 'pending', // ← PENDING dulu
    ]);

    // TIDAK auto-login — harus tunggu persetujuan admin
    return redirect()->route('login')->with('info', 'Menunggu persetujuan admin.');
}
```

### Admin/BukuController.php
```php
// CRUD Buku — Upload cover ke storage/public/covers/
// Validasi khusus: buku "segera" WAJIB tanggal_rilis

public function store(Request $request)
{
    $request->validate([
        'kode_buku'        => 'required|string|unique:buku,kode_buku',
        'stok'             => 'required|integer|min:0',
        'cover'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'status_launching' => 'required|in:tersedia,segera',
        'tanggal_rilis'    => 'nullable|date|after_or_equal:today',
        // ... field lainnya
    ]);

    if ($request->status_launching === 'segera' && !$request->tanggal_rilis) {
        return back()->withErrors(['tanggal_rilis' => 'Wajib diisi untuk buku Segera Hadir']);
    }

    $data = $request->except('cover');
    if ($request->hasFile('cover')) {
        $data['cover'] = $request->file('cover')->store('covers', 'public');
        // ↑ File disimpan di storage/app/public/covers/
        // ↑ Akses publik via /storage/covers/ (setelah php artisan storage:link)
    }
    Buku::create($data);
}
```

### Admin/AnggotaController.php — Route Model Binding Khusus
```php
// CATATAN PENTING: Laravel menggunakan "anggotum" sebagai nama binding
// karena tabel bernama "anggota" (Laravel singularize → "anggotum")

// Di route:
Route::get('/anggota/{anggotum}', [AnggotaController::class, 'show']);

// Di controller:
public function show(Anggota $anggotum) {
    // Laravel otomatis cari Anggota::find($anggotum_dari_url)
}
```

### Admin/TransaksiController.php — Approve Peminjaman
```php
public function approve(Peminjaman $transaksi)
{
    if ($transaksi->status !== Peminjaman::STATUS_PENDING) {
        return back()->with('error', 'Hanya yang berstatus pending bisa disetujui.');
    }

    if ($transaksi->buku->stok < 1) {
        return back()->with('error', 'Stok habis, tidak bisa approve.');
    }

    $tanggalPinjam  = Carbon::today();
    $tanggalKembali = $tanggalPinjam->copy()->addDays(7); // batas 7 hari

    $transaksi->update([
        'status'                  => Peminjaman::STATUS_DIPINJAM,
        'tanggal_pinjam'          => $tanggalPinjam,
        'tanggal_kembali_rencana' => $tanggalKembali,
        'approved_at'             => now(),
    ]);

    $transaksi->buku->decrement('stok'); // ← stok baru berkurang saat approve
}
```

### Admin/TransaksiController.php — Approve Pengembalian
```php
public function approveKembali(Peminjaman $transaksi)
{
    // Tanggal yang dipakai = saat siswa MENGAJUKAN (bukan saat admin klik)
    // Ini adil — siswa tidak kena denda tambahan saat menunggu konfirmasi admin
    $tanggalKembali = $transaksi->return_requested_at
        ? Carbon::parse($transaksi->return_requested_at)->startOfDay()
        : Carbon::today();

    $denda = 0;
    if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
        $selisih = $transaksi->tanggal_kembali_rencana->diffInDays($tanggalKembali);
        $denda   = $selisih * 1000; // Rp 1.000/hari
    }

    $transaksi->update([
        'tanggal_kembali_aktual' => $tanggalKembali,
        'status'                 => Peminjaman::STATUS_DIKEMBALIKAN,
        'denda'                  => $denda,
    ]);

    $transaksi->buku->increment('stok'); // ← stok bertambah saat buku kembali
}
```

### Auto-Update Status Terlambat
```php
// Di setiap halaman yang perlu cek keterlambatan, jalankan ini:
// (Ada di: TransaksiController::index(), Siswa/DashboardController, dll)

Peminjaman::where('status', Peminjaman::STATUS_DIPINJAM)
    ->where('tanggal_kembali_rencana', '<', Carbon::today())
    ->update(['status' => Peminjaman::STATUS_TERLAMBAT]);
// Tidak ada scheduler/cron — dijalankan setiap halaman dibuka
```

---

## 9. CONTROLLER — SISWA

### Siswa/PeminjamanController.php — Ajukan Pinjam
```php
public function store(Request $request)
{
    $request->validate(['buku_id' => 'required|exists:buku,id']);

    $buku = Buku::findOrFail($request->buku_id);

    // Cek stok (harus > 0)
    if ($buku->stok < 1) {
        return back()->with('error', 'Stok buku tidak tersedia.');
    }

    // Cek duplikat: siswa tidak boleh mengajukan buku yang sama jika masih aktif/pending
    $sudahAdaRequest = Peminjaman::where('anggota_id', $anggota->id)
        ->where('buku_id', $buku->id)
        ->whereIn('status', [
            Peminjaman::STATUS_PENDING,
            Peminjaman::STATUS_DIPINJAM,
            Peminjaman::STATUS_TERLAMBAT,
        ])->exists();

    if ($sudahAdaRequest) {
        return back()->with('error', 'Anda sudah memiliki pengajuan atau sedang meminjam buku ini.');
    }

    Peminjaman::create([
        'kode_pinjam'      => 'TRX-' . strtoupper(uniqid()),
        'anggota_id'       => $anggota->id,
        'buku_id'          => $buku->id,
        'tanggal_pengajuan'=> Carbon::today(),
        'tanggal_pinjam'   => null,  // diisi admin saat approve
        'tanggal_kembali_rencana' => null, // diisi admin saat approve
        'status'           => Peminjaman::STATUS_PENDING, // ← pending dulu
    ]);
    // STOK TIDAK BERKURANG SAAT INI — hanya saat admin approve
}
```

### Siswa/PengembalianController.php — Ajukan Kembali
```php
public function proses(Peminjaman $peminjaman)
{
    // Hanya status dipinjam/terlambat yang bisa diajukan kembali
    if (!in_array($peminjaman->status, [
        Peminjaman::STATUS_DIPINJAM,
        Peminjaman::STATUS_TERLAMBAT
    ])) {
        return redirect()->route('siswa.pengembalian.index')
            ->with('error', 'Status tidak valid.');
    }

    $peminjaman->update([
        'status'              => Peminjaman::STATUS_PENDING_KEMBALI,
        'return_requested_at' => now(), // ← waktu pengajuan dicatat
    ]);
    // STOK BELUM BERTAMBAH — baru bertambah saat admin approve pengembalian
}
```

---

## 10. ALUR BISNIS UTAMA

### A. Alur Registrasi Siswa
```
Siswa isi form register
    ↓
User dibuat (role=siswa) + Anggota dibuat (status=PENDING)
    ↓
Redirect ke login dengan pesan "menunggu persetujuan"
    ↓
Admin buka /admin/anggota-pending → lihat daftar pending
    ↓
Admin klik Setujui → status anggota berubah PENDING → AKTIF
    ↓
Siswa bisa login dan akses fitur
```

### B. Alur Peminjaman Lengkap
```
[1] Siswa ajukan pinjam
    → status: PENDING
    → stok: TIDAK berubah
    → tanggal_pinjam: NULL

[2a] Admin SETUJUI
    → status: DIPINJAM
    → tanggal_pinjam: hari ini
    → tanggal_kembali_rencana: hari ini + 7 hari
    → approved_at: timestamp sekarang
    → stok: BERKURANG 1
    
[2b] Admin TOLAK
    → status: DITOLAK
    → rejected_at: timestamp sekarang
    → rejection_reason: alasan (opsional)
    → stok: TIDAK berubah

[3] Jika melewati tanggal_kembali_rencana
    → status otomatis: TERLAMBAT
    (dijalankan saat halaman dibuka, bukan scheduler)

[4] Siswa ajukan pengembalian
    → status: PENDING_KEMBALI
    → return_requested_at: timestamp sekarang
    → stok: TIDAK berubah (buku masih di tangan siswa)

[5a] Admin KONFIRMASI pengembalian
    → tanggal_kembali_aktual: tanggal return_requested_at
    → denda dihitung dari return_requested_at vs tanggal_kembali_rencana
    → status: DIKEMBALIKAN
    → stok: BERTAMBAH 1

[5b] Admin TOLAK pengembalian
    → status: kembali ke DIPINJAM (belum lewat batas) atau TERLAMBAT (sudah lewat)
    → return_requested_at: NULL
    → stok: TIDAK berubah
```

### C. Aturan Stok — SANGAT PENTING
```
Stok BERKURANG hanya saat: approve() peminjaman
Stok BERTAMBAH hanya saat:  approveKembali() atau pengembalian() langsung

Status pending    → stok TIDAK berubah
Status ditolak    → stok TIDAK berubah
Status pending_kembali → stok TIDAK berubah (buku masih di siswa)
```

### D. Hitungan Denda
```
Denda = jumlah_hari_telat × Rp 1.000

Contoh:
- tanggal_kembali_rencana = 1 November
- return_requested_at     = 5 November
- Keterlambatan = 4 hari
- Denda = 4 × 1.000 = Rp 4.000

Denda dihitung dari tanggal PENGAJUAN pengembalian (return_requested_at),
BUKAN tanggal admin mengkonfirmasi — supaya siswa tidak kena denda
gara-gara admin lambat konfirmasi.
```

### E. Alur Ulasan
```
Peminjaman selesai (status = DIKEMBALIKAN)
    ↓
Siswa buka /siswa/ulasan/{peminjaman}
    ↓
Isi rating (1-5 bintang) + komentar (opsional)
    ↓
Simpan ke tabel ulasan (unique: peminjaman_id → tidak bisa double submit)
    ↓
Atau pilih SKIP → tidak ada ulasan tersimpan
```

---

## 11. KODE-KODE PENTING YANG SERING DITANYA

### Eager Loading (Mencegah N+1 Query Problem)
```php
// SALAH — N+1 query (1 query ambil peminjaman + N query untuk tiap buku)
$peminjaman = Peminjaman::all();
foreach ($peminjaman as $p) {
    echo $p->buku->judul; // ← query ke DB setiap iterasi!
}

// BENAR — Eager loading (2 query saja)
$peminjaman = Peminjaman::with(['anggota', 'buku'])->get();
// ↑ 1 query untuk peminjaman + 1 query untuk semua buku terkait
```

### withCount — Hitung Relasi Tanpa Load Data
```php
// Tambah kolom peminjaman_count ke setiap buku
$bukuPopuler = Buku::withCount('peminjaman')
    ->orderByDesc('peminjaman_count')
    ->take(8)
    ->get();
```

### Route Model Binding
```php
// Laravel otomatis cari record berdasarkan {id} di URL
// Jika tidak ditemukan → 404 otomatis

public function show(Peminjaman $transaksi)
{
    // $transaksi sudah langsung berisi data Peminjaman yang dicari
    return view('admin.transaksi.show', compact('transaksi'));
}
```

### decrement & increment — Ubah Angka di DB
```php
$buku->decrement('stok');      // stok - 1
$buku->increment('stok');      // stok + 1
$buku->increment('stok', 2);   // stok + 2
```

### Validasi Unique Kecuali Diri Sendiri
```php
// Saat UPDATE: email boleh sama dengan email dirinya sendiri
'email' => 'required|email|unique:users,email,' . $user->id,
//                                                ↑ abaikan jika ID ini
```

### Upload File
```php
// Upload file ke storage/app/public/covers/
if ($request->hasFile('cover')) {
    $path = $request->file('cover')->store('covers', 'public');
    // $path contoh: "covers/random123.jpg"
}

// Hapus file lama
Storage::disk('public')->delete($buku->cover);

// Supaya file bisa diakses via URL, jalankan sekali:
// php artisan storage:link
// File akan tersedia di /storage/covers/nama-file.jpg
```

### Paginate dengan Query String
```php
$data = Model::query()
    ->where(...)
    ->paginate(10)
    ->withQueryString(); // ← supaya parameter search/filter tetap ada di URL halaman selanjutnya
```

### Carbon — Manipulasi Tanggal
```php
use Carbon\Carbon;

Carbon::today()              // tanggal hari ini (00:00:00)
Carbon::now()                // tanggal + waktu sekarang
$date->addDays(7)            // tambah 7 hari
$date->copy()->addDays(7)    // tambah 7 hari TANPA ubah original
$date->gt($other)            // apakah $date > $other?
$date->diffInDays($other)    // selisih hari
```

### Auth Helpers
```php
Auth::check()           // apakah user sudah login?
Auth::user()            // ambil data user yang login
Auth::user()->isAdmin() // cek apakah admin
Auth::user()->anggota   // akses data anggota via relasi
Auth::attempt($creds)   // coba login dengan email+password
Auth::logout()          // logout
auth()->check()         // alias dari Auth::check()
```

### Session Flash Message
```php
// Set pesan (akan muncul sekali di view berikutnya)
return redirect()->route('...')->with('success', 'Berhasil!');
return redirect()->route('...')->with('error', 'Gagal!');
return redirect()->route('...')->with('warning', 'Perhatian!');

// Tampilkan di Blade:
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
```

### Blade — Sintaks Dasar
```blade
{{-- Komentar Blade --}}
{{ $variabel }}              {{-- output dengan escape HTML --}}
{!! $variabel !!}            {{-- output HTML mentah (hati-hati XSS) --}}

@if ($kondisi)
@elseif ($kondisi2)
@else
@endif

@foreach ($items as $item)
    {{ $item->nama }}
@endforeach

@extends('layouts.app')
@section('content')
    ...isi halaman...
@endsection

@include('partials.nama-partial')

{{ route('admin.buku.index') }}                  {{-- generate URL dari nama route --}}
{{ route('admin.buku.edit', $buku->id) }}        {{-- URL dengan parameter --}}

@csrf            {{-- wajib di dalam form POST --}}
@method('PUT')   {{-- untuk form PUT/DELETE (HTML hanya kenal GET/POST) --}}
```

---

## 12. PERTANYAAN PENGUJI + JAWABAN LENGKAP

---

### ❓ Apa itu Laravel dan kenapa dipakai di proyek ini?

**Jawab:**
Laravel adalah framework PHP berbasis pola MVC (Model-View-Controller). Dipakai karena menyediakan fitur siap pakai seperti routing, ORM (Eloquent), autentikasi, validasi, dan template engine Blade — sehingga pengembangan lebih cepat dan kode lebih terstruktur. Versi yang digunakan adalah Laravel 12 dengan PHP 8.2.

---

### ❓ Jelaskan pola MVC di proyek ini!

**Jawab:**
- **Model** → `app/Models/` → merepresentasikan tabel database dan logika bisnis. Contoh: `Peminjaman.php` berisi konstanta status, relasi, dan method `hitungDenda()`.
- **View** → `resources/views/` → tampilan Blade yang dikirim ke browser. Contoh: `admin/transaksi/index.blade.php`.
- **Controller** → `app/Http/Controllers/` → menerima request, ambil data dari Model, kirim ke View. Contoh: `Admin/TransaksiController.php`.

Alurnya: Request dari browser → Route → Middleware → Controller → Model → View → Response ke browser.

---

### ❓ Ada berapa role pengguna? Bagaimana cara membedakannya?

**Jawab:**
Ada 2 role: `admin` dan `siswa`. Role disimpan di kolom `role` pada tabel `users`. Cara membedakan menggunakan method di Model `User`:
```php
public function isAdmin(): bool { return $this->role === 'admin'; }
public function isSiswa(): bool { return $this->role === 'siswa'; }
```
Middleware kemudian mengecek role ini setiap request masuk ke halaman yang dilindungi.

---

### ❓ Apa itu Middleware dan bagaimana cara kerjanya di proyek ini?

**Jawab:**
Middleware adalah "penjaga gerbang" yang berjalan sebelum request sampai ke controller. Di proyek ini ada dua middleware custom:
- `AdminMiddleware` → dipasang di semua route `/admin`. Jika bukan admin, `abort(403)`.
- `SiswaMiddleware` → dipasang di semua route `/siswa`. Jika bukan siswa, `abort(403)`. Juga mengusir siswa yang masih `pending`.

Middleware didaftarkan di `bootstrap/app.php` (Laravel 12, bukan Kernel.php):
```php
$middleware->alias([
    'admin' => AdminMiddleware::class,
    'siswa' => SiswaMiddleware::class,
]);
```
Lalu dipasang di route: `Route::middleware(['auth', 'admin'])->group(...)`.

---

### ❓ Jelaskan alur peminjaman dari awal sampai selesai!

**Jawab:**
1. Siswa pilih buku → klik Pinjam → sistem buat record `Peminjaman` dengan status `pending`. **Stok belum berubah.**
2. Admin buka halaman transaksi → klik Setujui → status berubah ke `dipinjam`, `tanggal_pinjam` = hari ini, `tanggal_kembali_rencana` = hari ini + 7 hari. **Stok berkurang 1.**
3. Jika lewat `tanggal_kembali_rencana`, status otomatis berubah ke `terlambat` (dicek setiap halaman dibuka).
4. Siswa ajukan pengembalian → status berubah ke `pending_kembali`. **Stok belum berubah.**
5. Admin konfirmasi pengembalian → sistem hitung denda, status berubah ke `dikembalikan`. **Stok bertambah 1.**

---

### ❓ Kenapa stok tidak langsung berkurang saat siswa mengajukan pinjam?

**Jawab:**
Karena pengajuan siswa masih berstatus `pending` — belum tentu disetujui admin. Kalau stok langsung berkurang saat pengajuan, bisa terjadi situasi stok habis padahal buku sebenarnya masih ada (karena pengajuan tersebut ditolak). Stok baru berkurang saat admin benar-benar menyetujui dengan `approve()`.

---

### ❓ Bagaimana cara menghitung denda keterlambatan?

**Jawab:**
Denda = jumlah hari terlambat × Rp 1.000.

Denda dihitung berdasarkan `return_requested_at` (saat siswa mengajukan pengembalian), **bukan** saat admin mengkonfirmasi. Alasannya: supaya siswa tidak terkena denda tambahan hanya karena admin lambat mengkonfirmasi.

Kodenya:
```php
if ($tanggalKembali->gt($transaksi->tanggal_kembali_rencana)) {
    $selisih = $transaksi->tanggal_kembali_rencana->diffInDays($tanggalKembali);
    $denda   = $selisih * 1000;
}
```

---

### ❓ Apa itu Eloquent ORM dan apa keuntungannya?

**Jawab:**
Eloquent adalah ORM (Object-Relational Mapping) bawaan Laravel yang memungkinkan kita berinteraksi dengan database menggunakan kode PHP berbasis objek, tanpa menulis SQL mentah.

Contoh perbandingan:
```php
// SQL mentah:
"SELECT * FROM buku WHERE stok > 0 ORDER BY created_at DESC LIMIT 10"

// Eloquent:
Buku::where('stok', '>', 0)->latest()->take(10)->get();
```

Keuntungan: kode lebih mudah dibaca, ada proteksi otomatis dari SQL injection, dan bisa chain method.

---

### ❓ Jelaskan relasi antar tabel di proyek ini!

**Jawab:**
```
users (1) ──── (1) anggota           → User hasOne Anggota
anggota (1) ── (N) peminjaman        → Anggota hasMany Peminjaman
buku (1) ───── (N) peminjaman        → Buku hasMany Peminjaman
peminjaman (1) ─ (1) ulasan          → Peminjaman hasOne Ulasan
buku (N) ────── (N) series           → belongsToMany via tabel pivot series_buku
```

---

### ❓ Apa bedanya hasOne, hasMany, dan belongsTo?

**Jawab:**
- `hasOne` → satu record punya tepat satu record di tabel lain. Contoh: `User hasOne Anggota` (satu akun = satu profil anggota).
- `hasMany` → satu record punya banyak record di tabel lain. Contoh: `Anggota hasMany Peminjaman` (satu anggota bisa pinjam banyak kali).
- `belongsTo` → kebalikan dari hasOne/hasMany, dari sisi yang menyimpan foreign key. Contoh: `Peminjaman belongsTo Anggota` (peminjaman menyimpan `anggota_id`).
- `belongsToMany` → relasi banyak-ke-banyak via tabel pivot. Contoh: `Buku belongsToMany Series` via `series_buku`.

---

### ❓ Apa itu Migration dan kenapa penting?

**Jawab:**
Migration adalah file PHP yang mendefinisikan struktur tabel database. Fungsinya seperti "version control" untuk database — setiap perubahan struktur dibuat dalam file migration baru, sehingga seluruh tim bisa menjalankan `php artisan migrate` dan mendapatkan struktur database yang sama persis.

Perintah penting:
```bash
php artisan migrate           # jalankan semua migration yang belum dijalankan
php artisan migrate:rollback  # batalkan migration terakhir
php artisan migrate:fresh     # hapus semua tabel lalu migrate ulang dari awal
```

---

### ❓ Kenapa ada banyak file migration untuk tabel yang sama (misal: banyak migration untuk `peminjaman`)?

**Jawab:**
Karena setelah tabel dibuat, ada kebutuhan baru yang muncul dan perlu menambah/mengubah kolom. Daripada mengubah migration lama (yang bisa merusak database orang lain yang sudah migrate), dibuat migration baru yang khusus melakukan perubahan itu. Ini praktik standar dalam pengembangan tim.

Contoh untuk tabel `peminjaman`:
- Migration pertama: kolom dasar
- Migration berikutnya: tambah `denda_dibayar`, `denda_dibayar_at`
- Migration lagi: ubah status dari ENUM ke VARCHAR, tambah `tanggal_pengajuan`, `approved_at`
- Dst.

---

### ❓ Apa itu Route Model Binding? Kenapa di anggota pakai "anggotum"?

**Jawab:**
Route Model Binding adalah fitur Laravel yang otomatis mencari record di database berdasarkan parameter di URL. Kalau tidak ditemukan, otomatis menghasilkan 404.

```php
// Di route: /admin/anggota/{anggotum}
// Laravel lihat tipe parameter di controller: Anggota $anggotum
// Laravel otomatis jalankan: Anggota::findOrFail($anggotum_dari_url)
```

Kenapa `anggotum` bukan `anggota`? Karena Laravel menggunakan aturan *singularization* bahasa Inggris untuk nama binding. Kata "anggota" disingularisasi menjadi "anggotum" oleh library yang dipakai Laravel. Ini tidak masalah secara fungsional, hanya penamaan binding.

---

### ❓ Apa perbedaan `$request->validate()` dengan `Validator::make()`?

**Jawab:**
- `$request->validate()` → cara singkat, jika validasi gagal otomatis redirect back dengan error. Dipakai di sebagian besar controller proyek ini.
- `Validator::make()` → cara manual, memberi kontrol lebih untuk menentukan sendiri apa yang terjadi saat gagal.

Keduanya menggunakan aturan validasi yang sama, perbedaannya hanya di cara menangani kegagalan.

---

### ❓ Bagaimana cara upload file (foto/cover) di proyek ini?

**Jawab:**
File disimpan di `storage/app/public/covers/` atau `storage/app/public/anggota/` menggunakan:
```php
$path = $request->file('cover')->store('covers', 'public');
// $path → "covers/namafile.jpg" — ini yang disimpan di database
```

Supaya file bisa diakses via URL, perlu menjalankan sekali:
```bash
php artisan storage:link
```
Ini membuat symlink dari `public/storage` ke `storage/app/public`, sehingga file bisa diakses via `http://localhost/peminjaman_buku/public/storage/covers/namafile.jpg`.

Untuk hapus file:
```php
Storage::disk('public')->delete($buku->cover);
```

---

### ❓ Apa itu Blade dan apa keunggulannya dibanding PHP murni?

**Jawab:**
Blade adalah template engine Laravel. Keunggulannya:
1. Sintaks lebih bersih dan mudah dibaca (`@if`, `@foreach`, `{{ }}`)
2. Mendukung pewarisan layout (`@extends`, `@section`, `@yield`) — hindari kode duplikat
3. `{{ }}` otomatis meng-escape HTML (mencegah XSS)
4. `@include` dan `@component` untuk memecah tampilan menjadi bagian-bagian kecil
5. File `.blade.php` dikompilasi ke PHP murni dan di-cache untuk performa

---

### ❓ Kenapa form yang menggunakan PUT/DELETE butuh `@method('PUT')`?

**Jawab:**
HTML secara standar hanya mendukung method `GET` dan `POST` pada form. Laravel mendukung method `PUT`, `PATCH`, dan `DELETE`, tapi karena browser tidak bisa mengirimnya langsung, Laravel menggunakan teknik "method spoofing" — form dikirim sebagai POST dengan tambahan field tersembunyi `_method=PUT`. Blade helper `@method('PUT')` otomatis menghasilkan input hidden tersebut.

---

### ❓ Apa itu CSRF dan kenapa `@csrf` wajib di setiap form?

**Jawab:**
CSRF (Cross-Site Request Forgery) adalah serangan di mana situs jahat memaksa browser user untuk mengirim request ke aplikasi kita. Laravel melindungi dari ini dengan token CSRF — setiap form harus menyertakan token unik yang cocok dengan token di session. `@csrf` menghasilkan input hidden `<input type="hidden" name="_token" value="...">`. Jika token tidak ada atau tidak cocok, Laravel mengembalikan error 419.

---

### ❓ Apa itu Eager Loading dan N+1 Problem?

**Jawab:**
N+1 Problem terjadi saat kita mengambil N record lalu melakukan query tambahan untuk setiap record (1 query utama + N query tambahan). Ini sangat lambat.

Contoh masalah:
```php
$peminjaman = Peminjaman::all(); // 1 query
foreach ($peminjaman as $p) {
    echo $p->buku->judul; // N query (1 per peminjaman)
}
// Total: 1 + N query!
```

Solusi dengan Eager Loading:
```php
$peminjaman = Peminjaman::with('buku')->get(); // 2 query saja
// 1 query untuk peminjaman + 1 query untuk SEMUA buku terkait
```

---

### ❓ Apa itu View Composer di AppServiceProvider?

**Jawab:**
View Composer adalah cara untuk mengirim data ke view tertentu setiap kali view tersebut di-render, tanpa harus mengirim data itu di setiap controller. Di proyek ini, `AppServiceProvider` mendaftarkan View Composer untuk `layouts.app` yang menghitung:
- Berapa pengembalian yang menunggu konfirmasi
- Berapa denda yang belum lunas
- Berapa siswa yang menunggu approval

Data ini tampil sebagai badge notifikasi di navbar admin tanpa perlu dikirim manual dari setiap controller.

---

### ❓ Bagaimana alur registrasi siswa sampai bisa login?

**Jawab:**
1. Siswa isi form `/register` → `AuthController::register()` membuat `User` (role=siswa) + `Anggota` (status=**pending**)
2. Sistem **tidak** auto-login — redirect ke `/login` dengan pesan "menunggu persetujuan"
3. Admin buka `/admin/anggota-pending` → lihat daftar siswa pending
4. Admin klik "Setujui" → `AnggotaController::approveSiswa()` mengubah status `pending` → `aktif`
5. Siswa sekarang bisa login

Kalau siswa pending mencoba login, `AuthController::login()` mendeteksinya dan langsung logout + redirect dengan pesan peringatan.

---

### ❓ Apa itu `compact()` dan kenapa dipakai di controller?

**Jawab:**
`compact()` adalah fungsi PHP yang membuat array asosiatif dari variabel lokal. Dipakai untuk meneruskan variabel dari controller ke view dengan cara yang ringkas.

```php
$buku = Buku::all();
$kategoris = ['Fiksi', 'Sains'];

// Tanpa compact:
return view('admin.buku.index', ['buku' => $buku, 'kategoris' => $kategoris]);

// Dengan compact (lebih ringkas):
return view('admin.buku.index', compact('buku', 'kategoris'));
// ↑ Nama string harus sama persis dengan nama variabel
```

---

### ❓ Apa itu `withQueryString()` di pagination?

**Jawab:**
Saat menggunakan `paginate()`, link halaman selanjutnya/sebelumnya hanya berisi `?page=2`. Jika ada parameter lain di URL (misalnya `?search=harry&status=dipinjam&page=1`), parameter tersebut akan hilang saat berpindah halaman. `withQueryString()` memastikan semua parameter URL ikut terbawa di setiap link pagination.

---

### ❓ Kenapa tabel `anggota`, `buku`, `peminjaman` perlu `protected $table`?

**Jawab:**
Secara default, Laravel menentukan nama tabel dari nama model dengan aturan: pluralisasi bahasa Inggris. Contoh: model `User` → tabel `users`, model `Book` → tabel `books`. Tapi:
- Model `Anggota` → Laravel tebak tabelnya `anggota` (kebetulan benar, tapi tetap perlu eksplisit)
- Model `Buku` → Laravel tebak `bukus` (SALAH! Tabel kita `buku`)
- Model `Peminjaman` → Laravel tebak `peminjamans` (SALAH! Tabel kita `peminjaman`)

Karena nama tabel tidak mengikuti konvensi Laravel, kita harus mendefinisikannya secara eksplisit dengan `protected $table = 'nama_tabel'`.

---

### ❓ Apa itu `$fillable` di Model?

**Jawab:**
`$fillable` adalah daftar kolom yang boleh diisi via *mass assignment* (seperti `Model::create([...])` atau `$model->fill([...])`). Ini adalah proteksi dari *mass assignment vulnerability* — serangan di mana pengguna mengirim field tambahan yang tidak diinginkan.

Jika kolom tidak ada di `$fillable`, Laravel akan mengabaikannya saat create/update massal.

---

### ❓ Apa bedanya `Carbon::today()` dan `Carbon::now()`?

**Jawab:**
- `Carbon::today()` → tanggal hari ini jam 00:00:00. Dipakai untuk perbandingan tanggal (misal: cek keterlambatan).
- `Carbon::now()` → tanggal dan waktu saat ini dengan jam yang tepat. Dipakai untuk timestamp (misal: `approved_at`, `return_requested_at`).

Di proyek ini: `tanggal_pinjam` dan `tanggal_kembali_rencana` pakai `Carbon::today()`, sedangkan `approved_at` pakai `now()`.

---

### ❓ Bagaimana cara kerja `Auth::attempt()`?

**Jawab:**
`Auth::attempt(['email' => $email, 'password' => $password])` melakukan:
1. Cari user di database berdasarkan `email`
2. Verifikasi `password` menggunakan `Hash::check()` (bcrypt)
3. Jika cocok, set user sebagai user yang sedang login (simpan di session)
4. Return `true` jika berhasil, `false` jika gagal

Setelah berhasil, perlu memanggil `$request->session()->regenerate()` untuk mencegah *session fixation attack*.

---

### ❓ Apa itu `abort(403)` di middleware?

**Jawab:**
`abort(403)` menghentikan eksekusi dan mengembalikan response HTTP dengan status code 403 (Forbidden). Di proyek ini dipakai di middleware saat user mencoba akses halaman yang bukan haknya (bukan admin akses `/admin`, atau bukan siswa akses `/siswa`).

---

### ❓ Sebutkan status-status yang ada di peminjaman dan artinya!

**Jawab:**
| Status | Arti |
|--------|------|
| `pending` | Siswa sudah ajukan, menunggu persetujuan admin |
| `dipinjam` | Admin sudah approve, buku sedang di tangan siswa |
| `terlambat` | Sudah melewati batas tanggal kembali |
| `pending_kembali` | Siswa sudah ajukan pengembalian, menunggu konfirmasi admin |
| `dikembalikan` | Admin sudah konfirmasi, buku sudah kembali ke rak |
| `ditolak` | Admin menolak pengajuan pinjam siswa |

---

### ❓ Kenapa status peminjaman diubah dari ENUM ke VARCHAR?

**Jawab:**
ENUM di MySQL tidak bisa ditambah nilai baru tanpa mengubah struktur tabel secara destructive. Karena semakin lama status semakin bertambah (awalnya hanya 3: dipinjam, dikembalikan, terlambat — lalu ditambah pending, ditolak, pending_kembali), diputuskan untuk mengubah ke VARCHAR(20) yang lebih fleksibel. Perubahan ini dilakukan via migration `2026_10_07_000001_add_approval_fields_to_peminjaman_table.php` menggunakan raw SQL `ALTER TABLE`.

---

### ❓ Apa fungsi `php artisan storage:link`?

**Jawab:**
Perintah ini membuat symlink (tautan simbolis) dari folder `public/storage` ke `storage/app/public`. Tanpa ini, file yang di-upload tidak bisa diakses via URL karena folder `storage/app/` tidak berada di dalam folder `public/` yang bisa diakses web server. Perintah ini hanya perlu dijalankan sekali per instalasi.

---

### ❓ Apa itu `withPivot()` di relasi many-to-many?

**Jawab:**
Secara default, relasi `belongsToMany` hanya mengambil data dari tabel utama (bukan tabel pivot). `withPivot(['kolom1', 'kolom2'])` memberitahu Eloquent untuk juga mengambil kolom-kolom tertentu dari tabel pivot.

Di proyek ini:
```php
// Tanpa withPivot — tidak bisa akses $buku->pivot->urutan_baca
// Dengan withPivot — bisa akses data dari tabel series_buku
$series->buku()->withPivot(['urutan_baca','urutan_terbit','is_penutup'])->get();
// Lalu di view: $buku->pivot->urutan_baca
```

---

### ❓ Bagaimana cara menambah admin baru di sistem ini?

**Jawab:**
Admin tidak bisa daftar sendiri via form register (form register hanya untuk siswa). Ada dua cara menambah admin:
1. Admin yang sudah ada membuat admin baru via `/admin/anggota` (tab Admin) → klik Tambah Admin
2. Manual via `php artisan tinker`:
```php
\App\Models\User::create([
    'name' => 'Admin Baru', 'email' => 'admin@email.com',
    'password' => \Hash::make('password123'), 'role' => 'admin'
]);
```

---

### ❓ Apa itu `session()->regenerate()` dan kenapa penting setelah login?

**Jawab:**
Session regenerate mengganti ID session yang lama dengan ID session baru setelah login berhasil. Ini mencegah *session fixation attack* — serangan di mana penyerang mendapatkan session ID sebelum user login, lalu menggunakan session ID yang sama untuk hijack session setelah user login. Dengan regenerate, session ID lama tidak berlaku lagi.

---

### ❓ Jelaskan apa yang terjadi saat hapus anggota!

**Jawab:**
Di `AnggotaController::destroy()`:
1. Hapus file foto dari `storage` jika ada
2. Hapus record `anggota` (harus dihapus dulu karena ada FK dari `anggota` ke `users`)
3. Hapus record `user` yang terhubung

Kalau urutan dibalik (hapus `user` dulu), akan error FK constraint karena `anggota.user_id` masih menunjuk ke user yang ingin dihapus. Meski bisa pakai cascade, tapi kode ini melakukan hapus foto secara eksplisit dulu.

---

*Semangat ujiannya! Kalau sudah paham alur bisnis (terutama peminjaman & stok), pola MVC, middleware, dan relasi antar tabel — pertanyaan apapun bisa dijawab dengan logis.* 🎯

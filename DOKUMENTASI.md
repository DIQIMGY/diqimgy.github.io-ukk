# 📚 DOKUMENTASI SISTEM PEMINJAMAN BUKU PERPUSTAKAAN SEKOLAH
### Dibuat dengan Laravel — Dokumentasi Lengkap untuk Presentasi

---

## DAFTAR ISI
1. [Latar Belakang & Tujuan](#1-latar-belakang--tujuan)
2. [Teknologi yang Digunakan](#2-teknologi-yang-digunakan)
3. [Pola Arsitektur MVC](#3-pola-arsitektur-mvc)
4. [Struktur Folder Project](#4-struktur-folder-project)
5. [Database & Tabel](#5-database--tabel)
6. [Fitur-Fitur Sistem](#6-fitur-fitur-sistem)
7. [Alur Sistem (Flowchart)](#7-alur-sistem-flowchart)
8. [Penjelasan File Penting](#8-penjelasan-file-penting)
9. [Routes (URL Sistem)](#9-routes-url-sistem)
10. [Cara Menjalankan Project](#10-cara-menjalankan-project)

---

## 1. LATAR BELAKANG & TUJUAN

### Masalah yang Diselesaikan
Sistem perpustakaan sekolah yang masih manual (buku catatan, kartu anggota kertas)
memiliki banyak kelemahan:
- Susah mencari data buku yang tersedia
- Tidak tahu siapa yang sedang meminjam buku apa
- Sulit menghitung denda keterlambatan
- Tidak ada notifikasi batas waktu pengembalian
- Data mudah hilang atau rusak

### Solusi: Sistem Digital
Aplikasi web ini menggantikan sistem manual dengan fitur:
- Cari buku secara digital (judul, kategori, pengarang)
- Siswa bisa lihat stok buku real-time
- Admin bisa kelola peminjaman dari satu dashboard
- Denda dihitung otomatis oleh sistem
- Data tersimpan aman di database

---

## 2. TEKNOLOGI YANG DIGUNAKAN

```
┌──────────────────────────────────────────────────┐
│                BROWSER (User)                    │
│   HTML5 + CSS3 + JavaScript + Bootstrap 5.3      │
├──────────────────────────────────────────────────┤
│                  SERVER                          │
│   PHP 8.x + Laravel 11 + Blade Template          │
├──────────────────────────────────────────────────┤
│                 DATABASE                         │
│   MySQL (via Laragon)                            │
└──────────────────────────────────────────────────┘
```

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHP** | 8.x | Bahasa pemrograman server-side |
| **Laravel** | 11 | Framework PHP (struktur & tools) |
| **MySQL** | 8.x | Database penyimpanan data |
| **Bootstrap** | 5.3 | Library CSS untuk tampilan responsif |
| **Bootstrap Icons** | 1.11 | Ikon-ikon di tampilan |
| **Blade** | (Laravel) | Template engine untuk HTML dinamis |
| **Laragon** | - | Server lokal (Apache + MySQL + PHP) |
| **Carbon** | (Laravel) | Library untuk manipulasi tanggal |

### Penjelasan Singkat Setiap Teknologi

**PHP** — Bahasa program yang berjalan di server. Semua logika bisnis (cek stok,
hitung denda, simpan data) ditulis dalam PHP.

**Laravel** — Framework (kerangka kerja) PHP yang menyediakan struktur terorganisir.
Tanpa Laravel kita harus buat routing, validasi, ORM dari nol. Laravel menyediakan
semua itu secara siap pakai.

**MySQL** — Database relasional. Data buku, anggota, dan peminjaman disimpan di sini
dalam bentuk tabel-tabel yang saling berhubungan.

**Bootstrap** — Library CSS yang menyediakan komponen siap pakai (tombol, card,
tabel, form, grid responsif). Menghemat waktu styling.

**Blade** — Sistem template Laravel. Memungkinkan kita menulis PHP di dalam HTML
dengan sintaks yang lebih bersih menggunakan `{{ }}` dan `@foreach`, `@if`, dll.

**Laragon** — Aplikasi yang menjalankan server web lokal di komputer. Di dalamnya
ada Apache (web server), MySQL (database), dan PHP.

---

## 3. POLA ARSITEKTUR MVC

MVC adalah singkatan dari **Model - View - Controller**. Ini adalah cara mengorganisir
kode agar rapi, mudah dipelihara, dan tidak berantakan.

```
USER (Browser)
     │
     │ Request: GET /siswa/peminjaman
     ▼
┌─────────────┐
│  ROUTES     │  ← web.php: "URL ini → Controller ini"
│  (web.php)  │
└──────┬──────┘
       │
       ▼
┌──────────────────┐       ┌──────────┐
│   CONTROLLER     │◄─────►│  MODEL   │
│                  │       │          │
│ Terima request,  │       │ Ambil &  │
│ validasi input,  │       │ simpan   │
│ koordinasi data  │       │ data ke  │
│ kirim ke View    │       │ Database │
└────────┬─────────┘       └──────────┘
         │
         ▼
┌──────────────────┐
│      VIEW        │
│  (Blade .php)    │
│                  │
│  HTML + data →   │
│  Tampil ke user  │
└──────────────────┘
```

### Contoh Nyata — Siswa Buka Halaman Pinjam Buku

```
1. Siswa klik menu "Pinjam Buku"
   URL: GET /siswa/peminjaman/pinjam

2. Routes (web.php) membaca:
   Route::get('/peminjaman/pinjam', [PeminjamanController::class, 'create'])

3. PeminjamanController::create() dijalankan:
   - Ambil data buku yang stok > 0 dari database
   - Kirim data ke View

4. View (siswa/peminjaman/create.blade.php) menerima data:
   - Render daftar buku dalam kartu-kartu
   - Tampilkan form pencarian
   - Render tombol "Pinjam" di setiap buku

5. Browser tampilkan halaman ke siswa
```

---

## 4. STRUKTUR FOLDER PROJECT

```
peminjaman_buku/                    ← ROOT project
│
├── app/                            ← Logika utama aplikasi
│   ├── Http/
│   │   ├── Controllers/            ← Pengendali request
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php   ← Statistik admin
│   │   │   │   ├── BukuController.php        ← CRUD buku
│   │   │   │   ├── AnggotaController.php     ← Kelola anggota
│   │   │   │   └── TransaksiController.php   ← Kelola peminjaman
│   │   │   ├── Siswa/
│   │   │   │   ├── DashboardController.php   ← Dashboard siswa
│   │   │   │   ├── PeminjamanController.php  ← Proses pinjam
│   │   │   │   └── PengembalianController.php← Proses kembali
│   │   │   ├── AuthController.php            ← Login/Register/Logout
│   │   │   └── LandingController.php         ← Halaman publik
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php           ← Proteksi halaman admin
│   │       └── SiswaMiddleware.php           ← Proteksi halaman siswa
│   └── Models/
│       ├── User.php       ← Model tabel users
│       ├── Buku.php       ← Model tabel buku
│       ├── Anggota.php    ← Model tabel anggota
│       └── Peminjaman.php ← Model tabel peminjaman
│
├── database/
│   ├── migrations/        ← Script pembuatan tabel database
│   │   ├── create_users_table.php
│   │   ├── create_buku_table.php
│   │   ├── create_anggota_table.php
│   │   ├── create_peminjaman_table.php
│   │   └── add_launching_status_to_buku_table.php
│   └── seeders/           ← Data awal untuk testing
│       ├── DatabaseSeeder.php    ← Induk seeder
│       ├── BukuSeeder.php        ← 60 buku (10 kategori × 6 buku)
│       └── PeminjamanSeeder.php  ← 7 data transaksi contoh
│
├── resources/
│   └── views/             ← Semua file tampilan
│       ├── landing.blade.php          ← Halaman utama (publik)
│       ├── layouts/
│       │   └── app.blade.php          ← Layout dashboard (sidebar)
│       ├── auth/
│       │   ├── login.blade.php        ← Form login
│       │   └── register.blade.php    ← Form daftar
│       ├── admin/
│       │   ├── dashboard.blade.php   ← Dashboard admin
│       │   ├── buku/                 ← Halaman kelola buku
│       │   ├── anggota/              ← Halaman kelola anggota
│       │   └── transaksi/            ← Halaman kelola transaksi
│       └── siswa/
│           ├── dashboard.blade.php   ← Dashboard siswa
│           ├── peminjaman/           ← Halaman pinjam buku
│           └── pengembalian/         ← Halaman kembalikan buku
│
├── routes/
│   └── web.php            ← Semua URL/route terdaftar di sini
│
├── public/
│   └── image/             ← Gambar statis (logo, maskot, background)
│       ├── logo.png        ← Logo perpustakaan
│       ├── maskot.png      ← Maskot burung hantu
│       ├── hero-bg.jpg     ← Background halaman utama
│       └── ...
│
└── storage/
    └── app/public/covers/  ← Upload foto sampul buku (dari admin)
```

---

## 5. DATABASE & TABEL

### Diagram Relasi Antar Tabel (ERD)

```
┌─────────────┐           ┌─────────────────────┐           ┌──────────────┐
│    users    │           │     peminjaman       │           │     buku     │
├─────────────┤           ├─────────────────────┤           ├──────────────┤
│ id (PK)  ◄──┼──┐        │ id (PK)             │     ┌────►│ id (PK)      │
│ name        │  │        │ kode_pinjam         │     │     │ kode_buku    │
│ email       │  │        │ anggota_id (FK) ─── │─┐   │     │ isbn         │
│ password    │  │        │ buku_id (FK) ─────── │─┼───┘     │ judul        │
│ role        │  │        │ tanggal_pinjam       │ │         │ pengarang    │
└─────────────┘  │        │ tanggal_kembali_     │ │         │ penerbit     │
                 │        │   rencana            │ │         │ tahun_terbit │
┌─────────────┐  │        │ tanggal_kembali_     │ │         │ kategori     │
│   anggota   │  │        │   aktual             │ │         │ stok         │
├─────────────┤  │        │ status               │ │         │ cover        │
│ id (PK)  ───┼──┼────────│ denda                │ │         │ rating       │
│ user_id(FK)─┼──┘        │ keterangan           │ │         │ is_featured  │
│ nis         │           └─────────────────────┘ │         │ waitlist_    │
│ nama        │                                   │         │   count      │
│ kelas       │◄──────────────────────────────────┘         │ status_      │
│ alamat      │                                             │   launching  │
│ telepon     │                                             │ tanggal_     │
│ status      │                                             │   rilis      │
└─────────────┘                                             └──────────────┘
```

### Detail Setiap Tabel

---

#### Tabel `users` — Data Akun Login
```
Kolom           Tipe          Keterangan
─────────────────────────────────────────────────────
id              BIGINT (PK)   Nomor unik otomatis
name            VARCHAR       Nama lengkap
email           VARCHAR       Email (unik, untuk login)
password        VARCHAR       Password (dienkripsi bcrypt)
role            VARCHAR       Nilai: 'admin' atau 'siswa'
created_at      TIMESTAMP     Waktu daftar
updated_at      TIMESTAMP     Waktu update terakhir
```

**Catatan penting:** Password tidak pernah disimpan sebagai teks biasa.
Laravel menggunakan `Hash::make()` yang mengubah password menjadi kode
acak (hash) yang tidak bisa dibaca. Contoh: "admin123" → "$2y$12$xyz..."

---

#### Tabel `anggota` — Data Profil Siswa
```
Kolom       Tipe          Keterangan
──────────────────────────────────────────────
id          BIGINT (PK)   Nomor unik otomatis
user_id     BIGINT (FK)   Link ke tabel users
nis         VARCHAR       Nomor Induk Siswa (unik)
nama        VARCHAR       Nama lengkap siswa
kelas       VARCHAR       Contoh: "XII IPA 1"
alamat      TEXT          Alamat rumah
telepon     VARCHAR       Nomor HP
foto        VARCHAR       Path foto profil
status      VARCHAR       'aktif' atau 'nonaktif'
```

---

#### Tabel `buku` — Koleksi Buku Perpustakaan
```
Kolom               Tipe          Keterangan
────────────────────────────────────────────────────────────────
id                  BIGINT (PK)   Nomor unik otomatis
kode_buku           VARCHAR       Kode unik: BK001, BK002, dst
isbn                VARCHAR       Nomor standar buku internasional
judul               VARCHAR       Judul buku
pengarang           VARCHAR       Nama penulis
penerbit            VARCHAR       Nama penerbit
tahun_terbit        YEAR          Tahun diterbitkan
kategori            VARCHAR       Genre: Fiksi, Sains, dll
stok                INT           Jumlah buku tersedia
cover               VARCHAR       Path foto sampul
deskripsi           TEXT          Sinopsis/keterangan
rating              DECIMAL(3,1)  Nilai 1.0 – 5.0
is_featured         BOOLEAN       Tampil sebagai unggulan?
waitlist_count      INT           Jumlah orang dalam antrian
returned_at         TIMESTAMP     Terakhir dikembalikan
status_launching    ENUM          'tersedia' atau 'segera'
tanggal_rilis       DATE          Tanggal rilis (buku coming soon)
```

---

#### Tabel `peminjaman` — Transaksi Pinjam-Kembali
```
Kolom                      Tipe         Keterangan
──────────────────────────────────────────────────────────────────
id                         BIGINT (PK)  Nomor unik otomatis
kode_pinjam                VARCHAR      Kode unik: TRX-XXXXXXXX
anggota_id                 BIGINT (FK)  Link ke tabel anggota
buku_id                    BIGINT (FK)  Link ke tabel buku
tanggal_pinjam             DATE         Tanggal mulai pinjam
tanggal_kembali_rencana    DATE         Deadline pengembalian (+ 7 hari)
tanggal_kembali_aktual     DATE         Tanggal benar-benar dikembalikan
status                     ENUM         'dipinjam' / 'dikembalikan' / 'terlambat'
denda                      INT          Jumlah denda (Rp)
keterangan                 TEXT         Catatan tambahan
```

---

## 6. FITUR-FITUR SISTEM

### 6.1 Halaman Landing (Publik — Tanpa Login)

Halaman utama yang bisa dilihat siapa saja. Menampilkan:

| Section | Isi | Query Database |
|---------|-----|----------------|
| **Buku Populer** | 6 buku paling sering dipinjam | `ORDER BY peminjaman_count DESC` |
| **Buku Terbaru** | 4 buku yang baru ditambahkan | `ORDER BY created_at DESC` |
| **Stok Terbanyak** | 4 buku dengan stok paling banyak | `ORDER BY stok DESC` |
| **Kategori** | Semua kategori buku yang ada | `SELECT DISTINCT kategori` |
| **Baru Kembali** | Buku yang stok 1-3 dan ada riwayat pinjam | `stok BETWEEN 1 AND 3` |
| **Waitlist** | Buku habis stok tapi banyak peminat | `stok = 0 AND waitlist_count > 0` |
| **Segera Hadir** | Buku yang akan dirilis | `status_launching = 'segera'` |

---

### 6.2 Fitur Login & Register

**Login:**
- Validasi: email & password wajib diisi
- Cek kombinasi email + password di database
- Jika berhasil: redirect ke dashboard sesuai role
  - Role `admin` → `/admin/dashboard`
  - Role `siswa` → `/siswa/dashboard`
- Jika gagal: kembali ke form + pesan error

**Register (Siswa Baru):**
- Isi: nama, email, password, NIS, kelas, telepon
- Validasi: email harus unik, NIS harus unik, password minimal 6 karakter
- Otomatis buat 2 data sekaligus: satu di tabel `users`, satu di tabel `anggota`
- Langsung login setelah register berhasil

---

### 6.3 Fitur Admin

#### Dashboard Admin
Menampilkan statistik:
- Total buku koleksi
- Total anggota terdaftar
- Total transaksi (semua waktu)
- Total denda terkumpul
- Grafik/tabel peminjaman terbaru

#### Kelola Buku (CRUD)
- **Tambah buku:** isi form lengkap + upload foto sampul
- **Edit buku:** ubah data + ganti foto (foto lama otomatis dihapus)
- **Hapus buku:** data dihapus + foto otomatis dihapus dari storage
- **Cari buku:** filter by judul, pengarang, kode, kategori
- **Status launching:** pilih "Tersedia" atau "Segera Hadir"
  - Jika "Segera Hadir" → wajib isi tanggal rilis
  - Jika "Tersedia" → tanggal rilis otomatis dikosongkan

#### Kelola Anggota (CRUD)
- Lihat semua siswa terdaftar
- Tambah/edit/hapus data siswa
- Lihat detail: riwayat pinjam, denda, status aktif/nonaktif

#### Kelola Transaksi
- Lihat semua peminjaman (bisa filter: dipinjam, dikembalikan, terlambat)
- Proses pengembalian buku
- Otomatis hitung denda jika terlambat (Rp 1.000/hari)
- Tambah peminjaman baru dari sisi admin

---

### 6.4 Fitur Siswa

#### Dashboard Siswa
- Jumlah buku yang sedang dipinjam
- Buku yang mendekati deadline
- Total denda (jika ada)
- Riwayat peminjaman terbaru

#### Pinjam Buku
1. Siswa buka menu "Pinjam Buku"
2. Cari buku (by judul, pengarang, kategori)
3. Klik tombol "Pinjam" pada buku yang diinginkan
4. Sistem validasi:
   - Stok tersedia?
   - Akun siswa aktif?
   - Buku ini belum sedang dipinjam siswa ini?
5. Jika semua valid: stok berkurang 1, record peminjaman dibuat
6. Deadline otomatis: **7 hari dari tanggal pinjam**

#### Riwayat Peminjaman
- Lihat semua history: sedang dipinjam, sudah kembali, terlambat
- Filter by status
- Status terlambat otomatis ter-update saat halaman dibuka

#### Pengembalian Buku
1. Siswa pilih buku yang mau dikembalikan
2. Sistem hitung apakah terlambat
3. Jika terlambat: tampilkan jumlah denda (hari terlambat × Rp 1.000)
4. Konfirmasi pengembalian
5. Stok buku otomatis bertambah 1

---

## 7. ALUR SISTEM (FLOWCHART)

### 7.1 Alur Login

```
┌─────────────────┐
│ User buka /login│
└────────┬────────┘
         │
         ▼
┌─────────────────────┐
│ Isi email + password│
└────────┬────────────┘
         │
         ▼
┌──────────────────────────────┐
│ AuthController::login()      │
│ Validasi format input        │
└────────┬─────────────────────┘
         │
    ┌────┴────┐
  VALID    TIDAK VALID
    │           │
    ▼           ▼
Auth::attempt()  Kembali ke form
    │           + pesan error
 ┌──┴──┐
GAGAL  BERHASIL
  │       │
  ▼       ▼
Error   Cek role
"Email/  │
 pass   ┌┴─────┐
 salah" ADMIN  SISWA
         │      │
         ▼      ▼
     /admin  /siswa
   /dashboard /dashboard
```

---

### 7.2 Alur Peminjaman Buku

```
┌──────────────────────┐
│ Siswa klik "Pinjam"  │
│ pada buku tertentu   │
└──────────┬───────────┘
           │ POST /siswa/peminjaman
           ▼
┌──────────────────────────┐
│ PeminjamanController     │
│ ::store()                │
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────┐     TIDAK
│ Stok buku > 0?       ├──────────► Error "Stok habis"
└──────────┬───────────┘
           │ YA
           ▼
┌──────────────────────┐     TIDAK
│ Akun siswa aktif?    ├──────────► Error "Akun tidak aktif"
└──────────┬───────────┘
           │ YA
           ▼
┌──────────────────────────────┐  YA
│ Siswa sudah pinjam buku ini? ├──────► Error "Masih dipinjam"
└──────────┬───────────────────┘
           │ TIDAK
           ▼
┌────────────────────────────────────┐
│ Buat record di tabel peminjaman:   │
│ - kode_pinjam = "TRX-XXXXXXXX"    │
│ - status = 'dipinjam'              │
│ - tanggal_pinjam = hari ini        │
│ - tanggal_kembali_rencana = +7hari │
└──────────┬─────────────────────────┘
           │
           ▼
┌────────────────────────┐
│ Stok buku dikurangi 1  │
│ buku->decrement('stok')│
└──────────┬─────────────┘
           │
           ▼
┌──────────────────────────────────┐
│ Redirect ke riwayat + notif sukses│
└──────────────────────────────────┘
```

---

### 7.3 Alur Pengembalian + Hitung Denda

```
┌──────────────────────────┐
│ Admin/Siswa proses       │
│ pengembalian buku        │
└──────────┬───────────────┘
           │
           ▼
┌──────────────────────────────────┐
│ Ambil data peminjaman            │
│ Bandingkan:                      │
│ tanggal_hari_ini vs              │
│ tanggal_kembali_rencana          │
└──────────┬───────────────────────┘
           │
      ┌────┴─────┐
   TEPAT        TERLAMBAT
   WAKTU           │
      │            ▼
      │   ┌─────────────────────────┐
      │   │ Hitung selisih hari:    │
      │   │ hari_ini - batas_kembali│
      │   │                         │
      │   │ Denda = selisih × 1.000 │
      │   │ (Contoh: 3 hari = 3.000)│
      │   └─────────┬───────────────┘
      │             │
      └──────┬──────┘
             │
             ▼
┌────────────────────────────────────┐
│ Update tabel peminjaman:           │
│ - status = 'dikembalikan'          │
│ - tanggal_kembali_aktual = hari ini│
│ - denda = hasil perhitungan        │
└──────────┬─────────────────────────┘
           │
           ▼
┌──────────────────────────┐
│ Stok buku ditambah 1     │
│ buku->increment('stok')  │
└──────────────────────────┘
```

---

## 8. PENJELASAN FILE PENTING

### `routes/web.php` — Peta URL Aplikasi
File ini mendaftarkan semua URL yang bisa diakses. Setiap URL dipetakan ke
Controller tertentu.

```php
// Contoh route dari web.php:

// URL publik — siapa saja bisa akses
Route::get('/', [LandingController::class, 'index'])->name('landing');

// URL hanya untuk admin (middleware 'admin' memproteksi)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('buku', BukuController::class); // CRUD otomatis
});

// URL hanya untuk siswa (middleware 'siswa' memproteksi)
Route::prefix('siswa')->middleware(['auth', 'siswa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);
});
```

**Middleware** adalah "penjaga pintu". Sebelum request masuk ke Controller,
middleware mengecek dulu: apakah user sudah login? Apakah role-nya sesuai?
Jika tidak → redirect ke login.

---

### `app/Models/Buku.php` — Model Buku

```php
class Buku extends Model
{
    protected $table = 'buku'; // nama tabel di database

    // Kolom yang boleh diisi (mass assignment protection)
    protected $fillable = ['kode_buku', 'judul', 'pengarang', 'stok', ...];

    // Relasi: 1 buku bisa punya banyak peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Method helper: cek apakah buku tersedia
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }
}
```

Model adalah "jembatan" antara kode PHP dan tabel database. Dengan model,
kita bisa query database pakai kode PHP yang mudah dibaca:
- `Buku::all()` → ambil semua buku
- `Buku::find(1)` → ambil buku dengan id = 1
- `Buku::where('stok', '>', 0)->get()` → buku yang stoknya tersedia

---

### `app/Models/Peminjaman.php` — Model Peminjaman

```php
class Peminjaman extends Model
{
    // Relasi ke anggota (banyak peminjaman milik 1 anggota)
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relasi ke buku (banyak peminjaman merujuk 1 buku)
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    // Hitung denda otomatis
    public function hitungDenda(): int
    {
        if ($this->tanggal_kembali_aktual &&
            $this->tanggal_kembali_aktual->gt($this->tanggal_kembali_rencana)) {
            $selisih = $this->tanggal_kembali_rencana
                           ->diffInDays($this->tanggal_kembali_aktual);
            return $selisih * 1000; // Rp 1.000 per hari
        }
        return 0;
    }
}
```

---

### `app/Http/Controllers/AuthController.php` — Login & Register

```php
// Proses login
public function login(Request $request)
{
    // 1. Validasi format input
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    // 2. Coba login dengan kredensial
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $request->session()->regenerate(); // keamanan: regenerasi session
        return redirect ke dashboard sesuai role;
    }

    // 3. Jika gagal: kembali dengan error
    return back()->withErrors(['email' => 'Email atau password salah.']);
}

// Proses register siswa baru
public function register(Request $request)
{
    // Validasi & buat 2 record sekaligus:
    $user = User::create([...]);    // 1. Akun login
    Anggota::create([...]);         // 2. Data profil siswa
    Auth::login($user);             // Langsung login
}
```

---

### `app/Http/Controllers/LandingController.php` — Halaman Publik

```php
public function index()
{
    // Query berbeda untuk setiap section di landing page
    $bukuPopuler = Buku::withCount('peminjaman')
        ->orderByDesc('peminjaman_count')
        ->take(6)->get();

    $bukuSegeraHadir = Buku::where('status_launching', 'segera')
        ->whereNotNull('tanggal_rilis')
        ->orderBy('tanggal_rilis')
        ->take(6)->get();

    // Kirim semua data ke view
    return view('landing', compact('bukuPopuler', 'bukuSegeraHadir', ...));
}
```

---

## 9. ROUTES (URL SISTEM)

### URL Publik (Tanpa Login)
```
GET  /              → Halaman landing (beranda)
GET  /login         → Form login
POST /login         → Proses login
GET  /register      → Form daftar
POST /register      → Proses daftar
POST /logout        → Proses logout
```

### URL Admin (Harus Login + Role Admin)
```
GET    /admin/dashboard          → Dashboard statistik

GET    /admin/buku               → Daftar semua buku
GET    /admin/buku/create        → Form tambah buku baru
POST   /admin/buku               → Simpan buku baru
GET    /admin/buku/{id}          → Detail satu buku
GET    /admin/buku/{id}/edit     → Form edit buku
PUT    /admin/buku/{id}          → Simpan perubahan buku
DELETE /admin/buku/{id}          → Hapus buku

GET    /admin/anggota            → Daftar semua anggota/siswa
GET    /admin/anggota/create     → Form tambah anggota
POST   /admin/anggota            → Simpan anggota baru
GET    /admin/anggota/{id}       → Detail satu anggota
GET    /admin/anggota/{id}/edit  → Form edit anggota
PUT    /admin/anggota/{id}       → Simpan perubahan
DELETE /admin/anggota/{id}       → Hapus anggota

GET    /admin/transaksi          → Daftar semua transaksi
POST   /admin/transaksi          → Tambah transaksi baru
POST   /admin/transaksi/{id}/kembali → Proses pengembalian
```

### URL Siswa (Harus Login + Role Siswa)
```
GET  /siswa/dashboard            → Dashboard siswa

GET  /siswa/peminjaman           → Riwayat peminjaman
GET  /siswa/peminjaman/pinjam    → Halaman cari & pinjam buku
POST /siswa/peminjaman           → Proses pinjam buku
GET  /siswa/peminjaman/{id}      → Detail satu transaksi

GET  /siswa/pengembalian                       → Daftar buku dipinjam
GET  /siswa/pengembalian/{id}/konfirmasi       → Konfirmasi pengembalian
POST /siswa/pengembalian/{id}/proses           → Proses pengembalian
```

---

## 10. CARA MENJALANKAN PROJECT

### Prasyarat
- Laragon terinstall (berisi PHP 8.x, MySQL, Apache)
- Composer terinstall
- File project ada di folder `laragon/www/peminjaman_buku`

### Langkah-langkah

```bash
# 1. Masuk ke folder project
cd C:\laragon\www\peminjaman_buku

# 2. Install dependensi PHP (hanya pertama kali)
composer install

# 3. Copy file konfigurasi
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Buat database baru di MySQL bernama "peminjaman_buku"
#    (bisa lewat phpMyAdmin atau HeidiSQL)

# 6. Setting database di file .env
DB_DATABASE=peminjaman_buku
DB_USERNAME=root
DB_PASSWORD=

# 7. Jalankan migrasi (buat tabel-tabel)
php artisan migrate

# 8. Isi data awal (60 buku + user admin/siswa)
php artisan db:seed

# 9. Buat symlink storage (agar foto sampul bisa diakses)
php artisan storage:link

# 10. Nyalakan Laragon, buka browser:
#     http://localhost/peminjaman_buku/public
```

### Akun Default (Setelah Seeding)
```
ADMIN
  Email    : admin@perpus.sch.id
  Password : admin123

SISWA 1
  Email    : budi@siswa.sch.id
  Password : siswa123

SISWA 2
  Email    : siti@siswa.sch.id
  Password : siswa123
```

---

## RINGKASAN SINGKAT (Untuk Jawab Pertanyaan Guru)

| Pertanyaan | Jawaban |
|-----------|---------|
| **Dibuat pakai apa?** | PHP + Laravel (framework) + MySQL (database) + Bootstrap (tampilan) |
| **Pola arsitekturnya apa?** | MVC — Model (data), View (tampilan), Controller (logika) |
| **Database-nya apa?** | MySQL, ada 4 tabel utama: users, anggota, buku, peminjaman |
| **Siapa yang bisa akses?** | 3 jenis: Publik (landing page), Siswa (pinjam buku), Admin (kelola semua) |
| **Bagaimana keamanannya?** | Password dienkripsi (bcrypt), ada middleware proteksi halaman, session regenerate saat login |
| **Cara hitung denda?** | Otomatis: (tanggal kembali aktual - batas kembali) × Rp 1.000/hari |
| **Berapa buku di database?** | 60 buku dari 10 kategori (6 buku per kategori) |
| **Apa itu Middleware?** | Penjaga pintu: cek apakah user sudah login & role-nya sesuai sebelum boleh masuk halaman |
| **Apa itu Seeder?** | Script untuk mengisi data awal ke database secara otomatis (untuk testing) |
| **Apa itu Migration?** | Script yang mendefinisikan struktur tabel database — bisa dijalankan ulang kapan saja |

---

*Dibuat oleh sistem Kiro AI — Dokumentasi ini sesuai dengan kode asli project.*

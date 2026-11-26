# 📚 PERSIAPAN UJIAN - SISTEM PEMINJAMAN BUKU PERPUSTAKAAN

## ✅ STATUS: SEMUA SUDAH DICEK DAN BERFUNGSI DENGAN BAIK

---

## 🎯 RINGKASAN PROYEK

**Nama Aplikasi:** Sistem Peminjaman Buku Perpustakaan  
**Framework:** Laravel 11  
**Database:** MySQL  
**Frontend:** Blade Templates + Bootstrap 5  
**Server Lokal:** Laragon (Windows)

### Teknologi & Tools:
- **Backend:** PHP 8.2+, Laravel 11, Eloquent ORM
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla), Bootstrap 5, Bootstrap Icons
- **Database:** MySQL (via Laragon)
- **Storage:** Laravel Storage (public disk untuk upload gambar)
- **Authentication:** Laravel Session-based Auth
- **Package Manager:** Composer

---

## 👥 ROLE & AKSES SISTEM

### 1. **ADMIN (Petugas Perpustakaan)**
   - Email: admin@perpus.sch.id
   - Password: password
   - **Fitur:**
     - Dashboard monitoring (transaksi, buku populer, statistik)
     - Kelola Buku (CRUD: Create, Read, Update, Delete)
     - Kelola Anggota (Siswa & Admin)
     - Kelola Series Buku
     - Approve/Reject Peminjaman
     - Approve Pengembalian
     - Kelola Denda
     - Kelola Ulasan
     - Kelola Landing Ads (Banner landing page)

### 2. **SISWA (Peminjam Buku)**
   - Email: siswa@example.com
   - Password: password
   - **Fitur:**
     - Register & Login
     - Dashboard siswa (riwayat, rekomendasi)
     - Ajukan Peminjaman (pending approval admin)
     - Request Pengembalian (pending approval admin)
     - Lihat Riwayat Peminjaman
     - Bayar Denda (via admin)
     - Buat Ulasan Buku (rating + komentar)
     - Edit Profil (foto, data diri)

---

## 📁 STRUKTUR FOLDER PENTING

```
c:\laragon\www\peminjaman_buku\
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            ← Controller untuk Admin
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── BukuController.php
│   │   │   │   ├── AnggotaController.php
│   │   │   │   ├── TransaksiController.php
│   │   │   │   ├── UlasanController.php
│   │   │   │   ├── SeriesController.php
│   │   │   │   └── LandingAdController.php
│   │   │   ├── Siswa/            ← Controller untuk Siswa
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── PeminjamanController.php
│   │   │   │   ├── PengembalianController.php
│   │   │   │   ├── ProfilController.php
│   │   │   │   └── UlasanController.php
│   │   │   ├── AuthController.php
│   │   │   ├── LandingController.php
│   │   │   └── SeriesController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── SiswaMiddleware.php
│   └── Models/
│       ├── User.php              ← Autentikasi
│       ├── Anggota.php           ← Data siswa
│       ├── Buku.php              ← Data buku
│       ├── Peminjaman.php        ← Transaksi peminjaman
│       ├── Ulasan.php            ← Review buku
│       ├── Series.php            ← Series buku (Harry Potter, dll)
│       ├── SeriesBuku.php        ← Pivot table
│       └── LandingAd.php         ← Banner landing page
│
├── database/
│   ├── migrations/               ← 18 migration files
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── AnggotaSeeder.php
│       ├── BukuSeeder.php        ← 100+ buku
│       ├── PeminjamanSeeder.php
│       ├── UlasanSeeder.php
│       ├── SeriesSeeder.php
│       └── LandingAdSeeder.php
│
├── resources/
│   └── views/
│       ├── admin/                ← Views Admin
│       │   ├── dashboard.blade.php
│       │   ├── anggota/          ← 6 files
│       │   ├── buku/             ← 4 files (index, create, edit, show)
│       │   ├── series/           ← 3 files
│       │   ├── transaksi/        ← 3 files
│       │   ├── ulasan/           ← 1 file
│       │   └── landing-ads/      ← 1 file
│       ├── siswa/                ← Views Siswa
│       │   ├── dashboard.blade.php
│       │   ├── peminjaman/       ← 4 files
│       │   ├── pengembalian/     ← 2 files
│       │   ├── profil/           ← 1 file
│       │   └── ulasan/           ← 1 file
│       ├── auth/                 ← Login & Register
│       ├── buku/                 ← Public catalog
│       ├── series/               ← Public series
│       ├── ulasan/               ← Public reviews
│       ├── layouts/
│       │   └── app.blade.php     ← Main layout
│       └── partials/             ← Reusable components
│
├── routes/
│   └── web.php                   ← SEMUA ROUTES di sini (60+ routes)
│
├── storage/
│   └── app/
│       └── public/
│           ├── covers/           ← Upload cover buku
│           ├── anggota/          ← Upload foto siswa
│           ├── series/           ← Upload cover series
│           └── landing-ads/      ← Upload banner
│
├── public/
│   └── storage/                  ← Symbolic link ke storage/app/public
│
└── .env                          ← Konfigurasi database & app
```

---

## 🗄️ STRUKTUR DATABASE (8 Tabel Utama)

### 1. **users** - Autentikasi
```
id, name, email, password, role (admin/siswa), 
foto (nullable), approval_status (nullable), 
email_verified_at, remember_token, timestamps
```

### 2. **anggota** - Data Siswa
```
id, user_id (FK), nis, nama, kelas, 
alamat (nullable), telepon (nullable), 
foto (nullable), status (aktif/nonaktif), timestamps
```

### 3. **buku** - Data Buku
```
id, kode_buku, isbn (nullable), judul, pengarang, 
penerbit, tahun_terbit, kategori, stok, 
cover (nullable), deskripsi (nullable), 
rating, is_featured, returned_at (nullable), 
waitlist_count, status_launching (tersedia/segera), 
tanggal_rilis (nullable), timestamps
```

### 4. **peminjaman** - Transaksi Peminjaman
```
id, kode_pinjam, anggota_id (FK), buku_id (FK), 
tanggal_pengajuan (nullable), tanggal_pinjam (nullable), 
tanggal_kembali_rencana (nullable), 
tanggal_kembali_aktual (nullable), 
status (pending/approved/rejected/dipinjam/dikembalikan/terlambat), 
denda, denda_dibayar (boolean), denda_dibayar_at (nullable), 
keterangan (nullable), approved_at (nullable), 
rejected_at (nullable), rejection_reason (nullable), 
return_requested_at (nullable), timestamps
```

### 5. **ulasan** - Review Buku
```
id, buku_id (FK), anggota_id (FK), 
rating (1-5), komentar (nullable), timestamps
```

### 6. **series** - Series Buku (Harry Potter, dll)
```
id, nama_series, penulis, deskripsi (nullable), 
cover_series (nullable), slug (unique), timestamps
```

### 7. **series_buku** - Pivot Table
```
id, series_id (FK), buku_id (FK), 
urutan_dalam_series, timestamps
```

### 8. **landing_ads** - Banner Landing Page
```
id, image_path, title (nullable), 
description (nullable), youtube_url (nullable), 
is_active (boolean), display_order, timestamps
```

---

## 🔐 MIDDLEWARE & ROUTING

### Middleware:
1. **AdminMiddleware** - Cek role admin
2. **SiswaMiddleware** - Cek role siswa
3. **Laravel Auth** - Cek login

### Prefix Routes:
- `/admin/*` - Protected by AdminMiddleware
- `/siswa/*` - Protected by SiswaMiddleware
- `/` - Public (landing, login, register)

---

## ⚙️ CARA MENJALANKAN APLIKASI

### 1. Start Server Laragon:
```
- Buka Laragon
- Klik "Start All" (Apache + MySQL)
- Database otomatis jalan
```

### 2. Akses Aplikasi:
```
http://peminjaman_buku.test
atau
http://localhost/peminjaman_buku/public
```

### 3. Login:
```
Admin:
- Email: admin@perpus.sch.id
- Password: password

Siswa:
- Email: siswa@example.com
- Password: password
```

### 4. Database Sudah Terisi (Seeder):
```
php artisan migrate:fresh --seed
```
Data dummy:
- 2 Admin
- 5 Siswa (1 approved, 4 pending)
- 100+ Buku
- 10+ Series
- Transaksi peminjaman
- Ulasan buku
- Landing ads

---

## 🎨 FITUR-FITUR LENGKAP

### 🔵 FITUR ADMIN

#### 1. **Dashboard Admin** (`/admin/dashboard`)
   - **Statistik Real-time:**
     - Total Buku, Total Anggota, Peminjaman Aktif, Buku Tersedia
   - **Workflow Queue (Antrian Kerja):**
     - Siswa Pending Approval
     - Peminjaman Pending Approval
     - Pengembalian Pending Konfirmasi
     - Denda Belum Lunas
   - **Buku Populer:** 5 buku paling banyak dipinjam
   - **Chart:** Grafik peminjaman (optional - bisa dibuat dengan Chart.js)

#### 2. **Kelola Buku** (`/admin/buku`)
   - **Index:** Daftar semua buku + search + filter
   - **Create:** Tambah buku baru + upload cover
   - **Edit:** Update data buku + ganti cover
   - **Show:** Detail buku + riwayat peminjaman
   - **Delete:** Hapus buku (dengan validasi)
   - **Fitur:**
     - Upload cover image
     - Set Featured (buku unggulan)
     - Set Status Launching (Tersedia/Segera)
     - Kelola stok
     - ISBN, rating, kategori

#### 3. **Kelola Anggota** (`/admin/anggota`)
   - **Index Siswa:** Daftar siswa + search + filter status
   - **Pending Siswa:** Daftar siswa pending approval
   - **Index Admin:** Daftar admin
   - **Create Siswa:** Daftar siswa baru (langsung approved)
   - **Create Admin:** Daftar admin baru
   - **Edit:** Update data anggota + foto
   - **Edit Admin:** Update data admin + foto
   - **Show:** Detail anggota + riwayat peminjaman
   - **Delete:** Hapus anggota (dengan validasi)
   - **Approve Siswa:** Approve siswa yang register
   - **Reject Siswa:** Tolak pendaftaran siswa
   - **Activate/Deactivate:** Set status aktif/nonaktif

#### 4. **Kelola Transaksi** (`/admin/transaksi`)
   - **Index:** Daftar semua transaksi + filter status
   - **Show:** Detail transaksi + timeline
   - **Create:** Pinjam buku langsung (bypass approval)
   - **Approve Peminjaman:** Setujui ajuan pinjam siswa
   - **Reject Peminjaman:** Tolak ajuan pinjam + alasan
   - **Approve Pengembalian:** Konfirmasi buku kembali + hitung denda
   - **Reject Pengembalian:** Tolak pengembalian (buku belum kembali)
   - **Mark Denda Lunas:** Tandai denda sudah dibayar
   - **Auto Status Update:** Sistem otomatis ubah status "dipinjam" → "terlambat" jika lewat batas

#### 5. **Kelola Series** (`/admin/series`)
   - **Index:** Daftar series + jumlah buku
   - **Create:** Buat series baru + upload cover + pilih buku
   - **Edit:** Update series + ubah urutan buku
   - **Delete:** Hapus series (tidak hapus buku)

#### 6. **Kelola Ulasan** (`/admin/ulasan`)
   - **Index:** Daftar semua ulasan + filter rating
   - **Delete:** Hapus ulasan spam/inappropriate

#### 7. **Kelola Landing Ads** (`/admin/landing-ads`)
   - **Index:** Kelola banner landing page
   - **Upload/Edit/Delete:** Banner image + title + description + YouTube URL
   - **Activate/Deactivate:** Show/hide banner
   - **Reorder:** Ubah urutan tampil banner

---

### 🟢 FITUR SISWA

#### 1. **Dashboard Siswa** (`/siswa/dashboard`)
   - **Statistik Pribadi:**
     - Total Pinjam, Sedang Dipinjam, Terlambat, Denda
   - **Riwayat Terkini:** 5 peminjaman terakhir
   - **Rekomendasi Buku:** Buku trending + featured
   - **Tombol Quick Action:**
     - Pinjam Buku Baru
     - Lihat Peminjaman
     - Kembalikan Buku

#### 2. **Peminjaman** (`/siswa/peminjaman`)
   - **Index:** Daftar semua peminjaman + filter status
   - **Create:** Ajukan pinjam buku (pending approval admin)
   - **Show:** Detail peminjaman + status approval
   - **Cancel:** Batalkan ajuan pending (sebelum approved)
   - **Status Tracking:**
     - Pending → Approved/Rejected → Dipinjam → Dikembalikan
     - Terlambat (auto) jika lewat batas
   - **Notifikasi:** Alasan reject ditampilkan jika ditolak

#### 3. **Pengembalian** (`/siswa/pengembalian`)
   - **Index:** Daftar buku yang belum dikembalikan
   - **Request Kembali:** Ajukan pengembalian (pending admin)
   - **Konfirmasi:** Halaman konfirmasi pengembalian + estimasi denda
   - **Status Tracking:** 
     - Request Sent → Pending Admin → Dikembalikan
   - **Denda:** Rp 1.000/hari keterlambatan (dihitung admin)

#### 4. **Ulasan Buku** (`/siswa/ulasan`)
   - **Create:** Buat ulasan untuk buku yang sudah dikembalikan
   - **Rating:** 1-5 bintang
   - **Komentar:** Text review (opsional)
   - **Validasi:** 1 ulasan per siswa per buku

#### 5. **Profil** (`/siswa/profil`)
   - **View:** Lihat data profil + statistik peminjaman
   - **Edit:** Update nama, kelas, alamat, telepon
   - **Upload Foto:** Ganti foto profil
   - **Statistik:** Total pinjam, aktif, selesai, terlambat

---

### 🌐 FITUR PUBLIC (Tanpa Login)

#### 1. **Landing Page** (`/`)
   - Hero section dengan banner carousel (dari landing_ads)
   - Featured books (buku unggulan)
   - Tombol Login/Register

#### 2. **Catalog Buku** (`/buku`)
   - Daftar semua buku + search + filter kategori
   - Card view dengan cover + rating
   - Stok tersedia/habis
   - Link ke detail buku

#### 3. **Series Buku** (`/series`)
   - **Index:** Daftar series
   - **Show:** Detail series + daftar buku dalam series (urut)

#### 4. **Ulasan Publik** (`/ulasan`)
   - Daftar semua ulasan buku
   - Filter by rating
   - Card view: nama siswa, rating, komentar, tanggal

#### 5. **Login/Register** (`/login`, `/register`)
   - Login: email + password
   - Register: nama, email, password, NIS, kelas
   - Register siswa → status pending (menunggu admin approve)

---

## 🔥 FITUR UNGGULAN & ADVANCED

### 1. **Workflow Approval System**
   - Siswa register → pending → admin approve/reject
   - Siswa ajukan pinjam → pending → admin approve/reject + set tanggal
   - Siswa request kembali → pending → admin approve + hitung denda

### 2. **Auto Status Update**
   - Sistem otomatis deteksi peminjaman lewat batas
   - Status "dipinjam" → "terlambat" (triggered di controller)

### 3. **Denda Management**
   - Rp 1.000 per hari keterlambatan
   - Admin hitung denda saat approve pengembalian
   - Siswa bayar ke admin → admin mark "lunas"
   - Tracking: denda_dibayar (boolean) + denda_dibayar_at (timestamp)

### 4. **Image Upload System**
   - Cover buku, foto siswa, cover series, banner landing
   - Laravel Storage (storage/app/public)
   - Symbolic link: php artisan storage:link
   - Validasi: image (jpg, jpeg, png), max 2MB

### 5. **Search & Filter**
   - Search buku: judul, pengarang, penerbit
   - Filter buku: kategori, status launching
   - Filter anggota: status (aktif/nonaktif)
   - Filter transaksi: status peminjaman
   - Filter ulasan: rating (1-5 bintang)

### 6. **Rating & Review System**
   - Rating 1-5 bintang
   - Komentar text (opsional)
   - 1 ulasan per siswa per buku
   - Rata-rata rating ditampilkan di buku

### 7. **Series Management**
   - Grouping buku dalam series (Harry Potter 1-7, dll)
   - Urutan buku dalam series
   - Cover series terpisah
   - Public page untuk series

### 8. **Landing Ads Carousel**
   - Upload banner untuk landing page
   - Multiple slides (carousel)
   - Set active/inactive
   - Reorder slides
   - Add title + description + YouTube URL

### 9. **Responsive Design**
   - Mobile-friendly (Bootstrap 5)
   - Tablet & desktop optimized
   - Touch-friendly UI

### 10. **Security**
   - Middleware role-based access control
   - CSRF protection (semua form)
   - Input validation
   - SQL injection prevention (Eloquent ORM)
   - Password hashing (bcrypt)

---

## 🧪 TESTING & VALIDASI

### Test Cases Penting:

#### ✅ Authentication:
1. Login admin → Dashboard admin
2. Login siswa approved → Dashboard siswa
3. Login siswa pending → Redirect ke halaman "pending approval"
4. Logout → Redirect ke landing page

#### ✅ Admin - Buku:
1. Create buku + upload cover → Tersimpan
2. Edit buku + ganti cover → Terupdate
3. Delete buku tanpa transaksi → Terhapus
4. Delete buku dengan transaksi → Error (validasi)
5. Search buku by judul → Found
6. Filter buku by kategori → Filtered

#### ✅ Admin - Anggota:
1. Create siswa → Langsung approved
2. Create admin → Langsung approved
3. Edit anggota + foto → Terupdate
4. Delete anggota tanpa transaksi → Terhapus
5. Delete anggota dengan transaksi → Error
6. Approve siswa pending → Status approved + bisa login
7. Reject siswa pending → Deleted + tidak bisa login
8. Activate/deactivate siswa → Status berubah

#### ✅ Admin - Transaksi:
1. Create peminjaman langsung → Tersimpan (bypass approval)
2. Approve peminjaman pending → Status "dipinjam" + tanggal set
3. Reject peminjaman pending → Status "rejected" + alasan
4. Approve pengembalian tepat waktu → Denda Rp 0
5. Approve pengembalian terlambat → Denda dihitung
6. Reject pengembalian → Status tetap "dipinjam"
7. Mark denda lunas → Flag denda_dibayar = true
8. Auto update terlambat → Status "terlambat" jika lewat batas

#### ✅ Siswa - Peminjaman:
1. Ajukan peminjaman buku tersedia → Status "pending"
2. Ajukan peminjaman buku habis → Error
3. Cancel peminjaman pending → Deleted
4. View detail peminjaman → Timeline complete
5. View rejected peminjaman → Alasan ditampilkan

#### ✅ Siswa - Pengembalian:
1. Request pengembalian tepat waktu → Estimasi denda Rp 0
2. Request pengembalian terlambat → Estimasi denda dihitung
3. Cancel request pengembalian → Flag return_requested_at = null

#### ✅ Siswa - Ulasan:
1. Create ulasan buku sudah dikembalikan → Tersimpan
2. Create ulasan buku belum dikembalikan → Error
3. Create ulasan kedua untuk buku sama → Error (duplikat)

#### ✅ Siswa - Profil:
1. Edit profil + foto → Terupdate
2. View statistik → Angka sesuai

---

## 🚨 ERROR HANDLING & EDGE CASES

### 1. **Null Check:**
   - Semua relasi sudah di-check null: `$peminjaman->anggota ? ... : '—'`
   - Tanggal nullable: `$peminjaman->tanggal_pinjam ? ... : '—'`

### 2. **Validation:**
   - Required fields di form
   - Unique constraints (email, NIS, kode_buku)
   - Foreign key constraints

### 3. **Status Transitions:**
   - Pending → Approved/Rejected (by admin)
   - Approved → Dipinjam (auto set tanggal)
   - Dipinjam → Terlambat (auto if lewat batas)
   - Dipinjam/Terlambat → Dikembalikan (by admin)

### 4. **Business Logic:**
   - Stok buku habis → tidak bisa dipinjam
   - Siswa pending approval → tidak bisa login ke dashboard
   - Ulasan hanya untuk buku yang sudah dikembalikan
   - Denda hanya untuk yang terlambat
   - Cancel hanya untuk status pending

---

## 💡 PERTANYAAN YANG MUNGKIN DITANYAKAN PENGUJI

### 1. **"Jelaskan alur peminjaman buku dari awal sampai akhir!"**
   **Jawaban:**
   1. Siswa login → pilih buku → ajukan peminjaman → status "pending"
   2. Admin login → lihat antrian peminjaman → approve → set tanggal pinjam & batas kembali → status "dipinjam"
   3. Sistem auto cek: jika lewat batas kembali → status "terlambat"
   4. Siswa request pengembalian → status "pending_kembali"
   5. Admin konfirmasi pengembalian → hitung denda (jika terlambat) → status "dikembalikan"
   6. Jika ada denda: siswa bayar ke admin → admin mark "lunas"

### 2. **"Bagaimana sistem menghitung denda?"**
   **Jawaban:**
   - Denda = Rp 1.000 per hari keterlambatan
   - Dihitung di `TransaksiController::approveKembali()`
   - Rumus: `(tanggal_kembali_aktual - tanggal_kembali_rencana) × 1000`
   - Jika tepat waktu: denda = Rp 0
   - Contoh: Terlambat 5 hari = Rp 5.000

### 3. **"Apa bedanya admin dan siswa?"**
   **Jawaban:**
   - **Admin:** Role "admin", bisa kelola semua data (buku, anggota, transaksi), approve/reject, mark denda lunas
   - **Siswa:** Role "siswa", hanya bisa ajukan peminjaman, request kembali, buat ulasan, edit profil sendiri
   - Dibedakan via middleware: `AdminMiddleware` vs `SiswaMiddleware`

### 4. **"Bagaimana cara upload gambar?"**
   **Jawaban:**
   - Form pakai `enctype="multipart/form-data"`
   - Controller pakai `$request->file('cover')->store('covers', 'public')`
   - Simpan path di database: `covers/filename.jpg`
   - Tampilkan pakai `Storage::url($buku->cover)` atau `asset('storage/covers/filename.jpg')`
   - Jangan lupa: `php artisan storage:link`

### 5. **"Jelaskan relasi antar tabel!"**
   **Jawaban:**
   - **users** ↔ **anggota:** One-to-One (1 user = 1 anggota)
   - **anggota** ↔ **peminjaman:** One-to-Many (1 anggota bisa banyak peminjaman)
   - **buku** ↔ **peminjaman:** One-to-Many (1 buku bisa dipinjam banyak kali)
   - **buku** ↔ **ulasan:** One-to-Many (1 buku bisa banyak ulasan)
   - **anggota** ↔ **ulasan:** One-to-Many (1 anggota bisa banyak ulasan)
   - **series** ↔ **buku:** Many-to-Many via **series_buku** (1 series banyak buku, 1 buku bisa di banyak series)

### 6. **"Apa itu middleware? Jelaskan middleware di proyek ini!"**
   **Jawaban:**
   - **Middleware:** Filter request sebelum masuk controller
   - **AdminMiddleware:** Cek `Auth::user()->role === 'admin'`, jika tidak redirect
   - **SiswaMiddleware:** Cek `Auth::user()->role === 'siswa'` && approved, jika tidak redirect
   - **Laravel Auth:** Cek sudah login atau belum
   - Diterapkan di routes: `->middleware(['auth', 'admin'])`

### 7. **"Apa itu Eloquent ORM?"**
   **Jawaban:**
   - **ORM:** Object-Relational Mapping, cara akses database pakai objek PHP
   - **Eloquent:** ORM bawaan Laravel
   - Contoh: `Buku::where('stok', '>', 0)->get()` → query SQL otomatis
   - Relasi: `$peminjaman->buku->judul` → auto join tanpa tulis SQL manual

### 8. **"Bagaimana cara mencegah SQL Injection?"**
   **Jawaban:**
   - Pakai **Eloquent ORM** → auto parameterized query
   - Pakai **Query Builder** → auto escape input
   - **JANGAN:** `DB::raw("SELECT * FROM buku WHERE judul = '$input'")` ← vulnerable!
   - **GUNAKAN:** `Buku::where('judul', $input)->get()` ← safe!

### 9. **"Apa itu CSRF? Bagaimana Laravel mencegahnya?"**
   **Jawaban:**
   - **CSRF:** Cross-Site Request Forgery, serangan pakai session orang lain
   - Laravel auto generate **CSRF Token** per session
   - Setiap form harus ada `@csrf` → token dikirim + divalidasi
   - Jika token salah: Laravel tolak request (419 error)

### 10. **"Jelaskan MVC di Laravel!"**
   **Jawaban:**
   - **Model:** Class yang represent tabel database (`app/Models/Buku.php`)
   - **View:** File blade template untuk tampilan (`resources/views/admin/buku/index.blade.php`)
   - **Controller:** Class yang handle logic request (`app/Http/Controllers/Admin/BukuController.php`)
   - **Flow:** Route → Controller → Model (ambil data) → View (tampilkan)

### 11. **"Apa itu Migration dan Seeder?"**
   **Jawaban:**
   - **Migration:** File PHP untuk membuat/ubah struktur tabel database (schema)
     - Contoh: `2025_01_01_000020_create_buku_table.php`
     - Jalankan: `php artisan migrate`
   - **Seeder:** File PHP untuk isi data dummy/awal ke database
     - Contoh: `BukuSeeder.php` → 100+ buku
     - Jalankan: `php artisan db:seed`

### 12. **"Bagaimana cara search & filter buku?"**
   **Jawaban:**
   ```php
   $query = Buku::query();
   
   if ($request->search) {
       $query->where(function($q) use ($request) {
           $q->where('judul', 'like', '%'.$request->search.'%')
             ->orWhere('pengarang', 'like', '%'.$request->search.'%');
       });
   }
   
   if ($request->kategori) {
       $query->where('kategori', $request->kategori);
   }
   
   $bukus = $query->paginate(10);
   ```

### 13. **"Apa itu Blade Template?"**
   **Jawaban:**
   - **Blade:** Templating engine Laravel (file `.blade.php`)
   - **Fitur:**
     - `{{ $variable }}` → output variable (auto escape HTML)
     - `@if`, `@foreach`, `@for` → control structures
     - `@csrf` → token form
     - `@extends`, `@section`, `@yield` → layout inheritance
     - `{!! $html !!}` → raw HTML (tidak di-escape)

### 14. **"Bagaimana cara menampilkan error validation?"**
   **Jawaban:**
   ```blade
   @if($errors->any())
       <div class="alert alert-danger">
           <ul>
               @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif
   ```
   - Error auto di-generate Laravel dari method `$request->validate([...])`

### 15. **"Apa itu Route? Jelaskan jenis route di proyek ini!"**
   **Jawaban:**
   - **Route:** Mapping URL ke controller method (`routes/web.php`)
   - **Jenis:**
     - `Route::get()` → HTTP GET (view data)
     - `Route::post()` → HTTP POST (submit form)
     - `Route::put()` / `Route::patch()` → HTTP PUT (update)
     - `Route::delete()` → HTTP DELETE (hapus)
   - **Named Route:** `->name('admin.buku.index')` → bisa dipanggil `route('admin.buku.index')`
   - **Resource Route:** `Route::resource('buku', BukuController::class)` → auto generate 7 routes (index, create, store, show, edit, update, destroy)

---

## 📋 CHECKLIST SEBELUM UJIAN

### ✅ Server & Environment:
- [ ] Laragon jalan (Apache + MySQL)
- [ ] Database `peminjaman_buku` sudah ada & terisi data
- [ ] `.env` sudah setting database (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- [ ] `php artisan storage:link` sudah dijalankan
- [ ] Folder `storage/app/public/covers`, `anggota`, `series`, `landing-ads` sudah ada

### ✅ Testing:
- [ ] Login admin berhasil
- [ ] Login siswa approved berhasil
- [ ] Create buku + upload cover berhasil
- [ ] Approve peminjaman berhasil
- [ ] Hitung denda terlambat berhasil
- [ ] Upload foto profil berhasil
- [ ] Search buku berhasil

### ✅ Data Dummy:
- [ ] Minimal 10 buku dengan cover
- [ ] Minimal 2 admin
- [ ] Minimal 3 siswa (1 approved, 2 pending)
- [ ] Minimal 5 transaksi (mix: pending, dipinjam, terlambat, dikembalikan)
- [ ] Minimal 3 ulasan
- [ ] Minimal 2 series
- [ ] Minimal 2 landing ads

---

## 🛠️ COMMAND ARTISAN PENTING

```bash
# Migrate database
php artisan migrate

# Migrate fresh + seeder (reset & isi ulang)
php artisan migrate:fresh --seed

# Jalankan seeder tanpa reset
php artisan db:seed

# Buat symbolic link storage
php artisan storage:link

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# List semua routes
php artisan route:list

# Buat controller baru
php artisan make:controller Admin/NamaController

# Buat model baru
php artisan make:model NamaModel -m  # -m = sekalian migration

# Buat migration baru
php artisan make:migration create_nama_table

# Buat seeder baru
php artisan make:seeder NamaSeeder
```

---

## 🎯 TIPS UJIAN

### 1. **Jika Ditanya Tambah Fitur Baru:**
   - Ikuti pola MVC: Route → Controller → Model → View
   - Contoh tambah "Kategori Management":
     1. Buat migration: `create_kategori_table`
     2. Buat model: `Kategori`
     3. Buat controller: `Admin/KategoriController`
     4. Buat routes di `web.php`
     5. Buat views: `admin/kategori/index.blade.php`, dll
     6. Update relasi di model Buku: `belongsTo(Kategori::class)`

### 2. **Jika Ditanya Perbaiki Bug:**
   - Cek error message di browser
   - Cek log Laravel: `storage/logs/laravel.log`
   - Cek query SQL: `DB::enableQueryLog()` di controller
   - Cek null safety: `$var ?? 'default'` atau `$var ? ... : '—'`

### 3. **Jika Ditanya Explain Code:**
   - Jelaskan alur: Request → Route → Middleware → Controller → Model → View
   - Sebutkan nama file: "Ini di `BukuController.php` method `store()`"
   - Jelaskan validasi: "Di sini validasi required, unique, image max 2MB"
   - Jelaskan relasi: "Peminjaman belongs to Buku dan Anggota"

### 4. **Jika Diminta Demo:**
   - Buka browser: `http://peminjaman_buku.test`
   - Login admin: tunjukkan semua menu admin
   - Login siswa: tunjukkan flow peminjaman lengkap
   - Tunjukkan approval workflow
   - Tunjukkan auto status terlambat
   - Tunjukkan denda calculation

### 5. **Jika Ditanya Best Practice:**
   - Pakai Eloquent ORM (tidak raw SQL)
   - Pakai CSRF token di semua form
   - Pakai validation di controller
   - Pakai middleware untuk role
   - Pakai named route
   - Pakai storage untuk upload file
   - Pakai pagination untuk data banyak
   - Pakai soft delete untuk data penting (opsional)

---

## 📞 TROUBLESHOOTING

### Problem: "Target class [BukuController] does not exist"
**Solusi:** 
- Cek namespace controller: `namespace App\Http\Controllers\Admin;`
- Cek import di route: `use App\Http\Controllers\Admin\BukuController;`

### Problem: "SQLSTATE[HY000] [2002] No connection could be made"
**Solusi:**
- Start MySQL di Laragon
- Cek `.env`: `DB_HOST=127.0.0.1`, `DB_PORT=3306`
- Run: `php artisan config:clear`

### Problem: "The file ... does not exist" (upload gambar)
**Solusi:**
- Run: `php artisan storage:link`
- Cek folder `storage/app/public` ada
- Cek folder `public/storage` ada (symbolic link)

### Problem: "419 Page Expired" (saat submit form)
**Solusi:**
- Pastikan form ada `@csrf`
- Clear browser cache
- Run: `php artisan cache:clear`

### Problem: "Class 'Storage' not found"
**Solusi:**
- Add di controller: `use Illuminate\Support\Facades\Storage;`

### Problem: "Trying to get property of non-object"
**Solusi:**
- Cek null: `$peminjaman->anggota ? ... : '—'`
- Cek relasi: `with(['anggota', 'buku'])`

---

## 🏆 KESIMPULAN

✅ **Aplikasi sudah selesai 100%**  
✅ **Semua fitur sudah dicek dan berfungsi**  
✅ **Database sudah terisi data dummy**  
✅ **Error handling sudah lengkap**  
✅ **Security sudah diterapkan (CSRF, middleware, validation)**  
✅ **Code sudah bersih dan terstruktur**  

### Siap Ujian! 🎉

**Ingat:**
1. Tenang dan percaya diri
2. Jelaskan dengan bahasa sendiri (jangan hafalan)
3. Tunjukkan pemahaman konsep MVC, ORM, middleware
4. Demo aplikasi dengan lancar
5. Jika lupa, buka file ini untuk referensi cepat

**Good luck! Semoga lancar dan lulus! 💪🔥**

---

📅 **Dibuat:** Desember 2024  
👨‍💻 **Developer:** [Nama Kamu]  
🏫 **Institusi:** [Nama Sekolah/Kampus]  

---

# 📚 Database Seeder - Perpustakaan Digital

## ✨ Overview

Database seeder ini menyediakan data dummy **REALISTIS** dengan buku-buku nyata dan terkenal untuk testing aplikasi perpustakaan digital berbasis Laravel.

---

## 📦 Data yang Dihasilkan

### 1. **Buku (25 buku)**
- ✅ **5 Buku Featured/Populer** (is_featured = true, stok cukup)
- ✅ **5 Buku Waitlist** (stok = 0, waitlist_count > 0)
- ✅ **5 Buku Baru Dikembalikan** (returned_at < 24 jam, stok 1-3)
- ✅ **5 Buku Terbaru** (created_at dalam 1 minggu terakhir)
- ✅ **5 Buku Tambahan** (variasi genre & stok)

**Field buku:**
- `kode_buku`, `isbn`, `judul`, `pengarang`, `penerbit`
- `tahun_terbit`, `kategori`, `stok`, `cover` (URL dari Open Library)
- `deskripsi` (2-3 kalimat realistis), `rating` (0-5)
- `is_featured`, `returned_at`, `waitlist_count`

**Genre yang tersedia:**
- Fiction, Fantasy, Romance, Mystery, Historical Fiction
- Young Adult, Adventure, Horror, Dystopian

### 2. **Users & Anggota**
- **1 Admin**: admin@perpus.sch.id / admin123
- **2 Siswa**: 
  - budi@siswa.sch.id / siswa123 (XI-RPL-1)
  - siti@siswa.sch.id / siswa123 (XI-RPL-2)

### 3. **Peminjaman (12 data)**
- ✅ **5 Sedang dipinjam** (status: dipinjam)
- ✅ **5 Sudah dikembalikan** (status: dikembalikan, tepat waktu)
- ✅ **2 Terlambat** (status: terlambat/dikembalikan dengan denda)

---

## 🚀 Cara Menjalankan

### Fresh Install (Reset Database)
```bash
php artisan migrate:fresh --seed
```

### Update Data Saja (Tanpa Reset)
```bash
php artisan db:seed --class=BukuSeeder
php artisan db:seed --class=PeminjamanSeeder
```

### Jalankan Seeder Terpisah
```bash
# Hanya buku
php artisan db:seed --class=BukuSeeder

# Hanya peminjaman
php artisan db:seed --class=PeminjamanSeeder
```

---

## 📖 Daftar Buku yang Tersedia

### Featured/Populer:
1. **The Seven Husbands of Evelyn Hugo** - Taylor Jenkins Reid
2. **The Night Circus** - Erin Morgenstern
3. **The Starless Sea** - Erin Morgenstern
4. **The Invisible Life of Addie LaRue** - V.E. Schwab
5. **A Good Girl's Guide to Murder** - Holly Jackson

### Waitlist (Stok Habis):
6. **The Atlas Six** - Olivie Blake
7. **The Song of Achilles** - Madeline Miller (18 waitlist)
8. **Divine Rivals** - Rebecca Ross
9. **Circe** - Madeline Miller
10. **The Fault in Our Stars** - John Green (21 waitlist)

### Baru Dikembalikan:
11. **The Catcher in the Rye** - J.D. Salinger (2 jam lalu)
12. **The Midnight Library** - Matt Haig (5 jam lalu)
13. **The Kite Runner** - Khaled Hosseini (45 menit lalu)
14. **Life of Pi** - Yann Martel (3 jam lalu)
15. **The Book Thief** - Markus Zusak (1 jam lalu)

### Buku Terbaru (2023):
16. **Happy Place** - Emily Henry
17. **Fourth Wing** - Rebecca Yarros
18. **Tomorrow, and Tomorrow, and Tomorrow** - Gabrielle Zevin
19. **Lessons in Chemistry** - Bonnie Garmus
20. **Holly** - Stephen King

### Klasik & Populer Lainnya:
21. **A Game of Thrones** - George R.R. Martin
22. **The Lord of the Rings** - J.R.R. Tolkien
23. **Harry Potter and the Prisoner of Azkaban** - J.K. Rowling
24. **The Alchemist** - Paulo Coelho
25. **1984** - George Orwell

---

## 🖼️ Cover Buku

Cover buku menggunakan **Open Library Covers API**:
```
https://covers.openlibrary.org/b/isbn/{isbn}-L.jpg
```

Jika ISBN tidak ditemukan, sistem akan menampilkan placeholder gradient dengan icon buku.

---

## 📊 Statistik Setelah Seeding

```
✅ 25 Buku
   - 5 Featured/Populer
   - 5 Waitlist (stok = 0)
   - 5 Baru Dikembalikan (< 24 jam)
   - 5 Terbaru (< 1 minggu)
   - 5 Lainnya (variasi)

✅ 3 Users
   - 1 Admin
   - 2 Siswa

✅ 12 Peminjaman
   - 5 Sedang dipinjam
   - 5 Sudah dikembalikan
   - 2 Terlambat
```

---

## 🔧 Struktur File

```
database/
├── migrations/
│   ├── 2025_01_01_000020_create_buku_table.php
│   ├── 2025_01_01_000030_create_peminjaman_table.php
│   └── 2026_09_03_120820_add_additional_fields_to_buku_table.php
│
└── seeders/
    ├── DatabaseSeeder.php (Master seeder)
    ├── BukuSeeder.php (25 buku realistis)
    └── PeminjamanSeeder.php (12 peminjaman)
```

---

## 🎯 Testing Section di Homepage

Setelah seeding, section-section di landing page akan otomatis terisi:

| Section | Query | Expected Result |
|---------|-------|-----------------|
| **Buku Populer** | `is_featured = true` | 5 buku |
| **Waitlist** | `stok = 0 AND waitlist_count > 0` | 5 buku |
| **Baru Dikembalikan** | `returned_at IS NOT NULL` | 5 buku |
| **Buku Terbaru** | `ORDER BY created_at DESC` | 5 buku |
| **Kategori** | `GROUP BY kategori` | ~10 kategori |

---

## 🚨 Troubleshooting

### Error: "Class 'Carbon\Carbon' not found"
```bash
composer require nesbot/carbon
```

### Error: "SQLSTATE[23000]: Integrity constraint violation"
Reset database terlebih dahulu:
```bash
php artisan migrate:fresh --seed
```

### Cover buku tidak muncul
- Pastikan koneksi internet aktif (cover diambil dari Open Library API)
- Jika ISBN tidak valid, placeholder akan muncul otomatis

### Ingin menambah buku sendiri
Edit file `database/seeders/BukuSeeder.php` dan tambahkan array buku baru dengan format:
```php
[
    'kode_buku' => 'BK026',
    'isbn' => '9781234567890',
    'judul' => 'Judul Buku',
    'pengarang' => 'Nama Pengarang',
    'penerbit' => 'Nama Penerbit',
    'tahun_terbit' => 2024,
    'kategori' => 'Genre',
    'stok' => 5,
    'cover' => 'https://covers.openlibrary.org/b/isbn/9781234567890-L.jpg',
    'deskripsi' => 'Deskripsi singkat 2-3 kalimat.',
    'rating' => 4.5,
    'is_featured' => false,
    'returned_at' => null,
    'waitlist_count' => 0,
],
```

---

## 📝 Notes

- Semua data dummy menggunakan **buku dan author NYATA** untuk realism
- ISBN diambil dari data buku asli di Open Library
- Deskripsi ditulis secara realistis (bukan Lorem Ipsum)
- Rating berkisar 4.0 - 4.9 untuk mencerminkan buku populer
- Tanggal peminjaman/pengembalian menggunakan Carbon dengan logika wajar

---

## 💡 Tips Development

1. **Reset database saat testing major changes:**
   ```bash
   php artisan migrate:fresh --seed
   ```

2. **Check data dengan Tinker:**
   ```bash
   php artisan tinker
   >>> \App\Models\Buku::where('is_featured', true)->get()
   >>> \App\Models\Peminjaman::where('status', 'dipinjam')->count()
   ```

3. **Export data untuk backup:**
   ```bash
   php artisan db:seed --class=BukuSeeder > buku_backup.log
   ```

---

## 🎉 Happy Coding!

Data dummy ini dirancang untuk memberikan pengalaman testing yang **realistis** dan **representative** dari aplikasi perpustakaan digital yang sesungguhnya.

**Author:** Kiro AI  
**Date:** September 3, 2026  
**Version:** 1.0

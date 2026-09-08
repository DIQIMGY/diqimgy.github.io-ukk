# 🚀 Panduan Deployment ke InfinityFree + GitHub + Cloudflare

Panduan lengkap deploy aplikasi **Peminjaman Buku** ke InfinityFree dengan auto-deploy dari GitHub dan custom domain dari Cloudflare - **100% GRATIS!**

---

## 📋 Yang Dibutuhkan

- ✅ Akun GitHub (gratis)
- ✅ Akun InfinityFree (gratis - unlimited hosting)
- ✅ Akun Cloudflare (gratis - opsional untuk custom domain)
- ✅ Domain (opsional - InfinityFree kasih subdomain gratis)

---

## 🎯 STEP 1: Push ke GitHub

### 1.1 Inisialisasi Git (kalau belum)

```powershell
git init
git add .
git commit -m "Initial commit - Aplikasi Peminjaman Buku"
```

### 1.2 Buat Repository di GitHub

1. Buka https://github.com
2. Klik tombol **"New"** atau **"+"** → **"New repository"**
3. Isi:
   - **Repository name**: `peminjaman-buku` (atau terserah)
   - **Description**: Sistem Peminjaman Buku Laravel
   - **Public** (HARUS Public untuk InfinityFree auto-deploy)
   - ❌ **JANGAN** centang "Add README", "Add .gitignore", atau "Choose license"
4. Klik **"Create repository"**

### 1.3 Push ke GitHub

Copy command dari GitHub (ganti dengan URL repo kamu):

```powershell
git remote add origin https://github.com/username-kamu/peminjaman-buku.git
git branch -M main
git push -u origin main
```

✅ **Selesai!** Code sudah di GitHub.

---

## 🎯 STEP 2: Sign Up InfinityFree

### 2.1 Buat Akun

1. Buka https://infinityfree.net
2. Klik **"Sign Up Now"** (tombol hijau)
3. Isi form:
   - Email address
   - Password
4. Klik **"Sign Up"**
5. Check email untuk verifikasi → Klik link verifikasi

### 2.2 Buat Hosting Account

1. Login ke InfinityFree
2. Klik **"Create Account"**
3. Isi form:
   - **Domain**: Pilih salah satu
     - **Subdomain gratis**: `peminjamanbuku.infinityfreeapp.com` (gratis, langsung bisa)
     - **Custom domain**: `yourdomain.com` (kalau punya domain sendiri)
   - **Username**: Akan otomatis generate (contoh: `if0_12345678`)
   - **Password**: Buat password untuk cPanel
4. Klik **"Create Account"**
5. Tunggu 5-10 menit sampai account ready

✅ Account ready kalau status = **"Active"**

---

## 🎯 STEP 3: Upload Laravel ke InfinityFree

### 3.1 Login ke cPanel

1. Di InfinityFree dashboard, klik **"Control Panel"** (tombol biru)
2. Akan redirect ke **cPanel** InfinityFree

### 3.2 Upload Files via File Manager

#### Opsi A: Upload Manual (Untuk pertama kali)

1. Di cPanel, cari dan klik **"Online File Manager"**
2. Navigate ke folder **`htdocs`** (ini root folder website)
3. Klik **"Upload"** (icon upload di toolbar)
4. Upload **ZIP file** project Laravel kamu:
   - Compress dulu project local jadi ZIP
   - Exclude: `vendor`, `node_modules`, `.git`, `.env`
5. Setelah upload, kembali ke File Manager
6. Klik kanan file ZIP → **"Extract"**
7. Setelah extract, delete file ZIP
8. Pindahkan semua file dari folder hasil extract ke **`htdocs`** langsung

**Struktur folder di `htdocs` harus seperti ini:**
```
htdocs/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── .htaccess       ← Root redirect
├── artisan
├── composer.json
├── deploy.php      ← Auto-deploy script
└── ...
```

#### Opsi B: Upload via FTP (Recommended untuk update)

1. Di cPanel, cari **"FTP Accounts"**
2. Lihat FTP credentials:
   - **FTP Server**: `ftpupload.net` atau `ftp.yourdomain.com`
   - **Username**: (sama dengan cPanel username)
   - **Password**: (sama dengan cPanel password)
3. Gunakan FTP client (FileZilla, WinSCP, dll)
4. Connect dan upload files ke folder `htdocs`

### 3.3 Setup Permissions

Di File Manager, set permissions:

1. Folder **`storage`** dan semua subfolder → **755** (rwxr-xr-x)
2. Folder **`bootstrap/cache`** → **755** (rwxr-xr-x)

Cara set permissions:
- Klik kanan folder → **"Change Permissions"**
- Centang: Owner (Read, Write, Execute), Group (Read, Execute), World (Read, Execute)
- Centang **"Recurse into subdirectories"**
- Klik **"Change"**

---

## 🎯 STEP 4: Setup Database MySQL

### 4.1 Buat Database

1. Di cPanel, cari dan klik **"MySQL Databases"**
2. Di bagian **"Create New Database"**:
   - **Database Name**: `peminjaman_buku` (akan jadi: `if0_12345678_peminjaman_buku`)
   - Klik **"Create Database"**

### 4.2 Buat User Database

1. Scroll ke **"MySQL Users"**
2. Di **"Add New User"**:
   - **Username**: `laravel_user`
   - **Password**: Buat password kuat → **Generate Password** (recommended)
   - **Copy password** dan simpan!
   - Klik **"Create User"**

### 4.3 Assign User ke Database

1. Scroll ke **"Add User To Database"**
2. Pilih:
   - **User**: `if0_12345678_laravel_user`
   - **Database**: `if0_12345678_peminjaman_buku`
3. Klik **"Add"**
4. Di halaman privileges, centang **"ALL PRIVILEGES"**
5. Klik **"Make Changes"**

### 4.4 Catat Database Credentials

Simpan info ini (akan dipakai untuk .env):

```
DB_HOST: sql123.infinityfree.com (lihat di "MySQL Databases" bagian atas)
DB_PORT: 3306
DB_DATABASE: if0_12345678_peminjaman_buku
DB_USERNAME: if0_12345678_laravel_user
DB_PASSWORD: (password yang tadi dibuat)
```

---

## 🎯 STEP 5: Setup Environment Variables (.env)

### 5.1 Buat File .env

1. Di File Manager (htdocs), klik **"New File"**
2. Nama file: `.env`
3. Klik kanan `.env` → **"Edit"**
4. Copy dari `.env.example` dan edit:

```env
APP_NAME="Peminjaman Buku"
APP_ENV=production
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=false
APP_URL=https://peminjamanbuku.infinityfreeapp.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database MySQL InfinityFree
DB_CONNECTION=mysql
DB_HOST=sql123.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_12345678_peminjaman_buku
DB_USERNAME=if0_12345678_laravel_user
DB_PASSWORD=your-database-password-here

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
FILESYSTEM_DISK=local

# Disable broadcasting & mail di free hosting
BROADCAST_CONNECTION=log
MAIL_MAILER=log
```

5. **Save**

### 5.2 Generate APP_KEY

**Masalah:** InfinityFree tidak support SSH, jadi tidak bisa run `php artisan key:generate`

**Solusi:**

#### Cara 1: Generate di Local
```powershell
# Di local, run:
php artisan key:generate --show
```
Copy hasilnya (contoh: `base64:abc123...`) dan paste ke `.env` di InfinityFree

#### Cara 2: Online Generator
1. Buka https://generate-random.org/laravel-key-generator
2. Klik **"Generate Laravel APP_KEY"**
3. Copy hasilnya (format: `base64:xxxxx`)
4. Paste ke `.env` di InfinityFree

---

## 🎯 STEP 6: Install Composer Dependencies

**Masalah:** InfinityFree tidak support SSH/Composer command

**Solusi:** Install dependencies di local, lalu upload

### 6.1 Di Local Computer

```powershell
# Install dependencies untuk production
composer install --no-dev --optimize-autoloader

# Buat ZIP file vendor folder
# Atau upload langsung via FTP
```

### 6.2 Upload ke InfinityFree

1. Upload folder **`vendor`** via FTP atau File Manager
2. Upload ke `htdocs/vendor`
3. Pastikan struktur: `htdocs/vendor/autoload.php` exists

**Alternatif:** Pakai **Softaculous** di cPanel untuk auto-install (jika tersedia)

---

## 🎯 STEP 7: Run Database Migration

**Masalah:** Tidak ada SSH untuk run `php artisan migrate`

**Solusi:** Buat file PHP helper untuk run migration

### 7.1 Buat File migrate.php

Di File Manager, create file baru: `htdocs/migrate.php`

```php
<?php
// Temporary migration script for InfinityFree
// DELETE THIS FILE after migration!

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run migration
$status = $kernel->call('migrate', [
    '--force' => true,
]);

echo "Migration status: " . $status . "\n";
echo "Migration completed! DELETE this file now for security.\n";
```

### 7.2 Run Migration

1. Buka browser: `https://peminjamanbuku.infinityfreeapp.com/migrate.php`
2. Wait sampai muncul: "Migration completed!"
3. **PENTING:** Langsung **delete file `migrate.php`** setelah selesai!

### 7.3 Run Seeder (Opsional)

Buat `htdocs/seed.php`:

```php
<?php
// Temporary seeder script
// DELETE THIS FILE after seeding!

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run seeder
$status = $kernel->call('db:seed', [
    '--force' => true,
]);

echo "Seeding status: " . $status . "\n";
echo "Seeding completed! DELETE this file now.\n";
```

Run: `https://peminjamanbuku.infinityfreeapp.com/seed.php`

**DELETE file after seeding!**

---

## 🎯 STEP 8: Test Website

1. Buka: `https://peminjamanbuku.infinityfreeapp.com`
2. Harus muncul halaman Laravel (landing page)
3. Test login admin & siswa
4. Test fitur peminjaman & pengembalian

### Troubleshooting

#### ❌ Error 500 / Blank page
**Solusi:**
1. Check `.htaccess` file exists di `htdocs/`
2. Check permissions `storage/` dan `bootstrap/cache/` = 755
3. Check `.env` file exists dan APP_KEY sudah diisi

#### ❌ Database connection failed
**Solusi:**
1. Double check DB credentials di `.env`
2. Pastikan database & user sudah dibuat di cPanel
3. Pastikan user sudah di-assign ke database dengan ALL PRIVILEGES

#### ❌ Class not found
**Solusi:**
1. Pastikan folder `vendor` sudah diupload lengkap
2. Check file `vendor/autoload.php` exists

#### ❌ Storage link error
**Solusi:**
1. Di cPanel File Manager, buat symbolic link manual:
2. Di `htdocs/public`, create new file `storage` → link ke `../storage/app/public`

---

## 🎯 STEP 9: Setup Auto-Deploy dari GitHub (Opsional)

### 9.1 Edit deploy.php

File `deploy.php` sudah ada di project. Edit bagian konfigurasi:

1. Di File Manager, edit `htdocs/deploy.php`
2. Update variabel:

```php
// GitHub Webhook Secret (buat random string)
define('WEBHOOK_SECRET', 'your-super-secret-key-12345');

// Your GitHub repository URL
define('REPO_URL', 'https://github.com/username-kamu/peminjaman-buku.git');

// Branch to deploy
define('BRANCH', 'main');

// Path to website (ganti dengan username kamu)
define('DEPLOY_PATH', '/home/if0_12345678/htdocs');
```

3. **Save**

### 9.2 Setup GitHub Webhook

1. Buka GitHub repository
2. **Settings** → **Webhooks** → **Add webhook**
3. Isi:
   - **Payload URL**: `https://peminjamanbuku.infinityfreeapp.com/deploy.php`
   - **Content type**: `application/json`
   - **Secret**: (sama dengan WEBHOOK_SECRET di deploy.php)
   - **Events**: Pilih **"Just the push event"**
   - **Active**: ✅ Centang
4. Klik **"Add webhook"**

### 9.3 Test Auto-Deploy

1. Edit file di local (misal: ubah README.md)
2. Commit & push:
   ```powershell
   git add .
   git commit -m "Test auto deploy"
   git push origin main
   ```
3. Check GitHub webhook → **Recent Deliveries** → harus ada ✅ hijau
4. Check website → perubahan harus muncul

### 9.4 Check Deploy Logs

Buka: `https://peminjamanbuku.infinityfreeapp.com/deploy.log`

Atau via File Manager: `htdocs/deploy.log`

---

## 🎯 STEP 10: Custom Domain dengan Cloudflare (Opsional)

### 10.1 Setup di InfinityFree

1. Di InfinityFree dashboard → **"Control Panel"**
2. Klik **"Addon Domains"** atau **"Parked Domains"**
3. Tambah domain: `yourdomain.com`
4. InfinityFree akan kasih nameserver info

### 10.2 Setup di Cloudflare

1. Login ke https://dash.cloudflare.com
2. **"Add a Site"** → Masukkan domain kamu
3. Pilih **Free plan**
4. Cloudflare akan scan DNS records
5. Update nameserver domain kamu ke Cloudflare nameserver:
   ```
   NS1: chloe.ns.cloudflare.com
   NS2: dayton.ns.cloudflare.com
   ```

### 10.3 Update DNS di Cloudflare

1. Di Cloudflare → **DNS** → **Records**
2. Add DNS record:
   - **Type**: `A`
   - **Name**: `@` (root domain) atau `peminjaman` (subdomain)
   - **IPv4 address**: Lihat di InfinityFree → "Account Settings" → IP Address
   - **Proxy status**: 🟠 **Proxied** (untuk SSL gratis)
   - **TTL**: Auto
3. Klik **"Save"**

### 10.4 Setup SSL di Cloudflare

1. Di Cloudflare → **SSL/TLS**
2. Mode: Pilih **"Flexible"** (karena InfinityFree)
3. Enable **"Always Use HTTPS"**
4. Enable **"Automatic HTTPS Rewrites"**

### 10.5 Update .env

Edit `.env` di InfinityFree:

```env
APP_URL=https://yourdomain.com
```

### 10.6 Tunggu DNS Propagasi

- Biasanya 5-30 menit (bisa sampai 24 jam)
- Check: https://dnschecker.org
- Buka `https://yourdomain.com` → Website live! 🎉

---

## 🔧 Update Website (Setelah Setup Auto-Deploy)

Setiap kali ada perubahan code:

```powershell
git add .
git commit -m "Update: deskripsi perubahan"
git push origin main
```

GitHub webhook akan otomatis trigger `deploy.php` di InfinityFree → Auto update! 🚀

**Catatan:** Kalau auto-deploy gagal, upload manual via FTP.

---

## 🛠️ Tips & Limitations InfinityFree

### ✅ Yang Gratis & Unlimited
- Hosting space: Unlimited
- Bandwidth: Unlimited
- MySQL databases: Unlimited
- Subdomains: Unlimited
- Custom domains: Unlimited
- SSL certificate (via Cloudflare): Gratis

### ⚠️ Limitations
- **Tidak ada SSH** → Tidak bisa run `php artisan` commands langsung
- **Tidak ada Composer CLI** → Install dependencies di local, upload via FTP
- **CPU limit** → Website bisa kena suspend kalau CPU usage tinggi
- **File Manager** → Max upload 10MB per file (gunakan FTP untuk file besar)
- **Cron jobs** → Tidak support (gunakan external cron service kalau perlu)
- **Email** → Tidak support SMTP langsung (gunakan third-party seperti Mailtrap/Gmail SMTP)

### 💡 Workarounds
- **Artisan commands** → Buat PHP script helper (seperti `migrate.php`)
- **Cron jobs** → Gunakan https://cron-job.org (gratis)
- **Large uploads** → Gunakan FTP client
- **Email** → Gunakan Gmail SMTP atau Mailtrap

---

## 📊 Monitoring & Maintenance

### Cek Resource Usage

1. InfinityFree dashboard → **"View Details"**
2. Lihat:
   - **Disk Usage**
   - **MySQL Usage**
   - **Hits** (bandwidth)

### Backup Database

**Manual Backup:**
1. cPanel → **"phpMyAdmin"**
2. Pilih database kamu
3. Klik **"Export"**
4. Format: **SQL**
5. Klik **"Go"** → Download `.sql` file

**Scheduled Backup:**
- Tidak ada auto backup di free plan
- Backup manual secara berkala (weekly/monthly)

### Monitor Uptime

Gunakan free uptime monitor:
- https://uptimerobot.com (gratis, monitor 50 websites)
- https://freshping.io (gratis)

---

## 🆘 Troubleshooting Umum

### Website down / suspended

**Penyebab:**
- CPU usage terlalu tinggi
- File hosting illegal
- Spam/malware detected

**Solusi:**
1. Check email dari InfinityFree
2. Login dashboard → lihat suspension reason
3. Fix issue → request unsuspend

### Database connection timeout

**Penyebab:**
- InfinityFree MySQL server kadang slow

**Solusi:**
1. Retry beberapa kali
2. Kalau persistent, contact support
3. Pastikan tidak terlalu banyak query berat

### File upload error

**Penyebab:**
- Max upload size via File Manager = 10MB

**Solusi:**
- Gunakan FTP client (FileZilla/WinSCP)
- Atau split file jadi beberapa bagian

---

## 🎓 Best Practices

1. ✅ **Backup database** secara berkala
2. ✅ **Gunakan Git** untuk version control
3. ✅ **Set APP_DEBUG=false** di production
4. ✅ **Set LOG_LEVEL=error** untuk hemat resource
5. ✅ **Optimize images** sebelum upload
6. ✅ **Use caching** (config, route, view cache)
7. ✅ **Monitor uptime** dengan UptimeRobot
8. ✅ **Gunakan Cloudflare** untuk CDN & SSL gratis
9. ✅ **Delete file helper** (`migrate.php`, `seed.php`) setelah digunakan
10. ✅ **Update dependencies** secara berkala

---

## 🆘 Butuh Bantuan?

- 📚 InfinityFree Forum: https://forum.infinityfree.com
- 📚 InfinityFree Docs: https://docs.infinityfree.net
- 📚 Laravel Docs: https://laravel.com/docs
- 💬 Laravel Indonesia: https://t.me/laravel_indonesia

---

## ✅ Checklist Deployment

- [ ] Code sudah di GitHub (Public repository)
- [ ] Account InfinityFree sudah aktif
- [ ] Files Laravel sudah diupload ke `htdocs`
- [ ] Permissions `storage/` dan `bootstrap/cache/` = 755
- [ ] Database MySQL sudah dibuat
- [ ] User database sudah dibuat & assigned
- [ ] File `.env` sudah dibuat dengan DB credentials
- [ ] APP_KEY sudah di-generate
- [ ] Folder `vendor` sudah diupload
- [ ] Migration sudah dirun (via `migrate.php`)
- [ ] Seeder sudah dirun (via `seed.php` - opsional)
- [ ] File helper (`migrate.php`, `seed.php`) sudah **dihapus**
- [ ] Website bisa diakses via subdomain InfinityFree
- [ ] Test login & fitur berfungsi
- [ ] (Opsional) Auto-deploy sudah setup
- [ ] (Opsional) Custom domain sudah ditambahkan
- [ ] (Opsional) Cloudflare SSL sudah aktif

---

🎉 **Selamat! Website kamu sudah live di internet - 100% GRATIS!**

**Website URL:**
- Subdomain gratis: `https://peminjamanbuku.infinityfreeapp.com`
- Custom domain (kalau ada): `https://yourdomain.com`

**Default credentials (setelah seeding):**
- Sesuai dengan seeder di `database/seeders/`
- Ganti password default setelah deployment!

---

**Dibuat dengan ❤️ untuk hosting Laravel gratis & mudah**

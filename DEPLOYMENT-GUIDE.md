# 🚀 Panduan Deployment ke Railway + GitHub + Cloudflare

Panduan lengkap deploy aplikasi **Peminjaman Buku** ke Railway.app dengan domain custom dari Cloudflare - **GRATIS!**

---

## 📋 Yang Dibutuhkan

- ✅ Akun GitHub (gratis)
- ✅ Akun Railway.app (gratis - 500 jam/bulan)
- ✅ Akun Cloudflare (gratis - opsional untuk custom domain)
- ✅ Domain (bisa gratis dari Freenom atau pakai domain sendiri)

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
   - **Public** atau **Private** (pilih sesuai keinginan)
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

## 🎯 STEP 2: Deploy ke Railway

### 2.1 Sign Up Railway

1. Buka https://railway.app
2. Klik **"Login"** → Pilih **"Login with GitHub"**
3. Authorize Railway untuk akses GitHub
4. Verifikasi email kalau diminta

### 2.2 Buat Project Baru

1. Di Railway dashboard, klik **"New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Pilih repository **peminjaman-buku** yang tadi dibuat
4. Klik repository → Railway akan otomatis detect Laravel

### 2.3 Tambah MySQL Database

1. Di project Railway, klik **"+ New"**
2. Pilih **"Database"** → **"Add MySQL"**
3. Railway akan otomatis create MySQL database
4. Tunggu sampai database ready (ikon hijau)

### 2.4 Setting Environment Variables

1. Klik service **peminjaman-buku** (yang Laravel)
2. Klik tab **"Variables"**
3. Klik **"+ New Variable"** dan tambahkan satu per satu:

```bash
APP_NAME=Peminjaman Buku
APP_ENV=production
APP_KEY=base64:xxxxxxxxxxx
APP_DEBUG=false
APP_URL=https://peminjaman-buku-production.up.railway.app

LOG_LEVEL=error

# Database - Copy dari MySQL service Variables tab
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=6543
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=xxxxxxxxxxxxx

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

#### 🔑 Generate APP_KEY

Di local, jalankan:

```powershell
php artisan key:generate --show
```

Copy hasilnya (contoh: `base64:abc123...`) dan paste ke Railway variable `APP_KEY`.

#### 🗄️ Database Credentials

1. Klik service **MySQL** di Railway
2. Klik tab **"Variables"**
3. Copy nilai dari:
   - `MYSQLHOST` → paste ke `DB_HOST`
   - `MYSQLPORT` → paste ke `DB_PORT`
   - `MYSQLDATABASE` → paste ke `DB_DATABASE`
   - `MYSQLUSER` → paste ke `DB_USERNAME`
   - `MYSQLPASSWORD` → paste ke `DB_PASSWORD`

### 2.5 Deploy!

1. Railway akan otomatis build & deploy
2. Lihat progress di tab **"Deployments"**
3. Tunggu sampai status **"SUCCESS"** (sekitar 5-10 menit first deploy)
4. Setelah success, klik **"View Logs"** untuk cek ada error atau tidak

### 2.6 Generate Domain Railway

1. Klik tab **"Settings"**
2. Scroll ke bagian **"Domains"**
3. Klik **"Generate Domain"**
4. Railway akan kasih domain gratis: `peminjaman-buku-production.up.railway.app`
5. Buka domain itu di browser → **Website live!** 🎉

---

## 🎯 STEP 3: Custom Domain dengan Cloudflare (Opsional)

### 3.1 Setup di Cloudflare

1. Login ke https://dash.cloudflare.com
2. Pilih domain kamu (atau tambah domain baru)
3. Klik **"DNS"** di sidebar

### 3.2 Tambah DNS Record

1. Klik **"Add record"**
2. Isi:
   - **Type**: `CNAME`
   - **Name**: `@` (untuk root domain) atau `peminjaman` (untuk subdomain)
   - **Target**: `peminjaman-buku-production.up.railway.app` (domain Railway kamu)
   - **Proxy status**: 🟠 **Proxied** (agar dapat SSL gratis dari Cloudflare)
   - **TTL**: Auto
3. Klik **"Save"**

### 3.3 Setup di Railway

1. Balik ke Railway dashboard
2. Klik service **peminjaman-buku**
3. Tab **"Settings"** → scroll ke **"Domains"**
4. Klik **"Custom Domain"**
5. Masukkan domain kamu: `yourdomain.com` atau `peminjaman.yourdomain.com`
6. Klik **"Add"**

### 3.4 Update Environment Variables

1. Klik tab **"Variables"**
2. Edit variable **APP_URL**:
   ```
   APP_URL=https://yourdomain.com
   ```
3. Save → Railway akan auto redeploy

### 3.5 Tunggu DNS Propagasi

- Biasanya 5-30 menit
- Cek di https://dnschecker.org
- Kalau sudah hijau semua, buka domain kamu → **Website live dengan domain sendiri!** 🎉

---

## 🔧 Update Website (After Deployment)

Setiap kali ada perubahan code:

```powershell
git add .
git commit -m "Update: deskripsi perubahan"
git push origin main
```

Railway akan **otomatis detect** push baru dan **auto deploy** (sekitar 3-5 menit).

---

## 🛠️ Troubleshooting

### ❌ Error: "No application encryption key has been specified"

**Solusi:**
1. Generate key local: `php artisan key:generate --show`
2. Copy hasilnya
3. Tambahkan ke Railway Variables: `APP_KEY=base64:xxx...`

### ❌ Error: Database connection failed

**Solusi:**
1. Cek Railway MySQL service masih running (hijau)
2. Cek environment variables `DB_*` sudah benar
3. Copy ulang credentials dari MySQL Variables tab

### ❌ Error: 500 Internal Server Error

**Solusi:**
1. Buka Railway → Klik service → Tab **"Deployments"**
2. Klik deployment terakhir → **"View Logs"**
3. Cari error di logs (biasanya ada di bagian bawah)
4. Fix error → push lagi ke GitHub

### ❌ Website lambat atau not found

**Solusi:**
1. Railway free tier ada cold start (kalau lama ga diakses, perlu 10-30 detik untuk bangun)
2. Cek di Railway tab "Deployments" apakah status **"SUCCESS"**
3. Kalau masih error, cek logs

### ❌ Custom domain tidak bisa diakses

**Solusi:**
1. Cek DNS sudah propagasi: https://dnschecker.org
2. Pastikan Cloudflare Proxy Status = 🟠 **Proxied**
3. Pastikan di Railway sudah add custom domain
4. Tunggu 5-30 menit untuk DNS propagasi

---

## 📊 Monitoring & Maintenance

### Cek Resource Usage

1. Railway Dashboard → Klik project
2. Lihat **"Usage"** di bagian atas
3. Free tier: **500 jam/bulan** (cukup untuk 1 website 24/7)
4. Kalau over limit, website akan sleep sampai bulan depan

### Backup Database

Railway MySQL gratis tidak include automated backup. Solusi:

**Manual Backup (Recommended):**
```powershell
# Local, install MySQL client dulu
mysqldump -h containers-us-west-xxx.railway.app -P 6543 -u root -p railway > backup.sql
```

**Schedule Backup:** Bisa pakai GitHub Actions atau cron job.

---

## 🎓 Tips & Best Practices

1. ✅ **Jangan commit file `.env`** → Sudah ada di `.gitignore`
2. ✅ **Gunakan `APP_DEBUG=false`** di production
3. ✅ **Set `LOG_LEVEL=error`** untuk hemat resource
4. ✅ **Monitor usage** Railway agar tidak over limit
5. ✅ **Backup database** secara berkala
6. ✅ **Gunakan Cloudflare** untuk SSL gratis + CDN
7. ✅ **Test di local dulu** sebelum push ke production

---

## 🆘 Butuh Bantuan?

- 📚 Railway Docs: https://docs.railway.app
- 📚 Laravel Deployment: https://laravel.com/docs/deployment
- 📚 Cloudflare Docs: https://developers.cloudflare.com
- 💬 Railway Discord: https://discord.gg/railway
- 💬 Laravel Indonesia: https://t.me/laravel_indonesia

---

## ✅ Checklist Deployment

- [ ] Code sudah di GitHub
- [ ] Project Railway sudah dibuat
- [ ] MySQL database sudah ditambahkan
- [ ] Environment variables sudah diset (minimal APP_KEY + DB_*)
- [ ] Website bisa diakses via domain Railway
- [ ] (Opsional) Custom domain sudah ditambahkan
- [ ] (Opsional) DNS Cloudflare sudah diset
- [ ] Website bisa diakses via custom domain
- [ ] Test login admin & siswa berfungsi
- [ ] Test fitur peminjaman & pengembalian berfungsi

---

🎉 **Selamat! Website kamu sudah live di internet!**

**Default credentials (setelah migration + seeding):**
- Admin: Sesuai user seeder
- Siswa: Sesuai anggota seeder

Jangan lupa ganti password default setelah deployment!

---

**Dibuat dengan ❤️ untuk deployment mudah & gratis**

@extends('layouts.app')
@section('title','Login — Perpustakaan Sekolah Digital')

@push('styles')
<style>
/* ═══════════════════════════════════════════════════
   MODERN LOGIN PAGE — Reference Split Screen
═══════════════════════════════════════════════════ */
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: url('/image/awan.jpg') center center / cover no-repeat;
  padding: 24px;
  position: relative;
  overflow: hidden;
}

/* Overlay tipis biar card tetap keliatan jelas */
.login-page::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,.15);
  pointer-events: none;
  z-index: 0;
}
.login-page::after { display: none; }

/* Card utama */
.login-card {
  display: flex;
  width: 100%;
  max-width: 900px;
  min-height: 520px;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 24px 80px rgba(14,30,60,.18), 0 4px 16px rgba(0,0,0,.08);
  position: relative;
  z-index: 1;
}

/* ── KIRI: Maskot penuh seperti referensi ── */
.lc-left {
  flex: 1.05;
  position: relative;
  overflow: hidden;
  background: linear-gradient(165deg, #0d1830 0%, #1b3060 55%, #14284B 100%);
  border-radius: 24px 0 0 24px;
}

/* Foto maskot mengisi penuh panel, object-fit cover */
.lc-mascot-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center top;
  display: block;
}

/* Overlay gradient di bawah untuk teks terbaca */
.lc-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to bottom,
    transparent 40%,
    rgba(10,22,50,.55) 65%,
    rgba(8,18,42,.85) 100%
  );
}

/* Teks di bawah panel kiri */
.lc-text {
  position: absolute;
  bottom: 0;
  left: 0; right: 0;
  padding: 28px 30px;
  z-index: 2;
}

.lc-tagline {
  font-size: 1.55rem;
  font-weight: 900;
  color: #fff;
  line-height: 1.2;
  letter-spacing: -.02em;
  text-shadow: 0 2px 12px rgba(0,0,0,.35);
  margin: 0 0 10px;
}

.lc-badges {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.lc-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: rgba(255,255,255,.15);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,.2);
  padding: 5px 12px;
  border-radius: 8px;
  font-size: .73rem;
  font-weight: 700;
  color: rgba(255,255,255,.9);
}
.lc-badge i { color: #ED1B3B; font-size: .8rem; }

/* ── KANAN: Form login ── */
.lc-right {
  flex: 1;
  background: #fff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 44px 44px;
  position: relative;
}

/* Back link */
.lc-back {
  position: absolute;
  top: 20px; left: 24px;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  color: var(--tx-3);
  font-size: .76rem;
  font-weight: 600;
  text-decoration: none;
  transition: color .2s;
}
.lc-back:hover { color: var(--navy); }

/* Logo di tengah di atas judul */
.lc-logo-wrap {
  display: flex;
  justify-content: center;
  margin-bottom: 14px;
}

.lc-logo {
  width: 90px;
  height: 90px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lc-logo img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.lc-heading {
  text-align: center;
  margin-bottom: 28px;
}

.lc-title {
  font-size: 1.55rem;
  font-weight: 900;
  color: var(--navy-800);
  margin: 0 0 5px;
  letter-spacing: -.03em;
}

.lc-subtitle {
  font-size: .82rem;
  color: var(--tx-3);
  margin: 0;
}

/* Alert */
.lc-alert {
  background: #fef2f2;
  border: 1px solid #fecaca;
  border-radius: 10px;
  padding: 11px 14px;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  gap: 9px;
  color: #991b1b;
  font-size: .82rem;
  font-weight: 600;
}
.lc-alert i { flex-shrink: 0; }

/* Form fields */
.lc-group { margin-bottom: 15px; }

.lc-label {
  display: block;
  font-size: .8rem;
  font-weight: 700;
  color: var(--tx-2);
  margin-bottom: 6px;
}

.lc-field-wrap { position: relative; }

.lc-field-icon {
  position: absolute;
  left: 13px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--tx-4);
  font-size: .85rem;
  pointer-events: none;
  z-index: 1;
}

.lc-input {
  width: 100%;
  padding: 11px 13px 11px 38px;
  border: 1.5px solid var(--border);
  border-radius: 10px;
  font-size: .85rem;
  font-weight: 500;
  color: var(--tx-1);
  background: var(--bg);
  transition: border-color .2s, box-shadow .2s;
}
.lc-input:focus {
  outline: none;
  border-color: var(--crimson);
  box-shadow: 0 0 0 3px rgba(237,27,59,.1);
  background: #fff;
}
.lc-input::placeholder { color: var(--tx-4); }

.lc-eye {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: var(--tx-4);
  cursor: pointer;
  padding: 3px;
  font-size: .88rem;
  transition: color .2s;
  z-index: 2;
}
.lc-eye:hover { color: var(--tx-2); }

/* Remember */
.lc-remember {
  display: flex;
  align-items: center;
  gap: 7px;
  margin-bottom: 18px;
}
.lc-remember input {
  width: 15px; height: 15px;
  accent-color: var(--crimson);
  cursor: pointer;
}
.lc-remember label {
  font-size: .8rem;
  color: var(--tx-3);
  font-weight: 600;
  cursor: pointer;
  margin: 0;
}

/* Submit button */
.lc-btn {
  width: 100%;
  padding: 12px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  border: none;
  border-radius: 10px;
  color: #fff;
  font-size: .88rem;
  font-weight: 800;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  cursor: pointer;
  transition: all .25s;
  box-shadow: 0 6px 20px rgba(237,27,59,.35);
}
.lc-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 28px rgba(237,27,59,.45);
}
.lc-btn:active { transform: translateY(0); }

/* Footer links */
.lc-footer {
  margin-top: 20px;
  padding-top: 18px;
  border-top: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  gap: 8px;
  text-align: center;
  font-size: .8rem;
}
.lc-footer span { color: var(--tx-3); }
.lc-footer a { font-weight: 700; text-decoration: none; transition: opacity .2s; }
.lc-footer a:hover { opacity: .75; }
.lc-footer .a-siswa { color: var(--crimson); }
.lc-footer .a-admin { color: var(--navy); }

/* Responsive */
@media (max-width: 820px) {
  .login-card { flex-direction: column; max-width: 460px; min-height: auto; }
  .lc-left { flex: none; height: 280px; border-radius: 24px 24px 0 0; }
  .lc-right { padding: 36px 30px; }
}
@media (max-width: 500px) {
  .login-page { padding: 12px; }
  .lc-left { height: 220px; }
  .lc-right { padding: 28px 20px; }
  .lc-tagline { font-size: 1.25rem; }
}
</style>
@endpush

@section('content')

<div class="login-page">
  <div class="login-card">

    {{-- ── KIRI: Maskot penuh ── --}}
    <div class="lc-left">
      {{-- Foto maskot mengisi penuh panel -- letakkan di public/image/maskot32.jpg --}}
      <img src="/image/maskot32.jpg" alt="Maskot Perpustakaan" class="lc-mascot-img">
      <div class="lc-overlay"></div>
      <div class="lc-text">
        <p class="lc-tagline">JELAJAHI.<br>PINJAM.<br>TUMBUH.</p>
        <div class="lc-badges">
          <span class="lc-badge"><i class="bi bi-book-fill"></i> Koleksi Lengkap</span>
          <span class="lc-badge"><i class="bi bi-lightning-fill"></i> Akses Cepat</span>
        </div>
      </div>
    </div>

    {{-- ── KANAN: Form login ── --}}
    <div class="lc-right">
      <a href="{{ route('landing') }}" class="lc-back">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>

      {{-- Logo di tengah -- gunakan PNG transparan di public/image/logo.png --}}
      <div class="lc-logo-wrap">
        <div class="lc-logo">
          <img src="/image/logo.png" alt="Logo Perpustakaan">
        </div>
      </div>

      <div class="lc-heading">
        <h2 class="lc-title">Masuk ke Akun</h2>
        <p class="lc-subtitle">Masukkan email &amp; password Anda</p>
      </div>

      @if($errors->any())
      <div class="lc-alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        <span>{{ $errors->first() }}</span>
      </div>
      @endif

      @if(session('info'))
      <div class="lc-alert" style="background:#eff6ff;border-color:#bfdbfe;color:#1e40af">
        <i class="bi bi-info-circle-fill" style="color:#3b82f6"></i>
        <span>{{ session('info') }}</span>
      </div>
      @endif

      @if(session('warning'))
      <div class="lc-alert" style="background:#fffbeb;border-color:#fde68a;color:#92400e">
        <i class="bi bi-exclamation-triangle-fill" style="color:#f59e0b"></i>
        <span>{{ session('warning') }}</span>
      </div>
      @endif

      @if(session('success'))
      <div class="lc-alert" style="background:#f0fdf4;border-color:#bbf7d0;color:#166534">
        <i class="bi bi-check-circle-fill" style="color:#22c55e"></i>
        <span>{{ session('success') }}</span>
      </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="lc-group">
          <label class="lc-label" for="email">Email</label>
          <div class="lc-field-wrap">
            <i class="bi bi-envelope-fill lc-field-icon"></i>
            <input type="email" id="email" name="email" class="lc-input"
                   value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
          </div>
        </div>

        <div class="lc-group">
          <label class="lc-label" for="password">Password</label>
          <div class="lc-field-wrap">
            <i class="bi bi-lock-fill lc-field-icon"></i>
            <input type="password" id="password" name="password" class="lc-input"
                   placeholder="••••••••" required style="padding-right:40px">
            <button type="button" class="lc-eye" onclick="togglePwd()">
              <i class="bi bi-eye-slash" id="eyeIco"></i>
            </button>
          </div>
        </div>

        <div class="lc-remember">
          <input type="checkbox" name="remember" id="remember">
          <label for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="lc-btn">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Masuk Sekarang</span>
        </button>
      </form>

      <div class="lc-footer">
        <div>
          <span>Belum punya akun? </span>
          <a href="{{ route('register') }}" class="a-siswa">Daftar sebagai Siswa →</a>
        </div>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script>
function togglePwd() {
  const f = document.getElementById('password');
  const e = document.getElementById('eyeIco');
  f.type = f.type === 'password' ? 'text' : 'password';
  e.className = f.type === 'text' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush

@endsection

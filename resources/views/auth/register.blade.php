@extends('layouts.app')
@section('title','Daftar Anggota — Perpustakaan Sekolah Digital')

@push('styles')
<style>
/* ═══════════════════════════════════════════════════
   REGISTER PAGE — Same Design as Login
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
.login-page::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,.15);
  pointer-events: none;
  z-index: 0;
}

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

/* ── KIRI ── */
.lc-left {
  flex: 1.05;
  position: relative;
  overflow: hidden;
  background: linear-gradient(165deg, #0d1830 0%, #1b3060 55%, #14284B 100%);
  border-radius: 24px 0 0 24px;
}
.lc-mascot-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center top;
}
.lc-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, transparent 40%, rgba(10,22,50,.55) 65%, rgba(8,18,42,.85) 100%);
}
.lc-text {
  position: absolute;
  bottom: 0; left: 0; right: 0;
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
.lc-badges { display: flex; gap: 8px; flex-wrap: wrap; }
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

/* ── KANAN ── */
.lc-right {
  flex: 1;
  background: #fff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding: 28px 38px;
  position: relative;
}
.lc-back {
  position: absolute;
  top: 16px; left: 20px;
  display: inline-flex; align-items: center; gap: 5px;
  color: var(--tx-3); font-size: .74rem; font-weight: 600;
  text-decoration: none; transition: color .2s;
}
.lc-back:hover { color: var(--navy); }

.lc-logo-wrap { display: flex; justify-content: center; margin-bottom: 6px; }
.lc-logo { width: 68px; height: 68px; display: flex; align-items: center; justify-content: center; }
.lc-logo img { width: 100%; height: 100%; object-fit: contain; }

.lc-heading { text-align: center; margin-bottom: 12px; }
.lc-title { font-size: 1.3rem; font-weight: 900; color: var(--navy-800); margin: 0 0 3px; letter-spacing: -.03em; }
.lc-subtitle { font-size: .78rem; color: var(--tx-3); margin: 0; }

/* ── STEP INDICATOR ── */
.step-indicator {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  margin-bottom: 14px;
}
.step-dot {
  width: 30px; height: 30px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: .75rem; font-weight: 800;
  transition: all .3s;
  flex-shrink: 0;
}
.step-dot.active {
  background: var(--crimson);
  color: #fff;
  box-shadow: 0 4px 12px rgba(237,27,59,.35);
}
.step-dot.done {
  background: #10b981;
  color: #fff;
}
.step-dot.inactive {
  background: var(--border);
  color: var(--tx-4);
}
.step-line {
  flex: 1;
  max-width: 60px;
  height: 2px;
  background: var(--border);
  transition: background .3s;
}
.step-line.done { background: #10b981; }
.step-label {
  font-size: .7rem;
  font-weight: 700;
  margin-top: 4px;
  text-align: center;
}

/* ── FORM STEPS ── */
.form-step { display: none; }
.form-step.active { display: block; }

/* Alert */
.lc-alert {
  background: #fef2f2;
  border: 1px solid #fecaca;
  border-radius: 10px;
  padding: 11px 14px;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 9px;
  color: #991b1b;
  font-size: .8rem;
  font-weight: 600;
}
.lc-alert i { flex-shrink: 0; }

/* Fields */
.lc-group { margin-bottom: 10px; }
.lc-label { display: block; font-size: .76rem; font-weight: 700; color: var(--tx-2); margin-bottom: 4px; }
.lc-field-wrap { position: relative; }
.lc-field-icon {
  position: absolute; left: 12px; top: 50%;
  transform: translateY(-50%);
  color: var(--tx-4); font-size: .82rem;
  pointer-events: none; z-index: 1;
}
.lc-input {
  width: 100%;
  padding: 10px 12px 10px 36px;
  border: 1.5px solid var(--border);
  border-radius: 9px;
  font-size: .83rem; font-weight: 500;
  color: var(--tx-1); background: var(--bg);
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
  position: absolute; right: 11px; top: 50%;
  transform: translateY(-50%);
  background: none; border: none;
  color: var(--tx-4); cursor: pointer;
  padding: 3px; font-size: .85rem;
  transition: color .2s; z-index: 2;
}
.lc-eye:hover { color: var(--tx-2); }

.row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

/* Buttons */
.lc-btn-row { display: flex; gap: 10px; margin-top: 14px; }
.lc-btn {
  flex: 1; padding: 10px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  border: none; border-radius: 9px;
  color: #fff; font-size: .84rem; font-weight: 800;
  display: flex; align-items: center; justify-content: center; gap: 7px;
  cursor: pointer; transition: all .25s;
  box-shadow: 0 6px 20px rgba(237,27,59,.3);
}
.lc-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(237,27,59,.4); }
.lc-btn:active { transform: translateY(0); }
.lc-btn-outline {
  flex: 1; padding: 10px;
  background: linear-gradient(135deg, var(--navy) 0%, var(--navy-700) 100%);
  border: none; border-radius: 9px;
  color: #fff; font-size: .84rem; font-weight: 700;
  display: flex; align-items: center; justify-content: center; gap: 7px;
  cursor: pointer; transition: all .25s;
  box-shadow: 0 6px 20px rgba(20,40,75,.3);
}
.lc-btn-outline:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(20,40,75,.4); }

/* Footer */
.lc-footer {
  margin-top: 10px;
  padding-top: 10px;
  border-top: 1px solid var(--border);
  text-align: center;
  font-size: .78rem;
}
.lc-footer span { color: var(--tx-3); }
.lc-footer a { font-weight: 700; text-decoration: none; }
.lc-footer .a-login { color: var(--crimson); }

/* Responsive */
@media (max-width: 820px) {
  .login-card { flex-direction: column; max-width: 460px; min-height: auto; }
  .lc-left { flex: none; height: 220px; border-radius: 24px 24px 0 0; }
  .lc-right { padding: 30px 24px; }
}
@media (max-width: 500px) {
  .login-page { padding: 12px; }
  .lc-right { padding: 24px 18px; }
  .row-2 { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<div class="login-page">
  <div class="login-card">

    {{-- ── KIRI ── --}}
    <div class="lc-left">
      <img src="/image/maskot32.jpg" alt="Maskot" class="lc-mascot-img">
      <div class="lc-overlay"></div>
      <div class="lc-text">
        <p class="lc-tagline">BERGABUNG.<br>BELAJAR.<br>BERKEMBANG.</p>
        <div class="lc-badges">
          <span class="lc-badge"><i class="bi bi-person-check-fill"></i> Daftar Gratis</span>
          <span class="lc-badge"><i class="bi bi-book-fill"></i> Ribuan Buku</span>
        </div>
      </div>
    </div>

    {{-- ── KANAN ── --}}
    <div class="lc-right">
      <a href="{{ route('landing') }}" class="lc-back">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>

      <div class="lc-logo-wrap">
        <div class="lc-logo">
          <img src="/image/logo.png" alt="Logo">
        </div>
      </div>

      <div class="lc-heading">
        <h2 class="lc-title">Daftar Anggota Baru</h2>
        <p class="lc-subtitle">Isi data di bawah untuk membuat akun</p>
      </div>

      {{-- Step Indicator --}}
      <div class="step-indicator" id="stepIndicator">
        <div style="display:flex;flex-direction:column;align-items:center;gap:3px">
          <div class="step-dot active" id="dot1">1</div>
          <span class="step-label" style="color:var(--crimson)">Data Diri</span>
        </div>
        <div class="step-line" id="line1"></div>
        <div style="display:flex;flex-direction:column;align-items:center;gap:3px">
          <div class="step-dot inactive" id="dot2">2</div>
          <span class="step-label" style="color:var(--tx-4)">Akun</span>
        </div>
      </div>

      @if($errors->any())
      <div class="lc-alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        <span>{{ $errors->first() }}</span>
      </div>
      @endif

      <form method="POST" action="{{ route('register.post') }}" id="regForm">
        @csrf

        {{-- STEP 1: Data Diri --}}
        <div class="form-step active" id="step1">
          <div class="lc-group">
            <label class="lc-label">Nama Lengkap <span style="color:var(--crimson)">*</span></label>
            <div class="lc-field-wrap">
              <i class="bi bi-person-fill lc-field-icon"></i>
              <input type="text" name="name" class="lc-input" value="{{ old('name') }}" placeholder="Nama sesuai rapor" required>
            </div>
          </div>
          <div class="row-2">
            <div class="lc-group">
              <label class="lc-label">NIS <span style="color:var(--crimson)">*</span></label>
              <div class="lc-field-wrap">
                <i class="bi bi-credit-card-fill lc-field-icon"></i>
                <input type="text" name="nis" class="lc-input" value="{{ old('nis') }}" placeholder="Nomor Induk Siswa" required>
              </div>
            </div>
            <div class="lc-group">
              <label class="lc-label">Kelas <span style="color:var(--crimson)">*</span></label>
              <div class="lc-field-wrap">
                <i class="bi bi-mortarboard-fill lc-field-icon"></i>
                <input type="text" name="kelas" class="lc-input" value="{{ old('kelas') }}" placeholder="XI-RPL-1" required>
              </div>
            </div>
          </div>
          <div class="row-2">
            <div class="lc-group">
              <label class="lc-label">No. Telepon</label>
              <div class="lc-field-wrap">
                <i class="bi bi-telephone-fill lc-field-icon"></i>
                <input type="text" name="telepon" class="lc-input" value="{{ old('telepon') }}" placeholder="08xxxxxxxxx">
              </div>
            </div>
            <div class="lc-group">
              <label class="lc-label">Alamat</label>
              <div class="lc-field-wrap">
                <i class="bi bi-geo-alt-fill lc-field-icon"></i>
                <input type="text" name="alamat" class="lc-input" value="{{ old('alamat') }}" placeholder="Domisili">
              </div>
            </div>
          </div>

          <div class="lc-btn-row">
            <button type="button" class="lc-btn" onclick="goStep2()">
              Lanjut <i class="bi bi-arrow-right"></i>
            </button>
          </div>
        </div>

        {{-- STEP 2: Data Akun --}}
        <div class="form-step" id="step2">
          <div class="lc-group">
            <label class="lc-label">Email <span style="color:var(--crimson)">*</span></label>
            <div class="lc-field-wrap">
              <i class="bi bi-envelope-fill lc-field-icon"></i>
              <input type="email" name="email" class="lc-input" value="{{ old('email') }}" placeholder="nama@email.com" required>
            </div>
          </div>
          <div class="lc-group">
            <label class="lc-label">Password <span style="color:var(--crimson)">*</span></label>
            <div class="lc-field-wrap">
              <i class="bi bi-lock-fill lc-field-icon"></i>
              <input type="password" name="password" id="pwd" class="lc-input" placeholder="Min. 6 karakter" required style="padding-right:38px">
              <button type="button" class="lc-eye" onclick="togglePwd('pwd','eye1')">
                <i class="bi bi-eye-slash" id="eye1"></i>
              </button>
            </div>
          </div>
          <div class="lc-group">
            <label class="lc-label">Konfirmasi Password <span style="color:var(--crimson)">*</span></label>
            <div class="lc-field-wrap">
              <i class="bi bi-lock-fill lc-field-icon"></i>
              <input type="password" name="password_confirmation" id="pwd2" class="lc-input" placeholder="Ulangi password" required style="padding-right:38px">
              <button type="button" class="lc-eye" onclick="togglePwd('pwd2','eye2')">
                <i class="bi bi-eye-slash" id="eye2"></i>
              </button>
            </div>
          </div>

          <div class="lc-btn-row">
            <button type="button" class="lc-btn-outline" onclick="goStep1()">
              <i class="bi bi-arrow-left"></i> Kembali
            </button>
            <button type="submit" class="lc-btn">
              <i class="bi bi-person-check-fill"></i> Daftar
            </button>
          </div>
        </div>

      </form>

      <div class="lc-footer">
        <span>Sudah punya akun? </span>
        <a href="{{ route('login') }}" class="a-login">Masuk di sini →</a>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script>
// Kalau ada error dari server, langsung tampil step 2 jika errornya di field akun
const serverErrors = @json($errors->keys());
const step2Fields = ['email','password','password_confirmation'];
if (serverErrors.some(k => step2Fields.includes(k))) {
  showStep(2);
} else if (serverErrors.length > 0) {
  showStep(1);
}

function showStep(n) {
  document.getElementById('step1').classList.toggle('active', n === 1);
  document.getElementById('step2').classList.toggle('active', n === 2);

  const dot1 = document.getElementById('dot1');
  const dot2 = document.getElementById('dot2');
  const line1 = document.getElementById('line1');

  if (n === 1) {
    dot1.className = 'step-dot active';
    dot2.className = 'step-dot inactive';
    line1.classList.remove('done');
    dot1.closest('div').querySelector('.step-label').style.color = 'var(--crimson)';
    dot2.closest('div').querySelector('.step-label').style.color = 'var(--tx-4)';
  } else {
    dot1.className = 'step-dot done';
    dot1.innerHTML = '<i class="bi bi-check-lg" style="font-size:.75rem"></i>';
    dot2.className = 'step-dot active';
    line1.classList.add('done');
    dot1.closest('div').querySelector('.step-label').style.color = '#10b981';
    dot2.closest('div').querySelector('.step-label').style.color = 'var(--crimson)';
  }
}

function goStep2() {
  // Validasi step 1 sebelum lanjut
  const name = document.querySelector('[name="name"]');
  const nis  = document.querySelector('[name="nis"]');
  const kelas= document.querySelector('[name="kelas"]');
  if (!name.value.trim() || !nis.value.trim() || !kelas.value.trim()) {
    name.reportValidity();
    return;
  }
  showStep(2);
}

function goStep1() { showStep(1); }

function togglePwd(fieldId, iconId) {
  const f = document.getElementById(fieldId);
  const e = document.getElementById(iconId);
  f.type = f.type === 'password' ? 'text' : 'password';
  e.className = f.type === 'text' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush

@endsection

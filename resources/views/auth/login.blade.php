@extends('layouts.app')
@section('title','Login — Perpustakaan Sekolah Digital')
@section('content')
<div class="auth-bg">
  <div class="auth-card">
    {{-- Tombol kembali ke landing --}}
    <a href="{{ route('landing') }}" style="display:flex;align-items:center;gap:7px;color:var(--tx3);font-size:.78rem;font-weight:600;margin-bottom:22px;width:fit-content;transition:color .15s;padding:6px 0"
       onmouseover="this.style.color='var(--navy)'" onmouseout="this.style.color='var(--tx3)'">
      <i class="bi bi-arrow-left" style="font-size:.85rem"></i> Kembali ke Beranda
    </a>

    <div style="text-align:center;margin-bottom:30px">
      <div style="width:58px;height:58px;border-radius:16px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));display:flex;align-items:center;justify-content:center;font-size:1.5rem;color:#fff;margin:0 auto 14px;box-shadow:0 8px 24px rgba(237,27,59,.28)">
        <i class="bi bi-book-half"></i>
      </div>
      <h5 style="font-weight:900;color:var(--navy);margin:0 0 5px;font-size:1.15rem;letter-spacing:-.02em">Masuk ke Akun</h5>
      <p style="color:var(--tx3);font-size:.81rem;margin:0">Masukkan email &amp; password Anda</p>
    </div>

    @if($errors->any())
    <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" style="border-radius:10px">
      <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
      <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div style="margin-bottom:16px">
        <label class="form-label" for="email">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope-fill" style="color:var(--crimson);font-size:.82rem"></i></span>
          <input type="email" id="email" name="email" class="form-control"
                 value="{{ old('email') }}" placeholder="nama@email.com" required autofocus
                 style="border-left:0">
        </div>
      </div>
      <div style="margin-bottom:20px">
        <label class="form-label" for="password">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill" style="color:var(--crimson);font-size:.82rem"></i></span>
          <input type="password" id="password" name="password" class="form-control"
                 placeholder="••••••••" required style="border-left:0;border-right:0">
          <button type="button" class="input-group-text" onclick="togglePwd()" style="cursor:pointer;border-left:0">
            <i class="bi bi-eye-slash" id="eyeIco" style="color:var(--tx4);font-size:.82rem"></i>
          </button>
        </div>
      </div>
      <div style="display:flex;align-items:center;margin-bottom:22px">
        <label style="display:flex;align-items:center;gap:8px;font-size:.79rem;color:var(--tx3);cursor:pointer">
          <input type="checkbox" name="remember" style="width:15px;height:15px;accent-color:var(--crimson)">
          Ingat saya
        </label>
      </div>
      <button type="submit" class="btn btn-navy w-100" style="justify-content:center;padding:12px !important;font-size:.9rem !important">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
      </button>
    </form>

    <div style="text-align:center;margin-top:22px;padding-top:18px;border-top:1px solid var(--border)">
      <span style="font-size:.79rem;color:var(--tx3)">Belum punya akun? </span>
      <a href="{{ route('register') }}" style="font-size:.79rem;font-weight:700;color:var(--crimson)">Daftar sebagai Siswa →</a>
    </div>

    
  </div>
</div>
@push('scripts')
<script>
function togglePwd(){
  const i=document.getElementById('password'),e=document.getElementById('eyeIco');
  i.type=i.type==='password'?'text':'password';
  e.className=i.type==='text'?'bi bi-eye':'bi bi-eye-slash';
}
</script>
@endpush
@endsection

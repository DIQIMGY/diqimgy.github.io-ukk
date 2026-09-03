@extends('layouts.app')
@section('title','Daftar Anggota — Perpustakaan Sekolah Digital')
@section('content')
<div class="reg-bg">
  <div class="reg-card">
    <div style="text-align:center;margin-bottom:26px">
      <a href="{{ route('landing') }}" style="display:inline-flex;align-items:center;gap:6px;color:var(--tx3);font-size:.77rem;font-weight:600;margin-bottom:18px;transition:color .15s"
         onmouseover="this.style.color='var(--navy)'" onmouseout="this.style.color='var(--tx3)'">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>
      <div>
        <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#fff;margin:0 auto 12px;box-shadow:0 6px 18px rgba(237,27,59,.35)">
          <i class="bi bi-person-plus-fill"></i>
        </div>
        <h5 style="font-weight:900;color:var(--navy);margin:0 0 4px;font-size:1.05rem;letter-spacing:-.02em">Daftar Anggota Baru</h5>
        <p style="font-size:.79rem;color:var(--tx3);margin:0">Isi data diri untuk mendaftar sebagai anggota perpustakaan</p>
      </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger mb-4" style="border-radius:10px">
      <ul style="margin:0;padding-left:16px;font-size:.79rem">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
      @csrf
      <p style="font-size:.63rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #e2e8f0">
        <i class="bi bi-person-fill me-1" style="color:#64748b"></i>Data Diri
      </p>
      <div class="row g-3" style="margin-bottom:18px">
        <div class="col-12">
          <label class="form-label" for="rn">Nama Lengkap <span class="req">*</span></label>
          <input type="text" id="rn" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama sesuai rapor" required>
        </div>
        <div class="col-6">
          <label class="form-label">NIS <span class="req">*</span></label>
          <input type="text" name="nis" class="form-control" value="{{ old('nis') }}" placeholder="Nomor Induk Siswa" required>
        </div>
        <div class="col-6">
          <label class="form-label">Kelas <span class="req">*</span></label>
          <input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}" placeholder="XI-RPL-1" required>
        </div>
        <div class="col-6">
          <label class="form-label">No. Telepon</label>
          <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="08xxxxxxxxx">
        </div>
        <div class="col-6">
          <label class="form-label">Alamat</label>
          <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" placeholder="Domisili">
        </div>
      </div>

      <p style="font-size:.63rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #e2e8f0">
        <i class="bi bi-shield-lock-fill me-1" style="color:#64748b"></i>Data Akun
      </p>
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Email <span class="req">*</span></label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
        </div>
        <div class="col-6">
          <label class="form-label">Password <span class="req">*</span></label>
          <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
        </div>
        <div class="col-6">
          <label class="form-label">Konfirmasi <span class="req">*</span></label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi" required>
        </div>
        <div class="col-12" style="margin-top:4px">
          <button type="submit" class="btn btn-navy w-100" style="justify-content:center;padding:12px !important">
            <i class="bi bi-person-check-fill"></i> Daftar Sekarang
          </button>
        </div>
      </div>
    </form>

    <div style="text-align:center;margin-top:18px;padding-top:16px;border-top:1px solid #e2e8f0">
      <span style="font-size:.79rem;color:#94a3b8">Sudah punya akun? </span>
      <a href="{{ route('login') }}" style="font-size:.79rem;font-weight:700;color:#0f1f3d">Masuk di sini →</a>
    </div>
  </div>
</div>
@endsection

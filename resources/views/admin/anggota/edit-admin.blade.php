@extends('layouts.app')
@section('title','Edit Admin')
@section('page-title','Edit Data Admin')
@section('content')

<style>
.edit-admin-card{
  background:var(--surface);
  border-radius:16px;
  border:1px solid var(--border);
  padding:28px 32px;
  box-shadow:var(--sh-sm);
  max-width:720px;
  margin:0 auto;
}
.section-header{
  font-size:.7rem;
  font-weight:800;
  text-transform:uppercase;
  letter-spacing:.1em;
  color:var(--tx-3);
  margin-bottom:16px;
  padding-bottom:10px;
  border-bottom:2px solid var(--border);
  display:flex;
  align-items:center;
  gap:8px;
}
.foto-preview{
  width:120px;
  height:120px;
  border-radius:50%;
  object-fit:cover;
  border:4px solid var(--border);
  box-shadow:0 4px 12px rgba(0,0,0,.1);
}
.foto-placeholder{
  width:120px;
  height:120px;
  border-radius:50%;
  background:linear-gradient(135deg,var(--navy),var(--navy-dark));
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:2.5rem;
  font-weight:900;
  color:#fff;
  border:4px solid var(--border);
  box-shadow:0 4px 12px rgba(20,40,75,.25);
}
@media(max-width:768px){
  .edit-admin-card{padding:20px 18px}
}
</style>

<div class="edit-admin-card">
  <div style="margin-bottom:28px">
    <h2 style="font-size:1.3rem;font-weight:900;color:var(--navy-800);margin:0 0 8px;display:flex;align-items:center;gap:10px">
      <i class="bi bi-shield-fill-check" style="color:var(--navy)"></i>
      Edit Data Admin
    </h2>
    <p style="font-size:.84rem;color:var(--tx-3);margin:0">
      Perbarui informasi admin <strong>{{ $user->name }}</strong>
    </p>
  </div>

  @if($errors->any())
  <div class="alert alert-danger mb-4">
    <ul style="margin:0;padding-left:16px">
      @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
  </div>
  @endif

  <form method="POST" action="{{ route('admin.admin.update', $user) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Foto Profil --}}
    <div class="section-header">
      <i class="bi bi-image-fill"></i> Foto Profil
    </div>
    <div style="margin-bottom:28px">
      <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap">
        @if($user->foto)
          <img src="{{ Storage::url($user->foto) }}" alt="{{ $user->name }}" class="foto-preview">
        @else
          <div class="foto-placeholder">
            {{ strtoupper(substr($user->name, 0, 1)) }}
          </div>
        @endif
        <div style="flex:1;min-width:240px">
          <label class="form-label">Upload Foto Baru</label>
          <input type="file" name="foto" class="form-control mb-2" accept="image/jpeg,image/jpg,image/png">
          <small style="display:block;color:var(--tx-3);font-size:.78rem;margin-bottom:10px">
            <i class="bi bi-info-circle"></i> Maksimal 2MB (JPG, JPEG, PNG)
          </small>
          @if($user->foto)
          <label style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:var(--tx-2);cursor:pointer">
            <input type="checkbox" name="hapus_foto" value="1" style="width:16px;height:16px;accent-color:var(--crimson)">
            Hapus foto yang ada
          </label>
          @endif
        </div>
      </div>
    </div>

    {{-- Data Admin --}}
    <div class="section-header">
      <i class="bi bi-person-fill"></i> Informasi Admin
    </div>
    <div class="row g-3" style="margin-bottom:28px">
      <div class="col-12">
        <label class="form-label">Nama Lengkap <span class="req">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
      </div>
      <div class="col-12">
        <label class="form-label">Email <span class="req">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
      </div>
    </div>

    {{-- Keamanan --}}
    <div class="section-header">
      <i class="bi bi-shield-lock-fill"></i> Keamanan (Opsional)
    </div>
    <div class="row g-3" style="margin-bottom:28px">
      <div class="col-12">
        <small style="display:block;margin-bottom:12px;color:var(--tx-3);font-size:.78rem">
          <i class="bi bi-info-circle-fill"></i> Kosongkan jika tidak ingin mengubah password
        </small>
      </div>
      <div class="col-md-6">
        <label class="form-label">Password Baru</label>
        <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter">
      </div>
      <div class="col-md-6">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password">
      </div>
    </div>

    {{-- Actions --}}
    <div style="display:flex;gap:10px;justify-content:flex-end;padding-top:20px;border-top:2px solid var(--border)">
      <a href="{{ route('admin.anggota.index', ['tab' => 'admin']) }}" class="btn btn-ghost">
        <i class="bi bi-x-circle"></i> Batal
      </a>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle-fill"></i> Simpan Perubahan
      </button>
    </div>
  </form>
</div>

@endsection

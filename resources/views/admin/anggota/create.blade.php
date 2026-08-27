@extends('layouts.app')
@section('title','Tambah Anggota')
@section('page-title','Tambah Anggota')
@section('content')
<div class="row justify-content-center">
<div class="col-lg-8 col-xl-7">
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px">
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    <span style="font-weight:800;font-size:.95rem;color:var(--navy-800)">Tambah Anggota Baru</span>
  </div>
  <div class="form-card">
    @if($errors->any())
    <div class="alert alert-danger mb-4"><ul style="margin:0;padding-left:16px;font-size:.79rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('admin.anggota.store') }}">
      @csrf
      <div class="form-sec"><i class="bi bi-person"></i> Data Pribadi</div>
      <div class="row g-3 mb-4">
        <div class="col-12"><label class="form-label">Nama Lengkap <span class="req">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="col-md-4 col-6"><label class="form-label">NIS <span class="req">*</span></label>
          <input type="text" name="nis" class="form-control" value="{{ old('nis') }}" required></div>
        <div class="col-md-4 col-6"><label class="form-label">Kelas <span class="req">*</span></label>
          <input type="text" name="kelas" class="form-control" value="{{ old('kelas') }}" placeholder="XI-RPL-1" required></div>
        <div class="col-md-4 col-6"><label class="form-label">Status <span class="req">*</span></label>
          <select name="status" class="form-select">
            <option value="aktif" {{ old('status','aktif')==='aktif'?'selected':'' }}>Aktif</option>
            <option value="nonaktif" {{ old('status')==='nonaktif'?'selected':'' }}>Non-aktif</option>
          </select></div>
        <div class="col-md-6"><label class="form-label">No. Telepon</label>
          <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="08xxx"></div>
        <div class="col-md-6"><label class="form-label">Alamat</label>
          <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}"></div>
      </div>
      <div class="form-sec"><i class="bi bi-shield-lock"></i> Data Akun</div>
      <div class="row g-3">
        <div class="col-12"><label class="form-label">Email <span class="req">*</span></label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required></div>
        <div class="col-md-6"><label class="form-label">Password <span class="req">*</span></label>
          <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required></div>
      </div>
      <div style="margin-top:24px;padding-top:18px;border-top:1px solid var(--border-2);display:flex;gap:10px">
        <button type="submit" class="btn btn-primary"><i class="bi bi-person-check"></i> Simpan Anggota</button>
        <a href="{{ route('admin.anggota.index') }}" class="btn btn-ghost">Batal</a>
      </div>
    </form>
  </div>
</div></div>
@endsection

@extends('layouts.app')
@section('title','Tambah Buku')
@section('page-title','Tambah Buku')
@section('content')
<div class="row justify-content-center">
<div class="col-lg-9 col-xl-8">
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px">
    <a href="{{ route('admin.buku.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    <span style="font-weight:800;font-size:.95rem;color:var(--navy-800)">Tambah Buku Baru</span>
  </div>
  <div class="form-card">
    @if($errors->any())
    <div class="alert alert-danger mb-4"><ul style="margin:0;padding-left:16px;font-size:.79rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('admin.buku.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-sec"><i class="bi bi-card-heading"></i> Identitas Buku</div>
      <div class="row g-3 mb-4">
        <div class="col-md-4 col-6">
          <label class="form-label">Kode Buku <span class="req">*</span></label>
          <input type="text" name="kode_buku" class="form-control" value="{{ old('kode_buku') }}" placeholder="BK001" required>
        </div>
        <div class="col-md-4 col-6">
          <label class="form-label">Kategori <span class="req">*</span></label>
          <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" placeholder="Pemrograman" required>
        </div>
        <div class="col-md-4 col-4">
          <label class="form-label">Stok <span class="req">*</span></label>
          <input type="number" name="stok" class="form-control" value="{{ old('stok',1) }}" min="0" required>
        </div>
        <div class="col-12">
          <label class="form-label">Judul Buku <span class="req">*</span></label>
          <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Judul lengkap buku" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Pengarang <span class="req">*</span></label>
          <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}" required>
        </div>
        <div class="col-md-5">
          <label class="form-label">Penerbit <span class="req">*</span></label>
          <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}" required>
        </div>
        <div class="col-md-2 col-4">
          <label class="form-label">Tahun <span class="req">*</span></label>
          <input type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit',date('Y')) }}" min="1900" max="{{ date('Y') }}" required>
        </div>
      </div>

      <div class="form-sec"><i class="bi bi-image"></i> Cover & Deskripsi</div>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Cover Buku</label>
          <input type="file" name="cover" class="form-control" accept="image/*" onchange="prevCover(this)">
          <div class="form-text">JPG/PNG, maks 2MB. Rasio portrait (2:3) optimal.</div>
          <div class="cover-preview" id="prevBox">
            <img id="prevImg" src="" alt="preview" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
          </div>
        </div>
        <div class="col-md-8">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="6" placeholder="Sinopsis atau deskripsi singkat buku…">{{ old('deskripsi') }}</textarea>
        </div>
      </div>

      <div style="margin-top:24px;padding-top:18px;border-top:1px solid var(--border-2);display:flex;gap:10px">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save2"></i> Simpan Buku</button>
        <a href="{{ route('admin.buku.index') }}" class="btn btn-ghost">Batal</a>
      </div>
    </form>
  </div>
</div></div>
@push('scripts')
<script>
function prevCover(i){if(i.files&&i.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById('prevImg').src=e.target.result;document.getElementById('prevBox').style.display='block';};r.readAsDataURL(i.files[0]);}}
</script>
@endpush
@endsection

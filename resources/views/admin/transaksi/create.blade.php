@extends('layouts.app')
@section('title','Tambah Transaksi')
@section('page-title','Tambah Transaksi')
@section('content')
<div class="row justify-content-center">
<div class="col-lg-7 col-xl-6">
  <div style="display:flex;align-items:center;gap:10px;margin-bottom:18px">
    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
    <span style="font-weight:800;font-size:.95rem;color:var(--navy-800)">Tambah Transaksi Peminjaman</span>
  </div>
  <div class="form-card">
    @if($errors->any())
    <div class="alert alert-danger mb-4"><ul style="margin:0;padding-left:16px;font-size:.79rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('admin.transaksi.store') }}">
      @csrf
      <div class="form-sec"><i class="bi bi-arrow-left-right"></i> Detail Peminjaman</div>
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Anggota <span class="req">*</span></label>
          <select name="anggota_id" class="form-select" required>
            <option value="">— Pilih Anggota —</option>
            @foreach($anggota as $a)
            <option value="{{ $a->id }}" {{ old('anggota_id')==$a->id?'selected':'' }}>
              {{ $a->nis }} — {{ $a->nama }} ({{ $a->kelas }})
            </option>
            @endforeach
          </select>
        </div>
        <div class="col-12">
          <label class="form-label">Buku <span class="req">*</span></label>
          <select name="buku_id" class="form-select" required>
            <option value="">— Pilih Buku —</option>
            @foreach($buku as $b)
            <option value="{{ $b->id }}" {{ old('buku_id')==$b->id?'selected':'' }}>
              {{ $b->kode_buku }} — {{ $b->judul }} (Stok: {{ $b->stok }})
            </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tanggal Pinjam <span class="req">*</span></label>
          <input type="date" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam',date('Y-m-d')) }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Batas Kembali <span class="req">*</span></label>
          <input type="date" name="tanggal_kembali_rencana" class="form-control" value="{{ old('tanggal_kembali_rencana',date('Y-m-d',strtotime('+7 days'))) }}" required>
        </div>
      </div>
      <div style="margin-top:24px;padding-top:18px;border-top:1px solid var(--border-2);display:flex;gap:10px">
        <button type="submit" class="btn btn-primary"><i class="bi bi-save2"></i> Simpan Transaksi</button>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-ghost">Batal</a>
      </div>
    </form>
  </div>
</div></div>
@endsection

@extends('layouts.app')
@section('title','Data Buku')
@section('page-title','Data Buku')
@section('content')
<div class="toolbar">
  <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Tambah Buku
  </a>
  <div class="toolbar-right">
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
      <div class="input-group" style="width:210px">
        <span class="input-group-text"><i class="bi bi-search" style="font-size:.78rem"></i></span>
        <input type="text" name="search" class="form-control" placeholder="Cari buku…" value="{{ request('search') }}">
      </div>
      <select name="kategori" class="form-select" style="width:140px">
        <option value="">Semua Kategori</option>
        @foreach($kategoris as $k)
        <option value="{{ $k }}" {{ request('kategori')==$k?'selected':'' }}>{{ $k }}</option>
        @endforeach
      </select>
      <button class="btn btn-ghost"><i class="bi bi-funnel"></i> Filter</button>
      @if(request()->hasAny(['search','kategori']))
      <a href="{{ route('admin.buku.index') }}" class="btn btn-ghost"><i class="bi bi-x-lg"></i></a>
      @endif
    </form>
  </div>
</div>

@if($buku->isEmpty())
<div class="empty"><span class="empty-ico"><i class="bi bi-journal-x"></i></span>
<h6>Tidak ada buku ditemukan</h6>
<p style="margin-bottom:16px">Coba kata kunci berbeda atau tambahkan buku baru.</p>
<a href="{{ route('admin.buku.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Buku Pertama</a>
</div>
@else
<div class="book-grid">
  @foreach($buku as $i => $b)
  <div class="book-card">
    <div class="book-cover">
      @if($b->cover)
        <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}">
      @else
        <div class="book-ph g{{ $i % 8 }}">
          <span class="p-ico"><i class="bi bi-book-fill"></i></span>
          <span class="p-ttl">{{ $b->judul }}</span>
          <span class="p-ath">{{ $b->pengarang }}</span>
        </div>
      @endif
      <span class="book-stok {{ $b->stok>0?'sb-ada':'sb-habis' }}">
        {{ $b->stok>0 ? $b->stok.' stok' : 'Habis' }}
      </span>
    </div>
    <div class="book-body">
      <div class="book-cat">{{ $b->kategori }}</div>
      <div class="book-title">{{ $b->judul }}</div>
      <div class="book-author"><i class="bi bi-person" style="font-size:.67rem"></i> {{ $b->pengarang }}</div>
      <div class="book-footer">
        <a href="{{ route('admin.buku.show',$b) }}" class="btn btn-xs btn-ico bv" title="Detail"><i class="bi bi-eye"></i></a>
        <a href="{{ route('admin.buku.edit',$b) }}" class="btn btn-xs btn-ico be" title="Edit"><i class="bi bi-pencil"></i></a>
        <form method="POST" action="{{ route('admin.buku.destroy',$b) }}" onsubmit="return confirm('Hapus buku ini?')">
          @csrf @method('DELETE')
          <button class="btn btn-xs btn-ico bd" title="Hapus"><i class="bi bi-trash"></i></button>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>
@if($buku->hasPages())
<div style="display:flex;justify-content:center;margin-top:28px">{{ $buku->links() }}</div>
@endif
@endif
@endsection

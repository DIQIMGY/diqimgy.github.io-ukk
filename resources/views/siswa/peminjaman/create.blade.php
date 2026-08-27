@extends('layouts.app')
@section('title','Pinjam Buku')
@section('page-title','Pinjam Buku')
@section('content')

{{-- Search bar --}}
<div class="cbox" style="padding:14px 18px;margin-bottom:22px">
  <form method="GET">
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
      <div class="input-group" style="flex:1;min-width:200px">
        <span class="input-group-text"><i class="bi bi-search" style="font-size:.82rem;color:var(--blue-500)"></i></span>
        <input type="text" name="search" class="form-control"
               placeholder="Cari judul, pengarang, atau kategori…"
               value="{{ $search }}" autofocus>
      </div>
      <button class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
      @if($search)
      <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-ghost"><i class="bi bi-x-lg"></i> Reset</a>
      @endif
    </div>
  </form>
</div>

@if($search)
<p style="font-size:.82rem;color:var(--tx-3);margin-bottom:18px">
  Hasil pencarian "<strong style="color:var(--tx-1)">{{ $search }}</strong>" — <strong>{{ $buku->total() }}</strong> buku ditemukan
</p>
@endif

@if($buku->isEmpty())
<div class="empty" style="padding:64px 20px">
  <span class="empty-ico"><i class="bi bi-search"></i></span>
  <h6>Tidak ada buku ditemukan</h6>
  <p>Coba kata kunci yang berbeda.</p>
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
        {{ $b->stok>0 ? 'Tersedia' : 'Habis' }}
      </span>
    </div>
    <div class="book-body">
      <div class="book-cat">{{ $b->kategori }}</div>
      <div class="book-title">{{ $b->judul }}</div>
      <div class="book-author"><i class="bi bi-person" style="font-size:.67rem"></i> {{ $b->pengarang }}</div>
      <div class="book-footer">
        <span style="font-size:.71rem;color:var(--tx-3)">
          Stok: <strong style="{{ $b->stok===0?'color:var(--red-500)':'' }}">{{ $b->stok }}</strong>
        </span>
        @if($b->stok > 0)
        <form method="POST" action="{{ route('siswa.peminjaman.store') }}"
              onsubmit="return confirm('Pinjam buku ini?\nBatas pengembalian 7 hari.')">
          @csrf
          <input type="hidden" name="buku_id" value="{{ $b->id }}">
          <button class="btn btn-primary btn-xs"><i class="bi bi-book"></i> Pinjam</button>
        </form>
        @else
        <button class="btn btn-xs" disabled
                style="background:var(--surface-2);color:var(--tx-4);border:1.5px solid var(--border);cursor:not-allowed">
          Habis
        </button>
        @endif
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

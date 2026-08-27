@extends('layouts.app')
@section('title','Detail Buku')
@section('page-title','Detail Buku')
@section('content')
<a href="{{ route('admin.buku.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:18px"><i class="bi bi-arrow-left"></i> Kembali</a>
<div class="row g-4">
  <div class="col-sm-5 col-md-4 col-lg-3">
    <div style="position:sticky;top:76px">
      <div class="cover-frame">
        @if($buku->cover)
          <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}">
        @else
          <div class="book-ph g0">
            <span class="p-ico"><i class="bi bi-book-fill"></i></span>
            <span class="p-ttl">{{ $buku->judul }}</span>
            <span class="p-ath">{{ $buku->pengarang }}</span>
          </div>
        @endif
        <div class="cover-spine"></div>
      </div>
      <div style="text-align:center;margin-top:14px">
        <span class="status-badge {{ $buku->stok>0?'sb-ada':'sb-habis' }}" style="font-size:.76rem;padding:.4em .9em">
          {{ $buku->stok>0 ? '● Stok: '.$buku->stok : '● Stok Habis' }}
        </span>
      </div>
      <div style="display:flex;gap:8px;margin-top:14px">
        <a href="{{ route('admin.buku.edit',$buku) }}" class="btn btn-gold" style="flex:1;justify-content:center">
          <i class="bi bi-pencil"></i> Edit
        </a>
        <form method="POST" action="{{ route('admin.buku.destroy',$buku) }}" onsubmit="return confirm('Hapus?')">
          @csrf @method('DELETE')
          <button class="btn btn-ico btn-xs bd" style="width:40px;height:40px"><i class="bi bi-trash"></i></button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-sm-7 col-md-8 col-lg-9">
    <div class="cbox">
      <div class="cbox-body">
        <span class="status-badge" style="background:#ede9fe;color:#6d28d9;border:1px solid #ddd6fe;margin-bottom:12px;display:inline-flex">{{ $buku->kategori }}</span>
        <h3 style="font-family:'Playfair Display',serif;font-weight:800;color:var(--navy-800);line-height:1.25;margin-bottom:6px;font-size:1.45rem">{{ $buku->judul }}</h3>
        <p style="color:var(--tx-3);font-size:.9rem;margin-bottom:22px">oleh <strong style="color:var(--tx-2)">{{ $buku->pengarang }}</strong></p>

        <div class="info-grid info-grid-4">
          @foreach([
            ['bi-upc','Kode Buku',$buku->kode_buku,true],
            ['bi-building','Penerbit',$buku->penerbit,false],
            ['bi-calendar3','Tahun',$buku->tahun_terbit,false],
            ['bi-tag','Kategori',$buku->kategori,false],
          ] as [$ic,$lbl,$val,$code])
          <div class="info-cell">
            <div class="info-cell-label"><i class="bi {{ $ic }} me-1"></i>{{ $lbl }}</div>
            @if($code)
              <code style="font-size:.83rem;font-weight:700;color:var(--navy-800)">{{ $val }}</code>
            @else
              <div class="info-cell-value">{{ $val }}</div>
            @endif
          </div>
          @endforeach
        </div>

        @if($buku->deskripsi)
        <div style="margin-top:20px;padding-top:18px;border-top:1px solid var(--border-2)">
          <p style="font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.09em;color:var(--tx-4);margin-bottom:8px">Deskripsi</p>
          <p style="font-size:.86rem;line-height:1.75;color:var(--tx-2);margin:0">{{ $buku->deskripsi }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

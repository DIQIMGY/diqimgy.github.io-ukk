@extends('layouts.app')
@section('title','Data Buku')
@section('page-title','Data Buku')
@section('content')

<style>
/* ══════════════════════════════
   BOOKSHELF ADMIN STYLE
══════════════════════════════ */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
  position:relative;
  z-index:1;
}

.page-header h1 { letter-spacing:-.035em; }
.page-header > div:first-child::before {
  content:'KOLEKSI PERPUSTAKAAN';
  display:block;
  color:var(--crimson);
  font-size:.64rem;
  font-weight:900;
  letter-spacing:.16em;
  margin-bottom:7px;
}

.search-toolbar {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: center;
  background:linear-gradient(110deg,#fff 0%,#fff 70%,#fff7f8 100%);
  padding: 16px 20px;
  border-radius: 16px;
  border: 1px solid #f0f0f0;
  margin-bottom: 24px;
  box-shadow:0 8px 24px rgba(20,40,75,.06);
  position:relative;
  overflow:hidden;
}

.search-toolbar::before {
  content:'';
  position:absolute;
  left:0;
  top:0;
  bottom:0;
  width:4px;
  background:linear-gradient(180deg,var(--crimson),#f59e0b);
}

/* ══════════════════════════════
   BOOKSHELF ROWS
══════════════════════════════ */
.shelf-container{
  display:flex;flex-direction:column;gap:10px;
}

.shelf-row{
  position:relative;
  margin-bottom:8px;
}

/* Area buku di atas rak - BACKGROUND KAYU */
.shelf-books{
  display:flex;
  align-items:flex-end;
  justify-content:space-evenly;
  padding:0 20px 0;
  min-height:210px;
  /* Background kayu */
  background:
    linear-gradient(rgba(139,90,43,.3),rgba(74,44,14,.5)),
    url('/image/wood-bg.jpg') center/cover no-repeat;
  background-color:#8b5a2b;
  border-radius:8px 8px 0 0;
}

/* Satu buku */
.shelf-book{
  position:relative;
  flex:0 0 auto;
  cursor:pointer;
  transform-origin:bottom center;
  transition:
    transform .4s cubic-bezier(.34,1.56,.64,1),
    filter .3s ease;
  filter:drop-shadow(2px 4px 10px rgba(0,0,0,.6));
}
.shelf-book:hover{
  transform:translateY(-32px) scale(1.08);
  z-index:50;
  filter:drop-shadow(0 24px 40px rgba(0,0,0,.75));
}

/* Spine shadow kiri */
.shelf-book::before{
  content:'';
  position:absolute;left:0;top:0;bottom:0;width:8px;
  background:linear-gradient(to right,rgba(0,0,0,.5),rgba(0,0,0,.15),transparent);
  z-index:3;pointer-events:none;border-radius:2px 0 0 2px;
}
/* Gloss atas */
.shelf-book::after{
  content:'';position:absolute;top:0;left:0;right:0;height:5px;
  background:linear-gradient(180deg,rgba(255,255,255,.25),transparent);
  z-index:3;pointer-events:none;
}

.shelf-book-img{
  display:block;
  object-fit:cover;object-position:center top;
  border-radius:2px 5px 5px 2px;
}
.shelf-book-ph{
  border-radius:2px 5px 5px 2px;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:7px;padding:12px 10px;text-align:center;
}
.shelf-book-ph i{font-size:1.6rem;color:rgba(255,255,255,.45)}
.shelf-book-ph span{font-size:.52rem;font-weight:700;color:rgba(255,255,255,.75);line-height:1.3}

/* Popup admin - dengan tombol CRUD - KLIK untuk toggle */
.book-popup{
  display:none;
  position:absolute;
  bottom:calc(100% + 18px);
  left:50%;transform:translateX(-50%);
  z-index:300;
  width:200px;
  background:#fff;
  border-radius:10px;
  box-shadow:0 12px 36px rgba(0,0,0,.3),0 4px 12px rgba(0,0,0,.15);
  padding:14px 15px;
  animation:popupIn .25s cubic-bezier(.34,1.56,.64,1);
}
@keyframes popupIn{
  from{opacity:0;transform:translateX(-50%) translateY(12px) scale(.9)}
  to{opacity:1;transform:translateX(-50%) translateY(0) scale(1)}
}
.book-popup::after{
  content:'';position:absolute;bottom:-8px;left:50%;transform:translateX(-50%);
  width:0;height:0;
  border-left:8px solid transparent;border-right:8px solid transparent;
  border-top:8px solid #fff;
}
/* Tampilkan popup saat parent punya class 'active' */
.shelf-book.active .book-popup{display:block}
.popup-cat{
  display:inline-block;
  padding:3px 8px;border-radius:5px;
  font-size:.62rem;font-weight:800;
  background:rgba(237,27,59,.1);color:var(--crimson);
  margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;
}
.popup-title{font-size:.84rem;font-weight:700;color:#1a1a1a;line-height:1.3;margin-bottom:4px}
.popup-author{font-size:.72rem;color:var(--tx-3);margin-bottom:8px}
.popup-stok{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.69rem;font-weight:700;padding:4px 10px;border-radius:99px;margin-bottom:10px;
}
.stok-ada{background:#dcfce7;color:#15803d}
.stok-habis{background:#fee2e2;color:#dc2626}

.popup-actions{
  display:flex;gap:4px;margin-top:10px;
  border-top:1px solid #f0f0f0;padding-top:10px;
}
.popup-btn{
  flex:1;
  display:flex;align-items:center;justify-content:center;gap:4px;
  font-size:.7rem;font-weight:700;
  padding:7px 8px;border-radius:6px;
  text-decoration:none;
  transition:all .15s;
  border:1px solid #e5e7eb;
}
.popup-btn-view{background:#f0f0f0;color:var(--navy);border-color:#e0e0e0}
.popup-btn-view:hover{background:var(--navy);color:#fff;border-color:var(--navy)}
.popup-btn-edit{background:#fff;color:var(--crimson);border-color:#fecdd3}
.popup-btn-edit:hover{background:var(--crimson);color:#fff;border-color:var(--crimson)}
.popup-btn-delete{
  background:#fef2f2;color:#dc2626;border:1px solid #fecaca;
  cursor:pointer;padding:7px 10px;border-radius:6px;
  font-size:.7rem;font-weight:700;width:100%;
  display:flex;align-items:center;justify-content:center;gap:4px;
}
.popup-btn-delete:hover{background:#dc2626;color:#fff;border-color:#dc2626}

/* Papan penyangga - FOTO BG-RAK */
.shelf-plank{
  height:22px;
  position:relative;
  margin-bottom:32px;
  /* Background bg-rak.png */
  background:
    linear-gradient(180deg,
      rgba(74,74,82,.5) 0%,
      rgba(58,58,66,.6) 50%,
      rgba(74,74,82,.7) 100%
    ),
    url('/image/bg-rak.png') center/cover no-repeat;
  background-color:#4a4a52;
  border-radius:0 0 3px 3px;
  box-shadow:
    0 10px 28px rgba(0,0,0,.6),
    0 5px 10px rgba(0,0,0,.4),
    inset 0 1px 0 rgba(255,255,255,.15),
    inset 0 -1px 0 rgba(0,0,0,.3);
}
.shelf-plank::before{
  content:'';position:absolute;top:0;left:3px;right:3px;height:3px;
  background:linear-gradient(90deg,
    rgba(255,255,255,0) 0%,
    rgba(255,255,255,.2) 15%,
    rgba(255,255,255,.15) 50%,
    rgba(255,255,255,.2) 85%,
    rgba(255,255,255,0) 100%
  );
  border-radius:3px 3px 0 0;
}
.shelf-plank::after{
  content:'';
  position:absolute;bottom:-14px;left:5px;right:5px;height:14px;
  background:linear-gradient(180deg,rgba(0,0,0,.35),transparent);
  border-radius:0 0 6px 6px;
  pointer-events:none;
}

/* Gradients */
.g0{background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.g1{background:linear-gradient(150deg,#581c87,#7c3aed)}
.g2{background:linear-gradient(150deg,#064e3b,#059669)}
.g3{background:linear-gradient(150deg,#78350f,#d97706)}
.g4{background:linear-gradient(150deg,#881337,#e11d48)}
.g5{background:linear-gradient(150deg,#0c4a6e,#0284c7)}
.g6{background:linear-gradient(150deg,#1f2937,#4b5563)}
.g7{background:linear-gradient(150deg,#134e4a,#0d9488)}

@media(max-width:1024px){
  .shelf-books{min-height:180px;padding:0 16px 0}
}
@media(max-width:768px){
  .page-header{align-items:flex-start}
  .search-toolbar{padding:14px}
  .shelf-books{min-height:150px;padding:0 12px 0}
  .book-popup{width:170px}
}
@media(max-width:480px){
  .shelf-books{min-height:130px;gap:8px;overflow-x:auto;padding:0 10px 0}
  .book-popup{width:160px}
}
</style>

<script>
// Toggle popup dengan klik
document.addEventListener('DOMContentLoaded', function() {
  const shelfBooks = document.querySelectorAll('.shelf-book');
  
  shelfBooks.forEach(book => {
    book.addEventListener('click', function(e) {
      // Toggle active class
      const wasActive = this.classList.contains('active');
      
      // Tutup semua popup lain
      document.querySelectorAll('.shelf-book.active').forEach(b => {
        b.classList.remove('active');
      });
      
      // Toggle popup ini
      if (!wasActive) {
        this.classList.add('active');
      }
      
      e.stopPropagation();
    });
  });
  
  // Tutup popup saat klik di luar
  document.addEventListener('click', function() {
    document.querySelectorAll('.shelf-book.active').forEach(b => {
      b.classList.remove('active');
    });
  });
});
</script>

{{-- Page Header --}}
<div class="page-header">
  <div>
    <h1 style="font-size:1.6rem;font-weight:900;color:var(--navy-800);margin:0 0 6px">Data Buku</h1>
    <p style="font-size:.88rem;color:var(--tx-3);margin:0">
      <i class="bi bi-collection-fill" style="color:var(--crimson)"></i>
      Kelola koleksi perpustakaan
    </p>
  </div>
  <a href="{{ route('admin.buku.create') }}" style="padding:12px 24px;border-radius:14px;font-size:.88rem;font-weight:700;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));color:#fff;border:none;display:flex;align-items:center;gap:10px;box-shadow:0 6px 20px rgba(237,27,59,.3);text-decoration:none;transition:all .3s">
    <i class="bi bi-plus-circle-fill" style="font-size:1.1rem"></i> Tambah Buku
  </a>
</div>

{{-- Search & Filter Toolbar --}}
<div class="search-toolbar">
  <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;flex:1">
    <div style="flex:1;min-width:250px;position:relative">
      <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-4);font-size:.85rem"></i>
      <input type="text" name="search" placeholder="Cari judul, pengarang, atau ISBN..." value="{{ request('search') }}" style="width:100%;padding:10px 14px 10px 38px;border:1px solid #e0e0e0;border-radius:12px;font-size:.88rem">
    </div>
    
    <select name="kategori" style="padding:10px 14px;border:1px solid #e0e0e0;border-radius:12px;font-size:.88rem;min-width:160px">
      <option value="">Semua Kategori</option>
      @foreach($kategoris as $k)
      <option value="{{ $k }}" {{ request('kategori')==$k?'selected':'' }}>{{ $k }}</option>
      @endforeach
    </select>
    
    <button type="submit" style="padding:10px 20px;border-radius:12px;font-size:.85rem;font-weight:700;background:var(--crimson);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;gap:8px">
      <i class="bi bi-funnel-fill"></i> Filter
    </button>
    
    @if(request()->hasAny(['search','kategori']))
    <a href="{{ route('admin.buku.index') }}" style="padding:10px 16px;border-radius:12px;background:#f5f5f5;border:1px solid #e0e0e0;text-decoration:none;color:var(--tx-2);display:flex;align-items:center;gap:6px;font-size:.85rem">
      <i class="bi bi-x-circle-fill"></i> Reset
    </a>
    @endif
  </form>
</div>

@if($buku->isEmpty())
{{-- Empty State --}}
<div style="background:#fff;border-radius:20px;padding:60px 40px;text-align:center;border:2px dashed #e0e0e0">
  <i class="bi bi-journal-x" style="font-size:4rem;color:#d0d0d0;display:block;margin-bottom:16px"></i>
  <h3 style="font-size:1.2rem;font-weight:800;color:var(--navy-800);margin:0 0 8px">Tidak ada buku ditemukan</h3>
  <p style="font-size:.88rem;color:var(--tx-3);margin:0 0 24px">Coba kata kunci berbeda atau tambahkan buku baru.</p>
  <a href="{{ route('admin.buku.create') }}" style="display:inline-flex;align-items:center;gap:10px;padding:12px 28px;border-radius:14px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));color:#fff;font-weight:700;text-decoration:none;box-shadow:0 6px 20px rgba(237,27,59,.3)">
    <i class="bi bi-plus-circle-fill"></i> Tambah Buku Pertama
  </a>
</div>
@else
{{-- Bookshelf Rows --}}
@php
  $booksPerShelf = 6;
  $shelves = $buku->chunk($booksPerShelf);
  $heights = [175, 188, 162, 182, 168, 178, 192, 158, 185, 170, 165, 180, 155, 175, 188, 172];
  $widths  = [110, 118, 100, 114, 106, 112, 120, 98,  116, 108, 104, 113, 96,  110, 118, 108];
@endphp

<div class="shelf-container">
  @foreach($shelves as $shelfIdx => $shelfBooks)
  <div class="shelf-row">
    <div class="shelf-books">
      @foreach($shelfBooks as $i => $b)
      @php
        $globalIdx = $shelfIdx * $booksPerShelf + $i;
        $bh = $heights[$globalIdx % count($heights)];
        $bw = $widths[$globalIdx % count($widths)];
      @endphp
      <div class="shelf-book">
        
        {{-- Cover --}}
        @if($b->cover)
          <img class="shelf-book-img"
               src="{{ Storage::url($b->cover) }}"
               alt="{{ $b->judul }}"
               loading="lazy"
               style="height:{{ $bh }}px;width:{{ $bw }}px">
        @else
          <div class="shelf-book-ph g{{ $globalIdx % 8 }}"
               style="height:{{ $bh }}px;width:{{ $bw }}px">
            <i class="bi bi-book-fill"></i>
            <span>{{ Str::limit($b->judul, 18) }}</span>
          </div>
        @endif

        {{-- Popup dengan tombol CRUD --}}
        <div class="book-popup">
          <div class="popup-cat">{{ $b->kategori }}</div>
          <div class="popup-title">{{ $b->judul }}</div>
          <div class="popup-author">{{ $b->pengarang }}</div>
          @if($b->stok > 0)
            <span class="popup-stok stok-ada">
              <i class="bi bi-check-circle-fill" style="font-size:.6rem"></i>
              {{ $b->stok }} stok
            </span>
          @else
            <span class="popup-stok stok-habis">
              <i class="bi bi-x-circle-fill" style="font-size:.6rem"></i>
              Habis
            </span>
          @endif
          
          <div class="popup-actions">
            <a href="{{ route('admin.buku.show',$b) }}" class="popup-btn popup-btn-view" title="Detail">
              <i class="bi bi-eye-fill"></i>
            </a>
            <a href="{{ route('admin.buku.edit',$b) }}?page={{ $buku->currentPage() }}" class="popup-btn popup-btn-edit" title="Edit">
              <i class="bi bi-pencil-fill"></i>
            </a>
          </div>
          <form method="POST" action="{{ route('admin.buku.destroy',$b) }}" onsubmit="return confirm('Hapus buku ini?')" style="margin-top:4px">
            @csrf @method('DELETE')
            <input type="hidden" name="page" value="{{ $buku->currentPage() }}">
            <button type="submit" class="popup-btn-delete" title="Hapus">
              <i class="bi bi-trash-fill"></i> Hapus
            </button>
          </form>
        </div>

      </div>
      @endforeach
    </div>
    <div class="shelf-plank"></div>
  </div>
  @endforeach
</div>

{{-- Pagination --}}
@if($buku->hasPages())
<div style="display:flex;justify-content:center;margin-top:32px">
  {{ $buku->links('vendor.pagination.custom-simple') }}
</div>
@endif
@endif

@endsection

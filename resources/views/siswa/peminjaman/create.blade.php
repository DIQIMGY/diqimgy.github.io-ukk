@extends('layouts.app')
@section('title','Pinjam Buku')
@section('page-title','Pinjam Buku')
@section('content')
<style>
/* ══════════════════════════════
   BOOKSHELF SISWA STYLE
══════════════════════════════ */
.catalog-page-modern {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.search-bar-modern {
  background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
  border-radius: 16px;
  padding: 20px 24px;
  margin-bottom: 28px;
  box-shadow: 0 4px 16px rgba(20,40,75,0.06);
  border: 1.5px solid rgba(20,40,75,0.06);
}
.search-form-modern {
  display: flex;
  gap: 12px;
  align-items: center;
  flex-wrap: wrap;
}
.search-input-group {
  flex: 1;
  min-width: 250px;
  position: relative;
  display: flex;
  align-items: center;
  background: white;
  border: 2px solid rgba(20,40,75,0.12);
  border-radius: 12px;
  overflow: hidden;
  transition: all 0.3s ease;
}
.search-input-group:focus-within {
  border-color: #ED1B3B;
  box-shadow: 0 0 0 4px rgba(237,27,59,0.1);
}
.search-icon {
  padding: 0 16px;
  color: #ED1B3B;
  font-size: 1.1rem;
}
.search-input {
  flex: 1;
  border: none;
  padding: 14px 16px 14px 0;
  font-size: 0.95rem;
  color: #14284B;
  background: transparent;
  font-weight: 500;
}
.search-input:focus {
  outline: none;
}
.search-input::placeholder {
  color: #94a3b8;
}
.btn-search-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 24px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.95rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(237,27,59,0.3);
}
.btn-search-modern:hover {
  background: linear-gradient(135deg, #C41630 0%, #A01228 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(237,27,59,0.4);
}
.btn-reset-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 24px;
  background: white;
  border: 2px solid rgba(20,40,75,0.15);
  border-radius: 12px;
  color: #14284B;
  font-weight: 700;
  font-size: 0.95rem;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
}
.btn-reset-modern:hover {
  background: #f8fafc;
  border-color: rgba(20,40,75,0.25);
  color: #14284B;
}
.search-result-info {
  font-size: 0.9rem;
  color: #64748b;
  margin-bottom: 24px;
  font-weight: 600;
}
.search-result-info strong {
  color: #14284B;
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

.shelf-book::before{
  content:'';
  position:absolute;left:0;top:0;bottom:0;width:8px;
  background:linear-gradient(to right,rgba(0,0,0,.5),rgba(0,0,0,.15),transparent);
  z-index:3;pointer-events:none;border-radius:2px 0 0 2px;
}
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

/* Popup siswa - tombol PINJAM */
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

.popup-pinjam-form{margin-top:10px;border-top:1px solid #f0f0f0;padding-top:10px}
.popup-btn-pinjam{
  width:100%;
  display:flex;align-items:center;justify-content:center;gap:5px;
  font-size:.74rem;font-weight:700;
  padding:9px 13px;border-radius:7px;border:none;
  background:linear-gradient(135deg,#ED1B3B,#C41630);
  color:#fff;cursor:pointer;
  transition:all .2s;
}
.popup-btn-pinjam:hover{
  background:linear-gradient(135deg,#C41630,#A01228);
  transform:translateY(-1px);
  box-shadow:0 4px 12px rgba(237,27,59,.4);
}
.popup-btn-disabled{
  width:100%;
  display:flex;align-items:center;justify-content:center;gap:5px;
  font-size:.74rem;font-weight:700;
  padding:9px 13px;border-radius:7px;
  background:#f1f5f9;color:#9ca3af;
  cursor:not-allowed;border:1px solid #e5e7eb;
}

/* Papan penyangga - BG-RAK */
.shelf-plank{
  height:22px;
  position:relative;
  margin-bottom:32px;
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

.g0{background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.g1{background:linear-gradient(150deg,#581c87,#7c3aed)}
.g2{background:linear-gradient(150deg,#064e3b,#059669)}
.g3{background:linear-gradient(150deg,#78350f,#d97706)}
.g4{background:linear-gradient(150deg,#881337,#e11d48)}
.g5{background:linear-gradient(150deg,#0c4a6e,#0284c7)}
.g6{background:linear-gradient(150deg,#1f2937,#4b5563)}
.g7{background:linear-gradient(150deg,#134e4a,#0d9488)}

.catalog-pagination {
  display:flex;
  justify-content:center;
  overflow-x:auto;
  padding:4px 0;
  margin-top:32px;
}

.catalog-pagination .pagination {
  flex-wrap:nowrap;
  gap:5px;
}

.catalog-pagination .page-link {
  min-width:34px !important;
  width:34px;
  height:34px;
  padding:0 !important;
  border-radius:8px !important;
  font-size:.76rem !important;
}

@media(max-width:1024px){
  .shelf-books{min-height:180px;padding:0 16px 0}
}
@media(max-width:768px){
  .search-bar-modern{padding:16px}
  .shelf-books{min-height:150px;padding:0 12px 0}
  .book-popup{width:170px}
}
@media(max-width:576px){
  .catalog-pagination{justify-content:flex-start}
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
      // Jangan toggle jika klik tombol submit
      if (e.target.closest('button')) return;
      
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

<div class="catalog-page-modern">
  <div class="search-bar-modern">
    <form method="GET" class="search-form-modern">
      <div class="search-input-group">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Cari judul, pengarang, atau kategori buku..."
               value="{{ $search }}" autofocus>
      </div>
      <button type="submit" class="btn-search-modern">
        <i class="bi bi-search"></i>
        <span>Cari</span>
      </button>
      @if($search)
      <a href="{{ route('siswa.peminjaman.create') }}" class="btn-reset-modern">
        <i class="bi bi-x-circle"></i>
        <span>Reset</span>
      </a>
      @endif
    </form>
  </div>

  @if($search)
  <p class="search-result-info">
    Hasil pencarian "<strong>{{ $search }}</strong>" — <strong>{{ $buku->total() }}</strong> buku ditemukan
  </p>
  @endif

  @if($buku->isEmpty())
  <div style="text-align: center; padding: 80px 20px;">
    <i class="bi bi-search" style="font-size: 5rem; color: #cbd5e1; margin-bottom: 20px;"></i>
    <h6 style="font-size: 1.2rem; font-weight: 800; color: #14284B; margin-bottom: 10px;">Tidak Ada Buku Ditemukan</h6>
    <p style="color: #64748b; margin: 0;">Coba kata kunci yang berbeda</p>
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

          {{-- Popup dengan tombol PINJAM --}}
          <div class="book-popup">
            <div class="popup-cat">{{ $b->kategori }}</div>
            <div class="popup-title">{{ $b->judul }}</div>
            <div class="popup-author">{{ $b->pengarang }}</div>
            @if($b->stok > 0)
              <span class="popup-stok stok-ada">
                <i class="bi bi-check-circle-fill" style="font-size:.6rem"></i>
                {{ $b->stok }} tersedia
              </span>
            @else
              <span class="popup-stok stok-habis">
                <i class="bi bi-x-circle-fill" style="font-size:.6rem"></i>
                Habis
              </span>
            @endif
            
            <div class="popup-pinjam-form">
              @if($b->stok > 0)
                <form method="POST" action="{{ route('siswa.peminjaman.store') }}"
                      onsubmit="return confirm('Pinjam buku ini?\nBatas pengembalian 7 hari.')">
                  @csrf
                  <input type="hidden" name="buku_id" value="{{ $b->id }}">
                  <button type="submit" class="popup-btn-pinjam">
                    <i class="bi bi-book"></i> Pinjam Sekarang
                  </button>
                </form>
              @else
                <button class="popup-btn-disabled" disabled>
                  <i class="bi bi-clock"></i> Tidak Tersedia
                </button>
              @endif
            </div>
          </div>

        </div>
        @endforeach
      </div>
      <div class="shelf-plank"></div>
    </div>
    @endforeach
  </div>

  @if($buku->hasPages())
  <div class="catalog-pagination" style="padding-top:28px;border-top:2px solid rgba(237,27,59,0.1)">
    {{ $buku->links('vendor.pagination.custom-simple') }}
  </div>
  @endif
  @endif
</div>
@endsection

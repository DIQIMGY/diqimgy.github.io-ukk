<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semua Buku – Perpustakaan Sekolah Digital</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
  --red:#ED1B3B;--red-dk:#C41630;
  --navy:#14284B;--navy-dk:#0B1730;
  --gold:#E9A800;
  --wood:#8b5a2b;--wood-dk:#4a2c0e;
  --white:#fff;
  --tx1:#111827;--tx2:#374151;--tx3:#6B7280;--tx4:#9CA3AF;
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{
  font-family:'Inter',sans-serif;
  background:#f8f9fa;
  color:var(--tx1);
  -webkit-font-smoothing:antialiased;
  min-height:100vh;
}
a{text-decoration:none;color:inherit}
img{display:block}

/* ══════════════════════════════
   MAIN BOOKSHELF
══════════════════════════════ */
.main{
  max-width:1200px;margin:0 auto;
  padding:36px 32px 60px;
}

/* Info bar */
.info-bar{
  background:#fff;
  border-radius:10px;
  padding:16px 24px;
  margin-bottom:32px;
  display:flex;align-items:center;justify-content:space-between;
  box-shadow:0 2px 12px rgba(0,0,0,.08);
  border:1.5px solid #e5e7eb;
}
.info-title{
  font-family:'Playfair Display',serif;
  font-size:1.2rem;font-weight:700;color:var(--navy);
}
.info-title span{color:var(--red)}
.info-count{
  font-size:.8rem;color:var(--tx3);font-weight:600;
  background:#f0f0f0;padding:4px 12px;border-radius:99px;
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

/* Buku-buku berdiri di atas rak */
.shelf-books{
  display:flex;
  align-items:flex-end;
  justify-content:space-evenly;
  padding:0 20px 0;
  min-height:210px;
  /* Background per rak */
  background:
    linear-gradient(rgba(74,74,82,.65),rgba(58,58,66,.75)),
    url('/image/bg-rak.png') center/cover no-repeat;
  background-color:#4a4a52;
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

/* Spine shadow kiri — 3D effect */
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

/* Popup info saat hover */
.book-popup{
  display:none;
  position:absolute;
  bottom:calc(100% + 18px);
  left:50%;transform:translateX(-50%);
  z-index:300;
  width:190px;
  background:#fff;
  border-radius:10px;
  box-shadow:0 12px 36px rgba(0,0,0,.3),0 4px 12px rgba(0,0,0,.15);
  padding:14px 15px;
  pointer-events:none;
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
.shelf-book:hover .book-popup{display:block}
.popup-title{font-size:.84rem;font-weight:700;color:#1a1a1a;line-height:1.3;margin-bottom:4px}
.popup-author{font-size:.72rem;color:var(--tx3);margin-bottom:8px}
.popup-cat{font-size:.68rem;color:var(--tx4);margin-bottom:10px}
.popup-stok{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.69rem;font-weight:700;padding:4px 10px;border-radius:99px;margin-bottom:10px;
}
.stok-ada{background:#dcfce7;color:#15803d}
.stok-habis{background:#fee2e2;color:#dc2626}
.popup-btn{
  display:flex;align-items:center;justify-content:center;gap:5px;
  background:var(--red);color:#fff;font-size:.74rem;font-weight:700;
  padding:8px 13px;border-radius:7px;width:100%;text-decoration:none;
  transition:background .15s;
}
.popup-btn:hover{background:var(--red-dk);color:#fff}
.popup-btn-dis{
  display:flex;align-items:center;justify-content:center;gap:5px;
  background:#f1f5f9;color:#9ca3af;font-size:.74rem;font-weight:600;
  padding:8px 13px;border-radius:7px;width:100%;cursor:not-allowed;
}

/* Papan rak kayu */
.shelf-plank{
  height:22px;
  position:relative;
  margin-bottom:32px;
  /* Foto kayu asli */
  background:
    linear-gradient(180deg,
      rgba(248,244,238,.75) 0%,
      rgba(237,232,223,.5) 18%,
      transparent 50%,
      rgba(200,194,182,.3) 82%,
      rgba(184,178,166,.5) 100%
    ),
    url('/image/wood-bg.jpg') center/cover no-repeat;
  background-color:#8b5a2b;
  border-radius:0 0 3px 3px;
  box-shadow:
    0 10px 28px rgba(0,0,0,.6),
    0 5px 10px rgba(0,0,0,.4),
    0 2px 4px rgba(0,0,0,.3),
    inset 0 1px 0 rgba(255,255,255,.85),
    inset 0 -1px 0 rgba(0,0,0,.15);
}
/* Highlight putih atas papan */
.shelf-plank::before{
  content:'';position:absolute;top:0;left:3px;right:3px;height:3px;
  background:linear-gradient(90deg,
    rgba(255,255,255,.08) 0%,
    rgba(255,255,255,.9) 15%,
    rgba(255,255,255,.75) 50%,
    rgba(255,255,255,.9) 85%,
    rgba(255,255,255,.08) 100%
  );
  border-radius:3px 3px 0 0;
}
/* Shadow bawah papan */
.shelf-plank::after{
  content:'';
  position:absolute;bottom:-14px;left:5px;right:5px;height:14px;
  background:linear-gradient(180deg,rgba(0,0,0,.4),transparent);
  border-radius:0 0 6px 6px;
  pointer-events:none;
}

/* Gradients for placeholder */
.g0{background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.g1{background:linear-gradient(150deg,#581c87,#7c3aed)}
.g2{background:linear-gradient(150deg,#064e3b,#059669)}
.g3{background:linear-gradient(150deg,#78350f,#d97706)}
.g4{background:linear-gradient(150deg,#881337,#e11d48)}
.g5{background:linear-gradient(150deg,#0c4a6e,#0284c7)}
.g6{background:linear-gradient(150deg,#1f2937,#4b5563)}
.g7{background:linear-gradient(150deg,#134e4a,#0d9488)}

/* ══════════════════════════════
   PAGINATION
══════════════════════════════ */
.pagi{
  display:flex;justify-content:center;gap:6px;flex-wrap:wrap;
  margin-top:20px;
}
.pagi a,.pagi span{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:38px;height:38px;padding:0 11px;border-radius:6px;
  font-size:.82rem;font-weight:700;
  background:#fff;
  border:1.5px solid #e5e7eb;
  color:var(--tx2);
  transition:all .2s;
  box-shadow:0 2px 6px rgba(0,0,0,.06);
}
.pagi a:hover{
  background:var(--red);border-color:var(--red);color:#fff;
  transform:translateY(-2px);
  box-shadow:0 4px 14px rgba(237,27,59,.4);
}
.pagi span.active{
  background:var(--red);border-color:var(--red);color:#fff;
  box-shadow:0 4px 14px rgba(237,27,59,.4);
}
.pagi span.disabled{opacity:.4;pointer-events:none}

.empty{
  text-align:center;padding:80px 24px;
  color:var(--tx3);
}
.empty i{font-size:3rem;display:block;margin-bottom:14px;opacity:.3}

.foot{
  text-align:center;padding:32px 24px;
  color:var(--tx4);font-size:.78rem;
  margin-top:40px;
  border-top:1px solid #e5e7eb;
}
.foot-back{
  display:inline-flex;align-items:center;gap:7px;
  font-size:.82rem;font-weight:700;
  color:var(--navy);
  padding:10px 20px;border-radius:8px;
  background:#fff;
  border:1.5px solid #e5e7eb;
  transition:all .2s;
  text-decoration:none;
  margin-bottom:16px;
  box-shadow:0 2px 8px rgba(0,0,0,.08);
}
.foot-back:hover{
  background:var(--red);
  border-color:var(--red);
  color:#fff;
  transform:translateY(-2px);
  box-shadow:0 4px 14px rgba(237,27,59,.3);
}

/* ══════════════════════════════
   RESPONSIVE
══════════════════════════════ */
@media(max-width:1024px){
  .shelf-books{min-height:180px;padding:0 16px 0}
}
@media(max-width:768px){
  .main{padding:28px 20px 50px}
  .info-bar{flex-direction:column;align-items:flex-start;gap:10px}
  .shelf-books{min-height:150px;padding:0 12px 0}
}
@media(max-width:480px){
  .shelf-books{min-height:130px;gap:8px;overflow-x:auto;padding:0 10px 0}
  .book-popup{width:160px}
}
</style>
</head>
<body>

{{-- ══ MAIN ══ --}}
<div class="main">

  {{-- Info bar --}}
  <div class="info-bar">
    <h2 class="info-title">Koleksi <span>Lengkap</span></h2>
    <span class="info-count">
      Kategori {{ $pagination->current_page }} dari {{ $pagination->total }} · 
      {{ array_sum(array_map(fn($b) => $b->count(), $bukuPerKategori)) }} buku
    </span>
  </div>

  {{-- Bookshelf per Kategori (1 kategori per halaman) --}}
  @php
    $heights = [175, 188, 162, 182, 168, 178, 192, 158, 185, 170, 165, 180, 155, 175, 188, 172];
    $widths  = [110, 118, 100, 114, 106, 112, 120, 98,  116, 108, 104, 113, 96,  110, 118, 108];
  @endphp

  @foreach($kategoriPaginated as $katIdx => $kategori)
  @php
    $bukuKategori = $bukuPerKategori[$kategori];
    $booksPerShelf = 6;
    $shelves = $bukuKategori->chunk($booksPerShelf);
  @endphp

  {{-- Kategori Header --}}
  <div style="margin:20px 0 30px;text-align:center">
    <h3 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:800;color:var(--navy);margin-bottom:8px">
      {{ $kategori }}
    </h3>
    <p style="font-size:.9rem;color:var(--tx3);font-weight:600">
      {{ $bukuKategori->count() }} buku tersedia dalam kategori ini
    </p>
  </div>

  <div class="shelf-container">
    @foreach($shelves as $shelfIdx => $shelfBooks)
    <div class="shelf-row">
      <div class="shelf-books">
        @foreach($shelfBooks as $i => $buku)
        @php
          $globalIdx = ($shelfIdx * $booksPerShelf) + $i;
          $bh = $heights[$globalIdx % count($heights)];
          $bw = $widths[$globalIdx % count($widths)];
        @endphp
        <div class="shelf-book">
          
          {{-- Cover buku --}}
          @if($buku->cover)
            @if(Str::startsWith($buku->cover, 'http'))
              <img class="shelf-book-img"
                   src="{{ $buku->cover }}"
                   alt="{{ $buku->judul }}"
                   loading="lazy"
                   style="height:{{ $bh }}px;width:{{ $bw }}px">
            @else
              <img class="shelf-book-img"
                   src="{{ Storage::url($buku->cover) }}"
                   alt="{{ $buku->judul }}"
                   loading="lazy"
                   style="height:{{ $bh }}px;width:{{ $bw }}px">
            @endif
          @else
            <div class="shelf-book-ph g{{ $globalIdx % 8 }}"
                 style="height:{{ $bh }}px;width:{{ $bw }}px">
              <i class="bi bi-book-fill"></i>
              <span>{{ Str::limit($buku->judul, 18) }}</span>
            </div>
          @endif

          {{-- Popup info saat hover --}}
          <div class="book-popup">
            <div class="popup-title">{{ $buku->judul }}</div>
            <div class="popup-author">{{ $buku->pengarang }}</div>
            @if($buku->kategori)
              <div class="popup-cat">{{ $buku->kategori }}</div>
            @endif
            @if($buku->stok > 0)
              <span class="popup-stok stok-ada">
                <i class="bi bi-check-circle-fill" style="font-size:.6rem"></i>
                {{ $buku->stok }} tersedia
              </span>
            @else
              <span class="popup-stok stok-habis">
                <i class="bi bi-x-circle-fill" style="font-size:.6rem"></i>
                Habis
              </span>
            @endif
            @if($buku->stok > 0)
              <a href="{{ route('register') }}" class="popup-btn">
                <i class="bi bi-book" style="font-size:.7rem"></i> Pinjam Sekarang
              </a>
            @else
              <span class="popup-btn-dis">
                <i class="bi bi-clock" style="font-size:.7rem"></i> Tidak Tersedia
              </span>
            @endif
          </div>

        </div>
        @endforeach
      </div>
      
      {{-- Papan rak kayu --}}
      <div class="shelf-plank"></div>
    </div>
    @endforeach
  </div>
  @endforeach

  {{-- Pagination --}}
  @if($pagination->has_pages)
  <div class="pagi" style="margin-top:50px">
    @if($pagination->on_first_page)
      <span class="disabled"><i class="bi bi-chevron-left"></i></span>
    @else
      <a href="?page={{ $pagination->current_page - 1 }}"><i class="bi bi-chevron-left"></i></a>
    @endif

    @for($page = 1; $page <= $pagination->last_page; $page++)
      @if($page == $pagination->current_page)
        <span class="active">{{ $page }}</span>
      @else
        <a href="?page={{ $page }}">{{ $page }}</a>
      @endif
    @endfor

    @if($pagination->has_more_pages)
      <a href="?page={{ $pagination->current_page + 1 }}"><i class="bi bi-chevron-right"></i></a>
    @else
      <span class="disabled"><i class="bi bi-chevron-right"></i></span>
    @endif
  </div>
  @endif

  {{-- Empty state --}}
  @if(empty($bukuPerKategori))
  <div class="empty">
    <i class="bi bi-book"></i>
    <p style="font-weight:600">Belum ada buku tersedia</p>
  </div>
  @endif

</div>

<div class="foot">
  <a href="{{ route('landing') }}" class="foot-back">
    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
  </a>
  <div style="color:var(--tx4)">
    © {{ date('Y') }} Perpustakaan Sekolah Digital · Semua hak dilindungi
  </div>
</div>

</body>
</html>

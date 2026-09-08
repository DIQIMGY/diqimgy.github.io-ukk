<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Koleksi Series – Perpustakaan Sekolah Digital</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
  --red:#ED1B3B;--red-dk:#C41630;
  --navy:#14284B;
  --gold:#E9A800;
  --bg:#F0EEE9;
  --white:#fff;
  --border:#E0E0E0;
  --tx1:#1a1a1a;--tx2:#444;--tx3:#777;--tx4:#aaa;
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--tx1);-webkit-font-smoothing:antialiased}
a{text-decoration:none;color:inherit}
img{display:block}

/* ══════════ HERO RAK KAYU — full top, tanpa navbar terpisah ══════════ */
.hero{
  background:
    linear-gradient(180deg,rgba(15,7,3,.35) 0%,rgba(15,7,3,.1) 50%,rgba(15,7,3,.5) 100%),
    url('/image/wood-bg.jpg') center/cover no-repeat;
  background-color:#3b2010;
  min-height:300px;
  display:flex;flex-direction:column;
  position:relative;
  overflow:hidden;
}

/* Tombol Beranda di atas kiri — di dalam kayu */
.hero-nav{
  position:absolute;top:18px;left:24px;z-index:10;
}
.hero-back{
  display:inline-flex;align-items:center;gap:7px;
  font-size:.8rem;font-weight:700;
  color:rgba(255,255,255,.85);
  background:rgba(0,0,0,.35);
  backdrop-filter:blur(6px);
  border:1px solid rgba(255,255,255,.18);
  padding:7px 16px;border-radius:99px;
  transition:all .2s;
}
.hero-back:hover{background:var(--red);border-color:var(--red);color:#fff}
.hero-back i{font-size:.75rem}

/* Area buku di rak */
.shelf-area{
  flex:1;
  display:flex;align-items:flex-end;justify-content:center;
  padding:52px 32px 0;
}

/* Row buku */
.shelf-row{
  display:flex;
  align-items:flex-end;
  justify-content:center;
  gap:0px; /* buku rapat seperti referensi */
  position:relative;z-index:2;
}

/* Satu buku berdiri — PORTRAIT seperti referensi */
.shelf-book{
  position:relative;
  flex-shrink:0;
  /* Ukuran portrait nyata seperti buku fisik */
  width:82px;
  height:130px;
  border-radius:1px 4px 4px 1px;
  overflow:hidden;
  cursor:pointer;
  transition:transform .3s cubic-bezier(.4,0,.2,1);
  /* Sedikit kemiringan berbeda tiap buku */
}
.shelf-book:hover{
  transform:translateY(-22px) scale(1.05);
  z-index:20;
  box-shadow:6px 12px 28px rgba(0,0,0,.7)!important;
}
/* Spine shadow kiri — efek 3D buku */
.shelf-book::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:9px;
  background:linear-gradient(to right,rgba(0,0,0,.55),rgba(0,0,0,.15),transparent);
  z-index:3;pointer-events:none;
}
/* Gloss atas */
.shelf-book::after{
  content:'';position:absolute;top:0;left:0;right:0;height:5px;
  background:linear-gradient(180deg,rgba(255,255,255,.18),transparent);
  z-index:3;pointer-events:none;
}
.shelf-book img{
  width:100%;height:100%;
  object-fit:cover;object-position:center top;
  display:block;
}
/* Placeholder warna */
.shelf-book-ph{
  width:100%;height:100%;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:5px;padding:8px 6px;text-align:center;
}
.shelf-book-ph i{font-size:1.2rem;color:rgba(255,255,255,.5)}
.shelf-book-ph span{font-size:.48rem;font-weight:700;color:rgba(255,255,255,.7);line-height:1.3}

/* Drop shadow buku */
.shelf-book{
  box-shadow:3px 4px 12px rgba(0,0,0,.5),-1px 0 0 rgba(0,0,0,.2);
}

/* Papan rak kayu */
.shelf-plank{
  width:100%;height:24px;
  background:linear-gradient(180deg,#8b5a2b 0%,#6b3f1a 35%,#4a2c0e 100%);
  box-shadow:0 6px 18px rgba(0,0,0,.6),inset 0 2px 4px rgba(255,255,255,.08);
  position:relative;z-index:3;
  flex-shrink:0;
}
/* Garis highlight atas papan */
.shelf-plank::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent 5%,rgba(255,255,255,.15) 20%,rgba(255,255,255,.08) 50%,rgba(255,255,255,.15) 80%,transparent 95%);
}

/* ══════════ MAIN CONTENT ══════════ */
.main{max-width:1100px;margin:0 auto;padding:40px 24px 80px}

.sec-head{text-align:center;margin-bottom:32px}
.sec-head h2{
  font-family:'Playfair Display',serif;
  font-size:1.55rem;font-weight:700;color:var(--tx1);margin-bottom:8px;
}
.sec-head-line{display:inline-block;width:40px;height:2px;background:var(--red);border-radius:99px}
.sec-head p{font-size:.82rem;color:var(--tx3);margin-top:8px}

/* ══════════ SERIES GRID — 4 kolom ══════════ */
.series-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:20px;margin-bottom:40px;
}
@media(max-width:900px){.series-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:640px){.series-grid{grid-template-columns:repeat(2,1fr);gap:14px}}

/* ══════════ SERIES CARD — STACKED BOOKS ══════════ */
.sc{
  background:transparent;
  display:flex;flex-direction:column;
  text-decoration:none;color:inherit;
  position:relative;
}
.sc:hover .sc-cover-main{transform:translateY(-10px) scale(1.03)}
.sc:hover .sc-body{transform:translateY(-5px)}

/* Area cover bertumpuk */
.sc-cover-stack{
  position:relative;
  height:220px;
  margin-bottom:14px;
  display:flex;align-items:flex-end;justify-content:center;
}

/* Buku utama di depan — BESAR */
.sc-cover-main{
  position:relative;
  width:140px;height:200px;
  border-radius:2px 6px 6px 2px;
  overflow:hidden;
  background:#c8d0de;
  box-shadow:4px 8px 24px rgba(0,0,0,.4);
  z-index:3;
  transition:all .35s cubic-bezier(.4,0,.2,1);
}
.sc-cover-main img{
  width:100%;height:100%;
  object-fit:cover;object-position:center top;
}
/* Spine shadow kiri */
.sc-cover-main::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:10px;
  background:linear-gradient(to right,rgba(0,0,0,.45),rgba(0,0,0,.15),transparent);
  z-index:2;
}
/* Gloss atas */
.sc-cover-main::after{
  content:'';position:absolute;top:0;left:0;right:0;height:6px;
  background:linear-gradient(180deg,rgba(255,255,255,.2),transparent);
  z-index:2;
}
.sc-ph{
  position:absolute;inset:0;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:8px;padding:14px;text-align:center;
}
.sc-ph i{font-size:2.2rem;color:rgba(255,255,255,.45)}
.sc-ph span{font-size:.7rem;font-weight:700;color:rgba(255,255,255,.7);line-height:1.3}

/* Buku-buku kecil di belakang — STACKED */
.sc-stacked{
  position:absolute;
  bottom:0;
  display:flex;
  gap:8px;
  z-index:1;
}
.sc-stacked-book{
  width:80px;height:115px;
  border-radius:2px 4px 4px 2px;
  overflow:hidden;
  background:#dde3ef;
  box-shadow:2px 4px 12px rgba(0,0,0,.35);
  opacity:.75;
  transform:scale(.88);
  transition:all .25s;
}
.sc:hover .sc-stacked-book{opacity:.9;transform:scale(.92)}
.sc-stacked-book img{
  width:100%;height:100%;
  object-fit:cover;object-position:center top;
}
/* Spine kiri kecil */
.sc-stacked-book::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:6px;
  background:linear-gradient(to right,rgba(0,0,0,.4),rgba(0,0,0,.1),transparent);
  z-index:2;
}
.sc-stacked-ph{
  width:100%;height:100%;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:4px;padding:6px;text-align:center;
}
.sc-stacked-ph i{font-size:1rem;color:rgba(255,255,255,.4)}
.sc-stacked-ph span{font-size:.45rem;font-weight:700;color:rgba(255,255,255,.65);line-height:1.2}

/* Badge jumlah buku */
.sc-badge{
  position:absolute;bottom:8px;right:12px;z-index:4;
  background:rgba(20,40,75,.92);
  backdrop-filter:blur(8px);
  color:#fff;
  font-size:.7rem;font-weight:800;padding:4px 10px;border-radius:99px;
  display:flex;align-items:center;gap:5px;
  box-shadow:0 3px 10px rgba(0,0,0,.35);
  border:1px solid rgba(255,255,255,.15);
}
.sc-badge i{color:var(--gold);font-size:.65rem}

.sc-new{
  position:absolute;top:8px;right:12px;z-index:4;
  background:var(--red);color:#fff;
  font-size:.58rem;font-weight:800;letter-spacing:.05em;
  padding:4px 8px;border-radius:4px;text-transform:uppercase;
  box-shadow:0 2px 8px rgba(237,27,59,.4);
}

/* Body info */
.sc-body{
  padding:0 8px 12px;
  text-align:center;
  transition:transform .25s;
}
.sc-name{
  font-size:.92rem;font-weight:800;color:var(--tx1);
  line-height:1.3;margin-bottom:4px;
  overflow:hidden;display:-webkit-box;
  -webkit-line-clamp:2;-webkit-box-orient:vertical;
}
.sc-author{
  font-size:.74rem;color:var(--tx3);
  display:flex;align-items:center;justify-content:center;gap:5px;
}
.sc-author i{font-size:.68rem;color:var(--gold)}

/* Gradients */
.g0{background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.g1{background:linear-gradient(150deg,#581c87,#7c3aed)}
.g2{background:linear-gradient(150deg,#064e3b,#059669)}
.g3{background:linear-gradient(150deg,#78350f,#d97706)}
.g4{background:linear-gradient(150deg,#881337,#e11d48)}
.g5{background:linear-gradient(150deg,#0c4a6e,#0284c7)}
.g6{background:linear-gradient(150deg,#1f2937,#4b5563)}
.g7{background:linear-gradient(150deg,#134e4a,#0d9488)}

/* ══════════ PAGINATION ══════════ */
.pagi{display:flex;justify-content:center;gap:5px;flex-wrap:wrap;margin-top:8px}
.pagi a,.pagi span{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:36px;height:36px;padding:0 10px;border-radius:5px;
  font-size:.8rem;font-weight:600;
  background:#fff;border:1.5px solid var(--border);color:var(--tx2);transition:all .18s;
}
.pagi a:hover{background:var(--red);border-color:var(--red);color:#fff}
.pagi span.active{background:var(--red);border-color:var(--red);color:#fff;pointer-events:none}
.pagi span.disabled{opacity:.3;pointer-events:none}

.empty{grid-column:1/-1;text-align:center;padding:60px 24px;color:var(--tx3)}
.empty i{font-size:2.5rem;display:block;margin-bottom:12px;opacity:.25}
.foot{text-align:center;padding:24px;border-top:1px solid var(--border);color:var(--tx4);font-size:.76rem}

@media(max-width:600px){
  .hero{min-height:220px}
  .shelf-book{width:58px;height:94px}
  .main{padding:28px 16px 60px}
}
</style>
</head>
<body>

{{-- ══════════ HERO RAK KAYU — tanpa navbar terpisah ══════════ --}}
<div class="hero">

  {{-- Tombol Beranda di dalam kayu --}}
  <div class="hero-nav">
    <a href="{{ route('landing') }}" class="hero-back">
      <i class="bi bi-arrow-left"></i> Beranda
    </a>
  </div>

  {{-- Buku-buku berdiri di rak --}}
  <div class="shelf-area">
    <div class="shelf-row">
      @php
        $heroBooks = $semuaSeries->take(9);
        /* Tinggi bervariasi agar realistis seperti referensi */
        $heights = [126, 148, 138, 158, 142, 136, 152, 130, 144];
        $widths  = [76,  88,  80,  92,  84,  78,  86,  74,  82 ];
      @endphp
      @foreach($heroBooks as $hi => $hs)
      @php $hc = $hs->buku->first(); @endphp
      <a href="{{ route('series.show', $hs->slug) }}"
         class="shelf-book"
         style="width:{{ $widths[$hi % 9] }}px;height:{{ $heights[$hi % 9] }}px"
         title="{{ $hs->nama_series }}">
        @if($hc && $hc->cover)
          @if(Str::startsWith($hc->cover, 'http'))
            <img src="{{ $hc->cover }}" alt="{{ $hs->nama_series }}" loading="eager">
          @else
            <img src="{{ Storage::url($hc->cover) }}" alt="{{ $hs->nama_series }}" loading="eager">
          @endif
        @else
          <div class="shelf-book-ph g{{ $hi % 8 }}" style="height:100%">
            <i class="bi bi-book-fill"></i>
            <span>{{ Str::limit($hs->nama_series,12) }}</span>
          </div>
        @endif
      </a>
      @endforeach
    </div>
  </div>

  {{-- Papan rak kayu --}}
  <div class="shelf-plank"></div>
</div>

{{-- ══════════ MAIN ══════════ --}}
<div class="main">

  {{-- Section title --}}
  <div class="sec-head">
    <h2>Semua Koleksi Series</h2>
    <span class="sec-head-line"></span>
    <p style="font-size:.82rem;color:var(--tx3);margin-top:8px">
      {{ $semuaSeries->total() }} series tersedia · {{ $semuaSeries->sum('buku_count') }} total buku
    </p>
  </div>

  {{-- Grid series --}}
  <div class="series-grid">
    @forelse($semuaSeries as $i => $ser)
    @php
      $coverBuku   = $ser->buku->first();
      $stackedBooks = $ser->buku->skip(1)->take(3); // 3 buku di belakang
      $isNew       = $ser->created_at && $ser->created_at->diffInDays(now()) < 30;
    @endphp

    <a href="{{ route('series.show', $ser->slug) }}" class="sc">

      {{-- Cover stack --}}
      <div class="sc-cover-stack">
        
        {{-- Buku utama di depan --}}
        <div class="sc-cover-main">
          @if($coverBuku && $coverBuku->cover)
            @if(Str::startsWith($coverBuku->cover, 'http'))
              <img src="{{ $coverBuku->cover }}" alt="{{ $ser->nama_series }}" loading="lazy">
            @else
              <img src="{{ Storage::url($coverBuku->cover) }}" alt="{{ $ser->nama_series }}" loading="lazy">
            @endif
          @else
            <div class="sc-ph g{{ $i % 8 }}">
              <i class="bi bi-book-fill"></i>
              <span>{{ $ser->nama_series }}</span>
            </div>
          @endif
        </div>

        {{-- Buku-buku di belakang --}}
        @if($stackedBooks->count() > 0)
        <div class="sc-stacked">
          @foreach($stackedBooks as $si => $sb)
          <div class="sc-stacked-book">
            @if($sb->cover)
              @if(Str::startsWith($sb->cover, 'http'))
                <img src="{{ $sb->cover }}" alt="{{ $sb->judul }}" loading="lazy">
              @else
                <img src="{{ Storage::url($sb->cover) }}" alt="{{ $sb->judul }}" loading="lazy">
              @endif
            @else
              <div class="sc-stacked-ph g{{ ($i + $si + 1) % 8 }}">
                <i class="bi bi-book-fill"></i>
                <span>{{ Str::limit($sb->judul, 10) }}</span>
              </div>
            @endif
          </div>
          @endforeach
        </div>
        @endif

        {{-- Badge jumlah buku --}}
        <div class="sc-badge">
          <i class="bi bi-collection-fill"></i> {{ $ser->buku_count }}
        </div>

        @if($isNew)
        <div class="sc-new">Baru</div>
        @endif
      </div>

      {{-- Body info --}}
      <div class="sc-body">
        <div class="sc-name">{{ $ser->nama_series }}</div>
        <div class="sc-author">
          <i class="bi bi-person-fill"></i>{{ $ser->penulis }}
        </div>
      </div>

    </a>
    @empty
    <div class="empty">
      <i class="bi bi-collection"></i>
      <p style="font-weight:600">Belum ada koleksi series</p>
    </div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if($semuaSeries->hasPages())
  <div class="pagi">
    @if($semuaSeries->onFirstPage())
      <span class="disabled"><i class="bi bi-chevron-left"></i></span>
    @else
      <a href="{{ $semuaSeries->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
    @endif

    @foreach($semuaSeries->getUrlRange(1, $semuaSeries->lastPage()) as $page => $url)
      @if($page == $semuaSeries->currentPage())
        <span class="active">{{ $page }}</span>
      @else
        <a href="{{ $url }}">{{ $page }}</a>
      @endif
    @endforeach

    @if($semuaSeries->hasMorePages())
      <a href="{{ $semuaSeries->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
    @else
      <span class="disabled"><i class="bi bi-chevron-right"></i></span>
    @endif
  </div>
  @endif

</div>

<div class="foot">© {{ date('Y') }} Perpustakaan Sekolah Digital</div>

</body>
</html>

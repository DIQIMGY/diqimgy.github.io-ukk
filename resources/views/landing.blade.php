<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perpustakaan Sekolah Digital</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
/* ── ROOT ── */
:root{
  --navy:#0f1f3d;
  --navy2:#1a3461;
  --navy3:#162845;
  --blue:#2563eb;
  --gold:#f59e0b;
  --gold2:#d97706;
  --red:#e11d48;
  --green:#16a34a;
  --bg:#f8f9fc;
  --white:#fff;
  --border:#e8ecf3;
  --tx1:#0f172a;
  --tx2:#334155;
  --tx3:#64748b;
  --tx4:#94a3b8;
  --r:12px;
  --r2:8px;
  --sh:0 2px 8px rgba(0,0,0,.07),0 8px 24px rgba(0,0,0,.06);
  --sh2:0 8px 32px rgba(0,0,0,.12);
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--tx1);-webkit-font-smoothing:antialiased}
a{text-decoration:none;color:inherit}
::-webkit-scrollbar{width:5px}
::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:99px}

/* ── NAVBAR ── */
.nav{
  position:sticky;top:0;z-index:1000;
  background:rgba(255,255,255,.92);
  backdrop-filter:blur(14px);
  border-bottom:1px solid var(--border);
  padding:0 0;
}
.nav-inner{
  max-width:1200px;margin:0 auto;
  padding:0 24px;height:62px;
  display:flex;align-items:center;
  justify-content:space-between;gap:20px;
}
.nav-brand{display:flex;align-items:center;gap:10px}
.nav-brand-ico{
  width:38px;height:38px;border-radius:10px;
  background:linear-gradient(135deg,var(--gold),var(--gold2));
  display:flex;align-items:center;justify-content:center;
  font-size:.95rem;color:#fff;flex-shrink:0;
  box-shadow:0 3px 10px rgba(245,158,11,.35);
}
.nav-brand-name{font-weight:800;font-size:.9rem;color:var(--navy);line-height:1.2}
.nav-brand-sub{font-size:.65rem;color:var(--tx3);font-weight:500}
.nav-links{display:flex;align-items:center;gap:2px}
.nav-link{
  font-size:.83rem;font-weight:600;color:var(--tx2);
  padding:6px 14px;border-radius:var(--r2);
  transition:background .15s,color .15s;
}
.nav-link:hover{background:#f1f5f9;color:var(--navy)}
.nav-link.active{color:var(--navy);background:#eff6ff}
.nav-actions{display:flex;align-items:center;gap:8px}
.btn-outline{
  border:1.5px solid var(--border);background:transparent;
  color:var(--tx2);padding:7px 16px;border-radius:var(--r2);
  font-size:.82rem;font-weight:600;cursor:pointer;
  transition:all .18s;
}
.btn-outline:hover{border-color:var(--navy);color:var(--navy)}
.btn-solid{
  background:var(--navy);color:#fff;
  padding:7px 18px;border-radius:var(--r2);
  font-size:.82rem;font-weight:700;cursor:pointer;
  border:none;transition:all .18s;
  box-shadow:0 2px 8px rgba(15,31,61,.2);
}
.btn-solid:hover{background:var(--navy2);transform:translateY(-1px);box-shadow:0 4px 14px rgba(15,31,61,.28)}

/* ── HERO ── */
.hero{
  background:linear-gradient(135deg,var(--navy) 0%,var(--navy2) 50%,#1e4080 100%);
  /* Kalau punya gambar: tambahkan file hero-bg.jpg di public/image/ dan uncomment baris berikut */
  /* background-image:url('/image/hero-bg.jpg');background-size:cover;background-position:center; */
  position:relative;overflow:hidden;
  padding:70px 0 60px;
}
.hero::before{
  content:'';position:absolute;
  width:600px;height:600px;border-radius:50%;
  background:radial-gradient(circle,rgba(245,158,11,.12) 0%,transparent 70%);
  top:-200px;right:-100px;pointer-events:none;
}
.hero::after{
  content:'';position:absolute;
  width:400px;height:400px;border-radius:50%;
  background:radial-gradient(circle,rgba(37,99,235,.1) 0%,transparent 70%);
  bottom:-100px;left:-80px;pointer-events:none;
}
/* Decorative dots grid */
.hero-dots{
  position:absolute;right:0;top:0;bottom:0;width:420px;
  opacity:.04;
  background-image:radial-gradient(circle,#fff 1px,transparent 1px);
  background-size:24px 24px;
  pointer-events:none;
}
.hero-inner{max-width:1200px;margin:0 auto;padding:0 24px;position:relative;z-index:1}
.hero-content{max-width:520px}
.hero-tag{
  display:inline-flex;align-items:center;gap:7px;
  background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.3);
  color:#fbbf24;font-size:.74rem;font-weight:700;
  padding:5px 12px;border-radius:99px;margin-bottom:20px;
}
.hero h1{
  font-family:'Playfair Display',serif;
  font-size:clamp(2rem,4vw,3rem);
  font-weight:800;color:#fff;
  line-height:1.15;margin-bottom:16px;
  letter-spacing:-.02em;
}
.hero h1 span{color:var(--gold);font-style:italic}
.hero-sub{
  font-size:.95rem;color:rgba(255,255,255,.6);
  line-height:1.7;margin-bottom:30px;max-width:420px;
}
.hero-btns{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.btn-hero-primary{
  background:linear-gradient(135deg,var(--gold),var(--gold2));
  color:#fff;padding:12px 26px;border-radius:var(--r2);
  font-size:.9rem;font-weight:700;border:none;cursor:pointer;
  box-shadow:0 6px 20px rgba(245,158,11,.4);
  transition:all .2s;display:inline-flex;align-items:center;gap:8px;
}
.btn-hero-primary:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(245,158,11,.5);color:#fff}
.btn-hero-secondary{
  background:rgba(255,255,255,.1);
  border:1.5px solid rgba(255,255,255,.25);
  color:#fff;padding:12px 24px;border-radius:var(--r2);
  font-size:.9rem;font-weight:600;cursor:pointer;
  transition:all .2s;display:inline-flex;align-items:center;gap:8px;
}
.btn-hero-secondary:hover{background:rgba(255,255,255,.18);border-color:rgba(255,255,255,.4);color:#fff}
.hero-stats{
  display:flex;align-items:center;gap:28px;
  margin-top:36px;padding-top:28px;
  border-top:1px solid rgba(255,255,255,.1);
  flex-wrap:wrap;gap:20px;
}
.hero-stat-num{font-size:1.6rem;font-weight:900;color:#fff;line-height:1}
.hero-stat-lbl{font-size:.72rem;color:rgba(255,255,255,.45);font-weight:500;margin-top:3px}

/* Hero books visual */
.hero-books{
  position:absolute;right:80px;top:50%;transform:translateY(-50%);
  display:flex;align-items:flex-end;gap:-10px;
}
.hero-book-card{
  width:120px;border-radius:10px;overflow:hidden;
  box-shadow:0 16px 48px rgba(0,0,0,.45);
  transition:transform .3s;
}
.hero-book-card:nth-child(1){transform:rotate(-8deg) translateY(10px)}
.hero-book-card:nth-child(2){transform:rotate(-2deg) translateY(-5px);z-index:2;width:130px}
.hero-book-card:nth-child(3){transform:rotate(6deg) translateY(15px)}
.hero-book-inner{
  padding-top:145%;position:relative;
  background:linear-gradient(150deg,#1a1a2e,#16213e);
}
.hero-book-inner img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.hero-book-inner .book-ph-hero{
  position:absolute;inset:0;display:flex;flex-direction:column;
  align-items:center;justify-content:center;padding:12px;text-align:center;gap:6px;
}
.hero-book-inner::before{
  content:'';position:absolute;left:0;top:0;bottom:0;
  width:6px;background:linear-gradient(to right,rgba(0,0,0,.35),transparent);z-index:2;
}

/* ── SECTION BASE ── */
.section{padding:56px 0}
.section-inner{max-width:1200px;margin:0 auto;padding:0 24px}
.section-header{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:28px;flex-wrap:wrap;gap:12px;
}
.section-title{
  font-family:'Playfair Display',serif;
  font-size:1.45rem;font-weight:800;color:var(--navy);
}
.section-title span{color:var(--red)}
.section-sub{font-size:.82rem;color:var(--tx3);margin-top:4px}
.see-all{
  display:flex;align-items:center;gap:6px;
  font-size:.82rem;font-weight:700;color:var(--navy);
  border:1.5px solid var(--border);padding:7px 16px;
  border-radius:var(--r2);transition:all .18s;
  background:var(--white);
}
.see-all:hover{background:var(--navy);color:#fff;border-color:var(--navy)}

/* ── BOOK CARD (grid) ── */
.book-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(155px,1fr));
  gap:18px;
}
.bk{
  background:var(--white);border-radius:var(--r);
  border:1px solid var(--border);box-shadow:var(--sh);
  overflow:hidden;display:flex;flex-direction:column;
  transition:transform .22s,box-shadow .22s;cursor:pointer;
}
.bk:hover{transform:translateY(-5px);box-shadow:var(--sh2)}
.bk-cover{
  position:relative;padding-top:150%;
  overflow:hidden;background:#dde4ef;
}
.bk-cover img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .3s}
.bk:hover .bk-cover img{transform:scale(1.05)}
.bk-cover::before{content:'';position:absolute;left:0;top:0;bottom:0;width:7px;background:linear-gradient(to right,rgba(0,0,0,.25),transparent);z-index:3;pointer-events:none}
.bk-cover::after{content:'';position:absolute;bottom:0;left:0;right:0;height:56px;background:linear-gradient(transparent,rgba(0,0,0,.25));z-index:2;pointer-events:none}
.bk-ph{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:12px;text-align:center;gap:6px}
.bk-ph .ph-i{font-size:2rem;opacity:.65}
.bk-ph .ph-t{font-size:.68rem;font-weight:700;color:rgba(255,255,255,.9);line-height:1.3;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical}
.bk-ph .ph-a{font-size:.6rem;color:rgba(255,255,255,.55)}
/* Gradient covers */
.g0{background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.g1{background:linear-gradient(150deg,#581c87,#7c3aed)}
.g2{background:linear-gradient(150deg,#064e3b,#059669)}
.g3{background:linear-gradient(150deg,#78350f,#d97706)}
.g4{background:linear-gradient(150deg,#881337,#e11d48)}
.g5{background:linear-gradient(150deg,#0c4a6e,#0284c7)}
.g6{background:linear-gradient(150deg,#1f2937,#4b5563)}
.g7{background:linear-gradient(150deg,#134e4a,#0d9488)}
/* Stok badge */
.bk-stok{
  position:absolute;top:7px;right:7px;z-index:4;
  font-size:.61rem;font-weight:700;padding:2px 8px;border-radius:6px;
  backdrop-filter:blur(8px);
}
.stok-ada{background:rgba(22,163,74,.85);color:#fff}
.stok-habis{background:rgba(220,38,38,.85);color:#fff}
/* Fire badge */
.bk-fire{
  position:absolute;top:7px;left:12px;z-index:4;
  font-size:.65rem;font-weight:800;color:var(--gold);
  text-shadow:0 1px 4px rgba(0,0,0,.5);
}
.bk-body{padding:11px 12px 12px;flex:1;display:flex;flex-direction:column}
.bk-cat{font-size:.59rem;font-weight:800;text-transform:uppercase;letter-spacing:.07em;color:var(--blue);margin-bottom:4px}
.bk-title{font-size:.83rem;font-weight:700;color:var(--tx1);line-height:1.35;margin-bottom:3px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
.bk-author{font-size:.72rem;color:var(--tx3);margin-bottom:8px}
.bk-footer{margin-top:auto;display:flex;align-items:center;justify-content:space-between;gap:4px}
.bk-pinjam{
  font-size:.68rem;font-weight:700;color:var(--tx3);
  display:flex;align-items:center;gap:3px;
}
.btn-pinjam{
  background:linear-gradient(135deg,var(--navy),var(--navy2));
  color:#fff;border:none;padding:5px 11px;
  border-radius:var(--r2);font-size:.73rem;font-weight:700;
  cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:4px;
}
.btn-pinjam:hover{background:var(--blue);transform:translateY(-1px);color:#fff}
.btn-pinjam-disabled{
  background:#f1f5f9;color:var(--tx4);border:none;
  padding:5px 11px;border-radius:var(--r2);
  font-size:.73rem;font-weight:600;cursor:not-allowed;
}

/* ── BANNER (promo) ── */
.promo-banner{
  background:linear-gradient(135deg,var(--navy) 0%,#1e4080 60%,#2d5a9e 100%);
  border-radius:20px;padding:36px 40px;
  display:flex;align-items:center;justify-content:space-between;
  position:relative;overflow:hidden;margin:0 0 18px;
  flex-wrap:wrap;gap:20px;
}
.promo-banner::before{
  content:'';position:absolute;width:300px;height:300px;border-radius:50%;
  background:rgba(245,158,11,.1);right:-80px;top:-80px;pointer-events:none;
}
.promo-banner::after{
  content:'';position:absolute;width:200px;height:200px;border-radius:50%;
  background:rgba(255,255,255,.03);left:200px;bottom:-60px;pointer-events:none;
}
.promo-text{position:relative;z-index:1}
.promo-text p{color:rgba(255,255,255,.55);font-size:.8rem;margin-bottom:8px}
.promo-text h3{font-family:'Playfair Display',serif;font-size:1.7rem;font-weight:800;color:#fff;margin-bottom:4px}
.promo-text span{color:var(--gold)}
.promo-btn{
  background:linear-gradient(135deg,var(--gold),var(--gold2));
  color:#fff;padding:12px 26px;border-radius:var(--r2);
  font-size:.88rem;font-weight:700;border:none;cursor:pointer;
  box-shadow:0 4px 16px rgba(245,158,11,.4);
  transition:all .2s;position:relative;z-index:1;
  display:inline-flex;align-items:center;gap:8px;
}
.promo-btn:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(245,158,11,.5);color:#fff}
.promo-books{position:relative;z-index:1;display:flex;gap:-12px;align-items:flex-end}
.promo-book{
  width:70px;height:105px;border-radius:7px;overflow:hidden;
  box-shadow:0 8px 24px rgba(0,0,0,.35);
  border:1px solid rgba(255,255,255,.1);
}
.promo-book img{width:100%;height:100%;object-fit:cover}
.promo-book:nth-child(1){transform:rotate(-6deg) translateY(8px);margin-right:-8px}
.promo-book:nth-child(2){transform:rotate(-1deg);z-index:2}
.promo-book:nth-child(3){transform:rotate(5deg) translateY(8px);margin-left:-8px}

/* ── CATEGORIES ── */
.cat-grid{display:flex;gap:10px;flex-wrap:wrap}
.cat-chip{
  display:flex;align-items:center;gap:8px;
  padding:9px 18px;border-radius:99px;
  font-size:.82rem;font-weight:700;
  border:1.5px solid var(--border);
  background:var(--white);color:var(--tx2);
  cursor:pointer;transition:all .18s;
}
.cat-chip:hover,.cat-chip.active{background:var(--navy);color:#fff;border-color:var(--navy);box-shadow:0 4px 12px rgba(15,31,61,.2)}
.cat-chip i{font-size:.9rem}

/* ── STATS BAR ── */
.stats-bar{
  background:var(--navy);
  padding:36px 0;
}
.stats-bar-inner{
  max-width:1200px;margin:0 auto;padding:0 24px;
  display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
  gap:24px;
}
.stat-item{text-align:center}
.stat-item-num{font-size:2rem;font-weight:900;color:#fff;letter-spacing:-.04em;line-height:1}
.stat-item-num span{color:var(--gold)}
.stat-item-lbl{font-size:.78rem;color:rgba(255,255,255,.45);font-weight:500;margin-top:6px}

/* ── FOOTER ── */
.footer{background:var(--navy);border-top:1px solid rgba(255,255,255,.06);padding:48px 0 28px}
.footer-inner{max-width:1200px;margin:0 auto;padding:0 24px}
.footer-brand{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.footer-brand-ico{width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,var(--gold),var(--gold2));display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#fff}
.footer-brand-name{font-weight:800;font-size:.9rem;color:#fff}
.footer-desc{font-size:.82rem;color:rgba(255,255,255,.4);line-height:1.65;max-width:260px}
.footer-heading{font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.35);margin-bottom:16px}
.footer-link{display:block;font-size:.83rem;color:rgba(255,255,255,.55);margin-bottom:10px;transition:color .15s}
.footer-link:hover{color:#fff}
.footer-bottom{border-top:1px solid rgba(255,255,255,.07);margin-top:36px;padding-top:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
.footer-copy{font-size:.78rem;color:rgba(255,255,255,.3)}

/* ── RESPONSIVE ── */
@media(max-width:991px){.hero-books{display:none}}
@media(max-width:767px){
  .hero{padding:50px 0 44px}
  .hero h1{font-size:1.75rem}
  .section{padding:40px 0}
  .book-grid{grid-template-columns:repeat(auto-fill,minmax(138px,1fr));gap:12px}
  .promo-banner{padding:26px 22px}
  .promo-text h3{font-size:1.3rem}
  .stats-bar-inner{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:575px){
  .book-grid{grid-template-columns:repeat(2,1fr);gap:10px}
  .nav-links{display:none}
  .hero-stats{gap:16px}
  .hero-stat-num{font-size:1.3rem}
}
</style>
</head>
<body>

{{-- ══ NAVBAR ══════════════════════════════════════════════ --}}
<header class="nav">
  <div class="nav-inner">
    <div class="nav-brand">
      <div class="nav-brand-ico"><i class="bi bi-book-half"></i></div>
      <div>
        <div class="nav-brand-name">Perpustakaan Sekolah Digital</div>
        <div class="nav-brand-sub">Library Management System</div>
      </div>
    </div>

    <nav class="nav-links">
      <a href="{{ route('landing') }}" class="nav-link active">Beranda</a>
      <a href="#koleksi" class="nav-link">Koleksi Buku</a>
      <a href="#populer" class="nav-link">Terpopuler</a>
      <a href="#terbaru" class="nav-link">Terbaru</a>
    </nav>

    <div class="nav-actions">
      @auth
        @if(auth()->user()->isAdmin())
          <a href="{{ route('admin.dashboard') }}" class="btn-solid">Dashboard <i class="bi bi-arrow-right ms-1" style="font-size:.75rem"></i></a>
        @else
          <a href="{{ route('siswa.dashboard') }}" class="btn-solid">Dashboard <i class="bi bi-arrow-right ms-1" style="font-size:.75rem"></i></a>
        @endif
      @else
        <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
        <a href="{{ route('register') }}" class="btn-solid">Daftar Gratis</a>
      @endauth
    </div>
  </div>
</header>

{{-- ══ HERO ════════════════════════════════════════════════ --}}
<section class="hero">
  <div class="hero-dots"></div>
  <div class="hero-inner">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content">
          <div class="hero-tag">
            <i class="bi bi-stars"></i> Perpustakaan Digital Sekolah
          </div>
          <h1>
            Jelajahi Koleksi<br>
            Buku <span>Terbaik</span><br>
            Perpustakaan
          </h1>
          <p class="hero-sub">
            Pinjam buku favoritmu kapan saja, pantau status pengembalian,
            dan temukan koleksi buku menarik dari perpustakaan sekolah kami.
          </p>
          <div class="hero-btns">
            <a href="{{ route('register') }}" class="btn-hero-primary">
              <i class="bi bi-person-plus-fill"></i> Daftar Sekarang
            </a>
            <a href="#populer" class="btn-hero-secondary">
              <i class="bi bi-book-fill"></i> Lihat Koleksi
            </a>
          </div>
          <div class="hero-stats">
            <div>
              <div class="hero-stat-num">{{ $totalBuku }}+</div>
              <div class="hero-stat-lbl">Judul Buku</div>
            </div>
            <div style="width:1px;height:36px;background:rgba(255,255,255,.12)"></div>
            <div>
              <div class="hero-stat-num">{{ $totalStok }}+</div>
              <div class="hero-stat-lbl">Stok Tersedia</div>
            </div>
            <div style="width:1px;height:36px;background:rgba(255,255,255,.12)"></div>
            <div>
              <div class="hero-stat-num">{{ $kategoris->count() }}</div>
              <div class="hero-stat-lbl">Kategori</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Hero book display --}}
      <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center" style="padding:20px 0">
        <div style="display:flex;align-items:flex-end;gap:14px;filter:drop-shadow(0 24px 48px rgba(0,0,0,.4))">
          @foreach($bukuPopuler->take(3) as $hi => $hb)
          @php
            $rots  = ['-8deg', '-1deg', '7deg'];
            $trans = ['translateY(12px)', 'translateY(-6px)', 'translateY(16px)'];
            $zs    = ['1','3','1'];
            $ws    = ['110px','130px','110px'];
          @endphp
          <div style="width:{{ $ws[$hi] }};transform:rotate({{ $rots[$hi] }}) {{ $trans[$hi] }};z-index:{{ $zs[$hi] }};border-radius:10px;overflow:hidden;box-shadow:0 20px 50px rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.08)">
            <div style="padding-top:150%;position:relative;background:linear-gradient(150deg,{{ ['#0f1f3d,#1e4080','#581c87,#7c3aed','#064e3b,#059669'][$hi] }})">
              @if($hb->cover)
                <img src="{{ Storage::url($hb->cover) }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
              @else
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:10px;text-align:center;gap:6px">
                  <i class="bi bi-book-fill" style="font-size:1.8rem;color:rgba(255,255,255,.5)"></i>
                  <span style="font-size:.62rem;font-weight:700;color:rgba(255,255,255,.7);line-height:1.2;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical">{{ $hb->judul }}</span>
                </div>
              @endif
              <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:linear-gradient(to right,rgba(0,0,0,.3),transparent);z-index:2"></div>
            </div>
          </div>
          @endforeach

          @if($bukuPopuler->count() === 0)
          @foreach([['#0f1f3d','#1e4080','📘'],['#581c87','#7c3aed','📗'],['#064e3b','#059669','📕']] as $hi => $hc)
          <div style="width:{{ ['110px','130px','110px'][$hi] }};transform:rotate({{ ['-8deg','-1deg','7deg'][$hi] }}) {{ ['translateY(12px)','translateY(-6px)','translateY(16px)'][$hi] }};z-index:{{ ['1','3','1'][$hi] }};border-radius:10px;overflow:hidden;box-shadow:0 20px 50px rgba(0,0,0,.5)">
            <div style="padding-top:150%;position:relative;background:linear-gradient(150deg,{{ $hc[0] }},{{ $hc[1] }})">
              <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:2.5rem">{{ $hc[2] }}</div>
            </div>
          </div>
          @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ STATS BAR ═══════════════════════════════════════════ --}}
<div class="stats-bar">
  <div class="stats-bar-inner">
    @foreach([
      [$totalBuku.'+','Judul Buku','bi-journal-bookmark-fill'],
      [$totalStok.'+','Stok Buku','bi-box-seam-fill'],
      [$kategoris->count(),'Kategori','bi-tags-fill'],
      ['24/7','Akses Digital','bi-lightning-charge-fill'],
    ] as [$n,$l,$ic])
    <div class="stat-item">
      <div style="display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:8px">
        <div style="width:38px;height:38px;border-radius:10px;background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;font-size:.95rem;color:var(--gold)">
          <i class="bi {{ $ic }}"></i>
        </div>
        <div class="stat-item-num">{{ $n }}</div>
      </div>
      <div class="stat-item-lbl">{{ $l }}</div>
    </div>
    @endforeach
  </div>
</div>

{{-- ══ POPULER ═════════════════════════════════════════════ --}}
<section class="section" id="populer" style="background:#fff">
  <div class="section-inner">
    <div class="section-header">
      <div>
        <h2 class="section-title"><i class="bi bi-fire" style="color:var(--red);font-size:1.2rem;margin-right:8px"></i>Buku <span>Paling Populer</span></h2>
        <p class="section-sub">Koleksi paling banyak dipinjam oleh siswa</p>
      </div>
      <a href="{{ route('register') }}" class="see-all">Pinjam Sekarang <i class="bi bi-arrow-right"></i></a>
    </div>

    @if($bukuPopuler->isEmpty())
    <div style="text-align:center;padding:48px;color:var(--tx4)">
      <i class="bi bi-book" style="font-size:3rem;opacity:.2;display:block;margin-bottom:12px"></i>
      <p>Belum ada data buku.</p>
    </div>
    @else
    <div class="book-grid">
      @foreach($bukuPopuler as $i => $b)
      <div class="bk">
        <div class="bk-cover">
          @if($b->cover)
            <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}">
          @else
            <div class="bk-ph g{{ $i % 8 }}">
              <span class="ph-i"><i class="bi bi-book-fill"></i></span>
              <span class="ph-t">{{ $b->judul }}</span>
              <span class="ph-a">{{ $b->pengarang }}</span>
            </div>
          @endif
          @if($i === 0)
            <div class="bk-fire">🔥 #1</div>
          @elseif($i < 3)
            <div class="bk-fire" style="color:#e2e8f0">✦ #{{ $i+1 }}</div>
          @endif
          <span class="bk-stok {{ $b->stok>0?'stok-ada':'stok-habis' }}">{{ $b->stok>0?$b->stok.' stok':'Habis' }}</span>
        </div>
        <div class="bk-body">
          <div class="bk-cat">{{ $b->kategori }}</div>
          <div class="bk-title">{{ $b->judul }}</div>
          <div class="bk-author"><i class="bi bi-person" style="font-size:.65rem"></i> {{ $b->pengarang }}</div>
          <div class="bk-footer">
            <span class="bk-pinjam"><i class="bi bi-download" style="font-size:.65rem"></i>{{ $b->peminjaman_count }}x dipinjam</span>
            @if($b->stok > 0)
              <a href="{{ route('register') }}" class="btn-pinjam"><i class="bi bi-book"></i>Pinjam</a>
            @else
              <span class="btn-pinjam-disabled">Habis</span>
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- ══ PROMO BANNER ════════════════════════════════════════ --}}
<section style="padding:0 0 56px;background:#fff">
  <div class="section-inner">
    <div class="promo-banner">
      <div class="promo-text">
        <p><i class="bi bi-megaphone-fill me-2"></i>Perpustakaan Digital</p>
        <h3>Pinjam Buku <span>Gratis</span>,<br>Kapan Saja!</h3>
        <p style="color:rgba(255,255,255,.5);font-size:.83rem;margin-top:8px">Daftar sebagai anggota dan nikmati akses ke seluruh koleksi perpustakaan sekolah.</p>
      </div>
      <div style="position:relative;z-index:1;display:flex;align-items:center;gap:20px;flex-wrap:wrap">
        @if($bukuPopuler->count() >= 3)
        <div class="promo-books">
          @foreach($bukuPopuler->take(3) as $pi => $pb)
          <div class="promo-book">
            @if($pb->cover)<img src="{{ Storage::url($pb->cover) }}" alt="{{ $pb->judul }}">
            @else<div style="width:100%;height:100%;background:linear-gradient(150deg,{{ ['#0f1f3d,#1e4080','#581c87,#7c3aed','#064e3b,#059669'][$pi] }});display:flex;align-items:center;justify-content:center"><i class="bi bi-book-fill" style="color:rgba(255,255,255,.5);font-size:1.5rem"></i></div>
            @endif
          </div>
          @endforeach
        </div>
        @endif
        <div>
          <a href="{{ route('register') }}" class="promo-btn">
            <i class="bi bi-person-plus-fill"></i> Daftar Gratis
          </a>
          <p style="color:rgba(255,255,255,.35);font-size:.72rem;margin-top:8px;text-align:center">Tidak perlu kartu kredit</p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ TERBARU ══════════════════════════════════════════════ --}}
<section class="section" id="terbaru" style="background:var(--bg)">
  <div class="section-inner">
    <div class="section-header">
      <div>
        <h2 class="section-title"><i class="bi bi-stars" style="color:var(--gold);font-size:1.1rem;margin-right:8px"></i>Buku <span>Terbaru</span></h2>
        <p class="section-sub">Koleksi buku yang baru ditambahkan ke perpustakaan</p>
      </div>
      <a href="{{ route('register') }}" class="see-all">Semua Buku <i class="bi bi-arrow-right"></i></a>
    </div>

    @if($bukuTerbaru->isEmpty())
    <div style="text-align:center;padding:40px;color:var(--tx4)"><p>Belum ada buku terbaru.</p></div>
    @else
    <div class="row g-3">
      @foreach($bukuTerbaru as $ti => $tb)
      <div class="col-sm-6 col-lg-3">
        <div class="bk" style="flex-direction:row;padding:14px;border-radius:14px;gap:14px">
          {{-- Mini cover --}}
          <div style="width:70px;height:105px;border-radius:9px;overflow:hidden;flex-shrink:0;position:relative;box-shadow:var(--sh)">
            @if($tb->cover)
              <img src="{{ Storage::url($tb->cover) }}" style="width:100%;height:100%;object-fit:cover">
            @else
              <div class="bk-ph g{{ $ti % 8 }}" style="position:relative;width:100%;height:100%;padding:8px">
                <span class="ph-i" style="font-size:1.3rem"><i class="bi bi-book-fill"></i></span>
                <span class="ph-t" style="font-size:.58rem">{{ $tb->judul }}</span>
              </div>
            @endif
            <div style="position:absolute;left:0;top:0;bottom:0;width:4px;background:linear-gradient(to right,rgba(0,0,0,.25),transparent);z-index:2"></div>
          </div>
          {{-- Info --}}
          <div style="flex:1;min-width:0;display:flex;flex-direction:column;justify-content:space-between">
            <div>
              <div class="bk-cat" style="margin-bottom:5px">{{ $tb->kategori }}</div>
              <div style="font-size:.84rem;font-weight:700;color:var(--tx1);line-height:1.3;margin-bottom:4px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $tb->judul }}</div>
              <div style="font-size:.73rem;color:var(--tx3)">{{ $tb->pengarang }}</div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:10px">
              <span style="font-size:.69rem;font-weight:600;padding:2px 8px;border-radius:5px;{{ $tb->stok>0?'background:#dcfce7;color:#16a34a':'background:#fee2e2;color:#dc2626' }}">
                {{ $tb->stok>0 ? '● '.$tb->stok.' stok' : '● Habis' }}
              </span>
              <a href="{{ route('register') }}" style="font-size:.73rem;font-weight:700;color:var(--navy);display:flex;align-items:center;gap:4px">
                Pinjam <i class="bi bi-arrow-right" style="font-size:.7rem"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- ══ KATEGORI ════════════════════════════════════════════ --}}
<section class="section" id="koleksi" style="background:#fff">
  <div class="section-inner">
    <div class="section-header">
      <div>
        <h2 class="section-title">Jelajahi <span>Kategori</span></h2>
        <p class="section-sub">Temukan buku berdasarkan kategori yang kamu suka</p>
      </div>
    </div>
    <div class="cat-grid">
      @php
      $catIcons = ['Pemrograman'=>'bi-code-slash','Framework'=>'bi-layers-fill','Database'=>'bi-database-fill','Jaringan'=>'bi-diagram-3-fill','AI'=>'bi-cpu-fill','Desain'=>'bi-palette-fill','Sistem Operasi'=>'bi-terminal-fill','Matematika'=>'bi-calculator-fill','Fisika'=>'bi-lightning-fill','Bahasa'=>'bi-translate','Sejarah'=>'bi-hourglass-split','Sastra'=>'bi-journal-text','kartun'=>'bi-brush-fill','fantasi'=>'bi-stars','misteri'=>'bi-search-heart'];
      @endphp
      @foreach($kategoris as $kat)
      <a href="{{ route('register') }}" class="cat-chip">
        <i class="bi {{ $catIcons[$kat] ?? 'bi-book-fill' }}" style="color:var(--blue)"></i>
        {{ $kat }}
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- ══ CTA ════════════════════════════════════════════════ --}}
<section style="padding:56px 0;background:linear-gradient(135deg,#0f1f3d 0%,#1a3461 50%,#1e4080 100%);position:relative;overflow:hidden">
  <div style="position:absolute;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(245,158,11,.09) 0%,transparent 70%);top:-150px;right:-100px;pointer-events:none"></div>
  <div style="max-width:1200px;margin:0 auto;padding:0 24px;text-align:center;position:relative;z-index:1">
    <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.3);color:#fbbf24;font-size:.74rem;font-weight:700;padding:5px 14px;border-radius:99px;margin-bottom:20px">
      <i class="bi bi-person-check-fill"></i> Bergabung Sekarang — Gratis!
    </div>
    <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.6rem,3.5vw,2.5rem);font-weight:800;color:#fff;margin-bottom:14px;letter-spacing:-.02em">
      Mulai Pinjam Buku Hari Ini
    </h2>
    <p style="font-size:.95rem;color:rgba(255,255,255,.5);margin-bottom:32px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7">
      Daftar gratis sebagai anggota perpustakaan sekolah dan nikmati kemudahan pinjam buku secara digital.
    </p>
    <div style="display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap">
      <a href="{{ route('register') }}" class="btn-hero-primary" style="font-size:.9rem">
        <i class="bi bi-person-plus-fill"></i> Daftar Sekarang
      </a>
      <a href="{{ route('login') }}" class="btn-hero-secondary" style="font-size:.9rem">
        <i class="bi bi-box-arrow-in-right"></i> Sudah punya akun? Masuk
      </a>
    </div>
  </div>
</section>

{{-- ══ FOOTER ══════════════════════════════════════════════ --}}
<footer class="footer">
  <div class="footer-inner">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="footer-brand">
          <div class="footer-brand-ico"><i class="bi bi-book-half"></i></div>
          <div class="footer-brand-name">Perpustakaan Sekolah Digital</div>
        </div>
        <p class="footer-desc">Platform peminjaman buku digital untuk seluruh warga sekolah. Mudah, cepat, dan gratis.</p>
        <div style="display:flex;gap:8px;margin-top:16px">
          @foreach(['bi-instagram','bi-twitter-x','bi-facebook','bi-youtube'] as $ic)
          <a href="#" style="width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,.07);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.45);font-size:.88rem;transition:all .18s"
             onmouseover="this.style.background='rgba(245,158,11,.2)';this.style.color='#fbbf24'"
             onmouseout="this.style.background='rgba(255,255,255,.07)';this.style.color='rgba(255,255,255,.45)'">
            <i class="bi {{ $ic }}"></i>
          </a>
          @endforeach
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-6">
        <p class="footer-heading">Menu</p>
        <a href="{{ route('landing') }}" class="footer-link">Beranda</a>
        <a href="#populer" class="footer-link">Buku Populer</a>
        <a href="#terbaru" class="footer-link">Buku Terbaru</a>
        <a href="#koleksi" class="footer-link">Kategori</a>
      </div>
      <div class="col-lg-2 col-md-3 col-6">
        <p class="footer-heading">Akun</p>
        <a href="{{ route('login') }}" class="footer-link">Masuk</a>
        <a href="{{ route('register') }}" class="footer-link">Daftar</a>
        @auth
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('siswa.dashboard') }}" class="footer-link">Dashboard</a>
        @endauth
      </div>
      <div class="col-lg-4 col-md-6">
        <p class="footer-heading">Info</p>
        <p style="font-size:.82rem;color:rgba(255,255,255,.4);line-height:1.7">
          Sistem perpustakaan sekolah berbasis web untuk memudahkan peminjaman dan pengelolaan buku secara digital.
          Tersedia untuk seluruh siswa dan staf sekolah.
        </p>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">© {{ date('Y') }} Perpustakaan Sekolah Digital. All rights reserved.</span>
      <span class="footer-copy">Built with Laravel {{ app()->version() }}</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    const t=document.querySelector(a.getAttribute('href'));
    if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'})}
  })
})
// Navbar active state on scroll
const sections=document.querySelectorAll('section[id]');
const navLinks=document.querySelectorAll('.nav-link');
window.addEventListener('scroll',()=>{
  let cur='';
  sections.forEach(s=>{if(window.scrollY>=s.offsetTop-80)cur=s.id});
  navLinks.forEach(l=>{
    l.classList.remove('active');
    if(l.getAttribute('href')==='#'+cur)l.classList.add('active');
    if(l.getAttribute('href')===window.location.pathname&&cur==='')l.classList.add('active');
  });
})
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $series->nama_series }} – Perpustakaan Sekolah Digital</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/bookshelf-real.css') }}?v={{ filemtime(public_path('css/bookshelf-real.css')) }}">
<style>
/* ══════════════════════════════
   BASE
══════════════════════════════ */
:root{
  --red:#ED1B3B;--red-dk:#C41630;
  --navy:#14284B;--navy-dk:#0B1730;
  --gold:#E9A800;
  --bg:#F4F6FA;
  --white:#fff;
  --border:#E4E8EF;
  --tx1:#111827;--tx2:#374151;--tx3:#6B7280;--tx4:#9CA3AF;
  --sh:0 2px 10px rgba(0,0,0,.07);
  --sh2:0 12px 32px rgba(0,0,0,.12);
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--tx1);-webkit-font-smoothing:antialiased}
a{text-decoration:none;color:inherit}
img{display:block}

/* ══════════════════════════════
   NAVBAR
══════════════════════════════ */
.nav{
  display:none; /* Navbar dihapus */
}
.nav-back{
  display:inline-flex;align-items:center;gap:7px;
  font-size:.82rem;font-weight:600;color:rgba(255,255,255,.7);
  padding:7px 14px;border-radius:8px;border:1.5px solid rgba(255,255,255,.2);
  transition:all .18s;
  margin-bottom:20px;
}
.nav-back:hover{background:rgba(255,255,255,.15);color:#fff;border-color:rgba(255,255,255,.4)}

/* ══════════════════════════════
   HERO SERIES
══════════════════════════════ */
.hero{
  /* Background foto rak */
  background:
    linear-gradient(rgba(20,40,75,.85),rgba(11,23,48,.9)),
    url('/image/bg-buku.png') center/cover no-repeat;
  padding:48px 32px 0;position:relative;overflow:hidden;
}
.hero::before{
  content:'';position:absolute;top:-160px;right:-100px;
  width:600px;height:600px;border-radius:50%;
  background:radial-gradient(circle,rgba(237,27,59,.12) 0%,transparent 65%);
  pointer-events:none;
}
.hero::after{
  content:'';position:absolute;bottom:-60px;left:5%;
  width:350px;height:350px;border-radius:50%;
  background:radial-gradient(circle,rgba(244,185,66,.05) 0%,transparent 65%);
  pointer-events:none;
}
.hero-inner{
  max-width:1000px;margin:0 auto;
  position:relative;z-index:1;
  display:flex;gap:40px;align-items:center;
  padding-bottom:40px;
}
.hero-top{
  max-width:1000px;margin:0 auto;
  position:relative;z-index:1;
  display:flex;justify-content:flex-end;
  padding-bottom:10px;
}

/* Cover Besar dengan Lampu */
.hero-book-wrapper{
  flex:0 0 auto;
  position:relative;
}

.hero-book{
  width:168px;
  filter:drop-shadow(0 20px 36px rgba(0,0,0,.5));
  position:relative;
  z-index:2;
}

/* Lampu spotlight di atas cover */
.hero-book-light{
  position:absolute;
  top:-35px;
  left:50%;
  transform:translateX(-50%);
  z-index:4;
  pointer-events:none;
}

.hero-light-fixture{
  width:40px; /* LEBIH LEBAR LAGI */
  height:14px;
  background:linear-gradient(180deg,#2c2c2c,#1a1a1a);
  border-radius:20px 20px 0 0;
  position:relative;
  box-shadow:0 2px 4px rgba(0,0,0,.3);
  z-index:3;
}

.hero-light-bulb{
  position:absolute;
  bottom:-9px;
  left:50%;
  transform:translateX(-50%);
  width:20px; /* LEBIH BESAR */
  height:20px;
  background:radial-gradient(circle,#fff9e6 0%,#f4e5b8 50%,#d4c19a 100%);
  border-radius:50%;
  box-shadow:
    0 0 15px rgba(255,243,176,.9),
    0 0 30px rgba(255,243,176,.6),
    0 2px 3px rgba(0,0,0,.2);
}

.hero-light-beam{
  position:absolute;
  top:22px;
  left:50%;
  transform:translateX(-50%);
  width:168px;
  height:258px;
  background:
    radial-gradient(ellipse at 50% 10%,rgba(255,250,211,.72) 0%,rgba(255,243,176,.3) 30%,transparent 72%),
    linear-gradient(180deg,rgba(255,248,196,.2) 0%,rgba(255,243,176,.14) 50%,transparent 100%);
  pointer-events:none;
  z-index:4;
  mix-blend-mode:screen;
  opacity:.34;
  filter:blur(6px);
  mask-image:linear-gradient(180deg,transparent 0%,#000 10%,#000 86%,transparent 100%);
  -webkit-mask-image:linear-gradient(180deg,transparent 0%,#000 10%,#000 86%,transparent 100%);
  animation:heroLightPulse 4s ease-in-out infinite;
}
.hero-light-beam::after{
  content:'';
  position:absolute;
  inset:0;
  background:radial-gradient(ellipse at 50% 58%,rgba(255,247,190,.24),transparent 63%);
}
@keyframes heroLightPulse{
  0%,100%{opacity:.5}
  50%{opacity:.68}
}

.hero-book img{
  width:168px;height:240px;
  object-fit:cover;
  border-radius:3px 10px 10px 3px;
  box-shadow:6px 0 18px rgba(0,0,0,.35),inset -4px 0 8px rgba(0,0,0,.25);
}
.hero-book::after{
  content:'';
  position:absolute;
  inset:0;
  border-radius:inherit;
  background:
    radial-gradient(ellipse at 50% 0%,rgba(255,250,211,.42) 0%,rgba(255,246,190,.18) 30%,transparent 72%),
    linear-gradient(105deg,transparent 20%,rgba(255,247,199,.13) 48%,transparent 76%);
  mix-blend-mode:screen;
  pointer-events:none;
  z-index:4;
}
.hero-book-ph{
  width:168px;height:240px;
  border-radius:3px 10px 10px 3px;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:10px;padding:16px;text-align:center;
  box-shadow:6px 0 18px rgba(0,0,0,.35);
}
.hero-book-ph i{font-size:2.8rem;color:rgba(255,255,255,.35)}
.hero-book-ph span{font-size:.72rem;font-weight:700;color:rgba(255,255,255,.5);line-height:1.3}

/* Info di kanan cover */
.hero-info{flex:1;min-width:0;}
.hero-eyebrow{
  font-size:.68rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;
  color:rgba(255,255,255,.4);margin-bottom:10px;
  display:flex;align-items:center;gap:7px;
}
.hero-title{
  font-family:'Playfair Display',serif;
  font-size:clamp(1.7rem,3.5vw,2.6rem);font-weight:800;color:#fff;
  line-height:1.15;margin-bottom:10px;
}
.hero-author{
  font-size:.88rem;color:rgba(255,255,255,.55);
  display:flex;align-items:center;gap:7px;margin-bottom:14px;
}
.hero-author i{color:var(--gold)}
.hero-desc{
  font-size:.83rem;color:rgba(255,255,255,.4);
  line-height:1.65;max-width:540px;margin-bottom:20px;
}
.hero-chips{display:flex;gap:8px;flex-wrap:wrap}
.chip{
  display:inline-flex;align-items:center;gap:6px;
  font-size:.72rem;font-weight:700;padding:5px 13px;border-radius:99px;
}
.chip-red{background:rgba(237,27,59,.15);border:1px solid rgba(237,27,59,.3);color:#ff8a9a}
.chip-gold{background:rgba(233,168,0,.12);border:1px solid rgba(233,168,0,.25);color:var(--gold)}
.chip-blue{background:rgba(96,165,250,.1);border:1px solid rgba(96,165,250,.2);color:#93c5fd}

/* Efek fade bawah hero */
.hero-bottom{height:32px;background:linear-gradient(180deg,var(--navy-dk),var(--bg))}

/* ══════════════════════════════
   MAIN WRAPPER
══════════════════════════════ */
.main{max-width:1000px;margin:0 auto;padding:36px 32px 80px}

.sec-head{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:28px;flex-wrap:wrap;gap:10px;
}
.sec-title{font-family:'Playfair Display',serif;font-size:1.35rem;font-weight:700;color:var(--navy)}
.sec-title span{color:var(--red)}
.sec-sub{font-size:.8rem;color:var(--tx3);font-weight:500}

/* ══════════════════════════════════════════════
   BOOKSHELF — persis seperti referensi
══════════════════════════════════════════════ */
.bookshelf-section{
  /* Background putih bersih, tidak ada foto global */
  background:transparent;
  border-radius:0;
  padding:0;
  margin-bottom:40px;
  overflow:visible;
}

/* Satu unit rak: buku + papan */
.shelf-row{
  position:relative;
  margin-bottom:6px;
}

/* Buku-buku di atas rak */
.shelf-books{
  display:flex;
  align-items:flex-end;
  /* Buku tersebar merata di seluruh lebar rak */
  justify-content:space-evenly;
  padding:0 24px 0;
  min-height:200px;
  /* Background per rak dengan foto */
  background:
    linear-gradient(rgba(74,74,82,.65),rgba(58,58,66,.75)),
    url('/image/bg-rak.png') center/cover no-repeat;
  background-color:#4a4a52;
  border-radius:8px 8px 0 0;
}

/* ══ PAPAN RAK — foto kayu asli ══ */
.shelf-plank{
  height:20px;
  position:relative;
  margin-bottom:28px;
  /* Foto kayu asli dengan overlay gradient */
  background:
    linear-gradient(180deg,
      rgba(248,244,238,.75) 0%,
      rgba(237,232,223,.5) 20%,
      transparent 55%,
      rgba(200,194,182,.3) 85%,
      rgba(184,178,166,.5) 100%
    ),
    url('/image/wood-bg.jpg') center/cover no-repeat;
  background-color:#8b5a2b;
  border-radius:0 0 3px 3px;
  /* Shadow dalam yang dalam di bawah = efek papan nyata */
  box-shadow:
    0 8px 24px rgba(0,0,0,.55),
    0 4px 8px rgba(0,0,0,.35),
    0 2px 3px rgba(0,0,0,.25),
    inset 0 1px 0 rgba(255,255,255,.85),
    inset 0 -1px 0 rgba(0,0,0,.12);
}
/* Highlight putih atas papan */
.shelf-plank::before{
  content:'';position:absolute;top:0;left:3px;right:3px;height:3px;
  background:linear-gradient(90deg,
    rgba(255,255,255,.1) 0%,
    rgba(255,255,255,.9) 20%,
    rgba(255,255,255,.7) 50%,
    rgba(255,255,255,.9) 80%,
    rgba(255,255,255,.1) 100%
  );
  border-radius:3px 3px 0 0;
}
/* Shadow tipis bawah papan */
.shelf-plank::after{
  content:'';
  position:absolute;bottom:-12px;left:4px;right:4px;height:12px;
  background:linear-gradient(180deg,rgba(0,0,0,.35),transparent);
  border-radius:0 0 6px 6px;
  pointer-events:none;
}

/* ══════════════════════════════
   LAMPU SPOTLIGHT
══════════════════════════════ */
.shelf-book-wrapper{
  position:relative;
  flex:0 0 auto;
}

.shelf-book-light{
  position:absolute;
  top:-30px;
  left:50%;
  transform:translateX(-50%);
  z-index:1;
}

/* Housing lampu */
.light-fixture{
  width:16px;
  height:8px;
  background:linear-gradient(180deg,#2c2c2c,#1a1a1a);
  border-radius:8px 8px 0 0;
  position:relative;
  box-shadow:0 2px 4px rgba(0,0,0,.3);
}

/* Bohlam */
.light-bulb{
  position:absolute;
  bottom:-6px;
  left:50%;
  transform:translateX(-50%);
  width:10px;
  height:10px;
  background:radial-gradient(circle,#fff9e6 0%,#f4e5b8 50%,#d4c19a 100%);
  border-radius:50%;
  box-shadow:
    0 0 10px rgba(255,243,176,1),
    0 0 22px rgba(255,243,176,.85),
    0 0 38px rgba(255,226,125,.35),
    0 2px 3px rgba(0,0,0,.2);
}

/* Cahaya spotlight SEGITIGA */
.light-beam{
  position:absolute;
  top:18px;
  left:50%;
  transform:translateX(-50%);
  width:118px;
  height:178px;
  background:radial-gradient(ellipse at 50% 10%,rgba(255,250,211,.82),rgba(255,243,176,.34) 34%,transparent 74%),linear-gradient(180deg,rgba(255,248,196,.24),rgba(255,243,176,.16) 55%,transparent);
  pointer-events:none;
  z-index:4;
  mix-blend-mode:screen;
  opacity:.52;
  filter:blur(5px);
  mask-image:linear-gradient(180deg,transparent,#000 12%,#000 84%,transparent);
  -webkit-mask-image:linear-gradient(180deg,transparent,#000 12%,#000 84%,transparent);
}

/* ══ SATU BUKU ══ */
.shelf-book{
  position:relative;
  flex:0 0 auto;
  cursor:pointer;
  transform-origin:bottom center;
  /* TEGAK LURUS — tidak miring */
  transition:
    transform .45s cubic-bezier(.34,1.56,.64,1),
    filter .35s ease;
  filter:drop-shadow(2px 4px 8px rgba(0,0,0,.5));
  z-index:2; /* Di atas cahaya */
}

/* Hover: naik dengan spring bounce yang bagus */
.shelf-book:hover{
  transform:translateY(-36px) scale(1.1) !important;
  z-index:50;
  filter:drop-shadow(0 24px 36px rgba(0,0,0,.65));
}
.shelf-book.active{
  transform:translateY(-36px) scale(1.1) !important;
  z-index:50;
  filter:drop-shadow(0 24px 36px rgba(0,0,0,.65));
}

/* Spine shadow 3D */
.shelf-book::before{
  content:'';
  position:absolute;left:0;top:0;bottom:0;width:7px;
  background:linear-gradient(to right,rgba(0,0,0,.5),rgba(0,0,0,.12),transparent);
  z-index:3;pointer-events:none;border-radius:2px 0 0 2px;
}
/* Gloss atas */
.shelf-book::after{
  content:'';position:absolute;top:0;left:0;right:0;height:4px;
  background:linear-gradient(180deg,rgba(255,255,255,.3),transparent);
  z-index:3;pointer-events:none;
}
.shelf-book::after{
  height:100%;
  background:radial-gradient(ellipse at 50% 0%,rgba(255,250,211,.28),rgba(255,246,190,.08) 34%,transparent 72%);
  mix-blend-mode:screen;
  border-radius:inherit;
}

.shelf-book-img{
  display:block;
  object-fit:cover;object-position:center top;
  border-radius:2px 4px 4px 2px;
}
.shelf-book-ph{
  border-radius:2px 4px 4px 2px;
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  gap:6px;padding:10px 8px;text-align:center;
}
.shelf-book-ph i{font-size:1.4rem;color:rgba(255,255,255,.45)}
.shelf-book-ph span{font-size:.5rem;font-weight:700;color:rgba(255,255,255,.7);line-height:1.25}

.book-fin-badge{
  position:absolute;top:4px;right:4px;z-index:4;
  background:linear-gradient(135deg,#f59e0b,#d97706);
  color:#fff;font-size:.5rem;font-weight:800;
  padding:2px 5px;border-radius:3px;pointer-events:none;
}

/* ══ POPUP (desktop hover only) ══ */
.book-popup{
  display:none;
  position:absolute;
  bottom:calc(100% + 16px);
  left:50%;transform:translateX(-50%);
  z-index:300;
  width:182px;
  background:#fff;
  border-radius:10px;
  box-shadow:0 10px 32px rgba(0,0,0,.25),0 3px 10px rgba(0,0,0,.12);
  padding:13px 14px;
  pointer-events:none;
  animation:popupIn .22s cubic-bezier(.34,1.56,.64,1);
}
@keyframes popupIn{
  from{opacity:0;transform:translateX(-50%) translateY(10px) scale(.92)}
  to{opacity:1;transform:translateX(-50%) translateY(0) scale(1)}
}
.book-popup::after{
  content:'';position:absolute;bottom:-7px;left:50%;transform:translateX(-50%);
  width:0;height:0;
  border-left:7px solid transparent;border-right:7px solid transparent;
  border-top:7px solid #fff;
}
.shelf-book:hover .book-popup{display:block}

/* ══ MOBILE MODAL ══ */
.mobile-modal-overlay{
  display:none;position:fixed;inset:0;
  background:rgba(0,0,0,.6);z-index:9999;
  align-items:center;justify-content:center;padding:20px;
}
.mobile-modal-overlay.open{display:flex}
.mobile-modal{
  background:#fff;border-radius:16px;padding:20px;
  width:100%;max-width:320px;
  box-shadow:0 24px 60px rgba(0,0,0,.4);
  animation:modalIn .25s cubic-bezier(.34,1.56,.64,1);
  position:relative;
}
@keyframes modalIn{
  from{opacity:0;transform:scale(.85) translateY(20px)}
  to{opacity:1;transform:scale(1) translateY(0)}
}
.mobile-modal-close{
  position:absolute;top:12px;right:12px;
  width:28px;height:28px;border-radius:50%;
  background:#f1f5f9;border:none;cursor:pointer;
  display:flex;align-items:center;justify-content:center;
  font-size:1rem;color:#374151;
}
.m-cover img{
  width:70px;height:100px;object-fit:cover;
  border-radius:3px 6px 6px 3px;margin-bottom:10px;
  box-shadow:2px 4px 10px rgba(0,0,0,.25);
}
.m-cover-ph{
  width:70px;height:100px;border-radius:3px 6px 6px 3px;
  background:linear-gradient(135deg,#14284B,#ED1B3B);
  display:flex;align-items:center;justify-content:center;margin-bottom:10px;
}
.m-cover-ph i{font-size:1.8rem;color:rgba(255,255,255,.6)}
.m-urutan{font-size:.62rem;font-weight:800;color:#ED1B3B;margin-bottom:4px;letter-spacing:.05em}
.m-title{font-size:.95rem;font-weight:700;color:#111;line-height:1.3;margin-bottom:4px}
.m-author{font-size:.78rem;color:#6B7280;margin-bottom:8px}
.m-stok{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.72rem;font-weight:700;padding:4px 10px;
  border-radius:99px;margin-bottom:12px;
}
.m-btn-pinjam{
  display:flex;align-items:center;justify-content:center;gap:5px;
  background:#ED1B3B;color:#fff;font-size:.85rem;font-weight:700;
  padding:10px;border-radius:8px;width:100%;text-decoration:none;
}
.m-btn-dis{
  display:flex;align-items:center;justify-content:center;gap:5px;
  background:#f1f5f9;color:#9ca3af;font-size:.85rem;font-weight:600;
  padding:10px;border-radius:8px;width:100%;cursor:not-allowed;
}

@media(min-width:769px){.mobile-modal-overlay{display:none !important}}
@media(max-width:768px){
  .shelf-book:hover .book-popup{display:none !important}
  .book-popup{display:none !important}
}
.popup-num{font-size:.6rem;font-weight:800;color:var(--red);margin-bottom:4px;letter-spacing:.05em}
.popup-title{font-size:.8rem;font-weight:700;color:#1a1a1a;line-height:1.3;margin-bottom:3px}
.popup-author{font-size:.69rem;color:var(--tx3);margin-bottom:9px}
.popup-stok{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.67rem;font-weight:700;padding:3px 8px;border-radius:99px;margin-bottom:9px;
}
.stok-ada{background:#dcfce7;color:#15803d}
.stok-habis{background:#fee2e2;color:#dc2626}
.popup-btn{
  display:flex;align-items:center;justify-content:center;gap:5px;
  background:var(--red);color:#fff;font-size:.72rem;font-weight:700;
  padding:7px 12px;border-radius:7px;width:100%;text-decoration:none;
  transition:background .15s;
}
.popup-btn:hover{background:var(--red-dk);color:#fff}
.popup-btn-dis{
  display:flex;align-items:center;justify-content:center;gap:5px;
  background:#f1f5f9;color:#9ca3af;font-size:.72rem;font-weight:600;
  padding:7px 12px;border-radius:7px;width:100%;cursor:not-allowed;
}

.g0{background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.g1{background:linear-gradient(150deg,#581c87,#7c3aed)}
.g2{background:linear-gradient(150deg,#064e3b,#059669)}
.g3{background:linear-gradient(150deg,#78350f,#d97706)}
.g4{background:linear-gradient(150deg,#881337,#e11d48)}
.g5{background:linear-gradient(150deg,#0c4a6e,#0284c7)}
.g6{background:linear-gradient(150deg,#1f2937,#4b5563)}
.g7{background:linear-gradient(150deg,#134e4a,#0d9488)}

/* ══════════════════════════════
   SERIES LAINNYA
══════════════════════════════ */
.other{margin-top:0;padding-top:40px;border-top:1.5px solid var(--border)}
.other-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(190px,1fr));
  gap:14px;
}
.oc{
  display:flex;align-items:center;gap:12px;
  background:#fff;border:1.5px solid var(--border);
  border-radius:10px;padding:12px;
  transition:all .2s;text-decoration:none;color:inherit;
  box-shadow:var(--sh);
}
.oc:hover{border-color:var(--red);transform:translateY(-3px);box-shadow:var(--sh2)}
.oc-thumb{
  width:42px;height:60px;
  border-radius:3px 6px 6px 3px;
  overflow:hidden;background:#dde3ef;flex-shrink:0;
  box-shadow:2px 3px 8px rgba(0,0,0,.15);
}
.oc-thumb img{width:100%;height:100%;object-fit:cover}
.oc-info .name{font-size:.8rem;font-weight:700;color:var(--navy);line-height:1.25}
.oc-info .meta{font-size:.69rem;color:var(--tx3);margin-top:3px}

/* FOOTER */
.foot{text-align:center;padding:28px 24px;border-top:1px solid var(--border);color:var(--tx4);font-size:.78rem;margin-top:0}

/* ══════════════════════════════
   RESPONSIVE
══════════════════════════════ */
@media(max-width:1024px){
  .shelf-books{min-height:155px;gap:20px}
}
@media(max-width:768px){
  .hero{padding:36px 20px 0}
  .hero-inner{flex-direction:column;gap:20px;align-items:flex-start;padding-bottom:28px}
  .hero-book{width:120px}
  .hero-book img,.hero-book-ph{width:120px;height:172px}
  
  /* Lampu lebih kecil di mobile tapi tetap proporsional */
  .hero-book-light{
    top:-28px;
  }
  
  .hero-light-fixture{
    width:30px;
    height:12px;
  }
  
  .hero-light-bulb{
    width:16px;
    height:16px;
    bottom:-8px;
  }
  
  .hero-light-beam{
    width:120px; /* Cahaya mengikuti lebar cover mobile */
    height:190px;
    top:20px;
  }
  
  .main{padding:28px 20px 60px}
  .bookshelf-section{border-radius:8px}
  .shelf-books{min-height:130px;gap:16px;padding:20px 14px 0}
  .shelf-row{padding:0 12px}
  
  /* Hover jangan terlalu tinggi */
  .shelf-book:hover, .shelf-book.active{
    transform:translateY(-20px) scale(1.05) !important;
  }
}
@media(max-width:480px){
  body{overflow-x:hidden}
  .hero-top{justify-content:center;padding-bottom:4px}
  .hero-inner{align-items:center;gap:18px;padding-bottom:24px}
  .hero-book-wrapper{margin-top:8px}
  .nav-crumb{display:none}
  .other-grid{grid-template-columns:repeat(2,1fr)}
  .main{padding:24px 12px 56px}
  .sec-head{align-items:flex-start;gap:8px;margin-bottom:20px}
  .shelf-books{min-height:140px;gap:12px;overflow-x:auto;padding:12px 12px 0}
  .shelf-row{padding:0;margin-bottom:10px}
  .shelf-books{justify-content:flex-start;scroll-snap-type:x proximity}
  .shelf-book-wrapper{width:72px;scroll-snap-align:start}
  .shelf-book-img,.shelf-book-ph{width:72px !important;height:114px !important}
  .shelf-book-light{top:-24px}
  .light-beam{width:72px;height:114px}
  .light-beam{width:78px;height:126px}
  .hero-info{width:100%}
  .hero-eyebrow,.hero-author{justify-content:center}
  .hero-desc{max-width:330px;margin-left:auto;margin-right:auto;text-align:center}
  .hero-chips{justify-content:center}
  .hero-title{font-size:2rem}
  .hero-desc{font-size:.78rem;line-height:1.55}
  .hero-chips{gap:6px}
  .chip{font-size:.65rem;padding:5px 9px}
  
  /* Di HP: buku JANGAN naik */
  .shelf-book:hover, .shelf-book.active{
    transform:translateY(0px) scale(1.0) !important;
    z-index:100;
  }
  
  /* Popup tetap di atas, dekat buku */
  .book-popup{
    width:160px;
    bottom:calc(100% + 8px);
    padding:10px 12px;
  }
}
</style>
</head>
<body>

{{-- ══ NAVBAR (DIHAPUS, TOMBOL DI HERO) ══ --}}

{{-- ══ HERO ══ --}}
<div class="hero">
  {{-- Tombol kembali di kanan --}}
  <div class="hero-top">
    <a href="{{ route('series.index') }}" class="nav-back">
      <i class="bi bi-arrow-left"></i> Semua Series
    </a>
  </div>
  
  <div class="hero-inner">
    {{-- Cover buku pertama dengan lampu spotlight --}}
    @php $firstBook = $series->buku->first(); @endphp
    <div class="hero-book-wrapper">
      {{-- Lampu spotlight --}}
      <div class="hero-book-light">
        <div class="hero-light-fixture">
          <div class="hero-light-bulb"></div>
        </div>
        <div class="hero-light-beam"></div>
      </div>
      
      {{-- Cover buku --}}
      <div class="hero-book">
        @if($firstBook && $firstBook->cover)
          @if(Str::startsWith($firstBook->cover, 'http'))
            <img src="{{ $firstBook->cover }}" alt="{{ $series->nama_series }}">
          @else
            <img src="{{ Storage::url($firstBook->cover) }}" alt="{{ $series->nama_series }}">
          @endif
        @else
          <div class="hero-book-ph g0">
            <i class="bi bi-book-fill"></i>
            <span>{{ $series->nama_series }}</span>
          </div>
        @endif
      </div>
    </div>

    {{-- Info --}}
    <div class="hero-info">
      <div class="hero-eyebrow"><i class="bi bi-collection-fill"></i> Koleksi Series</div>
      <h1 class="hero-title">{{ $series->nama_series }}</h1>
      <div class="hero-author"><i class="bi bi-person-fill"></i> {{ $series->penulis }}</div>
      @if($series->deskripsi)
      <p class="hero-desc">{{ $series->deskripsi }}</p>
      @endif
      <div class="hero-chips">
        <span class="chip chip-red"><i class="bi bi-collection-fill"></i> {{ $series->buku_count }} Buku</span>
        <span class="chip chip-gold"><i class="bi bi-star-fill"></i> Series Pilihan</span>
        <span class="chip chip-blue"><i class="bi bi-book-fill"></i> Fiksi</span>
      </div>
    </div>
  </div>
</div>
<div class="hero-bottom"></div>

{{-- ══ MAIN ══ --}}
<div class="main">

  <div class="sec-head">
    <h2 class="sec-title">Semua <span>Buku</span></h2>
    <span class="sec-sub">{{ $series->buku_count }} judul · Urutan baca</span>
  </div>

  {{-- ══════════ BOOKSHELF RAK KAYU ══════════ --}}
  @php
    $bukuAll = $series->buku;
    $perRow  = 4; // 4 buku per rak seperti referensi
    $rows    = $bukuAll->chunk($perRow);
    $heights = [180, 180, 180, 180, 180, 180, 180, 180, 180, 180, 180, 180, 180, 180, 180]; // SEMUA SAMA
    $widths  = [115, 115, 115, 115, 115, 115, 115, 115, 115, 115, 115, 115, 115, 115, 115]; // SEMUA SAMA
  @endphp

  <div class="bookshelf-section">
    @foreach($rows as $rowIdx => $rowBooks)
    <div class="shelf-row">
      <div class="shelf-books">
        @include('partials.shelf-decor')
        @foreach($rowBooks as $i => $book)
        @php
          $pv  = $book->pivot;
          $idx = $rowIdx * $perRow + $i;
          $bh  = $heights[$idx % count($heights)];
          $bw  = $widths[$idx  % count($widths)];
        @endphp
        
        {{-- Wrapper: lampu + buku --}}
        <div class="shelf-book-wrapper">
          {{-- Lampu spotlight --}}
          <div class="shelf-book-light">
            @include('partials.shelf-light-cord')
            <div class="light-fixture"></div>
            <div class="light-bulb"></div>
            <div class="light-beam"></div>
          </div>
          
          {{-- Buku --}}
          <div class="shelf-book"
            data-judul="{{ $book->judul }}"
            data-pengarang="{{ $book->pengarang }}"
            data-urutan="{{ $pv->urutan_baca }}"
            data-stok="{{ $book->stok }}"
            data-cover="{{ $book->cover ? (Str::startsWith($book->cover,'http') ? $book->cover : Storage::url($book->cover)) : '' }}"
            data-link="{{ $book->stok > 0 ? route('register') : '' }}"
          >

          {{-- Cover --}}
          @if($book->cover)
            @if(Str::startsWith($book->cover, 'http'))
              <img class="shelf-book-img"
                   src="{{ $book->cover }}"
                   alt="{{ $book->judul }}"
                   loading="lazy"
                   style="height:{{ $bh }}px;width:{{ $bw }}px">
            @else
              <img class="shelf-book-img"
                   src="{{ Storage::url($book->cover) }}"
                   alt="{{ $book->judul }}"
                   loading="lazy"
                   style="height:{{ $bh }}px;width:{{ $bw }}px">
            @endif
          @else
            <div class="shelf-book-ph g{{ $idx % 8 }}"
                 style="height:{{ $bh }}px;width:{{ $bw }}px">
              <i class="bi bi-book-fill"></i>
              <span>{{ Str::limit($book->judul, 18) }}</span>
            </div>
          @endif
          @include('partials.shelf-stock-tag', ['stok' => $book->stok])

          {{-- Badge penutup --}}
          @if($pv->is_penutup)
            <div class="book-fin-badge">🎉</div>
          @endif

          {{-- Popup hover --}}
          <div class="book-popup">
            <div class="popup-num">Buku #{{ $pv->urutan_baca }}</div>
            <div class="popup-title">{{ $book->judul }}</div>
            <div class="popup-author">{{ $book->pengarang }}</div>
            @if($book->stok > 0)
              <span class="popup-stok stok-ada">
                <i class="bi bi-check-circle-fill" style="font-size:.6rem"></i>
                {{ $book->stok }} tersedia
              </span>
            @else
              <span class="popup-stok stok-habis">
                <i class="bi bi-x-circle-fill" style="font-size:.6rem"></i>
                Habis
              </span>
            @endif
            @if($book->stok > 0)
              <a href="{{ route('register') }}" class="popup-btn">
                <i class="bi bi-book" style="font-size:.68rem"></i> Pinjam Sekarang
              </a>
            @else
              <span class="popup-btn-dis">
                <i class="bi bi-clock" style="font-size:.68rem"></i> Tidak Tersedia
              </span>
            @endif
          </div>

        </div> {{-- end .shelf-book --}}
        </div> {{-- end .shelf-book-wrapper --}}
        @endforeach
      </div>
      {{-- Papan rak kayu --}}
      <div class="shelf-plank">
        @include('partials.shelf-plank-extras')
      </div>
    </div>
    @endforeach
  </div>
  {{-- ══ END BOOKSHELF ══ --}}

  {{-- Series Lainnya --}}
  @php
    $seriesLain = \App\Models\Series::withCount('buku')
      ->having('buku_count', '>', 0)
      ->where('id', '!=', $series->id)
      ->with(['buku' => fn($q) =>
        $q->where('series_buku.urutan_baca', 1)
          ->select('buku.id','buku.cover','buku.judul')
      ])
      ->orderBy('nama_series')
      ->take(6)->get();
  @endphp
  @if($seriesLain->isNotEmpty())
  <div class="other">
    <div class="sec-head" style="margin-top:32px">
      <h2 class="sec-title">Series <span>Lainnya</span></h2>
      <a href="{{ route('series.index') }}"
         style="font-size:.78rem;font-weight:700;color:var(--red);display:inline-flex;align-items:center;gap:5px">
        Lihat Semua <i class="bi bi-arrow-right" style="font-size:.7rem"></i>
      </a>
    </div>
    <div class="other-grid">
      @foreach($seriesLain as $sl)
      @php $slc = $sl->buku->first(); @endphp
      <a href="{{ route('series.show', $sl->slug) }}" class="oc">
        <div class="oc-thumb">
          @if($slc && $slc->cover)
            @if(Str::startsWith($slc->cover, 'http'))
              <img src="{{ $slc->cover }}" alt="{{ $sl->nama_series }}" loading="lazy">
            @else
              <img src="{{ Storage::url($slc->cover) }}" alt="{{ $sl->nama_series }}" loading="lazy">
            @endif
          @else
            <div class="g{{ $loop->index % 8 }}"
                 style="width:100%;height:100%;display:flex;align-items:center;justify-content:center">
              <i class="bi bi-book-fill" style="color:rgba(255,255,255,.5);font-size:.85rem"></i>
            </div>
          @endif
        </div>
        <div class="oc-info">
          <div class="name">{{ $sl->nama_series }}</div>
          <div class="meta">{{ $sl->penulis }} · {{ $sl->buku_count }} buku</div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif

</div>

<div class="foot">© {{ date('Y') }} Perpustakaan Sekolah Digital · Semua hak dilindungi</div>

{{-- ══ MOBILE MODAL ══ --}}
<div id="mobileModalOverlay" class="mobile-modal-overlay">
  <div id="mobileModal" class="mobile-modal">
    <button id="modalClose" class="mobile-modal-close">✕</button>
    <div class="m-cover"></div>
    <div class="m-urutan"></div>
    <div class="m-title"></div>
    <div class="m-author"></div>
    <div class="m-stok"></div>
    <div class="m-action"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const isMobile = () => window.innerWidth <= 768;
  const overlay  = document.getElementById('mobileModalOverlay');
  const modal    = document.getElementById('mobileModal');

  document.querySelectorAll('.shelf-book').forEach(book => {
    book.addEventListener('click', function(e){
      if(!isMobile()) return;
      if(e.target.closest('a')) return;
      e.preventDefault(); e.stopPropagation();
      openModal(this);
    });
  });

  function openModal(book){
    const judul    = book.dataset.judul    || '-';
    const pengarang= book.dataset.pengarang|| '-';
    const urutan   = book.dataset.urutan   || '1';
    const stok     = parseInt(book.dataset.stok)||0;
    const cover    = book.dataset.cover    || '';
    const link     = book.dataset.link     || '';

    const coverEl = modal.querySelector('.m-cover');
    coverEl.innerHTML = cover
      ? `<img src="${cover}" alt="${judul}">`
      : `<div class="m-cover-ph"><i class="bi bi-book-fill"></i></div>`;

    modal.querySelector('.m-urutan').textContent  = `Buku #${urutan}`;
    modal.querySelector('.m-title').textContent   = judul;
    modal.querySelector('.m-author').textContent  = pengarang;

    const stokEl = modal.querySelector('.m-stok');
    stokEl.className = stok>0 ? 'm-stok stok-ada' : 'm-stok stok-habis';
    stokEl.innerHTML = stok>0
      ? `<i class="bi bi-check-circle-fill" style="font-size:.65rem"></i> ${stok} tersedia`
      : `<i class="bi bi-x-circle-fill" style="font-size:.65rem"></i> Habis`;

    const actionEl = modal.querySelector('.m-action');
    if(stok>0 && link){
      actionEl.innerHTML = `<a href="${link}" class="m-btn-pinjam"><i class="bi bi-book"></i> Pinjam Sekarang</a>`;
    } else {
      actionEl.innerHTML = `<span class="m-btn-dis"><i class="bi bi-clock"></i> Tidak Tersedia</span>`;
    }

    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal(){
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  overlay.addEventListener('click', e => { if(e.target===overlay) closeModal(); });
  document.getElementById('modalClose').addEventListener('click', closeModal);
  document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });
});
</script>

<!-- 🎨 Series page button animations -->
<style>
.popup-btn{
  position:relative;overflow:hidden;
  transition:all .25s cubic-bezier(.34,1.56,.64,1) !important;
}
.popup-btn:hover{
  transform:translateY(-2px) scale(1.05) !important;
  box-shadow:0 8px 22px rgba(237,27,59,.4) !important;
}
.popup-btn::before{
  content:'';position:absolute;top:0;left:-110%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-20deg);pointer-events:none;
}
.popup-btn:hover::before{animation:srShimmer .5s ease forwards;}
@keyframes srShimmer{0%{left:-110%}100%{left:120%}}
.popup-btn i{display:inline-block;}
.popup-btn:hover i{animation:srBookBounce .5s ease;}
@keyframes srBookBounce{
  0%{transform:translateY(0) rotate(0) scale(1)}
  25%{transform:translateY(-6px) rotate(-8deg) scale(1.2)}
  50%{transform:translateY(-3px) rotate(4deg) scale(1.1)}
  75%{transform:translateY(-5px) rotate(-5deg) scale(1.15)}
  100%{transform:translateY(0) rotate(0) scale(1)}
}
.m-btn-pinjam{
  position:relative;overflow:hidden;
  animation:srPinjamGlow 2.4s ease-in-out infinite;
  transition:all .25s cubic-bezier(.34,1.56,.64,1) !important;
}
@keyframes srPinjamGlow{
  0%,100%{box-shadow:0 4px 14px rgba(237,27,59,.28)}
  50%{box-shadow:0 8px 24px rgba(237,27,59,.52),0 0 0 4px rgba(237,27,59,.1)}
}
.m-btn-pinjam:hover{
  animation:none;transform:translateY(-3px) scale(1.04) !important;
  box-shadow:0 10px 28px rgba(237,27,59,.48) !important;
}
.m-btn-pinjam i{display:inline-block;}
.m-btn-pinjam:hover i{animation:srBookBounce .5s ease;}
.sr-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:srRipple .4s linear;pointer-events:none;}
@keyframes srRipple{to{transform:scale(4);opacity:0}}
</style>
<script>
(function(){
  document.addEventListener('click',function(e){
    const btn=e.target.closest('.popup-btn,.m-btn-pinjam');
    if(!btn) return;
    const r=document.createElement('span');r.className='sr-ripple';
    const rect=btn.getBoundingClientRect(),size=Math.max(rect.width,rect.height)*1.8;
    r.style.cssText=`width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
    if(getComputedStyle(btn).position==='static')btn.style.position='relative';
    btn.style.overflow='hidden';btn.appendChild(r);
    r.addEventListener('animationend',()=>r.remove());
  });
})();
</script>

</body>
</html>

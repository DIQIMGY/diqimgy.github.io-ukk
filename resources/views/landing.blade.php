<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perpustakaan Sekolah Digital</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700;1,800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
  --crimson:#ED1B3B;
  --crimson-dark:#C41630;
  --crimson-darker:#A01228;
  --navy:#14284B;
  --navy-dark:#0B1730;
  --navy-darker:#06101F;
  --gold:#F4B942;
  --gold-dark:#E5A623;
  --green:#16a34a;
  --bg:#FFFFFF;
  --bg-alt:#F5F7FA;
  --bg-pink:#FFF0F3;
  --white:#FFFFFF;
  --border:#E5E7EB;
  --border-light:#F3F4F6;
  --tx1:#1F2937;
  --tx2:#374151;
  --tx3:#6B7280;
  --tx4:#9CA3AF;
  --r:12px;
  --r2:8px;
  --sh:0 2px 8px rgba(237,27,59,.08),0 8px 24px rgba(237,27,59,.06);
  --sh2:0 12px 40px rgba(237,27,59,.15);
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--tx1);-webkit-font-smoothing:antialiased}
a{text-decoration:none;color:inherit}
::-webkit-scrollbar{width:5px}
::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:99px}

/* ══════════════ NAVBAR — Floating inside hero ══════════════ */
.lnav-wrap{
  /* Absolute di dalam hero — melayang di atas background */
  position:absolute;
  top:0;left:0;right:0;
  z-index:100;
  padding:16px 24px;
  pointer-events:none;
}
.lnav{
  max-width:1180px;margin:0 auto;
  /* Transparan awalnya, solid setelah scroll */
  background:rgba(15,31,61,.25);
  backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);
  border:1px solid rgba(255,255,255,.12);
  border-radius:18px;
  box-shadow:0 4px 24px rgba(0,0,0,.15);
  pointer-events:all;
  transition:background .35s,border-color .35s,box-shadow .35s;
}
/* Setelah scroll — jadi solid melayang */
.lnav.scrolled{
  position:fixed;
  top:12px;left:50%;
  transform:translateX(-50%);
  width:calc(100% - 48px);
  max-width:1180px;
  background:rgba(255,255,255,.93);
  border-color:rgba(232,236,243,.9);
  box-shadow:0 8px 32px rgba(0,0,0,.12),0 2px 6px rgba(0,0,0,.06);
}
/* Teks putih saat di atas hero (belum scroll) */
.lnav:not(.scrolled) .lnav-name{ color:#fff }
.lnav:not(.scrolled) .lnav-sub{ color:rgba(255,255,255,.45) }
.lnav:not(.scrolled) .lnav-link{ color:rgba(255,255,255,.7) }
.lnav:not(.scrolled) .lnav-link:hover{ color:#fff; background:rgba(255,255,255,.12) }
.lnav:not(.scrolled) .lnav-link.active{ color:#fff; background:rgba(255,255,255,.15); box-shadow:none }
.lnav:not(.scrolled) .lnav-links{ background:rgba(255,255,255,.1) }
.lnav:not(.scrolled) .btn-lnav-out{ border-color:rgba(255,255,255,.3); color:rgba(255,255,255,.85) }
.lnav:not(.scrolled) .btn-lnav-out:hover{ background:rgba(255,255,255,.15); color:#fff; border-color:rgba(255,255,255,.5) }

.lnav-inner{
  padding:0 20px;
  height:58px;display:flex;align-items:center;
  justify-content:space-between;gap:16px;
}
.lnav-brand{display:flex;align-items:center;gap:10px;flex-shrink:0}
.lnav-logo{
  width:38px;height:38px;border-radius:10px;
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  display:flex;align-items:center;justify-content:center;
  font-size:.95rem;color:#fff;flex-shrink:0;
  box-shadow:0 3px 10px rgba(237,27,59,.35);
}
.lnav-name{font-weight:800;font-size:.86rem;color:var(--navy);line-height:1.2;transition:color .3s}
.lnav-sub{font-size:.62rem;color:var(--tx3);font-weight:500;transition:color .3s}

/* Nav pill */
.lnav-links{
  display:flex;align-items:center;
  background:#f1f5f9;
  border-radius:12px;
  padding:4px;gap:2px;
  transition:background .3s;
}
.lnav-link{
  font-size:.8rem;font-weight:600;color:var(--tx3);
  padding:6px 14px;border-radius:9px;
  transition:all .2s;white-space:nowrap;
}
.lnav-link:hover{color:var(--navy);background:rgba(255,255,255,.7)}
.lnav-link.active{
  color:var(--crimson);background:#fff;
  box-shadow:0 1px 4px rgba(0,0,0,.1),0 2px 8px rgba(0,0,0,.06);
  font-weight:700;
}

.lnav-actions{display:flex;align-items:center;gap:8px;flex-shrink:0}
.btn-lnav-out{
  border:1.5px solid var(--border);background:transparent;
  color:var(--tx2);padding:7px 15px;border-radius:10px;
  font-size:.8rem;font-weight:600;cursor:pointer;
  transition:all .2s;display:inline-flex;align-items:center;gap:6px;
}
.btn-lnav-out:hover{border-color:var(--navy);color:var(--navy);background:var(--bg-alt)}
.btn-lnav-solid{
  background:linear-gradient(135deg,var(--navy),var(--navy-dark));
  color:#fff;padding:8px 18px;border-radius:10px;
  font-size:.8rem;font-weight:700;cursor:pointer;border:none;
  transition:all .2s;display:inline-flex;align-items:center;gap:6px;
  box-shadow:0 2px 8px rgba(20,40,75,.22);
}
.btn-lnav-solid:hover{background:linear-gradient(135deg,var(--navy-dark),var(--navy-darker));transform:translateY(-1px);box-shadow:0 5px 16px rgba(20,40,75,.28);color:#fff}
.btn-lnav-gold{
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  color:#fff;padding:8px 18px;border-radius:10px;
  font-size:.8rem;font-weight:700;cursor:pointer;border:none;
  transition:all .2s;display:inline-flex;align-items:center;gap:6px;
  box-shadow:0 2px 8px rgba(237,27,59,.3);
}
.btn-lnav-gold:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(237,27,59,.4);color:#fff}

/* ══════════════ HERO — White Panel + BG Photo ══════════════ */
.hero{
  position:relative;
  min-height:100vh;
  overflow:hidden;
  display:flex;
  flex-direction:column;
}

/* BG foto: memenuhi layar, tidak blur, berada paling belakang */
.hero-bg-photo{
  position:absolute;inset:0;z-index:0;
  background-image:url('/image/hero-bg.jpg');
  background-size:cover;
  background-position:center center;
}

/* Overlay tipis untuk kontras */
.hero-bg-overlay{
  position:absolute;inset:0;z-index:1;pointer-events:none;
  background:linear-gradient(135deg,rgba(15,31,61,.12) 0%,rgba(8,15,31,.18) 100%);
}

/* Wrapper konten */
.hero-inner{
  position:relative;z-index:10;
  flex:1;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:100px 32px 64px;
  width:100%;
}

/* ══ PANEL PUTIH SOLID ══ */
.hero-panel{
  background:#ffffff;
  border-radius:28px;
  box-shadow:
    0 32px 80px rgba(0,0,0,.22),
    0 8px 24px rgba(0,0,0,.12);
  max-width:1080px;
  width:100%;
  display:flex;
  align-items:center;
  gap:0;
  overflow:visible;
  position:relative;
  animation:panelIn .7s cubic-bezier(.22,1,.36,1) both;
}

@keyframes panelIn{
  from{opacity:0;transform:translateY(40px) scale(.96)}
  to{opacity:1;transform:translateY(0) scale(1)}
}

/* ── Sisi kiri: buku 3D ── */
.hero-books-side{
  flex:0 0 46%;
  min-height:420px;
  display:flex;
  align-items:center;
  justify-content:center;
  padding:40px 20px 40px 40px;
  position:relative;
  overflow:visible;
}

/* Buku stack 3D */
.book-stack{
  position:relative;
  width:100%;
  max-width:340px;
  display:flex;
  align-items:flex-end;
  justify-content:center;
  gap:-16px;
  filter:drop-shadow(0 24px 48px rgba(0,0,0,.35));
  animation:booksFloat 3s ease-in-out infinite;
}

@keyframes booksFloat{
  0%,100%{transform:translateY(0px)}
  50%{transform:translateY(-8px)}
}

.book-3d{
  border-radius:3px 6px 6px 3px;
  overflow:hidden;
  flex-shrink:0;
  transition:transform .35s cubic-bezier(.22,1,.36,1);
  cursor:pointer;
  position:relative;
  box-shadow:
    0 2px 4px rgba(0,0,0,.15),
    0 8px 16px rgba(0,0,0,.12);
}

.book-3d:hover{
  transform:translateY(-12px) scale(1.04) !important;
  z-index:10 !important;
  filter:brightness(1.05);
}

/* Book sizing — 3 books stacked */
.book-3d:nth-child(1){
  width:120px;
  transform:rotate(-8deg) translateY(6px);
  z-index:1;
}
.book-3d:nth-child(2){
  width:140px;
  transform:rotate(2deg) translateY(-2px);
  z-index:3;
}
.book-3d:nth-child(3){
  width:110px;
  transform:rotate(10deg) translateY(8px);
  z-index:2;
}

/* Cover image */
.book-3d-cover{
  position:relative;
  padding-top:145%;
  overflow:hidden;
  background:linear-gradient(150deg,#1e3a8a,#3b82f6);
}

.book-3d-cover img{
  position:absolute;inset:0;
  width:100%;height:100%;object-fit:cover;
}

/* Placeholder untuk buku tanpa cover */
.book-3d-ph{
  position:absolute;inset:0;
  display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  padding:12px;text-align:center;gap:6px;
}
.book-3d-ph .bph-i{font-size:2rem;opacity:.5;color:#fff}
.book-3d-ph .bph-t{
  font-size:.65rem;font-weight:700;
  color:rgba(255,255,255,.92);line-height:1.3;
  overflow:hidden;display:-webkit-box;
  -webkit-line-clamp:4;-webkit-box-orient:vertical;
}

/* Spine shadow (kiri) */
.book-3d::before{
  content:'';
  position:absolute;left:0;top:0;bottom:0;width:8px;
  background:linear-gradient(to right,rgba(0,0,0,.38),transparent);
  z-index:3;pointer-events:none;
}

/* Top edge highlight */
.book-3d::after{
  content:'';
  position:absolute;top:0;left:8px;right:0;height:2px;
  background:linear-gradient(to bottom,rgba(255,255,255,.35),transparent);
  pointer-events:none;
}

/* ── Sisi kanan: teks ── */
.hero-text-side{
  flex:1;
  padding:52px 56px 52px 40px;
  border-left:1px solid #f0f2f5;
}

.hero-eyebrow{
  display:inline-flex;align-items:center;gap:7px;
  font-size:.7rem;font-weight:800;
  text-transform:uppercase;letter-spacing:.12em;
  color:var(--crimson);
  margin-bottom:16px;
  animation:fadeUp .6s .15s both;
}

.hero-h1{
  font-family:'Playfair Display',serif;
  font-size:clamp(2rem,3.8vw,3.2rem);
  font-weight:800;color:var(--navy);
  line-height:1.15;margin-bottom:18px;
  letter-spacing:-.025em;
  animation:fadeUp .6s .25s both;
}
.hero-h1 em{
  font-style:italic;color:var(--crimson);
}

.hero-desc{
  font-size:.94rem;color:var(--tx3);
  line-height:1.8;margin-bottom:32px;
  max-width:420px;
  animation:fadeUp .6s .35s both;
}

.hero-panel-btns{
  display:flex;align-items:center;gap:14px;
  flex-wrap:wrap;margin-bottom:36px;
  animation:fadeUp .6s .45s both;
}

.btn-hp-primary{
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  color:#fff;padding:13px 28px;border-radius:11px;
  font-size:.9rem;font-weight:700;border:none;cursor:pointer;
  box-shadow:0 4px 18px rgba(237,27,59,.28);
  transition:all .25s;display:inline-flex;align-items:center;gap:9px;
}
.btn-hp-primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(237,27,59,.38);color:#fff}

.btn-hp-outline{
  background:transparent;
  border:1.5px solid var(--border);
  color:var(--tx2);padding:12px 24px;border-radius:11px;
  font-size:.9rem;font-weight:600;cursor:pointer;
  transition:all .25s;display:inline-flex;align-items:center;gap:9px;
}
.btn-hp-outline:hover{border-color:var(--crimson);color:var(--crimson);background:var(--bg-pink)}

/* Stats baris bawah */
.hero-panel-stats{
  display:flex;align-items:center;gap:24px;
  padding-top:24px;border-top:1px solid #f0f2f5;
  flex-wrap:wrap;
  animation:fadeUp .6s .55s both;
}
.hps-item{display:flex;align-items:center;gap:10px}
.hps-icon{
  width:36px;height:36px;border-radius:10px;
  display:flex;align-items:center;justify-content:center;
  font-size:.95rem;flex-shrink:0;
}
.hps-num{font-size:1.2rem;font-weight:900;color:var(--navy);line-height:1}
.hps-lbl{font-size:.7rem;color:var(--tx4);font-weight:500;margin-top:2px}
.hps-div{width:1px;height:32px;background:var(--border)}

@keyframes fadeUp{
  from{opacity:0;transform:translateY(16px)}
  to{opacity:1;transform:translateY(0)}
}

/* ══ RESPONSIVE ══ */
@media(max-width:991px){
  .hero-panel{max-width:820px}
  .hero-text-side{padding:40px 40px 40px 32px}
  .hero-books-side{padding:32px 16px 32px 32px}
  .book-stack{max-width:280px;gap:-12px}
  .book-3d:nth-child(1){width:100px}
  .book-3d:nth-child(2){width:120px}
  .book-3d:nth-child(3){width:95px}
}

@media(max-width:767px){
  .hero-inner{padding:88px 20px 52px}
  .hero-panel{
    flex-direction:column;
    border-radius:24px;
    max-width:520px;
  }
  .hero-books-side{
    flex:none;width:100%;
    min-height:240px;
    padding:36px 28px 12px;
    border-bottom:1px solid #f0f2f5;
  }
  .book-stack{
    max-width:260px;
    gap:-10px;
    margin:0 auto;
  }
  .book-3d:nth-child(1){width:85px}
  .book-3d:nth-child(2){width:105px}
  .book-3d:nth-child(3){width:80px}
  .hero-text-side{
    padding:32px 32px 36px;
    border-left:none;
  }
  .hero-h1{font-size:clamp(1.7rem,6vw,2.2rem)}
  .hero-desc{font-size:.88rem}
}

@media(max-width:480px){
  .hero-inner{padding:80px 14px 44px}
  .hero-panel{max-width:100%;border-radius:20px}
  .hero-books-side{padding:28px 20px 8px;min-height:200px}
  .book-stack{max-width:220px;gap:-8px}
  .book-3d:nth-child(1){width:72px}
  .book-3d:nth-child(2){width:90px}
  .book-3d:nth-child(3){width:68px}
  .hero-text-side{padding:26px 24px 30px}
  .hero-panel-btns{flex-direction:column;align-items:stretch;gap:10px}
  .btn-hp-primary,.btn-hp-outline{justify-content:center;padding:11px 20px}
  .hero-panel-stats{gap:16px;font-size:.88rem}
  .hps-num{font-size:1.05rem}
  .hps-icon{width:32px;height:32px}
}
/* ══════════════ SECTION BASE ══════════════ */
.lsec{padding:60px 0}
.lsec-inner{max-width:1200px;margin:0 auto;padding:0 24px}
.lsec-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:14px}
.lsec-title{
  font-family:'Playfair Display',serif;
  font-size:1.5rem;font-weight:800;color:var(--navy);
  line-height:1.2;
}
.lsec-title span{color:var(--crimson)}
.lsec-title .gold{color:var(--gold)}
.lsec-sub{font-size:.82rem;color:var(--tx3);margin-top:5px;font-weight:500}
.lsec-badge{
  display:inline-flex;align-items:center;gap:6px;
  background:var(--bg-pink);border:1px solid #FECACA;
  color:var(--crimson);font-size:.7rem;font-weight:800;
  padding:3px 10px;border-radius:99px;margin-bottom:8px;
  text-transform:uppercase;letter-spacing:.06em;
}
.lsec-badge.gold{background:#FEF3C7;border-color:#FCD34D;color:var(--gold-dark)}
.lsec-badge.blue{background:#DBEAFE;border-color:#BFDBFE;color:var(--navy)}
.lsec-badge.green{background:#f0fdf4;border-color:#bbf7d0;color:#15803d}
.see-all{
  display:inline-flex;align-items:center;gap:7px;
  font-size:.82rem;font-weight:700;color:var(--navy);
  border:1.5px solid var(--border);padding:8px 16px;
  border-radius:var(--r2);transition:all .18s;background:#fff;
  white-space:nowrap;
}
.see-all:hover{background:var(--crimson);color:#fff;border-color:var(--crimson)}

/* ══════════════ BOOK CARD ══════════════ */
.bg{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(152px,1fr));
  gap:18px;
}
.bk{
  background:#fff;border-radius:var(--r);
  border:1px solid var(--border);box-shadow:var(--sh);
  overflow:hidden;display:flex;flex-direction:column;
  transition:transform .22s,box-shadow .22s;
}
.bk:hover{transform:translateY(-5px);box-shadow:var(--sh2)}
.bk-cov{position:relative;padding-top:150%;overflow:hidden;background:#dde4ef}
.bk-cov img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .3s}
.bk:hover .bk-cov img{transform:scale(1.05)}
.bk-cov::before{content:'';position:absolute;left:0;top:0;bottom:0;width:7px;background:linear-gradient(to right,rgba(0,0,0,.26),transparent);z-index:3;pointer-events:none}
.bk-cov::after{content:'';position:absolute;bottom:0;left:0;right:0;height:54px;background:linear-gradient(transparent,rgba(0,0,0,.24));z-index:2;pointer-events:none}
.bk-ph{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:12px;text-align:center;gap:6px}
.bk-ph .pi{font-size:2rem;opacity:.65}
.bk-ph .pt{font-size:.68rem;font-weight:700;color:rgba(255,255,255,.9);line-height:1.3;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical}
.bk-ph .pa{font-size:.6rem;color:rgba(255,255,255,.55)}
.g0{background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.g1{background:linear-gradient(150deg,#581c87,#7c3aed)}
.g2{background:linear-gradient(150deg,#064e3b,#059669)}
.g3{background:linear-gradient(150deg,#78350f,#d97706)}
.g4{background:linear-gradient(150deg,#881337,#e11d48)}
.g5{background:linear-gradient(150deg,#0c4a6e,#0284c7)}
.g6{background:linear-gradient(150deg,#1f2937,#4b5563)}
.g7{background:linear-gradient(150deg,#134e4a,#0d9488)}
.bk-badge{position:absolute;top:7px;right:7px;z-index:4;font-size:.61rem;font-weight:700;padding:2px 8px;border-radius:6px;backdrop-filter:blur(8px)}
.b-ada{background:rgba(22,163,74,.85);color:#fff}
.b-habis{background:rgba(220,38,38,.85);color:#fff}
.bk-rank{position:absolute;top:7px;left:10px;z-index:4;font-size:.72rem;font-weight:900;color:var(--gold);text-shadow:0 1px 4px rgba(0,0,0,.5)}
.bk-body{padding:11px 12px 12px;flex:1;display:flex;flex-direction:column}
.bk-cat{font-size:.59rem;font-weight:800;text-transform:uppercase;letter-spacing:.07em;color:var(--crimson);margin-bottom:4px}
.bk-ttl{font-size:.83rem;font-weight:700;color:var(--tx1);line-height:1.35;margin-bottom:3px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}
.bk-ath{font-size:.72rem;color:var(--tx3);margin-bottom:9px}
.bk-foot{margin-top:auto;display:flex;align-items:center;justify-content:space-between;gap:4px}
.bk-meta{font-size:.68rem;font-weight:600;color:var(--tx3);display:flex;align-items:center;gap:3px}
.btn-bk{
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  color:#fff;border:none;padding:5px 11px;
  border-radius:var(--r2);font-size:.73rem;font-weight:700;
  cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:5px;
  white-space:nowrap;
}
.btn-bk:hover{background:var(--crimson-darker);transform:translateY(-1px);color:#fff}
.btn-bk-dis{background:#f1f5f9;color:var(--tx4);border:none;padding:5px 11px;border-radius:var(--r2);font-size:.73rem;font-weight:600;cursor:not-allowed}

/* ══════════════ SECTION DIVIDERS / BG ══════════════ */
.sec-dark{
  background:var(--navy-dark);
  position:relative;overflow:hidden;
}
.sec-dark::before{
  content:'';position:absolute;inset:0;
  /*
   * ─────────────────────────────────────────────────
   * OPSIONAL: TARUH FILE: public/image/section-bg.jpg
   * Foto subtle / pattern / texture
   * ─────────────────────────────────────────────────
   */
  background-image:url('/image/section-bg.jpg');
  background-size:cover;background-position:center;
  opacity:.07;
}
.sec-gradient{
  background:linear-gradient(135deg,#FFF0F3 0%,#F5F7FA 50%,#FFFFFF 100%);
}
.sec-cream{background:var(--bg-pink)}

/* ══════════════ STOK TERBANYAK CARD (horizontal) ══════════════ */
.stok-card{
  background:#fff;border-radius:var(--r);
  border:1px solid var(--border);box-shadow:var(--sh);
  display:flex;gap:0;overflow:hidden;
  transition:transform .22s,box-shadow .22s;
}
.stok-card:hover{transform:translateY(-3px);box-shadow:var(--sh2)}
.stok-card-cover{
  width:80px;min-width:80px;height:120px;
  position:relative;overflow:hidden;background:#dde4ef;flex-shrink:0;
}
.stok-card-cover img{width:100%;height:100%;object-fit:cover}
.stok-card-cover::before{content:'';position:absolute;left:0;top:0;bottom:0;width:5px;background:linear-gradient(to right,rgba(0,0,0,.25),transparent);z-index:2}
.stok-card-body{padding:12px 14px;flex:1;min-width:0;display:flex;flex-direction:column;justify-content:space-between}
.stok-bar-wrap{height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden;margin-top:8px}
.stok-bar{height:100%;border-radius:99px;transition:width .8s ease}

/* ══════════════ PROMO BANNER ══════════════ */
.promo-wrap{
  border-radius:20px;overflow:hidden;
  position:relative;
  background:linear-gradient(120deg,var(--navy-darker) 0%,var(--navy-dark) 45%,var(--navy) 100%);
  background-image:
  linear-gradient(
        90deg,
        rgba(10, 5, 35, 0.92) 0%,
        rgba(25, 8, 50, 0.88) 40%,
        rgba(30, 10, 50, 0.75) 75%,
        rgba(20, 5, 30, 0.85) 100%
    ),
    url('/image/promo-bg.jpg');
  background-size:cover;background-position:center;
}
.promo-glow1{position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(237,27,59,.15) 0%,transparent 70%);top:-120px;right:-80px;pointer-events:none}
.promo-glow2{position:absolute;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(244,185,66,.12) 0%,transparent 70%);bottom:-60px;left:160px;pointer-events:none}
.promo-inner{padding:44px 44px;position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:28px}

/* ══════════════ CATEGORIES ══════════════ */
.cat-grid{display:flex;gap:10px;flex-wrap:wrap}
.cat-chip{
  display:inline-flex;align-items:center;gap:8px;
  padding:9px 18px;border-radius:99px;
  font-size:.82rem;font-weight:700;
  border:1.5px solid var(--border);
  background:#fff;color:var(--tx2);
  cursor:pointer;transition:all .2s;
  box-shadow:0 1px 4px rgba(0,0,0,.04);
}
.cat-chip:hover,.cat-chip.active{background:var(--crimson);color:#fff;border-color:var(--crimson);box-shadow:0 4px 14px rgba(237,27,59,.22);transform:translateY(-1px)}

/* ══════════════ MINI BOOK LIST (terbaru) ══════════════ */
.mini-card{
  background:#fff;border-radius:var(--r);
  border:1px solid var(--border);box-shadow:var(--sh);
  display:flex;gap:0;overflow:hidden;
  transition:transform .22s,box-shadow .22s;
}
.mini-card:hover{transform:translateY(-3px);box-shadow:var(--sh2)}
.mini-cov{width:72px;flex-shrink:0;position:relative;overflow:hidden}
.mini-cov-inner{padding-top:150%;position:relative;background:#dde4ef}
.mini-cov-inner img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.mini-cov-inner::before{content:'';position:absolute;left:0;top:0;bottom:0;width:4px;background:linear-gradient(to right,rgba(0,0,0,.25),transparent);z-index:2}
.mini-body{padding:13px 15px;flex:1;min-width:0;display:flex;flex-direction:column;justify-content:space-between}

/* ══════════════ CTA ══════════════ */
.cta-sec{
  background:
    linear-gradient(
        90deg,
        rgba(10, 5, 35, 0.92) 0%,
        rgba(25, 8, 50, 0.88) 40%,
        rgba(30, 10, 50, 0.75) 75%,
        rgba(20, 5, 30, 0.85) 100%
    ),
    url('/image/cta-bg.jpg');
  background-size:cover;background-position:center;
  padding:72px 0;position:relative;overflow:hidden;
}
.cta-glow{position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(237,27,59,.12) 0%,transparent 65%);top:-200px;right:-100px;pointer-events:none}

/* ══════════════ FOOTER ══════════════ */
.lfooter{background:var(--navy-dark);border-top:1px solid rgba(255,255,255,.06);padding:52px 0 28px}
.lfooter-inner{max-width:1200px;margin:0 auto;padding:0 24px}
.footer-logo{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.footer-logo-ico{width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#fff}
.footer-logo-name{font-weight:800;font-size:.88rem;color:#fff}
.footer-desc{font-size:.82rem;color:rgba(255,255,255,.38);line-height:1.7;max-width:260px}
.footer-h{font-size:.7rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.3);margin-bottom:16px}
.footer-lnk{display:block;font-size:.82rem;color:rgba(255,255,255,.5);margin-bottom:10px;transition:color .15s}
.footer-lnk:hover{color:#fff}
.footer-bottom{border-top:1px solid rgba(255,255,255,.07);margin-top:36px;padding-top:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
.footer-copy{font-size:.77rem;color:rgba(255,255,255,.28)}
.footer-social{display:flex;gap:8px}
.footer-social a{width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,.07);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.4);font-size:.88rem;transition:all .18s}
.footer-social a:hover{background:rgba(237,27,59,.25);color:var(--crimson)}

/* ══════════════ RESPONSIVE ══════════════ */
@media(max-width:991px){
  .hero h1{font-size:2rem}
  .promo-inner{padding:30px 28px}
}
@media(max-width:767px){
  .hero{min-height:auto}
  .hero-inner{padding:90px 20px 52px}
  .lsec{padding:44px 0}
  .bg{grid-template-columns:repeat(auto-fill,minmax(138px,1fr));gap:12px}
  .lnav-wrap{padding:10px 14px}
}
@media(max-width:575px){
  .bg{grid-template-columns:repeat(2,1fr);gap:10px}
  .lnav-links{display:none !important}
  .hero h1{font-size:1.8rem}
  .hero-stats{gap:18px}
  .lnav-wrap{padding:8px 12px}
}
</style>
</head>
<body>

{{-- ══ NAVBAR — Floating Pill ══ --}}
<div class="lnav-wrap" id="lnavWrap">
  <header class="lnav" id="lnav">
    <div class="lnav-inner">
      {{-- Brand --}}
      <div class="lnav-brand">
        <div class="lnav-logo"><i class="bi bi-book-half"></i></div>
        <div>
          <div class="lnav-name">Perpustakaan Sekolah Digital</div>
          <div class="lnav-sub">Library Management System</div>
        </div>
      </div>

      {{-- Pill Nav --}}
      <nav class="lnav-links d-none d-lg-flex">
        <a href="{{ route('landing') }}" class="lnav-link active" id="nl-home">Beranda</a>
        <a href="#populer"  class="lnav-link" id="nl-pop">Populer</a>
        <a href="#terbaru"  class="lnav-link" id="nl-new">Terbaru</a>
        <a href="#stok"     class="lnav-link" id="nl-stok">Stok</a>
        <a href="#kategori" class="lnav-link" id="nl-kat">Kategori</a>
      </nav>

      {{-- Actions --}}
      <div class="lnav-actions">
        @auth
          @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn-lnav-solid">
              <i class="bi bi-grid-1x2-fill"></i>
              <span class="d-none d-sm-inline">Dashboard</span>
            </a>
          @else
            <a href="{{ route('siswa.dashboard') }}" class="btn-lnav-solid">
              <i class="bi bi-grid-1x2-fill"></i>
              <span class="d-none d-sm-inline">Dashboard</span>
            </a>
          @endif
        @else
          <a href="{{ route('login') }}" class="btn-lnav-out d-none d-sm-flex">
            <i class="bi bi-box-arrow-in-right"></i> Masuk
          </a>
          <a href="{{ route('register') }}" class="btn-lnav-gold">
            <i class="bi bi-person-plus-fill"></i>
            <span class="d-none d-sm-inline">Daftar Gratis</span>
            <span class="d-sm-none">Daftar</span>
          </a>
        @endauth
        {{-- Mobile menu toggle --}}
        <button class="d-lg-none btn-lnav-out" id="mobileMenuBtn" style="padding:7px 10px;border-radius:10px" onclick="toggleMobileMenu()">
          <i class="bi bi-list" style="font-size:1.1rem"></i>
        </button>
      </div>
    </div>

    {{-- Mobile menu dropdown --}}
    <div id="mobileMenu" style="display:none;padding:8px 16px 14px;border-top:1px solid var(--border)">
      @foreach(['Beranda'=>route('landing'),'Populer'=>'#populer','Terbaru'=>'#terbaru','Stok Terbanyak'=>'#stok','Kategori'=>'#kategori'] as $label=>$href)
      <a href="{{ $href }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:9px;font-size:.84rem;font-weight:600;color:var(--tx2);transition:background .15s"
         onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background=''" onclick="document.getElementById('mobileMenu').style.display='none'">
        {{ $label }}
      </a>
      @endforeach
    </div>
  </header>
</div>

{{-- ══ HERO — White Panel Premium ══ --}}
<section class="hero">
  {{-- Background foto perpustakaan — tampak jelas di sekeliling panel --}}
  <div class="hero-bg-photo"></div>
  {{-- Overlay tipis untuk kontras --}}
  <div class="hero-bg-overlay"></div>

  {{-- Konten utama --}}
  <div class="hero-inner">
    {{-- ══ PANEL PUTIH SOLID ══ --}}
    <div class="hero-panel">
      
      {{-- ── SISI KIRI: Buku 3D ── --}}
      <div class="hero-books-side">
        <div class="book-stack">
          @php
            // Ambil 3 buku pertama dari bukuPopuler untuk ditampilkan sebagai 3D mockup
            $heroBuku = $bukuPopuler->take(3);
            
            // Jika tidak ada buku, buat placeholder
            if($heroBuku->count() === 0) {
              $heroBuku = collect([
                (object)['judul' => 'Koleksi Buku Premium', 'cover' => null],
                (object)['judul' => 'Perpustakaan Digital', 'cover' => null],
                (object)['judul' => 'Buku Terbaik', 'cover' => null],
              ]);
            }
            
            $bookGradients = [
              'linear-gradient(150deg,#1e3a8a,#3b82f6)',
              'linear-gradient(150deg,#7c2d12,#ea580c)',
              'linear-gradient(150deg,#064e3b,#10b981)'
            ];
          @endphp
          
          @foreach($heroBuku as $idx => $hb)
          <div class="book-3d">
            <div class="book-3d-cover" style="background:{{ $bookGradients[$idx] }}">
              @if(isset($hb->cover) && $hb->cover)
                <img src="{{ Storage::url($hb->cover) }}" alt="{{ $hb->judul }}" loading="lazy">
              @else
                <div class="book-3d-ph">
                  <span class="bph-i"><i class="bi bi-book-fill"></i></span>
                  <span class="bph-t">{{ $hb->judul }}</span>
                </div>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- ── SISI KANAN: Konten Teks ── --}}
      <div class="hero-text-side">
        {{-- Eyebrow badge --}}
        <div class="hero-eyebrow">
          <i class="bi bi-stars"></i>
          Perpustakaan Digital
        </div>

        {{-- Judul utama --}}
        <h1 class="hero-h1">
          Temukan Cerita<br>
          <em>Favoritmu</em>
        </h1>

        {{-- Deskripsi --}}
        <p class="hero-desc">
          Jelajahi koleksi buku terbaik perpustakaan sekolah. 
          Pinjam buku secara digital dengan mudah, kapan saja dan di mana saja.
        </p>

        {{-- CTA Buttons --}}
        <div class="hero-panel-btns">
          <a href="{{ route('register') }}" class="btn-hp-primary">
            <i class="bi bi-book-fill"></i>
            Jelajahi Buku
          </a>
          <a href="{{ route('login') }}" class="btn-hp-outline">
            <i class="bi bi-box-arrow-in-right"></i>
            Masuk
          </a>
        </div>

        {{-- Stats --}}
        <div class="hero-panel-stats">
          <div class="hps-item">
            <div class="hps-icon" style="background:#FEF2F2;color:var(--crimson)">
              <i class="bi bi-book-fill"></i>
            </div>
            <div>
              <div class="hps-num scp-num">{{ $totalBuku }}+</div>
              <div class="hps-lbl">Judul Buku</div>
            </div>
          </div>
          
          <div class="hps-div"></div>
          
          <div class="hps-item">
            <div class="hps-icon" style="background:#F0FDF4;color:#16a34a">
              <i class="bi bi-box-seam-fill"></i>
            </div>
            <div>
              <div class="hps-num scp-num">{{ $totalStok }}+</div>
              <div class="hps-lbl">Stok Tersedia</div>
            </div>
          </div>
          
          <div class="hps-div"></div>
          
          <div class="hps-item">
            <div class="hps-icon" style="background:#FEF3C7;color:var(--gold-dark)">
              <i class="bi bi-grid-fill"></i>
            </div>
            <div>
              <div class="hps-num scp-num">{{ $kategoris->count() }}</div>
              <div class="hps-lbl">Kategori</div>
            </div>
          </div>
        </div>
      </div>
      {{-- /SISI KANAN --}}

    </div>
    {{-- /PANEL PUTIH --}}
  </div>
</section>


{{-- ══ POPULER ══ --}}
<section class="lsec" id="populer" style="background:#fff">
  <div class="lsec-inner">
    <div class="lsec-header">
      <div>
        <div class="lsec-badge"><i class="bi bi-fire"></i> Paling Diminati</div>
        <h2 class="lsec-title">Buku <span>Populer</span></h2>
        <p class="lsec-sub">Koleksi paling banyak dipinjam oleh siswa</p>
      </div>
      <a href="{{ route('register') }}" class="see-all">Mulai Pinjam <i class="bi bi-arrow-right"></i></a>
    </div>
    @if($bukuPopuler->isEmpty())
    <div style="text-align:center;padding:48px;color:var(--tx4)">
      <i class="bi bi-book" style="font-size:3rem;opacity:.2;display:block;margin-bottom:12px"></i>
      <p>Belum ada data buku populer.</p>
    </div>
    @else
    <div class="bg">
      @foreach($bukuPopuler as $i => $b)
      <div class="bk">
        <div class="bk-cov">
          @if($b->cover)<img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}">
          @else<div class="bk-ph g{{ $i%8 }}"><span class="pi"><i class="bi bi-book-fill"></i></span><span class="pt">{{ $b->judul }}</span><span class="pa">{{ $b->pengarang }}</span></div>@endif
          @if($i===0)<div class="bk-rank">🔥 #1</div>
          @elseif($i<3)<div class="bk-rank" style="color:rgba(255,255,255,.7)">✦ #{{ $i+1 }}</div>@endif
          <span class="bk-badge {{ $b->stok>0?'b-ada':'b-habis' }}">{{ $b->stok>0?$b->stok.' stok':'Habis' }}</span>
        </div>
        <div class="bk-body">
          <div class="bk-cat">{{ $b->kategori }}</div>
          <div class="bk-ttl">{{ $b->judul }}</div>
          <div class="bk-ath"><i class="bi bi-person" style="font-size:.65rem"></i> {{ $b->pengarang }}</div>
          <div class="bk-foot">
            <span class="bk-meta"><i class="bi bi-download" style="font-size:.65rem"></i>{{ $b->peminjaman_count }}x</span>
            @if($b->stok>0)<a href="{{ route('register') }}" class="btn-bk"><i class="bi bi-book"></i>Pinjam</a>
            @else<span class="btn-bk-dis">Habis</span>@endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- ══ PROMO BANNER ══ --}}
<section class="lsec sec-cream" style="padding:0 0 60px">
  <div class="lsec-inner">
    <div class="promo-wrap">
      <div class="promo-glow1"></div>
      <div class="promo-glow2"></div>
      <div class="promo-inner">
        {{-- Books stacked --}}
        @if($bukuPopuler->count() >= 3)
        <div style="display:flex;align-items:flex-end;gap:8px;filter:drop-shadow(0 16px 32px rgba(0,0,0,.4));position:relative;z-index:1">
          @foreach($bukuPopuler->take(3) as $pi => $pb)
          @php $pr=['-7deg','0deg','6deg'];$pt=['translateY(8px)','translateY(-4px)','translateY(10px)'];@endphp
          <div style="width:72px;height:108px;border-radius:8px;overflow:hidden;transform:rotate({{ $pr[$pi] }}) {{ $pt[$pi] }};box-shadow:0 10px 28px rgba(0,0,0,.38);border:1px solid rgba(255,255,255,.1)">
            @if($pb->cover)<img src="{{ Storage::url($pb->cover) }}" style="width:100%;height:100%;object-fit:cover">
            @else<div style="width:100%;height:100%;background:linear-gradient(150deg,{{ ['#0f1f3d,#1e4080','#3b0764,#6d28d9','#064e3b,#059669'][$pi] }});display:flex;align-items:center;justify-content:center"><i class="bi bi-book-fill" style="color:rgba(255,255,255,.4);font-size:1.5rem"></i></div>@endif
          </div>
          @endforeach
        </div>
        @endif
        {{-- Text --}}
        <div style="flex:1;position:relative;z-index:1">
          <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(237,27,59,.15);border:1px solid rgba(237,27,59,.3);color:var(--crimson);font-size:.72rem;font-weight:800;padding:4px 12px;border-radius:99px;margin-bottom:14px;letter-spacing:.04em">
            <i class="bi bi-megaphone-fill"></i> Perpustakaan Digital
          </div>
          <h3 style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:8px;line-height:1.2">
            Pinjam Buku <span style="color:var(--gold)">Gratis</span>,<br>Kapan Saja!
          </h3>
          <p style="color:rgba(255,255,255,.85);font-size:.84rem;line-height:1.65;margin-bottom:20px;max-width:380px">
            Daftar sebagai anggota perpustakaan dan nikmati akses ke seluruh koleksi buku sekolah secara digital.
          </p>
          <div style="display:flex;gap:12px;flex-wrap:wrap">
            <a href="{{ route('register') }}" style="background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));color:#fff;padding:12px 24px;border-radius:var(--r2);font-size:.88rem;font-weight:700;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 16px rgba(237,27,59,.35);transition:all .2s"
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(237,27,59,.45)'"
               onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(237,27,59,.35)'">
              <i class="bi bi-person-plus-fill"></i> Daftar Gratis
            </a>
            <a href="{{ route('login') }}" style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.4);color:#fff;padding:12px 22px;border-radius:var(--r2);font-size:.88rem;font-weight:600;display:inline-flex;align-items:center;gap:8px;transition:all .2s"
               onmouseover="this.style.background='rgba(255,255,255,.25)';this.style.borderColor='rgba(255,255,255,.6)';this.style.color='#fff'"
               onmouseout="this.style.background='rgba(255,255,255,.15)';this.style.borderColor='rgba(255,255,255,.4)';this.style.color='#fff'">
              <i class="bi bi-box-arrow-in-right"></i> Masuk
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ══ TERBARU ══ --}}
<section class="lsec" id="terbaru" style="background:linear-gradient(135deg,#f0f4ff 0%,#f8f9fc 50%,#f0fdf4 100%)">
  <div class="lsec-inner">
    <div class="lsec-header">
      <div>
        <div class="lsec-badge gold"><i class="bi bi-stars"></i> Baru Ditambahkan</div>
        <h2 class="lsec-title">Buku <span class="gold" style="color:var(--gold2)">Terbaru</span></h2>
        <p class="lsec-sub">Koleksi buku yang baru masuk ke perpustakaan</p>
      </div>
      <a href="{{ route('register') }}" class="see-all">Lihat Semua <i class="bi bi-arrow-right"></i></a>
    </div>
    @if($bukuTerbaru->isEmpty())
    <p style="color:var(--tx4);text-align:center;padding:32px">Belum ada buku terbaru.</p>
    @else
    <div class="row g-3">
      @foreach($bukuTerbaru as $ti => $tb)
      <div class="col-sm-6 col-xl-3">
        <div class="mini-card">
          <div class="mini-cov">
            <div class="mini-cov-inner">
              @if($tb->cover)<img src="{{ Storage::url($tb->cover) }}" alt="{{ $tb->judul }}">
              @else<div class="bk-ph g{{ $ti%8 }}" style="position:absolute;inset:0;padding:8px"><span class="pi" style="font-size:1.3rem"><i class="bi bi-book-fill"></i></span><span class="pt" style="font-size:.58rem">{{ $tb->judul }}</span></div>@endif
            </div>
          </div>
          <div class="mini-body">
            <div>
              <div class="bk-cat" style="margin-bottom:5px">{{ $tb->kategori }}</div>
              <div style="font-size:.85rem;font-weight:700;color:var(--tx1);line-height:1.3;margin-bottom:4px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $tb->judul }}</div>
              <div style="font-size:.74rem;color:var(--tx3)">{{ $tb->pengarang }}</div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:12px;padding-top:10px;border-top:1px solid var(--border)">
              <span style="font-size:.7rem;font-weight:700;padding:3px 9px;border-radius:6px;{{ $tb->stok>0?'background:#dcfce7;color:#16a34a':'background:#fee2e2;color:#dc2626' }}">
                {{ $tb->stok>0 ? $tb->stok.' stok' : 'Habis' }}
              </span>
              <a href="{{ route('register') }}" style="font-size:.77rem;font-weight:700;color:var(--navy2);display:flex;align-items:center;gap:4px">
                Pinjam <i class="bi bi-arrow-right" style="font-size:.72rem"></i>
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

{{-- ══ STOK TERBANYAK ══ --}}
<section class="lsec sec-cream" id="stok">
  <div class="lsec-inner">
    <div class="lsec-header">
      <div>
        <div class="lsec-badge green"><i class="bi bi-check-circle-fill"></i> Banyak Tersedia</div>
        <h2 class="lsec-title">Stok <span class="gold" style="color:var(--green)">Terbanyak</span></h2>
        <p class="lsec-sub">Buku dengan ketersediaan stok paling banyak</p>
      </div>
      <a href="{{ route('register') }}" class="see-all">Pinjam Sekarang <i class="bi bi-arrow-right"></i></a>
    </div>
    @if($bukuStokTerbanyak->isEmpty())
    <p style="text-align:center;padding:32px;color:var(--tx4)">Belum ada data.</p>
    @else
    @php $maxStok = max($bukuStokTerbanyak->first()->stok, 1); @endphp
    <div class="row g-3">
      @foreach($bukuStokTerbanyak as $si => $sb)
      @php
        $pct    = round($sb->stok / $maxStok * 100);
        $colors = ['#2563eb','#7c3aed','#059669','#d97706'];
        $bcol   = $colors[$si % count($colors)];
        $bgrad  = ['#0f1f3d,#1e4080','#3b0764,#6d28d9','#064e3b,#059669','#78350f,#d97706'];
      @endphp
      <div class="col-sm-6 col-lg-3">
        <div class="bk" style="height:100%">
          <div class="bk-cov">
            @if($sb->cover)<img src="{{ Storage::url($sb->cover) }}" alt="{{ $sb->judul }}">
            @else<div class="bk-ph g{{ $si%8 }}"><span class="pi"><i class="bi bi-book-fill"></i></span><span class="pt">{{ $sb->judul }}</span><span class="pa">{{ $sb->pengarang }}</span></div>@endif
            <span class="bk-badge b-ada" style="font-size:.68rem;padding:3px 9px">
              <i class="bi bi-boxes" style="font-size:.65rem"></i> {{ $sb->stok }} stok
            </span>
          </div>
          <div class="bk-body">
            <div class="bk-cat">{{ $sb->kategori }}</div>
            <div class="bk-ttl">{{ $sb->judul }}</div>
            <div class="bk-ath"><i class="bi bi-person" style="font-size:.65rem"></i> {{ $sb->pengarang }}</div>
            {{-- Stok bar --}}
            <div style="margin-bottom:10px">
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px">
                <span style="font-size:.67rem;font-weight:600;color:var(--tx3)">Ketersediaan</span>
                <span style="font-size:.7rem;font-weight:800;color:{{ $bcol }}">{{ $sb->stok }} buku</span>
              </div>
              <div class="stok-bar-wrap">
                <div class="stok-bar" style="width:{{ $pct }}%;background:{{ $bcol }}"></div>
              </div>
            </div>
            <div class="bk-foot">
              <span class="bk-meta"><i class="bi bi-box-seam" style="font-size:.65rem"></i>{{ $sb->penerbit }}</span>
              <a href="{{ route('register') }}" class="btn-bk"><i class="bi bi-book"></i>Pinjam</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- ══ KATEGORI ══ --}}
<section class="lsec" id="kategori" style="background:#fff">
  <div class="lsec-inner">
    <div class="lsec-header">
      <div>
        <div class="lsec-badge blue"><i class="bi bi-grid-fill"></i> Jelajahi</div>
        <h2 class="lsec-title">Semua <span style="color:var(--blue)">Kategori</span></h2>
        <p class="lsec-sub">Temukan buku sesuai minat kamu</p>
      </div>
    </div>
    <div class="cat-grid">
      @php
      $catIcons=['Pemrograman'=>'bi-code-slash','Framework'=>'bi-layers-fill','Database'=>'bi-database-fill','Jaringan'=>'bi-diagram-3-fill','AI'=>'bi-cpu-fill','Desain'=>'bi-palette-fill','Sistem Operasi'=>'bi-terminal-fill','Matematika'=>'bi-calculator-fill','Fisika'=>'bi-lightning-fill','Bahasa'=>'bi-translate','Sejarah'=>'bi-hourglass-split','Sastra'=>'bi-journal-text','kartun'=>'bi-brush-fill','fantasi'=>'bi-stars','misteri'=>'bi-search-heart'];
      @endphp
      @foreach($kategoris as $kat)
      <a href="{{ route('register') }}" class="cat-chip">
        <i class="bi {{ $catIcons[$kat]??'bi-book-fill' }}" style="color:var(--blue)"></i>
        {{ $kat }}
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- ══ CTA ══ --}}
<section class="cta-sec">
  {{--
    TARUH FILE: public/image/cta-bg.jpg
    Foto berbeda dari hero — bisa foto buku terbuka, suasana membaca,
    atau ilustrasi perpustakaan dengan tone gelap. Ukuran ideal: 1920x600px
  --}}
  <div class="cta-glow"></div>
  <div style="max-width:680px;margin:0 auto;padding:0 24px;text-align:center;position:relative;z-index:1">
    <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(237,27,59,.16);border:1px solid rgba(237,27,59,.32);color:var(--crimson);font-size:.74rem;font-weight:700;padding:5px 14px;border-radius:99px;margin-bottom:20px;letter-spacing:.03em">
      <i class="bi bi-person-check-fill"></i> Bergabung Sekarang — Gratis!
    </div>
    <h2 style="font-family:'Playfair Display',serif;font-size:clamp(1.7rem,4vw,2.7rem);font-weight:800;color:#fff;margin-bottom:14px;letter-spacing:-.02em;line-height:1.15">
      Mulai Pinjam Buku<br><em style="color:var(--crimson);font-style:italic">Hari Ini</em>
    </h2>
    <p style="font-size:.93rem;color:rgba(255,255,255,.85);margin-bottom:32px;line-height:1.75">
      Daftar gratis sebagai anggota perpustakaan dan nikmati kemudahan pinjam buku digital kapan saja.
    </p>
    <div style="display:flex;align-items:center;justify-content:center;gap:14px;flex-wrap:wrap">
      <a href="{{ route('register') }}" class="btn-hero-gold">
        <i class="bi bi-person-plus-fill"></i> Daftar Gratis Sekarang
      </a>
      <a href="{{ route('login') }}" class="btn-hero-ghost">
        <i class="bi bi-box-arrow-in-right"></i> Sudah punya akun?
      </a>
    </div>
  </div>
</section>

{{-- ══ FOOTER ══ --}}
<footer class="lfooter">
  <div class="lfooter-inner">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="footer-logo">
          <div class="footer-logo-ico"><i class="bi bi-book-half"></i></div>
          <div class="footer-logo-name">Perpustakaan Sekolah Digital</div>
        </div>
        <p class="footer-desc">Platform peminjaman buku digital untuk seluruh warga sekolah. Mudah, cepat, dan gratis untuk semua siswa.</p>
        <div class="footer-social" style="margin-top:16px">
          @foreach(['bi-instagram','bi-twitter-x','bi-facebook','bi-youtube'] as $ic)
          <a href="#"><i class="bi {{ $ic }}"></i></a>
          @endforeach
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-6">
        <p class="footer-h">Navigasi</p>
        <a href="{{ route('landing') }}" class="footer-lnk">Beranda</a>
        <a href="#populer" class="footer-lnk">Buku Populer</a>
        <a href="#terbaru" class="footer-lnk">Buku Terbaru</a>
        <a href="#stok" class="footer-lnk">Stok Terbanyak</a>
        <a href="#kategori" class="footer-lnk">Kategori</a>
      </div>
      <div class="col-lg-2 col-md-3 col-6">
        <p class="footer-h">Akun</p>
        <a href="{{ route('login') }}" class="footer-lnk">Masuk</a>
        <a href="{{ route('register') }}" class="footer-lnk">Daftar</a>
        @auth
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('siswa.dashboard') }}" class="footer-lnk">Dashboard</a>
        @endauth
      </div>
      <div class="col-lg-4 col-md-6">
        <p class="footer-h">Tentang</p>
        <p style="font-size:.82rem;color:rgba(255,255,255,.38);line-height:1.75">
          Sistem informasi perpustakaan berbasis web untuk memudahkan pengelolaan dan peminjaman buku secara digital bagi seluruh warga sekolah.
        </p>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="footer-copy">© {{ date('Y') }} Perpustakaan Sekolah Digital. All rights reserved.</span>
      <span class="footer-copy">Powered by Laravel {{ app()->version() }}</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ── Smooth scroll ── */
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    const id=a.getAttribute('href');
    if(id.length>1){
      const t=document.querySelector(id);
      if(t){
        e.preventDefault();
        // offset for floating navbar height (~82px)
        const y=t.getBoundingClientRect().top+window.pageYOffset-90;
        window.scrollTo({top:y,behavior:'smooth'});
      }
    }
  });
});

/* ── Navbar scroll effect ── */
const lnav=document.getElementById('lnav');
window.addEventListener('scroll',()=>{
  if(window.scrollY>60){lnav.classList.add('scrolled');}
  else{lnav.classList.remove('scrolled');}
},{ passive:true });

/* ── Active nav link on scroll ── */
const sections=document.querySelectorAll('section[id],div[id]');
const links={
  'populer' :document.getElementById('nl-pop'),
  'terbaru' :document.getElementById('nl-new'),
  'stok'    :document.getElementById('nl-stok'),
  'kategori':document.getElementById('nl-kat'),
};
const homeLink=document.getElementById('nl-home');
window.addEventListener('scroll',()=>{
  let cur='';
  sections.forEach(s=>{
    if(s.id&&window.scrollY>=s.offsetTop-120) cur=s.id;
  });
  // reset all
  Object.values(links).forEach(l=>{ if(l) l.classList.remove('active'); });
  if(homeLink) homeLink.classList.remove('active');
  // set active
  if(links[cur]) links[cur].classList.add('active');
  else if(homeLink) homeLink.classList.add('active');
},{ passive:true });

/* ── Mobile menu toggle ── */
function toggleMobileMenu(){
  const m=document.getElementById('mobileMenu');
  m.style.display=m.style.display==='none'?'block':'none';
}
// close mobile menu on outside click
document.addEventListener('click',e=>{
  const btn=document.getElementById('mobileMenuBtn');
  const menu=document.getElementById('mobileMenu');
  if(btn&&menu&&!btn.contains(e.target)&&!menu.contains(e.target)){
    menu.style.display='none';
  }
});

/* ── Number counter animation ── */
function animateCounter(el,target,suffix=''){
  const isNum=!isNaN(parseInt(target));
  if(!isNum){return;}
  const num=parseInt(target);
  const dur=1200;
  const step=Math.ceil(num/60);
  let cur=0;
  const timer=setInterval(()=>{
    cur+=step;
    if(cur>=num){cur=num;clearInterval(timer);}
    el.textContent=cur+(suffix||'');
  },dur/60);
}
// trigger on first view
const statNums=document.querySelectorAll('.scp-num');
const observer=new IntersectionObserver((entries)=>{
  entries.forEach(en=>{
    if(en.isIntersecting){
      const el=en.target;
      const raw=el.textContent.trim();
      const suffix=raw.includes('+')?'+':'';
      const num=raw.replace(/[^0-9]/g,'');
      if(num) animateCounter(el,num,suffix);
      observer.unobserve(el);
    }
  });
},{threshold:.3});
statNums.forEach(n=>observer.observe(n));
</script>
</body>
</html>

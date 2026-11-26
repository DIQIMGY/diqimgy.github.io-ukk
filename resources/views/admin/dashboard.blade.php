@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard Admin')
@section('content')
{{--
  VIEW: admin/dashboard.blade.php
  FUNGSI: Halaman dashboard admin — overview perpustakaan & manajemen cepat
  REDESIGNED: Modern, mature, responsive — inspired by siswa dashboard
  
  VARIABEL DARI Admin\DashboardController::index():
    $totalBuku          → jumlah total buku di database
    $totalAnggota       → jumlah total anggota
    $totalPeminjaman    → jumlah total peminjaman
    $totalPending       → jumlah peminjaman pending
    $totalPendingKembali → jumlah pengajuan pengembalian menunggu konfirmasi
    $totalDendaBelumLunas → jumlah denda yang belum dibayar
    $totalDipinjam      → jumlah peminjaman aktif (dipinjam)
    $totalTerlambat     → jumlah peminjaman terlambat
    $totalDikembalikan  → jumlah peminjaman selesai
    $peminjamanTerbaru  → Collection 10 transaksi terbaru (with anggota, buku)
    $bukuPopuler        → Collection 8 buku populer (with peminjaman_count)
--}}

@php
  $hour = (int) date('H');
  $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
  $total = $totalDipinjam + $totalDikembalikan + ($totalTerlambat ?? 0);
  $returnRate = $total > 0 ? round(($totalDikembalikan / $total) * 100) : 0;
@endphp

<style>
/* ══ ADMIN DASHBOARD — PREMIUM REDESIGN ══ */
.adm-wrap{display:flex;flex-direction:column;gap:24px}

/* ── Hero Banner ── */
.adm-hero{
  position:relative;overflow:hidden;isolation:isolate;
  border-radius:18px;padding:32px 36px;
  background:
    linear-gradient(135deg,rgba(15,23,42,.96) 0%,rgba(30,41,59,.92) 45%,rgba(237,27,59,.65) 100%),
    url('/image/wood-bg.jpg') center/cover;
  color:#fff;
  box-shadow:0 18px 48px rgba(15,23,42,.32);
  display:grid;grid-template-columns:1.5fr 1fr;gap:28px;align-items:center;
}
.adm-hero::before{
  content:'';position:absolute;inset:0;z-index:0;
  background:
    radial-gradient(ellipse at 85% 15%,rgba(244,185,66,.22),transparent 50%),
    radial-gradient(ellipse at 20% 80%,rgba(59,130,246,.15),transparent 55%);
  pointer-events:none;animation:admHeroGlow 12s ease-in-out infinite;
}
@keyframes admHeroGlow{
  0%,100%{opacity:1}
  50%{opacity:.7}
}
.adm-hero>*{position:relative;z-index:1}
.adm-kicker{
  display:inline-flex;align-items:center;gap:9px;
  font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;
  color:rgba(255,255,255,.7);margin-bottom:12px;
}
.adm-kicker .dot{width:7px;height:7px;border-radius:50%;background:var(--gold-400);box-shadow:0 0 0 5px rgba(244,185,66,.24);animation:kickerPulse 2s ease infinite}
@keyframes kickerPulse{0%,100%{transform:scale(1)}50%{transform:scale(1.15)}}
.adm-hero h1{
  font-family:'Playfair Display',serif;font-size:clamp(1.6rem,2.4vw,2.2rem);
  font-weight:900;line-height:1.1;margin:0 0 12px;letter-spacing:-.025em;
  text-shadow:0 2px 12px rgba(0,0,0,.2);
}
.adm-hero p{margin:0;color:rgba(255,255,255,.72);font-size:.9rem;line-height:1.6;max-width:42ch}
.adm-hero-actions{display:flex;flex-wrap:wrap;gap:11px;margin-top:20px}
.adm-btn{
  display:inline-flex;align-items:center;gap:9px;
  padding:11px 18px;border-radius:11px;font-size:.84rem;font-weight:700;
  text-decoration:none;transition:all .25s cubic-bezier(.34,1.56,.64,1);
  border:1px solid transparent;position:relative;overflow:hidden;
}
.adm-btn::before{
  content:'';position:absolute;inset:0;opacity:0;
  background:linear-gradient(110deg,transparent,rgba(255,255,255,.2),transparent);
  transition:opacity .3s;
}
.adm-btn:hover::before{opacity:1;animation:admShimmer .6s ease}
@keyframes admShimmer{from{transform:translateX(-100%)}to{transform:translateX(100%)}}
.adm-btn-primary{background:var(--crimson);color:#fff;box-shadow:0 4px 14px rgba(237,27,59,.35)}
.adm-btn-primary:hover{background:var(--crimson-dark);color:#fff;transform:translateY(-2px);box-shadow:0 8px 20px rgba(237,27,59,.45)}
.adm-btn-ghost{background:rgba(255,255,255,.11);color:#fff;border-color:rgba(255,255,255,.2);backdrop-filter:blur(8px)}
.adm-btn-ghost:hover{background:rgba(255,255,255,.2);color:#fff;border-color:rgba(255,255,255,.3)}
.adm-hero-right{display:flex;align-items:center;justify-content:center}
.adm-hero-icon{
  width:96px;height:96px;border-radius:20px;
  background:rgba(255,255,255,.14);backdrop-filter:blur(16px);
  border:1px solid rgba(255,255,255,.22);
  display:grid;place-items:center;font-size:2.6rem;color:#fff;
  box-shadow:0 12px 32px rgba(0,0,0,.25),inset 0 1px 0 rgba(255,255,255,.2);
  transition:transform .4s cubic-bezier(.34,1.56,.64,1);
}
.adm-hero-icon:hover{transform:scale(1.08) rotate(-3deg)}
.adm-hero-icon i{animation:admIconFloat 4s ease-in-out infinite}
@keyframes admIconFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}

/* ── Hero Top 5 Buku Populer ── */
.adm-hero-right{min-width:0;width:100%}
.adm-popular-showcase{
  width:100%;max-width:440px;padding:14px;
  border:1px solid rgba(255,255,255,.2);border-radius:16px;
  background:rgba(15,23,42,.38);box-shadow:0 12px 36px rgba(0,0,0,.3);
  backdrop-filter:blur(10px)
}
.adm-popular-heading{
  display:flex;align-items:center;gap:8px;margin:0 0 12px;
  color:#fff;font-size:.78rem;font-weight:800;letter-spacing:.02em
}
.adm-popular-heading i{color:var(--gold-400);font-size:.95rem}
.adm-popular-stack{
  position:relative;isolation:isolate;width:100%;max-width:360px;height:184px;
  margin:0 auto;overflow:visible
}
.adm-popular-card{
  position:absolute;top:20px;left:calc(50% + var(--fan-offset));display:block;width:88px;height:132px;
  padding:0;overflow:visible;border:1px solid rgba(255,255,255,.4);
  border-radius:7px;background:#17243a;color:#fff;text-decoration:none;
  box-shadow:0 9px 20px rgba(0,0,0,.38),0 2px 5px rgba(0,0,0,.24);
  transform:translateX(-50%) rotate(var(--fan-angle));
  transform-origin:50% 85%;z-index:var(--fan-depth);
  transition:transform .24s ease,box-shadow .24s ease,border-color .24s ease
}
.adm-popular-card-featured{top:5px;width:108px;height:162px}
.adm-popular-card-right .adm-popular-rank{left:auto;right:5px}
.adm-popular-card:hover,.adm-popular-card:focus-visible{
  z-index:10;color:#fff;border-color:var(--gold-400);
  box-shadow:0 14px 28px rgba(0,0,0,.48),0 0 0 2px rgba(244,185,66,.24);
  transform:translateX(-50%) translateY(-8px)
    rotate(var(--fan-angle)) scale(1.05)
}
.adm-popular-card:focus-visible{outline:2px solid var(--gold-400);outline-offset:3px}
.adm-popular-cover{
  position:relative;width:100%;height:100%;overflow:hidden;border-radius:6px;
  background:linear-gradient(150deg,#20385e,#111827)
}
.adm-popular-cover img{display:block;width:100%;height:100%;object-fit:cover}
.adm-popular-placeholder{
  display:grid;width:100%;height:100%;place-items:center;
  color:rgba(255,255,255,.58);font-size:1.25rem
}
.adm-popular-rank{
  position:absolute;top:5px;left:5px;display:grid;min-width:22px;height:22px;
  padding:0 4px;place-items:center;border:1px solid rgba(255,255,255,.55);
  border-radius:6px;background:var(--gold-400);color:#1e293b;
  font-size:.65rem;font-weight:900;line-height:1;box-shadow:0 2px 6px rgba(0,0,0,.28)
}

/* ── Metrics Grid ── */
.adm-metrics{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.adm-queue-head{align-items:center}
.adm-queue-summary{margin:0;color:var(--tx-3);font-size:.8rem}
.adm-queue-nav{
  display:grid;grid-template-columns:repeat(2,minmax(0,1fr));
  border-bottom:1px solid var(--border);background:var(--surface-2)
}
.adm-queue-nav-link{
  min-width:0;display:flex;align-items:center;gap:10px;padding:13px 22px;
  color:var(--navy-800);text-decoration:none;font-size:.82rem;font-weight:700;
  transition:background .2s,color .2s
}
.adm-queue-nav-link+ .adm-queue-nav-link{border-left:1px solid var(--border)}
.adm-queue-nav-link:hover{background:var(--surface);color:var(--crimson)}
.adm-queue-nav-link:focus-visible{outline:2px solid var(--crimson);outline-offset:-2px}
.adm-queue-nav-link i{color:var(--crimson);font-size:1rem}
.adm-queue-nav-link span{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.adm-queue-count{
  margin-left:auto;flex:0 0 auto;min-width:25px;padding:3px 7px;
  border-radius:7px;background:var(--surface);color:var(--navy-800);
  text-align:center;font-size:.72rem;font-weight:800
}
.adm-queue-body{padding:0 22px 8px}
.adm-queue-group{scroll-margin-top:calc(var(--topbar-h) + 16px);padding:17px 0 4px}
.adm-queue-group+.adm-queue-group{border-top:1px solid var(--border)}
.adm-queue-group-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:4px}
.adm-queue-group-title{display:flex;align-items:center;gap:9px;min-width:0}
.adm-queue-group-title h4{margin:0;color:var(--navy-800);font-size:.88rem;font-weight:800}
.adm-queue-group-title>i{color:var(--crimson);font-size:.95rem}
.adm-queue-group-total{padding:3px 7px;border-radius:6px;background:var(--surface-2);color:var(--tx-3);font-size:.68rem;font-weight:800;white-space:nowrap}
.adm-workflow-list{display:flex;flex-direction:column}
.adm-workflow-item{
  display:flex;align-items:center;justify-content:space-between;gap:14px;
  padding:12px 0;border-bottom:1px solid var(--border-2)
}
.adm-workflow-item:last-child{border-bottom:0}
.adm-workflow-item-info{min-width:0;flex:1}
.adm-workflow-item-info strong{display:block;color:var(--navy-800);font-size:.82rem;line-height:1.4;overflow-wrap:anywhere}
.adm-workflow-item-info span{display:block;color:var(--tx-3);font-size:.72rem;margin-top:3px}
.adm-workflow-item-actions{display:flex;align-items:center;gap:7px;flex-shrink:0}
.adm-workflow-btn{
  border:0;border-radius:7px;padding:7px 9px;font-size:.7rem;font-weight:800;
  display:inline-flex;align-items:center;justify-content:center;gap:5px;text-decoration:none;cursor:pointer;
}
.adm-workflow-btn:focus-visible{outline:2px solid var(--navy-800);outline-offset:2px}
.adm-workflow-btn.approve{background:#dcfce7;color:#15803d}
.adm-workflow-btn.reject{background:#fff1f2;color:#be123c}
.adm-workflow-btn.payment{background:#16a34a;color:#fff}
.adm-workflow-empty{display:flex;align-items:center;gap:9px;padding:13px 0;color:var(--tx-3);font-size:.78rem}
.adm-workflow-empty i{color:var(--tx-4);font-size:.95rem}
.adm-metric{
  background:#fff;border:1px solid var(--border);border-radius:15px;
  padding:20px 20px 18px;box-shadow:var(--sh-sm);
  transition:transform .3s,box-shadow .3s,border-color .3s;
  position:relative;overflow:hidden;
}
.adm-metric::after{content:'';position:absolute;left:0;top:0;bottom:0;width:4px;background:var(--m-accent);transition:width .3s}
.adm-metric:hover{transform:translateY(-5px);box-shadow:var(--sh-lg);border-color:transparent}
.adm-metric:hover::after{width:8px}
.adm-metric-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px}
.adm-metric-icon{
  width:50px;height:50px;border-radius:13px;display:grid;place-items:center;
  background:color-mix(in srgb,var(--m-accent) 14%,white);color:var(--m-accent);font-size:1.2rem;
  transition:transform .3s;flex-shrink:0;
  box-shadow:0 4px 12px color-mix(in srgb,var(--m-accent) 18%,transparent);
}
.adm-metric:hover .adm-metric-icon{transform:rotate(-5deg) scale(1.1)}
.adm-metric-label{font-size:.72rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--tx-3);margin-bottom:10px}
.adm-metric-value{font-size:2rem;font-weight:900;color:var(--navy-800);letter-spacing:-.035em;line-height:1;margin-bottom:10px}
.adm-metric-note{font-size:.75rem;color:var(--tx-4);display:flex;align-items:center;gap:6px}
.adm-metric-note i{font-size:.7rem}
.m-crimson{--m-accent:var(--crimson)}
.m-emerald{--m-accent:#10b981}
.m-sky{--m-accent:#0ea5e9}
.m-purple{--m-accent:#a855f7}
.m-amber{--m-accent:#f59e0b}

/* ── Panel Container ── */
.adm-panel{
  background:#fff;border:1px solid var(--border);border-radius:17px;
  box-shadow:var(--sh-sm);overflow:hidden;
}
.adm-panel-head{
  display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;
  padding:18px 22px;border-bottom:1px solid var(--border-2);
  background:linear-gradient(180deg,#fff,#fafbfc);
}
.adm-panel-head h3{
  margin:0;font-size:1.02rem;font-weight:800;color:var(--navy-800);
  display:flex;align-items:center;gap:9px;
}
.adm-panel-head h3 i{color:var(--crimson);font-size:.95rem}
.adm-panel-body{padding:20px 22px}
.adm-link{
  font-size:.8rem;font-weight:700;color:var(--crimson);text-decoration:none;
  display:inline-flex;align-items:center;gap:5px;transition:gap .2s;
}
.adm-link:hover{color:var(--crimson-dark);gap:8px}

/* ── Table Transaksi ── */
.adm-table{width:100%;border-collapse:collapse}
.adm-table thead th{
  text-align:left;font-size:.7rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;
  color:var(--tx-3);padding:14px 18px;background:#f8fafc;border-bottom:1px solid var(--border);
  white-space:nowrap;
}
.adm-table tbody td{padding:16px 18px;border-bottom:1px solid #f3f4f6;vertical-align:middle;font-size:.84rem}
.adm-table tbody tr:last-child td{border-bottom:none}
.adm-table tbody tr{transition:background .2s}
.adm-table tbody tr:hover{background:#fafbfc}
.adm-member{display:flex;align-items:center;gap:11px}
.adm-member-ava{
  width:38px;height:38px;border-radius:50%;object-fit:cover;flex-shrink:0;
  box-shadow:0 3px 12px rgba(237,27,59,.28);border:2px solid #fff;
}
.adm-member-ava-ph{
  width:38px;height:38px;border-radius:50%;flex-shrink:0;
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  display:grid;place-items:center;font-size:.8rem;font-weight:800;color:#fff;
  box-shadow:0 3px 12px rgba(237,27,59,.28);border:2px solid #fff;
}
.adm-book{display:flex;align-items:center;gap:12px}
.adm-book-cover{
  width:42px;height:62px;border-radius:7px;object-fit:cover;flex-shrink:0;
  box-shadow:0 4px 12px rgba(0,0,0,.18);
}
.adm-book-ph{
  width:42px;height:62px;border-radius:7px;flex-shrink:0;
  background:linear-gradient(135deg,#0f1f3d,#1e4080);
  display:grid;place-items:center;color:rgba(255,255,255,.7);font-size:1.15rem;
  box-shadow:0 4px 12px rgba(0,0,0,.18);
}
.adm-muted{color:var(--tx-3);font-size:.82rem}
.adm-status{
  display:inline-flex;align-items:center;gap:6px;font-size:.7rem;font-weight:800;
  padding:5px 12px;border-radius:99px;white-space:nowrap;
}
.adm-status.ok{background:#d1fae5;color:#065f46}
.adm-status.run{background:#e0f2fe;color:#075985}
.adm-status.late{background:#ffe4e6;color:#9f1239}
.adm-status.pending{background:#fef3c7;color:#92400e}

/* ── Quick Actions Grid ── */
.adm-actions{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.adm-action{
  background:#fff;border:1px solid var(--border);border-radius:13px;
  padding:18px 16px;text-decoration:none;color:inherit;
  transition:all .3s cubic-bezier(.34,1.56,.64,1);
  display:flex;align-items:center;gap:14px;position:relative;overflow:hidden;
}
.adm-action::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,var(--ac-color) 0%,transparent 100%);
  opacity:0;transition:opacity .3s;
}
.adm-action:hover{
  transform:translateY(-4px);box-shadow:var(--sh-lg);border-color:transparent;color:inherit;
}
.adm-action:hover::before{opacity:.05}
.adm-action-icon{
  width:48px;height:48px;border-radius:12px;display:grid;place-items:center;
  font-size:1.15rem;color:#fff;flex-shrink:0;position:relative;z-index:1;
  transition:transform .3s;box-shadow:0 4px 14px rgba(0,0,0,.2);
}
.adm-action:hover .adm-action-icon{transform:scale(1.1) rotate(-5deg)}
.adm-action-txt{flex:1;position:relative;z-index:1}
.adm-action-txt strong{display:block;font-size:.84rem;color:var(--navy-800);font-weight:700;margin-bottom:2px}
.adm-action-txt span{font-size:.72rem;color:var(--tx-4)}

/* ── Donut Stats ── */
.adm-donut-wrap{
  display:flex;justify-content:center;padding:20px 0 22px;
  background:linear-gradient(160deg,#fff,#f8fafc);border-radius:13px;margin-bottom:16px;
}
.adm-donut{width:160px;height:160px;position:relative;flex-shrink:0}
.adm-donut-ring{
  width:100%;height:100%;border-radius:50%;
  background:conic-gradient(
    #10b981 0 calc(var(--k,0) * 1%),
    #0ea5e9 calc(var(--k,0) * 1%) 100%
  );
  -webkit-mask:radial-gradient(farthest-side,transparent 60%,#000 61.5%);
  mask:radial-gradient(farthest-side,transparent 60%,#000 61.5%);
  box-shadow:0 8px 22px rgba(15,23,42,.09);
}
.adm-donut.empty .adm-donut-ring{background:conic-gradient(#e2e8f0 0 100%)}
.adm-donut-center{
  position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);
  display:flex;flex-direction:column;align-items:center;justify-content:center;
  text-align:center;pointer-events:none;
}
.adm-donut-center b{display:block;font-size:1.7rem;font-weight:900;color:var(--navy-800);line-height:1;letter-spacing:-.03em}
.adm-donut-center span{display:block;font-size:.6rem;font-weight:700;color:var(--tx-3);margin-top:6px;letter-spacing:.05em;text-transform:uppercase}
.adm-stat-rows{display:flex;flex-direction:column;gap:9px}
.adm-stat-row{
  display:flex;align-items:center;justify-content:space-between;gap:12px;
  padding:12px 13px;border-radius:11px;border:1px solid var(--border);border-left:4px solid var(--c);background:#fff;
  transition:transform .2s,box-shadow .2s;
}
.adm-stat-row:hover{transform:translateX(3px);box-shadow:var(--sh-xs)}
.adm-stat-row>span:first-child{display:flex;align-items:center;gap:9px;font-size:.82rem;font-weight:700;color:var(--navy-800)}
.adm-stat-row i{width:9px;height:9px;border-radius:50%;background:var(--c);display:block}
.adm-stat-row b{font-size:.85rem;font-weight:900;padding:4px 10px;border-radius:8px;background:color-mix(in srgb,var(--c) 15%,white);color:var(--c)}

/* ── Timeline Activity ── */
.adm-timeline{position:relative}
.adm-timeline-item{
  display:flex;gap:14px;padding:14px 0;border-bottom:1px solid #f3f4f6;position:relative;
}
.adm-timeline-item:last-child{border-bottom:none}
.adm-timeline-dot{
  width:10px;height:10px;border-radius:50%;flex-shrink:0;margin-top:4px;position:relative;z-index:1;
}
.adm-timeline-dot::before{
  content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
  width:18px;height:18px;border-radius:50%;opacity:.2;
}
.tl-success .adm-timeline-dot{background:#10b981}
.tl-success .adm-timeline-dot::before{background:#10b981}
.tl-info .adm-timeline-dot{background:#0ea5e9}
.tl-info .adm-timeline-dot::before{background:#0ea5e9}
.tl-danger .adm-timeline-dot{background:#ef4444}
.tl-danger .adm-timeline-dot::before{background:#ef4444}
.tl-warning .adm-timeline-dot{background:#f59e0b}
.tl-warning .adm-timeline-dot::before{background:#f59e0b}
.adm-timeline-content{flex:1;min-width:0}
.adm-timeline-title{font-size:.82rem;font-weight:700;color:var(--navy-800);margin-bottom:4px}
.adm-timeline-desc{font-size:.76rem;color:var(--tx-3);margin-bottom:4px}
.adm-timeline-time{font-size:.7rem;color:var(--tx-4)}

/* ── Book Grid ── */
.adm-books{display:grid;grid-template-columns:repeat(8,1fr);gap:12px}
.adm-book-card{text-decoration:none;color:inherit;display:block;transition:transform .2s}
.adm-book-card:hover{transform:translateY(-4px)}
.adm-book-card-cover{
  aspect-ratio:2/3;border-radius:8px;overflow:hidden;background:#1e293b;
  box-shadow:0 8px 20px rgba(11,23,48,.18);margin-bottom:8px;position:relative;
}
.adm-book-card-cover img{width:100%;height:100%;object-fit:cover;display:block}
.adm-book-card-cover .ph{
  width:100%;height:100%;display:grid;place-items:center;
  color:rgba(255,255,255,.4);font-size:1.4rem;
  background:linear-gradient(150deg,#0f1f3d,#1e4080);
}
.adm-book-stok{
  position:absolute;left:6px;bottom:6px;
  font-size:.58rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;
  padding:3px 7px;border-radius:5px;color:#fff;
}
.adm-book-stok.ok{background:rgba(5,150,105,.9)}
.adm-book-stok.out{background:rgba(190,18,60,.9)}
.adm-book-card-title{
  font-size:.72rem;font-weight:800;color:var(--navy-800);line-height:1.3;
  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;
}
.adm-book-card-author{font-size:.64rem;color:var(--tx-4);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

/* ── Main Grid Layout ── */
.adm-grid{display:grid;grid-template-columns:1.7fr 1fr;gap:20px;align-items:start}

/* ── Animation ── */
.adm-metric,.adm-action,.adm-panel{animation:admEnter .45s var(--ease) both}
.adm-metric:nth-child(2){animation-delay:.05s}
.adm-metric:nth-child(3){animation-delay:.1s}
.adm-metric:nth-child(4){animation-delay:.15s}
@keyframes admEnter{
  from{opacity:0;transform:translateY(10px)}
  to{opacity:1;transform:translateY(0)}
}

/* ── Responsive ── */
@media(max-width:1100px){
  .adm-metrics{grid-template-columns:repeat(2,1fr)}
  .adm-grid{grid-template-columns:1fr}
  .adm-books{grid-template-columns:repeat(5,1fr)}
}
@media(max-width:768px){
  .adm-hero{grid-template-columns:1fr;padding:24px 22px}
  .adm-hero-icon{width:64px;height:64px;font-size:1.8rem}
  .adm-metrics{grid-template-columns:1fr 1fr}
  .adm-actions{grid-template-columns:1fr}
  .adm-workflow-item{align-items:flex-start}
  .adm-books{grid-template-columns:repeat(4,1fr)}
  .adm-table{min-width:650px}
}
@media(max-width:576px){
  .adm-hero{padding:20px 18px}
  .adm-popular-showcase{max-width:none;padding:12px}
  .adm-popular-stack{height:158px}
  .adm-popular-card{left:calc(50% + var(--fan-offset-mobile))}
  .adm-popular-card{top:17px;width:72px;height:108px}
  .adm-popular-card-featured{top:5px;width:90px;height:135px}
  .adm-metrics{grid-template-columns:1fr}
  .adm-books{grid-template-columns:repeat(2,1fr)}
  .adm-metric-value{font-size:1.6rem}
  .adm-queue-nav-link{gap:7px;padding:11px 12px;font-size:.74rem}
  .adm-queue-body{padding:0 16px 6px}
  .adm-queue-group-head{align-items:flex-start}
  .adm-queue-group-head>.adm-link{font-size:.72rem;white-space:nowrap}
  .adm-workflow-item{flex-direction:column;gap:8px}
  .adm-workflow-item-actions{width:100%}
  .adm-workflow-item-actions form{flex:1}
  .adm-workflow-item-actions form:only-child{flex:0 1 auto}
  .adm-workflow-item-actions form:only-child .adm-workflow-btn{width:auto}
  .adm-workflow-btn{width:100%;min-height:36px}
}
@media(prefers-reduced-motion:reduce){
  .adm-metric,.adm-action,.adm-panel{animation:none}
}
</style>

<div class="adm-wrap">

  {{-- Hero Banner --}}
  <section class="adm-hero">
    <div>
      <div class="adm-kicker">
        <span class="dot"></span>
        <span>{{ $greeting }} · {{ now()->translatedFormat('l, d F Y') }}</span>
      </div>
      <h1>{{ auth()->user()->name }}</h1>
      <p>Kelola perpustakaan digital dengan mudah dan efisien. Pantau transaksi, kelola koleksi, dan layani anggota dengan sistem terintegrasi.</p>
      <div class="adm-hero-actions">
        <a href="{{ route('admin.transaksi.create') }}" class="adm-btn adm-btn-primary">
          <i class="bi bi-plus-lg"></i> Tambah Transaksi
        </a>
        <a href="{{ route('admin.buku.index') }}" class="adm-btn adm-btn-ghost">
          <i class="bi bi-book-fill"></i> Kelola Buku
        </a>
      </div>
    </div>
    <div class="adm-hero-right">
      {{-- Top 5 Buku Populer --}}
      @if($bukuPopuler->isNotEmpty())
      @php
        $popularTopFive = $bukuPopuler->take(5);
        $popularCount = $popularTopFive->count();
        $fanMidpoint = ($popularCount - 1) / 2;
        $fanStep = $popularCount === 5 ? 58 : ($popularCount === 4 ? 66 : ($popularCount === 3 ? 75 : 70));
        $fanMobileStep = $popularCount === 5 ? 38 : ($popularCount === 4 ? 44 : ($popularCount === 3 ? 52 : 52));
      @endphp
      <section class="adm-popular-showcase" aria-labelledby="adm-popular-heading">
        <h2 class="adm-popular-heading" id="adm-popular-heading">
          <i class="bi bi-fire" aria-hidden="true"></i>
          <span>Top 5 Populer</span>
        </h2>
        <div class="adm-popular-stack" aria-label="Buku populer berdasarkan peringkat">
          @foreach($popularTopFive as $i => $b)
          @php
            $fanPosition = $i - $fanMidpoint;
            $fanOffset = $fanPosition * $fanStep;
            $fanMobileOffset = $fanPosition * $fanMobileStep;
            $fanAngle = $fanPosition * 6.5;
            $fanDepth = 5 - (int) round(abs($fanPosition));
            $isFeatured = $i === (int) floor($fanMidpoint);
            $isRightSide = $fanPosition > 0;
          @endphp
          <a href="{{ route('admin.buku.edit', $b->id) }}"
             class="adm-popular-card{{ $isFeatured ? ' adm-popular-card-featured' : '' }}{{ $isRightSide ? ' adm-popular-card-right' : '' }}"
             style="--fan-offset:{{ $fanOffset }}px;--fan-offset-mobile:{{ $fanMobileOffset }}px;--fan-angle:{{ $fanAngle }}deg;--fan-depth:{{ $fanDepth }}"
             aria-label="Peringkat {{ $i + 1 }}: {{ $b->judul }}. Edit buku." title="{{ $b->judul }}">
            <div class="adm-popular-cover">
            @if($b->cover)
              <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}" loading="lazy">
            @else
              <div class="adm-popular-placeholder">
                <i class="bi bi-book-fill" aria-hidden="true"></i>
              </div>
            @endif
              <span class="adm-popular-rank">#{{ $i + 1 }}</span>
            </div>
          </a>
          @endforeach
        </div>
      </section>
      @else
      <div class="adm-hero-icon">
        <i class="bi bi-building-fill-gear"></i>
      </div>
      @endif
    </div>
  </section>

  {{-- Metrics --}}
  <section class="adm-metrics">
    <div class="adm-metric m-crimson">
      <div class="adm-metric-top">
        <div class="adm-metric-icon"><i class="bi bi-people-fill"></i></div>
      </div>
      <div class="adm-metric-label">Total Anggota</div>
      <div class="adm-metric-value">{{ number_format($totalAnggota,0,',','.') }}</div>
      <div class="adm-metric-note"><i class="bi bi-check-circle-fill"></i> Anggota terdaftar</div>
    </div>
    <div class="adm-metric m-emerald">
      <div class="adm-metric-top">
        <div class="adm-metric-icon"><i class="bi bi-book-fill"></i></div>
      </div>
      <div class="adm-metric-label">Koleksi Buku</div>
      <div class="adm-metric-value">{{ number_format($totalBuku,0,',','.') }}</div>
      <div class="adm-metric-note"><i class="bi bi-collection-fill"></i> Buku tersedia</div>
    </div>
    <div class="adm-metric m-sky">
      <div class="adm-metric-top">
        <div class="adm-metric-icon"><i class="bi bi-arrow-repeat"></i></div>
      </div>
      <div class="adm-metric-label">Sedang Dipinjam</div>
      <div class="adm-metric-value">{{ number_format($totalDipinjam,0,',','.') }}</div>
      <div class="adm-metric-note"><i class="bi bi-clock-history"></i> Peminjaman aktif</div>
    </div>
    <div class="adm-metric m-purple">
      <div class="adm-metric-top">
        <div class="adm-metric-icon"><i class="bi bi-check2-circle"></i></div>
      </div>
      <div class="adm-metric-label">Dikembalikan</div>
      <div class="adm-metric-value">{{ number_format($totalDikembalikan,0,',','.') }}</div>
      <div class="adm-metric-note"><i class="bi bi-arrow-return-left"></i> Transaksi selesai</div>
    </div>
  </section>

  {{-- Action Queue: Return approvals and fine payments --}}
  <section class="adm-panel adm-queue" aria-labelledby="adm-queue-title">
    <div class="adm-panel-head adm-queue-head">
      <h3 id="adm-queue-title"><i class="bi bi-inbox"></i> Antrian Tindakan</h3>
      <p class="adm-queue-summary">Pengembalian dan pembayaran denda yang perlu ditangani</p>
    </div>
    <nav class="adm-queue-nav" aria-label="Pilih jenis antrian">
      <a href="{{ route('admin.dashboard', ['queue' => 'returns']) }}#pengembalian-menunggu" class="adm-queue-nav-link">
        <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i>
        <span>Pengembalian</span>
        <b class="adm-queue-count">{{ $totalPendingKembali }}</b>
      </a>
      <a href="{{ route('admin.dashboard', ['queue' => 'fines']) }}#denda-belum-lunas" class="adm-queue-nav-link">
        <i class="bi bi-cash-coin" aria-hidden="true"></i>
        <span>Denda belum lunas</span>
        <b class="adm-queue-count">{{ $totalDendaBelumLunas }}</b>
      </a>
    </nav>
    <div class="adm-panel-body adm-queue-body">
      <section id="pengembalian-menunggu" class="adm-queue-group" aria-labelledby="adm-returns-title">
        <div class="adm-queue-group-head">
          <div class="adm-queue-group-title">
            <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i>
            <h4 id="adm-returns-title">Pengembalian Menunggu Persetujuan</h4>
          </div>
        </div>
        @if($pengembalianMenunggu->isEmpty())
          <div class="adm-workflow-empty"><i class="bi bi-check2-circle" aria-hidden="true"></i> Tidak ada permintaan pengembalian yang menunggu.</div>
        @else
          <div class="adm-workflow-list">
            @foreach($pengembalianMenunggu as $p)
              <div class="adm-workflow-item">
                <div class="adm-workflow-item-info">
                  <strong>{{ $p->anggota->nama ?? 'Anggota' }} · {{ $p->buku->judul ?? 'Buku' }}</strong>
                  <span>
                    Diajukan {{ $p->return_requested_at?->isoFormat('D MMM YYYY, HH:mm') ?? '—' }}
                    · {{ $p->kode_pinjam }}
                  </span>
                </div>
                <div class="adm-workflow-item-actions">
                  <form method="POST" action="{{ route('admin.transaksi.approve-kembali', $p) }}" onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                    @csrf
                    <button type="submit" class="adm-workflow-btn approve">
                      <i class="bi bi-check-circle-fill"></i> Konfirmasi
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.transaksi.reject-kembali', $p) }}" onsubmit="return confirm('Tolak pengajuan pengembalian buku ini?')">
                    @csrf
                    <button type="submit" class="adm-workflow-btn reject">
                      <i class="bi bi-x-circle-fill"></i> Tolak
                    </button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </section>

      <section id="denda-belum-lunas" class="adm-queue-group" aria-labelledby="adm-fines-title">
        <div class="adm-queue-group-head">
          <div class="adm-queue-group-title">
            <i class="bi bi-cash-coin" aria-hidden="true"></i>
            <h4 id="adm-fines-title">Denda Belum Lunas</h4>
          </div>
        </div>
        @if($dendaBelumLunas->isEmpty())
          <div class="adm-workflow-empty"><i class="bi bi-check2-circle" aria-hidden="true"></i> Tidak ada denda yang menunggu pembayaran.</div>
        @else
          <div class="adm-workflow-list">
            @foreach($dendaBelumLunas as $p)
              <div class="adm-workflow-item">
                <div class="adm-workflow-item-info">
                  <strong>{{ $p->anggota ? $p->anggota->nama : 'Anggota' }} · {{ $p->buku ? $p->buku->judul : 'Buku' }}</strong>
                  <span>Denda Rp {{ number_format($p->denda, 0, ',', '.') }} · {{ $p->kode_pinjam }}</span>
                </div>
                <form method="POST" action="{{ route('admin.transaksi.denda.lunas', $p) }}" onsubmit="return confirm('Konfirmasi pembayaran denda Rp {{ number_format($p->denda, 0, ',', '.') }} sudah diterima?')">
                  @csrf
                  <button type="submit" class="adm-workflow-btn payment">
                    <i class="bi bi-check2-circle"></i> Selesaikan Pembayaran
                  </button>
                </form>
              </div>
            @endforeach
          </div>
        @endif
      </section>
    </div>
  </section>

  {{-- Buku Populer --}}
  @if($bukuPopuler->isNotEmpty())
  <section class="adm-panel">
    <div class="adm-panel-head">
      <h3><i class="bi bi-fire"></i> Buku Populer</h3>
      <a href="{{ route('admin.buku.index') }}" class="adm-link">Kelola semua <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="adm-panel-body">
      <div class="adm-books">
        @foreach($bukuPopuler as $b)
        <a href="{{ route('admin.buku.edit', $b->id) }}" class="adm-book-card">
          <div class="adm-book-card-cover">
            @if($b->cover)
              <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}" loading="lazy">
            @else
              <div class="ph"><i class="bi bi-book-fill"></i></div>
            @endif
            <span class="adm-book-stok {{ $b->stok > 0 ? 'ok' : 'out' }}">{{ $b->stok > 0 ? $b->stok.' stok' : 'Habis' }}</span>
          </div>
          <div class="adm-book-card-title">{{ $b->judul }}</div>
          <div class="adm-book-card-author">{{ $b->pengarang }}</div>
        </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- Main Grid: Table + Sidebar --}}
  <div class="adm-grid">

    {{-- Left: Transaksi Table + Actions --}}
    <div style="display:flex;flex-direction:column;gap:20px">
      
      {{-- Transaksi Terbaru --}}
      <section class="adm-panel">
        <div class="adm-panel-head">
          <h3><i class="bi bi-clock-history"></i> Transaksi Peminjaman Terbaru</h3>
          <a href="{{ route('admin.transaksi.index') }}" class="adm-link">Lihat semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="table-responsive">
          <table class="adm-table">
            <thead>
              <tr>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($peminjamanTerbaru->take(7) as $p)
              <tr>
                <td>
                  <div class="adm-member">
                    @if($p->anggota && $p->anggota->foto)
                      <img src="{{ Storage::url($p->anggota->foto) }}" alt="{{ $p->anggota->nama }}" class="adm-member-ava">
                    @else
                      <div class="adm-member-ava-ph">{{ strtoupper(substr($p->anggota->nama ?? 'U', 0, 1)) }}</div>
                    @endif
                    <span style="font-weight:700;color:var(--navy-800)">{{ Str::limit($p->anggota->nama ?? '-', 22) }}</span>
                  </div>
                </td>
                <td>
                  <div class="adm-book">
                    @if($p->buku && $p->buku->cover)
                      <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" class="adm-book-cover">
                    @else
                      <div class="adm-book-ph"><i class="bi bi-book-fill"></i></div>
                    @endif
                    <span style="font-weight:600;color:var(--tx-2)">{{ Str::limit($p->buku->judul ?? '-', 35) }}</span>
                  </div>
                </td>
                <td class="adm-muted">
                  <i class="bi bi-calendar3" style="font-size:.75rem;margin-right:4px"></i>
                  {{ $p->tanggal_pinjam?->format('d M Y') ?? '—' }}
                </td>
                <td class="adm-muted">
                  @if($p->tanggal_kembali_rencana)
                    <i class="bi bi-calendar-check" style="font-size:.75rem;margin-right:4px"></i>
                    {{ $p->tanggal_kembali_rencana->format('d M Y') }}
                  @else
                    —
                  @endif
                </td>
                <td>
                  @if($p->status === 'dikembalikan')
                    <span class="adm-status ok"><i class="bi bi-check-circle-fill"></i> Kembali</span>
                  @elseif($p->status === 'dipinjam')
                    <span class="adm-status run"><i class="bi bi-arrow-repeat"></i> Dipinjam</span>
                  @elseif($p->status === 'pending')
                    <span class="adm-status pending"><i class="bi bi-clock"></i> Pending</span>
                  @elseif($p->status === 'pending_kembali')
                    <span class="adm-status run"><i class="bi bi-hourglass-split"></i> Menunggu Kembali</span>
                  @elseif($p->status === 'ditolak')
                    <span class="adm-status pending"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                  @else
                    <span class="adm-status late"><i class="bi bi-exclamation-circle-fill"></i> Terlambat</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" style="text-align:center;padding:48px 20px;color:var(--tx-4)">
                  <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.25"></i>
                  <div style="font-weight:600;font-size:.88rem">Belum ada transaksi</div>
                  <div style="font-size:.78rem;margin-top:4px">Transaksi akan muncul di sini</div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>

      {{-- Aksi Cepat --}}
      <section class="adm-panel">
        <div class="adm-panel-head">
          <h3><i class="bi bi-lightning-charge-fill"></i> Aksi Cepat</h3>
        </div>
        <div class="adm-panel-body">
          <div class="adm-actions">
            <a href="{{ route('admin.transaksi.create') }}" class="adm-action" style="--ac-color:var(--crimson)">
              <div class="adm-action-icon" style="background:linear-gradient(135deg,var(--crimson),var(--crimson-dark))">
                <i class="bi bi-plus-circle-fill"></i>
              </div>
              <div class="adm-action-txt">
                <strong>Tambah Peminjaman</strong>
                <span>Buat transaksi baru</span>
              </div>
            </a>
            <a href="{{ route('admin.buku.index') }}" class="adm-action" style="--ac-color:#10b981">
              <div class="adm-action-icon" style="background:linear-gradient(135deg,#10b981,#059669)">
                <i class="bi bi-book-fill"></i>
              </div>
              <div class="adm-action-txt">
                <strong>Kelola Buku</strong>
                <span>Lihat & edit koleksi</span>
              </div>
            </a>
            <a href="{{ route('admin.anggota.index') }}" class="adm-action" style="--ac-color:#0ea5e9">
              <div class="adm-action-icon" style="background:linear-gradient(135deg,#0ea5e9,#0284c7)">
                <i class="bi bi-people-fill"></i>
              </div>
              <div class="adm-action-txt">
                <strong>Data Anggota</strong>
                <span>Kelola member</span>
              </div>
            </a>
          </div>
        </div>
      </section>

    </div>

    {{-- Right: Statistik + Aktivitas --}}
    <div style="display:flex;flex-direction:column;gap:20px">

      {{-- Donut Stats --}}
      <section class="adm-panel">
        <div class="adm-panel-head">
          <h3><i class="bi bi-pie-chart-fill"></i> Tingkat Pengembalian</h3>
        </div>
        <div class="adm-panel-body">
          <div class="adm-donut-wrap">
            <div class="adm-donut {{ $total > 0 ? '' : 'empty' }}" style="--k:{{ $returnRate }}"
                 role="img" aria-label="{{ $totalDikembalikan }} dikembalikan, {{ $totalDipinjam }} dipinjam">
              <div class="adm-donut-ring"></div>
              <div class="adm-donut-center">
                <b>{{ $returnRate }}%</b>
                <span>Kembali</span>
              </div>
            </div>
          </div>
          <div class="adm-stat-rows">
            <div class="adm-stat-row" style="--c:#10b981">
              <span><i></i> Dikembalikan</span>
              <b>{{ $totalDikembalikan }}</b>
            </div>
            <div class="adm-stat-row" style="--c:#0ea5e9">
              <span><i></i> Sedang Dipinjam</span>
              <b>{{ $totalDipinjam }}</b>
            </div>
            @if($totalTerlambat > 0)
            <div class="adm-stat-row" style="--c:#ef4444">
              <span><i></i> Terlambat</span>
              <b>{{ $totalTerlambat }}</b>
            </div>
            @endif
          </div>
        </div>
      </section>

      {{-- Aktivitas Terkini --}}
      <section class="adm-panel">
        <div class="adm-panel-head">
          <h3><i class="bi bi-activity"></i> Aktivitas Terkini</h3>
        </div>
        <div class="adm-panel-body">
          <div class="adm-timeline">
            @forelse($peminjamanTerbaru->take(5) as $p)
              <div class="adm-timeline-item {{ $p->status === 'dikembalikan' ? 'tl-success' : (in_array($p->status, ['dipinjam', 'pending_kembali']) ? 'tl-info' : (in_array($p->status, ['pending', 'ditolak']) ? 'tl-warning' : 'tl-danger')) }}">
                <div class="adm-timeline-dot"></div>
                <div class="adm-timeline-content">
                  <div class="adm-timeline-title">
                    @if($p->status === 'dikembalikan')
                      Buku dikembalikan
                    @elseif($p->status === 'dipinjam')
                      Peminjaman baru
                    @elseif($p->status === 'pending')
                      Menunggu persetujuan
                    @elseif($p->status === 'pending_kembali')
                      Menunggu konfirmasi pengembalian
                    @elseif($p->status === 'ditolak')
                      Pengajuan ditolak
                    @else
                      Keterlambatan
                    @endif
                  </div>
                  <div class="adm-timeline-desc">
                    <strong>{{ Str::limit($p->anggota->nama ?? '-', 20) }}</strong> 
                    {{ $p->status === 'dikembalikan' ? 'mengembalikan' : (in_array($p->status, ['pending', 'pending_kembali']) ? 'mengajukan' : ($p->status === 'ditolak' ? 'mengajukan' : 'meminjam')) }}
                    <strong>"{{ Str::limit($p->buku->judul ?? '-', 28) }}"</strong>
                  </div>
                  <div class="adm-timeline-time">
                    <i class="bi bi-clock"></i> {{ $p->created_at->diffForHumans() }}
                  </div>
                </div>
              </div>
            @empty
              <div style="text-align:center;padding:32px 20px;color:var(--tx-4)">
                <i class="bi bi-calendar-x" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.25"></i>
                <div style="font-size:.82rem;font-weight:600">Belum ada aktivitas</div>
              </div>
            @endforelse
          </div>
        </div>
      </section>

    </div>
  </div>

</div>

@endsection

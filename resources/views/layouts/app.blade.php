<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','Perpustakaan Sekolah Digital')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
/* ═══════════════════════════════════════════════════
   DESIGN SYSTEM — PERPUSTAKAAN SEKOLAH DIGITAL
   Theme: Premium Navy & Gold
═══════════════════════════════════════════════════ */
:root{
  /* Core palette */
  --navy-950:#060d1a;
  --navy-900:#0c1829;
  --navy-800:#0f1f3d;
  --navy-700:#162845;
  --navy-600:#1a3461;
  --navy-500:#1e4080;
  --navy-400:#2d5a9e;
  --navy-300:#4a7fc4;

  --gold-400:#f59e0b;
  --gold-500:#d97706;
  --gold-300:#fbbf24;
  --gold-100:#fef9c3;

  --blue-500:#2563eb;
  --blue-400:#3b82f6;
  --blue-100:#dbeafe;

  --green-500:#16a34a;
  --green-100:#dcfce7;
  --red-500:#dc2626;
  --red-100:#fee2e2;
  --yellow-100:#fef9c3;
  --sky-100:#e0f2fe;
  --violet-100:#ede9fe;

  /* Surface */
  --bg:#f0f4f8;
  --surface:#ffffff;
  --surface-2:#f8fafc;
  --border:#e2e8f0;
  --border-2:#f1f5f9;

  /* Text */
  --tx-1:#0f172a;
  --tx-2:#334155;
  --tx-3:#64748b;
  --tx-4:#94a3b8;

  /* Sidebar */
  --sb-w:268px;
  --sb-collapsed:68px;
  --sb-bg:var(--navy-900);

  /* Layout */
  --topbar-h:60px;
  --radius:14px;
  --radius-sm:9px;
  --radius-xs:6px;

  /* Shadow */
  --sh-xs:0 1px 2px rgba(0,0,0,.06);
  --sh-sm:0 1px 3px rgba(0,0,0,.08),0 4px 16px rgba(0,0,0,.06);
  --sh-md:0 4px 12px rgba(0,0,0,.08),0 12px 32px rgba(0,0,0,.07);
  --sh-lg:0 8px 24px rgba(0,0,0,.1),0 24px 56px rgba(0,0,0,.12);
  --sh-xl:0 16px 48px rgba(0,0,0,.18);

  --ease:cubic-bezier(.4,0,.2,1);
}

/* ── RESET ── */
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{
  font-family:'Inter',system-ui,sans-serif;
  background:var(--bg);color:var(--tx-1);
  font-size:14px;line-height:1.5;
  -webkit-font-smoothing:antialiased;
}
a{text-decoration:none;color:inherit}
::-webkit-scrollbar{width:5px;height:5px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:99px}
::-webkit-scrollbar-thumb:hover{background:#94a3b8}

/* ═══════════════════════════════════════════════════
   APP SHELL
═══════════════════════════════════════════════════ */
.app-wrap{display:flex;min-height:100vh}

/* ── SIDEBAR ── */
.sidebar{
  position:fixed;top:0;left:0;
  width:var(--sb-w);height:100vh;
  background:var(--sb-bg);
  display:flex;flex-direction:column;
  z-index:1050;
  transition:transform .3s var(--ease);
  overflow:hidden;
}
/* Decorative background pattern */
.sidebar::before{
  content:'';position:absolute;
  width:300px;height:300px;border-radius:50%;
  background:radial-gradient(circle,rgba(45,90,158,.15) 0%,transparent 70%);
  top:-80px;right:-80px;pointer-events:none;
}
.sidebar::after{
  content:'';position:absolute;
  width:200px;height:200px;border-radius:50%;
  background:radial-gradient(circle,rgba(245,158,11,.06) 0%,transparent 70%);
  bottom:60px;left:-60px;pointer-events:none;
}

/* Brand */
.sb-brand{
  padding:18px 16px 15px;
  display:flex;align-items:center;gap:12px;
  border-bottom:1px solid rgba(255,255,255,.06);
  flex-shrink:0;position:relative;z-index:1;
}
.sb-logo{
  width:42px;height:42px;border-radius:12px;
  background:linear-gradient(135deg,var(--gold-400),var(--gold-500));
  display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;color:#fff;flex-shrink:0;
  box-shadow:0 4px 16px rgba(245,158,11,.45);
}
.sb-logo i{filter:drop-shadow(0 1px 2px rgba(0,0,0,.3))}
.sb-brand-txt strong{
  display:block;color:#fff;font-size:.8rem;
  font-weight:800;line-height:1.25;
}
.sb-brand-txt span{color:rgba(255,255,255,.3);font-size:.65rem;font-weight:500}

/* User chip */
.sb-user{
  margin:10px 12px 4px;padding:10px 11px;
  background:rgba(255,255,255,.05);
  border:1px solid rgba(255,255,255,.07);
  border-radius:var(--radius-sm);
  display:flex;align-items:center;gap:10px;
  flex-shrink:0;position:relative;z-index:1;
}
.sb-avatar{
  width:34px;height:34px;border-radius:50%;
  background:linear-gradient(135deg,var(--gold-400),var(--gold-500));
  display:flex;align-items:center;justify-content:center;
  font-size:.75rem;font-weight:800;color:#fff;flex-shrink:0;
  box-shadow:0 2px 8px rgba(245,158,11,.4);
}
.sb-uname{color:#fff;font-size:.79rem;font-weight:600;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.sb-badge{
  font-size:.61rem;font-weight:700;padding:2px 8px;
  border-radius:99px;display:inline-block;margin-top:3px;
  letter-spacing:.02em;
}
.sb-badge-admin{background:rgba(220,38,38,.18);color:#fca5a5}
.sb-badge-siswa{background:rgba(59,130,246,.18);color:#93c5fd}

/* Nav */
.sb-nav{flex:1;overflow-y:auto;padding:6px 0 10px;position:relative;z-index:1}
.sb-nav::-webkit-scrollbar{width:0}
.sb-section{
  font-size:.6rem;font-weight:800;text-transform:uppercase;
  letter-spacing:.12em;color:rgba(255,255,255,.22);
  padding:16px 16px 5px;
}
.sb-item{
  display:flex;align-items:center;gap:11px;
  margin:2px 10px;padding:9px 11px;
  border-radius:var(--radius-sm);
  color:rgba(255,255,255,.55);
  font-size:.82rem;font-weight:500;
  transition:all .18s var(--ease);
  border:none;border-left:2px solid transparent;
  background:none;width:calc(100% - 20px);
  text-align:left;cursor:pointer;white-space:nowrap;
}
.sb-item:hover{
  background:rgba(255,255,255,.07);
  color:rgba(255,255,255,.88);
}
.sb-item.active{
  background:linear-gradient(90deg,rgba(245,158,11,.12),rgba(245,158,11,.04));
  color:#fff;border-left-color:var(--gold-400);
  font-weight:600;padding-left:9px;
}
.sb-icon{
  width:30px;height:30px;border-radius:7px;
  background:rgba(255,255,255,.07);
  display:flex;align-items:center;justify-content:center;
  font-size:.84rem;flex-shrink:0;
  transition:all .18s;
}
.sb-item.active .sb-icon{
  background:linear-gradient(135deg,var(--gold-400),var(--gold-500));
  box-shadow:0 3px 10px rgba(245,158,11,.5);color:#fff;
}
.sb-item:hover .sb-icon{background:rgba(255,255,255,.12)}

/* Sidebar footer */
.sb-footer{
  padding:10px;border-top:1px solid rgba(255,255,255,.06);
  flex-shrink:0;position:relative;z-index:1;
}

/* ── MAIN ── */
.app-main{
  flex:1;min-width:0;
  margin-left:var(--sb-w);
  display:flex;flex-direction:column;
  min-height:100vh;
}

/* Topbar */
.topbar{
  height:var(--topbar-h);
  background:var(--surface);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;
  justify-content:space-between;
  padding:0 24px;
  position:sticky;top:0;z-index:999;
  box-shadow:var(--sh-xs);
  flex-shrink:0;
}
.topbar-left{display:flex;align-items:center;gap:12px}
.topbar-title{font-size:.96rem;font-weight:800;color:var(--navy-800);letter-spacing:-.01em}
.topbar-right{display:flex;align-items:center;gap:10px}
.topbar-chip{
  display:flex;align-items:center;gap:7px;
  background:var(--bg);border:1px solid var(--border);
  border-radius:99px;padding:5px 12px 5px 7px;
}
.topbar-chip-ava{
  width:26px;height:26px;border-radius:50%;
  background:linear-gradient(135deg,var(--navy-800),var(--blue-500));
  display:flex;align-items:center;justify-content:center;
  font-size:.65rem;font-weight:800;color:#fff;flex-shrink:0;
}
.topbar-chip-name{font-size:.78rem;font-weight:600;color:var(--tx-2)}

/* Content */
.app-content{padding:24px;flex:1}

/* Overlay */
.sb-overlay{
  display:none;position:fixed;inset:0;
  background:rgba(0,0,0,.55);z-index:1040;
  backdrop-filter:blur(3px);
}
.sb-overlay.show{display:block}

/* ═══════════════════════════════════════════════════
   FLASH MESSAGES
═══════════════════════════════════════════════════ */
.flash-area{padding:16px 24px 0}
.flash-msg{
  display:flex;align-items:center;gap:11px;
  padding:12px 16px;border-radius:var(--radius-sm);
  font-size:.83rem;font-weight:500;margin-bottom:8px;
  animation:slideDown .3s var(--ease);
}
@keyframes slideDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:none}}
.flash-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
.flash-danger{background:#fff1f2;border:1px solid #fecdd3;color:#be123c}
.flash-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}

/* ═══════════════════════════════════════════════════
   STAT CARDS — Premium
═══════════════════════════════════════════════════ */
.stat-card{
  background:var(--surface);
  border-radius:var(--radius);
  border:1px solid var(--border);
  box-shadow:var(--sh-sm);
  padding:20px 22px;
  display:flex;align-items:flex-start;gap:16px;
  transition:transform .22s var(--ease),box-shadow .22s var(--ease);
  position:relative;overflow:hidden;
}
.stat-card::before{
  content:'';position:absolute;
  right:-20px;bottom:-20px;
  width:100px;height:100px;border-radius:50%;
  background:rgba(0,0,0,.02);pointer-events:none;
}
.stat-card:hover{transform:translateY(-3px);box-shadow:var(--sh-md)}
.stat-icon-wrap{
  width:54px;height:54px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.4rem;flex-shrink:0;
}
.stat-num{font-size:1.9rem;font-weight:900;line-height:1;letter-spacing:-.04em;color:var(--navy-800)}
.stat-lbl{font-size:.72rem;font-weight:600;color:var(--tx-3);margin-top:5px;text-transform:uppercase;letter-spacing:.04em}
.stat-trend{font-size:.7rem;font-weight:600;display:flex;align-items:center;gap:3px;margin-top:4px}

/* ═══════════════════════════════════════════════════
   DATA TABLE
═══════════════════════════════════════════════════ */
.data-card{
  background:var(--surface);border-radius:var(--radius);
  border:1px solid var(--border);box-shadow:var(--sh-sm);overflow:hidden;
}
.data-card-header{
  padding:16px 20px;border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;
  background:var(--surface);
}
.data-card-header h6{
  font-size:.9rem;font-weight:800;margin:0;
  color:var(--navy-800);display:flex;align-items:center;gap:8px;
}
.data-card-header .count-badge{
  font-size:.68rem;font-weight:700;
  background:var(--bg);color:var(--tx-3);
  padding:2px 8px;border-radius:99px;
  border:1px solid var(--border);
}
table.dt{width:100%;margin:0}
table.dt thead th{
  background:#f8fafc;
  font-size:.68rem;font-weight:800;text-transform:uppercase;
  letter-spacing:.08em;color:var(--tx-3);
  border-bottom:1px solid var(--border);
  padding:11px 18px;white-space:nowrap;
}
table.dt tbody td{
  padding:14px 18px;vertical-align:middle;
  font-size:.84rem;border-bottom:1px solid var(--border-2);
  color:var(--tx-1);transition:background .12s;
}
table.dt tbody tr:last-child td{border-bottom:none}
table.dt tbody tr:hover td{background:#fafbfd}
.dt-pager{padding:14px 20px;border-top:1px solid var(--border-2)}

/* Table helpers */
.pill{
  display:inline-block;background:var(--surface-2);
  padding:2px 8px;border-radius:5px;
  font-size:.71rem;font-weight:700;
  font-family:'Courier New',monospace;color:var(--navy-800);
  border:1px solid var(--border);
}
.ava{
  width:36px;height:36px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:.75rem;font-weight:800;color:#fff;flex-shrink:0;
  background:linear-gradient(135deg,var(--navy-800),var(--blue-500));
}
.ava-sm{width:30px;height:30px;font-size:.67rem}

/* ═══════════════════════════════════════════════════
   STATUS BADGES
═══════════════════════════════════════════════════ */
.status-badge{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.7rem;font-weight:700;
  padding:.3em .75em;border-radius:6px;
  white-space:nowrap;letter-spacing:.01em;
}
.sb-pinjam{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.sb-terlambat{background:#fff1f2;color:#be123c;border:1px solid #fecdd3}
.sb-kembali{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.sb-aktif{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.sb-nonaktif{background:#f8fafc;color:#64748b;border:1px solid #e2e8f0}
.sb-ada{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.sb-habis{background:#fff1f2;color:#be123c;border:1px solid #fecdd3}

/* ═══════════════════════════════════════════════════
   BUTTONS
═══════════════════════════════════════════════════ */
.btn{
  display:inline-flex !important;align-items:center;gap:6px;
  border-radius:var(--radius-sm) !important;
  font-size:.82rem !important;font-weight:600 !important;
  padding:9px 18px !important;
  transition:all .18s var(--ease) !important;
  cursor:pointer;border-width:1.5px !important;
  white-space:nowrap;line-height:1.3;
  font-family:'Inter',sans-serif !important;
}
.btn-primary{background:var(--blue-500) !important;border-color:var(--blue-500) !important;color:#fff !important}
.btn-primary:hover{background:#1d4ed8 !important;border-color:#1d4ed8 !important;color:#fff !important;transform:translateY(-1px);box-shadow:0 6px 16px rgba(37,99,235,.3) !important}
.btn-navy{background:var(--navy-800) !important;border-color:var(--navy-800) !important;color:#fff !important}
.btn-navy:hover{background:var(--navy-900) !important;border-color:var(--navy-900) !important;color:#fff !important;transform:translateY(-1px);box-shadow:0 6px 16px rgba(15,31,61,.3) !important}
.btn-gold{background:var(--gold-400) !important;border-color:var(--gold-400) !important;color:#fff !important}
.btn-gold:hover{background:var(--gold-500) !important;border-color:var(--gold-500) !important;color:#fff !important;transform:translateY(-1px);box-shadow:0 6px 16px rgba(245,158,11,.35) !important}
.btn-success{background:var(--green-500) !important;border-color:var(--green-500) !important;color:#fff !important}
.btn-success:hover{background:#15803d !important;border-color:#15803d !important;color:#fff !important;transform:translateY(-1px) !important}
.btn-danger{background:var(--red-500) !important;border-color:var(--red-500) !important;color:#fff !important}
.btn-danger:hover{background:#b91c1c !important;border-color:#b91c1c !important;color:#fff !important;transform:translateY(-1px) !important}
.btn-ghost{background:var(--surface) !important;border-color:var(--border) !important;color:var(--tx-2) !important}
.btn-ghost:hover{background:var(--bg) !important;border-color:#cbd5e1 !important;color:var(--tx-1) !important}
.btn-sm{padding:6px 13px !important;font-size:.77rem !important;border-radius:7px !important}
.btn-xs{padding:4px 10px !important;font-size:.71rem !important;border-radius:6px !important}

/* Icon action buttons */
.btn-ico{
  width:32px !important;height:32px !important;
  padding:0 !important;justify-content:center !important;
  border-radius:8px !important;flex-shrink:0;
}
.bv{background:#eff6ff !important;border-color:transparent !important;color:#1d4ed8 !important}
.bv:hover{background:#dbeafe !important}
.be{background:#fffbeb !important;border-color:transparent !important;color:#92400e !important}
.be:hover{background:#fef3c7 !important}
.bd{background:#fff1f2 !important;border-color:transparent !important;color:#be123c !important}
.bd:hover{background:#ffe4e6 !important}
.br{background:#f0fdf4 !important;border-color:transparent !important;color:#15803d !important}
.br:hover{background:#dcfce7 !important}

/* ═══════════════════════════════════════════════════
   FORM
═══════════════════════════════════════════════════ */
.form-card{
  background:var(--surface);border-radius:var(--radius);
  border:1px solid var(--border);box-shadow:var(--sh-sm);padding:26px;
}
.form-sec{
  display:flex;align-items:center;gap:8px;
  font-size:.67rem;font-weight:800;text-transform:uppercase;
  letter-spacing:.11em;color:var(--tx-3);
  padding-bottom:12px;border-bottom:2px solid var(--border-2);
  margin-bottom:20px;
}
.form-sec i{color:var(--blue-500);font-size:.9rem}
label.lbl{font-size:.8rem;font-weight:600;margin-bottom:6px;color:var(--tx-1);display:block}
.inp,.sel{
  width:100%;border:1.5px solid var(--border) !important;
  border-radius:var(--radius-sm) !important;
  font-size:.84rem !important;padding:10px 13px !important;
  font-family:'Inter',sans-serif !important;color:var(--tx-1) !important;
  background:var(--surface) !important;
  transition:border-color .18s,box-shadow .18s !important;
}
.inp:focus,.sel:focus{
  border-color:var(--blue-500) !important;
  box-shadow:0 0 0 3.5px rgba(37,99,235,.1) !important;
  outline:none !important;
}
.inp::placeholder{color:var(--tx-4) !important}
.form-control{
  border:1.5px solid var(--border) !important;
  border-radius:var(--radius-sm) !important;
  font-size:.84rem !important;padding:10px 13px !important;
  font-family:'Inter',sans-serif !important;color:var(--tx-1) !important;
  background:var(--surface) !important;
}
.form-control:focus{
  border-color:var(--blue-500) !important;
  box-shadow:0 0 0 3.5px rgba(37,99,235,.1) !important;
}
.form-select{
  border:1.5px solid var(--border) !important;
  border-radius:var(--radius-sm) !important;
  font-size:.84rem !important;padding:10px 13px !important;
  font-family:'Inter',sans-serif !important;color:var(--tx-1) !important;
}
.form-select:focus{border-color:var(--blue-500) !important;box-shadow:0 0 0 3.5px rgba(37,99,235,.1) !important}
.input-group-text{
  background:var(--surface-2) !important;
  border:1.5px solid var(--border) !important;
  color:var(--tx-3) !important;font-size:.85rem;
}
.input-group>.input-group-text:first-child{border-right:0 !important;border-radius:var(--radius-sm) 0 0 var(--radius-sm) !important}
.input-group>.input-group-text:last-child{border-left:0 !important;border-radius:0 var(--radius-sm) var(--radius-sm) 0 !important}
.input-group .form-control{border-radius:0 !important}
.input-group .form-control:last-child{border-radius:0 var(--radius-sm) var(--radius-sm) 0 !important}
textarea.form-control{resize:vertical;min-height:96px}
label.form-label{font-size:.8rem;font-weight:600;margin-bottom:6px;color:var(--tx-1)}
.form-text{font-size:.72rem;color:var(--tx-4);margin-top:5px}
.req{color:var(--red-500);margin-left:2px}

/* ═══════════════════════════════════════════════════
   TOOLBAR
═══════════════════════════════════════════════════ */
.toolbar{
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:12px;margin-bottom:22px;
}
.toolbar-right{display:flex;align-items:center;gap:8px;flex-wrap:wrap}

/* ═══════════════════════════════════════════════════
   BOOK GRID & CARD
═══════════════════════════════════════════════════ */
.book-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(152px,1fr));
  gap:18px;
}
@media(min-width:576px){.book-grid{grid-template-columns:repeat(auto-fill,minmax(164px,1fr))}}
@media(min-width:992px){.book-grid{grid-template-columns:repeat(auto-fill,minmax(178px,1fr))}}
@media(min-width:1400px){.book-grid{grid-template-columns:repeat(auto-fill,minmax(190px,1fr))}}

.book-card{
  background:var(--surface);
  border-radius:var(--radius);
  border:1px solid var(--border);
  box-shadow:var(--sh-sm);
  overflow:hidden;display:flex;flex-direction:column;
  transition:transform .25s var(--ease),box-shadow .25s var(--ease);
  cursor:pointer;
}
.book-card:hover{transform:translateY(-6px) scale(1.01);box-shadow:var(--sh-lg)}

/* Portrait 2:3 ratio */
.book-cover{
  position:relative;width:100%;padding-top:150%;
  overflow:hidden;background:#dde4ef;flex-shrink:0;
}
.book-cover img{
  position:absolute;inset:0;width:100%;height:100%;
  object-fit:cover;transition:transform .35s var(--ease);
}
.book-card:hover .book-cover img{transform:scale(1.07)}

/* Spine — realistic book edge */
.book-cover::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:9px;
  background:linear-gradient(to right,rgba(0,0,0,.3),rgba(0,0,0,.08) 60%,transparent);
  z-index:3;pointer-events:none;
}
/* Bottom gradient */
.book-cover::after{
  content:'';position:absolute;bottom:0;left:0;right:0;height:72px;
  background:linear-gradient(transparent,rgba(0,0,0,.32));
  z-index:2;pointer-events:none;
}
/* No-cover placeholder */
.book-ph{
  position:absolute;inset:0;
  display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  padding:14px;text-align:center;gap:7px;
}
.book-ph .p-ico{font-size:2.2rem;opacity:.65;line-height:1}
.book-ph .p-ttl{
  font-size:.7rem;font-weight:700;
  color:rgba(255,255,255,.9);line-height:1.3;
  overflow:hidden;display:-webkit-box;
  -webkit-line-clamp:3;-webkit-box-orient:vertical;
}
.book-ph .p-ath{font-size:.62rem;color:rgba(255,255,255,.55)}
/* Stok badge on cover */
.book-stok{
  position:absolute;top:8px;right:8px;z-index:4;
  font-size:.62rem;font-weight:700;padding:3px 8px;
  border-radius:6px;backdrop-filter:blur(8px);
}

/* Gradient palette */
.g0{background:linear-gradient(150deg,#0f1f3d 0%,#1e4080 100%)}
.g1{background:linear-gradient(150deg,#581c87 0%,#7c3aed 100%)}
.g2{background:linear-gradient(150deg,#064e3b 0%,#059669 100%)}
.g3{background:linear-gradient(150deg,#78350f 0%,#d97706 100%)}
.g4{background:linear-gradient(150deg,#881337 0%,#e11d48 100%)}
.g5{background:linear-gradient(150deg,#0c4a6e 0%,#0284c7 100%)}
.g6{background:linear-gradient(150deg,#1f2937 0%,#4b5563 100%)}
.g7{background:linear-gradient(150deg,#134e4a 0%,#0d9488 100%)}

/* Book body */
.book-body{padding:12px 13px 13px;flex:1;display:flex;flex-direction:column}
.book-cat{
  font-size:.59rem;font-weight:800;text-transform:uppercase;
  letter-spacing:.08em;color:var(--blue-500);margin-bottom:5px;
}
.book-title{
  font-size:.83rem;font-weight:700;color:var(--tx-1);
  line-height:1.35;margin-bottom:4px;
  overflow:hidden;display:-webkit-box;
  -webkit-line-clamp:2;-webkit-box-orient:vertical;
}
.book-author{font-size:.72rem;color:var(--tx-3);margin-bottom:10px}
.book-footer{
  margin-top:auto;display:flex;
  align-items:center;justify-content:space-between;gap:4px;
}

/* ═══════════════════════════════════════════════════
   WELCOME BANNER (siswa)
═══════════════════════════════════════════════════ */
.welcome{
  border-radius:18px;padding:24px 28px;color:#fff;
  background:linear-gradient(135deg,var(--navy-950) 0%,var(--navy-800) 40%,var(--navy-500) 100%);
  position:relative;overflow:hidden;margin-bottom:24px;
}
.welcome::before{
  content:'';position:absolute;right:-50px;top:-50px;
  width:200px;height:200px;border-radius:50%;
  background:rgba(255,255,255,.03);pointer-events:none;
}
.welcome::after{
  content:'';position:absolute;right:80px;bottom:-60px;
  width:150px;height:150px;border-radius:50%;
  background:rgba(245,158,11,.07);pointer-events:none;
}
.welcome-inner{position:relative;z-index:1}

/* Quick action cards */
.qa{
  display:flex;align-items:center;gap:16px;
  border-radius:16px;padding:20px 22px;color:#fff;
  text-decoration:none;
  transition:transform .22s var(--ease),box-shadow .22s var(--ease);
}
.qa:hover{transform:translateY(-4px);color:#fff}
.qa-gold{
  background:linear-gradient(135deg,var(--gold-400) 0%,var(--gold-500) 100%);
  box-shadow:0 6px 20px rgba(245,158,11,.32);
}
.qa-gold:hover{box-shadow:0 12px 32px rgba(245,158,11,.45)}
.qa-green{
  background:linear-gradient(135deg,#22c55e 0%,#16a34a 100%);
  box-shadow:0 6px 20px rgba(22,163,74,.28);
}
.qa-green:hover{box-shadow:0 12px 32px rgba(22,163,74,.42)}
.qa-icon{
  width:50px;height:50px;background:rgba(255,255,255,.2);
  border-radius:14px;display:flex;align-items:center;
  justify-content:center;font-size:1.35rem;flex-shrink:0;
}

/* ═══════════════════════════════════════════════════
   MISC
═══════════════════════════════════════════════════ */
/* Pagination */
.pagination{gap:4px;margin:0}
.page-link{
  border-radius:8px !important;font-size:.75rem !important;
  font-weight:600 !important;border:1.5px solid var(--border) !important;
  color:var(--tx-1) !important;padding:6px 11px !important;
  font-family:'Inter',sans-serif !important;
  transition:all .15s !important;
}
.page-link:hover{background:var(--bg) !important;border-color:#94a3b8 !important}
.page-item.active .page-link{
  background:var(--navy-800) !important;
  border-color:var(--navy-800) !important;color:#fff !important;
}
.page-item.disabled .page-link{opacity:.35}

/* Alert */
.alert{border-radius:var(--radius-sm);font-size:.83rem;font-weight:500}
.alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
.alert-danger{background:#fff1f2;border:1px solid #fecdd3;color:#be123c}
.alert-warning{background:#fffbeb;border:1px solid #fde68a;color:#92400e}
.alert-info{background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8}
.btn-close{padding:4px;opacity:.45}

/* Empty state */
.empty{text-align:center;padding:56px 20px;color:var(--tx-3)}
.empty-ico{font-size:3.5rem;opacity:.18;margin-bottom:16px;display:block}
.empty h6{font-weight:800;font-size:.94rem;color:var(--tx-1);margin-bottom:6px}
.empty p{font-size:.82rem;margin:0}

/* Card box */
.cbox{
  background:var(--surface);border-radius:var(--radius);
  border:1px solid var(--border);box-shadow:var(--sh-sm);
}
.cbox-header{
  padding:16px 20px;border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;
}
.cbox-header h6{font-size:.9rem;font-weight:800;margin:0;color:var(--navy-800)}
.cbox-body{padding:20px}

/* Info cell */
.info-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}
@media(min-width:576px){.info-grid-4{grid-template-columns:repeat(4,1fr)}}
.info-cell{background:var(--surface-2);border-radius:10px;padding:13px 15px;border:1px solid var(--border-2)}
.info-cell-label{font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--tx-4);margin-bottom:5px}
.info-cell-value{font-size:.88rem;font-weight:700;color:var(--tx-1)}

/* Cover frame (show) */
.cover-frame{
  border-radius:16px;overflow:hidden;
  box-shadow:var(--sh-lg);position:relative;
  width:100%;padding-top:150%;background:#dde4ef;
}
.cover-frame img,.cover-frame .book-ph{
  position:absolute;inset:0;width:100%;height:100%;
}
.cover-frame img{object-fit:cover}
.cover-spine{
  position:absolute;left:0;top:0;bottom:0;
  width:9px;
  background:linear-gradient(to right,rgba(0,0,0,.28),rgba(0,0,0,.06) 60%,transparent);
  z-index:2;pointer-events:none;
}

/* Cover preview in form */
.cover-preview{
  display:none;border-radius:10px;overflow:hidden;
  box-shadow:var(--sh-md);position:relative;
  width:100%;padding-top:150%;background:#dde4ef;margin-top:12px;
}
.cover-preview img,.cover-old{
  position:absolute;inset:0;width:100%;height:100%;object-fit:cover;
}
.cover-old-wrap{
  border-radius:10px;overflow:hidden;box-shadow:var(--sh-sm);
  position:relative;width:100%;padding-top:150%;
  background:#dde4ef;margin-bottom:12px;
}
.cover-old-wrap img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}

/* Profile */
.profile-ava{
  width:76px;height:76px;border-radius:50%;
  background:linear-gradient(135deg,var(--navy-800),var(--blue-500));
  display:flex;align-items:center;justify-content:center;
  font-size:1.9rem;font-weight:900;color:#fff;margin:0 auto 14px;
  box-shadow:0 6px 20px rgba(37,99,235,.28);
}
.profile-row{
  display:flex;align-items:flex-start;gap:10px;font-size:.82rem;
  padding:8px 0;border-bottom:1px solid var(--border-2);
}
.profile-row:last-of-type{border-bottom:none}
.profile-row i{color:var(--tx-4);flex-shrink:0;margin-top:1px}

/* Pengembalian card */
.ret-card{
  background:var(--surface);border-radius:var(--radius);
  border:1px solid var(--border);box-shadow:var(--sh-sm);
  overflow:hidden;display:flex;flex-direction:column;height:100%;
  transition:transform .2s,box-shadow .2s;
}
.ret-card:hover{transform:translateY(-3px);box-shadow:var(--sh-md)}
.ret-card-blue{border-top:3px solid var(--blue-500)}
.ret-card-red{border-top:3px solid var(--red-500)}
.ret-head{padding:16px 18px 0}
.ret-body{padding:12px 18px;flex:1}
.ret-foot{padding:0 18px 18px}
.date-cell{background:var(--surface-2);border-radius:9px;padding:10px 12px;border:1px solid var(--border-2)}
.date-cell-red{background:#fff1f2;border-color:#fecdd3}
.date-cell label{font-size:.61rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--tx-4);display:block;margin-bottom:3px}
.date-cell p{font-size:.82rem;font-weight:700;margin:0;color:var(--tx-1)}
.date-cell-red p{color:var(--red-500)}

/* Fine box */
.fine{border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:12px}
.fine-red{background:#fff1f2;border:1px solid #fecdd3}
.fine-green{background:#f0fdf4;border:1px solid #bbf7d0}

/* ═══════════════════════════════════════════════════
   AUTH PAGES
═══════════════════════════════════════════════════ */
.auth-bg{
  min-height:100vh;
  background-image:url('/image/loginbg.png');
  background-size:cover;background-position:center;
  display:flex;align-items:center;justify-content:center;padding:28px;
}
@media(max-width:576px){
  .auth-bg{background-image:url('/image/bgmobile.png');align-items:flex-start;padding-top:32px}
}
.auth-card{
  background:rgba(255,255,255,.93);
  backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
  border-radius:22px;padding:44px 40px;
  width:100%;max-width:400px;
  box-shadow:var(--sh-xl);
}
@media(max-width:576px){.auth-card{padding:32px 24px}}

.reg-bg{
  min-height:100vh;
  background-image:url('/image/loginbg.png');
  background-size:cover;background-position:center;
  background-attachment:fixed;
  display:flex;align-items:flex-start;
  justify-content:center;padding:32px 20px;
}
@media(max-width:576px){.reg-bg{background-image:url('/image/bgmobile.png');padding:20px 14px}}
.reg-card{
  background:rgba(255,255,255,.93);
  backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
  border-radius:22px;padding:40px 36px;
  width:100%;max-width:530px;
  box-shadow:var(--sh-xl);
}
@media(max-width:576px){.reg-card{padding:28px 20px}}

/* ═══════════════════════════════════════════════════
   SIDEBAR COLLAPSE  (desktop toggle)
═══════════════════════════════════════════════════ */
/* Sidebar transitions */
.sidebar{transition:width .3s var(--ease),transform .3s var(--ease)}
.app-main{transition:margin-left .3s var(--ease)}

/* Collapsed state — hanya icon */
.sidebar.collapsed{width:var(--sb-collapsed,68px)}

/* Hide text labels when collapsed */
.sidebar.collapsed .sb-brand-txt,
.sidebar.collapsed .sb-uname,
.sidebar.collapsed .sb-badge,
.sidebar.collapsed .sb-section,
.sidebar.collapsed .sb-item-label{
  opacity:0;max-width:0;overflow:hidden;
  transition:opacity .2s,max-width .2s;
  pointer-events:none;white-space:nowrap;
}
/* Center brand logo */
.sidebar.collapsed .sb-brand{justify-content:center;padding:16px 12px;gap:0}
/* Center user avatar */
.sidebar.collapsed .sb-user{justify-content:center;padding:9px;gap:0}
.sidebar.collapsed .sb-user>div:last-child{display:none}
/* Center nav items */
.sidebar.collapsed .sb-item{
  justify-content:center;padding:9px 0;
  margin:2px 10px;width:calc(100% - 20px);gap:0;
}
/* Hide section labels */
.sidebar.collapsed .sb-section{padding:8px 0;text-align:center;font-size:.5rem}
/* Center footer */
.sidebar.collapsed .sb-footer form button{justify-content:center;padding:9px 0}
/* Center icon size */
.sidebar.collapsed .sb-icon{width:32px;height:32px}
/* Main shifts */
.app-main.sb-collapsed{margin-left:var(--sb-collapsed,68px)}

/* Tooltip for collapsed items */
.sidebar.collapsed .sb-item{position:relative}
.sidebar.collapsed .sb-item:hover::after{
  content:attr(data-label);
  position:absolute;left:calc(100% + 10px);top:50%;
  transform:translateY(-50%);
  background:var(--navy-800);color:#fff;
  font-size:.76rem;font-weight:600;
  padding:5px 10px;border-radius:7px;
  white-space:nowrap;z-index:2000;
  box-shadow:var(--sh-md);
  pointer-events:none;
}
.sidebar.collapsed .sb-item:hover::before{
  content:'';
  position:absolute;left:calc(100% + 4px);top:50%;
  transform:translateY(-50%);
  border:5px solid transparent;
  border-right-color:var(--navy-800);
  z-index:2000;pointer-events:none;
}

/* ═══════════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════════ */
@media(max-width:991.98px){
  .sidebar{transform:translateX(calc(-1 * var(--sb-w)))}
  .sidebar.open{transform:translateX(0);box-shadow:var(--sh-xl)}
  .sidebar.collapsed{transform:translateX(calc(-1 * var(--sb-collapsed,68px)))}
  .sidebar.collapsed.open{transform:translateX(0)}
  .app-main{margin-left:0 !important}
  .app-main.sb-collapsed{margin-left:0 !important}
}
@media(max-width:767.98px){
  .app-content{padding:16px}
  .topbar{padding:0 16px}
  .stat-num{font-size:1.55rem}
  .stat-card{padding:16px 18px;gap:13px}
  .stat-icon-wrap{width:46px;height:46px;font-size:1.2rem;border-radius:12px}
  .book-grid{gap:12px}
}
@media(max-width:575.98px){
  .app-content{padding:12px}
  .form-card{padding:18px}
  .book-grid{grid-template-columns:repeat(2,1fr);gap:10px}
  .topbar-chip-name{display:none}
}
</style>
@stack('styles')
</head>
<body>
@auth
<div class="sb-overlay" id="sbOverlay" onclick="closeSB()"></div>
<div class="app-wrap">

  {{-- ══ SIDEBAR ══ --}}
  <nav class="sidebar" id="sidebar">
    <div class="sb-brand">
      <div class="sb-logo"><i class="bi bi-book-half"></i></div>
      <div class="sb-brand-txt">
        <strong>Perpustakaan<br>Sekolah Digital</strong>
        <span>Library Management System</span>
      </div>
    </div>

    <div class="sb-user">
      <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div style="min-width:0;flex:1">
        <div class="sb-uname">{{ Str::limit(auth()->user()->name,20) }}</div>
        <span class="sb-badge {{ auth()->user()->isAdmin()?'sb-badge-admin':'sb-badge-siswa' }}">
          {{ auth()->user()->isAdmin() ? '⚡ Administrator' : '📚 Siswa' }}
        </span>
      </div>
    </div>

    <div class="sb-nav">
      @if(auth()->user()->isAdmin())
        <div class="sb-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}" data-label="Dashboard" class="sb-item {{ request()->routeIs('admin.dashboard')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-grid-1x2-fill"></i></span><span class="sb-item-label">Dashboard</span>
        </a>
        <div class="sb-section">Data Master</div>
        <a href="{{ route('admin.buku.index') }}" data-label="Data Buku" class="sb-item {{ request()->routeIs('admin.buku.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-journal-bookmark-fill"></i></span><span class="sb-item-label">Data Buku</span>
        </a>
        <a href="{{ route('admin.anggota.index') }}" data-label="Kelola Anggota" class="sb-item {{ request()->routeIs('admin.anggota.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-people-fill"></i></span><span class="sb-item-label">Kelola Anggota</span>
        </a>
        <div class="sb-section">Transaksi</div>
        <a href="{{ route('admin.transaksi.index') }}" data-label="Peminjaman" class="sb-item {{ request()->routeIs('admin.transaksi.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-arrow-left-right"></i></span><span class="sb-item-label">Peminjaman</span>
        </a>
      @else
        <div class="sb-section">Menu Utama</div>
        <a href="{{ route('siswa.dashboard') }}" data-label="Dashboard" class="sb-item {{ request()->routeIs('siswa.dashboard')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-grid-1x2-fill"></i></span><span class="sb-item-label">Dashboard</span>
        </a>
        <div class="sb-section">Perpustakaan</div>
        <a href="{{ route('siswa.peminjaman.create') }}" data-label="Pinjam Buku" class="sb-item {{ request()->routeIs('siswa.peminjaman.create')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-book-fill"></i></span><span class="sb-item-label">Pinjam Buku</span>
        </a>
        <a href="{{ route('siswa.peminjaman.index') }}" data-label="Riwayat Pinjam" class="sb-item {{ request()->routeIs('siswa.peminjaman.index')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-card-list"></i></span><span class="sb-item-label">Riwayat Pinjam</span>
        </a>
        <a href="{{ route('siswa.pengembalian.index') }}" data-label="Pengembalian" class="sb-item {{ request()->routeIs('siswa.pengembalian.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-box-arrow-in-left"></i></span><span class="sb-item-label">Pengembalian</span>
        </a>
      @endif
    </div>

    <div class="sb-footer">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" data-label="Keluar" class="sb-item" style="color:rgba(252,165,165,.75)">
          <span class="sb-icon" style="background:rgba(220,38,38,.12)"><i class="bi bi-box-arrow-right"></i></span>
          <span class="sb-item-label">Keluar</span>
        </button>
      </form>
    </div>
  </nav>

  {{-- ══ MAIN ══ --}}
  <div class="app-main">
    <header class="topbar">
      <div class="topbar-left">
        {{-- Desktop: collapse toggle --}}
        <button class="btn btn-ghost btn-sm d-none d-lg-flex" id="sbToggle" onclick="toggleSB()" style="padding:7px 9px;border-radius:8px" title="Sembunyikan/tampilkan sidebar">
          <i class="bi bi-layout-sidebar" style="font-size:1.1rem"></i>
        </button>
        {{-- Mobile: open sidebar --}}
        <button class="btn btn-ghost btn-sm d-lg-none" onclick="openSB()" style="padding:7px 9px">
          <i class="bi bi-list" style="font-size:1.2rem"></i>
        </button>
        <span class="topbar-title">@yield('page-title','Dashboard')</span>
      </div>
      <div class="topbar-right">
        <span class="d-none d-md-flex" style="font-size:.74rem;color:var(--tx-3);background:var(--bg);padding:5px 12px;border-radius:20px;border:1px solid var(--border);gap:6px;align-items:center">
          <i class="bi bi-calendar3"></i>{{ date('l, d F Y') }}
        </span>
        <div class="topbar-chip">
          <div class="topbar-chip-ava">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
          <span class="topbar-chip-name">{{ Str::limit(auth()->user()->name,16) }}</span>
        </div>
      </div>
    </header>

    @if(session('success')||session('error')||session('warning'))
    <div class="flash-area">
      @if(session('success'))
      <div class="flash-msg flash-success">
        <i class="bi bi-check-circle-fill" style="flex-shrink:0;font-size:1rem"></i>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;font-size:1.1rem;line-height:1;opacity:.5;padding:0 4px">&times;</button>
      </div>
      @endif
      @if(session('error'))
      <div class="flash-msg flash-danger">
        <i class="bi bi-exclamation-circle-fill" style="flex-shrink:0;font-size:1rem"></i>
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;font-size:1.1rem;line-height:1;opacity:.5;padding:0 4px">&times;</button>
      </div>
      @endif
      @if(session('warning'))
      <div class="flash-msg flash-warning">
        <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;font-size:1rem"></i>
        <span>{{ session('warning') }}</span>
        <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;font-size:1.1rem;line-height:1;opacity:.5;padding:0 4px">&times;</button>
      </div>
      @endif
    </div>
    @endif

    <main class="app-content">@yield('content')</main>
  </div>
</div>

<script>
const SB_KEY = 'sb_collapsed';
const sidebar = document.getElementById('sidebar');
const main    = document.querySelector('.app-main');
const overlay = document.getElementById('sbOverlay');
const toggleBtn = document.getElementById('sbToggle');

/* ── Init from localStorage ── */
if(localStorage.getItem(SB_KEY)==='1'){
  sidebar.classList.add('collapsed');
  main.classList.add('sb-collapsed');
  if(toggleBtn) toggleBtn.querySelector('i').className='bi bi-layout-sidebar-reverse';
}

/* ── Desktop toggle ── */
function toggleSB(){
  const collapsed = sidebar.classList.toggle('collapsed');
  main.classList.toggle('sb-collapsed', collapsed);
  localStorage.setItem(SB_KEY, collapsed?'1':'0');
  if(toggleBtn){
    toggleBtn.querySelector('i').className = collapsed
      ? 'bi bi-layout-sidebar-reverse'
      : 'bi bi-layout-sidebar';
  }
}

/* ── Mobile open/close ── */
function openSB(){
  sidebar.classList.add('open');
  overlay.classList.add('show');
  document.body.style.overflow='hidden';
}
function closeSB(){
  sidebar.classList.remove('open');
  overlay.classList.remove('show');
  document.body.style.overflow='';
}
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeSB()})
</script>

@else
@yield('content')
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

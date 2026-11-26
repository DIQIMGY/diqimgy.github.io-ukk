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
<script>if(localStorage.getItem('library_theme')==='dark')document.documentElement.classList.add('theme-dark');</script>
<style>
/* ═══════════════════════════════════════════════════
   DESIGN SYSTEM — PERPUSTAKAAN SEKOLAH DIGITAL
   Theme: Premium Navy & Gold
═══════════════════════════════════════════════════ */
:root{
  /* Core palette — CRIMSON THEME */
  --crimson:#ED1B3B;
  --crimson-dark:#C41630;
  --crimson-darker:#A01228;
  
  --navy-950:#06101F;
  --navy-900:#0B1730;
  --navy-800:#14284B;
  --navy-700:#1A3461;
  --navy-600:#2055A5;
  --navy-500:#2D6DB5;
  --navy-400:#4A7FC4;
  --navy-300:#6B9ED9;

  --gold-400:#F4B942;
  --gold-500:#E5A623;
  --gold-300:#F9C85A;
  --gold-100:#FEF3C7;

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
  --bg:#F5F7FA;
  --surface:#FFFFFF;
  --surface-2:#F8FAFC;
  --border:#E5E7EB;
  --border-2:#F3F4F6;

  /* Text */
  --tx-1:#1F2937;
  --tx-2:#374151;
  --tx-3:#6B7280;
  --tx-4:#9CA3AF;

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
html.theme-dark{
  --bg:#0f172a;--surface:#172033;--surface-2:#1e293b;
  --border:#334155;--border-2:#273449;
  --tx-1:#f8fafc;--tx-2:#dbe4f0;--tx-3:#a8b5c7;--tx-4:#7f8da3;
  --blue-100:#172554;--green-100:#052e16;--red-100:#450a0a;
  --yellow-100:#422006;--sky-100:#082f49;--violet-100:#2e1065;
}

/* ── RESET ── */
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{
  font-family:'Inter',system-ui,sans-serif;
  background:var(--bg);color:var(--tx-1);
  font-size:14px;line-height:1.5;
  -webkit-font-smoothing:antialiased;
  transition:background-color .25s ease,color .25s ease;
}
html.theme-dark body{color-scheme:dark}
html.theme-dark .app-content input,
html.theme-dark .app-content select,
html.theme-dark .app-content textarea,
html.theme-dark .app-content .form-control,
html.theme-dark .app-content .form-select{background:var(--surface);color:var(--tx-1);border-color:var(--border)}
html.theme-dark .app-content .card,
html.theme-dark .app-content .table,
html.theme-dark .app-content .modal-content,
html.theme-dark .app-content .dropdown-menu{background:var(--surface);color:var(--tx-1);border-color:var(--border)}
html.theme-dark .app-content .table{--bs-table-bg:var(--surface);--bs-table-color:var(--tx-1);--bs-table-border-color:var(--border)}
html.theme-dark .app-content .text-muted{color:var(--tx-3)!important}
a{text-decoration:none;color:inherit}
::-webkit-scrollbar{width:5px;height:5px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:99px}
::-webkit-scrollbar-thumb:hover{background:#94a3b8}

/* ═══════════════════════════════════════════════════
   APP SHELL
═══════════════════════════════════════════════════ */
.app-wrap{display:flex;min-height:100vh}

/* ══════════════════════════════════════════════════════════
   MODERN NAVBAR & SIDEBAR - Premium Redesign
══════════════════════════════════════════════════════════ */

/* ── SIDEBAR ── */
.sidebar{
  position:fixed;top:0;left:0;
  width:var(--sb-w);height:100vh;
  background:linear-gradient(165deg, #0f1f3d 0%, #1a2c52 50%, #0d1830 100%);
  display:flex;flex-direction:column;
  z-index:1050;
  transition:transform .3s var(--ease);
  overflow:hidden;
  border-right:1px solid rgba(255,255,255,.05);
}

/* Modern blur backdrop effect */
.sidebar::before{
  content:'';position:absolute;inset:0;
  background:url('data:image/svg+xml,<svg width="400" height="400" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="a" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="%23ED1B3B" stop-opacity=".03"/><stop offset="100%" stop-color="%236B9ED9" stop-opacity=".02"/></linearGradient></defs><circle cx="200" cy="200" r="200" fill="url(%23a)"/></svg>');
  background-size:cover;
  opacity:.5;
  animation:floatBg 30s ease-in-out infinite;
  pointer-events:none;
}

@keyframes floatBg {
  0%, 100% { transform: translateY(0) scale(1); }
  50% { transform: translateY(-20px) scale(1.05); }
}

@keyframes pulse {
  0%, 100% { transform: scale(1); opacity: 0.8; }
  50% { transform: scale(1.1); opacity: 1; }
}

/* Brand - Clean Minimal */
.sb-brand{
  padding:24px 20px 20px;
  display:flex;align-items:center;gap:12px;
  flex-shrink:0;position:relative;z-index:1;
  border-bottom:1px solid rgba(255,255,255,.06);
}

.sb-logo{
  width:44px;height:44px;border-radius:12px;
  background:#fff;
  display:flex;align-items:center;justify-content:center;
  flex-shrink:0;
  box-shadow:0 8px 24px rgba(0,0,0,.2), 0 2px 8px rgba(0,0,0,.15);
  overflow:hidden;
}

.sb-brand-txt strong{
  display:block;color:#fff;font-size:.88rem;
  font-weight:900;line-height:1.25;
  letter-spacing:-.03em;
}

.sb-brand-txt span{
  color:rgba(255,255,255,.35);
  font-size:.68rem;
  font-weight:600;
  letter-spacing:.02em;
}

/* User Profile Card - Premium Glass Effect */
.sb-user{
  margin:16px 14px 12px;
  padding:16px;
  background:linear-gradient(135deg, rgba(255,255,255,.12) 0%, rgba(255,255,255,.06) 100%);
  backdrop-filter:blur(40px) saturate(180%);
  -webkit-backdrop-filter:blur(40px) saturate(180%);
  border:1px solid rgba(255,255,255,.15);
  border-radius:16px;
  display:flex;align-items:center;gap:12px;
  flex-shrink:0;position:relative;z-index:1;
  box-shadow:0 8px 32px rgba(0,0,0,.18),
              0 2px 8px rgba(0,0,0,.1),
              inset 0 1px 0 rgba(255,255,255,.15);
  transition:all .35s cubic-bezier(.4,0,.2,1);
  overflow:hidden;
}

.sb-user::before{
  content:'';position:absolute;top:0;left:0;right:0;
  height:1px;
  background:linear-gradient(90deg, transparent, rgba(255,255,255,.2), transparent);
}

.sb-user:hover {
  background:linear-gradient(135deg, rgba(237,27,59,.15) 0%, rgba(255,255,255,.08) 100%);
  border-color:rgba(237,27,59,.25);
  transform:translateY(-2px);
  box-shadow:0 12px 40px rgba(237,27,59,.25),
              0 4px 12px rgba(0,0,0,.15);
}

.sb-avatar{
  width:48px;height:48px;border-radius:50%;
  background:linear-gradient(135deg,#ED1B3B 0%, #C41630 100%);
  display:flex;align-items:center;justify-content:center;
  font-size:.95rem;font-weight:900;color:#fff;flex-shrink:0;
  box-shadow:0 6px 20px rgba(237,27,59,.4),
              0 2px 8px rgba(0,0,0,.2),
              inset 0 -3px 10px rgba(0,0,0,.25);
  border:3px solid rgba(255,255,255,.2);
  position:relative;
}

.sb-avatar::after{
  content:'';
  position:absolute;inset:4px;
  border-radius:50%;
  border:1px solid rgba(255,255,255,.15);
}

.sb-uname{
  color:#fff;
  font-size:.88rem;
  font-weight:800;
  line-height:1.3;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  text-shadow:0 1px 2px rgba(0,0,0,.2);
}

.sb-badge{
  font-size:.64rem;
  font-weight:800;
  padding:4px 10px;
  border-radius:8px;
  display:inline-flex;
  align-items:center;
  gap:5px;
  margin-top:4px;
  letter-spacing:.03em;
  text-transform:uppercase;
  box-shadow:0 2px 8px rgba(0,0,0,.15);
}

.sb-badge-admin{
  background:linear-gradient(135deg, rgba(239,68,68,.25), rgba(220,38,38,.2));
  color:#fecaca;
  border:1px solid rgba(239,68,68,.3);
}

.sb-badge-siswa{
  background:linear-gradient(135deg, rgba(59,130,246,.25), rgba(37,99,235,.2));
  color:#bfdbfe;
  border:1px solid rgba(59,130,246,.3);
}

/* Nav - Modern Style */
.sb-nav{
  flex:1;
  overflow-y:auto;
  padding:12px 0 20px;
  position:relative;
  z-index:1;
}

.sb-nav::-webkit-scrollbar{width:4px}
.sb-nav::-webkit-scrollbar-track{background:transparent}
.sb-nav::-webkit-scrollbar-thumb{background:rgba(255,255,255,.12);border-radius:99px}
.sb-nav::-webkit-scrollbar-thumb:hover{background:rgba(255,255,255,.2)}

.sb-section{
  font-size:.62rem;
  font-weight:900;
  text-transform:uppercase;
  letter-spacing:.15em;
  color:rgba(255,255,255,.28);
  padding:24px 20px 10px;
  position:relative;
}

.sb-section::before{
  content:'';
  position:absolute;
  bottom:0;left:20px;right:20px;
  height:1px;
  background:linear-gradient(90deg, transparent, rgba(255,255,255,.08), transparent);
}

.sb-item{
  display:flex;
  align-items:center;
  gap:12px;
  margin:4px 14px;
  padding:12px 16px;
  border-radius:12px;
  color:rgba(255,255,255,.65);
  font-size:.85rem;
  font-weight:600;
  transition:all .25s cubic-bezier(.4,0,.2,1);
  border:none;
  background:transparent;
  width:calc(100% - 28px);
  text-align:left;
  cursor:pointer;
  white-space:nowrap;
  position:relative;
  overflow:hidden;
}

.sb-item::before {
  content: '';
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 3px;
  height: 0;
  background: linear-gradient(180deg, var(--crimson), var(--crimson-dark));
  border-radius: 0 99px 99px 0;
  box-shadow: 0 0 12px rgba(237,27,59,.6);
  transition: height .3s cubic-bezier(.4,0,.2,1);
}

.sb-item:hover{
  background:rgba(255,255,255,.08);
  color:rgba(255,255,255,.95);
  transform: translateX(2px);
}

.sb-item:hover::before {
  height: 50%;
}

.sb-item.active{
  background:linear-gradient(90deg,rgba(237,27,59,.2) 0%,rgba(237,27,59,.08) 50%,transparent 100%);
  color:#fff;
  font-weight:700;
  border:1px solid rgba(237,27,59,.2);
  box-shadow:0 4px 20px rgba(237,27,59,.15),
              inset 0 1px 0 rgba(255,255,255,.08);
}

.sb-item.active::before {
  height: 80%;
}

.sb-icon{
  width:38px;
  height:38px;
  border-radius:11px;
  background:rgba(255,255,255,.06);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:1rem;
  flex-shrink:0;
  transition:all .25s cubic-bezier(.4,0,.2,1);
  border:1px solid rgba(255,255,255,.08);
}

.sb-item.active .sb-icon{
  background:linear-gradient(135deg,#ED1B3B 0%, #C41630 100%);
  box-shadow:0 6px 20px rgba(237,27,59,.5),
              0 2px 8px rgba(0,0,0,.2),
              inset 0 1px 2px rgba(255,255,255,.25);
  color:#fff;
  transform:scale(1.08);
  border-color:transparent;
}

.sb-item:hover .sb-icon{
  background:rgba(255,255,255,.12);
  border-color:rgba(255,255,255,.15);
  transform:scale(1.05);
}

.sb-item-label{
  flex:1;
  letter-spacing:-.01em;
}

/* Sidebar footer - Modern */
.sb-footer{
  padding:16px 14px;
  border-top:1px solid rgba(255,255,255,.06);
  flex-shrink:0;
  position:relative;
  z-index:1;
  background:rgba(0,0,0,.2);
  backdrop-filter:blur(20px);
}

.sb-footer button{
  width:100%;
  padding:12px 16px;
  background:rgba(255,255,255,.08);
  border:1px solid rgba(255,255,255,.12);
  border-radius:12px;
  color:rgba(255,255,255,.7);
  font-size:.82rem;
  font-weight:700;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:10px;
  transition:all .25s;
}

.sb-footer button:hover{
  background:rgba(239,68,68,.15);
  border-color:rgba(239,68,68,.3);
  color:#fca5a5;
  transform:translateY(-2px);
  box-shadow:0 6px 20px rgba(239,68,68,.25);
}

/* Refined library sidebar */
.sidebar{
  width:276px;
  background:linear-gradient(165deg,#0d1830 0%,#1a2c52 40%,#0f1f3d 100%);
  border-right:1px solid rgba(255,255,255,.08);
  box-shadow:4px 0 32px rgba(0,0,0,.2);
}
.sidebar::before{
  width:320px;height:320px;top:-180px;right:-150px;
  background:radial-gradient(circle,rgba(237,27,59,.12),transparent 68%);
  animation:pulse 20s ease-in-out infinite;
}
.sidebar::after{
  width:240px;height:240px;bottom:-150px;left:-130px;
  background:radial-gradient(circle,rgba(96,165,250,.08),transparent 68%);
  animation:pulse 25s ease-in-out infinite reverse;
}
.sb-brand{
  min-height:82px;padding:17px 18px;gap:12px;
  border-bottom-color:rgba(255,255,255,.1);
  background:rgba(255,255,255,.025);
}
.sb-logo{
  width:44px;height:44px;border-radius:12px;
  box-shadow:0 8px 18px rgba(0,0,0,.2),0 0 0 1px rgba(255,255,255,.16);
}
.sb-brand-txt strong{font-size:.82rem;letter-spacing:.01em;}
.sb-brand-txt span{
  display:inline-block;margin-top:5px;color:rgba(255,255,255,.42);
  font-size:.6rem;letter-spacing:.08em;text-transform:uppercase;
}
.sb-user{
  margin:16px 14px 12px;padding:16px;
  background:linear-gradient(135deg, rgba(255,255,255,.12) 0%, rgba(255,255,255,.06) 100%);
  backdrop-filter:blur(40px) saturate(180%);
  -webkit-backdrop-filter:blur(40px) saturate(180%);
  border:1px solid rgba(255,255,255,.15);
  border-radius:14px;box-shadow:0 8px 32px rgba(0,0,0,.18),
              0 2px 8px rgba(0,0,0,.1),
              inset 0 1px 0 rgba(255,255,255,.15);
}
}
.sb-user:hover{background:rgba(255,255,255,.09);border-color:rgba(255,255,255,.16);}
.sb-avatar{width:38px;height:38px;box-shadow:0 4px 12px rgba(237,27,59,.28);}
.sb-uname{font-size:.8rem;}
.sb-badge{margin-top:5px;padding:3px 8px;border-radius:5px;font-size:.58rem;letter-spacing:.08em;}
.sb-badge-admin{background:rgba(244,185,66,.14);color:#f8cf70;box-shadow:none;}
.sb-badge-siswa{background:rgba(96,165,250,.14);color:#a9d1ff;box-shadow:none;}
.sb-nav{padding:10px 0 16px;}
.sb-section{padding:18px 20px 7px;color:rgba(255,255,255,.32);font-size:.57rem;letter-spacing:.18em;}
.sb-item{margin:3px 12px;width:calc(100% - 24px);min-height:44px;padding:7px 12px;gap:11px;border-radius:10px;color:rgba(255,255,255,.58);font-size:.8rem;font-weight:600;}
.sb-item::before{left:-1px;width:3px;background:#f4b942;box-shadow:0 0 12px rgba(244,185,66,.55);}
.sb-item:hover{background:rgba(255,255,255,.065);color:#fff;transform:translateX(3px);}
.sb-item.active{background:linear-gradient(90deg,rgba(237,27,59,.2),rgba(237,27,59,.07));color:#fff;box-shadow:inset 0 0 0 1px rgba(237,27,59,.12),0 6px 18px rgba(6,16,31,.16);}
.sb-item.active::before{height:62%;}
.sb-icon{width:34px;height:34px;border-radius:9px;background:rgba(255,255,255,.055);color:rgba(255,255,255,.65);font-size:.88rem;}
.sb-item.active .sb-icon{
  background:linear-gradient(135deg,#ED1B3B 0%, #C41630 100%);
  box-shadow:0 6px 20px rgba(237,27,59,.5),
              0 2px 8px rgba(0,0,0,.2),
              inset 0 1px 2px rgba(255,255,255,.25);
  color:#fff;
  transform:scale(1.08);
  border-color:transparent;
}
.sb-item:hover .sb-icon{
  background:rgba(255,255,255,.12);
  border-color:rgba(255,255,255,.15);
  transform:scale(1.05);
}

/* ── MAIN ── */
.app-main{
  flex:1;min-width:0;
  margin-left:276px;
  display:flex;flex-direction:column;
  min-height:100vh;
}

/* ── TOPBAR - Modern Clean Style ── */
.topbar{
  height:var(--topbar-h);
  background:var(--surface);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;
  justify-content:space-between;
  padding:0 28px;
  position:sticky;top:0;z-index:999;
  box-shadow:0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.03);
  flex-shrink:0;
  backdrop-filter:blur(20px);
  -webkit-backdrop-filter:blur(20px);
}

.topbar-left{
  display:flex;
  align-items:center;
  gap:16px;
}

.topbar-title{
  font-size:1.05rem;
  font-weight:900;
  color:var(--navy-800);
  letter-spacing:-.02em;
  display:flex;
  align-items:center;
  gap:10px;
}

.topbar-title i {
  font-size:1.2rem;
  color:var(--crimson);
}

.topbar-right{
  display:flex;
  align-items:center;
  gap:12px;
}

/* Notification Bell - Modern */
.notif-btn {
  width:40px;
  height:40px;
  border-radius:12px;
  background:var(--bg);
  border:1px solid var(--border);
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  transition:all .2s;
  position:relative;
}

.notif-btn:hover {
  background:#fff;
  border-color:var(--crimson);
  color:var(--crimson);
  transform:translateY(-2px);
  box-shadow:0 4px 12px rgba(237,27,59,.15);
}

.notif-badge {
  position:absolute;
  top:-4px;
  right:-4px;
  width:18px;
  height:18px;
  border-radius:50%;
  background:var(--crimson);
  color:#fff;
  font-size:.65rem;
  font-weight:800;
  display:flex;
  align-items:center;
  justify-content:center;
  box-shadow:0 2px 8px rgba(237,27,59,.4);
  border:2px solid var(--surface);
}

/* User Chip - Modern Glassmorphism */
.topbar-chip{
  display:flex;
  align-items:center;
  gap:10px;
  background:linear-gradient(135deg, rgba(255,255,255,.9), rgba(245,247,250,.9));
  backdrop-filter:blur(20px);
  -webkit-backdrop-filter:blur(20px);
  border:1px solid rgba(237,27,59,.15);
  border-radius:14px;
  padding:6px 14px 6px 6px;
  box-shadow:0 4px 16px rgba(237,27,59,.08),
              inset 0 1px 0 rgba(255,255,255,.5);
  transition:all .3s;
  cursor:pointer;
}

.topbar-chip:hover {
  border-color:var(--crimson);
  box-shadow:0 6px 20px rgba(237,27,59,.15);
  transform:translateY(-2px);
}

.topbar-chip-ava{
  width:32px;
  height:32px;
  border-radius:50%;
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:.72rem;
  font-weight:900;
  color:#fff;
  flex-shrink:0;
  box-shadow:0 3px 10px rgba(237,27,59,.4),
              inset 0 -2px 6px rgba(0,0,0,.15);
  border:2px solid rgba(255,255,255,.3);
}

.topbar-chip-name{
  font-size:.82rem;
  font-weight:700;
  color:var(--navy-800);
  letter-spacing:-.01em;
}

/* Content */
.app-content{padding:24px;flex:1}
.app-content{
  position:relative;
  isolation:isolate;
}
.app-content::before{
  content:'';
  position:absolute;
  inset:0 0 auto;
  height:220px;
  background:linear-gradient(180deg,rgba(255,255,255,.65),transparent);
  pointer-events:none;
  z-index:-1;
}

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
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
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
.btn-primary{background:var(--crimson) !important;border-color:var(--crimson) !important;color:#fff !important}
.btn-primary:hover{background:var(--crimson-dark) !important;border-color:var(--crimson-dark) !important;color:#fff !important;transform:translateY(-1px);box-shadow:0 6px 16px rgba(237,27,59,.32) !important}
.btn-navy{background:var(--navy-800) !important;border-color:var(--navy-800) !important;color:#fff !important}
.btn-navy:hover{background:var(--navy-900) !important;border-color:var(--navy-900) !important;color:#fff !important;transform:translateY(-1px);box-shadow:0 6px 16px rgba(20,40,75,.3) !important}
.btn-gold{background:var(--gold-400) !important;border-color:var(--gold-400) !important;color:var(--navy-900) !important;font-weight:700 !important}
.btn-gold:hover{background:var(--gold-500) !important;border-color:var(--gold-500) !important;color:var(--navy-900) !important;transform:translateY(-1px);box-shadow:0 6px 16px rgba(244,185,66,.35) !important}
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
  border-color:var(--crimson) !important;
  box-shadow:0 0 0 3.5px rgba(237,27,59,.12) !important;
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
  border-color:var(--crimson) !important;
  box-shadow:0 0 0 3.5px rgba(237,27,59,.12) !important;
}
.form-select{
  border:1.5px solid var(--border) !important;
  border-radius:var(--radius-sm) !important;
  font-size:.84rem !important;padding:10px 13px !important;
  font-family:'Inter',sans-serif !important;color:var(--tx-1) !important;
}
.form-select:focus{border-color:var(--crimson) !important;box-shadow:0 0 0 3.5px rgba(237,27,59,.12) !important}
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
  letter-spacing:.08em;color:var(--crimson);margin-bottom:5px;
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
  background:linear-gradient(135deg,var(--crimson) 0%,var(--crimson-dark) 100%);
  box-shadow:0 6px 20px rgba(237,27,59,.32);
}
.qa-gold:hover{box-shadow:0 12px 32px rgba(237,27,59,.45)}
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
  background:var(--crimson) !important;
  border-color:var(--crimson) !important;color:#fff !important;
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
  border:1px solid rgba(229,231,235,.9);box-shadow:var(--sh-sm);
  overflow:hidden;
  transition:box-shadow .24s var(--ease),border-color .24s var(--ease),transform .24s var(--ease);
}
.cbox:hover{border-color:#dbe2ea;box-shadow:var(--sh-md)}
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
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  display:flex;align-items:center;justify-content:center;
  font-size:1.9rem;font-weight:900;color:#fff;margin:0 auto 14px;
  box-shadow:0 6px 20px rgba(237,27,59,.35);
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
html.theme-dark .auth-card,html.theme-dark .reg-card{background:rgba(23,32,51,.94);color:var(--tx-1);border:1px solid var(--border)}
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
  .sidebar{transform:translateX(-276px)}
  .sidebar.open{transform:translateX(0);box-shadow:var(--sh-xl)}
  .sidebar.collapsed{transform:translateX(calc(-1 * var(--sb-collapsed,68px)))}
  .sidebar.collapsed.open{transform:translateX(0)}
  .app-main{margin-left:0 !important}
  .app-main.sb-collapsed{margin-left:0 !important}
}
@media(max-width:767.98px){
  .app-content{padding:16px}
  .topbar{padding:0 12px;gap:8px}
  .topbar-left{gap:8px;min-width:0}
  .topbar-title{font-size:.92rem;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
  .topbar-right{gap:6px;flex-shrink:0}
  .topbar-chip{padding:4px;border-radius:11px}
  .topbar-chip-ava{width:30px;height:30px}
  .stat-num{font-size:1.55rem}
  .stat-card{padding:16px 18px;gap:13px}
  .stat-icon-wrap{width:46px;height:46px;font-size:1.2rem;border-radius:12px}
  .book-grid{gap:12px}
}
@media(max-width:575.98px){
  .app-content{padding:12px 10px 24px}
  .form-card{padding:18px}
  .book-grid{grid-template-columns:repeat(2,1fr);gap:10px}
  .topbar-chip-name{display:none}
  .topbar{height:56px}
  .topbar-title{font-size:.86rem}
}

/* ═══════════════════════════════════════════════════
   🎨 GLOBAL BUTTON MAGIC ANIMATIONS
   ── Applies to all action buttons sitewide ──
═══════════════════════════════════════════════════ */

/* ── Base: semua tombol action punya ripple ── */
.btn,[class*="-act"],[class*="-btn"],[class*="btn-"]{
  position:relative;overflow:hidden;
}
/* Ripple effect on click */
.btn-ripple{
  position:absolute;border-radius:50%;
  background:rgba(255,255,255,.35);
  transform:scale(0);
  animation:rippleAnim .5s linear;
  pointer-events:none;
}
@keyframes rippleAnim{
  to{transform:scale(4);opacity:0}
}

/* ── DELETE / HAPUS buttons: icon flies into trash ── */
@keyframes trashLid{
  0%{transform:rotate(0) translateY(0)}
  30%{transform:rotate(-25deg) translateY(-3px)}
  60%{transform:rotate(15deg) translateY(-1px)}
  100%{transform:rotate(0) translateY(0)}
}
@keyframes trashShake{
  0%,100%{transform:translateX(0) scale(1)}
  15%{transform:translateX(-3px) scale(1.08)}
  30%{transform:translateX(3px) scale(1.05)}
  45%{transform:translateX(-2px) scale(1.03)}
  60%{transform:translateX(2px) scale(1.02)}
  75%{transform:translateX(-1px) scale(1.01)}
}
@keyframes flyIntoTrash{
  0%{transform:translateY(0) scale(1);opacity:1}
  40%{transform:translateY(-8px) scale(.7);opacity:.6}
  100%{transform:translateY(4px) scale(.3);opacity:0}
}

/* Trigger via JS class .btn-deleting */
.btn-del-anim.btn-deleting i,
.ag-act.del.btn-deleting i,
.tx-act.del.btn-deleting i,
.popup-btn-delete.btn-deleting i,
.m-btn-delete.btn-deleting i,
[class*="del"].btn-deleting i,
[class*="hapus"].btn-deleting i{
  animation:trashShake .45s ease both;
}

/* ── VIEW / LIHAT buttons: eye blinks ── */
@keyframes eyeBlink{
  0%,90%,100%{transform:scaleY(1)}
  93%{transform:scaleY(.08)}
  96%{transform:scaleY(1)}
}
@keyframes eyePulse{
  0%{transform:scale(1)}
  40%{transform:scale(1.3)}
  70%{transform:scale(0.9)}
  100%{transform:scale(1)}
}
.ag-act.view:hover i,
.tx-act.view:hover i,
.popup-btn-view:hover i,
.m-btn-view:hover i,
.bv:hover i,
[class*="view"]:hover i.bi-eye,
[class*="view"]:hover i.bi-eye-fill,
[class*="lihat"]:hover i{
  animation:eyeBlink .7s ease infinite;
  display:inline-block;
}

/* ── EDIT / PENCIL buttons: pencil writes ── */
@keyframes pencilWrite{
  0%{transform:rotate(0deg) translate(0,0)}
  20%{transform:rotate(-18deg) translate(-2px,1px)}
  40%{transform:rotate(-18deg) translate(2px,-1px)}
  60%{transform:rotate(-18deg) translate(-1px,1px)}
  80%{transform:rotate(-5deg) translate(0,0)}
  100%{transform:rotate(0deg) translate(0,0)}
}
.ag-act.edit:hover i,
.tx-act.edit:hover i,
.popup-btn-edit:hover i,
.m-btn-edit:hover i,
.be:hover i,
[class*="edit"]:hover i.bi-pencil,
[class*="edit"]:hover i.bi-pencil-fill{
  animation:pencilWrite .5s ease;
  display:inline-block;
  transform-origin:bottom center;
}

/* ── BACK / KEMBALI buttons: arrow slides left ── */
@keyframes arrowLeft{
  0%{transform:translateX(0)}
  35%{transform:translateX(-5px)}
  65%{transform:translateX(-2px)}
  100%{transform:translateX(0)}
}
[class*="back"]:hover i,
[class*="kembali"]:hover i,
.btn-ghost:hover i.bi-arrow-left,
.btn-ghost:hover i.bi-chevron-left,
[class*="back-btn"]:hover i{
  animation:arrowLeft .4s ease;
  display:inline-block;
}

/* ── SAVE / SUBMIT buttons: checkmark bounce ── */
@keyframes checkBounce{
  0%{transform:scale(1) rotate(0deg)}
  30%{transform:scale(1.4) rotate(-10deg)}
  55%{transform:scale(.85) rotate(5deg)}
  75%{transform:scale(1.1) rotate(-3deg)}
  100%{transform:scale(1) rotate(0deg)}
}
@keyframes submitPulse{
  0%{box-shadow:0 0 0 0 rgba(237,27,59,.4)}
  70%{box-shadow:0 0 0 10px rgba(237,27,59,0)}
  100%{box-shadow:0 0 0 0 rgba(237,27,59,0)}
}
[class*="submit"]:hover,
[class*="simpan"]:hover,
[class*="save"]:hover{
  animation:submitPulse .6s ease;
}
[class*="submit"]:hover i,
[class*="simpan"]:hover i,
[class*="save"]:hover i{
  animation:checkBounce .45s ease;
  display:inline-block;
}

/* ── RETURN / KEMBALIKAN buttons: arrow spins ── */
@keyframes arrowSpin{
  0%{transform:rotate(0deg) scale(1)}
  50%{transform:rotate(180deg) scale(1.2)}
  100%{transform:rotate(360deg) scale(1)}
}
.tx-act.back:hover i,
[class*="return"]:hover i,
[class*="kembali"]:hover i.bi-box-arrow-in-left,
[class*="kembalikan"]:hover i{
  animation:arrowSpin .5s ease;
  display:inline-block;
}

/* ── TAMBAH / ADD buttons: plus rotates ── */
@keyframes plusSpin{
  0%{transform:rotate(0deg) scale(1)}
  50%{transform:rotate(90deg) scale(1.25)}
  100%{transform:rotate(0deg) scale(1)}
}
[class*="tambah"]:hover i,
[class*="add"]:hover i.bi-plus,
[class*="add"]:hover i.bi-plus-lg,
[class*="add"]:hover i.bi-plus-circle,
[class*="-btn"]:hover i.bi-plus-lg,
[class*="-btn"]:hover i.bi-plus-circle-fill{
  animation:plusSpin .4s ease;
  display:inline-block;
}

/* ── PINJAM / BORROW buttons: book open ── */
@keyframes bookBounce{
  0%{transform:translateY(0) scale(1)}
  30%{transform:translateY(-5px) scale(1.15)}
  55%{transform:translateY(-2px) scale(1.05)}
  75%{transform:translateY(-4px) scale(1.1)}
  100%{transform:translateY(0) scale(1)}
}
[class*="pinjam"]:hover i,
[class*="borrow"]:hover i,
.btn-bk:hover i{
  animation:bookBounce .5s ease;
  display:inline-block;
}

/* ── LUNAS / PAY buttons: coin flip ── */
@keyframes coinFlip{
  0%{transform:rotateY(0deg) scale(1)}
  40%{transform:rotateY(90deg) scale(1.1)}
  100%{transform:rotateY(0deg) scale(1)}
}
[class*="lunas"]:hover i,
[class*="fine"]:hover i,
[class*="denda"]:hover i,
[class*="pay"]:hover i{
  animation:coinFlip .5s ease;
  display:inline-block;
}

/* ── SEARCH / FILTER buttons: magnifier bounces ── */
@keyframes searchBounce{
  0%{transform:scale(1) rotate(0)}
  30%{transform:scale(1.2) rotate(-15deg)}
  60%{transform:scale(.9) rotate(10deg)}
  100%{transform:scale(1) rotate(0)}
}
[class*="submit"]:hover i.bi-search,
[class*="filter"]:hover i.bi-search,
[class*="cari"]:hover i.bi-search,
button[type="submit"]:hover i.bi-search,
button[type="submit"]:hover i.bi-funnel,
button[type="submit"]:hover i.bi-funnel-fill{
  animation:searchBounce .45s ease;
  display:inline-block;
}

/* ── UPLOAD buttons: arrow floats up ── */
@keyframes uploadFloat{
  0%{transform:translateY(0) scale(1)}
  40%{transform:translateY(-6px) scale(1.1)}
  70%{transform:translateY(-3px) scale(1.05)}
  100%{transform:translateY(0) scale(1)}
}
[class*="upload"]:hover i,
button[type="submit"]:hover i.bi-upload,
button[type="submit"]:hover i.bi-cloud-upload,
button[type="submit"]:hover i.bi-cloud-arrow-up{
  animation:uploadFloat .5s ease;
  display:inline-block;
}

/* ── REFRESH / RESET buttons: circle spin ── */
@keyframes resetSpin{
  0%{transform:rotate(0deg)}
  100%{transform:rotate(-360deg)}
}
[class*="reset"]:hover i,
[class*="ghost"]:hover i.bi-arrow-counterclockwise,
[class*="ghost"]:hover i.bi-x-circle,
a[class*="ghost"]:hover i{
  animation:resetSpin .45s ease;
  display:inline-block;
}

/* ── LOGIN / DAFTAR buttons: shine sweep ── */
@keyframes shineSweep{
  0%{left:-120%;opacity:.55}
  50%{opacity:.7}
  100%{left:120%;opacity:0}
}
.btn-navy::after,
.btn-primary::after,
.btn-hp-primary::after,
.btn-lnav-gold::after,
.btn-lnav-solid::after{
  content:'';
  position:absolute;top:0;left:-120%;
  width:60%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.25),transparent);
  transform:skewX(-20deg);
  pointer-events:none;
}
.btn-navy:hover::after,
.btn-primary:hover::after,
.btn-hp-primary:hover::after,
.btn-lnav-gold:hover::after,
.btn-lnav-solid:hover::after{
  animation:shineSweep .55s ease forwards;
}

/* ── ADD MEMBER / TAMBAH ANGGOTA hero buttons: glow pulse ── */
@keyframes heroBtnGlow{
  0%,100%{box-shadow:0 4px 14px rgba(237,27,59,.3)}
  50%{box-shadow:0 8px 28px rgba(237,27,59,.55),0 0 0 6px rgba(237,27,59,.08)}
}
.ag-btn,.tx-btn,.la-btn-primary,.btn-submit-modern,
[class*="hero-btn"],[class*="cta-btn"]{
  animation:heroBtnGlow 2.8s ease-in-out infinite;
}
.ag-btn:hover,.tx-btn:hover,.la-btn-primary:hover,.btn-submit-modern:hover{
  animation:none;
  transform:translateY(-3px) scale(1.03);
}

/* ── Tambah Anggota / Tambah Transaksi icon spin on hover ── */
.ag-btn i,.tx-btn i{
  transition:transform .35s cubic-bezier(.34,1.56,.64,1);
  display:inline-block;
}
.ag-btn:hover i,.tx-btn:hover i{
  transform:rotate(135deg) scale(1.2);
}

/* ── Scale pop on all action btn click ── */
.btn-click-pop{
  animation:clickPop .2s ease;
}
@keyframes clickPop{
  0%{transform:scale(1)}
  50%{transform:scale(.88)}
  100%{transform:scale(1)}
}

/* ── Delete confirm visual feedback ── */
.btn-del-shake{
  animation:deleteShake .3s ease;
}
@keyframes deleteShake{
  0%,100%{transform:translateX(0)}
  20%{transform:translateX(-5px) rotate(-1deg)}
  40%{transform:translateX(5px) rotate(1deg)}
  60%{transform:translateX(-4px)}
  80%{transform:translateX(4px)}
}

/* ── Floating tooltip on hover ── */
.magic-tooltip{
  position:absolute;
  bottom:calc(100% + 6px);
  left:50%;transform:translateX(-50%);
  background:rgba(15,23,42,.88);
  color:#fff;font-size:.68rem;font-weight:700;
  padding:4px 9px;border-radius:6px;
  white-space:nowrap;pointer-events:none;
  opacity:0;
  transition:opacity .18s,transform .18s;
  transform:translateX(-50%) translateY(4px);
  z-index:9999;
  letter-spacing:.02em;
}
.magic-tooltip::after{
  content:'';position:absolute;top:100%;left:50%;
  transform:translateX(-50%);
  border:4px solid transparent;
  border-top-color:rgba(15,23,42,.88);
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
      <div class="sb-logo"><img src="/image/logo.png" alt="Logo" style="width:100%;height:100%;object-fit:contain;"></div>
      <div class="sb-brand-txt">
        <strong>ESKALIBRARY</strong>
        <span>Read More, Explore More.</span>
      </div>
    </div>

    <div class="sb-user">
      @php
        $currentUser = auth()->user();
        $fotoUrl = null;
        
        if ($currentUser->isAdmin()) {
          // Admin: ambil foto dari tabel users
          $fotoUrl = $currentUser->foto ? Storage::url($currentUser->foto) : null;
        } else {
          // Siswa: ambil foto dari tabel anggota
          $userAnggota = $currentUser->anggota;
          $fotoUrl = ($userAnggota && $userAnggota->foto) ? Storage::url($userAnggota->foto) : null;
        }
      @endphp
      @if($fotoUrl)
        <img src="{{ $fotoUrl }}" alt="{{ $currentUser->name }}" class="sb-avatar" style="object-fit: cover;">
      @else
        <div class="sb-avatar">{{ strtoupper(substr($currentUser->name,0,1)) }}</div>
      @endif
      <div style="min-width:0;flex:1">
        <div class="sb-uname">{{ Str::limit($currentUser->name,20) }}</div>
        <span class="sb-badge {{ $currentUser->isAdmin()?'sb-badge-admin':'sb-badge-siswa' }}">
          {{ $currentUser->isAdmin() ? '⚡ Administrator' : '📚 Siswa' }}
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
        <a href="{{ route('admin.series.index') }}" data-label="Koleksi Series" class="sb-item {{ request()->routeIs('admin.series.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-collection-fill"></i></span><span class="sb-item-label">Koleksi Series</span>
        </a>
        <a href="{{ route('admin.landing-ads.index') }}" data-label="Visual Ads" class="sb-item {{ request()->routeIs('admin.landing-ads.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-images"></i></span><span class="sb-item-label">Visual Ads</span>
        </a>
        <div class="sb-section">Transaksi</div>
        <a href="{{ route('admin.transaksi.index') }}" data-label="Riwayat Transaksi" class="sb-item {{ request()->routeIs('admin.transaksi.index') ? 'active' : '' }}">
          <span class="sb-icon"><i class="bi bi-clock-history"></i></span><span class="sb-item-label">Riwayat Transaksi</span>
        </a>
        <a href="{{ route('admin.transaksi.index', ['status' => 'pending_kembali']) }}" data-label="Pengembalian" class="sb-item {{ request()->routeIs('admin.transaksi.index') && request('status') === 'pending_kembali' ? 'active' : '' }}">
          <span class="sb-icon"><i class="bi bi-box-arrow-in-left"></i></span>
          <span class="sb-item-label">Pengembalian</span>
          @if($adminPendingReturnCount > 0)
            <span style="margin-left:auto;padding:2px 8px;border-radius:99px;background:#ef4444;color:#fff;font-size:.68rem;font-weight:900;line-height:1.6">{{ $adminPendingReturnCount }}</span>
          @endif
        </a>
        <a href="{{ route('admin.transaksi.index', ['denda' => 'belum_lunas']) }}" data-label="Pembayaran Denda" class="sb-item {{ request()->routeIs('admin.transaksi.index') && request('denda') === 'belum_lunas' ? 'active' : '' }}">
          <span class="sb-icon"><i class="bi bi-cash-coin"></i></span>
          <span class="sb-item-label">Pembayaran Denda</span>
          @if($adminUnpaidFineCount > 0)
            <span style="margin-left:auto;padding:2px 8px;border-radius:99px;background:#f59e0b;color:#fff;font-size:.68rem;font-weight:900;line-height:1.6">{{ $adminUnpaidFineCount }}</span>
          @endif
        </a>
        <div class="sb-section">Konten</div>
        <a href="{{ route('admin.ulasan.index') }}" data-label="Ulasan Buku" class="sb-item {{ request()->routeIs('admin.ulasan.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-star-fill"></i></span><span class="sb-item-label">Ulasan Buku</span>
        </a>
        <div class="sb-section">Sistem</div>
        <a href="{{ route('admin.anggota.pending') }}" data-label="Persetujuan Siswa" class="sb-item {{ request()->routeIs('admin.anggota.pending') ? 'active' : '' }}">
          <span class="sb-icon"><i class="bi bi-person-check-fill"></i></span>
          <span class="sb-item-label">Persetujuan Siswa</span>
          @if($adminPendingSiswaCount > 0)
            <span style="margin-left:auto;padding:2px 8px;border-radius:99px;background:#8b5cf6;color:#fff;font-size:.68rem;font-weight:900;line-height:1.6">{{ $adminPendingSiswaCount }}</span>
          @endif
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
        <div class="sb-section">Akun</div>
        <a href="{{ route('siswa.profil.index') }}" data-label="Profil Saya" class="sb-item {{ request()->routeIs('siswa.profil.*')?'active':'' }}">
          <span class="sb-icon"><i class="bi bi-person-circle"></i></span><span class="sb-item-label">Profil Saya</span>
        </a>
      @endif
    </div>

    <div class="sb-footer">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" data-label="Keluar">
          <i class="bi bi-box-arrow-right"></i>
          <span>Keluar</span>
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
          @php
            $currentUser = auth()->user();
            $fotoUrl = null;
            
            if ($currentUser->isAdmin()) {
              // Admin: ambil foto dari tabel users
              $fotoUrl = $currentUser->foto ? Storage::url($currentUser->foto) : null;
            } else {
              // Siswa: ambil foto dari tabel anggota
              $userAnggota = $currentUser->anggota;
              $fotoUrl = ($userAnggota && $userAnggota->foto) ? Storage::url($userAnggota->foto) : null;
            }
          @endphp
          @if($fotoUrl)
            <img src="{{ $fotoUrl }}" alt="{{ $currentUser->name }}" class="topbar-chip-ava" style="object-fit: cover;">
          @else
            <div class="topbar-chip-ava">{{ strtoupper(substr($currentUser->name,0,1)) }}</div>
          @endif
          <span class="topbar-chip-name">{{ Str::limit($currentUser->name,16) }}</span>
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
const sidebar = document.getElementById('sidebar');
const main    = document.querySelector('.app-main');
const overlay = document.getElementById('sbOverlay');
const toggleBtn = document.getElementById('sbToggle');

/* ── Init from localStorage ── */
const SB_KEY = 'sb_collapsed';
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
<script>
/* ═══════════════════════════════════════════════════
   🎨 GLOBAL BUTTON MAGIC — Interactive Animations
═══════════════════════════════════════════════════ */
(function(){
  /* ── 1. Ripple on click for ALL clickable buttons ── */
  document.addEventListener('click', function(e){
    const btn = e.target.closest(
      'button,a.btn,[class*="-btn"],[class*="btn-"],[class*="-act"],[class*="-submit"]'
    );
    if(!btn || btn.closest('.sb-item, nav, .topbar')) return;

    const r  = document.createElement('span');
    r.className = 'btn-ripple';
    const rect  = btn.getBoundingClientRect();
    const size  = Math.max(rect.width, rect.height) * 1.8;
    r.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
    // ensure parent can clip
    if(getComputedStyle(btn).position === 'static') btn.style.position = 'relative';
    btn.style.overflow = 'hidden';
    btn.appendChild(r);
    r.addEventListener('animationend', ()=> r.remove());

    /* click-pop feedback */
    btn.classList.add('btn-click-pop');
    btn.addEventListener('animationend', ()=> btn.classList.remove('btn-click-pop'), {once:true});
  });

  /* ── 2. Delete button: trash shake + confirm shake ── */
  document.addEventListener('DOMContentLoaded', function(){

    /* Magic tooltips for icon-only buttons */
    const tooltipMap = {
      'bi-eye': 'Lihat Detail',
      'bi-eye-fill': 'Lihat Detail',
      'bi-pencil': 'Edit',
      'bi-pencil-fill': 'Edit',
      'bi-trash': 'Hapus',
      'bi-trash-fill': 'Hapus',
      'bi-box-arrow-in-left': 'Kembalikan',
      'bi-check-circle-fill': 'Tandai Lunas',
      'bi-arrow-left': 'Kembali',
      'bi-chevron-left': 'Kembali',
      'bi-plus-lg': 'Tambah Baru',
      'bi-person-plus-fill': 'Tambah Anggota',
      'bi-funnel-fill': 'Filter',
    };

    document.querySelectorAll(
      '.ag-act,.tx-act,.btn-ico,.bv,.be,.bd,.br,button.tx-fine-btn'
    ).forEach(function(btn){
      if(btn.closest('nav, .sb-item, .topbar')) return;

      const ic = btn.querySelector('i[class*="bi-"]');
      if(!ic) return;
      const cls = Array.from(ic.classList).find(c => tooltipMap[c]);
      if(!cls) return;

      // inject tooltip
      const tip = document.createElement('span');
      tip.className = 'magic-tooltip';
      tip.textContent = tooltipMap[cls];
      if(getComputedStyle(btn).position === 'static') btn.style.position = 'relative';
      btn.appendChild(tip);

      btn.addEventListener('mouseenter', function(){
        tip.style.opacity = '1';
        tip.style.transform = 'translateX(-50%) translateY(0)';
      });
      btn.addEventListener('mouseleave', function(){
        tip.style.opacity = '0';
        tip.style.transform = 'translateX(-50%) translateY(4px)';
      });
    });

    /* Delete buttons: animate trash lid on hover + shake on click */
    document.querySelectorAll(
      '.ag-act.del,.tx-act.del,.popup-btn-delete,.m-btn-delete,.bd,[class*="del"][class*="btn"],[class*="btn"][class*="del"]'
    ).forEach(function(btn){
      if(btn.closest('nav, .sb-item, .topbar')) return;

      btn.addEventListener('click', function(e){
        this.classList.add('btn-del-shake');
        this.addEventListener('animationend', ()=> this.classList.remove('btn-del-shake'), {once:true});
      });
    });

    /* Submit / Save buttons: pulse on click */
    document.querySelectorAll(
      '[class*="submit"],[class*="simpan"],[class*="save"],[class*="send"],.btn-submit-modern'
    ).forEach(function(btn){
      if(btn.closest('nav, .sb-item, .topbar')) return;
      btn.addEventListener('click', function(){
        this.style.animation = 'none';
        void this.offsetWidth;
        this.style.animation = 'submitPulse .6s ease';
        setTimeout(()=> this.style.animation = '', 650);
      });
    });

  });
})();
</script>
@stack('scripts')
</body>
</html>

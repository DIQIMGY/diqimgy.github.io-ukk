@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard Admin')
@section('content')

@php
  $hour = (int) date('H');
  $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
  $emoji = $hour < 11 ? '👋' : ($hour < 15 ? '☀️' : ($hour < 18 ? '🌇' : '🌙'));
@endphp

<style>
/* ══════════════════════════════════════════════════════════
   MODERN LIBRARY DASHBOARD — ADMIN VIEW
   Redesigned: Proportional, Clean, and Professional
══════════════════════════════════════════════════════════ */

/* Welcome Banner - Library Theme */
.welcome-banner-lib {
  background: linear-gradient(135deg, #0B1730 0%, #14284B 85%, #1A3461 100%);
  border-radius: 16px;
  padding: 28px 32px;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 4px 20px rgba(11,23,48,.25);
  position: relative;
  overflow: hidden;
  border: 1px solid rgba(255,255,255,.08);
}

.welcome-banner-lib::before {
  content: '';
  position: absolute;
  top: -100px;
  right: -100px;
  width: 350px;
  height: 350px;
  background: radial-gradient(circle, rgba(237,27,59,.15) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulseGlow 8s ease-in-out infinite;
}

.welcome-banner-lib::after {
  content: '';
  position: absolute;
  bottom: -80px;
  left: -80px;
  width: 280px;
  height: 280px;
  background: radial-gradient(circle, rgba(96,165,250,.12) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulseGlow 12s ease-in-out infinite reverse;
}

@keyframes pulseGlow {
  0%, 100% { transform: scale(1); opacity: 1; }
  50% { transform: scale(1.08); opacity: 0.7; }
}

/* Stat Cards Grid - Balanced Size */
.stat-grid-lib {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 18px;
  margin-bottom: 28px;
}

@media (min-width: 1200px) {
  .stat-grid-lib {
    grid-template-columns: repeat(4, 1fr);
  }
}

.stat-card-lib {
  background: #fff;
  border-radius: 14px;
  padding: 20px 22px;
  border: 1px solid #f0f0f0;
  transition: all .3s cubic-bezier(.4,0,.2,1);
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.stat-card-lib::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 140px;
  height: 140px;
  border-radius: 50%;
  opacity: .04;
  transition: all .4s;
}

.stat-card-lib:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,.1);
  border-color: var(--crimson);
}

.stat-card-lib:hover::before {
  transform: scale(1.3) translate(-10px, 10px);
  opacity: .06;
}

.stat-icon-lib {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.15rem;
  transition: all .3s;
  flex-shrink: 0;
}

.stat-card-lib:hover .stat-icon-lib {
  transform: scale(1.08) rotate(-4deg);
}

.stat-content-lib {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.stat-label-lib {
  font-size: .75rem;
  color: var(--tx-3);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .05em;
}

.stat-value-lib {
  font-size: 1.75rem;
  font-weight: 900;
  color: var(--navy-800);
  line-height: 1;
  letter-spacing: -.02em;
}

.stat-footer-lib {
  font-size: .74rem;
  color: var(--tx-4);
  display: flex;
  align-items: center;
  gap: 4px;
}

/* Color Variants */
.sc-red::before { background: var(--crimson); }
.sc-green::before { background: #10b981; }
.sc-blue::before { background: #0ea5e9; }
.sc-orange::before { background: #f59e0b; }
.sc-purple::before { background: #a855f7; }

/* Table - Transaction List */
.table-lib-modern {
  width: 100%;
}

.table-lib-modern thead th {
  padding: 14px 18px;
  font-size: .72rem;
  font-weight: 800;
  color: var(--tx-3);
  text-transform: uppercase;
  letter-spacing: .06em;
  text-align: left;
  border: none;
  background: #fafbfc;
  white-space: nowrap;
}

.table-lib-modern tbody td {
  padding: 16px 18px;
  font-size: .84rem;
  color: var(--tx-1);
  border-bottom: 1px solid #f5f5f5;
  vertical-align: middle;
}

.table-lib-modern tbody tr:last-child td {
  border-bottom: none;
}

.table-lib-modern tbody tr {
  transition: background .15s;
}

.table-lib-modern tbody tr:hover {
  background: #fafbfc;
}

/* Member Avatar in Table */
.member-ava-sm {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--crimson), var(--crimson-dark));
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: .72rem;
  font-weight: 800;
  color: #fff;
  margin-right: 10px;
  box-shadow: 0 3px 10px rgba(237,27,59,.3);
  vertical-align: middle;
  border: 2px solid #fff;
}

/* Quick Action Cards */
.qa-grid-lib {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 14px;
}

.qa-card-lib {
  background: #fff;
  border-radius: 12px;
  padding: 18px 16px;
  border: 1px solid #f0f0f0;
  text-decoration: none;
  transition: all .3s;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  text-align: center;
}

.qa-card-lib:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(237,27,59,.15);
  border-color: var(--crimson);
}

.qa-icon-lib {
  width: 42px;
  height: 42px;
  border-radius: 11px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.05rem;
  transition: all .3s;
}

.qa-card-lib:hover .qa-icon-lib {
  transform: scale(1.1);
}

.qa-label-lib {
  font-size: .78rem;
  font-weight: 700;
  color: var(--navy-800);
}

.qa-desc-lib {
  font-size: .7rem;
  color: var(--tx-4);
}

/* Activity Timeline */
.timeline-lib {
  position: relative;
}

.timeline-item-lib {
  display: flex;
  gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid #f5f5f5;
  position: relative;
}

.timeline-item-lib:last-child {
  border-bottom: none;
}

.timeline-dot-lib {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  flex-shrink: 0;
  margin-top: 4px;
  position: relative;
  z-index: 1;
}

.timeline-dot-lib::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 18px;
  height: 18px;
  border-radius: 50%;
  opacity: .2;
}

.tl-success .timeline-dot-lib { background: #10b981; }
.tl-success .timeline-dot-lib::before { background: #10b981; }

.tl-warning .timeline-dot-lib { background: #f59e0b; }
.tl-warning .timeline-dot-lib::before { background: #f59e0b; }

.tl-danger .timeline-dot-lib { background: #ef4444; }
.tl-danger .timeline-dot-lib::before { background: #ef4444; }

.tl-info .timeline-dot-lib { background: #0ea5e9; }
.tl-info .timeline-dot-lib::before { background: #0ea5e9; }

.timeline-content-lib {
  flex: 1;
  min-width: 0;
}

.timeline-title-lib {
  font-size: .82rem;
  font-weight: 700;
  color: var(--navy-800);
  margin-bottom: 2px;
}

.timeline-desc-lib {
  font-size: .76rem;
  color: var(--tx-3);
  margin-bottom: 4px;
}

.timeline-time-lib {
  font-size: .7rem;
  color: var(--tx-4);
}

/* Responsive */
@media (max-width: 768px) {
  .stat-grid-lib {
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
  }
  
  .stat-value-lib {
    font-size: 1.5rem;
  }
  
  .welcome-banner-lib {
    padding: 22px 20px;
  }
  
  .qa-grid-lib {
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
  }
}

@media (max-width: 576px) {
  .stat-card-lib {
    padding: 16px 18px;
  }
  
  .stat-icon-lib {
    width: 42px;
    height: 42px;
    font-size: 1rem;
  }
  
  .stat-value-lib {
    font-size: 1.4rem;
  }
}
</style>

{{-- ══════════════════════════════════════════════════════════
     WELCOME BANNER — Modern Library Theme
══════════════════════════════════════════════════════════ --}}
<div class="welcome-banner-lib">
  <div style="flex:1;position:relative;z-index:1">
    <p style="font-size:.8rem;color:rgba(255,255,255,.65);margin:0 0 6px;font-weight:600;display:flex;align-items:center;gap:6px">
      <span>{{ $greeting }}</span>
      <span style="font-size:1.1rem">{{ $emoji }}</span>
    </p>
    <h1 style="font-size:1.5rem;font-weight:900;color:#fff;margin:0 0 8px;letter-spacing:-.02em">
      {{ auth()->user()->name }}
    </h1>
    <p style="font-size:.86rem;color:rgba(255,255,255,.75);margin:0;line-height:1.5">
      Kelola perpustakaan dengan mudah dan efisien
    </p>
  </div>
  <div style="position:relative;z-index:1;display:flex;align-items:center">
    <div style="width:56px;height:56px;background:rgba(255,255,255,.12);backdrop-filter:blur(10px);border-radius:14px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,.15);box-shadow:0 4px 16px rgba(0,0,0,.15)">
      <i class="bi bi-book-half" style="font-size:1.6rem;color:#fff"></i>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     STAT CARDS — Library Metrics
══════════════════════════════════════════════════════════ --}}
<div class="stat-grid-lib">
  {{-- Total Anggota --}}
  <div class="stat-card-lib sc-red">
    <div style="display:flex;align-items:center;gap:14px">
      <div class="stat-icon-lib" style="background:rgba(237,27,59,.1);color:var(--crimson)">
        <i class="bi bi-people-fill"></i>
      </div>
      <div class="stat-content-lib">
        <div class="stat-label-lib">Total Anggota</div>
        <div class="stat-value-lib">{{ $totalAnggota }}</div>
      </div>
    </div>
    <div class="stat-footer-lib">
      <i class="bi bi-check-circle-fill" style="color:#10b981"></i>
      <span>Anggota terdaftar</span>
    </div>
  </div>

  {{-- Koleksi Buku --}}
  <div class="stat-card-lib sc-green">
    <div style="display:flex;align-items:center;gap:14px">
      <div class="stat-icon-lib" style="background:rgba(16,185,129,.1);color:#10b981">
        <i class="bi bi-book-fill"></i>
      </div>
      <div class="stat-content-lib">
        <div class="stat-label-lib">Koleksi Buku</div>
        <div class="stat-value-lib">{{ $totalBuku }}</div>
      </div>
    </div>
    <div class="stat-footer-lib">
      <i class="bi bi-collection-fill" style="color:#10b981"></i>
      <span>Buku tersedia</span>
    </div>
  </div>

  {{-- Sedang Dipinjam --}}
  <div class="stat-card-lib sc-blue">
    <div style="display:flex;align-items:center;gap:14px">
      <div class="stat-icon-lib" style="background:rgba(14,165,233,.1);color:#0ea5e9">
        <i class="bi bi-arrow-repeat"></i>
      </div>
      <div class="stat-content-lib">
        <div class="stat-label-lib">Sedang Dipinjam</div>
        <div class="stat-value-lib">{{ $totalPinjam }}</div>
      </div>
    </div>
    <div class="stat-footer-lib">
      <i class="bi bi-clock-history" style="color:#0ea5e9"></i>
      <span>Peminjaman aktif</span>
    </div>
  </div>

  {{-- Dikembalikan --}}
  <div class="stat-card-lib sc-purple">
    <div style="display:flex;align-items:center;gap:14px">
      <div class="stat-icon-lib" style="background:rgba(168,85,247,.1);color:#a855f7">
        <i class="bi bi-check2-circle"></i>
      </div>
      <div class="stat-content-lib">
        <div class="stat-label-lib">Dikembalikan</div>
        <div class="stat-value-lib">{{ $totalKembali }}</div>
      </div>
    </div>
    <div class="stat-footer-lib">
      <i class="bi bi-arrow-return-left" style="color:#a855f7"></i>
      <span>Transaksi selesai</span>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MAIN CONTENT GRID
══════════════════════════════════════════════════════════ --}}
<div class="row g-3">
  {{-- LEFT COLUMN - Transaction List --}}
  <div class="col-lg-8">
    {{-- Recent Transaction Table --}}
    <div class="cbox" style="margin-bottom:20px">
      <div class="cbox-header">
        <h3 style="font-size:1.05rem;font-weight:800;color:var(--navy-800);margin:0;display:flex;align-items:center;gap:8px">
          <i class="bi bi-clock-history" style="color:var(--crimson)"></i>
          Transaksi Peminjaman Terbaru
        </h3>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-ghost btn-sm">
          Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
      </div>
      <div class="cbox-body" style="padding:0">
        <div class="table-responsive">
          <table class="table-lib-modern">
            <thead>
              <tr>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($peminjamanTerbaru->take(7) as $p)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px">
                    @if($p->anggota && $p->anggota->foto)
                      <img src="{{ Storage::url($p->anggota->foto) }}" alt="{{ $p->anggota->nama }}" class="member-ava-sm" style="object-fit: cover;">
                    @else
                      <div class="member-ava-sm">{{ strtoupper(substr($p->anggota->nama ?? 'U', 0, 1)) }}</div>
                    @endif
                    <span style="font-weight:600;color:var(--navy-800)">{{ Str::limit($p->anggota->nama ?? '-', 22) }}</span>
                  </div>
                </td>
                <td>
                  <div style="display:flex;align-items:center;gap:12px">
                    @if($p->buku && $p->buku->cover)
                      <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" 
                           style="width:40px;height:60px;object-fit:cover;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.15);flex-shrink:0;">
                    @else
                      <div style="width:40px;height:60px;border-radius:6px;background:linear-gradient(135deg,#0f1f3d,#1e4080);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 8px rgba(0,0,0,.15)">
                        <i class="bi bi-book-fill" style="color:rgba(255,255,255,.7);font-size:1.2rem"></i>
                      </div>
                    @endif
                    <span style="color:var(--tx-2);font-weight:600">{{ Str::limit($p->buku->judul ?? '-', 35) }}</span>
                  </div>
                </td>
                <td style="font-size:.82rem;color:var(--tx-3)">
                  <i class="bi bi-calendar3" style="font-size:.75rem;margin-right:4px"></i>
                  {{ $p->tanggal_pinjam->format('d M Y') }}
                </td>
                <td style="font-size:.82rem;color:var(--tx-3)">
                  @if($p->tanggal_kembali)
                    <i class="bi bi-calendar-check" style="font-size:.75rem;margin-right:4px"></i>
                    {{ $p->tanggal_kembali->format('d M Y') }}
                  @else
                    <span style="color:var(--tx-4)">—</span>
                  @endif
                </td>
                <td>
                  @if($p->status === 'dikembalikan')
                    <span class="status-badge sb-kembali">
                      <i class="bi bi-check-circle-fill"></i> Dikembalikan
                    </span>
                  @elseif($p->status === 'dipinjam')
                    <span class="status-badge sb-pinjam">
                      <i class="bi bi-arrow-repeat"></i> Dipinjam
                    </span>
                  @else
                    <span class="status-badge sb-terlambat">
                      <i class="bi bi-exclamation-circle-fill"></i> Terlambat
                    </span>
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
      </div>
    </div>

    {{-- Quick Actions --}}
    <div class="cbox">
      <div class="cbox-header">
        <h4 style="font-size:1rem;font-weight:800;color:var(--navy-800);margin:0;display:flex;align-items:center;gap:8px">
          <i class="bi bi-lightning-charge-fill" style="color:#f59e0b"></i>
          Aksi Cepat
        </h4>
      </div>
      <div class="cbox-body">
        <div class="qa-grid-lib">
          <a href="{{ route('admin.transaksi.create') }}" class="qa-card-lib">
            <div class="qa-icon-lib" style="background:rgba(237,27,59,.1);color:var(--crimson)">
              <i class="bi bi-plus-circle-fill"></i>
            </div>
            <div class="qa-label-lib">Tambah Peminjaman</div>
            <div class="qa-desc-lib">Buat transaksi baru</div>
          </a>
          
          <a href="{{ route('admin.buku.index') }}" class="qa-card-lib">
            <div class="qa-icon-lib" style="background:rgba(16,185,129,.1);color:#10b981">
              <i class="bi bi-book-fill"></i>
            </div>
            <div class="qa-label-lib">Kelola Buku</div>
            <div class="qa-desc-lib">Lihat koleksi</div>
          </a>
          
          <a href="{{ route('admin.anggota.index') }}" class="qa-card-lib">
            <div class="qa-icon-lib" style="background:rgba(14,165,233,.1);color:#0ea5e9">
              <i class="bi bi-people-fill"></i>
            </div>
            <div class="qa-label-lib">Data Anggota</div>
            <div class="qa-desc-lib">Kelola member</div>
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- RIGHT COLUMN - Activity & Stats --}}
  <div class="col-lg-4">
    {{-- Library Stats Overview --}}
    <div class="cbox" style="margin-bottom:20px">
      <div class="cbox-header">
        <h4 style="font-size:1rem;font-weight:800;color:var(--navy-800);margin:0;display:flex;align-items:center;gap:8px">
          <i class="bi bi-graph-up" style="color:#10b981"></i>
          Statistik Perpustakaan
        </h4>
      </div>
      <div class="cbox-body">
        @php
          $total = $totalPinjam + $totalKembali + ($totalTerlambat ?? 0);
          $returnRate = $total > 0 ? round(($totalKembali / $total) * 100) : 0;
        @endphp
        
        <div style="text-align:center;margin-bottom:24px">
          <div style="position:relative;width:140px;height:140px;margin:0 auto">
            <svg width="140" height="140" style="transform:rotate(-90deg)">
              <circle cx="70" cy="70" r="55" fill="none" stroke="#f0f0f0" stroke-width="14"/>
              <circle cx="70" cy="70" r="55" fill="none" stroke="var(--crimson)" stroke-width="14"
                      stroke-dasharray="{{ (2 * 3.14159 * 55 * $returnRate) / 100 }} {{ 2 * 3.14159 * 55 }}"
                      stroke-linecap="round"/>
            </svg>
            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center">
              <div style="font-size:2rem;font-weight:900;color:var(--navy-800);line-height:1">{{ $returnRate }}%</div>
              <div style="font-size:.7rem;color:var(--tx-3);margin-top:4px;font-weight:600">Tingkat<br>Pengembalian</div>
            </div>
          </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:10px">
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:rgba(16,185,129,.08);border-radius:10px">
            <div style="display:flex;align-items:center;gap:8px">
              <div style="width:8px;height:8px;border-radius:50%;background:#10b981"></div>
              <span style="font-size:.8rem;color:var(--tx-2);font-weight:600">Dikembalikan</span>
            </div>
            <span style="font-size:.85rem;font-weight:800;color:var(--navy-800)">{{ $totalKembali }}</span>
          </div>
          
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:rgba(14,165,233,.08);border-radius:10px">
            <div style="display:flex;align-items:center;gap:8px">
              <div style="width:8px;height:8px;border-radius:50%;background:#0ea5e9"></div>
              <span style="font-size:.8rem;color:var(--tx-2);font-weight:600">Sedang Dipinjam</span>
            </div>
            <span style="font-size:.85rem;font-weight:800;color:var(--navy-800)">{{ $totalPinjam }}</span>
          </div>
          
          @if($totalTerlambat > 0)
          <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:rgba(239,68,68,.08);border-radius:10px">
            <div style="display:flex;align-items:center;gap:8px">
              <div style="width:8px;height:8px;border-radius:50%;background:#ef4444"></div>
              <span style="font-size:.8rem;color:var(--tx-2);font-weight:600">Terlambat</span>
            </div>
            <span style="font-size:.85rem;font-weight:800;color:var(--navy-800)">{{ $totalTerlambat }}</span>
          </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Recent Activity --}}
    <div class="cbox">
      <div class="cbox-header">
        <h4 style="font-size:1rem;font-weight:800;color:var(--navy-800);margin:0;display:flex;align-items:center;gap:8px">
          <i class="bi bi-activity" style="color:#a855f7"></i>
          Aktivitas Terkini
        </h4>
      </div>
      <div class="cbox-body">
        <div class="timeline-lib">
          @forelse($peminjamanTerbaru->take(5) as $p)
            <div class="timeline-item-lib {{ $p->status === 'dikembalikan' ? 'tl-success' : ($p->status === 'dipinjam' ? 'tl-info' : 'tl-danger') }}">
              <div class="timeline-dot-lib"></div>
              <div class="timeline-content-lib">
                <div class="timeline-title-lib">
                  @if($p->status === 'dikembalikan')
                    Buku dikembalikan
                  @elseif($p->status === 'dipinjam')
                    Peminjaman baru
                  @else
                    Keterlambatan
                  @endif
                </div>
                <div class="timeline-desc-lib">
                  <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
                    @if($p->buku && $p->buku->cover)
                      <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" 
                           style="width:32px;height:48px;object-fit:cover;border-radius:4px;box-shadow:0 2px 6px rgba(0,0,0,.12);flex-shrink:0;">
                    @else
                      <div style="width:32px;height:48px;border-radius:4px;background:linear-gradient(135deg,#581c87,#7c3aed);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-book-fill" style="color:rgba(255,255,255,.7);font-size:1rem"></i>
                      </div>
                    @endif
                    <div style="flex:1;min-width:0">
                      <strong>{{ Str::limit($p->anggota->nama ?? '-', 20) }}</strong> 
                      {{ $p->status === 'dikembalikan' ? 'mengembalikan' : 'meminjam' }} 
                      <strong>"{{ Str::limit($p->buku->judul ?? '-', 25) }}"</strong>
                    </div>
                  </div>
                </div>
                <div class="timeline-time-lib">
                  <i class="bi bi-clock"></i> {{ $p->tanggal_pinjam->diffForHumans() }}
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
    </div>
  </div>
</div>

@endsection

@extends('layouts.app')
@section('title','Dashboard Siswa')
@section('page-title','Dashboard Siswa')
@section('content')

@if($anggota)
@php
  $hour = (int) date('H');
  $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
  $emoji = $hour < 11 ? '👋' : ($hour < 15 ? '☀️' : ($hour < 18 ? '🌇' : '🌙'));
@endphp

<style>
/* ══════════════════════════════════════════════════════════
   MODERN STUDENT DASHBOARD — REDESIGNED
   Consistent with Admin Dashboard Design
══════════════════════════════════════════════════════════ */

/* Welcome Banner Siswa - Gradient Style */
.welcome-banner-siswa {
  background: linear-gradient(135deg, #0B1730 0%, #1A3461 85%, #2055A5 100%);
  border-radius: 16px;
  padding: 26px 30px;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 4px 20px rgba(11,23,48,.25);
  position: relative;
  overflow: hidden;
  border: 1px solid rgba(255,255,255,.08);
}

.welcome-banner-siswa::before {
  content: '';
  position: absolute;
  top: -80px;
  right: -80px;
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, rgba(14,165,233,.18) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulseGlow 8s ease-in-out infinite;
}

.welcome-banner-siswa::after {
  content: '';
  position: absolute;
  bottom: -60px;
  left: -60px;
  width: 220px;
  height: 220px;
  background: radial-gradient(circle, rgba(16,185,129,.15) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulseGlow 12s ease-in-out infinite reverse;
}

/* Stat Cards Siswa */
.stat-grid-siswa {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 18px;
  margin-bottom: 24px;
}

@media (min-width: 768px) {
  .stat-grid-siswa {
    grid-template-columns: repeat(3, 1fr);
  }
}

.stat-card-siswa {
  background: #fff;
  border-radius: 14px;
  padding: 20px 22px;
  border: 1px solid #f0f0f0;
  transition: all .3s cubic-bezier(.4,0,.2,1);
  position: relative;
  overflow: hidden;
}

.stat-card-siswa::before {
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

.stat-card-siswa:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,.1);
  border-color: var(--crimson);
}

.stat-card-siswa:hover::before {
  transform: scale(1.3) translate(-10px, 10px);
  opacity: .06;
}

.sc-blue-siswa::before { background: #0ea5e9; }
.sc-green-siswa::before { background: #10b981; }
.sc-red-siswa::before { background: #ef4444; }

/* Action Cards */
.action-card-siswa {
  background: #fff;
  border-radius: 14px;
  padding: 20px 22px;
  border: 1px solid #f0f0f0;
  transition: all .3s;
  cursor: pointer;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 16px;
}

.action-card-siswa:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,.12);
  border-color: var(--crimson);
}

.action-icon-siswa {
  width: 52px;
  height: 52px;
  border-radius: 13px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  color: #fff;
  flex-shrink: 0;
  transition: all .3s;
}

.action-card-siswa:hover .action-icon-siswa {
  transform: scale(1.08) rotate(-4deg);
}

/* Profile Card */
.profile-card-siswa {
  background: #fff;
  border-radius: 14px;
  padding: 22px 20px;
  border: 1px solid #f0f0f0;
  box-shadow: 0 2px 8px rgba(0,0,0,.04);
}

.profile-ava-siswa {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--crimson), var(--crimson-dark));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  font-weight: 900;
  color: #fff;
  margin: 0 auto 12px;
  box-shadow: 0 6px 20px rgba(237,27,59,.35);
  border: 3px solid #fff;
}

.profile-item-siswa {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid #f5f5f5;
}

.profile-item-siswa:last-child {
  border-bottom: none;
}

.profile-icon-siswa {
  width: 38px;
  height: 38px;
  border-radius: 10px;
  background: #fafbfc;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

/* Badge Siswa */
.badge-siswa {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: rgba(16,185,129,.1);
  color: #10b981;
  padding: 4px 12px;
  border-radius: 8px;
  font-size: .74rem;
  font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
  .stat-grid-siswa {
    grid-template-columns: 1fr;
    gap: 14px;
  }
  
  .welcome-banner-siswa {
    padding: 20px 18px;
  }
}
</style>

{{-- ══════════════════════════════════════════════════════════
     WELCOME BANNER SISWA
══════════════════════════════════════════════════════════ --}}
<div class="welcome-banner-siswa">
  <div style="flex:1;position:relative;z-index:1">
    <p style="font-size:.8rem;color:rgba(255,255,255,.65);margin:0 0 6px;font-weight:600;display:flex;align-items:center;gap:6px">
      <span>{{ $greeting }}</span>
      <span style="font-size:1.1rem">{{ $emoji }}</span>
    </p>
    <h1 style="font-size:1.55rem;font-weight:900;color:#fff;margin:0 0 10px;letter-spacing:-.02em">
      {{ $anggota->nama }}
    </h1>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
      <span style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);color:#fff;padding:5px 13px;border-radius:8px;font-size:.74rem;font-weight:700;border:1px solid rgba(255,255,255,.2)">
        <i class="bi bi-credit-card-2-front" style="font-size:.7rem"></i> {{ $anggota->nis }}
      </span>
      <span style="background:rgba(255,255,255,.15);backdrop-filter:blur(10px);color:#fff;padding:5px 13px;border-radius:8px;font-size:.74rem;font-weight:700;border:1px solid rgba(255,255,255,.2)">
        <i class="bi bi-mortarboard" style="font-size:.7rem"></i> {{ $anggota->kelas }}
      </span>
      <span style="background:rgba(16,185,129,.2);backdrop-filter:blur(10px);color:#dcfce7;padding:5px 13px;border-radius:8px;font-size:.74rem;font-weight:700;border:1px solid rgba(16,185,129,.3)">
        ● Anggota Aktif
      </span>
    </div>
  </div>
  <div style="position:relative;z-index:1;display:flex;align-items:center">
    <div style="width:56px;height:56px;background:rgba(255,255,255,.12);backdrop-filter:blur(10px);border-radius:14px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,.15);box-shadow:0 4px 16px rgba(0,0,0,.15)">
      <i class="bi bi-person-badge-fill" style="font-size:1.6rem;color:#fff"></i>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     STAT CARDS SISWA
══════════════════════════════════════════════════════════ --}}
<div class="stat-grid-siswa">
  {{-- Sedang Dipinjam --}}
  <div class="stat-card-siswa sc-blue-siswa">
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:12px">
      <div style="width:48px;height:48px;background:rgba(14,165,233,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;color:#0ea5e9">
        <i class="bi bi-book-fill"></i>
      </div>
      <div>
        <div style="font-size:.75rem;color:var(--tx-3);font-weight:700;text-transform:uppercase;letter-spacing:.05em">
          Sedang Dipinjam
        </div>
        <div style="font-size:1.75rem;font-weight:900;color:var(--navy-800);line-height:1;letter-spacing:-.02em">
          {{ $totalPinjam }}
        </div>
      </div>
    </div>
    <div style="font-size:.74rem;color:var(--tx-4);display:flex;align-items:center;gap:4px">
      <i class="bi bi-arrow-repeat" style="font-size:.7rem"></i>
      <span>{{ $totalPinjam == 0 ? 'Tidak ada pinjaman' : 'Buku aktif' }}</span>
    </div>
  </div>

  {{-- Sudah Dikembalikan --}}
  <div class="stat-card-siswa sc-green-siswa">
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:12px">
      <div style="width:48px;height:48px;background:rgba(16,185,129,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;color:#10b981">
        <i class="bi bi-check-circle-fill"></i>
      </div>
      <div>
        <div style="font-size:.75rem;color:var(--tx-3);font-weight:700;text-transform:uppercase;letter-spacing:.05em">
          Sudah Kembali
        </div>
        <div style="font-size:1.75rem;font-weight:900;color:var(--navy-800);line-height:1;letter-spacing:-.02em">
          {{ $totalKembali }}
        </div>
      </div>
    </div>
    <div style="font-size:.74rem;color:var(--tx-4);display:flex;align-items:center;gap:4px">
      <i class="bi bi-check2-all" style="font-size:.7rem"></i>
      <span>Riwayat selesai</span>
    </div>
  </div>

  {{-- Total Denda --}}
  <div class="stat-card-siswa sc-red-siswa">
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:12px">
      <div style="width:48px;height:48px;background:{{ $totalDenda > 0 ? 'rgba(239,68,68,.1)' : 'rgba(107,114,128,.1)' }};border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;color:{{ $totalDenda > 0 ? '#ef4444' : '#6b7280' }}">
        <i class="bi bi-cash-coin"></i>
      </div>
      <div>
        <div style="font-size:.75rem;color:var(--tx-3);font-weight:700;text-transform:uppercase;letter-spacing:.05em">
          Total Denda
        </div>
        <div style="font-size:{{ $totalDenda > 0 ? '1.15rem' : '1.75rem' }};font-weight:900;color:{{ $totalDenda > 0 ? '#ef4444' : 'var(--navy-800)' }};line-height:1;letter-spacing:-.02em">
          {{ $totalDenda > 0 ? 'Rp '.number_format($totalDenda,0,',','.') : 'Rp 0' }}
        </div>
      </div>
    </div>
    <div style="font-size:.74rem;color:{{ $totalDenda > 0 ? '#ef4444' : 'var(--tx-4)' }};display:flex;align-items:center;gap:4px">
      @if($totalDenda > 0)
        <i class="bi bi-exclamation-circle-fill" style="font-size:.7rem"></i>
        <span>Segera dilunasi</span>
      @else
        <i class="bi bi-check-circle-fill" style="font-size:.7rem"></i>
        <span>Tidak ada denda</span>
      @endif
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     QUICK ACTIONS
══════════════════════════════════════════════════════════ --}}
<div class="row g-3 mb-4">
  <div class="col-md-6">
    <a href="{{ route('siswa.peminjaman.create') }}" class="action-card-siswa">
      <div class="action-icon-siswa" style="background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 6px 20px rgba(245,158,11,.3)">
        <i class="bi bi-book-fill"></i>
      </div>
      <div style="flex:1;min-width:0">
        <h5 style="font-size:.96rem;font-weight:800;color:var(--navy-800);margin:0 0 4px">Pinjam Buku</h5>
        <p style="font-size:.78rem;color:var(--tx-3);margin:0">Jelajahi koleksi perpustakaan</p>
      </div>
      <i class="bi bi-arrow-right" style="font-size:1.1rem;color:var(--tx-4);flex-shrink:0"></i>
    </a>
  </div>
  <div class="col-md-6">
    <a href="{{ route('siswa.pengembalian.index') }}" class="action-card-siswa">
      <div class="action-icon-siswa" style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 6px 20px rgba(16,185,129,.3)">
        <i class="bi bi-box-arrow-in-left"></i>
      </div>
      <div style="flex:1;min-width:0">
        <h5 style="font-size:.96rem;font-weight:800;color:var(--navy-800);margin:0 0 4px">Kembalikan Buku</h5>
        <p style="font-size:.78rem;color:var(--tx-3);margin:0">Proses pengembalian buku</p>
      </div>
      <i class="bi bi-arrow-right" style="font-size:1.1rem;color:var(--tx-4);flex-shrink:0"></i>
    </a>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MAIN CONTENT — Riwayat & Profile
══════════════════════════════════════════════════════════ --}}
<div class="row g-3">
  {{-- LEFT: Riwayat Peminjaman --}}
  <div class="col-lg-8">
    <div class="cbox">
      <div class="cbox-header">
        <h3 style="font-size:1.05rem;font-weight:800;color:var(--navy-800);margin:0;display:flex;align-items:center;gap:8px">
          <i class="bi bi-clock-history" style="color:var(--crimson)"></i>
          Riwayat Peminjaman Saya
        </h3>
        <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-ghost btn-sm">
          Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
      </div>
      <div class="cbox-body" style="padding:0">
        <div class="table-responsive">
          <table class="table-lib-modern">
            <thead>
              <tr>
                <th style="width: 35%;">Buku</th>
                <th style="width: 20%;">Tgl Pinjam</th>
                <th style="width: 20%;">Batas Kembali</th>
                <th style="width: 25%;">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($riwayat->take(7) as $r)
              <tr>
                <td style="padding:14px 16px;width:35%;">
                  <div style="display:flex;align-items:center;gap:10px">
                    @if($r->buku && $r->buku->cover)
                      <img src="{{ Storage::url($r->buku->cover) }}" alt="{{ $r->buku->judul }}" 
                           style="width:32px;height:48px;object-fit:cover;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.12);flex-shrink:0;">
                    @else
                      <div style="width:32px;height:48px;border-radius:6px;background:linear-gradient(135deg,#581c87,#7c3aed);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <i class="bi bi-book-fill" style="color:rgba(255,255,255,.7);font-size:1rem"></i>
                      </div>
                    @endif
                    <span style="font-weight:600;color:var(--navy-800)">{{ Str::limit($r->buku->judul ?? '-', 30) }}</span>
                  </div>
                </td>
                <td style="font-size:.82rem;color:var(--tx-3);padding:14px 16px;white-space:nowrap;width:20%;">
                  {{ $r->tanggal_pinjam->format('d M Y') }}
                </td>
                <td style="font-size:.82rem;color:{{ $r->status === 'terlambat' ? '#ef4444' : 'var(--tx-3)' }};font-weight:{{ $r->status === 'terlambat' ? '700' : '400' }};padding:14px 16px;white-space:nowrap;width:20%;">
                  {{ $r->tanggal_kembali_rencana->format('d M Y') }}
                </td>
                <td style="padding:14px 16px;width:25%;">
                  @if($r->status === 'dipinjam')
                    <span class="status-badge sb-pinjam">
                      <i class="bi bi-arrow-repeat"></i> Dipinjam
                    </span>
                  @elseif($r->status === 'terlambat')
                    <span class="status-badge sb-terlambat">
                      <i class="bi bi-exclamation-circle-fill"></i> Terlambat
                    </span>
                  @else
                    <span class="status-badge sb-kembali">
                      <i class="bi bi-check-circle-fill"></i> Kembali
                    </span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" style="text-align:center;padding:48px 20px;color:var(--tx-4)">
                  <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:.25"></i>
                  <div style="font-weight:600;font-size:.88rem">Belum ada riwayat peminjaman</div>
                  <div style="font-size:.78rem;margin-top:4px">Mulai pinjam buku sekarang!</div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- RIGHT: Profile & Stats --}}
  <div class="col-lg-4">
    {{-- Profile Card --}}
    <div class="profile-card-siswa" style="margin-bottom:20px">
      <h4 style="font-size:1rem;font-weight:800;color:var(--navy-800);margin:0 0 16px;display:flex;align-items:center;gap:8px">
        <i class="bi bi-person-circle" style="color:#0ea5e9"></i>
        Profil Anggota
      </h4>
      
      <div style="text-align:center;margin-bottom:18px;padding-bottom:18px;border-bottom:1px solid #f5f5f5">
        @if($anggota->foto)
          <img src="{{ Storage::url($anggota->foto) }}" alt="{{ $anggota->nama }}" class="profile-ava-siswa" style="width:64px;height:64px;object-fit:cover;border-radius:50%;box-shadow:0 6px 20px rgba(237,27,59,.35);border:3px solid #fff;margin:0 auto 12px;">
        @else
          <div class="profile-ava-siswa">
            {{ strtoupper(substr($anggota->nama,0,1)) }}
          </div>
        @endif
        <h5 style="font-size:.94rem;font-weight:800;color:var(--navy-800);margin:0 0 6px">{{ $anggota->nama }}</h5>
        <span class="badge-siswa">
          <i class="bi bi-check-circle-fill"></i> Anggota Aktif
        </span>
      </div>

      <div>
        @foreach([
          ['bi-credit-card-2-front', 'NIS', $anggota->nis],
          ['bi-mortarboard', 'Kelas', $anggota->kelas],
          ['bi-telephone', 'Telepon', $anggota->telepon ?? '—'],
        ] as [$ico, $lbl, $val])
        <div class="profile-item-siswa">
          <div class="profile-icon-siswa">
            <i class="bi {{ $ico }}" style="color:var(--tx-3);font-size:.9rem"></i>
          </div>
          <div style="flex:1;min-width:0">
            <p style="font-size:.7rem;color:var(--tx-4);margin:0;text-transform:uppercase;letter-spacing:.05em;font-weight:700">{{ $lbl }}</p>
            <p style="font-size:.84rem;color:var(--navy-800);margin:0;font-weight:600">{{ $val }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Performance Card --}}
    <div class="profile-card-siswa">
      <h4 style="font-size:1rem;font-weight:800;color:var(--navy-800);margin:0 0 18px;display:flex;align-items:center;gap:8px">
        <i class="bi bi-graph-up" style="color:#10b981"></i>
        Tingkat Pengembalian
      </h4>
      
      @php
        $returnRate = $totalPinjam + $totalKembali > 0 ? round(($totalKembali / ($totalPinjam + $totalKembali)) * 100) : 100;
      @endphp
      
      <div style="text-align:center;margin-bottom:18px">
        <div style="position:relative;width:120px;height:120px;margin:0 auto">
          <svg width="120" height="120" style="transform:rotate(-90deg)">
            <circle cx="60" cy="60" r="48" fill="none" stroke="#f0f0f0" stroke-width="12"/>
            <circle cx="60" cy="60" r="48" fill="none" stroke="var(--crimson)" stroke-width="12"
                    stroke-dasharray="{{ (2 * 3.14159 * 48 * $returnRate) / 100 }} {{ 2 * 3.14159 * 48 }}"
                    stroke-linecap="round"/>
          </svg>
          <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center">
            <div style="font-size:1.8rem;font-weight:900;color:var(--crimson);line-height:1">{{ $returnRate }}%</div>
            <div style="font-size:.68rem;color:var(--tx-3);margin-top:3px;font-weight:600">Return Rate</div>
          </div>
        </div>
      </div>

      <div style="display:flex;flex-direction:column;gap:10px">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:rgba(14,165,233,.08);border-radius:10px">
          <div style="display:flex;align-items:center;gap:8px">
            <div style="width:8px;height:8px;border-radius:50%;background:#0ea5e9"></div>
            <span style="font-size:.8rem;color:var(--tx-2);font-weight:600">Sedang Dipinjam</span>
          </div>
          <span style="font-size:.85rem;font-weight:800;color:var(--navy-800)">{{ $totalPinjam }}</span>
        </div>
        
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:rgba(16,185,129,.08);border-radius:10px">
          <div style="display:flex;align-items:center;gap:8px">
            <div style="width:8px;height:8px;border-radius:50%;background:#10b981"></div>
            <span style="font-size:.8rem;color:var(--tx-2);font-weight:600">Sudah Dikembalikan</span>
          </div>
          <span style="font-size:.85rem;font-weight:800;color:var(--navy-800)">{{ $totalKembali }}</span>
        </div>
      </div>
    </div>
  </div>
</div>

@else
<div class="alert alert-warning" style="border-radius:14px;display:flex;align-items:center;gap:12px">
  <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem"></i>
  <div>
    <strong style="display:block;margin-bottom:4px">Data Anggota Tidak Ditemukan</strong>
    <span style="font-size:.85rem">Silakan hubungi admin perpustakaan untuk informasi lebih lanjut.</span>
  </div>
</div>
@endif
@endsection

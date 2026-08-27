@extends('layouts.app')
@section('title','Dashboard Siswa')
@section('page-title','Dashboard')
@section('content')

@if($anggota)
@php
  $hour = (int) date('H');
  $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
  $emoji = $hour < 11 ? '☀️' : ($hour < 15 ? '🌤️' : ($hour < 18 ? '🌇' : '🌙'));
@endphp

{{-- ── Hero Banner ───────────────────────────────────────────────── --}}
<div style="
  background:linear-gradient(135deg, #0c1829 0%, #0f1f3d 40%, #1a3461 80%, #1e4080 100%);
  border-radius:20px;padding:0;margin-bottom:24px;
  position:relative;overflow:hidden;
  box-shadow:0 8px 32px rgba(15,31,61,.38);
  min-height:160px;
  display:flex;align-items:stretch;
">
  {{-- Decorative elements --}}
  <div style="position:absolute;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,.025);top:-100px;right:-80px;pointer-events:none"></div>
  <div style="position:absolute;width:180px;height:180px;border-radius:50%;background:rgba(245,158,11,.06);bottom:-60px;right:180px;pointer-events:none"></div>
  <div style="position:absolute;width:60px;height:60px;border-radius:50%;border:1px solid rgba(255,255,255,.08);bottom:30px;right:340px;pointer-events:none"></div>

  {{-- Gold accent bar --}}
  <div style="width:5px;background:linear-gradient(180deg,var(--gold-400),var(--gold-500));flex-shrink:0;border-radius:20px 0 0 20px"></div>

  <div style="padding:26px 28px;flex:1;position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
    <div>
      <p style="color:rgba(255,255,255,.4);font-size:.74rem;font-weight:600;margin:0 0 6px;letter-spacing:.05em;text-transform:uppercase">
        {{ $emoji }} {{ $greeting }}
      </p>
      <h2 style="color:#fff;font-weight:900;font-size:1.55rem;margin:0 0 10px;letter-spacing:-.03em;line-height:1.1">
        {{ $anggota->nama }}
      </h2>
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
        <span style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.75);padding:3px 11px;border-radius:99px;font-size:.73rem;font-weight:600;display:flex;align-items:center;gap:5px">
          <i class="bi bi-credit-card-2-front" style="font-size:.7rem"></i>{{ $anggota->nis }}
        </span>
        <span style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.12);color:rgba(255,255,255,.75);padding:3px 11px;border-radius:99px;font-size:.73rem;font-weight:600;display:flex;align-items:center;gap:5px">
          <i class="bi bi-mortarboard" style="font-size:.7rem"></i>{{ $anggota->kelas }}
        </span>
        <span style="background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.3);color:#86efac;padding:3px 11px;border-radius:99px;font-size:.73rem;font-weight:700">
          ● Anggota Aktif
        </span>
      </div>
    </div>

    {{-- Big avatar --}}
    <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,var(--gold-400),var(--gold-500));display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:900;color:#fff;flex-shrink:0;box-shadow:0 6px 24px rgba(245,158,11,.45);border:3px solid rgba(255,255,255,.15)">
      {{ strtoupper(substr($anggota->nama,0,1)) }}
    </div>
  </div>
</div>

{{-- ── Stat Cards ────────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
  @php
  $sCards = [
    [
      'ico'   => 'bi-book-fill',
      'grad'  => 'linear-gradient(135deg,#0ea5e9,#2563eb)',
      'glow'  => 'rgba(14,165,233,.2)',
      'bg'    => '#eff6ff',
      'val'   => $totalPinjam,
      'lbl'   => 'Sedang Dipinjam',
      'sub'   => $totalPinjam==0 ? 'Tidak ada pinjaman' : 'Buku aktif',
    ],
    [
      'ico'   => 'bi-check-circle-fill',
      'grad'  => 'linear-gradient(135deg,#10b981,#16a34a)',
      'glow'  => 'rgba(16,185,129,.2)',
      'bg'    => '#f0fdf4',
      'val'   => $totalKembali,
      'lbl'   => 'Sudah Kembali',
      'sub'   => 'Riwayat selesai',
    ],
    [
      'ico'   => 'bi-cash-coin',
      'grad'  => ($totalDenda>0) ? 'linear-gradient(135deg,#f43f5e,#dc2626)' : 'linear-gradient(135deg,#6b7280,#4b5563)',
      'glow'  => ($totalDenda>0) ? 'rgba(244,63,94,.2)' : 'rgba(107,114,128,.15)',
      'bg'    => ($totalDenda>0) ? '#fff1f2' : '#f8fafc',
      'val'   => $totalDenda>0 ? 'Rp '.number_format($totalDenda,0,',','.') : 'Rp 0',
      'lbl'   => 'Total Denda',
      'sub'   => $totalDenda>0 ? 'Harap segera dilunasi' : 'Tidak ada denda',
      'warn'  => $totalDenda>0,
    ],
  ];
  @endphp

  @foreach($sCards as $c)
  <div class="col-4">
    <div style="
      background:var(--surface);border-radius:18px;
      border:1px solid {{ (!empty($c['warn']) && $c['warn']) ? '#fecdd3' : 'var(--border)' }};
      box-shadow:var(--sh-sm);
      padding:18px 16px;
      transition:transform .22s ease,box-shadow .22s ease;
      position:relative;overflow:hidden;
    " onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='var(--sh-md)'"
       onmouseout="this.style.transform='';this.style.boxShadow='var(--sh-sm)'">

      <div style="position:absolute;width:90px;height:90px;border-radius:50%;background:{{ $c['glow'] }};top:-30px;right:-20px;pointer-events:none;filter:blur(16px)"></div>

      <div style="width:42px;height:42px;border-radius:12px;background:{{ $c['grad'] }};display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:#fff;margin-bottom:12px;box-shadow:0 4px 12px {{ $c['glow'] }};position:relative;z-index:1">
        <i class="bi {{ $c['ico'] }}"></i>
      </div>
      <div style="font-size:{{ strlen((string)$c['val'])>6 ? '1rem' : '1.55rem' }};font-weight:900;line-height:1;letter-spacing:-.03em;color:{{ (!empty($c['warn'])&&$c['warn']) ? 'var(--red-500)' : 'var(--navy-800)' }};margin-bottom:5px;position:relative;z-index:1">
        {{ $c['val'] }}
      </div>
      <div style="font-size:.72rem;font-weight:700;color:var(--tx-1);margin-bottom:2px;position:relative;z-index:1">{{ $c['lbl'] }}</div>
      <div style="font-size:.68rem;color:{{ (!empty($c['warn'])&&$c['warn']) ? 'var(--red-500)' : 'var(--tx-4)' }};position:relative;z-index:1">{{ $c['sub'] }}</div>
    </div>
  </div>
  @endforeach
</div>

{{-- ── Quick Actions ─────────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
  <div class="col-sm-6">
    <a href="{{ route('siswa.peminjaman.create') }}" style="display:block;text-decoration:none">
      <div style="
        background:linear-gradient(135deg,#f59e0b 0%,#d97706 100%);
        border-radius:18px;padding:22px 24px;
        box-shadow:0 6px 24px rgba(245,158,11,.35);
        transition:transform .22s ease,box-shadow .22s ease;
        position:relative;overflow:hidden;
      " onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 36px rgba(245,158,11,.48)'"
         onmouseout="this.style.transform='';this.style.boxShadow='0 6px 24px rgba(245,158,11,.35)'">
        <div style="position:absolute;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.1);top:-40px;right:-30px;pointer-events:none"></div>
        <div style="position:absolute;width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,.07);bottom:-10px;right:60px;pointer-events:none"></div>
        <div style="display:flex;align-items:center;gap:16px;position:relative;z-index:1">
          <div style="width:52px;height:52px;background:rgba(255,255,255,.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;backdrop-filter:blur(4px)">
            <i class="bi bi-book-fill" style="color:#fff"></i>
          </div>
          <div style="flex:1;min-width:0">
            <p style="font-weight:900;font-size:1rem;margin:0 0 3px;color:#fff;letter-spacing:-.01em">Pinjam Buku</p>
            <p style="font-size:.76rem;color:rgba(255,255,255,.7);margin:0">Jelajahi koleksi perpustakaan</p>
          </div>
          <div style="width:32px;height:32px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="bi bi-arrow-right" style="color:#fff;font-size:.85rem"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6">
    <a href="{{ route('siswa.pengembalian.index') }}" style="display:block;text-decoration:none">
      <div style="
        background:linear-gradient(135deg,#22c55e 0%,#16a34a 100%);
        border-radius:18px;padding:22px 24px;
        box-shadow:0 6px 24px rgba(34,197,94,.3);
        transition:transform .22s ease,box-shadow .22s ease;
        position:relative;overflow:hidden;
      " onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 36px rgba(34,197,94,.44)'"
         onmouseout="this.style.transform='';this.style.boxShadow='0 6px 24px rgba(34,197,94,.3)'">
        <div style="position:absolute;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.09);top:-40px;right:-30px;pointer-events:none"></div>
        <div style="display:flex;align-items:center;gap:16px;position:relative;z-index:1">
          <div style="width:52px;height:52px;background:rgba(255,255,255,.2);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">
            <i class="bi bi-box-arrow-in-left" style="color:#fff"></i>
          </div>
          <div style="flex:1;min-width:0">
            <p style="font-weight:900;font-size:1rem;margin:0 0 3px;color:#fff;letter-spacing:-.01em">Kembalikan Buku</p>
            <p style="font-size:.76rem;color:rgba(255,255,255,.7);margin:0">Proses pengembalian buku</p>
          </div>
          <div style="width:32px;height:32px;background:rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="bi bi-arrow-right" style="color:#fff;font-size:.85rem"></i>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>

{{-- ── Recent + Status summary ───────────────────────────────────── --}}
<div class="row g-3">
  <div class="col-lg-8">
    <div class="data-card" style="border-radius:18px">
      <div class="data-card-header" style="padding:18px 22px">
        <h6 style="font-size:.9rem"><i class="bi bi-clock-history" style="color:var(--blue-500)"></i> Riwayat Terbaru</h6>
        <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-ghost btn-sm">Semua <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="table-responsive">
        <table class="dt">
          <thead><tr><th>Buku</th><th>Tgl Pinjam</th><th>Batas</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($riwayat as $r)
            <tr>
              <td style="font-weight:700;max-width:180px">{{ Str::limit($r->buku->judul??'-',28) }}</td>
              <td style="font-size:.8rem;white-space:nowrap">{{ $r->tanggal_pinjam->format('d M Y') }}</td>
              <td style="font-size:.8rem;white-space:nowrap;{{ $r->status==='terlambat'?'color:var(--red-500);font-weight:700':'' }}">
                {{ $r->tanggal_kembali_rencana->format('d M Y') }}
              </td>
              <td>
                @if($r->status==='dipinjam')     <span class="status-badge sb-pinjam"><i class="bi bi-circle-fill" style="font-size:.4rem"></i>Dipinjam</span>
                @elseif($r->status==='terlambat') <span class="status-badge sb-terlambat"><i class="bi bi-exclamation-circle-fill" style="font-size:.68rem"></i>Terlambat</span>
                @else                             <span class="status-badge sb-kembali"><i class="bi bi-check-circle-fill" style="font-size:.68rem"></i>Kembali</span>
                @endif
              </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;padding:36px;color:var(--tx-4)">
              <i class="bi bi-book" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.2"></i>
              Belum ada riwayat peminjaman.
            </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Info card --}}
  <div class="col-lg-4">
    <div style="background:var(--surface);border-radius:18px;border:1px solid var(--border);box-shadow:var(--sh-sm);padding:22px;height:100%">
      <h6 style="font-size:.88rem;font-weight:800;color:var(--navy-800);margin:0 0 18px;display:flex;align-items:center;gap:8px">
        <i class="bi bi-person-badge-fill" style="color:var(--blue-500)"></i> Profil Anggota
      </h6>

      {{-- Avatar + name --}}
      <div style="text-align:center;padding-bottom:18px;border-bottom:1px solid var(--border-2);margin-bottom:18px">
        <div style="width:58px;height:58px;border-radius:50%;background:linear-gradient(135deg,var(--navy-800),var(--blue-500));display:flex;align-items:center;justify-content:center;font-size:1.45rem;font-weight:900;color:#fff;margin:0 auto 10px;box-shadow:0 6px 18px rgba(37,99,235,.28)">
          {{ strtoupper(substr($anggota->nama,0,1)) }}
        </div>
        <p style="font-weight:800;font-size:.92rem;color:var(--navy-800);margin:0 0 3px">{{ $anggota->nama }}</p>
        <span class="status-badge sb-aktif" style="font-size:.7rem">● Anggota Aktif</span>
      </div>

      {{-- Info rows --}}
      @foreach([
        ['bi-credit-card-2-front', 'NIS', $anggota->nis],
        ['bi-mortarboard',         'Kelas', $anggota->kelas],
        ['bi-telephone',           'Telepon', $anggota->telepon ?? '—'],
      ] as [$ico,$lbl,$val])
      <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--border-2)">
        <div style="width:30px;height:30px;border-radius:8px;background:var(--surface-2);display:flex;align-items:center;justify-content:center;flex-shrink:0">
          <i class="bi {{ $ico }}" style="color:var(--tx-3);font-size:.8rem"></i>
        </div>
        <div>
          <p style="font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--tx-4);margin:0">{{ $lbl }}</p>
          <p style="font-size:.82rem;font-weight:600;color:var(--tx-1);margin:0">{{ $val }}</p>
        </div>
      </div>
      @endforeach

      <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-primary w-100" style="justify-content:center;margin-top:16px">
        <i class="bi bi-book-fill"></i> Pinjam Buku Sekarang
      </a>
    </div>
  </div>
</div>

{{-- ── Buku Populer ─────────────────────────────────────────────── --}}
<div style="background:var(--surface);border-radius:18px;border:1px solid var(--border);box-shadow:var(--sh-sm);overflow:hidden;margin-top:4px">
  <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px">
    <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;color:#fff;font-size:.9rem;box-shadow:0 3px 10px rgba(245,158,11,.35)">
      <i class="bi bi-fire"></i>
    </div>
    <div>
      <h6 style="font-size:.9rem;font-weight:800;margin:0;color:var(--navy-800)">Buku Paling Populer</h6>
      <p style="font-size:.72rem;color:var(--tx-4);margin:0">Paling banyak dipinjam oleh siswa</p>
    </div>
  </div>

  @if($bukuPopuler->isEmpty())
  <div style="text-align:center;padding:28px;color:var(--tx-4);font-size:.83rem">Belum ada data.</div>
  @else
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:0">
    @foreach($bukuPopuler as $idx => $b)
    @php
      $grads=['#0f1f3d,#1e4080','#581c87,#7c3aed','#064e3b,#059669','#78350f,#d97706','#881337,#e11d48','#0c4a6e,#0284c7'];
      $g=$grads[$idx%count($grads)];
    @endphp
    <a href="{{ route('siswa.peminjaman.create') }}?search={{ urlencode($b->judul) }}" style="text-decoration:none;padding:14px 16px;border-right:1px solid var(--border-2);border-bottom:1px solid var(--border-2);display:flex;flex-direction:column;gap:10px;transition:background .18s;position:relative"
       onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background=''">
      {{-- Rank badge --}}
      @if($idx < 3)
      <div style="position:absolute;top:8px;right:8px;width:20px;height:20px;border-radius:50%;background:{{ $idx===0?'linear-gradient(135deg,#f59e0b,#d97706)':($idx===1?'linear-gradient(135deg,#94a3b8,#64748b)':'linear-gradient(135deg,#cd7f32,#a0522d)') }};display:flex;align-items:center;justify-content:center;font-size:.62rem;font-weight:800;color:#fff;box-shadow:0 2px 6px rgba(0,0,0,.2)">
        {{ $idx+1 }}
      </div>
      @endif
      {{-- Mini book cover --}}
      <div style="width:100%;padding-top:140%;border-radius:9px;overflow:hidden;background:linear-gradient(150deg,{{ $g }});position:relative;box-shadow:0 4px 12px rgba(0,0,0,.18)">
        @if($b->cover)
          <img src="{{ Storage::url($b->cover) }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
        @else
          <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:8px;text-align:center;gap:4px">
            <i class="bi bi-book-fill" style="font-size:1.4rem;color:rgba(255,255,255,.6)"></i>
            <span style="font-size:.62rem;font-weight:700;color:rgba(255,255,255,.8);line-height:1.2;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $b->judul }}</span>
          </div>
        @endif
        <div style="position:absolute;left:0;top:0;bottom:0;width:5px;background:linear-gradient(to right,rgba(0,0,0,.28),transparent);z-index:2"></div>
      </div>
      <div>
        <p style="font-size:.77rem;font-weight:700;color:var(--tx-1);margin:0 0 2px;line-height:1.3;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">{{ $b->judul }}</p>
        <p style="font-size:.68rem;color:var(--tx-4);margin:0 0 5px">{{ $b->pengarang }}</p>
        <div style="display:flex;align-items:center;justify-content:space-between">
          <span style="font-size:.68rem;font-weight:700;color:var(--gold-500);display:flex;align-items:center;gap:3px">
            <i class="bi bi-fire" style="font-size:.65rem"></i>{{ $b->peminjaman_count }}x
          </span>
          <span class="status-badge {{ $b->stok>0?'sb-ada':'sb-habis' }}" style="font-size:.6rem;padding:.2em .55em">
            {{ $b->stok>0 ? 'Ada' : 'Habis' }}
          </span>
        </div>
      </div>
    </a>
    @endforeach
  </div>
  @endif
</div>

@else
<div class="alert alert-warning d-flex align-items-center gap-2" style="border-radius:12px">
  <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
  <span>Data anggota tidak ditemukan. Hubungi admin perpustakaan.</span>
</div>
@endif
@endsection

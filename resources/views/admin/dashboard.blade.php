@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard')
@section('content')

@php
  $hour = (int) date('H');
  $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
  $emoji = $hour < 11 ? '☀️' : ($hour < 15 ? '🌤️' : ($hour < 18 ? '🌇' : '🌙'));
@endphp

{{-- ── Hero Banner ─────────────────────────────────────── --}}
<div style="background:linear-gradient(135deg,var(--navy-950) 0%,var(--navy-800) 45%,var(--navy-600) 100%);border-radius:20px;padding:28px 32px;margin-bottom:24px;position:relative;overflow:hidden;box-shadow:0 8px 32px rgba(15,31,61,.35)">
  <div style="position:absolute;width:280px;height:280px;border-radius:50%;background:rgba(255,255,255,.03);top:-100px;right:-60px;pointer-events:none"></div>
  <div style="position:absolute;width:160px;height:160px;border-radius:50%;background:rgba(245,158,11,.07);bottom:-50px;right:220px;pointer-events:none"></div>
  <div style="position:absolute;width:100px;height:100px;border-radius:50%;border:1px solid rgba(255,255,255,.06);bottom:20px;right:60px;pointer-events:none"></div>
  <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
    <div>
      <p style="color:rgba(255,255,255,.45);font-size:.78rem;font-weight:600;margin:0 0 6px;letter-spacing:.04em;text-transform:uppercase">
        {{ $emoji }} {{ $greeting }},
      </p>
      <h2 style="color:#fff;font-weight:900;font-size:1.65rem;margin:0 0 8px;letter-spacing:-.03em;line-height:1.1">
        {{ auth()->user()->name }}
      </h2>
      <p style="color:rgba(255,255,255,.45);font-size:.82rem;margin:0;display:flex;align-items:center;gap:8px">
        <i class="bi bi-calendar3"></i>
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
      </p>
    </div>
    <div style="text-align:right">
      <div style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:14px;padding:16px 22px">
        <p style="color:rgba(255,255,255,.45);font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;margin:0 0 4px">Total Koleksi</p>
        <p style="color:#fff;font-size:2rem;font-weight:900;margin:0;letter-spacing:-.04em;line-height:1">{{ $totalBuku }}</p>
        <p style="color:rgba(255,255,255,.4);font-size:.72rem;margin:4px 0 0">buku terdaftar</p>
      </div>
    </div>
  </div>
</div>

{{-- ── Stat Cards ───────────────────────────────────────── --}}
<div class="row g-3 mb-4">
  @php
  $stats = [
    ['icon'=>'bi-people-fill',              'grad'=>'linear-gradient(135deg,#6366f1,#8b5cf6)', 'glow'=>'rgba(99,102,241,.25)',  'val'=>$totalAnggota,   'lbl'=>'Total Anggota',   'sub'=>'Anggota terdaftar',       'link'=>route('admin.anggota.index')],
    ['icon'=>'bi-arrow-left-right',         'grad'=>'linear-gradient(135deg,#0ea5e9,#2563eb)', 'glow'=>'rgba(14,165,233,.25)',  'val'=>$totalPinjam,    'lbl'=>'Sedang Dipinjam', 'sub'=>'Aktif dipinjam',           'link'=>route('admin.transaksi.index').'?status=dipinjam'],
    ['icon'=>'bi-check-circle-fill',        'grad'=>'linear-gradient(135deg,#10b981,#16a34a)', 'glow'=>'rgba(16,185,129,.25)',  'val'=>$totalKembali,   'lbl'=>'Dikembalikan',    'sub'=>'Selesai dikembalikan',     'link'=>route('admin.transaksi.index').'?status=dikembalikan'],
    ['icon'=>'bi-exclamation-triangle-fill','grad'=>'linear-gradient(135deg,#f43f5e,#dc2626)', 'glow'=>'rgba(244,63,94,.25)',   'val'=>$totalTerlambat, 'lbl'=>'Terlambat',       'sub'=>'Perlu tindakan segera',    'link'=>route('admin.transaksi.index').'?status=terlambat'],
  ];
  @endphp
  @foreach($stats as $s)
  <div class="col-6 col-xl-3">
    <a href="{{ $s['link'] }}" style="text-decoration:none;display:block">
      <div style="background:var(--surface);border-radius:18px;border:1px solid var(--border);box-shadow:var(--sh-sm);padding:20px 22px;transition:transform .22s ease,box-shadow .22s ease;position:relative;overflow:hidden;cursor:pointer"
           onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--sh-lg)'"
           onmouseout="this.style.transform='';this.style.boxShadow='var(--sh-sm)'">
        <div style="position:absolute;width:120px;height:120px;border-radius:50%;background:{{ $s['glow'] }};top:-40px;right:-30px;pointer-events:none;filter:blur(20px)"></div>
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:14px">
          <div style="width:46px;height:46px;border-radius:13px;background:{{ $s['grad'] }};display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;flex-shrink:0;box-shadow:0 4px 14px {{ $s['glow'] }}">
            <i class="bi {{ $s['icon'] }}"></i>
          </div>
          <i class="bi bi-arrow-up-right" style="color:var(--tx-4);font-size:.85rem;margin-top:4px"></i>
        </div>
        <div style="font-size:2rem;font-weight:900;color:var(--navy-800);line-height:1;letter-spacing:-.04em;margin-bottom:4px;position:relative;z-index:1">{{ $s['val'] }}</div>
        <div style="font-size:.75rem;font-weight:700;color:var(--tx-1);margin-bottom:2px;position:relative;z-index:1">{{ $s['lbl'] }}</div>
        <div style="font-size:.7rem;color:var(--tx-4);position:relative;z-index:1">{{ $s['sub'] }}</div>
      </div>
    </a>
  </div>
  @endforeach
</div>

{{-- ── Row: Transaksi + Aksi Cepat + Ringkasan ─────────── --}}
<div class="row g-3 mb-3">
  {{-- Transaksi Terbaru --}}
  <div class="col-lg-8">
    <div class="data-card" style="border-radius:18px;height:100%">
      <div class="data-card-header" style="padding:18px 22px">
        <div style="display:flex;align-items:center;gap:10px">
          <div style="width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,.2)"></div>
          <h6 style="font-size:.92rem">Transaksi Terbaru</h6>
        </div>
        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-ghost btn-sm">Lihat Semua <i class="bi bi-arrow-right"></i></a>
      </div>
      <div class="table-responsive">
        <table class="dt">
          <thead><tr><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Status</th></tr></thead>
          <tbody>
            @forelse($peminjamanTerbaru as $p)
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:10px">
                  <div class="ava" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">{{ strtoupper(substr($p->anggota->nama??'A',0,1)) }}</div>
                  <div>
                    <div style="font-weight:700;font-size:.84rem;line-height:1.2">{{ $p->anggota->nama??'-' }}</div>
                    <div style="font-size:.71rem;color:var(--tx-4)">{{ $p->anggota->kelas??'' }}</div>
                  </div>
                </div>
              </td>
              <td style="font-size:.83rem;font-weight:500;color:var(--tx-2);max-width:160px">{{ Str::limit($p->buku->judul??'-',24) }}</td>
              <td style="font-size:.8rem;color:var(--tx-3);white-space:nowrap">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
              <td>
                @if($p->status==='dipinjam')     <span class="status-badge sb-pinjam"><i class="bi bi-circle-fill" style="font-size:.4rem"></i>Dipinjam</span>
                @elseif($p->status==='terlambat') <span class="status-badge sb-terlambat"><i class="bi bi-exclamation-circle-fill" style="font-size:.68rem"></i>Terlambat</span>
                @else                             <span class="status-badge sb-kembali"><i class="bi bi-check-circle-fill" style="font-size:.68rem"></i>Kembali</span>
                @endif
              </td>
            </tr>
            @empty
            <tr><td colspan="4">
              <div class="empty" style="padding:32px"><span class="empty-ico"><i class="bi bi-inbox"></i></span><p>Belum ada transaksi.</p></div>
            </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Panel kanan --}}
  <div class="col-lg-4">
    {{-- Aksi Cepat --}}
    <div style="background:var(--surface);border-radius:18px;border:1px solid var(--border);box-shadow:var(--sh-sm);padding:20px;margin-bottom:14px">
      <h6 style="font-size:.88rem;font-weight:800;color:var(--navy-800);margin:0 0 14px;display:flex;align-items:center;gap:8px">
        <i class="bi bi-lightning-fill" style="color:var(--gold-400)"></i> Aksi Cepat
      </h6>
      <div style="display:flex;flex-direction:column;gap:8px">
        @foreach([
          [route('admin.transaksi.create'),'bi-plus-circle-fill','Tambah Transaksi','#eff6ff','#2563eb'],
          [route('admin.buku.create'),     'bi-journal-plus',    'Tambah Buku',     '#ede9fe','#7c3aed'],
          [route('admin.anggota.create'),  'bi-person-plus-fill','Tambah Anggota',  '#f0fdf4','#16a34a'],
        ] as [$url,$ico,$lbl,$bg,$color])
        <a href="{{ $url }}" style="display:flex;align-items:center;gap:12px;padding:11px 14px;background:{{ $bg }};border-radius:12px;text-decoration:none;transition:transform .18s"
           onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform=''">
          <i class="bi {{ $ico }}" style="color:{{ $color }};font-size:1rem;flex-shrink:0"></i>
          <span style="font-size:.83rem;font-weight:600;color:var(--tx-1)">{{ $lbl }}</span>
          <i class="bi bi-chevron-right" style="color:var(--tx-4);margin-left:auto;font-size:.75rem"></i>
        </a>
        @endforeach
      </div>
    </div>

    {{-- Ringkasan Status --}}
    <div style="background:linear-gradient(135deg,var(--navy-900),var(--navy-700));border-radius:18px;padding:20px;box-shadow:var(--sh-md)">
      <h6 style="font-size:.8rem;font-weight:700;color:rgba(255,255,255,.5);margin:0 0 14px;text-transform:uppercase;letter-spacing:.08em">Ringkasan Status</h6>
      @php
        $total = $totalPinjam + $totalTerlambat + $totalKembali;
        $items = [['Dipinjam',$totalPinjam,'#60a5fa'],['Terlambat',$totalTerlambat,'#f87171'],['Kembali',$totalKembali,'#34d399']];
      @endphp
      @foreach($items as [$lbl,$val,$c])
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
        <div style="width:10px;height:10px;border-radius:50%;background:{{ $c }};flex-shrink:0;box-shadow:0 0 6px {{ $c }}88"></div>
        <span style="font-size:.82rem;color:rgba(255,255,255,.7);flex:1">{{ $lbl }}</span>
        <span style="font-size:.88rem;font-weight:800;color:#fff">{{ $val }}</span>
        <div style="width:55px;height:5px;background:rgba(255,255,255,.1);border-radius:99px;overflow:hidden">
          <div style="height:100%;width:{{ $total>0?round($val/$total*100):0 }}%;background:{{ $c }};border-radius:99px"></div>
        </div>
      </div>
      @endforeach
      <div style="margin-top:12px;padding-top:12px;border-top:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between">
        <span style="font-size:.74rem;color:rgba(255,255,255,.4)">Total Transaksi</span>
        <span style="font-size:1.1rem;font-weight:900;color:#fff">{{ $total }}</span>
      </div>
    </div>
  </div>
</div>

{{-- ── Buku Paling Sering Dipinjam ─────────────────────── --}}
<div style="background:var(--surface);border-radius:18px;border:1px solid var(--border);box-shadow:var(--sh-sm);overflow:hidden">
  <div style="padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
    <div style="display:flex;align-items:center;gap:12px">
      <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;font-size:.95rem;color:#fff;box-shadow:0 3px 10px rgba(245,158,11,.35)">
        <i class="bi bi-fire"></i>
      </div>
      <div>
        <h6 style="font-size:.92rem;font-weight:800;margin:0;color:var(--navy-800)">Buku Paling Sering Dipinjam</h6>
        <p style="font-size:.72rem;color:var(--tx-4);margin:0">Berdasarkan total semua transaksi</p>
      </div>
    </div>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-ghost btn-sm">Lihat Semua <i class="bi bi-arrow-right"></i></a>
  </div>

  @if($bukuPopuler->isEmpty())
  <div class="empty" style="padding:36px"><span class="empty-ico"><i class="bi bi-book"></i></span><p>Belum ada data peminjaman.</p></div>
  @else
  <div style="padding:8px 20px 16px">
    @php $maxCount = max($bukuPopuler->first()->peminjaman_count, 1); @endphp
    @foreach($bukuPopuler as $idx => $b)
    @php
      $grads   = ['#0f1f3d,#1e4080','#581c87,#7c3aed','#064e3b,#059669','#78350f,#d97706','#881337,#e11d48'];
      $bars    = ['#60a5fa','#a78bfa','#34d399','#fbbf24','#f87171'];
      $pct     = round($b->peminjaman_count / $maxCount * 100);
    @endphp
    <div style="display:flex;align-items:center;gap:14px;padding:13px 0;{{ !$loop->last?'border-bottom:1px solid var(--border-2)':'' }}">
      {{-- Rank --}}
      <div style="width:28px;height:28px;border-radius:8px;background:{{ $idx===0?'linear-gradient(135deg,#f59e0b,#d97706)':'var(--surface-2)' }};display:flex;align-items:center;justify-content:center;font-size:{{ $idx===0?'1rem':'.75rem' }};font-weight:900;color:{{ $idx===0?'#fff':'var(--tx-3)' }};flex-shrink:0;box-shadow:{{ $idx===0?'0 3px 10px rgba(245,158,11,.4)':'none' }}">
        {{ $idx===0 ? '🏆' : ($idx+1) }}
      </div>
      {{-- Mini cover --}}
      <div style="width:38px;height:57px;border-radius:7px;overflow:hidden;flex-shrink:0;background:linear-gradient(150deg,{{ $grads[$idx % count($grads)] }});position:relative;box-shadow:0 3px 10px rgba(0,0,0,.2)">
        @if($b->cover)
          <img src="{{ Storage::url($b->cover) }}" style="width:100%;height:100%;object-fit:cover">
        @else
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:.8rem;color:rgba(255,255,255,.65)"><i class="bi bi-book-fill"></i></div>
        @endif
        <div style="position:absolute;left:0;top:0;bottom:0;width:4px;background:linear-gradient(to right,rgba(0,0,0,.28),transparent)"></div>
      </div>
      {{-- Info + bar --}}
      <div style="flex:1;min-width:0">
        <p style="font-size:.85rem;font-weight:700;color:var(--tx-1);margin:0 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $b->judul }}</p>
        <p style="font-size:.72rem;color:var(--tx-3);margin:0 0 7px">{{ $b->pengarang }}</p>
        <div style="height:5px;background:var(--border-2);border-radius:99px;overflow:hidden">
          <div style="height:100%;width:{{ $pct }}%;background:{{ $bars[$idx % count($bars)] }};border-radius:99px;transition:width .8s ease"></div>
        </div>
      </div>
      {{-- Count --}}
      <div style="text-align:right;flex-shrink:0">
        <div style="font-size:1.15rem;font-weight:900;color:var(--navy-800);line-height:1">{{ $b->peminjaman_count }}</div>
        <div style="font-size:.67rem;color:var(--tx-4)">kali dipinjam</div>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>

@endsection

@extends('layouts.app')
@section('title','Dashboard Siswa')
@section('page-title','Dashboard Siswa')
@section('content')
{{--
  VIEW: siswa/dashboard.blade.php
  FUNGSI: Halaman utama siswa setelah login — ringkasan aktivitas peminjaman.

  VARIABEL DARI Siswa\DashboardController::index():
    $anggota      → Model Anggota milik user yang login (bisa null jika belum ada)
    $totalPinjam  → jumlah buku yang masih di tangan siswa (dipinjam+terlambat+pending_kembali)
    $totalKembali → jumlah peminjaman yang sudah selesai dikembalikan
    $totalDenda   → total rupiah denda belum lunas (sum, bukan count)
    $riwayat      → Collection 5 transaksi terbaru (eager load buku)
    $riwayatDenda → Collection semua transaksi yang punya denda (untuk tabel tagihan)
    $bukuPopuler  → Collection 8 buku paling sering dipinjam (dengan peminjaman_count)

  SECTION UTAMA:
    1. Hero           → sapa siswa + 3 stat kartu (pinjam, kembali, denda)
    2. Aktivitas terbaru → tabel 5 transaksi terakhir
    3. Denda & tagihan  → tabel semua denda yang belum/sudah lunas
    4. Buku populer     → grid 8 buku populer (link ke detail)

  CATATAN:
    Jika $anggota null → tetap tampilkan halaman tapi dengan angka 0 semua.
    Ini terjadi saat user baru register tapi data anggota belum terbuat (edge case).
--}}@if($anggota)
@php
  $hour = (int) date('H');
  $greeting = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
  $totalRiwayat = $totalPinjam + $totalKembali;
  $returnRate = $totalRiwayat > 0 ? round(($totalKembali / $totalRiwayat) * 100) : 0;
  $pctKembali = $returnRate;
  $pctPinjam  = $totalRiwayat > 0 ? max(0, 100 - $pctKembali) : 0;
@endphp

<style>
/* ══ SISWA DASHBOARD — PREMIUM v3 ══ */
.sd-wrap{display:flex;flex-direction:column;gap:22px}

/* ── Hero ── */
.sd-hero{
  position:relative;overflow:hidden;isolation:isolate;
  border-radius:18px;padding:28px 32px;
  background:
    linear-gradient(125deg,rgba(11,23,48,.95) 0%,rgba(20,40,75,.9) 55%,rgba(160,18,40,.5) 100%),
    url('/image/wood-bg.jpg') center/cover;
  color:#fff;
  box-shadow:0 16px 40px rgba(11,23,48,.28);
  display:grid;grid-template-columns:1.4fr .9fr;gap:24px;align-items:center;
}
.sd-hero::before{
  content:'';position:absolute;inset:0;z-index:0;
  background:radial-gradient(ellipse at 80% 20%,rgba(244,185,66,.18),transparent 55%);
  pointer-events:none;
}
.sd-hero>*{position:relative;z-index:1}
.sd-kicker{
  display:inline-flex;align-items:center;gap:8px;
  font-size:.68rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;
  color:rgba(255,255,255,.65);margin-bottom:10px;
}
.sd-kicker span{width:6px;height:6px;border-radius:50%;background:var(--gold-400);box-shadow:0 0 0 4px rgba(244,185,66,.2)}
.sd-hero h1{
  font-family:'Playfair Display',serif;font-size:clamp(1.45rem,2.2vw,2rem);
  font-weight:800;line-height:1.15;margin:0 0 10px;letter-spacing:-.02em;
}
.sd-hero p{margin:0;color:rgba(255,255,255,.68);font-size:.88rem;line-height:1.55;max-width:40ch}
.sd-hero-actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:18px}
.sd-btn{
  display:inline-flex;align-items:center;gap:8px;
  padding:10px 16px;border-radius:10px;font-size:.82rem;font-weight:700;
  text-decoration:none;transition:all .2s;border:1px solid transparent;
}
.sd-btn-primary{background:var(--crimson);color:#fff}
.sd-btn-primary:hover{background:var(--crimson-dark);color:#fff;transform:translateY(-1px)}
.sd-btn-ghost{background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.18)}
.sd-btn-ghost:hover{background:rgba(255,255,255,.18);color:#fff}
.sd-hero-stats{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.sd-hero-stat{
  background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);
  backdrop-filter:blur(10px);border-radius:12px;padding:14px 16px;
}
.sd-hero-stat b{display:block;font-size:1.4rem;font-weight:900;letter-spacing:-.03em;line-height:1}
.sd-hero-stat span{display:block;margin-top:6px;font-size:.66rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.55)}

/* ── Metrics ── */
.sd-metrics{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.sd-metric{
  background:#fff;border:1px solid var(--border);border-radius:14px;
  padding:18px 18px 16px;box-shadow:var(--sh-xs);
  transition:transform .2s,box-shadow .2s,border-color .2s;
  position:relative;overflow:hidden;
}
.sd-metric::after{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--m-accent)}
.sd-metric:hover{transform:translateY(-3px);box-shadow:var(--sh-md);border-color:transparent}
.sd-metric-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
.sd-metric-icon{
  width:40px;height:40px;border-radius:11px;display:grid;place-items:center;
  background:color-mix(in srgb,var(--m-accent) 12%,white);color:var(--m-accent);font-size:1.05rem;
}
.sd-metric-label{font-size:.68rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--tx-3)}
.sd-metric-value{font-size:1.75rem;font-weight:900;color:var(--navy-800);letter-spacing:-.03em;line-height:1;margin:4px 0 8px}
.sd-metric-note{font-size:.72rem;color:var(--tx-4);display:flex;align-items:center;gap:5px}
.m-sky{--m-accent:#0284c7}
.m-emerald{--m-accent:#059669}
.m-rose{--m-accent:#e11d48}

/* ── Panel ── */
.sd-panel{
  background:#fff;border:1px solid var(--border);border-radius:16px;
  box-shadow:var(--sh-xs);overflow:hidden;
}
.sd-panel-head{
  display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
  padding:16px 20px;border-bottom:1px solid var(--border-2);
  background:linear-gradient(180deg,#fff,#fafbfc);
}
.sd-panel-head h3{
  margin:0;font-size:.98rem;font-weight:800;color:var(--navy-800);
  display:flex;align-items:center;gap:8px;
}
.sd-panel-head h3 i{color:var(--crimson)}
.sd-panel-body{padding:18px 20px}
.sd-link{
  font-size:.78rem;font-weight:700;color:var(--crimson);text-decoration:none;
  display:inline-flex;align-items:center;gap:5px;
}
.sd-link:hover{color:var(--crimson-dark)}

/* ── Book Showcase ── */
.sd-books{display:grid;grid-template-columns:repeat(8,minmax(0,1fr));gap:12px}
.sd-book{text-decoration:none;color:inherit;display:block;transition:transform .2s}
.sd-book:hover{transform:translateY(-4px)}
.sd-book-cover{
  aspect-ratio:2/3;border-radius:8px;overflow:hidden;background:#1e293b;
  box-shadow:0 8px 20px rgba(11,23,48,.18);margin-bottom:8px;position:relative;
}
.sd-book-cover img{width:100%;height:100%;object-fit:cover;display:block}
.sd-book-cover .ph{
  width:100%;height:100%;display:grid;place-items:center;
  color:rgba(255,255,255,.4);font-size:1.4rem;
  background:linear-gradient(150deg,#0f1f3d,#1e4080);
}
.sd-book-stok{
  position:absolute;left:6px;bottom:6px;
  font-size:.58rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;
  padding:3px 7px;border-radius:5px;color:#fff;
}
.sd-book-stok.ok{background:rgba(5,150,105,.9)}
.sd-book-stok.out{background:rgba(190,18,60,.9)}
.sd-book-title{
  font-size:.72rem;font-weight:800;color:var(--navy-800);line-height:1.3;
  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;
}
.sd-book-author{font-size:.64rem;color:var(--tx-4);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

/* ── Main grid ── */
.sd-grid{display:grid;grid-template-columns:1.7fr 1fr;gap:16px;align-items:start}

/* ── Table ── */
.sd-table{width:100%;border-collapse:collapse}
.sd-table th{
  text-align:left;font-size:.67rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;
  color:var(--tx-3);padding:12px 16px;background:#f8fafc;border-bottom:1px solid var(--border);
}
.sd-table td{padding:14px 16px;border-bottom:1px solid #f3f4f6;vertical-align:middle;font-size:.82rem}
.sd-table tr:last-child td{border-bottom:none}
.sd-table tbody tr:hover{background:#fafbfc}
.sd-bookcell{display:flex;align-items:center;gap:10px}
.sd-bookcell img,.sd-bookcell .ph{
  width:36px;height:52px;border-radius:5px;object-fit:cover;flex-shrink:0;
  box-shadow:0 2px 8px rgba(0,0,0,.14);
}
.sd-bookcell .ph{background:linear-gradient(135deg,#0f1f3d,#1e4080);display:grid;place-items:center;color:rgba(255,255,255,.55);font-size:.85rem}
.sd-muted{color:var(--tx-3);font-size:.78rem}
.sd-status{
  display:inline-flex;align-items:center;gap:5px;font-size:.68rem;font-weight:800;
  padding:4px 10px;border-radius:99px;white-space:nowrap;
}
.sd-status.ok{background:#d1fae5;color:#065f46}
.sd-status.run{background:#e0f2fe;color:#075985}
.sd-status.late{background:#ffe4e6;color:#9f1239}

/* ── Donut ── */
.sd-donut-wrap{
  display:flex;justify-content:center;padding:16px 0 18px;
  background:linear-gradient(160deg,#fff,#f4f7fb);border-radius:12px;margin-bottom:14px;
}
.sd-donut{width:156px;height:156px;position:relative;flex-shrink:0}
.sd-donut-ring{
  width:100%;height:100%;border-radius:50%;
  background:conic-gradient(
    #10b981 0 calc(var(--k,0) * 1%),
    #0ea5e9 calc(var(--k,0) * 1%) 100%
  );
  -webkit-mask:radial-gradient(farthest-side,transparent 61%,#000 62.5%);
  mask:radial-gradient(farthest-side,transparent 61%,#000 62.5%);
  box-shadow:0 6px 18px rgba(15,23,42,.07);
}
.sd-donut.empty .sd-donut-ring{background:conic-gradient(#e2e8f0 0 100%)}
.sd-donut-center{
  position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);
  width:78px;display:flex;flex-direction:column;align-items:center;
  justify-content:center;text-align:center;pointer-events:none;line-height:1.15;
}
.sd-donut-center b{display:block;font-size:1.5rem;font-weight:900;color:var(--navy-800);line-height:1;letter-spacing:-.03em}
.sd-donut-center span{display:block;font-size:.57rem;font-weight:700;color:var(--tx-3);line-height:1.2;margin-top:5px;letter-spacing:.04em;text-transform:uppercase;white-space:nowrap}
.sd-stat-rows{display:flex;flex-direction:column;gap:8px}
.sd-stat-row{
  display:flex;align-items:center;justify-content:space-between;gap:10px;
  padding:11px 12px;border-radius:10px;border:1px solid var(--border);border-left:3px solid var(--c);background:#fff;
}
.sd-stat-row>span:first-child{display:flex;align-items:center;gap:8px;font-size:.79rem;font-weight:700;color:var(--navy-800)}
.sd-stat-row i{width:8px;height:8px;border-radius:50%;background:var(--c);display:block}
.sd-stat-row b{font-size:.82rem;font-weight:900;padding:3px 9px;border-radius:7px;background:color-mix(in srgb,var(--c) 14%,white);color:var(--c)}

/* ── Fine list ── */
.sd-fine-list{display:flex;flex-direction:column}
.sd-fine-row{display:flex;align-items:center;gap:12px;padding:13px 16px;border-bottom:1px solid #f3f4f6}
.sd-fine-row:last-child{border-bottom:0}
.sd-fine-cover{width:36px;height:52px;border-radius:5px;object-fit:cover;flex-shrink:0;box-shadow:0 2px 7px rgba(0,0,0,.12)}
.sd-fine-ph{width:36px;height:52px;border-radius:5px;flex-shrink:0;background:linear-gradient(145deg,#145b71,#168b86);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.8)}
.sd-fine-meta{flex:1;min-width:0}
.sd-fine-title{font-size:.8rem;font-weight:800;color:var(--navy-800);line-height:1.35;overflow-wrap:anywhere}
.sd-fine-sub{font-size:.68rem;color:var(--tx-3);margin-top:3px}
.sd-fine-amount{text-align:right;min-width:110px}
.sd-fine-val{font-size:.86rem;font-weight:900;color:#be123c}
.sd-fine-val.paid{color:#047857}
.sd-fine-badge{display:inline-flex;align-items:center;gap:4px;margin-top:4px;padding:3px 8px;border-radius:6px;font-size:.64rem;font-weight:800}
.sd-fine-badge.unpaid{background:#fff1f2;color:#be123c}
.sd-fine-badge.paid{background:#ecfdf5;color:#047857}
.sd-fine-empty{padding:22px 16px;text-align:center;color:var(--tx-4);font-size:.8rem}

/* ── Quick actions ── */
.sd-qa{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.sd-qa-item{
  display:flex;align-items:center;gap:14px;padding:16px;
  background:#fff;border:1px solid var(--border);border-radius:13px;
  text-decoration:none;color:inherit;transition:all .2s;
}
.sd-qa-item:hover{border-color:rgba(237,27,59,.3);box-shadow:var(--sh-sm);transform:translateY(-2px);color:inherit}
.sd-qa-icon{
  width:44px;height:44px;border-radius:12px;display:grid;place-items:center;
  font-size:1.05rem;color:#fff;flex-shrink:0;
}
.sd-qa-txt strong{display:block;font-size:.82rem;color:var(--navy-800)}
.sd-qa-txt span{font-size:.7rem;color:var(--tx-4)}

/* ── Responsive ── */
@media(max-width:1100px){
  .sd-books{grid-template-columns:repeat(5,1fr)}
  .sd-grid{grid-template-columns:1fr}
  .sd-metrics{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:768px){
  .sd-hero{grid-template-columns:1fr;padding:22px 20px}
  .sd-hero-stats{grid-template-columns:1fr 1fr}
  .sd-books{grid-template-columns:repeat(4,1fr);gap:10px}
  .sd-metrics{grid-template-columns:repeat(3,1fr)}
  .sd-qa{grid-template-columns:1fr 1fr}
  .sd-table{min-width:520px}
}
@media(max-width:480px){
  .sd-metrics{grid-template-columns:1fr}
  .sd-books{grid-template-columns:repeat(2,1fr)}
  .sd-qa{grid-template-columns:1fr}
  .sd-hero-actions .sd-btn{flex:1;justify-content:center}
}
</style>

<div class="sd-wrap">

  {{-- Hero --}}
  <section class="sd-hero">
    <div>
      <div class="sd-kicker"><span></span> {{ $greeting }} · {{ now()->translatedFormat('l, d F Y') }}</div>
      <h1>{{ $anggota->nama }}</h1>
      <p>Selamat datang di perpustakaan digital. Kelola pinjaman, pantau denda, dan temukan bacaan baru.</p>
      <div class="sd-hero-actions">
        <a href="{{ route('siswa.peminjaman.create') }}" class="sd-btn sd-btn-primary"><i class="bi bi-plus-lg"></i> Pinjam Buku</a>
        <a href="{{ route('siswa.pengembalian.index') }}" class="sd-btn sd-btn-ghost"><i class="bi bi-box-arrow-in-left"></i> Kembalikan Buku</a>
      </div>
    </div>
    <div class="sd-hero-stats">
      <div class="sd-hero-stat"><b>{{ $totalPinjam }}</b><span>Dipinjam</span></div>
      <div class="sd-hero-stat"><b>{{ $totalKembali }}</b><span>Dikembalikan</span></div>
      <div class="sd-hero-stat"><b>{{ $anggota->nis }}</b><span>NIS</span></div>
      <div class="sd-hero-stat"><b>{{ $anggota->kelas }}</b><span>Kelas</span></div>
    </div>
  </section>

  {{-- Metrics --}}
  <section class="sd-metrics">
    <div class="sd-metric m-sky">
      <div class="sd-metric-top">
        <div class="sd-metric-icon"><i class="bi bi-book-fill"></i></div>
      </div>
      <div class="sd-metric-label">Sedang Dipinjam</div>
      <div class="sd-metric-value">{{ $totalPinjam }}</div>
      <div class="sd-metric-note"><i class="bi bi-arrow-repeat"></i> {{ $totalPinjam == 0 ? 'Tidak ada pinjaman aktif' : 'Buku aktif' }}</div>
    </div>
    <div class="sd-metric m-emerald">
      <div class="sd-metric-top">
        <div class="sd-metric-icon"><i class="bi bi-check-circle-fill"></i></div>
      </div>
      <div class="sd-metric-label">Sudah Dikembalikan</div>
      <div class="sd-metric-value">{{ $totalKembali }}</div>
      <div class="sd-metric-note"><i class="bi bi-check2-all"></i> Riwayat selesai</div>
    </div>
    <div class="sd-metric m-rose">
      <div class="sd-metric-top">
        <div class="sd-metric-icon"><i class="bi bi-cash-coin"></i></div>
      </div>
      <div class="sd-metric-label">Denda Belum Lunas</div>
      <div class="sd-metric-value" style="font-size:{{ $totalDenda > 0 ? '1.1rem' : '1.75rem' }};color:{{ $totalDenda > 0 ? '#e11d48' : 'var(--navy-800)' }}">
        {{ $totalDenda > 0 ? 'Rp '.number_format($totalDenda,0,',','.') : 'Rp 0' }}
      </div>
      <div class="sd-metric-note" style="color:{{ $totalDenda > 0 ? '#e11d48' : 'var(--tx-4)' }}">
        @if($totalDenda > 0)
          <i class="bi bi-exclamation-circle-fill"></i> Segera dilunasi
        @else
          <i class="bi bi-check-circle-fill" style="color:#059669"></i> Tidak ada denda aktif
        @endif
      </div>
    </div>
  </section>

  {{-- Buku Populer dari DB --}}
  @if($bukuPopuler->isNotEmpty())
  <section class="sd-panel">
    <div class="sd-panel-head">
      <h3><i class="bi bi-fire"></i> Buku Populer</h3>
      <a href="{{ route('siswa.peminjaman.create') }}" class="sd-link">Pinjam sekarang <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="sd-panel-body">
      <div class="sd-books">
        @foreach($bukuPopuler as $b)
        <a href="{{ route('siswa.peminjaman.create', ['search' => $b->judul]) }}" class="sd-book">
          <div class="sd-book-cover">
            @if($b->cover)
              <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}" loading="lazy">
            @else
              <div class="ph"><i class="bi bi-book-fill"></i></div>
            @endif
            <span class="sd-book-stok {{ $b->stok > 0 ? 'ok' : 'out' }}">{{ $b->stok > 0 ? $b->stok.' stok' : 'Habis' }}</span>
          </div>
          <div class="sd-book-title">{{ $b->judul }}</div>
          <div class="sd-book-author">{{ $b->pengarang }}</div>
        </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  {{-- Main grid: Riwayat + Sidebar ── --}}
  <div class="sd-grid">

    {{-- Left: Riwayat + Denda + Aksi cepat --}}
    <div style="display:flex;flex-direction:column;gap:16px">

      {{-- Riwayat Peminjaman --}}
      <section class="sd-panel">
        <div class="sd-panel-head">
          <h3><i class="bi bi-clock-history"></i> Riwayat Peminjaman</h3>
          <a href="{{ route('siswa.peminjaman.index') }}" class="sd-link">Lihat semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="table-responsive">
          <table class="sd-table">
            <thead>
              <tr>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($riwayat as $r)
              <tr>
                <td>
                  <div class="sd-bookcell">
                    @if($r->buku && $r->buku->cover)
                      <img src="{{ Storage::url($r->buku->cover) }}" alt="{{ $r->buku->judul }}">
                    @else
                      <div class="ph"><i class="bi bi-book-fill"></i></div>
                    @endif
                    <span style="font-weight:700;color:var(--tx-1)">{{ Str::limit($r->buku->judul ?? '-', 30) }}</span>
                  </div>
                </td>
                <td class="sd-muted">{{ $r->tanggal_pinjam?->format('d M Y') ?? '—' }}</td>
                <td class="sd-muted {{ $r->status === 'terlambat' ? 'text-danger fw-bold' : '' }}">{{ $r->tanggal_kembali_rencana?->format('d M Y') ?? '—' }}</td>
                <td>
                  @if($r->status === 'dikembalikan')
                    <span class="sd-status ok"><i class="bi bi-check-circle-fill"></i> Kembali</span>
                  @elseif($r->status === 'dipinjam')
                    <span class="sd-status run"><i class="bi bi-arrow-repeat"></i> Dipinjam</span>
                  @else
                    <span class="sd-status late"><i class="bi bi-exclamation-circle-fill"></i> Terlambat</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4">
                  <div style="text-align:center;padding:32px 16px;color:var(--tx-4)">
                    <i class="bi bi-journal-bookmark" style="font-size:2rem;opacity:.3;display:block;margin-bottom:8px"></i>
                    <div style="font-size:.84rem">Belum ada riwayat peminjaman</div>
                    <a href="{{ route('siswa.peminjaman.create') }}" style="display:inline-flex;align-items:center;gap:5px;margin-top:10px;font-size:.78rem;font-weight:700;color:var(--crimson)">
                      <i class="bi bi-book"></i> Pinjam buku pertamamu
                    </a>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </section>

      {{-- Denda --}}
      <section class="sd-panel">
        <div class="sd-panel-head">
          <h3><i class="bi bi-receipt-cutoff"></i> Riwayat Denda</h3>
          <span style="font-size:.72rem;font-weight:700;color:var(--tx-3)">{{ $riwayatDenda->count() }} catatan</span>
        </div>
        <div class="sd-fine-list">
          @forelse($riwayatDenda as $d)
          <div class="sd-fine-row">
            @if($d->buku && $d->buku->cover)
              <img src="{{ Storage::url($d->buku->cover) }}" alt="{{ $d->buku->judul }}" class="sd-fine-cover">
            @else
              <div class="sd-fine-ph"><i class="bi bi-book-fill" style="font-size:.85rem"></i></div>
            @endif
            <div class="sd-fine-meta">
              <div class="sd-fine-title">{{ $d->buku->judul ?? 'Buku tidak tersedia' }}</div>
              <div class="sd-fine-sub">
                Denda {{ $d->tanggal_kembali_aktual?->isoFormat('D MMM YYYY') ?? '—' }}
                @if($d->denda_dibayar)
                  · Lunas {{ $d->denda_dibayar_at?->isoFormat('D MMM YYYY') ?? '' }}
                @endif
              </div>
            </div>
            <div class="sd-fine-amount">
              <div class="sd-fine-val {{ $d->denda_dibayar ? 'paid' : '' }}">Rp {{ number_format($d->denda,0,',','.') }}</div>
              @if($d->denda_dibayar)
                <span class="sd-fine-badge paid"><i class="bi bi-check-circle-fill"></i> Lunas</span>
              @else
                <span class="sd-fine-badge unpaid"><i class="bi bi-clock-fill"></i> Belum lunas</span>
              @endif
            </div>
          </div>
          @empty
          <div class="sd-fine-empty"><i class="bi bi-check-circle" style="color:#059669;margin-right:5px"></i> Tidak ada riwayat denda.</div>
          @endforelse
        </div>
      </section>

      {{-- Aksi Cepat --}}
      <section class="sd-panel">
        <div class="sd-panel-head">
          <h3><i class="bi bi-lightning-charge-fill"></i> Aksi Cepat</h3>
        </div>
        <div class="sd-panel-body">
          <div class="sd-qa">
            <a href="{{ route('siswa.peminjaman.create') }}" class="sd-qa-item">
              <div class="sd-qa-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 4px 14px rgba(245,158,11,.3)"><i class="bi bi-book-fill"></i></div>
              <div class="sd-qa-txt"><strong>Pinjam Buku</strong><span>Jelajahi koleksi</span></div>
            </a>
            <a href="{{ route('siswa.pengembalian.index') }}" class="sd-qa-item">
              <div class="sd-qa-icon" style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 14px rgba(16,185,129,.3)"><i class="bi bi-box-arrow-in-left"></i></div>
              <div class="sd-qa-txt"><strong>Kembalikan Buku</strong><span>Proses pengembalian</span></div>
            </a>
            <a href="{{ route('siswa.peminjaman.index') }}" class="sd-qa-item">
              <div class="sd-qa-icon" style="background:linear-gradient(135deg,#3b82f6,#2563eb);box-shadow:0 4px 14px rgba(59,130,246,.3)"><i class="bi bi-clock-history"></i></div>
              <div class="sd-qa-txt"><strong>Riwayat Lengkap</strong><span>Semua transaksi</span></div>
            </a>
            <a href="{{ route('siswa.profil.index') }}" class="sd-qa-item">
              <div class="sd-qa-icon" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);box-shadow:0 4px 14px rgba(139,92,246,.3)"><i class="bi bi-person-fill"></i></div>
              <div class="sd-qa-txt"><strong>Profil Saya</strong><span>Edit data diri</span></div>
            </a>
          </div>
        </div>
      </section>
    </div>

    {{-- Right: Donut + Profil --}}
    <div style="display:flex;flex-direction:column;gap:16px">

      {{-- Donut Stats --}}
      <section class="sd-panel">
        <div class="sd-panel-head">
          <h3><i class="bi bi-pie-chart-fill"></i> Tingkat Pengembalian</h3>
        </div>
        <div class="sd-panel-body">
          <div class="sd-donut-wrap">
            <div class="sd-donut {{ $totalRiwayat > 0 ? '' : 'empty' }}" style="--k:{{ $pctKembali }};--p:{{ $pctPinjam }}"
                 role="img" aria-label="{{ $totalKembali }} dikembalikan, {{ $totalPinjam }} dipinjam">
              <div class="sd-donut-ring"></div>
              <div class="sd-donut-center">
                <b>{{ $returnRate }}%</b>
                <span>Kembali</span>
              </div>
            </div>
          </div>
          <div class="sd-stat-rows">
            <div class="sd-stat-row" style="--c:#0284c7"><span><i></i> Sedang Dipinjam</span><b>{{ $totalPinjam }}</b></div>
            <div class="sd-stat-row" style="--c:#059669"><span><i></i> Sudah Dikembalikan</span><b>{{ $totalKembali }}</b></div>
          </div>
        </div>
      </section>

      {{-- Profile Card --}}
      <section class="sd-panel">
        <div class="sd-panel-head">
          <h3><i class="bi bi-person-badge-fill"></i> Profil Anggota</h3>
          <a href="{{ route('siswa.profil.index') }}" class="sd-link">Edit <i class="bi bi-pencil"></i></a>
        </div>
        <div class="sd-panel-body" style="text-align:center;padding-bottom:8px">
          <div style="margin-bottom:14px">
            @if($anggota->foto)
              <img src="{{ Storage::url($anggota->foto) }}" alt="{{ $anggota->nama }}"
                style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #fff;
                       box-shadow:0 6px 20px rgba(237,27,59,.28);margin:0 auto 10px;display:block">
            @else
              <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
                          display:flex;align-items:center;justify-content:center;font-size:1.7rem;font-weight:900;
                          color:#fff;margin:0 auto 10px;box-shadow:0 6px 20px rgba(237,27,59,.35);border:3px solid #fff">
                {{ strtoupper(substr($anggota->nama,0,1)) }}
              </div>
            @endif
            <div style="font-size:.96rem;font-weight:800;color:var(--navy-800)">{{ $anggota->nama }}</div>
            <div style="display:inline-flex;align-items:center;gap:5px;margin-top:6px;background:#d1fae5;color:#065f46;
                        padding:4px 12px;border-radius:99px;font-size:.7rem;font-weight:800;border:1px solid #a7f3d0">
              <i class="bi bi-circle-fill" style="font-size:.4rem"></i> Anggota Aktif
            </div>
          </div>
        </div>
        <div style="border-top:1px solid var(--border-2)">
          @foreach([
            ['bi-credit-card-2-front','NIS',$anggota->nis],
            ['bi-mortarboard-fill','Kelas',$anggota->kelas],
            ['bi-telephone-fill','Telepon',$anggota->telepon ?? '—'],
          ] as [$ico,$lbl,$val])
          <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #f3f4f6">
            <div style="width:34px;height:34px;border-radius:9px;background:#f1f5f9;display:grid;place-items:center;color:var(--tx-3);font-size:.85rem;flex-shrink:0">
              <i class="bi {{ $ico }}"></i>
            </div>
            <div>
              <div style="font-size:.64rem;font-weight:800;color:var(--tx-4);text-transform:uppercase;letter-spacing:.06em">{{ $lbl }}</div>
              <div style="font-size:.84rem;font-weight:700;color:var(--navy-800)">{{ $val }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </section>

    </div>
  </div>

</div>

@else
<div style="background:#fffbeb;border:1px solid #fde68a;border-radius:14px;padding:20px 24px;display:flex;align-items:center;gap:14px">
  <i class="bi bi-exclamation-triangle-fill" style="font-size:1.4rem;color:#d97706"></i>
  <div>
    <strong style="display:block;margin-bottom:4px;color:var(--navy-800)">Data Anggota Tidak Ditemukan</strong>
    <span style="font-size:.85rem;color:var(--tx-3)">Silakan hubungi admin perpustakaan untuk mendaftarkan akunmu.</span>
  </div>
</div>
@endif
@endsection

@push('styles')
<style>
/* ── sd-btn-primary (Pinjam Buku): glow + plus bounce ── */
.sd-btn-primary{
  position:relative;overflow:hidden;
  animation:sdPrimaryGlow 2.4s ease-in-out infinite;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s ease !important;
}
@keyframes sdPrimaryGlow{
  0%,100%{box-shadow:0 3px 12px rgba(237,27,59,.3)}
  50%{box-shadow:0 8px 24px rgba(237,27,59,.55),0 0 0 5px rgba(237,27,59,.12)}
}
.sd-btn-primary:hover{
  animation:none;
  transform:translateY(-3px) scale(1.06) !important;
  box-shadow:0 12px 28px rgba(237,27,59,.5) !important;
}
.sd-btn-primary::before{
  content:'';position:absolute;top:0;left:-110%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-20deg);pointer-events:none;
}
.sd-btn-primary:hover::before{animation:sdShimmer .5s ease forwards;}
@keyframes sdShimmer{0%{left:-110%}100%{left:120%}}
.sd-btn-primary i{display:inline-block;transition:transform .35s cubic-bezier(.34,1.56,.64,1);}
.sd-btn-primary:hover i{transform:rotate(135deg) scale(1.3);}
/* ── sd-btn-ghost (Kembalikan): arrow spins ── */
.sd-btn-ghost{
  position:relative;overflow:hidden;
  transition:all .25s cubic-bezier(.34,1.56,.64,1) !important;
}
.sd-btn-ghost:hover{
  background:rgba(255,255,255,.22) !important;
  transform:translateY(-3px) scale(1.05) !important;
  box-shadow:0 6px 18px rgba(0,0,0,.25) !important;
}
.sd-btn-ghost i{display:inline-block;transition:transform .35s cubic-bezier(.34,1.56,.64,1);}
.sd-btn-ghost:hover i{animation:sdArrowSpin .5s ease;}
@keyframes sdArrowSpin{
  0%{transform:rotate(0deg) scale(1)}
  40%{transform:rotate(-160deg) scale(1.2)}
  70%{transform:rotate(-330deg) scale(1.1)}
  100%{transform:rotate(-360deg) scale(1)}
}
.sd-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:sdRipple .4s linear;pointer-events:none;}
@keyframes sdRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.sd-btn').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='sd-ripple';
      const rect=btn.getBoundingClientRect(),size=Math.max(rect.width,rect.height)*1.8;
      r.style.cssText=`width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
      if(getComputedStyle(btn).position==='static')btn.style.position='relative';
      btn.style.overflow='hidden';btn.appendChild(r);
      r.addEventListener('animationend',()=>r.remove());
    });
  });
});
</script>
@endpush

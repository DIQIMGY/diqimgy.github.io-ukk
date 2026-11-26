@extends('layouts.app')
@section('title','Riwayat Peminjaman')
@section('page-title','Riwayat Peminjaman')
@section('content')
<style>
/* ══ PEMINJAMAN PAGE — PREMIUM v4 (with approval) ══ */
.pm-wrap{display:flex;flex-direction:column;gap:20px;max-width:1280px;margin:0 auto}

/* ── Toolbar ── */
.pm-toolbar{
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:14px;
  padding:20px 24px;
  background:#fff;border:1px solid var(--border);border-radius:16px;
  box-shadow:var(--sh-xs);
  position:relative;overflow:hidden;
}
.pm-toolbar::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:4px;
  background:linear-gradient(180deg,var(--crimson),#f59e0b);
  box-shadow:0 0 16px rgba(237,27,59,.25);
}
.pm-toolbar-left{display:flex;flex-direction:column;gap:2px}
.pm-toolbar-title{font-size:1rem;font-weight:900;color:var(--navy-800);display:flex;align-items:center;gap:8px}
.pm-toolbar-title i{color:var(--crimson)}
.pm-toolbar-sub{font-size:.74rem;color:var(--tx-3)}
.pm-toolbar-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.pm-btn-new{
  display:inline-flex;align-items:center;gap:8px;
  padding:11px 20px;border-radius:11px;font-size:.84rem;font-weight:700;
  background:var(--crimson);color:#fff;text-decoration:none;
  transition:all .2s;box-shadow:0 4px 14px rgba(237,27,59,.3);border:none;
}
.pm-btn-new:hover{background:var(--crimson-dark);color:#fff;transform:translateY(-2px);box-shadow:0 6px 20px rgba(237,27,59,.4)}
.pm-filter-form{display:flex;align-items:center;gap:8px}
.pm-select{
  padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;
  font-size:.82rem;font-weight:600;color:var(--navy-800);background:#fff;
  cursor:pointer;transition:border-color .2s,box-shadow .2s;min-width:195px;
  font-family:'Inter',sans-serif;
}
.pm-select:focus{outline:none;border-color:var(--crimson);box-shadow:0 0 0 3px rgba(237,27,59,.1)}
.pm-btn-filter{
  width:40px;height:40px;border:1.5px solid var(--border);border-radius:10px;
  background:#fff;display:grid;place-items:center;cursor:pointer;
  font-size:.95rem;color:var(--tx-3);transition:all .2s;
}
.pm-btn-filter:hover{background:var(--crimson);border-color:var(--crimson);color:#fff;transform:translateY(-1px)}

/* ── Pending banner ── */
.pm-pending-banner{
  display:flex;align-items:center;gap:14px;
  padding:16px 22px;border-radius:14px;
  background:linear-gradient(135deg,#fffbeb,#fef9ee);
  border:1.5px solid #fde68a;
  box-shadow:0 4px 16px rgba(245,158,11,.12);
}
.pm-pending-banner-icon{
  width:44px;height:44px;border-radius:12px;flex-shrink:0;
  background:linear-gradient(135deg,#f59e0b,#d97706);
  display:grid;place-items:center;color:#fff;font-size:1.15rem;
  box-shadow:0 4px 12px rgba(245,158,11,.3);
}
.pm-pending-banner-body{flex:1;min-width:0}
.pm-pending-banner-title{font-size:.9rem;font-weight:800;color:#92400e;margin-bottom:2px}
.pm-pending-banner-sub{font-size:.76rem;color:#b45309}
.pm-pending-count{
  padding:6px 14px;border-radius:8px;font-size:.8rem;font-weight:900;
  background:#f59e0b;color:#fff;white-space:nowrap;
  box-shadow:0 2px 8px rgba(245,158,11,.3);
}

/* ── Card ── */
.pm-card{
  background:#fff;border:1px solid var(--border);border-radius:16px;
  box-shadow:var(--sh-xs);overflow:hidden;
}
.pm-card-head{
  display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;
  padding:16px 22px;border-bottom:1px solid var(--border-2);
  background:linear-gradient(180deg,#fff,#fafbfc);
}
.pm-card-title{
  display:flex;align-items:center;gap:9px;
  font-size:.97rem;font-weight:800;color:var(--navy-800);margin:0;
}
.pm-card-title i{color:var(--crimson)}
.pm-count{
  display:inline-flex;align-items:center;gap:5px;
  padding:5px 12px;border-radius:8px;font-size:.73rem;font-weight:700;
  background:rgba(237,27,59,.08);color:var(--crimson);
  border:1px solid rgba(237,27,59,.15);
}

/* ── Table ── */
.pm-table-wrap{overflow-x:auto}
.pm-table{width:100%;min-width:860px;border-collapse:collapse}
.pm-table th{
  padding:13px 20px;background:#f8fafc;
  border-top:1px solid #edf1f5;border-bottom:1px solid #e7ecf2;
  color:#64748b;font-size:.67rem;font-weight:800;letter-spacing:.09em;
  text-transform:uppercase;text-align:left;white-space:nowrap;
}
.pm-table td{
  padding:15px 20px;border-bottom:1px solid #eef2f6;
  color:#334155;font-size:.82rem;vertical-align:middle;white-space:nowrap;
}
.pm-table tbody tr{transition:background .18s}
.pm-table tbody tr:hover{background:#fff8f9}
.pm-table tbody tr:last-child td{border-bottom:0}

/* Row highlight untuk pending & ditolak */
.pm-table tbody tr.row-pending{background:#fffdf0}
.pm-table tbody tr.row-pending:hover{background:#fffbeb}
.pm-table tbody tr.row-ditolak{background:#fff8f8}
.pm-table tbody tr.row-ditolak:hover{background:#fff1f2}

/* ── Table cell types ── */
.pm-book-cell{display:flex;align-items:center;gap:11px;min-width:200px;white-space:normal}
.pm-book-img{
  width:38px;height:54px;border-radius:6px;object-fit:cover;flex-shrink:0;
  box-shadow:0 3px 10px rgba(15,23,42,.16);
}
.pm-book-ph{
  width:38px;height:54px;border-radius:6px;flex-shrink:0;display:grid;place-items:center;
  background:linear-gradient(145deg,#0f1f3d,#2055a5);color:rgba(255,255,255,.75);
  box-shadow:0 3px 10px rgba(15,23,42,.16);
}
.pm-book-title{font-weight:700;color:var(--navy-800);line-height:1.35;max-width:230px;overflow-wrap:break-word}

.pm-date{color:#64748b}
.pm-date.late{color:#dc2626;font-weight:700}
.pm-date i{color:#94a3b8;margin-right:4px}
.pm-date.late i{color:#dc2626}
.pm-date-dash{color:#cbd5e1}

.pm-fine{font-weight:700;color:#dc2626}
.pm-fine.none{color:#94a3b8;font-weight:500}

/* ── Status badges ── */
.pm-status{
  display:inline-flex;align-items:center;gap:5px;
  padding:5px 11px;border-radius:7px;font-size:.7rem;font-weight:700;white-space:nowrap;
}
.pm-status.pending{background:#fffbeb;color:#92400e;border:1px solid #fde68a}
.pm-status.dipinjam{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.pm-status.terlambat{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
.pm-status.dikembalikan{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.pm-status.ditolak{background:#fff1f2;color:#be123c;border:1px solid #fecdd3}

/* Pulse dot untuk pending */
.pm-pulse{
  width:7px;height:7px;border-radius:50%;background:#f59e0b;
  animation:pmPulseDot 1.6s ease-in-out infinite;
}
@keyframes pmPulseDot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.7)}}

/* ── Alasan tolak tooltip ── */
.pm-rejection-note{
  display:inline-flex;align-items:center;gap:5px;
  font-size:.68rem;color:#9f1239;background:#fff1f2;
  border:1px solid #fecdd3;border-radius:6px;padding:3px 8px;
  margin-top:4px;max-width:220px;overflow:hidden;
  white-space:normal;word-break:break-word;
  cursor:default;
}
.pm-rejection-note i{flex-shrink:0}

/* ── Rating ── */
.pm-rating-stars{color:#f59e0b;font-size:.88rem;letter-spacing:-1px}
.pm-rating-btn{
  display:inline-flex;align-items:center;gap:4px;
  font-size:.71rem;font-weight:700;color:#f59e0b;
  border:1.5px solid rgba(245,158,11,.3);padding:4px 10px;border-radius:7px;
  background:rgba(245,158,11,.06);transition:all .2s;text-decoration:none;
}
.pm-rating-btn:hover{background:#f59e0b;color:#fff;border-color:#f59e0b}

/* ── Empty ── */
.pm-empty{text-align:center;padding:72px 20px}
.pm-empty-icon{font-size:4rem;color:#cbd5e1;display:block;margin-bottom:16px}
.pm-empty h5{font-size:1.1rem;font-weight:800;color:var(--navy-800);margin-bottom:8px}
.pm-empty p{color:var(--tx-3);margin-bottom:22px;font-size:.88rem}

/* ── Pagination ── */
.pm-pager{
  display:flex;justify-content:center;padding:18px 24px;
  border-top:1px solid var(--border-2);background:#f8fafc;
}
.pm-pager .pagination{gap:6px}
.pm-pager .page-link{min-width:36px!important;width:36px;height:36px;padding:0!important;font-size:.76rem!important;border-radius:8px!important}

/* ── Review section ── */
.pm-rw-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:16px 22px;background:#fff;border-bottom:1px solid var(--border-2);
}
.pm-rw-title{display:flex;align-items:center;gap:9px;font-size:.97rem;font-weight:800;color:var(--navy-800);margin:0}
.pm-rw-title i{color:#f59e0b}
.pm-rw-grid{
  display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));
  gap:16px;padding:18px 22px;background:#fafbfc;
}
.pm-rw-card{
  background:#fff;border-radius:13px;border:1px solid rgba(0,0,0,.06);
  padding:16px;box-shadow:0 2px 10px rgba(0,0,0,.04);
  display:flex;flex-direction:column;gap:11px;transition:all .22s;
}
.pm-rw-card:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(0,0,0,.08);border-color:rgba(245,158,11,.25)}
.pm-rw-book{display:flex;gap:11px;align-items:center}
.pm-rw-cover{width:40px;height:58px;border-radius:6px;object-fit:cover;flex-shrink:0;box-shadow:0 3px 10px rgba(0,0,0,.14)}
.pm-rw-cover-ph{width:40px;height:58px;border-radius:6px;flex-shrink:0;background:linear-gradient(135deg,#0c4a6e,#0284c7);display:grid;place-items:center;color:rgba(255,255,255,.75)}
.pm-rw-book-title{font-size:.83rem;font-weight:800;color:var(--navy-800);line-height:1.3;margin-bottom:2px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.pm-rw-book-author{font-size:.7rem;color:var(--tx-4)}
.pm-rw-stars{display:flex;align-items:center;gap:6px}
.pm-rw-stars-val{color:#f59e0b;font-size:.95rem;letter-spacing:-1px}
.pm-rw-stars-num{font-size:.76rem;font-weight:800;color:#f59e0b;background:rgba(245,158,11,.1);padding:2px 8px;border-radius:6px}
.pm-rw-comment{font-size:.8rem;color:#374151;line-height:1.6;background:#f8fafc;border-radius:8px;padding:10px 12px;border-left:3px solid rgba(245,158,11,.4);font-style:italic;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.pm-rw-no-comment{font-size:.76rem;color:#d1d5db;font-style:italic}
.pm-rw-date{font-size:.67rem;color:#9ca3af}

/* ── Responsive ── */
@media(max-width:768px){
  .pm-toolbar{padding:16px 18px}
  .pm-toolbar-right{width:100%}
  .pm-btn-new{width:100%;justify-content:center}
  .pm-filter-form{width:100%}
  .pm-select{flex:1;min-width:0}
  .pm-pager{justify-content:flex-start;overflow-x:auto;padding:14px 18px}
  .pm-card-head{padding:14px 18px}
}
@media(max-width:768px){
  .pm-table-wrap{overflow:visible}
  .pm-table{min-width:0;display:block}
  .pm-table thead{display:none}
  .pm-table tbody{display:grid;gap:12px;padding:14px}
  .pm-table tbody tr{
    display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0 12px;
    padding:10px 12px;border:1px solid #e7ecf2;border-left:3px solid #3b82f6;
    border-radius:12px;background:#fff;box-shadow:0 2px 10px rgba(15,23,42,.05);
  }
  .pm-table tbody tr.row-pending{border-left-color:#f59e0b!important}
  .pm-table tbody tr.row-ditolak{border-left-color:#e11d48!important}
  .pm-table tbody tr:has(.pm-status.terlambat){border-left-color:#d97706}
  .pm-table tbody tr:has(.pm-status.dikembalikan){border-left-color:#16a34a}
  .pm-table td{
    display:flex;flex-direction:column;align-items:flex-start;gap:4px;
    padding:8px 2px;border:0;white-space:normal;font-size:.75rem;min-width:0;
  }
  .pm-table td::before{content:attr(data-label);color:#8792a3;font-size:.6rem;font-weight:800;text-transform:uppercase}
  .pm-table td:first-child{grid-column:1/-1}
  .pm-table td:last-child{align-items:flex-start}
  .pm-book-cell{width:100%}
  .pm-book-title{max-width:100%;overflow-wrap:anywhere}
}
</style>

<div class="pm-wrap">

  {{-- Pending banner (tampil jika ada pengajuan menunggu) --}}
  @php
    $jumlahPending = $peminjaman->getCollection()->where('status','pending')->count();
    // Hitung total pending dari semua halaman untuk banner
    $totalPendingAll = \App\Models\Peminjaman::where('anggota_id', Auth::user()->anggota?->id)
        ->where('status', 'pending')->count();
  @endphp
  @if($totalPendingAll > 0)
  <div class="pm-pending-banner">
    <div class="pm-pending-banner-icon">
      <i class="bi bi-hourglass-split"></i>
    </div>
    <div class="pm-pending-banner-body">
      <div class="pm-pending-banner-title">Pengajuan Menunggu Persetujuan</div>
      <div class="pm-pending-banner-sub">Admin akan memproses pengajuanmu secepatnya. Hitungan hari peminjaman dimulai setelah disetujui.</div>
    </div>
    <span class="pm-pending-count">{{ $totalPendingAll }} Menunggu</span>
  </div>
  @endif

  {{-- Toolbar --}}
  <div class="pm-toolbar">
    <div class="pm-toolbar-left">
      <div class="pm-toolbar-title"><i class="bi bi-clock-history"></i> Riwayat Peminjaman</div>
      <div class="pm-toolbar-sub">Semua catatan peminjaman buku kamu</div>
    </div>
    <div class="pm-toolbar-right">
      <form method="GET" class="pm-filter-form">
        <select name="status" class="pm-select" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="pending"       {{ request('status')==='pending'       ? 'selected' : '' }}>⏳ Menunggu Persetujuan</option>
          <option value="dipinjam"      {{ request('status')==='dipinjam'      ? 'selected' : '' }}>📖 Dipinjam</option>
          <option value="terlambat"     {{ request('status')==='terlambat'     ? 'selected' : '' }}>⚠️ Terlambat</option>
          <option value="dikembalikan"  {{ request('status')==='dikembalikan'  ? 'selected' : '' }}>✅ Dikembalikan</option>
          <option value="ditolak"       {{ request('status')==='ditolak'       ? 'selected' : '' }}>❌ Ditolak</option>
        </select>
        <button type="submit" class="pm-btn-filter" title="Filter">
          <i class="bi bi-funnel-fill"></i>
        </button>
      </form>
      <a href="{{ route('siswa.peminjaman.create') }}" class="pm-btn-new">
        <i class="bi bi-plus-circle-fill"></i> Pinjam Buku Baru
      </a>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="pm-card">
    <div class="pm-card-head">
      <h3 class="pm-card-title"><i class="bi bi-journal-text"></i> Daftar Transaksi</h3>
      <span class="pm-count"><i class="bi bi-list-ul"></i> {{ $peminjaman->total() }} Transaksi</span>
    </div>

    @forelse($peminjaman as $p)
      @if($loop->first)
      <div class="pm-table-wrap">
        <table class="pm-table">
          <thead>
            <tr>
              <th>Buku</th>
              <th>Status</th>
              <th>Tgl Pengajuan</th>
              <th>Tgl Pinjam</th>
              <th>Batas Kembali</th>
              <th>Dikembalikan</th>
              <th>Denda</th>
              <th>Ulasan</th>
            </tr>
          </thead>
          <tbody>
      @endif

      @php
        $rowClass = $p->status === 'pending' ? 'row-pending' : ($p->status === 'ditolak' ? 'row-ditolak' : '');
      @endphp
            <tr class="{{ $rowClass }}">
              <td data-label="Buku">
                <div class="pm-book-cell">
                  @if($p->buku && $p->buku->cover)
                    <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" class="pm-book-img">
                  @else
                    <div class="pm-book-ph"><i class="bi bi-book-fill"></i></div>
                  @endif
                  <span class="pm-book-title">{{ $p->buku->judul ?? '-' }}</span>
                </div>
              </td>

              <td data-label="Status">
                @if($p->status === 'pending')
                  <span class="pm-status pending"><span class="pm-pulse"></span> Menunggu</span>
                @elseif($p->status === 'dipinjam')
                  <span class="pm-status dipinjam"><i class="bi bi-circle-fill" style="font-size:.45rem"></i> Dipinjam</span>
                @elseif($p->status === 'terlambat')
                  <span class="pm-status terlambat"><i class="bi bi-exclamation-circle-fill"></i> Terlambat</span>
                @elseif($p->status === 'dikembalikan')
                  <span class="pm-status dikembalikan"><i class="bi bi-check-circle-fill"></i> Dikembalikan</span>
                @elseif($p->status === 'ditolak')
                  <span class="pm-status ditolak"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                  @if($p->rejection_reason)
                    <div class="pm-rejection-note"><i class="bi bi-chat-left-text-fill"></i> {{ $p->rejection_reason }}</div>
                  @endif
                @endif
              </td>

              <td data-label="Tgl Pengajuan" class="pm-date">
                @if($p->tanggal_pengajuan)
                  <i class="bi bi-send"></i>{{ $p->tanggal_pengajuan->format('d M Y') }}
                @else
                  <span class="pm-date-dash">—</span>
                @endif
              </td>

              <td data-label="Tgl Pinjam" class="pm-date">
                @if($p->tanggal_pinjam)
                  <i class="bi bi-calendar3"></i>{{ $p->tanggal_pinjam->format('d M Y') }}
                @elseif($p->status === 'pending')
                  <span style="font-size:.7rem;color:#b45309;font-style:italic">Setelah disetujui</span>
                @else
                  <span class="pm-date-dash">—</span>
                @endif
              </td>

              <td data-label="Batas Kembali" class="pm-date {{ $p->status === 'terlambat' ? 'late' : '' }}">
                @if($p->tanggal_kembali_rencana)
                  <i class="bi bi-calendar-x"></i>{{ $p->tanggal_kembali_rencana->format('d M Y') }}
                @elseif($p->status === 'pending')
                  <span style="font-size:.7rem;color:#b45309;font-style:italic">7 hari setelah approve</span>
                @else
                  <span class="pm-date-dash">—</span>
                @endif
              </td>

              <td data-label="Dikembalikan" class="pm-date">
                {{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d M Y') : '—' }}
              </td>

              <td data-label="Denda" class="pm-fine {{ $p->denda > 0 ? '' : 'none' }}">
                @if($p->status === 'pending' || $p->status === 'ditolak')
                  <span style="color:#cbd5e1;font-size:.72rem">—</span>
                @else
                  {{ $p->denda > 0 ? 'Rp '.number_format($p->denda,0,',','.') : 'Tidak ada' }}
                @endif
              </td>

              <td data-label="Ulasan">
                @if($p->status === 'dikembalikan')
                  @if($p->ulasan)
                    <span class="pm-rating-stars">
                      @for($s=1;$s<=5;$s++){{ $s<=$p->ulasan->rating ? '★' : '☆' }}@endfor
                    </span>
                  @else
                    <a href="{{ route('siswa.ulasan.create', $p) }}" class="pm-rating-btn">
                      <i class="bi bi-star-fill" style="font-size:.62rem"></i> Beri Rating
                    </a>
                  @endif
                @else
                  <span style="color:#cbd5e1;font-size:.72rem">—</span>
                @endif
              </td>
            </tr>

      @if($loop->last)
          </tbody>
        </table>
      </div>
      @endif

    @empty
      <div class="pm-empty">
        <i class="bi bi-inbox pm-empty-icon"></i>
        <h5>Belum Ada Riwayat Peminjaman</h5>
        <p>Mulai pinjam buku dari koleksi perpustakaan kami</p>
        <a href="{{ route('siswa.peminjaman.create') }}" class="pm-btn-new" style="display:inline-flex">
          <i class="bi bi-book-fill"></i> Mulai Pinjam Buku
        </a>
      </div>
    @endforelse

    @if($peminjaman->hasPages())
      <div class="pm-pager">
        {{ $peminjaman->links('vendor.pagination.custom-simple') }}
      </div>
    @endif
  </div>

  {{-- Riwayat Ulasan --}}
  @if($riwayatUlasan->isNotEmpty())
  <div class="pm-card">
    <div class="pm-rw-head">
      <h3 class="pm-rw-title"><i class="bi bi-star-fill"></i> Riwayat Ulasan Saya</h3>
      <span class="pm-count">{{ $riwayatUlasan->count() }} Ulasan</span>
    </div>
    <div class="pm-rw-grid">
      @foreach($riwayatUlasan as $u)
      <div class="pm-rw-card">
        <div class="pm-rw-book">
          @if($u->buku->cover)
            <img src="{{ Storage::url($u->buku->cover) }}" alt="{{ $u->buku->judul }}" class="pm-rw-cover">
          @else
            <div class="pm-rw-cover-ph"><i class="bi bi-book-fill" style="font-size:.8rem"></i></div>
          @endif
          <div style="min-width:0">
            <div class="pm-rw-book-title">{{ $u->buku->judul }}</div>
            <div class="pm-rw-book-author">{{ $u->buku->pengarang }}</div>
          </div>
        </div>
        <div class="pm-rw-stars">
          <span class="pm-rw-stars-val">
            @for($s=1;$s<=5;$s++){{ $s<=$u->rating ? '★' : '☆' }}@endfor
          </span>
          <span class="pm-rw-stars-num">{{ $u->rating }}/5</span>
        </div>
        @if($u->komentar)
          <div class="pm-rw-comment">{{ $u->komentar }}</div>
        @else
          <div class="pm-rw-no-comment">Tidak ada komentar</div>
        @endif
        <div class="pm-rw-date"><i class="bi bi-calendar3" style="margin-right:3px"></i>{{ $u->created_at->isoFormat('D MMM YYYY') }}</div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

</div>

@include('siswa.partials.rekomendasi-buku')

@push('styles')
<style>
/* ── pm-btn-new: glow + plus spin ── */
.pm-btn-new{
  position:relative;overflow:hidden;
  animation:pmBtnGlow 2.5s ease-in-out infinite;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s ease !important;
}
@keyframes pmBtnGlow{
  0%,100%{box-shadow:0 4px 14px rgba(237,27,59,.3)}
  50%{box-shadow:0 8px 26px rgba(237,27,59,.55),0 0 0 5px rgba(237,27,59,.1)}
}
.pm-btn-new:hover{
  animation:none;
  background:var(--crimson-dark,#C41630) !important;
  transform:translateY(-3px) scale(1.04) !important;
  box-shadow:0 12px 32px rgba(237,27,59,.45) !important;
  color:#fff !important;
}
.pm-btn-new i{display:inline-block;transition:transform .35s cubic-bezier(.34,1.56,.64,1);}
.pm-btn-new:hover i{transform:rotate(135deg) scale(1.25);}
.pm-btn-new::before{
  content:'';position:absolute;top:0;left:-110%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-20deg);pointer-events:none;
}
.pm-btn-new:hover::before{animation:pmShimmer .5s ease forwards;}
@keyframes pmShimmer{0%{left:-110%}100%{left:120%}}
/* ── pm-btn-filter: funnel bounce ── */
.pm-btn-filter{
  transition:all .22s cubic-bezier(.34,1.56,.64,1) !important;
  position:relative;overflow:hidden;
}
.pm-btn-filter:hover{
  transform:translateY(-2px) scale(1.1) !important;
  box-shadow:0 5px 14px rgba(237,27,59,.3) !important;
}
.pm-btn-filter i{display:inline-block;}
.pm-btn-filter:hover i{animation:pmFunnel .4s ease;}
@keyframes pmFunnel{
  0%{transform:scale(1) rotate(0)}
  30%{transform:scale(1.35) rotate(-20deg)}
  60%{transform:scale(.9) rotate(12deg)}
  100%{transform:scale(1) rotate(0)}
}
/* Ripple */
.pm-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:pmRipple .4s linear;pointer-events:none;}
@keyframes pmRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.pm-btn-new,.pm-btn-filter').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='pm-ripple';
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

@endsection

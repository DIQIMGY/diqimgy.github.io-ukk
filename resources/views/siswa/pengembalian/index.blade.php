@extends('layouts.app')
@section('title','Pengembalian Buku')
@section('page-title','Pengembalian Buku')
@section('content')
<style>
/* ══ PENGEMBALIAN PAGE — PREMIUM v3 ══ */
.rt-wrap{display:flex;flex-direction:column;gap:20px;max-width:1280px;margin:0 auto}

/* ── Info Banner ── */
.rt-banner{
  display:flex;align-items:center;gap:14px;
  padding:14px 20px;
  background:linear-gradient(135deg,#eff6ff,#f0f9ff);
  border:1px solid #bfdbfe;border-radius:12px;
  color:#1e40af;font-size:.83rem;font-weight:600;
  box-shadow:0 3px 12px rgba(37,99,235,.07);
}
.rt-banner i{font-size:1.3rem;color:#2563eb;flex-shrink:0}

/* ── Toolbar ── */
.rt-toolbar{
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:14px;
  padding:20px 24px;
  background:#fff;border:1px solid var(--border);border-radius:16px;
  box-shadow:var(--sh-xs);position:relative;overflow:hidden;
}
.rt-toolbar::before{
  content:'';position:absolute;left:0;top:0;bottom:0;width:4px;
  background:linear-gradient(180deg,#10b981,#0284c7);
}
.rt-toolbar-left{display:flex;flex-direction:column;gap:2px}
.rt-toolbar-title{font-size:1rem;font-weight:900;color:var(--navy-800);display:flex;align-items:center;gap:8px}
.rt-toolbar-title i{color:#10b981}
.rt-toolbar-sub{font-size:.74rem;color:var(--tx-3)}

/* ── Card ── */
.rt-card{
  background:#fff;border:1px solid var(--border);border-radius:16px;
  box-shadow:var(--sh-xs);overflow:hidden;
}
.rt-card-head{
  display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;
  padding:16px 22px;border-bottom:1px solid var(--border-2);
  background:linear-gradient(180deg,#fff,#fafbfc);
}
.rt-card-title{
  display:flex;align-items:center;gap:9px;
  font-size:.97rem;font-weight:800;color:var(--navy-800);margin:0;
}
.rt-card-title i{color:#10b981}
.rt-count{
  display:inline-flex;align-items:center;gap:5px;
  padding:5px 12px;border-radius:8px;font-size:.73rem;font-weight:700;
  background:rgba(16,185,129,.08);color:#059669;
  border:1px solid rgba(16,185,129,.2);
}

/* ── Table ── */
.rt-table-wrap{overflow-x:auto}
.rt-table{width:100%;min-width:820px;border-collapse:collapse}
.rt-table th{
  padding:13px 22px;background:#f8fafc;
  border-bottom:1px solid #e7ecf2;
  color:#64748b;font-size:.67rem;font-weight:800;letter-spacing:.09em;
  text-transform:uppercase;text-align:left;white-space:nowrap;
}
.rt-table td{
  padding:15px 22px;border-bottom:1px solid #eef2f6;
  color:#334155;font-size:.82rem;vertical-align:middle;white-space:nowrap;
}
.rt-table tbody tr{transition:background .18s}
.rt-table tbody tr:hover{background:#f0fff8}
.rt-table tbody tr:last-child td{border-bottom:0}

/* ── Cell types ── */
.rt-book-cell{display:flex;align-items:center;gap:11px;min-width:220px;white-space:normal}
.rt-book-img{
  width:40px;height:56px;border-radius:6px;object-fit:cover;flex-shrink:0;
  box-shadow:0 3px 10px rgba(15,23,42,.16);
}
.rt-book-ph{
  width:40px;height:56px;border-radius:6px;flex-shrink:0;display:grid;place-items:center;
  background:linear-gradient(145deg,#881337,#e11d48);color:rgba(255,255,255,.8);
  box-shadow:0 3px 10px rgba(15,23,42,.16);
}
.rt-book-name{font-weight:700;color:var(--navy-800);line-height:1.35;max-width:230px;overflow-wrap:break-word}
.rt-book-author{display:block;margin-top:3px;color:var(--tx-4);font-size:.7rem;font-weight:500;max-width:220px;overflow:hidden;text-overflow:ellipsis}

/* ── Status badge ── */
.rt-status{
  display:inline-flex;align-items:center;gap:5px;
  padding:5px 11px;border-radius:7px;font-size:.7rem;font-weight:700;white-space:nowrap;
}
.rt-status.active{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.rt-status.late{background:#fff1f2;color:#dc2626;border:1px solid #fecdd3}
.rt-status.pending-kembali{background:#ecfeff;color:#0e7490;border:1px solid #a5f3fc}

.rt-date{color:#64748b}
.rt-date.late{color:#dc2626;font-weight:700}

.rt-fine{font-weight:800;color:#dc2626}
.rt-fine.none{color:#94a3b8;font-weight:500}

/* ── Baris pending_kembali ── */
.rt-table tbody tr.row-pending-kembali{background:#ecfeff}
.rt-table tbody tr.row-pending-kembali:hover{background:#cffafe}

.rt-action{
  font-size:.75rem;font-weight:700;white-space:nowrap;
  text-decoration:none;transition:all .22s;
}
.rt-action.success{background:linear-gradient(135deg,#16a34a,#15803d);box-shadow:0 4px 12px rgba(22,163,74,.25)}
.rt-action.danger{background:linear-gradient(135deg,#dc2626,#b91c1c);box-shadow:0 4px 12px rgba(220,38,38,.25)}
.rt-action:hover{color:#fff;transform:translateY(-2px) scale(1.03);box-shadow:0 6px 18px rgba(0,0,0,.2)}

/* ── Pagination ── */
.rt-pager{
  display:flex;justify-content:center;padding:18px 24px;
  border-top:1px solid var(--border-2);background:#f8fafc;
}
.rt-pager .pagination{gap:6px}
.rt-pager .page-link{min-width:36px!important;width:36px;height:36px;padding:0!important;font-size:.76rem!important;border-radius:8px!important}

/* ── Empty ── */
.rt-empty{text-align:center;padding:80px 20px}
.rt-empty-icon{font-size:5rem;color:#16a34a;display:block;margin-bottom:18px;filter:drop-shadow(0 6px 14px rgba(22,163,74,.22))}
.rt-empty h5{font-size:1.3rem;font-weight:800;color:#15803d;margin-bottom:10px}
.rt-empty p{color:var(--tx-3);margin-bottom:26px;font-size:.92rem}
.rt-btn-pinjam{
  display:inline-flex;align-items:center;gap:8px;
  padding:11px 22px;border-radius:11px;font-size:.85rem;font-weight:700;
  background:var(--crimson);color:#fff;text-decoration:none;
  transition:all .2s;box-shadow:0 4px 14px rgba(237,27,59,.28);
}
.rt-btn-pinjam:hover{background:var(--crimson-dark);color:#fff;transform:translateY(-2px)}

/* ── Responsive ── */
@media(max-width:768px){
  .rt-toolbar{padding:16px 18px}
  .rt-pager{justify-content:flex-start;overflow-x:auto;padding:14px 18px}
  .rt-card-head{padding:14px 18px}
  .rt-table th{padding:11px 16px}
  .rt-table td{padding:13px 16px}
}
@media(max-width:768px){
  .rt-table-wrap{overflow:visible}
  .rt-table{min-width:0;display:block}
  .rt-table thead{display:none}
  .rt-table tbody{display:grid;gap:12px;padding:14px}
  .rt-table tbody tr{
    display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:0 12px;
    padding:10px 12px;border:1px solid #e7ecf2;border-left:3px solid #3b82f6;
    border-radius:12px;background:#fff;box-shadow:0 2px 10px rgba(15,23,42,.05);
  }
  .rt-table tbody tr:has(.rt-status.late){border-left-color:#dc2626}
  .rt-table td{
    display:flex;flex-direction:column;align-items:flex-start;gap:4px;
    padding:8px 2px;border:0;white-space:normal;font-size:.75rem;min-width:0;
  }
  .rt-table td::before{content:attr(data-label);color:#8792a3;font-size:.6rem;font-weight:800;text-transform:uppercase}
  .rt-table td:first-child{grid-column:1/-1}
  .rt-table td:last-child{grid-column:1/-1;align-items:stretch}
  .rt-book-cell{width:100%}
  .rt-book-name{max-width:100%;overflow-wrap:anywhere}
  .rt-action{justify-content:center;padding:10px 14px}
}
</style>

<div class="rt-wrap">

  @if($peminjaman->isEmpty())
  <div class="rt-empty">
    <i class="bi bi-check-circle-fill rt-empty-icon"></i>
    <h5>Semua Buku Sudah Dikembalikan!</h5>
    <p>Tidak ada buku yang perlu dikembalikan saat ini</p>
    <a href="{{ route('siswa.peminjaman.create') }}" class="rt-btn-pinjam">
      <i class="bi bi-book-fill"></i> Pinjam Buku Sekarang
    </a>
  </div>
  @else

  {{-- Banner info --}}
  <div class="rt-banner">
    <i class="bi bi-info-circle-fill"></i>
    <span>Pilih buku yang ingin dikembalikan. Denda keterlambatan dihitung <strong>Rp 1.000 per hari</strong> setelah batas waktu. Setelah diajukan, admin akan mengkonfirmasi pengembalian dan denda tidak bertambah selama menunggu.</span>
  </div>

  {{-- Banner pending kembali (tampil jika ada yang menunggu konfirmasi) --}}
  @php $jumlahPendingKembali = $peminjaman->filter(fn($p) => $p->status === 'pending_kembali')->count(); @endphp
  @if($jumlahPendingKembali > 0)
  <div style="display:flex;align-items:center;gap:14px;padding:14px 20px;background:linear-gradient(135deg,#ecfeff,#cffafe);border:1.5px solid #a5f3fc;border-radius:12px;box-shadow:0 3px 12px rgba(6,182,212,.1)">
    <div style="width:40px;height:40px;border-radius:11px;flex-shrink:0;background:linear-gradient(135deg,#0891b2,#0e7490);display:grid;place-items:center;color:#fff;font-size:1.1rem;box-shadow:0 4px 12px rgba(8,145,178,.3)">
      <i class="bi bi-hourglass-split"></i>
    </div>
    <div style="flex:1;min-width:0">
      <div style="font-size:.88rem;font-weight:800;color:#0e7490;margin-bottom:2px">Pengajuan Pengembalian Menunggu Konfirmasi Admin</div>
      <div style="font-size:.76rem;color:#0891b2">Admin perpustakaan akan segera mengkonfirmasi dan mencatat tanggal pengembalian resmi.</div>
    </div>
    <span style="padding:6px 14px;border-radius:8px;font-size:.8rem;font-weight:900;background:linear-gradient(135deg,#0891b2,#0e7490);color:#fff;white-space:nowrap;box-shadow:0 3px 10px rgba(8,145,178,.3)">
      {{ $jumlahPendingKembali }} Menunggu
    </span>
  </div>
  @endif

  {{-- Toolbar --}}
  <div class="rt-toolbar">
    <div class="rt-toolbar-left">
      <div class="rt-toolbar-title"><i class="bi bi-box-arrow-in-left"></i> Buku Perlu Dikembalikan</div>
      <div class="rt-toolbar-sub">Kembalikan buku sebelum batas waktu untuk menghindari denda</div>
    </div>
    <div style="display:flex;align-items:center;gap:10px">
      @php $lateCnt = $peminjaman->filter(fn($p) => $p->status === 'terlambat')->count() @endphp
      @if($lateCnt > 0)
        <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;background:#fff1f2;color:#dc2626;border:1px solid #fecdd3;font-size:.78rem;font-weight:800">
          <i class="bi bi-exclamation-circle-fill"></i> {{ $lateCnt }} Terlambat
        </span>
      @endif
      <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:9px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-size:.78rem;font-weight:700">
        <i class="bi bi-stack"></i> {{ $peminjaman->count() }} Buku
      </span>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="rt-card">
    <div class="rt-card-head">
      <h3 class="rt-card-title"><i class="bi bi-arrow-return-left"></i> Daftar Peminjaman Aktif</h3>
      <span class="rt-count"><i class="bi bi-book"></i> {{ $peminjaman->count() }} Buku</span>
    </div>

    <div class="rt-table-wrap">
      <table class="rt-table">
        <thead>
          <tr>
            <th>Buku</th>
            <th>Status</th>
            <th>Tanggal Pinjam</th>
            <th>Batas Kembali</th>
            <th>Estimasi Denda</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($peminjaman as $p)
          @php
            $isPendingKembali = ($p->status === 'pending_kembali');
            $late  = ($p->status === 'terlambat');
            // Hitung estimasi denda berdasarkan hari ini (belum final)
            $tanggalPerhitungan = $isPendingKembali && $p->return_requested_at
              ? $p->return_requested_at->copy()->startOfDay()
              : \Carbon\Carbon::today();
            $hari  = ($late || $isPendingKembali) && $p->tanggal_kembali_rencana && $tanggalPerhitungan->gt($p->tanggal_kembali_rencana)
              ? $p->tanggal_kembali_rencana->diffInDays($tanggalPerhitungan)
              : 0;
            $denda = $hari * 1000;
            $rowClass = $isPendingKembali ? 'row-pending-kembali' : '';
          @endphp
          <tr class="{{ $rowClass }}">
            <td data-label="Buku">
              <div class="rt-book-cell">
                @if($p->buku && $p->buku->cover)
                  <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" class="rt-book-img">
                @else
                  <div class="rt-book-ph"><i class="bi bi-book-fill"></i></div>
                @endif
                <div>
                  <div class="rt-book-name">{{ $p->buku->judul ?? '-' }}</div>
                  <span class="rt-book-author"><i class="bi bi-person"></i> {{ $p->buku->pengarang ?? '-' }}</span>
                </div>
              </div>
            </td>
            <td data-label="Status">
              @if($isPendingKembali)
                <span class="rt-status pending-kembali">
                  <i class="bi bi-hourglass-split"></i> Menunggu Konfirmasi
                </span>
                @if($p->return_requested_at)
                  <div style="font-size:.67rem;color:#0891b2;margin-top:3px">
                    <i class="bi bi-send"></i> {{ $p->return_requested_at->isoFormat('D MMM, HH:mm') }}
                  </div>
                @endif
              @elseif($late)
                <span class="rt-status late">
                  <i class="bi bi-exclamation-circle-fill"></i> Terlambat
                </span>
              @else
                <span class="rt-status active">
                  <i class="bi bi-circle-fill" style="font-size:.45em"></i> Dipinjam
                </span>
              @endif
            </td>
            <td data-label="Tgl Pinjam" class="rt-date">
              <i class="bi bi-calendar3" style="margin-right:4px;color:#94a3b8"></i>{{ $p->tanggal_pinjam ? $p->tanggal_pinjam->format('d M Y') : '—' }}
            </td>
            <td data-label="Batas Kembali" class="rt-date {{ $late ? 'late' : '' }}">
              <i class="bi bi-calendar-x" style="margin-right:4px"></i>{{ $p->tanggal_kembali_rencana ? $p->tanggal_kembali_rencana->format('d M Y') : '—' }}
              @if($late || $isPendingKembali)
                <span style="display:block;font-size:.68rem;color:#dc2626;margin-top:2px">
                  {{ $hari }} hari terlambat{{ $isPendingKembali ? ' saat diajukan' : '' }}
                </span>
              @endif
            </td>
            <td data-label="Estimasi Denda" class="rt-fine {{ ($late || ($isPendingKembali && $denda > 0)) ? '' : 'none' }}">
              {{ ($late || $isPendingKembali) && $denda > 0 ? 'Rp '.number_format($denda,0,',','.') : 'Tidak ada' }}
            </td>
            <td data-label="Aksi">
              @if($isPendingKembali)
                {{-- Sudah diajukan — tidak bisa diajukan lagi --}}
                <span style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:9px;background:#ecfeff;color:#0e7490;border:1px solid #a5f3fc;font-size:.75rem;font-weight:700">
                  <i class="bi bi-hourglass-split"></i> Menunggu Admin
                </span>
              @else
                <a href="{{ route('siswa.pengembalian.konfirmasi', $p) }}" class="rt-action {{ $late ? 'danger' : 'success' }}">
                  <i class="bi bi-box-arrow-in-left"></i> Kembalikan
                </a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($peminjaman->hasPages())
    <div class="rt-pager">
      {{ $peminjaman->links('vendor.pagination.custom-simple') }}
    </div>
    @endif
  </div>

  @endif
</div>

@include('siswa.partials.rekomendasi-buku')

@push('styles')
<style>
/* ── rt-action: arrow spins + lift ── */
.rt-action{
  position:relative;overflow:hidden;
  transition:all .25s cubic-bezier(.34,1.56,.64,1) !important;
}
.rt-action:hover{
  transform:translateY(-3px) scale(1.05) !important;
}
.rt-action i{display:inline-block;transition:transform .35s cubic-bezier(.34,1.56,.64,1);}
.rt-action:hover i{animation:rtArrowSpin .5s ease;}
@keyframes rtArrowSpin{
  0%{transform:rotate(0deg) scale(1)}
  40%{transform:rotate(-160deg) scale(1.25)}
  70%{transform:rotate(-330deg) scale(1.1)}
  100%{transform:rotate(-360deg) scale(1)}
}
.rt-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:rtRipple .4s linear;pointer-events:none;}
@keyframes rtRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.rt-action').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='rt-ripple';
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

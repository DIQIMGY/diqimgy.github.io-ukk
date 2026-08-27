@extends('layouts.app')
@section('title','Pengembalian Buku')
@section('page-title','Pengembalian Buku')
@section('content')

@if($peminjaman->isEmpty())
<div class="empty" style="padding:72px 20px">
  <span class="empty-ico" style="font-size:4rem;opacity:1;color:var(--green-500)">
    <i class="bi bi-check-circle-fill"></i>
  </span>
  <h6 style="color:var(--green-500);font-size:1rem;margin-bottom:6px">Semua buku sudah dikembalikan!</h6>
  <p style="margin-bottom:20px">Tidak ada buku yang perlu dikembalikan saat ini.</p>
  <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-primary">
    <i class="bi bi-book-fill"></i> Pinjam Buku Sekarang
  </a>
</div>
@else

<div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:22px;display:flex;align-items:center;gap:10px;font-size:.83rem;color:#1d4ed8;font-weight:500">
  <i class="bi bi-info-circle-fill" style="flex-shrink:0;font-size:.95rem"></i>
  Pilih buku yang ingin dikembalikan. Denda keterlambatan dihitung <strong>Rp 1.000 per hari</strong>.
</div>

<div class="row g-3">
  @foreach($peminjaman as $p)
  @php $late = ($p->status === 'terlambat'); @endphp
  <div class="col-sm-6 col-lg-4">
    <div class="ret-card {{ $late ? 'ret-card-red' : 'ret-card-blue' }}">

      <div class="ret-head">
        <span class="status-badge {{ $late ? 'sb-terlambat' : 'sb-pinjam' }}" style="margin-bottom:10px">
          @if($late) <i class="bi bi-exclamation-triangle-fill" style="font-size:.7rem"></i> Terlambat
          @else <i class="bi bi-circle-fill" style="font-size:.45rem"></i> Dipinjam
          @endif
        </span>
        <h6 style="font-weight:800;font-size:.92rem;line-height:1.35;margin:0 0 4px;color:var(--navy-800)">
          {{ Str::limit($p->buku->judul??'-', 50) }}
        </h6>
        <p style="font-size:.76rem;color:var(--tx-3);margin:0">
          <i class="bi bi-person" style="font-size:.68rem"></i> {{ $p->buku->pengarang??'' }}
        </p>
      </div>

      <div class="ret-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px">
          <div class="date-cell">
            <label>Tgl Pinjam</label>
            <p>{{ $p->tanggal_pinjam->format('d M Y') }}</p>
          </div>
          <div class="date-cell {{ $late ? 'date-cell-red' : '' }}">
            <label>Batas Kembali</label>
            <p>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</p>
          </div>
        </div>

        @if($late)
        @php
          $hari  = $p->tanggal_kembali_rencana->diffInDays(\Carbon\Carbon::today());
          $denda = $hari * 1000;
        @endphp
        <div class="fine fine-red">
          <i class="bi bi-exclamation-triangle-fill" style="color:var(--red-500);font-size:1.05rem;flex-shrink:0"></i>
          <div>
            <p style="font-size:.76rem;font-weight:800;color:#be123c;margin:0 0 2px">Terlambat {{ $hari }} hari</p>
            <p style="font-size:.72rem;color:var(--red-500);margin:0">
              Estimasi denda: <strong>Rp {{ number_format($denda,0,',','.') }}</strong>
            </p>
          </div>
        </div>
        @endif
      </div>

      <div class="ret-foot">
        <a href="{{ route('siswa.pengembalian.konfirmasi',$p) }}"
           class="btn {{ $late ? 'btn-danger' : 'btn-success' }} w-100"
           style="justify-content:center">
          <i class="bi bi-box-arrow-in-left"></i>
          {{ $late ? 'Kembalikan (Ada Denda)' : 'Kembalikan Buku' }}
        </a>
      </div>

    </div>
  </div>
  @endforeach
</div>

@if($peminjaman->hasPages())
<div style="display:flex;justify-content:center;margin-top:24px">{{ $peminjaman->links() }}</div>
@endif
@endif
@endsection

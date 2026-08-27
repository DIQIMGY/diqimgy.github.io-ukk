@extends('layouts.app')
@section('title','Konfirmasi Pengembalian')
@section('page-title','Konfirmasi Pengembalian')
@section('content')

<div class="row justify-content-center">
<div class="col-sm-9 col-md-7 col-lg-5">

  <a href="{{ route('siswa.pengembalian.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:18px">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>

  <div class="cbox">
    {{-- Icon header --}}
    <div style="text-align:center;padding:28px 24px 0">
      <div style="width:64px;height:64px;border-radius:50%;background:{{ $denda>0?'#fff1f2':'#f0fdf4' }};display:flex;align-items:center;justify-content:center;font-size:1.7rem;margin:0 auto 14px;border:2px solid {{ $denda>0?'#fecdd3':'#bbf7d0' }}">
        <i class="bi bi-box-arrow-in-left" style="color:{{ $denda>0?'var(--red-500)':'var(--green-500)' }}"></i>
      </div>
      <h5 style="font-weight:900;color:var(--navy-800);margin:0 0 5px;letter-spacing:-.02em">Konfirmasi Pengembalian</h5>
      <p style="font-size:.81rem;color:var(--tx-3);margin:0">Pastikan Anda membawa buku berikut:</p>
    </div>

    <div class="cbox-body">
      {{-- Buku info --}}
      <div style="background:var(--surface-2);border-radius:12px;padding:16px;margin-bottom:18px;border:1px solid var(--border-2)">
        <p style="font-size:.63rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--tx-4);margin:0 0 8px">
          <i class="bi bi-book me-1"></i>Buku yang Dikembalikan
        </p>
        <h6 style="font-weight:800;color:var(--navy-800);margin:0 0 4px;line-height:1.3">{{ $peminjaman->buku->judul }}</h6>
        <p style="font-size:.78rem;color:var(--tx-3);margin:0">{{ $peminjaman->buku->pengarang }}</p>
      </div>

      {{-- Date grid --}}
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px">
        <div class="date-cell">
          <label>Tanggal Pinjam</label>
          <p>{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
        </div>
        <div class="date-cell {{ $denda>0?'date-cell-red':'' }}">
          <label>Batas Kembali</label>
          <p>{{ $peminjaman->tanggal_kembali_rencana->format('d M Y') }}</p>
        </div>
      </div>

      {{-- Denda / OK --}}
      @if($denda > 0)
      <div class="fine fine-red" style="margin-bottom:22px">
        <i class="bi bi-exclamation-triangle-fill" style="color:var(--red-500);font-size:1.3rem;flex-shrink:0"></i>
        <div>
          <p style="font-weight:800;font-size:.92rem;color:#be123c;margin:0 0 3px">Terdapat Denda Keterlambatan</p>
          <p style="font-size:1.2rem;font-weight:900;color:var(--red-500);margin:0 0 3px;letter-spacing:-.02em">
            Rp {{ number_format($denda,0,',','.') }}
          </p>
          <p style="font-size:.72rem;color:#be123c;margin:0">
            Rp 1.000 × {{ $peminjaman->tanggal_kembali_rencana->diffInDays(\Carbon\Carbon::today()) }} hari keterlambatan
          </p>
        </div>
      </div>
      @else
      <div class="fine fine-green" style="margin-bottom:22px">
        <i class="bi bi-check-circle-fill" style="color:var(--green-500);font-size:1.3rem;flex-shrink:0"></i>
        <div>
          <p style="font-weight:800;font-size:.9rem;color:#15803d;margin:0 0 2px">Pengembalian Tepat Waktu ✓</p>
          <p style="font-size:.8rem;color:var(--green-500);margin:0">Tidak ada denda. Terima kasih!</p>
        </div>
      </div>
      @endif

      {{-- Buttons --}}
      <div style="display:flex;gap:10px">
        <a href="{{ route('siswa.pengembalian.index') }}" class="btn btn-ghost" style="flex:1;justify-content:center">
          <i class="bi bi-x-lg"></i> Batal
        </a>
        <form method="POST" action="{{ route('siswa.pengembalian.proses',$peminjaman) }}" style="flex:1">
          @csrf
          <button type="submit" class="btn {{ $denda>0?'btn-danger':'btn-success' }} w-100" style="justify-content:center">
            <i class="bi bi-check-lg"></i> Ya, Kembalikan
          </button>
        </form>
      </div>
    </div>
  </div>

</div>
</div>
@endsection

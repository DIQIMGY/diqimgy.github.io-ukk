@extends('layouts.app')
@section('title','Detail Transaksi')
@section('page-title','Detail Transaksi')
@section('content')

<a href="{{ route('admin.transaksi.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:18px">
  <i class="bi bi-arrow-left"></i> Kembali
</a>

<div class="row justify-content-center">
<div class="col-lg-8 col-xl-7">
<div class="cbox">
  <div class="cbox-header">
    <div>
      <p style="font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:var(--tx-4);margin:0 0 5px">Kode Transaksi</p>
      <span class="pill" style="font-size:.88rem;padding:4px 10px">{{ $transaksi->kode_pinjam }}</span>
    </div>
    @if($transaksi->status==='dipinjam')
      <span class="status-badge sb-pinjam" style="font-size:.78rem;padding:.4em 1em"><i class="bi bi-circle-fill" style="font-size:.5rem"></i>Dipinjam</span>
    @elseif($transaksi->status==='terlambat')
      <span class="status-badge sb-terlambat" style="font-size:.78rem;padding:.4em 1em"><i class="bi bi-exclamation-circle-fill" style="font-size:.75rem"></i>Terlambat</span>
    @else
      <span class="status-badge sb-kembali" style="font-size:.78rem;padding:.4em 1em"><i class="bi bi-check-circle-fill" style="font-size:.75rem"></i>Dikembalikan</span>
    @endif
  </div>

  <div class="cbox-body">
    {{-- Anggota & Buku --}}
    <div class="row g-3 mb-4">
      <div class="col-md-6">
        <div style="background:var(--surface-2);border-radius:12px;padding:16px;border:1px solid var(--border-2)">
          <p style="font-size:.63rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--tx-4);margin:0 0 10px">
            <i class="bi bi-person me-1"></i>Anggota
          </p>
          <div style="display:flex;align-items:center;gap:12px">
            <div class="ava">{{ strtoupper(substr($transaksi->anggota->nama,0,1)) }}</div>
            <div>
              <p style="font-weight:800;font-size:.9rem;margin:0 0 2px;color:var(--navy-800)">{{ $transaksi->anggota->nama }}</p>
              <p style="font-size:.76rem;color:var(--tx-3);margin:0">{{ $transaksi->anggota->nis }} · {{ $transaksi->anggota->kelas }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div style="background:var(--surface-2);border-radius:12px;padding:16px;border:1px solid var(--border-2)">
          <p style="font-size:.63rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--tx-4);margin:0 0 10px">
            <i class="bi bi-book me-1"></i>Buku
          </p>
          <p style="font-weight:800;font-size:.9rem;margin:0 0 3px;color:var(--navy-800);line-height:1.3">{{ $transaksi->buku->judul }}</p>
          <p style="font-size:.76rem;color:var(--tx-3);margin:0">{{ $transaksi->buku->kode_buku }} · {{ $transaksi->buku->pengarang }}</p>
        </div>
      </div>
    </div>

    {{-- Info grid --}}
    <div class="info-grid" style="grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:20px">
      @foreach([
        ['Tanggal Pinjam',   $transaksi->tanggal_pinjam->format('d F Y'),               false],
        ['Batas Kembali',    $transaksi->tanggal_kembali_rencana->format('d F Y'),      $transaksi->status==='terlambat'],
        ['Tgl Dikembalikan', $transaksi->tanggal_kembali_aktual ? $transaksi->tanggal_kembali_aktual->format('d F Y') : '—', false],
        ['Denda',            $transaksi->denda>0 ? 'Rp '.number_format($transaksi->denda,0,',','.') : 'Tidak ada denda', $transaksi->denda>0],
      ] as [$lbl,$val,$danger])
      <div class="info-cell" style="{{ $danger?'background:#fff1f2;border-color:#fecdd3':'' }}">
        <div class="info-cell-label">{{ $lbl }}</div>
        <div class="info-cell-value" style="{{ $danger?'color:var(--red-500)':'' }}">{{ $val }}</div>
      </div>
      @endforeach
    </div>

    {{-- Return action --}}
    @if(in_array($transaksi->status,['dipinjam','terlambat']))
    <div style="background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:12px;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;border:1px solid #bbf7d0">
      <div>
        <p style="font-weight:800;font-size:.9rem;color:#15803d;margin:0 0 3px">Proses Pengembalian Buku</p>
        <p style="font-size:.79rem;color:#16a34a;margin:0">Klik tombol untuk menyelesaikan peminjaman ini.</p>
      </div>
      <form method="POST" action="{{ route('admin.transaksi.kembali',$transaksi) }}" onsubmit="return confirm('Proses pengembalian buku ini?')">
        @csrf
        <button class="btn btn-success"><i class="bi bi-box-arrow-in-left"></i> Kembalikan Sekarang</button>
      </form>
    </div>
    @endif
  </div>
</div>
</div></div>
@endsection

@extends('layouts.app')
@section('title','Riwayat Peminjaman')
@section('page-title','Riwayat Peminjaman')
@section('content')

<div class="toolbar">
  <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Pinjam Buku Baru
  </a>
  <div class="toolbar-right">
    <form method="GET" style="display:flex;gap:8px;align-items:center">
      <select name="status" class="form-select" style="width:160px">
        <option value="">Semua Status</option>
        <option value="dipinjam"     {{ request('status')==='dipinjam'    ?'selected':'' }}>Dipinjam</option>
        <option value="terlambat"    {{ request('status')==='terlambat'   ?'selected':'' }}>Terlambat</option>
        <option value="dikembalikan" {{ request('status')==='dikembalikan'?'selected':'' }}>Dikembalikan</option>
      </select>
      <button class="btn btn-ghost"><i class="bi bi-funnel"></i></button>
    </form>
  </div>
</div>

<div class="data-card">
  <div class="data-card-header">
    <h6><i class="bi bi-card-list" style="color:var(--blue-500)"></i> Riwayat Peminjaman Saya</h6>
    <span class="count-badge">{{ $peminjaman->total() }} transaksi</span>
  </div>
  <div class="table-responsive">
    <table class="dt">
      <thead><tr>
        <th style="width:36px">#</th>
        <th>Buku</th>
        <th>Tgl Pinjam</th>
        <th>Batas Kembali</th>
        <th>Tgl Kembali</th>
        <th>Status</th>
        <th>Denda</th>
      </tr></thead>
      <tbody>
        @forelse($peminjaman as $p)
        <tr>
          <td style="color:var(--tx-4);font-size:.78rem">{{ $peminjaman->firstItem()+$loop->index }}</td>
          <td style="font-weight:700;max-width:200px">{{ Str::limit($p->buku->judul??'-',30) }}</td>
          <td style="font-size:.8rem">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
          <td style="font-size:.8rem;{{ $p->status==='terlambat'?'color:var(--red-500);font-weight:700':'' }}">
            {{ $p->tanggal_kembali_rencana->format('d M Y') }}
          </td>
          <td style="font-size:.8rem;color:var(--tx-3)">
            {{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d M Y') : '—' }}
          </td>
          <td>
            @if($p->status==='dipinjam')     <span class="status-badge sb-pinjam"><i class="bi bi-circle-fill" style="font-size:.45rem"></i>Dipinjam</span>
            @elseif($p->status==='terlambat') <span class="status-badge sb-terlambat"><i class="bi bi-exclamation-circle-fill" style="font-size:.7rem"></i>Terlambat</span>
            @else                             <span class="status-badge sb-kembali"><i class="bi bi-check-circle-fill" style="font-size:.7rem"></i>Kembali</span>
            @endif
          </td>
          <td style="{{ $p->denda>0?'color:var(--red-500);font-weight:700':'color:var(--tx-4)' }};font-size:.8rem">
            {{ $p->denda>0 ? 'Rp '.number_format($p->denda,0,',','.') : '—' }}
          </td>
        </tr>
        @empty
        <tr><td colspan="7">
          <div class="empty" style="padding:48px 20px">
            <span class="empty-ico"><i class="bi bi-book"></i></span>
            <h6>Belum ada riwayat peminjaman</h6>
            <p style="margin-bottom:16px">Mulai pinjam buku dari koleksi perpustakaan kami.</p>
            <a href="{{ route('siswa.peminjaman.create') }}" class="btn btn-primary btn-sm">
              <i class="bi bi-book-fill"></i> Mulai Pinjam
            </a>
          </div>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($peminjaman->hasPages())
  <div class="dt-pager">{{ $peminjaman->links() }}</div>
  @endif
</div>
@endsection

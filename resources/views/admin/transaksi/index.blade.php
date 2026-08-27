@extends('layouts.app')
@section('title','Transaksi Peminjaman')
@section('page-title','Transaksi')
@section('content')
<div class="toolbar">
  <a href="{{ route('admin.transaksi.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Transaksi</a>
  <div class="toolbar-right">
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
      <div class="input-group" style="width:210px">
        <span class="input-group-text"><i class="bi bi-search" style="font-size:.78rem"></i></span>
        <input type="text" name="search" class="form-control" placeholder="Kode / Nama / Buku…" value="{{ request('search') }}">
      </div>
      <select name="status" class="form-select" style="width:140px">
        <option value="">Semua Status</option>
        <option value="dipinjam" {{ request('status')==='dipinjam'?'selected':'' }}>Dipinjam</option>
        <option value="terlambat" {{ request('status')==='terlambat'?'selected':'' }}>Terlambat</option>
        <option value="dikembalikan" {{ request('status')==='dikembalikan'?'selected':'' }}>Dikembalikan</option>
      </select>
      <button class="btn btn-ghost"><i class="bi bi-funnel"></i></button>
      @if(request()->hasAny(['search','status']))<a href="{{ route('admin.transaksi.index') }}" class="btn btn-ghost"><i class="bi bi-x-lg"></i></a>@endif
    </form>
  </div>
</div>

<div class="data-card">
  <div class="data-card-header">
    <h6><i class="bi bi-arrow-left-right" style="color:var(--gold-500)"></i> Data Transaksi</h6>
    <span class="count-badge">{{ $transaksi->total() }} transaksi</span>
  </div>
  <div class="table-responsive">
    <table class="dt">
      <thead><tr><th style="width:36px">#</th><th>Kode</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Batas Kembali</th><th>Status</th><th>Denda</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($transaksi as $t)
        <tr>
          <td style="color:var(--tx-4);font-size:.78rem">{{ $transaksi->firstItem()+$loop->index }}</td>
          <td><span class="pill">{{ $t->kode_pinjam }}</span></td>
          <td>
            <div style="display:flex;align-items:center;gap:9px">
              <div class="ava ava-sm">{{ strtoupper(substr($t->anggota->nama??'A',0,1)) }}</div>
              <div>
                <div style="font-weight:700;font-size:.82rem;line-height:1.2">{{ $t->anggota->nama??'-' }}</div>
                <div style="font-size:.69rem;color:var(--tx-4)">{{ $t->anggota->kelas??'' }}</div>
              </div>
            </div>
          </td>
          <td style="font-size:.82rem;color:var(--tx-2);max-width:150px">{{ Str::limit($t->buku->judul??'-',22) }}</td>
          <td style="font-size:.8rem">{{ $t->tanggal_pinjam->format('d M Y') }}</td>
          <td style="font-size:.8rem;{{ $t->status==='terlambat'?'color:var(--red-500);font-weight:700':'' }}">
            {{ $t->tanggal_kembali_rencana->format('d M Y') }}
          </td>
          <td>
            @if($t->status==='dipinjam') <span class="status-badge sb-pinjam"><i class="bi bi-circle-fill" style="font-size:.45rem"></i>Dipinjam</span>
            @elseif($t->status==='terlambat') <span class="status-badge sb-terlambat"><i class="bi bi-exclamation-circle-fill" style="font-size:.7rem"></i>Terlambat</span>
            @else <span class="status-badge sb-kembali"><i class="bi bi-check-circle-fill" style="font-size:.7rem"></i>Kembali</span>
            @endif
          </td>
          <td style="{{ $t->denda>0?'color:var(--red-500);font-weight:700':'color:var(--tx-4)' }};font-size:.8rem">
            {{ $t->denda>0 ? 'Rp '.number_format($t->denda,0,',','.') : '—' }}
          </td>
          <td>
            <div style="display:flex;gap:3px">
              <a href="{{ route('admin.transaksi.show',$t) }}" class="btn btn-xs btn-ico bv" title="Detail"><i class="bi bi-eye"></i></a>
              @if(in_array($t->status,['dipinjam','terlambat']))
              <form method="POST" action="{{ route('admin.transaksi.kembali',$t) }}" onsubmit="return confirm('Proses pengembalian?')">
                @csrf<button class="btn btn-xs btn-ico br" title="Kembalikan"><i class="bi bi-box-arrow-in-left"></i></button>
              </form>
              @endif
              <form method="POST" action="{{ route('admin.transaksi.destroy',$t) }}" onsubmit="return confirm('Hapus transaksi?')">
                @csrf @method('DELETE')
                <button class="btn btn-xs btn-ico bd"><i class="bi bi-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9"><div class="empty"><span class="empty-ico"><i class="bi bi-inbox"></i></span><h6>Tidak ada transaksi</h6><p>Coba ubah filter.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($transaksi->hasPages())<div class="dt-pager">{{ $transaksi->links() }}</div>@endif
</div>
@endsection

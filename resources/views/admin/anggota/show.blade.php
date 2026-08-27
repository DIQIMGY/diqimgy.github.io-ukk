@extends('layouts.app')
@section('title','Detail Anggota')
@section('page-title','Detail Anggota')
@section('content')
<a href="{{ route('admin.anggota.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:18px"><i class="bi bi-arrow-left"></i> Kembali</a>
<div class="row g-4">
  <div class="col-sm-5 col-md-4 col-lg-3">
    <div class="cbox cbox-body" style="text-align:center">
      <div class="profile-ava">{{ strtoupper(substr($anggota->nama,0,1)) }}</div>
      <h5 style="font-weight:800;font-size:1.05rem;color:var(--navy-800);margin-bottom:4px">{{ $anggota->nama }}</h5>
      <p style="font-size:.82rem;color:var(--tx-3);margin-bottom:10px">{{ $anggota->kelas }}</p>
      @if($anggota->status==='aktif')
        <span class="status-badge sb-aktif" style="font-size:.76rem">● Aktif</span>
      @else
        <span class="status-badge sb-nonaktif" style="font-size:.76rem">○ Non-aktif</span>
      @endif
      <div style="margin-top:18px">
        @foreach([
          ['bi-credit-card-2-front','NIS: '.$anggota->nis],
          ['bi-envelope',$anggota->user->email??'-'],
          ['bi-telephone',$anggota->telepon??'—'],
          ['bi-geo-alt',$anggota->alamat??'—'],
        ] as [$ic,$val])
        <div class="profile-row">
          <i class="bi {{ $ic }}"></i>
          <span style="color:var(--tx-2)">{{ $val }}</span>
        </div>
        @endforeach
      </div>
      <a href="{{ route('admin.anggota.edit',$anggota) }}" class="btn btn-primary w-100" style="margin-top:16px;justify-content:center">
        <i class="bi bi-pencil"></i> Edit Anggota
      </a>
    </div>
  </div>

  <div class="col-sm-7 col-md-8 col-lg-9">
    <div class="data-card">
      <div class="data-card-header">
        <h6><i class="bi bi-clock-history" style="color:var(--blue-500)"></i> Riwayat Peminjaman</h6>
        <span class="count-badge">{{ $anggota->peminjaman->count() }} transaksi</span>
      </div>
      <div class="table-responsive">
        <table class="dt">
          <thead><tr><th>Kode</th><th>Buku</th><th>Tgl Pinjam</th><th>Batas Kembali</th><th>Status</th><th>Denda</th></tr></thead>
          <tbody>
            @forelse($anggota->peminjaman as $p)
            <tr>
              <td><span class="pill">{{ $p->kode_pinjam }}</span></td>
              <td style="font-weight:600;max-width:180px">{{ Str::limit($p->buku->judul??'-',28) }}</td>
              <td style="font-size:.8rem">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
              <td style="font-size:.8rem">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
              <td>
                @if($p->status==='dipinjam') <span class="status-badge sb-pinjam"><i class="bi bi-circle-fill" style="font-size:.45rem"></i>Dipinjam</span>
                @elseif($p->status==='terlambat') <span class="status-badge sb-terlambat"><i class="bi bi-exclamation-circle-fill" style="font-size:.7rem"></i>Terlambat</span>
                @else <span class="status-badge sb-kembali"><i class="bi bi-check-circle-fill" style="font-size:.7rem"></i>Kembali</span>
                @endif
              </td>
              <td style="{{ $p->denda>0?'color:var(--red-500);font-weight:700':'color:var(--tx-4)' }};font-size:.8rem">
                {{ $p->denda>0 ? 'Rp '.number_format($p->denda,0,',','.') : '—' }}
              </td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="empty" style="padding:32px"><span class="empty-ico"><i class="bi bi-inbox"></i></span><p>Belum ada riwayat peminjaman.</p></div></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

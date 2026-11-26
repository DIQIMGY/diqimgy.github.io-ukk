@extends('layouts.app')
@section('title','Detail Peminjaman')
@section('page-title','Detail Peminjaman')
@section('content')

<div class="row justify-content-center">
<div class="col-lg-8 col-xl-7">

  <a href="{{ route('siswa.peminjaman.index') }}"
     style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:rgba(237,27,59,.07);border:1.5px solid rgba(237,27,59,.2);border-radius:12px;color:#ED1B3B;font-weight:600;font-size:.875rem;text-decoration:none;margin-bottom:22px;transition:all .3s">
    <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
  </a>

  {{-- Flash --}}
  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mb-4">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif
  @if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show mb-4">
    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div style="background:#fff;border-radius:20px;border:1px solid #e5e7eb;box-shadow:0 4px 24px rgba(0,0,0,.06);overflow:hidden">

    {{-- Header: Kode & Status --}}
    <div style="padding:24px 28px;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
      <div>
        <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:5px">Kode Transaksi</div>
        <code style="padding:8px 16px;background:rgba(20,40,75,.07);border:1.5px solid rgba(20,40,75,.12);border-radius:9px;font-size:.95rem;font-weight:700;color:#14284B;font-family:'Courier New',monospace">
          {{ $peminjaman->kode_pinjam }}
        </code>
      </div>
      <span class="badge bg-{{ $peminjaman->statusColor() }}" style="font-size:.8rem;padding:8px 14px;border-radius:8px">
        {{ $peminjaman->statusLabel() }}
      </span>
    </div>

    {{-- Buku Info --}}
    <div style="padding:24px 28px;border-bottom:1px solid #f0f0f0">
      <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:12px">Buku Dipinjam</div>
      <div style="display:flex;gap:16px;align-items:flex-start">
        @if($peminjaman->buku && $peminjaman->buku->cover)
          <img src="{{ Storage::url($peminjaman->buku->cover) }}" alt="{{ $peminjaman->buku->judul }}"
               style="width:60px;height:90px;object-fit:cover;border-radius:10px;box-shadow:0 4px 16px rgba(0,0,0,.18);flex-shrink:0">
        @else
          <div style="width:60px;height:90px;border-radius:10px;background:linear-gradient(135deg,#0c4a6e,#0284c7);display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="bi bi-book-fill" style="color:rgba(255,255,255,.8);font-size:1.5rem"></i>
          </div>
        @endif
        <div>
          <div style="font-size:1.05rem;font-weight:800;color:#14284B;line-height:1.3;margin-bottom:4px">{{ $peminjaman->buku->judul ?? '-' }}</div>
          <div style="font-size:.85rem;color:#64748b">{{ $peminjaman->buku->pengarang ?? '' }}</div>
          <div style="font-size:.8rem;color:#94a3b8;margin-top:3px">{{ $peminjaman->buku->kategori ?? '' }}</div>
        </div>
      </div>
    </div>

    {{-- Tanggal Grid --}}
    <div style="padding:24px 28px;border-bottom:1px solid #f0f0f0">
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:14px">

        <div style="background:#f8fafc;border-radius:12px;padding:14px;border:1px solid #e2e8f0">
          <div style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;margin-bottom:5px">Tgl Pengajuan</div>
          <div style="font-weight:700;color:#14284B">{{ $peminjaman->tanggal_pengajuan ? $peminjaman->tanggal_pengajuan->format('d M Y') : '—' }}</div>
        </div>

        <div style="background:#f8fafc;border-radius:12px;padding:14px;border:1px solid #e2e8f0">
          <div style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;margin-bottom:5px">Tgl Pinjam</div>
          <div style="font-weight:700;color:#14284B">
            {{ $peminjaman->tanggal_pinjam ? $peminjaman->tanggal_pinjam->format('d M Y') : '—' }}
            @if($peminjaman->status === 'pending')
              <div style="font-size:.7rem;color:#b45309;font-weight:400">Setelah disetujui</div>
            @endif
          </div>
        </div>

        <div style="background:{{ $peminjaman->status === 'terlambat' ? '#fff1f2' : '#f8fafc' }};border-radius:12px;padding:14px;border:1px solid {{ $peminjaman->status === 'terlambat' ? '#fecdd3' : '#e2e8f0' }}">
          <div style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;margin-bottom:5px">Batas Kembali</div>
          <div style="font-weight:700;color:{{ $peminjaman->status === 'terlambat' ? '#dc2626' : '#14284B' }}">
            {{ $peminjaman->tanggal_kembali_rencana ? $peminjaman->tanggal_kembali_rencana->format('d M Y') : '—' }}
          </div>
        </div>

        @if($peminjaman->tanggal_kembali_aktual)
        <div style="background:#f0fdf4;border-radius:12px;padding:14px;border:1px solid #bbf7d0">
          <div style="font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;margin-bottom:5px">Tgl Dikembalikan</div>
          <div style="font-weight:700;color:#15803d">{{ $peminjaman->tanggal_kembali_aktual->format('d M Y') }}</div>
        </div>
        @endif

      </div>
    </div>

    {{-- Denda --}}
    @if($peminjaman->denda > 0 || $peminjaman->status === 'dikembalikan')
    <div style="padding:20px 28px;border-bottom:1px solid #f0f0f0">
      <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:10px">Denda</div>
      @if($peminjaman->denda > 0)
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
          <span style="font-size:1.1rem;font-weight:800;color:#dc2626">
            Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
          </span>
          @if($peminjaman->denda_dibayar)
            <span class="badge bg-success" style="font-size:.8rem;padding:7px 13px">
              <i class="bi bi-check-circle-fill me-1"></i> Lunas
              @if($peminjaman->denda_dibayar_at)
                ({{ $peminjaman->denda_dibayar_at->format('d M Y') }})
              @endif
            </span>
          @else
            <span class="badge bg-warning text-dark" style="font-size:.8rem;padding:7px 13px">
              <i class="bi bi-clock me-1"></i> Belum Lunas
            </span>
          @endif
        </div>
      @else
        <span style="color:#15803d;font-weight:600"><i class="bi bi-check-circle-fill me-1"></i>Tidak ada denda</span>
      @endif
    </div>
    @endif

    {{-- Alasan Penolakan --}}
    @if($peminjaman->status === 'ditolak' && $peminjaman->rejection_reason)
    <div style="padding:20px 28px;border-bottom:1px solid #f0f0f0;background:#fff8f8">
      <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#be123c;margin-bottom:8px">Alasan Penolakan</div>
      <p style="margin:0;color:#9f1239;font-size:.9rem;line-height:1.6">{{ $peminjaman->rejection_reason }}</p>
    </div>
    @endif

    {{-- Ulasan --}}
    <div style="padding:20px 28px">
      @if($peminjaman->status === 'dikembalikan')
        @if($peminjaman->ulasan)
          <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;color:#94a3b8;margin-bottom:10px">Ulasan Kamu</div>
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
            <span style="color:#f59e0b;font-size:1.1rem">
              @for($s=1;$s<=5;$s++){{ $s<=$peminjaman->ulasan->rating ? '★' : '☆' }}@endfor
            </span>
            <span style="font-weight:700;color:#f59e0b">{{ $peminjaman->ulasan->rating }}/5</span>
          </div>
          @if($peminjaman->ulasan->komentar)
            <p style="margin:0;font-size:.88rem;color:#374151;line-height:1.6;font-style:italic">"{{ $peminjaman->ulasan->komentar }}"</p>
          @endif
        @else
          <a href="{{ route('siswa.ulasan.create', $peminjaman) }}"
             style="display:inline-flex;align-items:center;gap:8px;padding:11px 20px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border-radius:11px;font-weight:700;font-size:.88rem;text-decoration:none">
            <i class="bi bi-star-fill"></i> Beri Ulasan
          </a>
        @endif
      @endif
    </div>

  </div>

</div>
</div>
@endsection

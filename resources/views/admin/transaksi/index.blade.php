@extends('layouts.app')
@section('title','Transaksi Peminjaman')
@section('page-title','Transaksi')
@section('content')

<style>
/* Modern Transaction List Style */
.transaction-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
}

.transaction-filter-bar {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: center;
  background: #fff;
  padding: 16px 20px;
  border-radius: 16px;
  border: 1px solid #f0f0f0;
  margin-bottom: 24px;
  box-shadow: 0 2px 8px rgba(0,0,0,.04);
}

.transaction-card {
  background: #fff;
  border-radius: 16px;
  border: 1px solid #f0f0f0;
  padding: 20px 24px;
  margin-bottom: 16px;
  transition: all .3s;
  cursor: pointer;
}

.transaction-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,0,0,.08);
  border-color: var(--crimson);
}

.transaction-card-borrowed {
  border-left: 4px solid #0ea5e9;
}

.transaction-card-late {
  border-left: 4px solid #f59e0b;
}

.transaction-card-returned {
  border-left: 4px solid #10b981;
}
</style>

{{-- Page Header --}}
<div class="transaction-header">
  <div>
    <h1 style="font-size:1.6rem;font-weight:900;color:var(--navy-800);margin:0 0 6px">Transaksi Peminjaman</h1>
    <p style="font-size:.88rem;color:var(--tx-3);margin:0">
      <i class="bi bi-arrow-left-right" style="color:#f59e0b"></i>
      Kelola transaksi peminjaman buku
    </p>
  </div>
  <a href="{{ route('admin.transaksi.create') }}" style="padding:12px 24px;border-radius:14px;font-size:.88rem;font-weight:700;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border:none;display:flex;align-items:center;gap:10px;box-shadow:0 6px 20px rgba(245,158,11,.3);text-decoration:none;transition:all .3s">
    <i class="bi bi-plus-circle-fill" style="font-size:1.1rem"></i> Tambah Transaksi
  </a>
</div>

{{-- Filter Bar --}}
<div class="transaction-filter-bar">
  <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;flex:1">
    <div style="flex:1;min-width:250px;position:relative">
      <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-4);font-size:.85rem"></i>
      <input type="text" name="search" placeholder="Cari kode, nama anggota, atau buku..." value="{{ request('search') }}" style="width:100%;padding:10px 14px 10px 38px;border:1px solid #e0e0e0;border-radius:12px;font-size:.88rem">
    </div>
    
    <select name="status" style="padding:10px 14px;border:1px solid #e0e0e0;border-radius:12px;font-size:.88rem;min-width:160px">
      <option value="">Semua Status</option>
      <option value="dipinjam" {{ request('status')==='dipinjam'?'selected':'' }}>Dipinjam</option>
      <option value="terlambat" {{ request('status')==='terlambat'?'selected':'' }}>Terlambat</option>
      <option value="dikembalikan" {{ request('status')==='dikembalikan'?'selected':'' }}>Dikembalikan</option>
    </select>
    
    <button type="submit" style="padding:10px 20px;border-radius:12px;font-size:.85rem;font-weight:700;background:#f59e0b;color:#fff;border:none;cursor:pointer;display:flex;align-items:center;gap:8px">
      <i class="bi bi-funnel-fill"></i> Filter
    </button>
    
    @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.transaksi.index') }}" style="padding:10px 16px;border-radius:12px;background:#f5f5f5;border:1px solid #e0e0e0;text-decoration:none;color:var(--tx-2);display:flex;align-items:center;gap:6px;font-size:.85rem">
      <i class="bi bi-x-circle-fill"></i> Reset
    </a>
    @endif
  </form>
</div>

{{-- Stats Overview --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:24px">
  @php
    $stats = [
      ['Total', $transaksi->total(), '#6b7280', 'bi-arrow-left-right'],
      ['Dipinjam', $transaksi->where('status','dipinjam')->count(), '#0ea5e9', 'bi-circle-fill'],
      ['Terlambat', $transaksi->where('status','terlambat')->count(), '#f59e0b', 'bi-exclamation-triangle-fill'],
      ['Kembali', $transaksi->where('status','dikembalikan')->count(), '#10b981', 'bi-check-circle-fill'],
    ];
  @endphp
  
  @foreach($stats as [$label, $value, $color, $icon])
  <div style="background:#fff;border-radius:14px;padding:18px;border:1px solid #f0f0f0;box-shadow:0 2px 8px rgba(0,0,0,.04)">
    <div style="display:flex;align-items:center;gap:12px">
      <div style="width:48px;height:48px;border-radius:12px;background:{{ $color }}20;display:flex;align-items:center;justify-content:center">
        <i class="bi {{ $icon }}" style="font-size:1.2rem;color:{{ $color }}"></i>
      </div>
      <div>
        <div style="font-size:.75rem;color:var(--tx-3);font-weight:700;text-transform:uppercase">{{ $label }}</div>
        <div style="font-size:1.8rem;font-weight:900;color:var(--navy-800);line-height:1">{{ $value }}</div>
      </div>
    </div>
  </div>
  @endforeach
</div>

@if($transaksi->isEmpty())
{{-- Empty State --}}
<div style="background:#fff;border-radius:20px;padding:60px 40px;text-align:center;border:2px dashed #e0e0e0">
  <i class="bi bi-inbox" style="font-size:4rem;color:#d0d0d0;display:block;margin-bottom:16px"></i>
  <h3 style="font-size:1.2rem;font-weight:800;color:var(--navy-800);margin:0 0 8px">Tidak ada transaksi ditemukan</h3>
  <p style="font-size:.88rem;color:var(--tx-3);margin:0 0 24px">Coba kata kunci berbeda atau tambahkan transaksi baru.</p>
  <a href="{{ route('admin.transaksi.create') }}" style="display:inline-flex;align-items:center;gap:10px;padding:12px 28px;border-radius:14px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;font-weight:700;text-decoration:none;box-shadow:0 6px 20px rgba(245,158,11,.3)">
    <i class="bi bi-plus-circle-fill"></i> Tambah Transaksi Pertama
  </a>
</div>
@else
{{-- Transaction List --}}
@foreach($transaksi as $t)
<div class="transaction-card transaction-card-{{ $t->status === 'terlambat' ? 'late' : ($t->status === 'dikembalikan' ? 'returned' : 'borrowed') }}">
  <div style="display:flex;align-items:start;justify-content:space-between;gap:20px;flex-wrap:wrap">
    {{-- Left: Main Info --}}
    <div style="flex:1;min-width:250px">
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
        {{-- Avatar --}}
        @if($t->anggota && $t->anggota->foto)
          <img src="{{ Storage::url($t->anggota->foto) }}" alt="{{ $t->anggota->nama }}" 
               style="width:48px;height:48px;border-radius:50%;object-fit:cover;flex-shrink:0;box-shadow:0 4px 14px rgba(0,0,0,.2);border:2px solid #fff;">
        @else
          <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,{{ $t->status === 'terlambat' ? '#f59e0b,#d97706' : ($t->status === 'dikembalikan' ? '#10b981,#059669' : '#0ea5e9,#0284c7') }});display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:900;color:#fff;flex-shrink:0;box-shadow:0 4px 14px rgba(0,0,0,.2)">
            {{ strtoupper(substr($t->anggota->nama??'A',0,1)) }}
          </div>
        @endif
        
        {{-- Member Info --}}
        <div>
          <h3 style="font-size:1rem;font-weight:800;color:var(--navy-800);margin:0 0 4px">{{ $t->anggota->nama??'-' }}</h3>
          <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            <span style="font-size:.72rem;color:var(--tx-3)">
              <i class="bi bi-credit-card-2-front"></i> {{ $t->kode_pinjam }}
            </span>
            <span style="font-size:.72rem;color:var(--tx-3)">
              <i class="bi bi-mortarboard"></i> {{ $t->anggota->kelas??'' }}
            </span>
          </div>
        </div>
      </div>
      
      {{-- Book Info --}}
      <div style="background:#fafbfc;border-radius:12px;padding:12px;margin-bottom:12px">
        <div style="display:flex;align-items:center;gap:12px">
          @if($t->buku && $t->buku->cover)
            <img src="{{ Storage::url($t->buku->cover) }}" alt="{{ $t->buku->judul }}" 
                 style="width:44px;height:66px;object-fit:cover;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.15);flex-shrink:0;">
          @else
            <div style="width:44px;height:66px;border-radius:8px;background:linear-gradient(135deg,#0f1f3d,#1e4080);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,.15)">
              <i class="bi bi-book-fill" style="color:rgba(255,255,255,.7);font-size:1.3rem"></i>
            </div>
          @endif
          <div style="flex:1;min-width:0">
            <div style="font-size:.88rem;font-weight:700;color:var(--navy-800);margin-bottom:2px">{{ $t->buku->judul??'-' }}</div>
            <div style="font-size:.75rem;color:var(--tx-3)">{{ $t->buku->pengarang??'' }}</div>
          </div>
        </div>
      </div>
      
      {{-- Dates --}}
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px">
        <div>
          <div style="font-size:.68rem;color:var(--tx-4);font-weight:700;text-transform:uppercase;margin-bottom:4px">Tgl Pinjam</div>
          <div style="font-size:.85rem;font-weight:700;color:var(--navy-800)">
            <i class="bi bi-calendar3"></i> {{ $t->tanggal_pinjam->format('d M Y') }}
          </div>
        </div>
        <div>
          <div style="font-size:.68rem;color:var(--tx-4);font-weight:700;text-transform:uppercase;margin-bottom:4px">Batas Kembali</div>
          <div style="font-size:.85rem;font-weight:700;color:{{ $t->status === 'terlambat' ? '#f59e0b' : 'var(--navy-800)' }}">
            <i class="bi bi-calendar-check"></i> {{ $t->tanggal_kembali_rencana->format('d M Y') }}
          </div>
        </div>
      </div>
    </div>
    
    {{-- Right: Status & Actions --}}
    <div style="display:flex;flex-direction:column;gap:12px;min-width:200px">
      {{-- Status Badge --}}
      <div>
        @if($t->status === 'dipinjam')
          <span style="display:inline-flex;align-items:center;gap:6px;background:#dbeafe;color:#0369a1;font-size:.8rem;font-weight:700;padding:8px 16px;border-radius:10px;width:100%;justify-content:center">
            <span style="width:8px;height:8px;background:currentColor;border-radius:50%"></span>Sedang Dipinjam
          </span>
        @elseif($t->status === 'terlambat')
          <span style="display:inline-flex;align-items:center;gap:6px;background:#fef3c7;color:#b45309;font-size:.8rem;font-weight:700;padding:8px 16px;border-radius:10px;width:100%;justify-content:center">
            <i class="bi bi-exclamation-triangle-fill"></i>Terlambat
          </span>
        @else
          <span style="display:inline-flex;align-items:center;gap:6px;background:#dcfce7;color:#15803d;font-size:.8rem;font-weight:700;padding:8px 16px;border-radius:10px;width:100%;justify-content:center">
            <i class="bi bi-check-circle-fill"></i>Dikembalikan
          </span>
        @endif
      </div>
      
      {{-- Denda --}}
      @if($t->denda > 0)
      <div style="background:#fff1f2;border:1px solid #fecdd3;border-radius:10px;padding:10px;text-align:center">
        <div style="font-size:.7rem;color:#be123c;font-weight:700;text-transform:uppercase;margin-bottom:4px">Denda</div>
        <div style="font-size:1.1rem;font-weight:900;color:#be123c;line-height:1">Rp {{ number_format($t->denda,0,',','.') }}</div>
      </div>
      @endif
      
      {{-- Actions --}}
      <div style="display:flex;gap:8px">
        <a href="{{ route('admin.transaksi.show',$t) }}" style="flex:1;display:flex;align-items:center;justify-content:center;padding:10px;border-radius:10px;background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;text-decoration:none;font-size:.82rem;font-weight:700">
          <i class="bi bi-eye-fill"></i>
        </a>
        @if(in_array($t->status,['dipinjam','terlambat']))
        <form method="POST" action="{{ route('admin.transaksi.kembali',$t) }}" onsubmit="return confirm('Proses pengembalian buku {{ $t->buku->judul }}?')" style="flex:1">
          @csrf
          <button type="submit" style="width:100%;padding:10px;border-radius:10px;background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;font-size:.82rem;font-weight:700;cursor:pointer">
            <i class="bi bi-box-arrow-in-left"></i>
          </button>
        </form>
        @endif
        <form method="POST" action="{{ route('admin.transaksi.destroy',$t) }}" onsubmit="return confirm('Hapus transaksi ini?')" style="flex:1">
          @csrf @method('DELETE')
          <button type="submit" style="width:100%;padding:10px;border-radius:10px;background:#fef2f2;border:1px solid #fecdd3;color:#be123c;font-size:.82rem;font-weight:700;cursor:pointer">
            <i class="bi bi-trash-fill"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

{{-- Pagination --}}
@if($transaksi->hasPages())
<div style="display:flex;justify-content:center;margin-top:32px">
  {{ $transaksi->links() }}
</div>
@endif
@endif

@endsection

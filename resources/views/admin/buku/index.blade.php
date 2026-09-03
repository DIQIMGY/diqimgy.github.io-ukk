@extends('layouts.app')
@section('title','Data Buku')
@section('page-title','Data Buku')
@section('content')

<style>
/* Modern Book Library Style */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
}

.search-toolbar {
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

.book-grid-modern {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}

.book-card-modern {
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid #f0f0f0;
  transition: all .3s cubic-bezier(.4,0,.2,1);
  cursor: pointer;
}

.book-card-modern:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 32px rgba(0,0,0,.12);
  border-color: var(--crimson);
}

.book-cover-wrapper {
  position: relative;
  width: 100%;
  padding-top: 140%;
  background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
  overflow: hidden;
}

.book-cover-wrapper img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.book-placeholder {
  position: absolute;
  inset: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
  text-align: center;
  gap: 8px;
  color: #fff;
}

.book-stok-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  padding: 4px 12px;
  border-radius: 8px;
  font-size: .72rem;
  font-weight: 700;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

.stok-available {
  background: rgba(16,185,129,.9);
  color: #fff;
  box-shadow: 0 4px 12px rgba(16,185,129,.4);
}

.stok-empty {
  background: rgba(239,68,68,.9);
  color: #fff;
  box-shadow: 0 4px 12px rgba(239,68,68,.4);
}

.book-info {
  padding: 16px;
}

.book-category {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: .7rem;
  font-weight: 700;
  background: rgba(237,27,59,.08);
  color: var(--crimson);
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: .05em;
}

.book-title-modern {
  font-size: .95rem;
  font-weight: 800;
  color: var(--navy-800);
  margin: 0 0 6px;
  line-height: 1.3;
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

.book-author-modern {
  font-size: .8rem;
  color: var(--tx-3);
  margin: 0 0 12px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.book-actions {
  display: flex;
  gap: 6px;
  padding-top: 12px;
  border-top: 1px solid #f0f0f0;
}

.action-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px;
  border-radius: 10px;
  border: 1px solid #e0e0e0;
  background: #fafbfc;
  cursor: pointer;
  transition: all .2s;
  text-decoration: none;
  color: var(--tx-2);
  font-size: .85rem;
}

.action-btn:hover {
  background: #fff;
  border-color: var(--crimson);
  color: var(--crimson);
  transform: translateY(-2px);
}

.action-btn.btn-delete:hover {
  background: #fef2f2;
  border-color: #ef4444;
  color: #ef4444;
}
</style>

{{-- Page Header --}}
<div class="page-header">
  <div>
    <h1 style="font-size:1.6rem;font-weight:900;color:var(--navy-800);margin:0 0 6px">Data Buku</h1>
    <p style="font-size:.88rem;color:var(--tx-3);margin:0">
      <i class="bi bi-collection-fill" style="color:var(--crimson)"></i>
      Kelola koleksi perpustakaan
    </p>
  </div>
  <a href="{{ route('admin.buku.create') }}" style="padding:12px 24px;border-radius:14px;font-size:.88rem;font-weight:700;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));color:#fff;border:none;display:flex;align-items:center;gap:10px;box-shadow:0 6px 20px rgba(237,27,59,.3);text-decoration:none;transition:all .3s">
    <i class="bi bi-plus-circle-fill" style="font-size:1.1rem"></i> Tambah Buku
  </a>
</div>

{{-- Search & Filter Toolbar --}}
<div class="search-toolbar">
  <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;flex:1">
    <div style="flex:1;min-width:250px;position:relative">
      <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--tx-4);font-size:.85rem"></i>
      <input type="text" name="search" placeholder="Cari judul, pengarang, atau ISBN..." value="{{ request('search') }}" style="width:100%;padding:10px 14px 10px 38px;border:1px solid #e0e0e0;border-radius:12px;font-size:.88rem">
    </div>
    
    <select name="kategori" style="padding:10px 14px;border:1px solid #e0e0e0;border-radius:12px;font-size:.88rem;min-width:160px">
      <option value="">Semua Kategori</option>
      @foreach($kategoris as $k)
      <option value="{{ $k }}" {{ request('kategori')==$k?'selected':'' }}>{{ $k }}</option>
      @endforeach
    </select>
    
    <button type="submit" style="padding:10px 20px;border-radius:12px;font-size:.85rem;font-weight:700;background:var(--crimson);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;gap:8px">
      <i class="bi bi-funnel-fill"></i> Filter
    </button>
    
    @if(request()->hasAny(['search','kategori']))
    <a href="{{ route('admin.buku.index') }}" style="padding:10px 16px;border-radius:12px;background:#f5f5f5;border:1px solid #e0e0e0;text-decoration:none;color:var(--tx-2);display:flex;align-items:center;gap:6px;font-size:.85rem">
      <i class="bi bi-x-circle-fill"></i> Reset
    </a>
    @endif
  </form>
</div>

@if($buku->isEmpty())
{{-- Empty State --}}
<div style="background:#fff;border-radius:20px;padding:60px 40px;text-align:center;border:2px dashed #e0e0e0">
  <i class="bi bi-journal-x" style="font-size:4rem;color:#d0d0d0;display:block;margin-bottom:16px"></i>
  <h3 style="font-size:1.2rem;font-weight:800;color:var(--navy-800);margin:0 0 8px">Tidak ada buku ditemukan</h3>
  <p style="font-size:.88rem;color:var(--tx-3);margin:0 0 24px">Coba kata kunci berbeda atau tambahkan buku baru.</p>
  <a href="{{ route('admin.buku.create') }}" style="display:inline-flex;align-items:center;gap:10px;padding:12px 28px;border-radius:14px;background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));color:#fff;font-weight:700;text-decoration:none;box-shadow:0 6px 20px rgba(237,27,59,.3)">
    <i class="bi bi-plus-circle-fill"></i> Tambah Buku Pertama
  </a>
</div>
@else
{{-- Book Grid --}}
<div class="book-grid-modern">
  @foreach($buku as $i => $b)
  @php
    $gradients = [
      'linear-gradient(150deg,#667eea,#764ba2)',
      'linear-gradient(150deg,#f093fb,#f5576c)',
      'linear-gradient(150deg,#4facfe,#00f2fe)',
      'linear-gradient(150deg,#43e97b,#38f9d7)',
      'linear-gradient(150deg,#fa709a,#fee140)',
      'linear-gradient(150deg,#30cfd0,#330867)',
      'linear-gradient(150deg,#a8edea,#fed6e3)',
      'linear-gradient(150deg,#ff9a9e,#fecfef)',
    ];
    $grad = $gradients[$i % count($gradients)];
  @endphp
  
  <div class="book-card-modern">
    {{-- Book Cover --}}
    <div class="book-cover-wrapper">
      @if($b->cover)
        <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}">
      @else
        <div class="book-placeholder" style="background:{{ $grad }}">
          <i class="bi bi-book-fill" style="font-size:2.5rem;opacity:.7"></i>
          <span style="font-size:.8rem;font-weight:700;line-height:1.3;opacity:.9">{{ Str::limit($b->judul,40) }}</span>
          <span style="font-size:.7rem;opacity:.7">{{ Str::limit($b->pengarang,30) }}</span>
        </div>
      @endif
      
      {{-- Stock Badge --}}
      <div class="book-stok-badge {{ $b->stok > 0 ? 'stok-available' : 'stok-empty' }}">
        @if($b->stok > 0)
          <i class="bi bi-check-circle-fill" style="font-size:.7rem"></i> {{ $b->stok }} Stok
        @else
          <i class="bi bi-x-circle-fill" style="font-size:.7rem"></i> Habis
        @endif
      </div>
      
      {{-- Spine Effect --}}
      <div style="position:absolute;left:0;top:0;bottom:0;width:6px;background:linear-gradient(to right,rgba(0,0,0,.3),transparent)"></div>
    </div>
    
    {{-- Book Info --}}
    <div class="book-info">
      <div class="book-category">{{ $b->kategori }}</div>
      <h3 class="book-title-modern">{{ $b->judul }}</h3>
      <p class="book-author-modern">
        <i class="bi bi-person-fill"></i> {{ $b->pengarang }}
      </p>
      
      {{-- Actions --}}
      <div class="book-actions">
        <a href="{{ route('admin.buku.show',$b) }}" class="action-btn" title="Detail">
          <i class="bi bi-eye-fill"></i>
        </a>
        <a href="{{ route('admin.buku.edit',$b) }}" class="action-btn" title="Edit">
          <i class="bi bi-pencil-fill"></i>
        </a>
        <form method="POST" action="{{ route('admin.buku.destroy',$b) }}" onsubmit="return confirm('Hapus buku ini dari perpustakaan?')" style="flex:1">
          @csrf @method('DELETE')
          <button type="submit" class="action-btn btn-delete" title="Hapus" style="width:100%;border:none">
            <i class="bi bi-trash-fill"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Pagination --}}
@if($buku->hasPages())
<div style="display:flex;justify-content:center;margin-top:32px">
  {{ $buku->links() }}
</div>
@endif
@endif

@endsection

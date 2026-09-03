@extends('layouts.app')
@section('title','Pinjam Buku')
@section('page-title','Pinjam Buku')
@section('content')
<style>
.catalog-page-modern {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.search-bar-modern {
  background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
  border-radius: 16px;
  padding: 20px 24px;
  margin-bottom: 28px;
  box-shadow: 0 4px 16px rgba(20,40,75,0.06);
  border: 1.5px solid rgba(20,40,75,0.06);
}
.search-form-modern {
  display: flex;
  gap: 12px;
  align-items: center;
  flex-wrap: wrap;
}
.search-input-group {
  flex: 1;
  min-width: 250px;
  position: relative;
  display: flex;
  align-items: center;
  background: white;
  border: 2px solid rgba(20,40,75,0.12);
  border-radius: 12px;
  overflow: hidden;
  transition: all 0.3s ease;
}
.search-input-group:focus-within {
  border-color: #ED1B3B;
  box-shadow: 0 0 0 4px rgba(237,27,59,0.1);
}
.search-icon {
  padding: 0 16px;
  color: #ED1B3B;
  font-size: 1.1rem;
}
.search-input {
  flex: 1;
  border: none;
  padding: 14px 16px 14px 0;
  font-size: 0.95rem;
  color: #14284B;
  background: transparent;
  font-weight: 500;
}
.search-input:focus {
  outline: none;
}
.search-input::placeholder {
  color: #94a3b8;
}
.btn-search-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 24px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.95rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(237,27,59,0.3);
}
.btn-search-modern:hover {
  background: linear-gradient(135deg, #C41630 0%, #A01228 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(237,27,59,0.4);
}
.btn-reset-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 24px;
  background: white;
  border: 2px solid rgba(20,40,75,0.15);
  border-radius: 12px;
  color: #14284B;
  font-weight: 700;
  font-size: 0.95rem;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
}
.btn-reset-modern:hover {
  background: #f8fafc;
  border-color: rgba(20,40,75,0.25);
  color: #14284B;
}
.search-result-info {
  font-size: 0.9rem;
  color: #64748b;
  margin-bottom: 24px;
  font-weight: 600;
}
.search-result-info strong {
  color: #14284B;
}
</style>

<div class="catalog-page-modern">
  <div class="search-bar-modern">
    <form method="GET" class="search-form-modern">
      <div class="search-input-group">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Cari judul, pengarang, atau kategori buku..."
               value="{{ $search }}" autofocus>
      </div>
      <button type="submit" class="btn-search-modern">
        <i class="bi bi-search"></i>
        <span>Cari</span>
      </button>
      @if($search)
      <a href="{{ route('siswa.peminjaman.create') }}" class="btn-reset-modern">
        <i class="bi bi-x-circle"></i>
        <span>Reset</span>
      </a>
      @endif
    </form>
  </div>

  @if($search)
  <p class="search-result-info">
    Hasil pencarian "<strong>{{ $search }}</strong>" — <strong>{{ $buku->total() }}</strong> buku ditemukan
  </p>
  @endif

  @if($buku->isEmpty())
  <div style="text-align: center; padding: 80px 20px;">
    <i class="bi bi-search" style="font-size: 5rem; color: #cbd5e1; margin-bottom: 20px;"></i>
    <h6 style="font-size: 1.2rem; font-weight: 800; color: #14284B; margin-bottom: 10px;">Tidak Ada Buku Ditemukan</h6>
    <p style="color: #64748b; margin: 0;">Coba kata kunci yang berbeda</p>
  </div>
  @else
  <div class="book-grid">
    @foreach($buku as $i => $b)
    <div class="book-card">
      <div class="book-cover">
        @if($b->cover)
          <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}">
        @else
          <div class="book-ph g{{ $i % 8 }}">
            <span class="p-ico"><i class="bi bi-book-fill"></i></span>
            <span class="p-ttl">{{ $b->judul }}</span>
            <span class="p-ath">{{ $b->pengarang }}</span>
          </div>
        @endif
        <span class="book-stok {{ $b->stok>0?'sb-ada':'sb-habis' }}">
          {{ $b->stok>0 ? 'Tersedia' : 'Habis' }}
        </span>
      </div>
      <div class="book-body">
        <div class="book-cat">{{ $b->kategori }}</div>
        <div class="book-title">{{ $b->judul }}</div>
        <div class="book-author"><i class="bi bi-person" style="font-size:.67rem"></i> {{ $b->pengarang }}</div>
        <div class="book-footer">
          <span style="font-size:.71rem;color:var(--tx-3)">
            Stok: <strong style="{{ $b->stok===0?'color:var(--red-500)':'' }}">{{ $b->stok }}</strong>
          </span>
          @if($b->stok > 0)
          <form method="POST" action="{{ route('siswa.peminjaman.store') }}"
                onsubmit="return confirm('Pinjam buku ini?\nBatas pengembalian 7 hari.')">
            @csrf
            <input type="hidden" name="buku_id" value="{{ $b->id }}">
            <button class="btn btn-primary btn-xs"><i class="bi bi-book"></i> Pinjam</button>
          </form>
          @else
          <button class="btn btn-xs" disabled
                  style="background:var(--surface-2);color:var(--tx-4);border:1.5px solid var(--border);cursor:not-allowed">
            Habis
          </button>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>

  @if($buku->hasPages())
  <div style="margin-top: 32px; padding-top: 28px; border-top: 2px solid rgba(237,27,59,0.1)">
    {{ $buku->links() }}
  </div>
  @endif
  @endif
</div>
@endsection

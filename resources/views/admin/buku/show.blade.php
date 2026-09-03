@extends('layouts.app')
@section('title','Detail Buku')
@section('page-title','Detail Buku')
@section('content')
<style>
.detail-book-page {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.back-btn-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  background: linear-gradient(135deg, rgba(237,27,59,0.08) 0%, rgba(237,27,59,0.02) 100%);
  border: 1.5px solid rgba(237,27,59,0.2);
  border-radius: 12px;
  color: #ED1B3B;
  font-weight: 600;
  font-size: 0.875rem;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  margin-bottom: 24px;
}
.back-btn-modern:hover {
  background: linear-gradient(135deg, rgba(237,27,59,0.15) 0%, rgba(237,27,59,0.05) 100%);
  border-color: rgba(237,27,59,0.4);
  transform: translateX(-4px);
  box-shadow: 0 4px 12px rgba(237,27,59,0.15);
}
.book-cover-section {
  position: sticky;
  top: 90px;
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
  border-radius: 24px;
  padding: 28px;
  box-shadow: 0 8px 32px rgba(20,40,75,0.08),
              0 2px 8px rgba(20,40,75,0.04);
  border: 1px solid rgba(20,40,75,0.06);
}
.cover-wrapper-modern {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(237,27,59,0.2),
              0 8px 24px rgba(20,40,75,0.15);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  background: linear-gradient(145deg, #ffffff 0%, #f1f1f1 100%);
}
.cover-wrapper-modern:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 28px 80px rgba(237,27,59,0.25),
              0 12px 32px rgba(20,40,75,0.2);
}
.cover-wrapper-modern img {
  width: 100%;
  height: auto;
  aspect-ratio: 2/3;
  object-fit: cover;
  display: block;
}
.cover-placeholder-modern {
  width: 100%;
  aspect-ratio: 2/3;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #14284B 0%, #0B1730 100%);
  padding: 24px;
  gap: 16px;
}
.cover-placeholder-modern i {
  font-size: 64px;
  color: rgba(237,27,59,0.9);
  filter: drop-shadow(0 4px 12px rgba(237,27,59,0.4));
}
.cover-placeholder-modern .title {
  font-size: 1rem;
  font-weight: 700;
  color: white;
  text-align: center;
  line-height: 1.4;
}
.cover-placeholder-modern .author {
  font-size: 0.85rem;
  color: rgba(255,255,255,0.7);
  text-align: center;
}
.stock-badge-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 20px;
  border-radius: 12px;
  font-size: 0.875rem;
  font-weight: 700;
  margin-top: 20px;
  width: 100%;
  justify-content: center;
  background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(22,163,74,0.3);
}
.stock-badge-modern.habis {
  background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
  box-shadow: 0 4px 12px rgba(220,38,38,0.3);
}
.action-buttons-modern {
  display: flex;
  gap: 12px;
  margin-top: 20px;
}
.btn-edit-modern {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 14px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.9rem;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(237,27,59,0.3);
}
.btn-edit-modern:hover {
  background: linear-gradient(135deg, #C41630 0%, #A01228 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(237,27,59,0.4);
  color: white;
}
.btn-delete-modern {
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, rgba(220,38,38,0.1) 0%, rgba(220,38,38,0.05) 100%);
  border: 1.5px solid rgba(220,38,38,0.3);
  border-radius: 12px;
  color: #dc2626;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s ease;
}
.btn-delete-modern:hover {
  background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
  color: white;
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(220,38,38,0.3);
}
.info-card-modern {
  background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
  border-radius: 20px;
  padding: 24px;
  box-shadow: 0 8px 32px rgba(20,40,75,0.08),
              0 2px 8px rgba(20,40,75,0.04);
  border: 1px solid rgba(20,40,75,0.06);
}
.category-badge-modern {
  display: inline-flex;
  align-items: center;
  padding: 8px 16px;
  background: linear-gradient(135deg, rgba(237,27,59,0.12) 0%, rgba(237,27,59,0.06) 100%);
  border: 1.5px solid rgba(237,27,59,0.2);
  border-radius: 10px;
  color: #ED1B3B;
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  margin-bottom: 20px;
}
.book-title-modern {
  font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
  font-weight: 800;
  font-size: 1.5rem;
  color: #14284B;
  line-height: 1.2;
  margin-bottom: 12px;
  background: linear-gradient(135deg, #14284B 0%, #ED1B3B 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.book-author-modern {
  font-size: 1.1rem;
  color: #64748b;
  margin-bottom: 32px;
}
.book-author-modern strong {
  color: #14284B;
  font-weight: 700;
}
.info-grid-modern {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  margin-bottom: 32px;
}
.info-item-modern {
  background: linear-gradient(135deg, rgba(237,27,59,0.04) 0%, rgba(237,27,59,0.01) 100%);
  border-radius: 16px;
  padding: 20px;
  border: 1.5px solid rgba(237,27,59,0.1);
  transition: all 0.3s ease;
}
.info-item-modern:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(237,27,59,0.12);
  border-color: rgba(237,27,59,0.3);
}
.info-label-modern {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 10px;
}
.info-label-modern i {
  color: #ED1B3B;
  font-size: 1rem;
}
.info-value-modern {
  font-size: 1.05rem;
  font-weight: 700;
  color: #14284B;
}
.info-value-modern code {
  background: linear-gradient(135deg, rgba(237,27,59,0.08) 0%, rgba(237,27,59,0.02) 100%);
  padding: 8px 14px;
  border-radius: 8px;
  font-family: 'Courier New', monospace;
  font-size: 1rem;
  color: #ED1B3B;
  border: 1px solid rgba(237,27,59,0.2);
  letter-spacing: 1px;
}
.description-section-modern {
  margin-top: 24px;
  padding-top: 24px;
  border-top: 2px solid rgba(237,27,59,0.1);
}
.description-title-modern {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 0.8rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #ED1B3B;
  margin-bottom: 16px;
}
.description-title-modern i {
  font-size: 1rem;
}
.description-text-modern {
  font-size: 1rem;
  line-height: 1.8;
  color: #475569;
  text-align: justify;
}
</style>

<div class="detail-book-page">
  <a href="{{ route('admin.buku.index') }}" class="back-btn-modern">
    <i class="bi bi-arrow-left"></i>
    <span>Kembali ke Daftar Buku</span>
  </a>

  <div class="row g-4">
    <div class="col-lg-4 col-md-5">
      <div class="book-cover-section">
        <div class="cover-wrapper-modern">
          @if($buku->cover)
            <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}">
          @else
            <div class="cover-placeholder-modern">
              <i class="bi bi-book-fill"></i>
              <span class="title">{{ $buku->judul }}</span>
              <span class="author">{{ $buku->pengarang }}</span>
            </div>
          @endif
        </div>

        <div class="stock-badge-modern {{ $buku->stok > 0 ? '' : 'habis' }}">
          @if($buku->stok > 0)
            <i class="bi bi-check-circle-fill"></i>
            <span>Stok Tersedia: {{ $buku->stok }}</span>
          @else
            <i class="bi bi-x-circle-fill"></i>
            <span>Stok Habis</span>
          @endif
        </div>

        <div class="action-buttons-modern">
          <a href="{{ route('admin.buku.edit', $buku) }}" class="btn-edit-modern">
            <i class="bi bi-pencil-square"></i>
            <span>Edit Buku</span>
          </a>
          <form method="POST" action="{{ route('admin.buku.destroy', $buku) }}" onsubmit="return confirm('Yakin ingin menghapus buku ini?')" style="margin:0">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete-modern">
              <i class="bi bi-trash3"></i>
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-8 col-md-7">
      <div class="info-card-modern">
        <span class="category-badge-modern">
          <i class="bi bi-tag-fill me-1"></i>
          {{ $buku->kategori }}
        </span>

        <h1 class="book-title-modern">{{ $buku->judul }}</h1>
        <p class="book-author-modern">oleh <strong>{{ $buku->pengarang }}</strong></p>

        <div class="info-grid-modern">
          <div class="info-item-modern">
            <div class="info-label-modern">
              <i class="bi bi-upc-scan"></i>
              <span>Kode Buku</span>
            </div>
            <div class="info-value-modern">
              <code>{{ $buku->kode_buku }}</code>
            </div>
          </div>

          <div class="info-item-modern">
            <div class="info-label-modern">
              <i class="bi bi-building"></i>
              <span>Penerbit</span>
            </div>
            <div class="info-value-modern">{{ $buku->penerbit }}</div>
          </div>

          <div class="info-item-modern">
            <div class="info-label-modern">
              <i class="bi bi-calendar-event"></i>
              <span>Tahun Terbit</span>
            </div>
            <div class="info-value-modern">{{ $buku->tahun_terbit }}</div>
          </div>

          <div class="info-item-modern">
            <div class="info-label-modern">
              <i class="bi bi-box-seam"></i>
              <span>Stok Tersedia</span>
            </div>
            <div class="info-value-modern">{{ $buku->stok }} Buku</div>
          </div>
        </div>

        @if($buku->deskripsi)
        <div class="description-section-modern">
          <div class="description-title-modern">
            <i class="bi bi-journal-text"></i>
            <span>Deskripsi Buku</span>
          </div>
          <p class="description-text-modern">{{ $buku->deskripsi }}</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

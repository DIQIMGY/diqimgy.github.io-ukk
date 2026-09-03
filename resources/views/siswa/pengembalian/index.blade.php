@extends('layouts.app')
@section('title','Pengembalian Buku')
@section('page-title','Pengembalian Buku')
@section('content')
<style>
.return-page-modern {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.info-banner-modern {
  background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
  border: 2px solid #93c5fd;
  border-radius: 16px;
  padding: 18px 24px;
  margin-bottom: 28px;
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 0.95rem;
  color: #1e40af;
  font-weight: 600;
}
.info-banner-modern i {
  font-size: 1.3rem;
  color: #2563eb;
  flex-shrink: 0;
}
.return-card-modern {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(20,40,75,0.08);
  border: 2px solid rgba(20,40,75,0.06);
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}
.return-card-modern:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(20,40,75,0.12);
}
.return-card-modern.late {
  border-top: 4px solid #dc2626;
}
.return-card-modern.active {
  border-top: 4px solid #3b82f6;
}
.return-card-header {
  padding: 20px 24px;
  border-bottom: 2px solid rgba(20,40,75,0.06);
}
.status-badge-return {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  margin-bottom: 12px;
}
.status-badge-return.late {
  background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
  color: #dc2626;
  border: 1px solid #fecaca;
}
.status-badge-return.active {
  background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
  color: #2563eb;
  border: 1px solid #93c5fd;
}
.book-title-return {
  font-size: 1.05rem;
  font-weight: 800;
  color: #14284B;
  line-height: 1.4;
  margin-bottom: 8px;
}
.book-author-return {
  font-size: 0.85rem;
  color: #64748b;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 6px;
}
.return-card-body {
  padding: 20px 24px;
  flex: 1;
}
.dates-grid-modern {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 16px;
}
.date-box-modern {
  background: linear-gradient(135deg, rgba(237,27,59,0.04) 0%, rgba(237,27,59,0.01) 100%);
  border: 1.5px solid rgba(237,27,59,0.1);
  border-radius: 12px;
  padding: 14px;
}
.date-box-modern.late {
  background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
  border-color: #fecaca;
}
.date-box-modern label {
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  display: block;
  margin-bottom: 6px;
}
.date-box-modern p {
  font-size: 0.95rem;
  font-weight: 700;
  color: #14284B;
  margin: 0;
}
.date-box-modern.late p {
  color: #dc2626;
}
.fine-alert-modern {
  background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
  border: 2px solid #fca5a5;
  border-radius: 12px;
  padding: 14px 16px;
  display: flex;
  align-items: start;
  gap: 12px;
}
.fine-alert-modern i {
  color: #dc2626;
  font-size: 1.2rem;
  flex-shrink: 0;
  margin-top: 2px;
}
.fine-alert-content {
  flex: 1;
}
.fine-alert-content .title {
  font-size: 0.85rem;
  font-weight: 800;
  color: #dc2626;
  margin-bottom: 4px;
}
.fine-alert-content .amount {
  font-size: 0.8rem;
  color: #991b1b;
  font-weight: 600;
}
.fine-alert-content .amount strong {
  font-weight: 800;
  font-size: 0.95rem;
}
.return-card-footer {
  padding: 20px 24px;
  border-top: 2px solid rgba(20,40,75,0.06);
}
.btn-return-modern {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 14px;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.95rem;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.btn-return-modern.success {
  background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
  color: white;
}
.btn-return-modern.success:hover {
  background: linear-gradient(135deg, #15803d 0%, #166534 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(22,163,74,0.3);
  color: white;
}
.btn-return-modern.danger {
  background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
  color: white;
}
.btn-return-modern.danger:hover {
  background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(220,38,38,0.3);
  color: white;
}
.btn-add-modern {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 14px 24px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.95rem;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(237,27,59,0.3);
}
.btn-add-modern:hover {
  background: linear-gradient(135deg, #C41630 0%, #A01228 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(237,27,59,0.4);
  color: white;
}
.empty-state-success {
  text-align: center;
  padding: 80px 20px;
}
.empty-state-success i {
  font-size: 5rem;
  color: #16a34a;
  margin-bottom: 20px;
  filter: drop-shadow(0 4px 12px rgba(22,163,74,0.2));
}
.empty-state-success h6 {
  font-size: 1.3rem;
  font-weight: 800;
  color: #16a34a;
  margin-bottom: 10px;
}
.empty-state-success p {
  color: #64748b;
  font-size: 1rem;
  margin-bottom: 28px;
}
</style>

<div class="return-page-modern">
  @if($peminjaman->isEmpty())
  <div class="empty-state-success">
    <i class="bi bi-check-circle-fill"></i>
    <h6>Semua Buku Sudah Dikembalikan!</h6>
    <p>Tidak ada buku yang perlu dikembalikan saat ini</p>
    <a href="{{ route('siswa.peminjaman.create') }}" class="btn-add-modern">
      <i class="bi bi-book-fill"></i>
      <span>Pinjam Buku Sekarang</span>
    </a>
  </div>
  @else

  <div class="info-banner-modern">
    <i class="bi bi-info-circle-fill"></i>
    <span>Pilih buku yang ingin dikembalikan. Denda keterlambatan dihitung <strong>Rp 1.000 per hari</strong>.</span>
  </div>

  <div class="row g-4">
    @foreach($peminjaman as $p)
    @php $late = ($p->status === 'terlambat'); @endphp
    <div class="col-md-6 col-lg-4">
      <div class="return-card-modern {{ $late ? 'late' : 'active' }}">
        
        <div class="return-card-header">
          <span class="status-badge-return {{ $late ? 'late' : 'active' }}">
            @if($late)
              <i class="bi bi-exclamation-triangle-fill"></i>
              <span>Terlambat</span>
            @else
              <i class="bi bi-circle-fill"></i>
              <span>Dipinjam</span>
            @endif
          </span>
          <div style="display:flex;align-items:start;gap:12px;margin-top:12px">
            @if($p->buku && $p->buku->cover)
              <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" 
                   style="width:50px;height:75px;object-fit:cover;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.15);flex-shrink:0;">
            @else
              <div style="width:50px;height:75px;border-radius:8px;background:linear-gradient(135deg,#881337,#e11d48);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,.15)">
                <i class="bi bi-book-fill" style="color:rgba(255,255,255,.8);font-size:1.5rem"></i>
              </div>
            @endif
            <div style="flex:1;min-width:0">
              <h6 class="book-title-return">{{ Str::limit($p->buku->judul??'-', 40) }}</h6>
              <div class="book-author-return">
                <i class="bi bi-person-fill"></i>
                <span>{{ $p->buku->pengarang??'' }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="return-card-body">
          <div class="dates-grid-modern">
            <div class="date-box-modern">
              <label>Tgl Pinjam</label>
              <p>{{ $p->tanggal_pinjam->format('d M Y') }}</p>
            </div>
            <div class="date-box-modern {{ $late ? 'late' : '' }}">
              <label>Batas Kembali</label>
              <p>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</p>
            </div>
          </div>

          @if($late)
          @php
            $hari  = $p->tanggal_kembali_rencana->diffInDays(\Carbon\Carbon::today());
            $denda = $hari * 1000;
          @endphp
          <div class="fine-alert-modern">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div class="fine-alert-content">
              <div class="title">Terlambat {{ $hari }} hari</div>
              <div class="amount">Estimasi denda: <strong>Rp {{ number_format($denda,0,',','.') }}</strong></div>
            </div>
          </div>
          @endif
        </div>

        <div class="return-card-footer">
          <a href="{{ route('siswa.pengembalian.konfirmasi', $p) }}"
             class="btn-return-modern {{ $late ? 'danger' : 'success' }}">
            <i class="bi bi-box-arrow-in-left"></i>
            <span>{{ $late ? 'Kembalikan (Ada Denda)' : 'Kembalikan Buku' }}</span>
          </a>
        </div>

      </div>
    </div>
    @endforeach
  </div>

  @if($peminjaman->hasPages())
  <div style="margin-top: 32px; padding-top: 28px; border-top: 2px solid rgba(237,27,59,0.1); display: flex; justify-content: center;">
    {{ $peminjaman->links() }}
  </div>
  @endif
  @endif
</div>
@endsection

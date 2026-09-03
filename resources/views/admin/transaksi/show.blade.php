@extends('layouts.app')
@section('title','Detail Transaksi')
@section('page-title','Detail Transaksi')
@section('content')
<style>
.detail-transaction-page {
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
  transition: all 0.3s ease;
  margin-bottom: 24px;
}
.back-btn-modern:hover {
  background: linear-gradient(135deg, rgba(237,27,59,0.15) 0%, rgba(237,27,59,0.05) 100%);
  border-color: rgba(237,27,59,0.4);
  transform: translateX(-4px);
  box-shadow: 0 4px 12px rgba(237,27,59,0.15);
}
.transaction-card-modern {
  background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
  border-radius: 24px;
  padding: 36px;
  box-shadow: 0 8px 32px rgba(20,40,75,0.08),
              0 2px 8px rgba(20,40,75,0.04);
  border: 1px solid rgba(20,40,75,0.06);
}
.transaction-header-modern {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: 32px;
  padding-bottom: 24px;
  border-bottom: 2px solid rgba(237,27,59,0.1);
  flex-wrap: wrap;
  gap: 16px;
}
.transaction-code-section {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.code-label {
  font-size: 0.7rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #64748b;
}
.code-value {
  display: inline-flex;
  padding: 10px 18px;
  background: linear-gradient(135deg, rgba(20,40,75,0.1) 0%, rgba(20,40,75,0.05) 100%);
  border: 2px solid rgba(20,40,75,0.15);
  border-radius: 12px;
  font-family: 'Courier New', monospace;
  font-size: 1.1rem;
  font-weight: 700;
  color: #14284B;
}
.status-badge-large {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  border-radius: 12px;
  font-size: 0.9rem;
  font-weight: 700;
}
.status-badge-large.dipinjam {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(59,130,246,0.3);
}
.status-badge-large.terlambat {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(245,158,11,0.3);
}
.status-badge-large.dikembalikan {
  background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(22,163,74,0.3);
}
.info-section-modern {
  background: linear-gradient(135deg, rgba(237,27,59,0.04) 0%, rgba(237,27,59,0.01) 100%);
  border-radius: 16px;
  padding: 24px;
  border: 1.5px solid rgba(237,27,59,0.1);
  margin-bottom: 24px;
  transition: all 0.3s ease;
}
.info-section-modern:hover {
  border-color: rgba(237,27,59,0.2);
  box-shadow: 0 4px 16px rgba(237,27,59,0.08);
}
.section-label {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.7rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #64748b;
  margin-bottom: 16px;
}
.section-label i {
  color: #ED1B3B;
  font-size: 1rem;
}
.member-info-content {
  display: flex;
  align-items: center;
  gap: 16px;
}
.avatar-circle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
  font-weight: 800;
  color: white;
  box-shadow: 0 4px 12px rgba(237,27,59,0.3);
  flex-shrink: 0;
}
.member-details {
  flex: 1;
}
.member-name {
  font-size: 1.1rem;
  font-weight: 800;
  color: #14284B;
  margin-bottom: 4px;
}
.member-meta {
  font-size: 0.85rem;
  color: #64748b;
  font-weight: 600;
}
.book-info-content {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.book-title {
  font-size: 1.1rem;
  font-weight: 800;
  color: #14284B;
  line-height: 1.4;
}
.book-meta {
  font-size: 0.85rem;
  color: #64748b;
  font-weight: 600;
}
.details-grid-modern {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}
.detail-item-modern {
  background: white;
  border-radius: 12px;
  padding: 18px;
  border: 2px solid rgba(20,40,75,0.08);
  transition: all 0.3s ease;
}
.detail-item-modern:hover {
  border-color: rgba(237,27,59,0.2);
  transform: translateY(-2px);
}
.detail-item-modern.warning {
  background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
  border-color: #fecdd3;
}
.detail-label {
  font-size: 0.75rem;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 8px;
}
.detail-value {
  font-size: 1rem;
  font-weight: 700;
  color: #14284B;
}
.detail-value.danger {
  color: #dc2626;
}
.return-action-modern {
  background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
  border: 2px solid #bbf7d0;
  border-radius: 16px;
  padding: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
}
.return-action-info h4 {
  font-size: 1.1rem;
  font-weight: 800;
  color: #15803d;
  margin: 0 0 6px 0;
}
.return-action-info p {
  font-size: 0.9rem;
  color: #16a34a;
  margin: 0;
  font-weight: 600;
}
.btn-return-modern {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 14px 28px;
  background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(22,163,74,0.3);
}
.btn-return-modern:hover {
  background: linear-gradient(135deg, #15803d 0%, #166534 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(22,163,74,0.4);
}
</style>

<div class="detail-transaction-page">
  <a href="{{ route('admin.transaksi.index') }}" class="back-btn-modern">
    <i class="bi bi-arrow-left"></i>
    <span>Kembali ke Daftar Transaksi</span>
  </a>

  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">
      <div class="transaction-card-modern">
        <div class="transaction-header-modern">
          <div class="transaction-code-section">
            <span class="code-label">Kode Transaksi</span>
            <span class="code-value">{{ $transaksi->kode_pinjam }}</span>
          </div>

          @if($transaksi->status === 'dipinjam')
            <span class="status-badge-large dipinjam">
              <i class="bi bi-circle-fill"></i>
              <span>Dipinjam</span>
            </span>
          @elseif($transaksi->status === 'terlambat')
            <span class="status-badge-large terlambat">
              <i class="bi bi-exclamation-circle-fill"></i>
              <span>Terlambat</span>
            </span>
          @else
            <span class="status-badge-large dikembalikan">
              <i class="bi bi-check-circle-fill"></i>
              <span>Dikembalikan</span>
            </span>
          @endif
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="info-section-modern">
              <div class="section-label">
                <i class="bi bi-person-fill"></i>
                <span>Peminjam</span>
              </div>
              <div class="member-info-content">
                @if($transaksi->anggota && $transaksi->anggota->foto)
                  <img src="{{ Storage::url($transaksi->anggota->foto) }}" alt="{{ $transaksi->anggota->nama }}" 
                       class="avatar-circle" style="object-fit: cover;">
                @else
                  <div class="avatar-circle">
                    {{ strtoupper(substr($transaksi->anggota->nama, 0, 1)) }}
                  </div>
                @endif
                <div class="member-details">
                  <div class="member-name">{{ $transaksi->anggota->nama }}</div>
                  <div class="member-meta">{{ $transaksi->anggota->nis }} · {{ $transaksi->anggota->kelas }}</div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="info-section-modern">
              <div class="section-label">
                <i class="bi bi-book-fill"></i>
                <span>Buku Dipinjam</span>
              </div>
              <div class="book-info-content">
                <div style="display:flex;align-items:start;gap:14px;margin-bottom:12px">
                  @if($transaksi->buku && $transaksi->buku->cover)
                    <img src="{{ Storage::url($transaksi->buku->cover) }}" alt="{{ $transaksi->buku->judul }}" 
                         style="width:60px;height:90px;object-fit:cover;border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,.2);flex-shrink:0;">
                  @else
                    <div style="width:60px;height:90px;border-radius:10px;background:linear-gradient(135deg,#064e3b,#059669);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 6px 20px rgba(0,0,0,.2)">
                      <i class="bi bi-book-fill" style="color:rgba(255,255,255,.8);font-size:1.8rem"></i>
                    </div>
                  @endif
                  <div style="flex:1;min-width:0">
                    <div class="book-title">{{ $transaksi->buku->judul }}</div>
                    <div class="book-meta">{{ $transaksi->buku->kode_buku }} · {{ $transaksi->buku->pengarang }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="details-grid-modern">
          <div class="detail-item-modern">
            <div class="detail-label">Tanggal Pinjam</div>
            <div class="detail-value">{{ $transaksi->tanggal_pinjam->format('d F Y') }}</div>
          </div>

          <div class="detail-item-modern {{ $transaksi->status === 'terlambat' ? 'warning' : '' }}">
            <div class="detail-label">Batas Kembali</div>
            <div class="detail-value {{ $transaksi->status === 'terlambat' ? 'danger' : '' }}">
              {{ $transaksi->tanggal_kembali_rencana->format('d F Y') }}
            </div>
          </div>

          <div class="detail-item-modern">
            <div class="detail-label">Tanggal Dikembalikan</div>
            <div class="detail-value">
              {{ $transaksi->tanggal_kembali_aktual ? $transaksi->tanggal_kembali_aktual->format('d F Y') : 'Belum dikembalikan' }}
            </div>
          </div>

          <div class="detail-item-modern {{ $transaksi->denda > 0 ? 'warning' : '' }}">
            <div class="detail-label">Denda</div>
            <div class="detail-value {{ $transaksi->denda > 0 ? 'danger' : '' }}">
              {{ $transaksi->denda > 0 ? 'Rp ' . number_format($transaksi->denda, 0, ',', '.') : 'Tidak ada denda' }}
            </div>
          </div>
        </div>

        @if(in_array($transaksi->status, ['dipinjam', 'terlambat']))
        <div class="return-action-modern">
          <div class="return-action-info">
            <h4>Proses Pengembalian Buku</h4>
            <p>Klik tombol untuk menyelesaikan peminjaman ini</p>
          </div>
          <form method="POST" action="{{ route('admin.transaksi.kembali', $transaksi) }}" onsubmit="return confirm('Yakin ingin memproses pengembalian buku ini?')" style="margin: 0">
            @csrf
            <button type="submit" class="btn-return-modern">
              <i class="bi bi-box-arrow-in-left"></i>
              <span>Kembalikan Sekarang</span>
            </button>
          </form>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

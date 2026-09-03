@extends('layouts.app')
@section('title','Riwayat Peminjaman')
@section('page-title','Riwayat Peminjaman')
@section('content')
<style>
.history-page-modern {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.toolbar-modern {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 24px;
  padding: 20px;
  background: linear-gradient(135deg, rgba(237,27,59,0.04) 0%, rgba(237,27,59,0.01) 100%);
  border-radius: 16px;
  border: 1.5px solid rgba(237,27,59,0.1);
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
.filter-group {
  display: flex;
  gap: 10px;
  align-items: center;
}
.filter-select {
  padding: 12px 16px;
  border: 2px solid rgba(20,40,75,0.12);
  border-radius: 10px;
  font-size: 0.9rem;
  color: #14284B;
  background: white;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 180px;
}
.filter-select:focus {
  outline: none;
  border-color: #ED1B3B;
  box-shadow: 0 0 0 4px rgba(237,27,59,0.1);
}
.btn-filter {
  padding: 12px 16px;
  background: white;
  border: 2px solid rgba(20,40,75,0.12);
  border-radius: 10px;
  color: #14284B;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s ease;
}
.btn-filter:hover {
  background: #ED1B3B;
  border-color: #ED1B3B;
  color: white;
}
.history-card-modern {
  background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
  border-radius: 24px;
  padding: 32px;
  box-shadow: 0 8px 32px rgba(20,40,75,0.08),
              0 2px 8px rgba(20,40,75,0.04);
  border: 1px solid rgba(20,40,75,0.06);
}
.card-header-modern {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 28px;
  padding-bottom: 20px;
  border-bottom: 2px solid rgba(237,27,59,0.1);
}
.card-title-modern {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1.3rem;
  font-weight: 800;
  color: #14284B;
  margin: 0;
}
.card-title-modern i {
  color: #ED1B3B;
  font-size: 1.5rem;
}
.count-badge-modern {
  padding: 8px 18px;
  background: linear-gradient(135deg, rgba(237,27,59,0.12) 0%, rgba(237,27,59,0.06) 100%);
  border: 1.5px solid rgba(237,27,59,0.2);
  border-radius: 10px;
  color: #ED1B3B;
  font-size: 0.875rem;
  font-weight: 700;
}
.transaction-list-modern {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.transaction-item-modern {
  background: white;
  border-radius: 16px;
  padding: 24px;
  border: 2px solid rgba(20,40,75,0.06);
  transition: all 0.3s ease;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 20px;
  align-items: start;
}
.transaction-item-modern:hover {
  border-color: rgba(237,27,59,0.2);
  box-shadow: 0 4px 16px rgba(237,27,59,0.08);
  transform: translateY(-2px);
}
.trx-main {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.trx-book {
  font-size: 1.1rem;
  font-weight: 800;
  color: #14284B;
  line-height: 1.3;
}
.trx-dates {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 12px;
  font-size: 0.85rem;
}
.trx-date-item {
  color: #64748b;
}
.trx-date-item strong {
  display: block;
  color: #14284B;
  font-weight: 700;
  margin-top: 4px;
}
.trx-date-item.late strong {
  color: #dc2626;
}
.trx-side {
  display: flex;
  flex-direction: column;
  gap: 12px;
  align-items: flex-end;
}
.status-badge-trx {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 10px;
  font-size: 0.8rem;
  font-weight: 700;
  white-space: nowrap;
}
.status-badge-trx.dipinjam {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(59,130,246,0.3);
}
.status-badge-trx.terlambat {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(245,158,11,0.3);
}
.status-badge-trx.dikembalikan {
  background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(22,163,74,0.3);
}
.trx-denda {
  font-size: 0.95rem;
  font-weight: 700;
}
.trx-denda.has {
  color: #dc2626;
}
.trx-denda.none {
  color: #94a3b8;
}
.empty-state-modern {
  text-align: center;
  padding: 80px 20px;
}
.empty-state-modern i {
  font-size: 5rem;
  color: #cbd5e1;
  margin-bottom: 20px;
}
.empty-state-modern h6 {
  font-size: 1.2rem;
  font-weight: 800;
  color: #14284B;
  margin-bottom: 10px;
}
.empty-state-modern p {
  color: #64748b;
  margin-bottom: 24px;
}
@media (max-width: 768px) {
  .transaction-item-modern {
    grid-template-columns: 1fr;
  }
  .trx-side {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
}
</style>

<div class="history-page-modern">
  <div class="toolbar-modern">
    <a href="{{ route('siswa.peminjaman.create') }}" class="btn-add-modern">
      <i class="bi bi-plus-circle-fill"></i>
      <span>Pinjam Buku Baru</span>
    </a>
    <form method="GET" class="filter-group">
      <select name="status" class="filter-select">
        <option value="">Semua Status</option>
        <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
      </select>
      <button type="submit" class="btn-filter">
        <i class="bi bi-funnel-fill"></i>
      </button>
    </form>
  </div>

  <div class="history-card-modern">
    <div class="card-header-modern">
      <h3 class="card-title-modern">
        <i class="bi bi-clock-history"></i>
        <span>Riwayat Peminjaman Saya</span>
      </h3>
      <span class="count-badge-modern">{{ $peminjaman->total() }} Transaksi</span>
    </div>

    @forelse($peminjaman as $p)
      <div class="transaction-list-modern">
        <div class="transaction-item-modern">
          <div class="trx-main">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
              @if($p->buku && $p->buku->cover)
                <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" 
                     style="width:44px;height:66px;object-fit:cover;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.15);flex-shrink:0;">
              @else
                <div style="width:44px;height:66px;border-radius:8px;background:linear-gradient(135deg,#0f1f3d,#1e4080);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,.15)">
                  <i class="bi bi-book-fill" style="color:rgba(255,255,255,.7);font-size:1.3rem"></i>
                </div>
              @endif
              <div class="trx-book">{{ $p->buku->judul ?? '-' }}</div>
            </div>
            <div class="trx-dates">
              <div class="trx-date-item">
                <i class="bi bi-calendar-check"></i> Tanggal Pinjam
                <strong>{{ $p->tanggal_pinjam->format('d M Y') }}</strong>
              </div>
              <div class="trx-date-item {{ $p->status === 'terlambat' ? 'late' : '' }}">
                <i class="bi bi-calendar-x"></i> Batas Kembali
                <strong>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</strong>
              </div>
              <div class="trx-date-item">
                <i class="bi bi-calendar-check-fill"></i> Tgl Kembali
                <strong>{{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d M Y') : 'Belum dikembalikan' }}</strong>
              </div>
            </div>
          </div>
          <div class="trx-side">
            @if($p->status === 'dipinjam')
              <span class="status-badge-trx dipinjam">
                <i class="bi bi-circle-fill"></i>
                <span>Dipinjam</span>
              </span>
            @elseif($p->status === 'terlambat')
              <span class="status-badge-trx terlambat">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>Terlambat</span>
              </span>
            @else
              <span class="status-badge-trx dikembalikan">
                <i class="bi bi-check-circle-fill"></i>
                <span>Dikembalikan</span>
              </span>
            @endif
            <span class="trx-denda {{ $p->denda > 0 ? 'has' : 'none' }}">
              {{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : 'Tidak ada denda' }}
            </span>
          </div>
        </div>
      </div>
    @empty
      <div class="empty-state-modern">
        <i class="bi bi-inbox"></i>
        <h6>Belum Ada Riwayat Peminjaman</h6>
        <p>Mulai pinjam buku dari koleksi perpustakaan kami</p>
        <a href="{{ route('siswa.peminjaman.create') }}" class="btn-add-modern">
          <i class="bi bi-book-fill"></i>
          <span>Mulai Pinjam Buku</span>
        </a>
      </div>
    @endforelse

    @if($peminjaman->hasPages())
      <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid rgba(237,27,59,0.1)">
        {{ $peminjaman->links() }}
      </div>
    @endif
  </div>
</div>
@endsection

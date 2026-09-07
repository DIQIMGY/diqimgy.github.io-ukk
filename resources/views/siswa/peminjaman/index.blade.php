@extends('layouts.app')
@section('title','Riwayat Peminjaman')
@section('page-title','Riwayat Peminjaman')
@section('content')
<style>
.history-page-modern {
  animation: fadeInUp 0.5s ease;
  max-width:1180px;
  margin:0 auto;
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
  background:linear-gradient(110deg,#fff 0%,#fff 68%,#fff7f8 100%);
  border-radius: 16px;
  border:1px solid rgba(20,40,75,.08);
  box-shadow:0 8px 24px rgba(20,40,75,.06);
  position:relative;
  overflow:hidden;
}
.toolbar-modern::before {
  content:'';
  position:absolute;
  left:0;
  top:0;
  bottom:0;
  width:4px;
  background:linear-gradient(180deg,var(--crimson),#f59e0b);
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
  border-radius:18px;
  padding:28px;
  box-shadow: 0 8px 32px rgba(20,40,75,0.08),
              0 2px 8px rgba(20,40,75,0.04);
  border:1px solid rgba(20,40,75,.08);
}
.card-header-modern {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom:22px;
  padding-bottom:16px;
  border-bottom:1px solid rgba(20,40,75,.09);
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
  gap:12px;
}
.transaction-item-modern {
  background:linear-gradient(110deg,#fff 0%,#fff 78%,#f8fafc 100%);
  border-radius:14px;
  padding:20px;
  border:1px solid rgba(20,40,75,.08);
  border-left:4px solid #cbd5e1;
  transition: all 0.3s ease;
  display: grid;
  grid-template-columns: 1fr auto;
  gap: 20px;
  align-items: start;
}
.transaction-item-modern:hover {
  border-color:rgba(237,27,59,.2);
  border-left-color:var(--crimson);
  box-shadow: 0 4px 16px rgba(237,27,59,0.08);
  transform: translateY(-2px);
}
.trx-main {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.transaction-item-modern:has(.status-badge-trx.dipinjam) { border-left-color:#3b82f6; }
.transaction-item-modern:has(.status-badge-trx.terlambat) { border-left-color:#f59e0b; }
.transaction-item-modern:has(.status-badge-trx.dikembalikan) { border-left-color:#16a34a; }
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

.transaction-item-modern { animation:transactionIn .4s var(--ease) both; }
.transaction-item-modern:nth-child(2n) { animation-delay:.06s; }
@keyframes transactionIn {
  from { opacity:0; transform:translateY(8px); }
  to { opacity:1; transform:translateY(0); }
}

@media (prefers-reduced-motion:reduce) {
  .transaction-item-modern { animation:none; }
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
  .history-card-modern { padding:18px; }
  .card-title-modern { font-size:1.05rem; }
  .count-badge-modern { padding:6px 10px; font-size:.75rem; }
  .transaction-item-modern { padding:16px; }
}

/* Compact library register layout */
.history-page-modern { max-width:1240px; }
.history-card-modern { padding:0; overflow:hidden; border-radius:14px; }
.card-header-modern { margin:0; padding:18px 22px; background:#fff; }
.card-title-modern { font-size:1rem; gap:9px; }
.card-title-modern i { font-size:1.15rem; }
.count-badge-modern { padding:5px 10px; border-radius:7px; font-size:.72rem; }
.transaction-list-modern { display:block; }
.transaction-table-wrap { overflow-x:auto; }
.transaction-table { width:100%; min-width:760px; border-collapse:collapse; }
.transaction-table th {
  padding:11px 18px;
  background:#f8fafc;
  border-top:1px solid #edf1f5;
  border-bottom:1px solid #e7ecf2;
  color:#64748b;
  font-size:.67rem;
  font-weight:800;
  letter-spacing:.08em;
  text-transform:uppercase;
  text-align:left;
  white-space:nowrap;
}
.transaction-table td {
  padding:13px 18px;
  border-bottom:1px solid #eef2f6;
  color:#334155;
  font-size:.78rem;
  vertical-align:middle;
  white-space:nowrap;
}
.transaction-table tbody tr { transition:background .16s; }
.transaction-table tbody tr:hover { background:#fff8f9; }
.transaction-table tbody tr:last-child td { border-bottom:0; }
.table-book { display:flex; align-items:center; gap:11px; min-width:230px; }
.table-book-cover {
  width:34px; height:48px; object-fit:cover; border-radius:5px;
  flex-shrink:0; box-shadow:0 2px 7px rgba(15,23,42,.16);
}
.table-book-placeholder {
  display:flex; align-items:center; justify-content:center;
  background:linear-gradient(145deg,#0f1f3d,#2055a5);
  color:rgba(255,255,255,.75);
}
.table-book-title { max-width:240px; overflow:hidden; text-overflow:ellipsis; font-weight:700; color:#14284b; }
.table-date { color:#64748b; }
.table-date i { color:#94a3b8; margin-right:5px; }
.table-date.late { color:#dc2626; font-weight:700; }
.table-date.late i { color:#dc2626; }
.table-fine { font-weight:700; color:#dc2626; }
.table-fine.none { color:#94a3b8; font-weight:600; }
.table-status { padding:5px 9px; border-radius:6px; font-size:.68rem; }
.table-pagination { display:flex; justify-content:center; padding:18px 22px; border-top:1px solid #edf1f5; }
.table-pagination .pagination { gap:5px; }
.table-pagination .page-link { min-width:32px !important; width:32px; height:32px; padding:0 !important; font-size:.72rem !important; border-radius:7px !important; }
@media(max-width:768px) {
  .toolbar-modern { padding:14px; }
  .toolbar-modern .btn-add-modern { width:100%; justify-content:center; }
  .filter-group { width:100%; }
  .filter-select { flex:1; min-width:0; }
  .table-pagination { justify-content:flex-start; overflow-x:auto; }
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
      @if($loop->first)
      <div class="transaction-table-wrap">
        <table class="transaction-table">
          <thead>
            <tr>
              <th>Buku</th>
              <th>Status</th>
              <th>Tanggal Pinjam</th>
              <th>Batas Kembali</th>
              <th>Dikembalikan</th>
              <th>Denda</th>
            </tr>
          </thead>
          <tbody>
      @endif
            <tr>
              <td>
                <div class="table-book">
                  @if($p->buku && $p->buku->cover)
                    <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" class="table-book-cover">
                  @else
                    <div class="table-book-cover table-book-placeholder"><i class="bi bi-book-fill"></i></div>
                  @endif
                  <span class="table-book-title">{{ $p->buku->judul ?? '-' }}</span>
                </div>
              </td>
              <td>
                @if($p->status === 'dipinjam')
                  <span class="status-badge-trx dipinjam table-status"><i class="bi bi-circle-fill"></i> Dipinjam</span>
                @elseif($p->status === 'terlambat')
                  <span class="status-badge-trx terlambat table-status"><i class="bi bi-exclamation-circle-fill"></i> Terlambat</span>
                @else
                  <span class="status-badge-trx dikembalikan table-status"><i class="bi bi-check-circle-fill"></i> Dikembalikan</span>
                @endif
              </td>
              <td class="table-date"><i class="bi bi-calendar3"></i>{{ $p->tanggal_pinjam->format('d M Y') }}</td>
              <td class="table-date {{ $p->status === 'terlambat' ? 'late' : '' }}"><i class="bi bi-calendar-x"></i>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
              <td class="table-date">{{ $p->tanggal_kembali_aktual ? $p->tanggal_kembali_aktual->format('d M Y') : 'Belum kembali' }}</td>
              <td class="table-fine {{ $p->denda > 0 ? '' : 'none' }}">{{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : 'Tidak ada' }}</td>
            </tr>
      @if($loop->last)
          </tbody>
        </table>
      </div>
      @endif
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
      <div class="table-pagination">
        {{ $peminjaman->links('vendor.pagination.custom-simple') }}
      </div>
    @endif
  </div>
</div>
@include('siswa.partials.rekomendasi-buku')
@endsection

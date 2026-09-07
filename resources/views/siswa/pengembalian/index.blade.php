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

/* Compact circulation desk layout */
.return-page-modern { max-width:1240px; margin:0 auto; }
.info-banner-modern {
  margin-bottom:18px;
  padding:13px 17px;
  border:1px solid #bfdbfe;
  border-radius:10px;
  font-size:.8rem;
  box-shadow:0 3px 12px rgba(37,99,235,.06);
}
.return-table-card { background:#fff; border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; box-shadow:0 5px 18px rgba(20,40,75,.06); }
.return-table-wrap { overflow-x:auto; }
.return-table { width:100%; min-width:820px; border-collapse:collapse; }
.return-table th {
  padding:11px 18px; background:#f8fafc; border-bottom:1px solid #e7ecf2;
  color:#64748b; font-size:.67rem; font-weight:800; letter-spacing:.08em;
  text-transform:uppercase; text-align:left; white-space:nowrap;
}
.return-table td { padding:13px 18px; border-bottom:1px solid #eef2f6; font-size:.78rem; color:#334155; vertical-align:middle; white-space:nowrap; }
.return-table tbody tr { transition:background .16s; }
.return-table tbody tr:hover { background:#fffafa; }
.return-table tbody tr:last-child td { border-bottom:0; }
.return-book { display:flex; align-items:center; gap:11px; min-width:240px; }
.return-book-cover { width:36px; height:50px; object-fit:cover; border-radius:5px; flex-shrink:0; box-shadow:0 2px 7px rgba(15,23,42,.16); }
.return-book-placeholder { display:flex; align-items:center; justify-content:center; background:linear-gradient(145deg,#881337,#e11d48); color:rgba(255,255,255,.8); }
.return-book-title { max-width:250px; overflow:hidden; text-overflow:ellipsis; font-weight:700; color:#14284b; }
.return-author { display:block; margin-top:3px; color:#94a3b8; font-size:.7rem; font-weight:500; overflow:hidden; text-overflow:ellipsis; max-width:240px; }
.return-status { display:inline-flex; align-items:center; gap:5px; padding:5px 9px; border-radius:6px; font-size:.68rem; font-weight:700; }
.return-status.active { background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }
.return-status.late { background:#fff1f2; color:#dc2626; border:1px solid #fecdd3; }
.return-date { color:#64748b; }
.return-date.late { color:#dc2626; font-weight:700; }
.return-fine { color:#dc2626; font-weight:800; }
.return-fine.none { color:#94a3b8; font-weight:600; }
.return-action { display:inline-flex; align-items:center; gap:6px; padding:7px 11px; border-radius:7px; color:#fff; font-size:.7rem; font-weight:700; white-space:nowrap; text-decoration:none; }
.return-action.success { background:#16a34a; box-shadow:0 3px 8px rgba(22,163,74,.2); }
.return-action.danger { background:#dc2626; box-shadow:0 3px 8px rgba(220,38,38,.2); }
.return-action:hover { color:#fff; transform:translateY(-1px); }
.return-pagination { display:flex; justify-content:center; padding:18px 22px; border-top:1px solid #edf1f5; }
.return-pagination .pagination { gap:5px; }
.return-pagination .page-link { min-width:32px !important; width:32px; height:32px; padding:0 !important; font-size:.72rem !important; border-radius:7px !important; }
@media(max-width:768px) {
  .return-page-modern { width:100%; }
  .info-banner-modern { align-items:flex-start; }
  .return-pagination { justify-content:flex-start; overflow-x:auto; }
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

  <div class="return-table-card">
    <div class="return-table-wrap">
      <table class="return-table">
        <thead>
          <tr>
            <th>Buku</th>
            <th>Status</th>
            <th>Tanggal Pinjam</th>
            <th>Batas Kembali</th>
            <th>Denda</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($peminjaman as $p)
          @php
            $late = ($p->status === 'terlambat');
            $hari = $late ? $p->tanggal_kembali_rencana->diffInDays(\Carbon\Carbon::today()) : 0;
            $denda = $hari * 1000;
          @endphp
          <tr>
            <td>
              <div class="return-book">
                @if($p->buku && $p->buku->cover)
                  <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" class="return-book-cover">
                @else
                  <div class="return-book-cover return-book-placeholder"><i class="bi bi-book-fill"></i></div>
                @endif
                <div>
                  <div class="return-book-title">{{ $p->buku->judul ?? '-' }}</div>
                  <span class="return-author"><i class="bi bi-person"></i> {{ $p->buku->pengarang ?? '-' }}</span>
                </div>
              </div>
            </td>
            <td>
              <span class="return-status {{ $late ? 'late' : 'active' }}">
                <i class="bi {{ $late ? 'bi-exclamation-circle-fill' : 'bi-circle-fill' }}"></i>
                {{ $late ? 'Terlambat' : 'Dipinjam' }}
              </span>
            </td>
            <td class="return-date">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
            <td class="return-date {{ $late ? 'late' : '' }}">{{ $p->tanggal_kembali_rencana->format('d M Y') }}</td>
            <td class="return-fine {{ $late ? '' : 'none' }}">{{ $late ? 'Rp ' . number_format($denda, 0, ',', '.') : 'Tidak ada' }}</td>
            <td>
              <a href="{{ route('siswa.pengembalian.konfirmasi', $p) }}" class="return-action {{ $late ? 'danger' : 'success' }}">
                <i class="bi bi-box-arrow-in-left"></i> Kembalikan
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  @if($peminjaman->hasPages())
  <div class="return-pagination">
    {{ $peminjaman->links('vendor.pagination.custom-simple') }}
  </div>
  @endif
  @endif
</div>
@include('siswa.partials.rekomendasi-buku')
@endsection

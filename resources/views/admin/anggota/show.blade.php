@extends('layouts.app')
@section('title','Detail Anggota')
@section('page-title','Detail Anggota')
@section('content')
<style>
.detail-member-page {
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
.profile-card-modern {
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
  border-radius: 24px;
  padding: 32px;
  box-shadow: 0 8px 32px rgba(20,40,75,0.08),
              0 2px 8px rgba(20,40,75,0.04);
  border: 1px solid rgba(20,40,75,0.06);
  text-align: center;
  position: sticky;
  top: 90px;
}
.avatar-modern {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  font-weight: 800;
  color: white;
  margin: 0 auto 18px;
  box-shadow: 0 10px 28px rgba(237,27,59,0.35),
              0 0 0 6px rgba(237,27,59,0.1);
  position: relative;
}
.avatar-modern::after {
  content: '';
  position: absolute;
  inset: -4px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(237,27,59,0.3), transparent);
  z-index: -1;
  animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.05); }
}
.member-name-modern {
  font-size: 1.5rem;
  font-weight: 800;
  color: #14284B;
  margin-bottom: 6px;
}
.member-class-modern {
  font-size: 1rem;
  color: #64748b;
  font-weight: 600;
  margin-bottom: 16px;
}
.status-badge-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  border-radius: 12px;
  font-size: 0.875rem;
  font-weight: 700;
  margin-bottom: 24px;
}
.status-badge-modern.active {
  background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(22,163,74,0.3);
}
.status-badge-modern.inactive {
  background: linear-gradient(135deg, #64748b 0%, #475569 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(100,116,139,0.3);
}
.info-list-modern {
  text-align: left;
  margin-bottom: 24px;
}
.info-item-modern {
  display: flex;
  align-items: start;
  gap: 12px;
  padding: 14px 16px;
  background: linear-gradient(135deg, rgba(237,27,59,0.04) 0%, rgba(237,27,59,0.01) 100%);
  border-radius: 12px;
  margin-bottom: 10px;
  border: 1px solid rgba(237,27,59,0.08);
  transition: all 0.3s ease;
}
.info-item-modern:hover {
  background: linear-gradient(135deg, rgba(237,27,59,0.08) 0%, rgba(237,27,59,0.02) 100%);
  border-color: rgba(237,27,59,0.15);
}
.info-item-modern i {
  color: #ED1B3B;
  font-size: 1.2rem;
  margin-top: 2px;
}
.info-item-modern span {
  color: #14284B;
  font-size: 0.9rem;
  font-weight: 600;
  line-height: 1.5;
}
.btn-edit-profile {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 16px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1rem;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 16px rgba(237,27,59,0.3);
}
.btn-edit-profile:hover {
  background: linear-gradient(135deg, #C41630 0%, #A01228 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 24px rgba(237,27,59,0.4);
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
.history-header-modern {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 28px;
  padding-bottom: 20px;
  border-bottom: 2px solid rgba(237,27,59,0.1);
}
.history-title-modern {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1.3rem;
  font-weight: 800;
  color: #14284B;
  margin: 0;
}
.history-title-modern i {
  color: #ED1B3B;
  font-size: 1.5rem;
}
.count-badge-modern {
  padding: 8px 16px;
  background: linear-gradient(135deg, rgba(237,27,59,0.12) 0%, rgba(237,27,59,0.06) 100%);
  border: 1.5px solid rgba(237,27,59,0.2);
  border-radius: 10px;
  color: #ED1B3B;
  font-size: 0.875rem;
  font-weight: 700;
}
.transaction-item-modern {
  background: white;
  border-radius: 16px;
  padding: 20px;
  margin-bottom: 16px;
  border: 2px solid rgba(20,40,75,0.06);
  transition: all 0.3s ease;
}
.transaction-item-modern:hover {
  border-color: rgba(237,27,59,0.2);
  box-shadow: 0 4px 16px rgba(237,27,59,0.08);
  transform: translateY(-2px);
}
.transaction-header {
  display: flex;
  justify-content: space-between;
  align-items: start;
  margin-bottom: 16px;
}
.transaction-code {
  display: inline-flex;
  padding: 6px 12px;
  background: linear-gradient(135deg, rgba(20,40,75,0.08) 0%, rgba(20,40,75,0.02) 100%);
  border: 1px solid rgba(20,40,75,0.12);
  border-radius: 8px;
  font-family: 'Courier New', monospace;
  font-size: 0.8rem;
  font-weight: 700;
  color: #14284B;
}
.transaction-book {
  font-size: 1.05rem;
  font-weight: 700;
  color: #14284B;
  margin-bottom: 12px;
}
.transaction-dates {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
  margin-bottom: 12px;
}
.date-item {
  font-size: 0.85rem;
  color: #64748b;
}
.date-item strong {
  color: #14284B;
  display: block;
  margin-top: 4px;
}
.transaction-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 12px;
  border-top: 1px solid rgba(20,40,75,0.08);
}
.status-badge-trx {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 14px;
  border-radius: 10px;
  font-size: 0.8rem;
  font-weight: 700;
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
.denda-amount {
  font-size: 0.95rem;
  font-weight: 700;
}
.denda-amount.has-fine {
  color: #dc2626;
}
.denda-amount.no-fine {
  color: #94a3b8;
}
.empty-state-modern {
  text-align: center;
  padding: 60px 20px;
}
.empty-state-modern i {
  font-size: 4rem;
  color: #cbd5e1;
  margin-bottom: 16px;
}
.empty-state-modern p {
  color: #64748b;
  font-size: 1rem;
  margin: 0;
}
</style>

<div class="detail-member-page">
  <a href="{{ route('admin.anggota.index') }}" class="back-btn-modern">
    <i class="bi bi-arrow-left"></i>
    <span>Kembali ke Daftar Anggota</span>
  </a>

  <div class="row g-4">
    <div class="col-lg-4 col-md-5">
      <div class="profile-card-modern">
        @if($anggota->foto)
          <img src="{{ Storage::url($anggota->foto) }}" alt="{{ $anggota->nama }}" 
               style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; margin: 0 auto 18px; box-shadow: 0 10px 28px rgba(237,27,59,0.35), 0 0 0 6px rgba(237,27,59,0.1); display: block;">
        @else
          <div class="avatar-modern">
            {{ strtoupper(substr($anggota->nama, 0, 1)) }}
          </div>
        @endif

        <h2 class="member-name-modern">{{ $anggota->nama }}</h2>
        <p class="member-class-modern">{{ $anggota->kelas }}</p>

        <div class="status-badge-modern {{ $anggota->status === 'aktif' ? 'active' : 'inactive' }}">
          @if($anggota->status === 'aktif')
            <i class="bi bi-check-circle-fill"></i>
            <span>Status Aktif</span>
          @else
            <i class="bi bi-x-circle-fill"></i>
            <span>Status Non-aktif</span>
          @endif
        </div>

        <div class="info-list-modern">
          <div class="info-item-modern">
            <i class="bi bi-credit-card-2-front"></i>
            <span>NIS: {{ $anggota->nis }}</span>
          </div>

          <div class="info-item-modern">
            <i class="bi bi-envelope-fill"></i>
            <span>{{ $anggota->user->email ?? '-' }}</span>
          </div>

          <div class="info-item-modern">
            <i class="bi bi-telephone-fill"></i>
            <span>{{ $anggota->telepon ?? 'Tidak ada nomor telepon' }}</span>
          </div>

          <div class="info-item-modern">
            <i class="bi bi-geo-alt-fill"></i>
            <span>{{ $anggota->alamat ?? 'Alamat belum diisi' }}</span>
          </div>
        </div>

        <a href="{{ route('admin.anggota.edit', $anggota) }}" class="btn-edit-profile">
          <i class="bi bi-pencil-square"></i>
          <span>Edit Anggota</span>
        </a>
      </div>
    </div>

    <div class="col-lg-8 col-md-7">
      <div class="history-card-modern">
        <div class="history-header-modern">
          <h3 class="history-title-modern">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Peminjaman</span>
          </h3>
          <span class="count-badge-modern">{{ $anggota->peminjaman->count() }} Transaksi</span>
        </div>

        @forelse($anggota->peminjaman as $p)
          <div class="transaction-item-modern">
            <div class="transaction-header">
              <span class="transaction-code">{{ $p->kode_pinjam }}</span>
            </div>

            <div style="display:flex;align-items:start;gap:12px;margin-bottom:12px">
              @if($p->buku && $p->buku->cover)
                <img src="{{ Storage::url($p->buku->cover) }}" alt="{{ $p->buku->judul }}" 
                     style="width:44px;height:66px;object-fit:cover;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.15);flex-shrink:0;">
              @else
                <div style="width:44px;height:66px;border-radius:8px;background:linear-gradient(135deg,#1f2937,#4b5563);display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,.15)">
                  <i class="bi bi-book-fill" style="color:rgba(255,255,255,.7);font-size:1.3rem"></i>
                </div>
              @endif
              <div class="transaction-book">{{ $p->buku->judul ?? '-' }}</div>
            </div>

            <div class="transaction-dates">
              <div class="date-item">
                <i class="bi bi-calendar-check text-muted"></i> Tanggal Pinjam
                <strong>{{ $p->tanggal_pinjam->format('d M Y') }}</strong>
              </div>
              <div class="date-item">
                <i class="bi bi-calendar-x text-muted"></i> Batas Kembali
                <strong>{{ $p->tanggal_kembali_rencana->format('d M Y') }}</strong>
              </div>
            </div>

            <div class="transaction-footer">
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

              <span class="denda-amount {{ $p->denda > 0 ? 'has-fine' : 'no-fine' }}">
                {{ $p->denda > 0 ? 'Rp ' . number_format($p->denda, 0, ',', '.') : 'Tidak ada denda' }}
              </span>
            </div>
          </div>
        @empty
          <div class="empty-state-modern">
            <i class="bi bi-inbox"></i>
            <p>Belum ada riwayat peminjaman</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

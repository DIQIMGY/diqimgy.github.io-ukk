@extends('layouts.app')
@section('title','Kelola Anggota')
@section('page-title','Kelola Anggota')
@section('content')

<style>
/* ══════════════════════════════════════════════════════════
   MODERN MEMBERS MANAGEMENT — REDESIGNED
   Clean, Proportional, and Professional
══════════════════════════════════════════════════════════ */

.members-header-new {
  margin-bottom: 24px;
}

.page-title-new {
  font-size: 1.4rem;
  font-weight: 900;
  color: var(--navy-800);
  margin: 0 0 6px;
  letter-spacing: -.02em;
}

.page-subtitle-new {
  font-size: .84rem;
  color: var(--tx-3);
  margin: 0;
  display: flex;
  align-items: center;
  gap: 6px;
}

/* Toolbar */
.toolbar-new {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

/* Search & Filter Bar */
.search-filter-bar {
  background: #fff;
  padding: 16px 18px;
  border-radius: 14px;
  border: 1px solid #f0f0f0;
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,.04);
}

.search-input-wrapper {
  position: relative;
  flex: 1;
  min-width: 240px;
}

.search-icon-left {
  position: absolute;
  left: 13px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--tx-4);
  font-size: .82rem;
  pointer-events: none;
}

.search-input-new {
  width: 100%;
  padding: 9px 13px 9px 36px;
  border: 1.5px solid var(--border);
  border-radius: 10px;
  font-size: .84rem;
  transition: all .2s;
}

.search-input-new:focus {
  border-color: var(--crimson);
  box-shadow: 0 0 0 3px rgba(237,27,59,.1);
  outline: none;
}

.filter-select-new {
  padding: 9px 13px;
  border: 1.5px solid var(--border);
  border-radius: 10px;
  font-size: .84rem;
  min-width: 150px;
  transition: all .2s;
}

.filter-select-new:focus {
  border-color: var(--crimson);
  box-shadow: 0 0 0 3px rgba(237,27,59,.1);
  outline: none;
}

/* Stats Cards */
.stats-grid-members {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}

.stat-card-member {
  background: #fff;
  border-radius: 14px;
  padding: 18px 20px;
  border: 1px solid #f0f0f0;
  box-shadow: 0 2px 8px rgba(0,0,0,.04);
  display: flex;
  align-items: center;
  gap: 14px;
  transition: all .3s;
}

.stat-card-member:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0,0,0,.08);
}

.stat-icon-member {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  flex-shrink: 0;
}

/* Member Cards Grid */
.member-card-grid-new {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 18px;
  margin-bottom: 24px;
}

@media (min-width: 1400px) {
  .member-card-grid-new {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  }
}

.member-card-new {
  background: #fff;
  border-radius: 14px;
  border: 1px solid #f0f0f0;
  padding: 20px 18px;
  transition: all .3s;
  display: flex;
  flex-direction: column;
}

.member-card-new:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 28px rgba(0,0,0,.12);
  border-color: var(--crimson);
}

.member-avatar-new {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--crimson), var(--crimson-dark));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  font-weight: 900;
  color: #fff;
  margin: 0 auto 12px;
  box-shadow: 0 5px 16px rgba(237,27,59,.35);
  border: 2.5px solid #fff;
}

.member-info-new {
  text-align: center;
  margin-bottom: 14px;
}

.member-name-new {
  font-size: .92rem;
  font-weight: 800;
  color: var(--navy-800);
  margin: 0 0 6px;
  line-height: 1.3;
}

.member-status-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: .7rem;
  font-weight: 700;
  padding: 4px 11px;
  border-radius: 8px;
}

.badge-active {
  background: rgba(16,185,129,.12);
  color: #15803d;
}

.badge-inactive {
  background: rgba(100,116,139,.12);
  color: #64748b;
}

.member-details-new {
  display: flex;
  flex-direction: column;
  gap: 7px;
  margin-bottom: 14px;
  flex: 1;
}

.detail-row-new {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 7px 11px;
  background: #fafbfc;
  border-radius: 9px;
  font-size: .8rem;
}

.detail-label-new {
  color: var(--tx-3);
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 6px;
}

.detail-label-new i {
  font-size: .72rem;
}

.detail-value-new {
  color: var(--navy-800);
  font-weight: 700;
  font-size: .79rem;
}

.member-actions-new {
  display: flex;
  gap: 7px;
  padding-top: 14px;
  border-top: 1px solid #f0f0f0;
}

.action-btn-new {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 9px;
  border-radius: 9px;
  text-decoration: none;
  font-size: .8rem;
  font-weight: 700;
  transition: all .2s;
  border: none;
  cursor: pointer;
}

.action-view {
  background: rgba(59,130,246,.1);
  color: #1d4ed8;
  border: 1px solid rgba(59,130,246,.2);
}

.action-view:hover {
  background: rgba(59,130,246,.15);
  transform: translateY(-1px);
}

.action-edit {
  background: rgba(245,158,11,.1);
  color: #92400e;
  border: 1px solid rgba(245,158,11,.2);
}

.action-edit:hover {
  background: rgba(245,158,11,.15);
  transform: translateY(-1px);
}

.action-delete {
  background: rgba(239,68,68,.1);
  color: #be123c;
  border: 1px solid rgba(239,68,68,.2);
}

.action-delete:hover {
  background: rgba(239,68,68,.15);
  transform: translateY(-1px);
}

/* Empty State */
.empty-state-new {
  background: #fff;
  border-radius: 18px;
  padding: 56px 36px;
  text-align: center;
  border: 2px dashed #e0e0e0;
}

.empty-icon-new {
  font-size: 3.5rem;
  color: #d0d0d0;
  display: block;
  margin-bottom: 14px;
}

.empty-title-new {
  font-size: 1.1rem;
  font-weight: 800;
  color: var(--navy-800);
  margin: 0 0 8px;
}

.empty-desc-new {
  font-size: .84rem;
  color: var(--tx-3);
  margin: 0 0 22px;
}

/* Responsive */
@media (max-width: 768px) {
  .member-card-grid-new {
    grid-template-columns: 1fr;
    gap: 14px;
  }
  
  .stats-grid-members {
    grid-template-columns: 1fr;
  }
  
  .toolbar-new {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>

{{-- ══════════════════════════════════════════════════════════
     PAGE HEADER
══════════════════════════════════════════════════════════ --}}
<div class="members-header-new">
  <h1 class="page-title-new">Kelola Anggota Perpustakaan</h1>
  <p class="page-subtitle-new">
    <i class="bi bi-people-fill" style="color:#10b981"></i>
    <span>Manajemen data anggota perpustakaan</span>
  </p>
</div>

{{-- ══════════════════════════════════════════════════════════
     TOOLBAR
══════════════════════════════════════════════════════════ --}}
<div class="toolbar-new">
  <div style="display:flex;align-items:center;gap:10px">
    <span style="font-size:.84rem;color:var(--tx-3);font-weight:600">
      <i class="bi bi-list-ul"></i> Menampilkan {{ $anggota->count() }} dari {{ $anggota->total() }} anggota
    </span>
  </div>
  <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px">
    <i class="bi bi-person-plus-fill"></i> Tambah Anggota
  </a>
</div>

{{-- ══════════════════════════════════════════════════════════
     SEARCH & FILTER BAR
══════════════════════════════════════════════════════════ --}}
<div class="search-filter-bar">
  <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
    <div class="search-input-wrapper">
      <i class="bi bi-search search-icon-left"></i>
      <input type="text" name="search" placeholder="Cari nama, NIS, atau kelas..." value="{{ request('search') }}" class="search-input-new">
    </div>
    
    <select name="status" class="filter-select-new">
      <option value="">Semua Status</option>
      <option value="aktif" {{ request('status')==='aktif'?'selected':'' }}>Aktif</option>
      <option value="nonaktif" {{ request('status')==='nonaktif'?'selected':'' }}>Non-aktif</option>
    </select>
    
    <button type="submit" class="btn btn-primary btn-sm">
      <i class="bi bi-funnel-fill"></i> Filter
    </button>
    
    @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-ghost btn-sm">
      <i class="bi bi-x-circle-fill"></i> Reset
    </a>
    @endif
  </form>
</div>

{{-- ══════════════════════════════════════════════════════════
     STATS OVERVIEW
══════════════════════════════════════════════════════════ --}}
<div class="stats-grid-members">
  <div class="stat-card-member">
    <div class="stat-icon-member" style="background:rgba(16,185,129,.1);color:#10b981">
      <i class="bi bi-people-fill"></i>
    </div>
    <div>
      <div style="font-size:.72rem;color:var(--tx-3);font-weight:700;text-transform:uppercase;letter-spacing:.04em">Total Anggota</div>
      <div style="font-size:1.6rem;font-weight:900;color:var(--navy-800);line-height:1;letter-spacing:-.02em">{{ $anggota->total() }}</div>
    </div>
  </div>
  
  <div class="stat-card-member">
    <div class="stat-icon-member" style="background:rgba(34,197,94,.1);color:#22c55e">
      <i class="bi bi-check-circle-fill"></i>
    </div>
    <div>
      <div style="font-size:.72rem;color:var(--tx-3);font-weight:700;text-transform:uppercase;letter-spacing:.04em">Anggota Aktif</div>
      <div style="font-size:1.6rem;font-weight:900;color:var(--navy-800);line-height:1;letter-spacing:-.02em">{{ $anggota->where('status','aktif')->count() }}</div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     CONTENT — Member Cards or Empty State
══════════════════════════════════════════════════════════ --}}
@if($anggota->isEmpty())
  {{-- Empty State --}}
  <div class="empty-state-new">
    <i class="bi bi-people empty-icon-new"></i>
    <h3 class="empty-title-new">Tidak ada anggota ditemukan</h3>
    <p class="empty-desc-new">
      @if(request()->hasAny(['search','status']))
        Tidak ada hasil yang cocok dengan filter Anda. Coba kata kunci atau filter lain.
      @else
        Belum ada anggota terdaftar. Mulai dengan menambahkan anggota pertama.
      @endif
    </p>
    <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary" style="display:inline-flex;align-items:center;gap:8px">
      <i class="bi bi-person-plus-fill"></i> Tambah Anggota Pertama
    </a>
  </div>
@else
  {{-- Member Cards Grid --}}
  <div class="member-card-grid-new">
    @foreach($anggota as $a)
    <div class="member-card-new">
      {{-- Avatar --}}
      @if($a->foto)
        <img src="{{ Storage::url($a->foto) }}" alt="{{ $a->nama }}" class="member-avatar-new" style="width: 56px; height: 56px; object-fit: cover;">
      @else
        <div class="member-avatar-new">
          {{ strtoupper(substr($a->nama,0,1)) }}
        </div>
      @endif
      
      {{-- Info --}}
      <div class="member-info-new">
        <h3 class="member-name-new">{{ $a->nama }}</h3>
        @if($a->status==='aktif')
          <span class="member-status-badge badge-active">
            <span style="width:5px;height:5px;background:currentColor;border-radius:50%"></span>
            Aktif
          </span>
        @else
          <span class="member-status-badge badge-inactive">
            <span style="width:5px;height:5px;background:currentColor;border-radius:50%"></span>
            Non-aktif
          </span>
        @endif
      </div>
      
      {{-- Details --}}
      <div class="member-details-new">
        <div class="detail-row-new">
          <span class="detail-label-new">
            <i class="bi bi-credit-card-2-front"></i> NIS
          </span>
          <span class="detail-value-new">{{ $a->nis }}</span>
        </div>
        <div class="detail-row-new">
          <span class="detail-label-new">
            <i class="bi bi-mortarboard"></i> Kelas
          </span>
          <span class="detail-value-new">{{ $a->kelas }}</span>
        </div>
        <div class="detail-row-new">
          <span class="detail-label-new">
            <i class="bi bi-envelope"></i> Email
          </span>
          <span class="detail-value-new" style="font-size:.72rem">{{ Str::limit($a->user->email??'-',18) }}</span>
        </div>
      </div>
      
      {{-- Actions --}}
      <div class="member-actions-new">
        <a href="{{ route('admin.anggota.show',$a) }}" class="action-btn-new action-view" title="Lihat Detail">
          <i class="bi bi-eye-fill"></i>
        </a>
        <a href="{{ route('admin.anggota.edit',$a) }}" class="action-btn-new action-edit" title="Edit">
          <i class="bi bi-pencil-fill"></i>
        </a>
        <form method="POST" action="{{ route('admin.anggota.destroy',$a) }}" onsubmit="return confirm('Hapus anggota {{ $a->nama }}? Tindakan ini tidak dapat dibatalkan.')" style="flex:1">
          @csrf @method('DELETE')
          <button type="submit" class="action-btn-new action-delete" style="width:100%" title="Hapus">
            <i class="bi bi-trash-fill"></i>
          </button>
        </form>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  @if($anggota->hasPages())
  <div style="display:flex;justify-content:center;margin-top:28px">
    {{ $anggota->links() }}
  </div>
  @endif
@endif

@endsection

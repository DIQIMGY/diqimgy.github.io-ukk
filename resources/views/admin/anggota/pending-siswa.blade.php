@extends('layouts.app')
@section('title','Persetujuan Pendaftaran Siswa')
@section('page-title','Persetujuan Siswa')

@section('content')
<style>
.ps-wrap { max-width: 860px; margin: 0 auto; }

.ps-header {
  display: flex; align-items: center; gap: 14px;
  margin-bottom: 24px;
}
.ps-header-icon {
  width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1.25rem;
  box-shadow: 0 6px 18px rgba(139,92,246,.35);
}
.ps-header-text h2 { margin: 0 0 2px; font-size: 1.1rem; font-weight: 800; color: var(--navy-800); }
.ps-header-text p  { margin: 0; font-size: .8rem; color: var(--tx-3); }

.ps-info {
  display: flex; align-items: flex-start; gap: 12px;
  background: rgba(139,92,246,.07);
  border: 1.5px solid rgba(139,92,246,.18);
  border-radius: 12px;
  padding: 14px 16px;
  margin-bottom: 20px;
  font-size: .82rem; color: var(--tx-2); line-height: 1.55;
}
.ps-info i { color: #8b5cf6; flex-shrink: 0; margin-top: 1px; font-size: 1rem; }

/* Empty */
.ps-empty {
  text-align: center; padding: 60px 20px;
  background: var(--bg);
  border: 1.5px dashed var(--border);
  border-radius: 16px;
}
.ps-empty-icon {
  width: 72px; height: 72px; border-radius: 50%;
  background: rgba(139,92,246,.1);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.8rem; color: #8b5cf6;
  margin: 0 auto 16px;
}
.ps-empty h3 { font-size: 1rem; font-weight: 800; color: var(--navy-800); margin: 0 0 6px; }
.ps-empty p  { font-size: .82rem; color: var(--tx-3); margin: 0; }

/* Card */
.ps-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 18px 20px;
  margin-bottom: 10px;
  transition: box-shadow .2s, transform .15s;
}
.ps-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.07); transform: translateY(-1px); }

.ps-card-top {
  display: flex; align-items: center; gap: 14px;
  margin-bottom: 14px;
}
.ps-avatar {
  width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
  background: linear-gradient(135deg, #ED1B3B, #C41630);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 1.1rem; font-weight: 800;
  border: 2px solid var(--border);
}
.ps-name  { font-size: .95rem; font-weight: 800; color: var(--navy-800); margin: 0 0 2px; }
.ps-email { font-size: .77rem; color: var(--tx-3); margin: 0; }
.ps-badge-pending {
  margin-left: auto; flex-shrink: 0;
  display: inline-flex; align-items: center; gap: 4px;
  background: rgba(139,92,246,.1); color: #7c3aed;
  border: 1px solid rgba(139,92,246,.2);
  padding: 3px 10px; border-radius: 20px;
  font-size: .7rem; font-weight: 700;
}

.ps-details {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 8px;
  margin-bottom: 14px;
  padding: 12px 14px;
  background: var(--bg);
  border-radius: 10px;
  border: 1px solid var(--border);
}
.ps-detail-item label {
  display: block; font-size: .67rem; font-weight: 800; text-transform: uppercase;
  letter-spacing: .06em; color: var(--tx-4); margin-bottom: 2px;
}
.ps-detail-item span {
  font-size: .8rem; font-weight: 600; color: var(--tx-1);
}

.ps-actions { display: flex; gap: 10px; }
.ps-btn-approve {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 20px; border-radius: 9px;
  background: linear-gradient(135deg, #10b981, #059669);
  color: #fff; font-size: .82rem; font-weight: 700;
  border: none; cursor: pointer;
  box-shadow: 0 4px 14px rgba(16,185,129,.3);
  transition: all .2s;
}
.ps-btn-approve:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,.4); }
.ps-btn-reject {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 20px; border-radius: 9px;
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: #fff; font-size: .82rem; font-weight: 700;
  border: none; cursor: pointer;
  box-shadow: 0 4px 14px rgba(239,68,68,.3);
  transition: all .2s;
}
.ps-btn-reject:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(239,68,68,.4); }
.ps-date { margin-left: auto; font-size: .73rem; color: var(--tx-4); align-self: center; }

/* Modal */
.ps-modal {
  display: none; position: fixed; inset: 0; z-index: 9999;
  background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
  align-items: center; justify-content: center; padding: 20px;
}
.ps-modal.show { display: flex; }
.ps-modal-box {
  background: var(--surface); border-radius: 16px;
  padding: 28px 24px; max-width: 400px; width: 100%;
  box-shadow: 0 24px 60px rgba(0,0,0,.18); text-align: center;
}
.ps-modal-icon {
  width: 56px; height: 56px; border-radius: 50%; margin: 0 auto 14px;
  display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
}
.ps-modal-icon.approve { background: rgba(16,185,129,.12); color: #10b981; }
.ps-modal-icon.reject  { background: rgba(239,68,68,.12);  color: #ef4444; }
.ps-modal-title { font-size: 1rem; font-weight: 800; color: var(--navy-800); margin-bottom: 8px; }
.ps-modal-desc  { font-size: .82rem; color: var(--tx-3); margin-bottom: 20px; line-height: 1.5; }
.ps-modal-btns  { display: flex; gap: 10px; justify-content: center; }
.ps-modal-btns button, .ps-btn-cancel {
  padding: 9px 22px; border-radius: 9px; font-size: .82rem; font-weight: 700;
  cursor: pointer; border: none; transition: all .2s;
}
.ps-btn-cancel { background: var(--bg) !important; color: var(--tx-2); border: 1.5px solid var(--border) !important; }
.ps-btn-cancel:hover { background: var(--border) !important; }
</style>

<div class="ps-wrap">
  {{-- Header --}}
  <div class="ps-header">
    <div class="ps-header-icon"><i class="bi bi-person-check-fill"></i></div>
    <div class="ps-header-text">
      <h2>Persetujuan Pendaftaran Siswa</h2>
      <p>{{ $totalPending }} siswa menunggu persetujuan kamu</p>
    </div>
  </div>

  {{-- Info --}}
  <div class="ps-info">
    <i class="bi bi-info-circle-fill"></i>
    <span>Siswa yang baru daftar tidak bisa login sampai kamu setujui. Pastikan data NIS dan kelas sudah benar sebelum menyetujui. Kalau kamu tolak, data pendaftaran mereka akan dihapus permanen.</span>
  </div>

  @if($totalPending === 0)
  <div class="ps-empty">
    <div class="ps-empty-icon"><i class="bi bi-person-check"></i></div>
    <h3>Tidak ada yang menunggu</h3>
    <p>Semua pendaftaran siswa sudah diproses.</p>
  </div>

  @else
  @foreach($pendingSiswa as $anggota)
  <div class="ps-card">
    <div class="ps-card-top">
      <div class="ps-avatar">{{ strtoupper(substr($anggota->nama, 0, 1)) }}</div>
      <div style="min-width:0">
        <p class="ps-name">{{ $anggota->nama }}</p>
        <p class="ps-email">{{ $anggota->user?->email ?? '—' }}</p>
      </div>
      <span class="ps-badge-pending"><i class="bi bi-hourglass-split"></i> Menunggu</span>
    </div>

    <div class="ps-details">
      <div class="ps-detail-item">
        <label>NIS</label>
        <span>{{ $anggota->nis }}</span>
      </div>
      <div class="ps-detail-item">
        <label>Kelas</label>
        <span>{{ $anggota->kelas }}</span>
      </div>
      @if($anggota->telepon)
      <div class="ps-detail-item">
        <label>Telepon</label>
        <span>{{ $anggota->telepon }}</span>
      </div>
      @endif
      @if($anggota->alamat)
      <div class="ps-detail-item">
        <label>Alamat</label>
        <span>{{ Str::limit($anggota->alamat, 30) }}</span>
      </div>
      @endif
      <div class="ps-detail-item">
        <label>Daftar</label>
        <span>{{ $anggota->created_at->format('d M Y, H:i') }}</span>
      </div>
    </div>

    <div class="ps-actions">
      <button class="ps-btn-approve" onclick="confirmAction('approve', {{ $anggota->id }}, '{{ addslashes($anggota->nama) }}')">
        <i class="bi bi-check-lg"></i> Setujui
      </button>
      <button class="ps-btn-reject" onclick="confirmAction('reject', {{ $anggota->id }}, '{{ addslashes($anggota->nama) }}')">
        <i class="bi bi-x-lg"></i> Tolak
      </button>
      <span class="ps-date">{{ $anggota->created_at->diffForHumans() }}</span>
    </div>
  </div>
  @endforeach
  @endif

  <div style="margin-top:20px">
    <a href="{{ route('admin.anggota.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.8rem;color:var(--tx-3);text-decoration:none;font-weight:600;transition:color .2s" onmouseover="this.style.color='var(--navy)'" onmouseout="this.style.color='var(--tx-3)'">
      <i class="bi bi-arrow-left"></i> Kembali ke Kelola Anggota
    </a>
  </div>
</div>

{{-- Confirm Modal --}}
<div class="ps-modal" id="psModal">
  <div class="ps-modal-box">
    <div class="ps-modal-icon" id="psModalIcon"></div>
    <div class="ps-modal-title" id="psModalTitle"></div>
    <div class="ps-modal-desc"  id="psModalDesc"></div>
    <div class="ps-modal-btns">
      <button class="ps-btn-cancel" onclick="closeModal()">Batal</button>
      <form id="psModalForm" method="POST" style="margin:0">
        @csrf
        <button type="submit" id="psModalBtn" style="padding:9px 22px;border-radius:9px;font-size:.82rem;font-weight:700;border:none;cursor:pointer;color:#fff;transition:all .2s"></button>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
function confirmAction(type, id, name) {
  const modal = document.getElementById('psModal');
  const icon  = document.getElementById('psModalIcon');
  const title = document.getElementById('psModalTitle');
  const desc  = document.getElementById('psModalDesc');
  const form  = document.getElementById('psModalForm');
  const btn   = document.getElementById('psModalBtn');

  if (type === 'approve') {
    icon.className = 'ps-modal-icon approve';
    icon.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
    title.textContent = 'Setujui Pendaftaran?';
    desc.textContent  = `"${name}" akan bisa login ke sistem setelah disetujui.`;
    btn.textContent   = 'Ya, Setujui';
    btn.style.background = 'linear-gradient(135deg,#10b981,#059669)';
    btn.style.boxShadow  = '0 4px 12px rgba(16,185,129,.3)';
    form.action = `/admin/anggota/${id}/approve`;
  } else {
    icon.className = 'ps-modal-icon reject';
    icon.innerHTML = '<i class="bi bi-trash-fill"></i>';
    title.textContent = 'Tolak Pendaftaran?';
    desc.textContent  = `Pendaftaran "${name}" akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.`;
    btn.textContent   = 'Ya, Tolak & Hapus';
    btn.style.background = 'linear-gradient(135deg,#ef4444,#dc2626)';
    btn.style.boxShadow  = '0 4px 12px rgba(239,68,68,.3)';
    form.action = `/admin/anggota/${id}/reject`;
  }

  modal.classList.add('show');
}

function closeModal() {
  document.getElementById('psModal').classList.remove('show');
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
document.getElementById('psModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});
</script>
@endpush

@endsection

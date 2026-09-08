@extends('layouts.app')
@section('title','Edit Series – '.$series->nama_series)
@section('page-title','Edit Series')
@section('content')

<style>
.form-card{background:#fff;border-radius:16px;border:1px solid #f0f0f0;box-shadow:0 4px 20px rgba(20,40,75,.06);padding:28px 32px;margin-bottom:24px}
.form-label{font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px;display:block}
.form-control,.form-select{border-radius:9px;border:1.5px solid #e5e7eb;font-size:.85rem;padding:9px 13px;transition:border-color .2s,box-shadow .2s}
.form-control:focus,.form-select:focus{border-color:var(--crimson);box-shadow:0 0 0 3px rgba(237,27,59,.1);outline:none}
.btn-save{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--crimson),#c41630);color:#fff;font-weight:700;font-size:.88rem;padding:11px 24px;border-radius:10px;border:none;cursor:pointer;transition:all .2s}
.btn-save:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(237,27,59,.35)}
.btn-back{display:inline-flex;align-items:center;gap:7px;background:#f9fafb;color:#374151;font-weight:600;font-size:.85rem;padding:10px 18px;border-radius:10px;border:1.5px solid #e5e7eb;text-decoration:none;transition:all .18s}
.btn-back:hover{background:#f0f4ff;border-color:#3b4fd4;color:#3b4fd4}

/* Tabel buku dalam series */
.buku-table{width:100%;border-collapse:separate;border-spacing:0}
.buku-table thead th{font-size:.72rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.06em;padding:8px 12px;border-bottom:1.5px solid #f0f0f0}
.buku-table tbody tr{border-bottom:1px solid #f5f5f5;transition:background .15s}
.buku-table tbody tr:last-child{border-bottom:none}
.buku-table tbody tr:hover{background:#fafbff}
.buku-table td{padding:11px 12px;vertical-align:middle;font-size:.84rem}

.num-badge{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--crimson),#c41630);color:#fff;font-size:.72rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center}
.btn-sm-action{display:inline-flex;align-items:center;gap:4px;font-size:.72rem;font-weight:700;padding:5px 10px;border-radius:7px;border:none;cursor:pointer;transition:all .18s}
.btn-penutup{background:#fff7ed;color:#d97706}.btn-penutup:hover{background:#d97706;color:#fff}
.btn-penutup.active{background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff}
.btn-hapus-buku{background:#fff0f0;color:var(--crimson)}.btn-hapus-buku:hover{background:var(--crimson);color:#fff}

/* Tambah buku */
.add-buku-form{display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;padding:16px;background:#f9fafb;border-radius:10px;border:1.5px dashed #e5e7eb;margin-top:12px}
.add-buku-form select{flex:1;min-width:200px}

/* Cover mini */
.cover-mini{width:36px;height:50px;border-radius:4px;overflow:hidden;background:#dde4ef;flex-shrink:0;display:inline-block;vertical-align:middle}
.cover-mini img{width:100%;height:100%;object-fit:cover;display:block}
</style>

<div style="display:flex;align-items:center;gap:14px;margin-bottom:24px">
  <a href="{{ route('admin.series.index') }}" class="btn-back">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
  <div>
    <div style="font-size:.65rem;font-weight:900;letter-spacing:.14em;color:var(--crimson);text-transform:uppercase;margin-bottom:3px">EDIT SERIES</div>
    <h1 style="font-size:1.4rem;font-weight:800;color:#0b1730;margin:0">{{ $series->nama_series }}</h1>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#ecfdf5;color:#065f46;font-weight:600">
  <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;font-weight:600">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
  {{-- Kolom kiri: info series --}}
  <div class="col-lg-4">
    <div class="form-card">
      <h2 style="font-size:1rem;font-weight:800;color:#0b1730;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid #f0f0f0">
        <i class="bi bi-info-circle-fill" style="color:var(--crimson);margin-right:8px"></i>Info Series
      </h2>

      <form action="{{ route('admin.series.update', $series) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
          <label class="form-label">Nama Series <span style="color:var(--crimson)">*</span></label>
          <input type="text" name="nama_series" class="form-control"
                 value="{{ old('nama_series', $series->nama_series) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Penulis <span style="color:var(--crimson)">*</span></label>
          <input type="text" name="penulis" class="form-control"
                 value="{{ old('penulis', $series->penulis) }}" required>
        </div>

        <div class="mb-4">
          <label class="form-label">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $series->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn-save" style="width:100%;justify-content:center">
          <i class="bi bi-check-lg"></i> Simpan Perubahan
        </button>
      </form>
    </div>
  </div>

  {{-- Kolom kanan: kelola buku --}}
  <div class="col-lg-8">
    <div class="form-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #f0f0f0">
        <h2 style="font-size:1rem;font-weight:800;color:#0b1730;margin:0">
          <i class="bi bi-books" style="color:var(--crimson);margin-right:8px"></i>
          Buku dalam Series
        </h2>
        <span style="background:#eff6ff;color:#1d4ed8;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:99px">
          {{ $series->buku->count() }} buku
        </span>
      </div>

      {{-- Tabel buku --}}
      @if($series->buku->isEmpty())
      <div style="text-align:center;padding:32px;color:#9ca3af">
        <i class="bi bi-book" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.3"></i>
        Belum ada buku dalam series ini
      </div>
      @else
      <table class="buku-table">
        <thead>
          <tr>
            <th style="width:40px">#</th>
            <th>Buku</th>
            <th style="text-align:center;width:90px">Penutup</th>
            <th style="text-align:center;width:80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($series->buku as $bk)
          @php $pv = $bk->pivot; @endphp
          <tr>
            <td><span class="num-badge">{{ $pv->urutan_baca }}</span></td>
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                <div class="cover-mini">
                  @if($bk->cover)
                    <img src="{{ Storage::url($bk->cover) }}" alt="{{ $bk->judul }}">
                  @else
                    <div style="width:100%;height:100%;background:linear-gradient(135deg,#0f1f3d,#1e4080);display:flex;align-items:center;justify-content:center">
                      <i class="bi bi-book-fill" style="color:rgba(255,255,255,.5);font-size:.65rem"></i>
                    </div>
                  @endif
                </div>
                <div>
                  <div style="font-weight:700;color:#1f2937;font-size:.84rem">{{ $bk->judul }}</div>
                  <div style="font-size:.72rem;color:#9ca3af">{{ $bk->pengarang }}</div>
                </div>
              </div>
            </td>
            <td style="text-align:center">
              {{-- Toggle penutup --}}
              <form action="{{ route('admin.series.buku.penutup', [$series, $bk]) }}" method="POST">
                @csrf
                <button type="submit" class="btn-sm-action btn-penutup {{ $pv->is_penutup ? 'active' : '' }}"
                        title="{{ $pv->is_penutup ? 'Tandai bukan penutup' : 'Tandai sebagai penutup' }}">
                  {{ $pv->is_penutup ? '🎉 Ya' : '—' }}
                </button>
              </form>
            </td>
            <td style="text-align:center">
              {{-- Hapus dari series --}}
              <form action="{{ route('admin.series.buku.hapus', [$series, $bk]) }}" method="POST"
                    onsubmit="return confirm('Keluarkan buku ini dari series?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm-action btn-hapus-buku">
                  <i class="bi bi-x-lg"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif

      {{-- Form tambah buku baru --}}
      @if($bukuLainnya->isNotEmpty())
      <form action="{{ route('admin.series.buku.tambah', $series) }}" method="POST" class="add-buku-form">
        @csrf
        <div style="flex:1;min-width:200px">
          <label class="form-label" style="margin-bottom:5px">Tambah Buku ke Series</label>
          <select name="buku_id" class="form-select" required>
            <option value="">— Pilih buku —</option>
            @foreach($bukuLainnya as $b)
            <option value="{{ $b->id }}">{{ $b->judul }} ({{ $b->pengarang }})</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label" style="margin-bottom:5px">Tandai sebagai Penutup?</label>
          <div style="display:flex;align-items:center;gap:6px;padding:9px 0">
            <input type="checkbox" name="is_penutup" value="1" id="isPenutup" style="width:16px;height:16px;accent-color:var(--crimson)">
            <label for="isPenutup" style="font-size:.82rem;font-weight:600;color:#374151;margin:0;cursor:pointer">Ya, buku penutup</label>
          </div>
        </div>
        <button type="submit" class="btn-save" style="align-self:flex-end">
          <i class="bi bi-plus-lg"></i> Tambah
        </button>
      </form>
      @else
      <div style="margin-top:12px;padding:12px 16px;background:#f9fafb;border-radius:9px;font-size:.8rem;color:#9ca3af;text-align:center">
        Semua buku sudah masuk dalam series ini.
      </div>
      @endif

    </div>
  </div>
</div>

@endsection

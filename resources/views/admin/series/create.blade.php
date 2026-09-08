@extends('layouts.app')
@section('title','Tambah Series')
@section('page-title','Tambah Series')
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

/* Buku selector */
.buku-search-wrap{position:relative;margin-bottom:12px}
.buku-search-wrap input{width:100%}
.buku-list{max-height:280px;overflow-y:auto;border:1.5px solid #e5e7eb;border-radius:10px;background:#fff}
.buku-item{display:flex;align-items:center;gap:12px;padding:10px 14px;cursor:pointer;transition:background .15s;border-bottom:1px solid #f5f5f5;user-select:none}
.buku-item:last-child{border-bottom:none}
.buku-item:hover{background:#fafbff}
.buku-item.selected{background:#fff7f7;border-left:3px solid var(--crimson)}
.buku-item-cover{width:36px;height:50px;border-radius:4px;overflow:hidden;background:#dde4ef;flex-shrink:0}
.buku-item-cover img{width:100%;height:100%;object-fit:cover}
.buku-item-info{flex:1;min-width:0}
.buku-item-title{font-size:.82rem;font-weight:700;color:#1f2937;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.buku-item-author{font-size:.72rem;color:#9ca3af}

/* Selected books list (urutan) */
.selected-list{margin-top:16px}
.selected-item{display:flex;align-items:center;gap:10px;padding:10px 14px;background:#fff;border:1.5px solid #e5e7eb;border-radius:9px;margin-bottom:8px}
.selected-item .num{width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,var(--crimson),#c41630);color:#fff;font-size:.72rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.selected-item .title{flex:1;font-size:.82rem;font-weight:700;color:#1f2937;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.selected-item .rm{background:none;border:none;color:#dc2626;cursor:pointer;font-size:1rem;padding:2px 6px;border-radius:6px;transition:background .15s;flex-shrink:0}
.selected-item .rm:hover{background:#fee2e2}
.empty-selected{text-align:center;padding:20px;color:#9ca3af;font-size:.82rem;border:1.5px dashed #e5e7eb;border-radius:9px}
</style>

<div style="display:flex;align-items:center;gap:14px;margin-bottom:24px">
  <a href="{{ route('admin.series.index') }}" class="btn-back">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
  <div>
    <div style="font-size:.65rem;font-weight:900;letter-spacing:.14em;color:var(--crimson);text-transform:uppercase;margin-bottom:3px">TAMBAH BARU</div>
    <h1 style="font-size:1.4rem;font-weight:800;color:#0b1730;margin:0">Tambah Series</h1>
  </div>
</div>

@if($errors->any())
<div class="alert alert-danger mb-4" style="border-radius:10px;border:none;background:#fef2f2;color:#991b1b;font-size:.84rem">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>
  <strong>Ada kesalahan:</strong>
  <ul style="margin:6px 0 0 20px;padding:0">
    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
  </ul>
</div>
@endif

<form action="{{ route('admin.series.store') }}" method="POST" id="seriesForm">
@csrf

<div class="row g-4">
  {{-- Kolom kiri: info series --}}
  <div class="col-lg-5">
    <div class="form-card">
      <h2 style="font-size:1rem;font-weight:800;color:#0b1730;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid #f0f0f0">
        <i class="bi bi-info-circle-fill" style="color:var(--crimson);margin-right:8px"></i>Info Series
      </h2>

      <div class="mb-3">
        <label class="form-label">Nama Series <span style="color:var(--crimson)">*</span></label>
        <input type="text" name="nama_series" class="form-control" placeholder="cth: Bumi Series"
               value="{{ old('nama_series') }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Penulis <span style="color:var(--crimson)">*</span></label>
        <input type="text" name="penulis" class="form-control" placeholder="cth: Tere Liye"
               value="{{ old('penulis') }}" required>
      </div>

      <div class="mb-0">
        <label class="form-label">Deskripsi <span style="color:#9ca3af">(opsional)</span></label>
        <textarea name="deskripsi" class="form-control" rows="4"
                  placeholder="Deskripsi singkat tentang series ini...">{{ old('deskripsi') }}</textarea>
      </div>
    </div>
  </div>

  {{-- Kolom kanan: pilih buku --}}
  <div class="col-lg-7">
    <div class="form-card">
      <h2 style="font-size:1rem;font-weight:800;color:#0b1730;margin-bottom:4px">
        <i class="bi bi-books" style="color:var(--crimson);margin-right:8px"></i>Buku dalam Series
      </h2>
      <p style="font-size:.78rem;color:#9ca3af;margin-bottom:16px">Cari dan pilih buku. Urutan = urutan klik.</p>

      {{-- Search --}}
      <div class="buku-search-wrap">
        <input type="text" id="bukuSearch" class="form-control" placeholder="🔍  Cari judul buku...">
      </div>

      {{-- List semua buku (filterable) --}}
      <div class="buku-list" id="bukuList">
        @foreach($semuaBuku as $b)
        <div class="buku-item" data-id="{{ $b->id }}" data-title="{{ $b->judul }}" data-author="{{ $b->pengarang }}"
             onclick="toggleBuku(this)">
          <div class="buku-item-cover">
            @if($b->cover)
              <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}" loading="lazy">
            @else
              <div style="width:100%;height:100%;background:linear-gradient(135deg,#0f1f3d,#1e4080);display:flex;align-items:center;justify-content:center">
                <i class="bi bi-book-fill" style="color:rgba(255,255,255,.5);font-size:.8rem"></i>
              </div>
            @endif
          </div>
          <div class="buku-item-info">
            <div class="buku-item-title">{{ $b->judul }}</div>
            <div class="buku-item-author">{{ $b->pengarang }}</div>
          </div>
          <i class="bi bi-plus-circle" style="color:#9ca3af;font-size:1.1rem"></i>
        </div>
        @endforeach
      </div>

      {{-- Buku terpilih (urutan) --}}
      <div class="selected-list">
        <div style="font-size:.78rem;font-weight:700;color:#374151;margin-bottom:8px">
          Buku Terpilih <span id="selectedCount" style="color:var(--crimson)">(0)</span>
        </div>
        <div id="selectedBooks">
          <div class="empty-selected" id="emptyMsg">
            <i class="bi bi-hand-index" style="display:block;font-size:1.4rem;margin-bottom:4px"></i>
            Klik buku di atas untuk menambahkan ke series
          </div>
        </div>
        {{-- Hidden inputs dikirim ke server --}}
        <div id="hiddenInputs"></div>
      </div>
    </div>
  </div>
</div>

<div style="display:flex;gap:12px;margin-top:8px">
  <button type="submit" class="btn-save">
    <i class="bi bi-check-lg"></i> Simpan Series
  </button>
  <a href="{{ route('admin.series.index') }}" class="btn-back">Batal</a>
</div>

</form>

<script>
let selected = []; // [{id, title, author}]

// ── Filter buku saat search ───────────────────────────────
document.getElementById('bukuSearch').addEventListener('input', function(){
  const q = this.value.toLowerCase();
  document.querySelectorAll('.buku-item').forEach(item => {
    const match = item.dataset.title.toLowerCase().includes(q) ||
                  item.dataset.author.toLowerCase().includes(q);
    item.style.display = match ? '' : 'none';
  });
});

// ── Toggle pilih/hapus buku ───────────────────────────────
function toggleBuku(el){
  const id     = el.dataset.id;
  const title  = el.dataset.title;
  const author = el.dataset.author;
  const idx    = selected.findIndex(b => b.id === id);

  if(idx === -1){
    selected.push({id, title, author});
    el.classList.add('selected');
    el.querySelector('i.bi').className = 'bi bi-check-circle-fill';
    el.querySelector('i.bi').style.color = 'var(--crimson)';
  } else {
    selected.splice(idx, 1);
    el.classList.remove('selected');
    el.querySelector('i.bi').className = 'bi bi-plus-circle';
    el.querySelector('i.bi').style.color = '#9ca3af';
  }
  renderSelected();
}

// ── Render daftar terpilih ────────────────────────────────
function renderSelected(){
  const wrap  = document.getElementById('selectedBooks');
  const empty = document.getElementById('emptyMsg');
  const count = document.getElementById('selectedCount');
  const hiddenWrap = document.getElementById('hiddenInputs');

  count.textContent = '(' + selected.length + ')';
  hiddenWrap.innerHTML = '';

  if(selected.length === 0){
    wrap.innerHTML = '';
    wrap.appendChild(empty);
    return;
  }

  wrap.innerHTML = '';
  selected.forEach((b, i) => {
    // Visible card
    const div = document.createElement('div');
    div.className = 'selected-item';
    div.innerHTML = `
      <span class="num">${i+1}</span>
      <span class="title">${b.title}</span>
      <button type="button" class="rm" onclick="removeSelected(${i})" title="Hapus">
        <i class="bi bi-x-lg"></i>
      </button>`;
    wrap.appendChild(div);

    // Hidden input
    const inp = document.createElement('input');
    inp.type  = 'hidden';
    inp.name  = 'buku_ids[]';
    inp.value = b.id;
    hiddenWrap.appendChild(inp);
  });
}

function removeSelected(idx){
  const removed = selected.splice(idx, 1)[0];
  // Un-highlight di list
  const el = document.querySelector(`.buku-item[data-id="${removed.id}"]`);
  if(el){
    el.classList.remove('selected');
    el.querySelector('i.bi').className = 'bi bi-plus-circle';
    el.querySelector('i.bi').style.color = '#9ca3af';
  }
  renderSelected();
}
</script>

@endsection

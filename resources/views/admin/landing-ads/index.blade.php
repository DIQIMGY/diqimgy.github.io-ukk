@extends('layouts.app')
@section('title','Visual Ads')
@section('page-title','Visual Ads')
@section('content')
{{--
  VIEW: admin/landing-ads/index.blade.php
  FUNGSI: Halaman kelola banner/iklan visual di landing page publik.

  VARIABEL DARI LandingAdController::index():
    $ads          → Collection semua LandingAd, urut sort_order lalu id
    $bukuShowcase → Collection 6 buku terbaru (referensi preview)

  SECTION UTAMA:
    1. Hero          → statistik total/aktif/ada-video
    2. Upload form   → POST admin.landing-ads.store (input file multiple)
    3. Ad Grid       → kartu tiap iklan + drag-reorder + tombol edit/toggle/hapus
    4. Edit Modal    → modal ganti judul/deskripsi/youtube/foto per iklan
    5. Book showcase → referensi 6 buku terbaru

  HIDDEN FORMS (di bawah grid):
    - form#toggle-{id} → POST admin.landing-ads.toggle (aktif/nonaktif)
    - form#delete-{id} → DELETE admin.landing-ads.destroy (hapus + file)

  JAVASCRIPT:
    - Drag-reorder: drag kartu → ubah urutan → submit form adsOrderForm
    - openEditModal()  → buka modal edit, isi form dengan data iklan yang diklik
    - closeEditModal() → tutup modal, stop iframe YouTube
    - updateYtPreview() → preview live YouTube saat user ketik URL
--}}
<style>
/* ══ LANDING ADS ADMIN — PREMIUM ══ */
.la-wrap{display:flex;flex-direction:column;gap:18px}

/* ── Hero ── */
.la-hero{
  display:flex;align-items:flex-end;justify-content:space-between;gap:16px;flex-wrap:wrap;
  padding:24px 26px;border-radius:18px;position:relative;overflow:hidden;isolation:isolate;
  background:
    linear-gradient(125deg,rgba(11,23,48,.95),rgba(20,40,75,.88) 50%,rgba(237,27,59,.42)),
    url('/image/wood-bg.jpg') center/cover;
  color:#fff;box-shadow:0 12px 32px rgba(11,23,48,.22);
}
.la-hero::after{
  content:'';position:absolute;right:-40px;top:-50px;width:200px;height:200px;border-radius:50%;
  background:radial-gradient(circle,rgba(244,185,66,.22),transparent 70%);pointer-events:none;
}
.la-hero>*{position:relative;z-index:1}
.la-kicker{font-size:.65rem;font-weight:900;letter-spacing:.16em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:8px}
.la-hero h1{margin:0 0 6px;font-family:'Playfair Display',serif;font-size:clamp(1.35rem,2vw,1.75rem);font-weight:800}
.la-hero p{margin:0;font-size:.86rem;color:rgba(255,255,255,.7);max-width:48ch}
.la-stats{display:flex;gap:10px;flex-wrap:wrap}
.la-pill{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.14);backdrop-filter:blur(8px);border-radius:10px;padding:10px 14px;min-width:90px}
.la-pill b{display:block;font-size:1.25rem;font-weight:900;line-height:1}
.la-pill span{font-size:.62rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.55)}

/* ── Alerts ── */
.la-alert{border-radius:12px;padding:12px 16px;font-weight:600;font-size:.86rem;display:flex;align-items:center;gap:10px}
.la-alert.ok{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
.la-alert.err{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

/* ── Upload card ── */
.la-upload{background:#fff;border:1px solid var(--border);border-radius:16px;padding:20px;box-shadow:var(--sh-xs)}
.la-upload-head{display:flex;align-items:center;gap:9px;margin-bottom:4px}
.la-upload-head h3{margin:0;font-size:.95rem;font-weight:800;color:var(--navy-800)}
.la-upload-head i{color:var(--crimson)}
.la-upload-sub{margin:0 0 14px;font-size:.78rem;color:var(--tx-3)}
.la-upload-row{display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.la-file{
  flex:1;min-width:220px;padding:12px 14px;border:1.5px dashed #cbd5e1;border-radius:12px;
  background:#f8fafc;font-size:.82rem;color:var(--tx-2);cursor:pointer;transition:border-color .15s;
}
.la-file:hover{border-color:var(--crimson)}
.la-btn{
  display:inline-flex;align-items:center;justify-content:center;gap:8px;border:0;border-radius:11px;
  padding:11px 18px;font-size:.82rem;font-weight:800;cursor:pointer;text-decoration:none;transition:all .2s;
}
.la-btn-primary{background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));color:#fff;box-shadow:0 5px 16px rgba(237,27,59,.28)}
.la-btn-primary:hover{transform:translateY(-1px);box-shadow:0 7px 20px rgba(237,27,59,.38);color:#fff}
.la-btn-ghost{background:#fff;border:1.5px solid var(--border);color:var(--tx-2)}
.la-btn-ghost:hover{border-color:var(--crimson);color:var(--crimson)}
.la-btn-amber{background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;box-shadow:0 5px 16px rgba(245,158,11,.28)}
.la-btn-amber:hover{transform:translateY(-1px);color:#fff}
.la-btn-sm{padding:8px 14px!important;font-size:.76rem!important}

/* ── Ad grid ── */
.la-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px}
.la-card{
  background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;
  box-shadow:var(--sh-xs);transition:transform .22s,box-shadow .22s;cursor:grab;
  position:relative;
}
.la-card:active{cursor:grabbing}
.la-card:hover{transform:translateY(-3px);box-shadow:var(--sh-md)}
.la-card.is-off{opacity:.55}
.la-card.has-detail .la-detail-dot{display:flex}

/* Preview area */
.la-preview{aspect-ratio:16/9;background:#0b1730;overflow:hidden;position:relative}
.la-preview img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .3s}
.la-card:hover .la-preview img{transform:scale(1.04)}
.la-order-badge{
  position:absolute;top:10px;left:10px;
  background:rgba(11,23,48,.82);color:#fff;
  padding:4px 9px;border-radius:7px;font-size:.68rem;font-weight:800;letter-spacing:.04em;
  backdrop-filter:blur(6px);
}
.la-drag-hint{
  position:absolute;top:10px;right:10px;background:rgba(255,255,255,.9);color:var(--navy-800);
  width:28px;height:28px;border-radius:8px;display:grid;place-items:center;font-size:.8rem;
  cursor:grab;
}
/* YouTube indicator on preview */
.la-yt-badge{
  position:absolute;bottom:10px;left:10px;
  display:flex;align-items:center;gap:6px;
  background:rgba(255,0,0,.9);color:#fff;
  padding:4px 10px;border-radius:7px;font-size:.68rem;font-weight:800;
  backdrop-filter:blur(4px);
}
/* Detail dot */
.la-detail-dot{
  display:none;position:absolute;bottom:10px;right:10px;
  width:26px;height:26px;border-radius:50%;
  background:var(--gold-400);color:var(--navy-900);
  place-items:center;font-size:.7rem;
  box-shadow:0 3px 10px rgba(0,0,0,.2);
}

/* Card body */
.la-body{padding:13px 14px}
.la-card-title{
  font-size:.84rem;font-weight:800;color:var(--navy-800);
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
  margin-bottom:8px;
}
.la-card-title.empty{color:var(--tx-4);font-style:italic;font-weight:500}
.la-card-desc{
  font-size:.72rem;color:var(--tx-3);line-height:1.5;
  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
  min-height:2.2em;margin-bottom:10px;
}
.la-card-footer{display:flex;align-items:center;justify-content:space-between;gap:8px}
.la-status{font-size:.72rem;font-weight:800;display:inline-flex;align-items:center;gap:6px}
.la-status::before{content:'';width:7px;height:7px;border-radius:50%;background:currentColor}
.la-status.on{color:#059669}.la-status.off{color:#94a3b8}
.la-actions{display:flex;gap:6px}
.la-ico{
  width:34px;height:34px;border:0;border-radius:9px;display:inline-flex;align-items:center;justify-content:center;
  cursor:pointer;font-size:.85rem;transition:all .15s;
}
.la-ico.edit{background:#fffbeb;color:#d97706}.la-ico.edit:hover{background:#fef3c7;color:#b45309}
.la-ico.toggle{background:#eff6ff;color:#2563eb}.la-ico.toggle:hover{background:#dbeafe}
.la-ico.del{background:#fff1f2;color:var(--crimson)}.la-ico.del:hover{background:#ffe4e6}

/* ── Empty ── */
.la-empty{
  text-align:center;padding:56px 20px;background:#fff;border:1.5px dashed var(--border);
  border-radius:16px;color:var(--tx-3);
}
.la-empty i{font-size:2.8rem;display:block;color:#cbd5e1;margin-bottom:12px}

/* ── Save order footer ── */
.la-foot{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-top:4px}

/* ── Book showcase ── */
.la-books{background:#fff;border:1px solid var(--border);border-radius:16px;padding:18px 20px;box-shadow:var(--sh-xs)}
.la-books h3{margin:0 0 12px;font-size:.92rem;font-weight:800;color:var(--navy-800);display:flex;align-items:center;gap:8px}
.la-books h3 i{color:var(--crimson)}
.la-book-row{display:grid;grid-template-columns:repeat(6,1fr);gap:12px}
.la-book{text-decoration:none;color:inherit;transition:transform .2s}
.la-book:hover{transform:translateY(-3px)}
.la-book-cover{aspect-ratio:2/3;border-radius:8px;overflow:hidden;background:#1e293b;margin-bottom:6px;box-shadow:0 6px 16px rgba(11,23,48,.15)}
.la-book-cover img{width:100%;height:100%;object-fit:cover}
.la-book-cover .ph{width:100%;height:100%;display:grid;place-items:center;color:rgba(255,255,255,.4);background:linear-gradient(150deg,#0f1f3d,#1e4080)}
.la-book strong{display:block;font-size:.7rem;font-weight:800;color:var(--navy-800);line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.la-book span{font-size:.62rem;color:var(--tx-4)}

/* ══ EDIT MODAL ══ */
.la-modal-bg{
  position:fixed;inset:0;z-index:1200;
  background:rgba(8,15,30,.72);backdrop-filter:blur(6px);
  display:flex;align-items:center;justify-content:center;
  padding:20px;opacity:0;pointer-events:none;transition:opacity .22s;
}
.la-modal-bg.open{opacity:1;pointer-events:all}
.la-modal{
  background:#fff;border-radius:20px;width:100%;max-width:620px;max-height:90vh;
  overflow-y:auto;box-shadow:0 32px 80px rgba(0,0,0,.35);
  transform:translateY(20px) scale(.97);transition:transform .22s,opacity .22s;
}
.la-modal-bg.open .la-modal{transform:none}
.la-modal-head{
  display:flex;align-items:center;justify-content:space-between;gap:12px;
  padding:20px 24px;border-bottom:1px solid var(--border-2);
  background:linear-gradient(180deg,#fff,#fafbfc);border-radius:20px 20px 0 0;
  position:sticky;top:0;z-index:2;
}
.la-modal-head h3{
  margin:0;font-size:1rem;font-weight:800;color:var(--navy-800);
  display:flex;align-items:center;gap:9px;
}
.la-modal-head h3 i{color:var(--crimson)}
.la-modal-close{
  width:36px;height:36px;border-radius:10px;border:1.5px solid var(--border);
  background:#fff;display:grid;place-items:center;cursor:pointer;
  font-size:1.1rem;color:var(--tx-3);transition:all .15s;
}
.la-modal-close:hover{background:var(--crimson);color:#fff;border-color:var(--crimson)}
.la-modal-body{padding:24px}
.la-modal-preview{
  width:100%;aspect-ratio:16/9;border-radius:12px;overflow:hidden;
  background:#0b1730;margin-bottom:20px;position:relative;
}
.la-modal-preview img{width:100%;height:100%;object-fit:cover;display:block}
.la-modal-preview-overlay{
  position:absolute;inset:0;background:rgba(11,23,48,.35);
  display:flex;align-items:center;justify-content:center;
}
.la-form-group{margin-bottom:16px}
.la-form-group:last-child{margin-bottom:0}
.la-label{font-size:.78rem;font-weight:700;color:var(--tx-2);display:block;margin-bottom:6px}
.la-label span{color:var(--crimson);margin-left:2px}
.la-input{
  width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:10px;
  font-size:.84rem;color:var(--tx-1);background:#fff;font-family:'Inter',sans-serif;
  transition:border-color .18s,box-shadow .18s;
}
.la-input:focus{outline:none;border-color:var(--crimson);box-shadow:0 0 0 3px rgba(237,27,59,.1)}
.la-textarea{resize:vertical;min-height:90px}
.la-hint{font-size:.7rem;color:var(--tx-4);margin-top:4px}
.la-yt-preview{
  margin-top:10px;border-radius:10px;overflow:hidden;background:#000;
  aspect-ratio:16/9;position:relative;display:none;
}
.la-yt-preview.show{display:block}
.la-yt-preview iframe{width:100%;height:100%;border:0}
.la-modal-foot{
  padding:16px 24px;border-top:1px solid var(--border-2);
  display:flex;align-items:center;justify-content:flex-end;gap:10px;
  background:#fafbfc;border-radius:0 0 20px 20px;
  position:sticky;bottom:0;
}
/* Image replace area */
.la-img-replace{
  border:1.5px dashed #cbd5e1;border-radius:10px;padding:12px 14px;
  background:#f8fafc;font-size:.8rem;color:var(--tx-3);cursor:pointer;transition:border-color .15s;
}
.la-img-replace:hover{border-color:var(--crimson)}

@media(max-width:900px){.la-book-row{grid-template-columns:repeat(3,1fr)}}
@media(max-width:640px){
  .la-hero{padding:20px}
  .la-grid{grid-template-columns:1fr 1fr;gap:12px}
  .la-upload-row{flex-direction:column;align-items:stretch}
  .la-book-row{grid-template-columns:repeat(2,1fr)}
  .la-modal{max-width:100%;max-height:95vh}
  .la-modal-body{padding:18px}
}
@media(max-width:400px){.la-grid{grid-template-columns:1fr}}
</style>

<div class="la-wrap">

  @if(session('success'))
  <div class="la-alert ok"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
  @endif
  @if($errors->any())
  <div class="la-alert err"><i class="bi bi-exclamation-triangle-fill"></i>{{ $errors->first() }}</div>
  @endif

  {{-- Hero --}}
  <section class="la-hero">
    <div>
      <div class="la-kicker">Landing page · visual control</div>
      <h1>Visual Ads</h1>
      <p>Kelola billboard foto di landing page. Tambah detail & video YouTube lalu klik kartu untuk edit.</p>
    </div>
    <div class="la-stats">
      <div class="la-pill"><b>{{ $ads->count() }}</b><span>Total</span></div>
      <div class="la-pill"><b>{{ $ads->where('is_active',true)->count() }}</b><span>Aktif</span></div>
      <div class="la-pill"><b>{{ $ads->whereNotNull('youtube_url')->count() }}</b><span>Ada Video</span></div>
    </div>
  </section>

  {{-- Upload --}}
  <section class="la-upload">
    <div class="la-upload-head">
      <i class="bi bi-cloud-arrow-up-fill"></i>
      <h3>Upload Foto Iklan</h3>
    </div>
    <p class="la-upload-sub">JPG, PNG, atau WEBP · maks. 5 MB per file · bisa pilih beberapa sekaligus</p>
    <form action="{{ route('admin.landing-ads.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="la-upload-row">
        <input class="la-file" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple required>
        <button class="la-btn la-btn-primary" type="submit"><i class="bi bi-upload"></i> Upload</button>
      </div>
    </form>
  </section>

  {{-- Ad Grid --}}
  @if($ads->isEmpty())
  <div class="la-empty">
    <i class="bi bi-images"></i>
    <strong style="display:block;font-size:1rem;color:var(--navy-800);margin-bottom:6px">Belum ada foto iklan</strong>
    <div style="font-size:.82rem">Upload foto pertama untuk menampilkan billboard di landing page.</div>
  </div>
  @else
  <form action="{{ route('admin.landing-ads.reorder') }}" method="POST" id="adsOrderForm">
    @csrf
    <div class="la-grid" id="adsGrid">
      @foreach($ads as $ad)
      <article class="la-card {{ !$ad->is_active ? 'is-off' : '' }} {{ $ad->title || $ad->youtube_url ? 'has-detail' : '' }}"
               draggable="true" data-id="{{ $ad->id }}">
        <div class="la-preview">
          <img src="{{ Storage::url($ad->image_path) }}" alt="Iklan {{ $loop->iteration }}" loading="lazy">
          <span class="la-order-badge">#{{ $loop->iteration }}</span>
          <span class="la-drag-hint"><i class="bi bi-grip-vertical"></i></span>
          @if($ad->youtube_id)
          <span class="la-yt-badge"><i class="bi bi-youtube"></i> Video</span>
          @endif
          <span class="la-detail-dot"><i class="bi bi-info-lg"></i></span>
        </div>
        <div class="la-body">
          <div class="la-card-title {{ !$ad->title ? 'empty' : '' }}">
            {{ $ad->title ?: 'Belum ada judul — klik Edit' }}
          </div>
          <div class="la-card-desc">
            {{ $ad->description ?: '' }}
          </div>
          <div class="la-card-footer">
            <span class="la-status {{ $ad->is_active ? 'on' : 'off' }}">{{ $ad->is_active ? 'Aktif' : 'Nonaktif' }}</span>
            <div class="la-actions">
              <button class="la-ico edit" type="button" title="Edit detail"
                      onclick="openEditModal({{ $ad->id }},
                        {{ json_encode($ad->title ?? '') }},
                        {{ json_encode($ad->description ?? '') }},
                        {{ json_encode($ad->youtube_url ?? '') }},
                        '{{ Storage::url($ad->image_path) }}')">
                <i class="bi bi-pencil-fill"></i>
              </button>
              <button class="la-ico toggle" type="button" title="Aktif/nonaktif"
                      onclick="document.getElementById('toggle-{{ $ad->id }}').submit()">
                <i class="bi bi-eye{{ $ad->is_active ? '-slash' : '' }}-fill"></i>
              </button>
              <button class="la-ico del" type="button" title="Hapus"
                      onclick="if(confirm('Hapus iklan ini?')) document.getElementById('delete-{{ $ad->id }}').submit()">
                <i class="bi bi-trash3-fill"></i>
              </button>
            </div>
          </div>
        </div>
      </article>
      @endforeach
    </div>
    <div class="la-foot">
      <button class="la-btn la-btn-primary" type="submit"><i class="bi bi-arrows-move"></i> Simpan Urutan</button>
    </div>
  </form>

  {{-- Hidden action forms --}}
  @foreach($ads as $ad)
  <form id="toggle-{{ $ad->id }}" action="{{ route('admin.landing-ads.toggle',$ad) }}" method="POST" style="display:none">@csrf</form>
  <form id="delete-{{ $ad->id }}" action="{{ route('admin.landing-ads.destroy',$ad) }}" method="POST" style="display:none">@csrf @method('DELETE')</form>
  @endforeach
  @endif

  {{-- Book showcase --}}
  @if(isset($bukuShowcase) && $bukuShowcase->isNotEmpty())
  <section class="la-books">
    <h3><i class="bi bi-journal-richtext"></i> Referensi koleksi buku</h3>
    <div class="la-book-row">
      @foreach($bukuShowcase as $b)
      <a href="{{ route('admin.buku.show',$b) }}" class="la-book">
        <div class="la-book-cover">
          @if($b->cover)
            <img src="{{ Storage::url($b->cover) }}" alt="{{ $b->judul }}" loading="lazy">
          @else
            <div class="ph"><i class="bi bi-book-fill"></i></div>
          @endif
        </div>
        <strong>{{ $b->judul }}</strong>
        <span>{{ $b->pengarang }}</span>
      </a>
      @endforeach
    </div>
  </section>
  @endif
</div>

{{-- ══ EDIT MODAL ══ --}}
<div class="la-modal-bg" id="editModal" onclick="if(event.target===this) closeEditModal()">
  <div class="la-modal">
    <div class="la-modal-head">
      <h3><i class="bi bi-pencil-square"></i> Edit Detail Iklan</h3>
      <button class="la-modal-close" type="button" onclick="closeEditModal()">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>

    <form id="editForm" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="la-modal-body">

        {{-- Preview current image --}}
        <div class="la-modal-preview" id="modalPreviewWrap">
          <img id="modalPreviewImg" src="" alt="Preview iklan">
        </div>

        {{-- Replace image --}}
        <div class="la-form-group">
          <label class="la-label">Ganti Foto <span style="font-weight:400;color:var(--tx-4)">(opsional)</span></label>
          <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                 class="la-img-replace" id="modalImageInput"
                 onchange="previewNewImage(this)">
          <div class="la-hint">Kosongkan jika tidak ingin ganti foto. Maks. 5 MB.</div>
        </div>

        {{-- Title --}}
        <div class="la-form-group">
          <label class="la-label" for="modalTitle">Judul Iklan</label>
          <input type="text" name="title" id="modalTitle" class="la-input"
                 placeholder="Contoh: Album Terbaru BLACKPINK" maxlength="120">
        </div>

        {{-- Description --}}
        <div class="la-form-group">
          <label class="la-label" for="modalDesc">Deskripsi</label>
          <textarea name="description" id="modalDesc" class="la-input la-textarea"
                    placeholder="Tuliskan deskripsi singkat tentang iklan ini..." maxlength="1000"></textarea>
        </div>

        {{-- YouTube URL --}}
        <div class="la-form-group">
          <label class="la-label" for="modalYt">
            <i class="bi bi-youtube" style="color:#ff0000"></i> Link YouTube
          </label>
          <input type="url" name="youtube_url" id="modalYt" class="la-input"
                 placeholder="https://www.youtube.com/watch?v=..."
                 oninput="updateYtPreview(this.value)">
          <div class="la-hint">Paste URL video YouTube — otomatis jadi embed di landing page.</div>
          {{-- Live YouTube preview --}}
          <div class="la-yt-preview" id="ytLivePreview">
            <iframe id="ytLiveIframe" src="" allowfullscreen allow="autoplay"></iframe>
          </div>
        </div>

      </div>
      <div class="la-modal-foot">
        <button type="button" class="la-btn la-btn-ghost" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="la-btn la-btn-primary"><i class="bi bi-check-lg"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
/* ── Drag-reorder ── */
(function(){
  var grid = document.getElementById('adsGrid');
  var form = document.getElementById('adsOrderForm');
  if(!grid || !form) return;
  var dragged;
  grid.querySelectorAll('.la-card').forEach(function(card){
    card.addEventListener('dragstart', function(){ dragged=card; card.style.opacity='.4'; });
    card.addEventListener('dragend',   function(){ dragged=null; card.style.opacity='';
      grid.querySelectorAll('.la-order-badge').forEach(function(el,i){ el.textContent='#'+(i+1); });
    });
    card.addEventListener('dragover', function(e){
      e.preventDefault();
      if(dragged && dragged!==card) card.parentNode.insertBefore(dragged,card);
    });
  });
  form.addEventListener('submit', function(){
    form.querySelectorAll('input[name="order[]"]').forEach(function(i){ i.remove(); });
    grid.querySelectorAll('.la-card').forEach(function(card){
      var inp=document.createElement('input');
      inp.type='hidden'; inp.name='order[]'; inp.value=card.dataset.id;
      form.appendChild(inp);
    });
  });
})();

/* ── Edit modal ── */
function openEditModal(id, title, desc, ytUrl, imgSrc){
  var modal = document.getElementById('editModal');
  var form  = document.getElementById('editForm');
  form.action = '/admin/landing-ads/' + id + '/update';

  document.getElementById('modalPreviewImg').src = imgSrc;
  document.getElementById('modalTitle').value     = title || '';
  document.getElementById('modalDesc').value      = desc  || '';
  document.getElementById('modalYt').value        = ytUrl || '';
  document.getElementById('modalImageInput').value = '';

  /* Reset YT preview */
  updateYtPreview(ytUrl || '');

  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeEditModal(){
  document.getElementById('editModal').classList.remove('open');
  document.body.style.overflow = '';
  /* Stop any playing iframe */
  var iframe = document.getElementById('ytLiveIframe');
  iframe.src = '';
  document.getElementById('ytLivePreview').classList.remove('show');
}

/* Live YT preview inside modal */
function updateYtPreview(url){
  var preview = document.getElementById('ytLivePreview');
  var iframe  = document.getElementById('ytLiveIframe');
  var id = extractYtId(url);
  if(id){
    iframe.src = 'https://www.youtube.com/embed/'+id+'?rel=0&modestbranding=1';
    preview.classList.add('show');
  } else {
    iframe.src = '';
    preview.classList.remove('show');
  }
}

function extractYtId(url){
  var m = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_\-]{11})/);
  return m ? m[1] : null;
}

/* Preview newly selected image */
function previewNewImage(input){
  if(!input.files || !input.files[0]) return;
  var reader = new FileReader();
  reader.onload = function(e){ document.getElementById('modalPreviewImg').src = e.target.result; };
  reader.readAsDataURL(input.files[0]);
}

/* Close modal on Escape */
document.addEventListener('keydown', function(e){
  if(e.key==='Escape') closeEditModal();
});
</script>
@endsection

@push('styles')
<style>
/* ── la-btn-primary: crimson glow + shimmer ── */
.la-btn-primary{
  position:relative;overflow:hidden;
  animation:laBtnGlow 2.6s ease-in-out infinite;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s ease !important;
}
@keyframes laBtnGlow{
  0%,100%{box-shadow:0 5px 16px rgba(237,27,59,.28)}
  50%{box-shadow:0 9px 28px rgba(237,27,59,.52),0 0 0 5px rgba(237,27,59,.1)}
}
.la-btn-primary:hover{
  animation:none;
  transform:translateY(-3px) scale(1.04) !important;
  box-shadow:0 12px 32px rgba(237,27,59,.5) !important;
}
.la-btn-primary::before{
  content:'';position:absolute;top:0;left:-110%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-20deg);pointer-events:none;
}
.la-btn-primary:hover::before{animation:laShimmer .5s ease forwards;}
@keyframes laShimmer{0%{left:-110%}100%{left:120%}}
.la-btn-primary i{display:inline-block;transition:transform .3s cubic-bezier(.34,1.56,.64,1);}
/* Upload icon floats up */
.la-btn-primary:hover i.bi-upload{animation:laUploadFloat .5s ease;}
@keyframes laUploadFloat{
  0%{transform:translateY(0) scale(1)}
  35%{transform:translateY(-7px) scale(1.15)}
  65%{transform:translateY(-3px) scale(1.08)}
  100%{transform:translateY(0) scale(1)}
}
/* Save icon bounces */
.la-btn-primary:hover i.bi-check-lg,
.la-btn-primary:hover i.bi-arrows-move{animation:laIconBounce .45s ease;}
@keyframes laIconBounce{
  0%{transform:scale(1) rotate(0)}
  30%{transform:scale(1.4) rotate(-10deg)}
  55%{transform:scale(.85) rotate(5deg)}
  75%{transform:scale(1.1) rotate(-3deg)}
  100%{transform:scale(1) rotate(0)}
}
/* ── la-btn-ghost (Batal): fade red ── */
.la-btn-ghost{
  position:relative;overflow:hidden;
  transition:all .22s cubic-bezier(.34,1.56,.64,1) !important;
}
.la-btn-ghost:hover{
  background:#fff1f2 !important;border-color:#fca5a5 !important;color:#be123c !important;
  transform:translateY(-2px) !important;
}
.la-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:laRipple .4s linear;pointer-events:none;}
@keyframes laRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.la-btn').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='la-ripple';
      const rect=btn.getBoundingClientRect(),size=Math.max(rect.width,rect.height)*1.8;
      r.style.cssText=`width:${size}px;height:${size}px;left:${e.clientX-rect.left-size/2}px;top:${e.clientY-rect.top-size/2}px`;
      if(getComputedStyle(btn).position==='static')btn.style.position='relative';
      btn.style.overflow='hidden';btn.appendChild(r);
      r.addEventListener('animationend',()=>r.remove());
    });
  });
});
</script>
@endpush

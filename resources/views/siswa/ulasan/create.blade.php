@extends('layouts.app')
@section('title','Beri Ulasan')
@section('page-title','Ulasan Buku')
@section('content')

<style>
/* ════ RATING PAGE ════ */
.ulasan-wrap{
  max-width:560px;margin:0 auto;
}
.ulasan-card{
  background:var(--surface);border-radius:20px;
  border:1px solid var(--border);
  box-shadow:0 4px 24px rgba(0,0,0,.06);
  overflow:hidden;
}

/* Success / already-rated state */
.ulasan-done{
  text-align:center;padding:56px 32px;
}
.ulasan-done-icon{
  font-size:3.5rem;margin-bottom:16px;line-height:1;
}

/* Book hero */
.ulasan-book-hero{
  display:flex;gap:18px;align-items:center;
  padding:24px 24px 20px;
  background:linear-gradient(135deg,var(--navy-950,#06101F) 0%,var(--navy-800,#14284B) 100%);
  position:relative;overflow:hidden;
}
.ulasan-book-hero::after{
  content:'';position:absolute;right:-60px;top:-60px;
  width:200px;height:200px;border-radius:50%;
  background:radial-gradient(circle,rgba(237,27,59,.15),transparent 70%);
  pointer-events:none;
}
.ulasan-book-cover{
  width:72px;height:108px;border-radius:10px;
  object-fit:cover;flex-shrink:0;
  box-shadow:0 8px 24px rgba(0,0,0,.4);
}
.ulasan-book-cover-ph{
  width:72px;height:108px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,#1e3a5f,#2563eb);
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 8px 24px rgba(0,0,0,.4);
}
.ulasan-book-info{ flex:1;min-width:0;position:relative;z-index:1; }
.ulasan-book-kat{
  font-size:.62rem;font-weight:800;text-transform:uppercase;
  letter-spacing:.1em;color:rgba(255,255,255,.45);margin-bottom:6px;
}
.ulasan-book-title{
  font-size:1rem;font-weight:800;color:#fff;line-height:1.3;
  margin-bottom:4px;
  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.ulasan-book-author{
  font-size:.78rem;color:rgba(255,255,255,.55);
}

/* Form body */
.ulasan-form-body{ padding:24px; }
.ulasan-prompt{
  text-align:center;margin-bottom:24px;
}
.ulasan-prompt h3{
  font-size:1rem;font-weight:800;color:var(--navy-800,#14284B);
  margin-bottom:4px;letter-spacing:-.01em;
}
.ulasan-prompt p{
  font-size:.8rem;color:var(--tx-3,#6B7280);
}

/* Star rating input */
.star-group{
  display:flex;justify-content:center;gap:6px;margin-bottom:8px;
  flex-direction:row-reverse;
}
.star-group input[type=radio]{
  display:none;
}
.star-group label{
  font-size:2.6rem;color:#e5e7eb;
  cursor:pointer;transition:color .15s,transform .15s;
  line-height:1;
}
/* hover + checked via CSS — flex-direction:row-reverse trick */
.star-group input:checked ~ label,
.star-group label:hover,
.star-group label:hover ~ label{
  color:#f59e0b;
  transform:scale(1.12);
}
.star-group input:checked ~ label{
  color:#f59e0b;
}
.star-hint{
  text-align:center;font-size:.75rem;color:var(--tx-4,#9CA3AF);
  min-height:1.2em;margin-bottom:20px;transition:color .15s;
}

/* Komentar */
.ulasan-label{
  font-size:.78rem;font-weight:700;color:var(--tx-2,#374151);
  margin-bottom:6px;display:block;
}
.ulasan-textarea{
  width:100%;border:1.5px solid var(--border,#E5E7EB);
  border-radius:10px;padding:12px 14px;
  font-size:.84rem;color:var(--tx-1,#1F2937);
  font-family:inherit;resize:vertical;min-height:100px;
  transition:border-color .2s,box-shadow .2s;
  background:var(--surface,#fff);
}
.ulasan-textarea:focus{
  outline:none;border-color:#f59e0b;
  box-shadow:0 0 0 3px rgba(245,158,11,.12);
}
.ulasan-char{
  font-size:.7rem;color:var(--tx-4,#9CA3AF);
  text-align:right;margin-top:4px;
}

/* Buttons */
.ulasan-actions{
  display:flex;gap:10px;margin-top:20px;
}
.btn-ulasan-submit{
  flex:1;padding:12px;border-radius:10px;
  background:linear-gradient(135deg,#f59e0b,#d97706);
  color:#fff;font-weight:800;font-size:.88rem;
  border:none;cursor:pointer;
  box-shadow:0 4px 14px rgba(245,158,11,.3);
  transition:all .2s;
  display:flex;align-items:center;justify-content:center;gap:7px;
}
.btn-ulasan-submit:hover{
  transform:translateY(-2px);
  box-shadow:0 6px 20px rgba(245,158,11,.4);
}
.btn-ulasan-skip{
  padding:12px 18px;border-radius:10px;
  background:var(--surface,#fff);color:var(--tx-3,#6B7280);
  font-size:.82rem;font-weight:600;
  border:1.5px solid var(--border,#E5E7EB);cursor:pointer;
  transition:all .2s;
  display:flex;align-items:center;justify-content:center;gap:6px;
}
.btn-ulasan-skip:hover{
  border-color:#cbd5e1;color:var(--tx-1,#1F2937);
}

/* Success banner at top */
.ulasan-success-banner{
  background:#f0fdf4;border-bottom:1px solid #bbf7d0;
  padding:12px 20px;display:flex;align-items:center;gap:10px;
  font-size:.83rem;font-weight:600;color:#15803d;
}
</style>

<div class="ulasan-wrap">

  {{-- Flash success (pengembalian berhasil) --}}
  @if(session('success'))
  <div class="ulasan-success-banner">
    <i class="bi bi-check-circle-fill" style="font-size:1rem;flex-shrink:0"></i>
    {{ session('success') }}
  </div>
  @endif

  <div class="ulasan-card">

    {{-- Book hero --}}
    <div class="ulasan-book-hero">
      @if($peminjaman->buku->cover)
        <img src="{{ Storage::url($peminjaman->buku->cover) }}"
             alt="{{ $peminjaman->buku->judul }}"
             class="ulasan-book-cover">
      @else
        <div class="ulasan-book-cover-ph">
          <i class="bi bi-book-fill" style="font-size:1.6rem;color:rgba(255,255,255,.7)"></i>
        </div>
      @endif

      <div class="ulasan-book-info">
        <div class="ulasan-book-kat">{{ $peminjaman->buku->kategori }}</div>
        <div class="ulasan-book-title">{{ $peminjaman->buku->judul }}</div>
        <div class="ulasan-book-author">{{ $peminjaman->buku->pengarang }}</div>
      </div>
    </div>

    {{-- Already rated --}}
    @if($sudahUlasan)
    <div class="ulasan-done">
      <div class="ulasan-done-icon">⭐</div>
      <h3 style="font-weight:800;color:var(--navy-800,#14284B);margin-bottom:8px">Sudah Diulas!</h3>
      <p style="font-size:.84rem;color:var(--tx-3,#6B7280);margin-bottom:24px">
        Kamu sudah memberikan ulasan untuk buku ini sebelumnya.
      </p>
      <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-ghost btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
      </a>
    </div>

    @else
    {{-- Rating form --}}
    <div class="ulasan-form-body">
      <div class="ulasan-prompt">
        <h3>Bagaimana pendapatmu tentang buku ini?</h3>
        <p>Ulasanmu membantu siswa lain dalam memilih buku. Tidak wajib diisi.</p>
      </div>

      <form method="POST" action="{{ route('siswa.ulasan.store', $peminjaman) }}" id="ulasanForm">
        @csrf

        {{-- Star picker --}}
        <div class="star-group" id="starGroup">
          @for($i = 5; $i >= 1; $i--)
            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                   {{ old('rating') == $i ? 'checked' : '' }}>
            <label for="star{{ $i }}" title="{{ $i }} bintang">&#9733;</label>
          @endfor
        </div>
        <div class="star-hint" id="starHint">Pilih bintang untuk memberi rating</div>

        @error('rating')
          <p style="color:#ef4444;font-size:.75rem;text-align:center;margin-bottom:8px">{{ $message }}</p>
        @enderror

        {{-- Komentar --}}
        <div style="margin-bottom:4px">
          <label class="ulasan-label" for="komentar">
            Komentar <span style="color:var(--tx-4,#9CA3AF);font-weight:500">(opsional)</span>
          </label>
          <textarea id="komentar" name="komentar" class="ulasan-textarea"
                    maxlength="500"
                    placeholder="Ceritakan pengalamanmu membaca buku ini...">{{ old('komentar') }}</textarea>
          <div class="ulasan-char">
            <span id="charCount">0</span>/500
          </div>
        </div>

        @error('komentar')
          <p style="color:#ef4444;font-size:.75rem;margin-top:2px">{{ $message }}</p>
        @enderror

        <div class="ulasan-actions">
          {{-- Skip — pakai form terpisah di LUAR form utama, dihubungkan via formaction --}}
          <button type="button"
            onclick="document.getElementById('skipForm').submit()"
            class="btn-ulasan-skip">
            <i class="bi bi-skip-forward"></i> Lewati
          </button>

          {{-- Submit --}}
          <button type="submit" form="ulasanForm" class="btn-ulasan-submit">
            <i class="bi bi-send-fill"></i> Kirim Ulasan
          </button>
        </div>
      </form>

      {{-- Form Skip di luar form utama (tidak boleh nested) --}}
      <form id="skipForm" method="POST" action="{{ route('siswa.ulasan.skip', $peminjaman) }}" style="display:none">
        @csrf
      </form>
    </div>
    @endif

  </div>

  {{-- Skip link below card --}}
  @if(!$sudahUlasan)
  <p style="text-align:center;margin-top:14px;font-size:.76rem;color:var(--tx-4,#9CA3AF)">
    Ulasan bersifat opsional dan tidak mempengaruhi proses pengembalian.
  </p>
  @endif

</div>

<script>
(function(){
  const hints = ['','Sangat buruk','Kurang bagus','Cukup bagus','Bagus sekali','Luar biasa! ⭐'];
  const hintEl = document.getElementById('starHint');
  const radios = document.querySelectorAll('.star-group input[type=radio]');
  const textarea = document.getElementById('komentar');
  const charCount = document.getElementById('charCount');

  // Star hint
  radios.forEach(r => {
    r.addEventListener('change', () => {
      hintEl.textContent = hints[r.value] || '';
      hintEl.style.color = '#f59e0b';
    });
  });

  // Char count
  if(textarea && charCount){
    charCount.textContent = textarea.value.length;
    textarea.addEventListener('input', () => {
      charCount.textContent = textarea.value.length;
    });
  }
})();
</script>
@endsection

@push('styles')
<style>
/* ── btn-ulasan-submit (Kirim Ulasan): amber glow + send icon flies ── */
.btn-ulasan-submit{
  position:relative;overflow:hidden;
  animation:ulasanGlow 2.5s ease-in-out infinite;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s ease !important;
}
@keyframes ulasanGlow{
  0%,100%{box-shadow:0 4px 14px rgba(245,158,11,.3)}
  50%{box-shadow:0 8px 26px rgba(245,158,11,.58),0 0 0 5px rgba(245,158,11,.12)}
}
.btn-ulasan-submit:hover{
  animation:none;
  transform:translateY(-3px) scale(1.04) !important;
  box-shadow:0 12px 30px rgba(245,158,11,.5) !important;
}
.btn-ulasan-submit::before{
  content:'';position:absolute;top:0;left:-110%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-20deg);pointer-events:none;
}
.btn-ulasan-submit:hover::before{animation:ulShimmer .5s ease forwards;}
@keyframes ulShimmer{0%{left:-110%}100%{left:120%}}
.btn-ulasan-submit i{display:inline-block;}
.btn-ulasan-submit:hover i{animation:sendFly .5s ease;}
@keyframes sendFly{
  0%{transform:translate(0,0) rotate(0) scale(1)}
  30%{transform:translate(6px,-6px) rotate(-30deg) scale(1.2)}
  55%{transform:translate(-2px,2px) rotate(5deg) scale(.9)}
  80%{transform:translate(3px,-3px) rotate(-15deg) scale(1.1)}
  100%{transform:translate(0,0) rotate(0) scale(1)}
}
/* ── btn-ulasan-skip (Lewati): skip arrow slides ── */
.btn-ulasan-skip{
  position:relative;overflow:hidden;
  transition:all .22s cubic-bezier(.34,1.56,.64,1) !important;
}
.btn-ulasan-skip:hover{
  background:#f8fafc !important;
  transform:translateY(-2px) !important;
  box-shadow:0 4px 12px rgba(0,0,0,.08) !important;
}
.btn-ulasan-skip i{display:inline-block;transition:transform .3s cubic-bezier(.34,1.56,.64,1);}
.btn-ulasan-skip:hover i{transform:translateX(5px) scale(1.2);}
.ul-sub-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:ulSubRipple .4s linear;pointer-events:none;}
@keyframes ulSubRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.btn-ulasan-submit,.btn-ulasan-skip').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='ul-sub-ripple';
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

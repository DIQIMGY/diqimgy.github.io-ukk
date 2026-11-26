@extends('layouts.app')
@section('title','Kelola Ulasan')
@section('page-title','Kelola Ulasan')
@section('content')

<style>
.ul-wrap{display:flex;flex-direction:column;gap:18px}
.ul-hero{
  display:flex;align-items:flex-end;justify-content:space-between;gap:16px;flex-wrap:wrap;
  padding:24px 26px;border-radius:16px;position:relative;overflow:hidden;isolation:isolate;
  background:
    linear-gradient(125deg,rgba(11,23,48,.95),rgba(20,40,75,.88) 50%,rgba(245,158,11,.4)),
    url('/image/wood-bg.jpg') center/cover;
  color:#fff;box-shadow:0 12px 32px rgba(11,23,48,.22);
}
.ul-hero::after{
  content:'';position:absolute;right:-40px;top:-60px;width:200px;height:200px;border-radius:50%;
  background:radial-gradient(circle,rgba(251,191,36,.25),transparent 70%);pointer-events:none;
}
.ul-hero > *{position:relative;z-index:1}
.ul-kicker{font-size:.65rem;font-weight:900;letter-spacing:.16em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:8px}
.ul-hero h1{margin:0 0 6px;font-family:'Playfair Display',serif;font-size:clamp(1.35rem,2vw,1.75rem);font-weight:800}
.ul-hero p{margin:0;font-size:.86rem;color:rgba(255,255,255,.7)}
.ul-hero-rate{
  background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.14);backdrop-filter:blur(8px);
  border-radius:14px;padding:14px 18px;text-align:center;min-width:120px;
}
.ul-hero-rate b{display:block;font-size:1.8rem;font-weight:900;color:#fbbf24;line-height:1}
.ul-hero-rate span{font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:rgba(255,255,255,.55)}

.ul-stats{display:grid;grid-template-columns:1fr 1fr 1.6fr;gap:14px}
.ul-stat{
  background:#fff;border:1px solid var(--border);border-radius:14px;padding:18px 20px;box-shadow:var(--sh-xs);
}
.ul-stat b{display:block;font-size:1.7rem;font-weight:900;color:var(--navy-800);letter-spacing:-.03em;line-height:1}
.ul-stat.gold b{color:#d97706}
.ul-stat span{display:block;margin-top:6px;font-size:.7rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:var(--tx-3)}
.ul-dist-title{font-size:.7rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:var(--tx-3);margin-bottom:10px}
.ul-bar{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.ul-bar:last-child{margin-bottom:0}
.ul-bar-n{width:12px;font-size:.74rem;font-weight:800;color:var(--tx-2);text-align:right}
.ul-bar-track{flex:1;height:8px;background:#f1f5f9;border-radius:99px;overflow:hidden}
.ul-bar-fill{height:100%;background:linear-gradient(90deg,#f59e0b,#f97316);border-radius:99px}
.ul-bar-c{width:28px;font-size:.7rem;color:var(--tx-4);text-align:right;font-weight:700}

.ul-toolbar{
  background:#fff;border:1px solid var(--border);border-radius:14px;padding:14px 16px;
  display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;box-shadow:var(--sh-xs);
}
.ul-toolbar h3{margin:0;font-size:.92rem;font-weight:800;color:var(--navy-800);display:flex;align-items:center;gap:8px}
.ul-count{background:#f1f5f9;color:var(--navy-800);font-size:.72rem;font-weight:800;padding:3px 9px;border-radius:99px}
.ul-form{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.ul-input,.ul-select{
  padding:9px 12px;border:1.5px solid var(--border);border-radius:10px;font-size:.82rem;background:#fff;
}
.ul-input{min-width:200px}
.ul-input:focus,.ul-select:focus{outline:none;border-color:#f59e0b;box-shadow:0 0 0 3px rgba(245,158,11,.12)}
.ul-submit{
  display:inline-flex;align-items:center;gap:6px;padding:9px 14px;border-radius:10px;border:none;
  background:var(--navy-800);color:#fff;font-weight:700;font-size:.78rem;cursor:pointer;
}
.ul-ghost{
  display:inline-flex;align-items:center;gap:5px;padding:8px 12px;border-radius:10px;
  border:1.5px solid var(--border);background:#fff;color:var(--tx-2);font-weight:700;font-size:.78rem;text-decoration:none;
}

.ul-list{background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden;box-shadow:var(--sh-xs)}
.ul-row{
  display:grid;grid-template-columns:auto 1fr auto auto;gap:16px;align-items:center;
  padding:16px 18px;border-bottom:1px solid #f3f4f6;transition:background .12s;
}
.ul-row:last-child{border-bottom:none}
.ul-row:hover{background:#fafbfc}
.ul-ava{
  width:44px;height:44px;border-radius:12px;overflow:hidden;flex-shrink:0;
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  color:#fff;font-size:.85rem;font-weight:800;display:grid;place-items:center;
  box-shadow:0 4px 12px rgba(237,27,59,.25);
}
.ul-ava img{width:100%;height:100%;object-fit:cover}
.ul-who{font-size:.86rem;font-weight:800;color:var(--navy-800)}
.ul-who span{font-weight:600;color:var(--tx-4);font-size:.74rem;margin-left:6px}
.ul-stars{display:flex;gap:2px;margin:4px 0 6px}
.ul-star{font-size:.9rem;line-height:1;color:#e5e7eb}
.ul-star.on{color:#f59e0b}
.ul-quote{font-size:.84rem;color:var(--tx-1);line-height:1.5;margin:0 0 4px}
.ul-quote.empty{font-style:italic;color:var(--tx-4);font-size:.78rem}
.ul-time{font-size:.7rem;color:var(--tx-4)}

.ul-book{display:flex;align-items:center;gap:10px;min-width:160px;max-width:200px}
.ul-cover{width:40px;height:58px;border-radius:6px;overflow:hidden;flex-shrink:0;background:#1e293b;box-shadow:0 3px 10px rgba(0,0,0,.15)}
.ul-cover img{width:100%;height:100%;object-fit:cover}
.ul-cover .ph{width:100%;height:100%;display:grid;place-items:center;color:rgba(255,255,255,.5);background:linear-gradient(135deg,#1e3a5f,#2563eb);font-size:.8rem}
.ul-book strong{display:block;font-size:.78rem;font-weight:800;color:var(--navy-800);line-height:1.3;
  display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.ul-book span{font-size:.68rem;color:var(--tx-4)}

.ul-del{
  width:36px;height:36px;border-radius:9px;border:1px solid #fecdd3;background:#fff1f2;color:#be123c;
  display:grid;place-items:center;cursor:pointer;transition:all .15s;
}
.ul-del:hover{background:#ffe4e6}

.ul-empty{text-align:center;padding:52px 24px;color:var(--tx-4)}
.ul-empty i{font-size:2.5rem;opacity:.3;display:block;margin-bottom:10px}

.ul-alert{border-radius:12px;padding:12px 16px;font-weight:600;font-size:.86rem;display:flex;align-items:center;gap:10px;background:#ecfdf5;color:#065f46}

@media(max-width:900px){
  .ul-stats{grid-template-columns:1fr 1fr}
  .ul-stat:last-child{grid-column:1/-1}
  .ul-row{grid-template-columns:auto 1fr auto;gap:12px}
  .ul-book{grid-column:2;max-width:none;min-width:0}
}
@media(max-width:640px){
  .ul-hero{padding:20px}
  .ul-hero-rate{width:100%}
  .ul-toolbar{align-items:stretch;flex-direction:column}
  .ul-form{width:100%}
  .ul-input,.ul-select,.ul-submit,.ul-ghost{width:100%}
  .ul-form{display:grid;grid-template-columns:1fr}
  .ul-row{grid-template-columns:auto 1fr;padding:14px}
  .ul-book{grid-column:1/-1}
  .ul-del{grid-column:2;justify-self:end}
  .ul-stats{grid-template-columns:1fr}
}
@media(prefers-reduced-motion:reduce){
  .ul-wrap *,.ul-wrap *::before,.ul-wrap *::after{animation-duration:.01ms!important;animation-iteration-count:1!important;scroll-behavior:auto!important;transition-duration:.01ms!important}
}
.ul-hero{
  background:linear-gradient(115deg,#0b1730 0%,#14284b 72%,#263b5c 100%);
  border:1px solid rgba(255,255,255,.1);
  box-shadow:0 12px 28px rgba(11,23,48,.15);
}
.ul-hero::after{background:radial-gradient(circle,rgba(214,168,79,.18),transparent 70%)}
.ul-hero-rate{backdrop-filter:none;background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.2)}
.ul-stat,.ul-toolbar,.ul-list{border-color:#e7e5e4;box-shadow:0 2px 10px rgba(20,40,75,.045)}
.ul-stat{border-radius:12px}
.ul-stat.gold b{color:#946b1d}
.ul-bar-fill{background:#d6a84f}
.ul-input:focus,.ul-select:focus{border-color:#c41630;box-shadow:0 0 0 3px rgba(196,22,48,.12)}
.ul-submit{background:#14284b;min-height:40px}
.ul-submit:hover{background:#0b1730}
.ul-quote{overflow-wrap:anywhere}
.ul-row{grid-template-columns:44px minmax(0,1fr) minmax(150px,200px) 36px}
.ul-book{min-width:0}
.ul-del{flex-shrink:0}
.ul-wrap :focus-visible{outline:3px solid #d6a84f;outline-offset:3px}
@media(max-width:900px){.ul-row{grid-template-columns:44px minmax(0,1fr) 36px}.ul-book{grid-column:2;max-width:none}.ul-row>form{grid-column:3;grid-row:1}}
@media(max-width:640px){.ul-row{grid-template-columns:40px minmax(0,1fr);gap:10px}.ul-row>form{grid-column:2;grid-row:auto;justify-self:end}.ul-book{grid-column:1/-1}}
</style>

<div class="ul-wrap">

  {{-- Flash pesan sukses hapus ulasan --}}
  @if(session('success'))
  <div class="ul-alert"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
  @endif

  {{-- ═══ SECTION 1 — HERO ══════════════════════════════════════════
       Menampilkan rata-rata rating di kotak kanan
  ════════════════════════════════════════════════════════════════ --}}
  <section class="ul-hero">
    <div>
      <div class="ul-kicker">Moderasi komunitas</div>
      <h1>Kelola Ulasan</h1>
      <p>Pantau rating dan komentar pembaca terhadap koleksi buku.</p>
    </div>
    {{-- $rataRata dari controller: rata-rata semua ulasan, dibulatkan 1 desimal --}}
    <div class="ul-hero-rate">
      <b>{{ number_format($rataRata,1) }} ★</b>
      <span>Rata-rata</span>
    </div>
  </section>

  {{-- ═══ SECTION 2 — STAT CARDS ════════════════════════════════════
       Kartu ketiga: distribusi bintang sebagai progress bar
       $distribusi = array [5=>N, 4=>N, 3=>N, 2=>N, 1=>N] dari controller
  ════════════════════════════════════════════════════════════════ --}}
  <section class="ul-stats">
    <div class="ul-stat">
      <b>{{ $totalUlasan }}</b>
      <span>Total ulasan</span>
    </div>
    <div class="ul-stat gold">
      <b>{{ number_format($rataRata,1) }}</b>
      <span>Rating rata-rata</span>
    </div>
    <div class="ul-stat">
      <div class="ul-dist-title">Distribusi bintang</div>
      {{-- Loop dari bintang 5 ke 1 (terbanyak di atas) --}}
      @for($i=5;$i>=1;$i--)
        {{-- Hitung persentase bar: 0% jika belum ada ulasan sama sekali --}}
        @php $pct = $totalUlasan > 0 ? ($distribusi[$i] / $totalUlasan) * 100 : 0; @endphp
        <div class="ul-bar">
          <span class="ul-bar-n">{{ $i }}</span>
          <div class="ul-bar-track">
            <div class="ul-bar-fill" style="width:{{ $pct }}%"></div>
          </div>
          {{-- Jumlah ulasan untuk bintang ini --}}
          <span class="ul-bar-c">{{ $distribusi[$i] }}</span>
        </div>
      @endfor
    </div>
  </section>

  {{-- ═══ SECTION 3 — TOOLBAR + FILTER ═════════════════════════════
       Form GET: search (judul/nama/komentar) + filter rating (1-5)
       Tombol reset hanya muncul jika ada filter aktif
  ════════════════════════════════════════════════════════════════ --}}
  <section class="ul-toolbar">
    <h3>Semua Ulasan <span class="ul-count">{{ $ulasan->total() }}</span></h3>
    <form method="GET" class="ul-form">
      <input type="text" name="search" value="{{ request('search') }}" class="ul-input"
             placeholder="Cari buku, nama, komentar…">
      <select name="rating" class="ul-select">
        <option value="">Semua bintang</option>
        {{-- Dropdown bintang 5 sampai 1 --}}
        @for($i=5;$i>=1;$i--)
          <option value="{{ $i }}" {{ request('rating')==$i?'selected':'' }}>{{ $i }} bintang</option>
        @endfor
      </select>
      <button class="ul-submit" type="submit"><i class="bi bi-search"></i> Cari</button>
      {{-- Tombol reset hanya muncul jika ada filter aktif --}}
      @if(request('search') || request('rating'))
        <a href="{{ route('admin.ulasan.index') }}" class="ul-ghost"><i class="bi bi-x-lg"></i> Reset</a>
      @endif
    </form>
  </section>

  <section class="ul-list">
    @forelse($ulasan as $u)
    <article class="ul-row">
      <div class="ul-ava">
        @if($u->anggota && $u->anggota->foto)
          <img src="{{ Storage::url($u->anggota->foto) }}" alt="{{ $u->anggota->nama }}">
        @else
          {{ strtoupper(substr($u->anggota->nama ?? 'U',0,1)) }}
        @endif
      </div>

      <div style="min-width:0">
        <div class="ul-who">
          {{ $u->anggota->nama ?? '-' }}
          <span>· {{ $u->anggota->kelas ?? '' }}</span>
        </div>
        <div class="ul-stars">
          @for($s=1;$s<=5;$s++)
            <span class="ul-star {{ $s <= $u->rating ? 'on' : '' }}">★</span>
          @endfor
        </div>
        @if($u->komentar)
          <p class="ul-quote">“{{ $u->komentar }}”</p>
        @else
          <p class="ul-quote empty">Tanpa komentar</p>
        @endif
        <div class="ul-time">{{ $u->created_at->isoFormat('D MMM YYYY · HH:mm') }}</div>
      </div>

      <div class="ul-book">
        <div class="ul-cover">
          @if($u->buku && $u->buku->cover)
            <img src="{{ Storage::url($u->buku->cover) }}" alt="{{ $u->buku->judul }}" loading="lazy">
          @else
            <div class="ph"><i class="bi bi-book-fill"></i></div>
          @endif
        </div>
        <div style="min-width:0">
          <strong>{{ $u->buku->judul ?? '-' }}</strong>
          <span>{{ $u->buku->kategori ?? '' }}</span>
        </div>
      </div>

      <form method="POST" action="{{ route('admin.ulasan.destroy', $u) }}" onsubmit="return confirm('Hapus ulasan ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="ul-del" title="Hapus"><i class="bi bi-trash-fill"></i></button>
      </form>
    </article>
    @empty
    <div class="ul-empty">
      <i class="bi bi-chat-square-text"></i>
      Belum ada ulasan.
    </div>
    @endforelse

    @if($ulasan->hasPages())
    <div style="padding:16px;display:flex;justify-content:center">{{ $ulasan->links() }}</div>
    @endif
  </section>
</div>

@endsection

@push('styles')
<style>
/* ── ul-del: trash flies ── */
.ul-del{
  position:relative;overflow:hidden;
  transition:all .22s cubic-bezier(.34,1.56,.64,1) !important;
}
.ul-del:hover{
  background:#dc2626 !important;color:#fff !important;
  border-color:#dc2626 !important;
  transform:translateY(-2px) scale(1.12) !important;
  box-shadow:0 6px 18px rgba(220,38,38,.38) !important;
}
.ul-del i{display:inline-block;}
.ul-del:hover i{animation:ulTrashFly .5s cubic-bezier(.25,.46,.45,.94);}
@keyframes ulTrashFly{
  0%{transform:translateY(0) rotate(0) scale(1)}
  20%{transform:translateY(-9px) rotate(-18deg) scale(1.3)}
  45%{transform:translateY(-4px) rotate(12deg) scale(1.15)}
  65%{transform:translateY(-7px) rotate(-10deg) scale(1.2)}
  85%{transform:translateY(-2px) rotate(4deg) scale(1.05)}
  100%{transform:translateY(0) rotate(0) scale(1)}
}
/* ── ul-submit Cari: search bounces ── */
.ul-submit{
  position:relative;overflow:hidden;
  transition:all .22s cubic-bezier(.34,1.56,.64,1) !important;
}
.ul-submit:hover{
  transform:translateY(-2px) scale(1.04) !important;
  box-shadow:0 5px 14px rgba(20,40,75,.3) !important;
}
.ul-submit i{display:inline-block;}
.ul-submit:hover i{animation:ulSearchBounce .4s ease;}
@keyframes ulSearchBounce{
  0%{transform:scale(1) rotate(0)}
  30%{transform:scale(1.35) rotate(-20deg)}
  60%{transform:scale(.9) rotate(12deg)}
  100%{transform:scale(1) rotate(0)}
}
/* ── ul-ghost Reset: X spins ── */
.ul-ghost{
  position:relative;overflow:hidden;
  transition:all .22s cubic-bezier(.34,1.56,.64,1) !important;
}
.ul-ghost:hover{
  background:#fff1f2 !important;border-color:#fca5a5 !important;color:#be123c !important;
  transform:translateY(-2px) !important;
}
.ul-ghost i{display:inline-block;}
.ul-ghost:hover i{animation:ulXSpin .4s ease;}
@keyframes ulXSpin{
  0%{transform:rotate(0) scale(1)}50%{transform:rotate(90deg) scale(1.25)}100%{transform:rotate(0) scale(1)}
}
.ul-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:ulRipple .4s linear;pointer-events:none;}
@keyframes ulRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.ul-del,.ul-submit,.ul-ghost').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='ul-ripple';
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

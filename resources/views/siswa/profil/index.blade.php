@extends('layouts.app')
@section('title','Profil Saya')
@section('page-title','Profil Saya')
@section('content')
<style>
/* ══ PROFIL PAGE — PREMIUM v3 ══ */
.pf-wrap{display:flex;flex-direction:column;gap:22px;max-width:1200px;margin:0 auto}

/* ── Hero Bar ── */
.pf-hero{
  position:relative;overflow:hidden;isolation:isolate;
  border-radius:18px;padding:26px 30px;
  background:
    linear-gradient(125deg,rgba(11,23,48,.95) 0%,rgba(20,40,75,.9) 55%,rgba(120,10,30,.5) 100%),
    url('/image/wood-bg.jpg') center/cover;
  color:#fff;
  box-shadow:0 14px 36px rgba(11,23,48,.26);
  display:flex;align-items:center;gap:24px;
}
.pf-hero::before{
  content:'';position:absolute;inset:0;z-index:0;
  background:radial-gradient(ellipse at 85% 20%,rgba(244,185,66,.14),transparent 52%);
  pointer-events:none;
}
.pf-hero>*{position:relative;z-index:1}
.pf-hero-ava{
  width:72px;height:72px;border-radius:50%;flex-shrink:0;
  border:3px solid rgba(255,255,255,.25);
  box-shadow:0 8px 24px rgba(0,0,0,.3);object-fit:cover;
}
.pf-hero-ava-ph{
  width:72px;height:72px;border-radius:50%;flex-shrink:0;
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  display:grid;place-items:center;font-size:1.8rem;font-weight:900;color:#fff;
  border:3px solid rgba(255,255,255,.25);box-shadow:0 8px 24px rgba(237,27,59,.35);
}
.pf-hero-info{flex:1;min-width:0}
.pf-hero-kicker{font-size:.67rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:6px;display:flex;align-items:center;gap:7px}
.pf-hero-kicker span{width:5px;height:5px;border-radius:50%;background:var(--gold-400)}
.pf-hero h1{font-family:'Playfair Display',serif;font-size:clamp(1.3rem,2vw,1.75rem);font-weight:800;margin:0 0 8px;line-height:1.2;letter-spacing:-.02em}
.pf-hero-chips{display:flex;flex-wrap:wrap;align-items:center;gap:8px}
.pf-chip{
  display:inline-flex;align-items:center;gap:5px;
  padding:5px 12px;border-radius:8px;font-size:.73rem;font-weight:700;
  background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.18);
}
.pf-chip.active{background:rgba(16,185,129,.2);color:#6ee7b7;border-color:rgba(16,185,129,.3)}

/* ── Grid ── */
.pf-grid{display:grid;grid-template-columns:minmax(0,300px) minmax(0,1fr);gap:22px;align-items:start}

/* ── Side Card ── */
.pf-side-card{
  background:#fff;border:1px solid var(--border);border-radius:16px;
  box-shadow:var(--sh-xs);overflow:hidden;
}
.pf-side-header{
  background:linear-gradient(135deg,#0b1730 0%,#1e293b 60%,#334155 100%);
  padding:28px 22px;text-align:center;position:relative;
}
.pf-side-ava-wrap{position:relative;display:inline-block;margin-bottom:14px}
.pf-side-ava{width:88px;height:88px;border-radius:50%;object-fit:cover;border:4px solid rgba(255,255,255,.22);box-shadow:0 6px 22px rgba(0,0,0,.4)}
.pf-side-ava-ph{
  width:88px;height:88px;border-radius:50%;
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  display:grid;place-items:center;font-size:2rem;font-weight:900;color:#fff;
  border:4px solid rgba(255,255,255,.22);box-shadow:0 8px 26px rgba(237,27,59,.45);
}
.pf-ava-edit{
  position:absolute;bottom:3px;right:3px;
  width:28px;height:28px;border-radius:50%;
  background:var(--crimson);border:3px solid #fff;
  display:grid;place-items:center;cursor:pointer;
  transition:.22s;box-shadow:0 4px 12px rgba(237,27,59,.4);
}
.pf-ava-edit:hover{background:var(--crimson-dark);transform:scale(1.12)}
.pf-side-name{font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:5px;letter-spacing:-.01em}
.pf-side-nis{font-size:.78rem;color:rgba(255,255,255,.55);margin-bottom:11px}
.pf-side-status{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(16,185,129,.2);color:#6ee7b7;
  padding:5px 14px;border-radius:99px;font-size:.72rem;font-weight:700;
  border:1px solid rgba(16,185,129,.3);
}
.pf-meta{padding:0}
.pf-meta-row{
  display:flex;align-items:center;gap:12px;
  padding:13px 20px;border-bottom:1px solid #f3f4f6;
  transition:background .16s;
}
.pf-meta-row:last-child{border-bottom:none}
.pf-meta-row:hover{background:#fafbfc}
.pf-meta-ico{
  width:36px;height:36px;border-radius:9px;flex-shrink:0;
  background:linear-gradient(145deg,#f8fafc,#e2e8f0);
  display:grid;place-items:center;font-size:.84rem;color:var(--crimson);
  box-shadow:0 2px 6px rgba(0,0,0,.04);
}
.pf-meta-label{font-size:.63rem;font-weight:800;color:var(--tx-4);text-transform:uppercase;letter-spacing:.07em}
.pf-meta-value{font-size:.84rem;font-weight:600;color:var(--navy-800);overflow-wrap:anywhere}

/* ── Form sections ── */
.pf-form-card{
  background:#fff;border:1px solid var(--border);border-radius:16px;
  box-shadow:var(--sh-xs);overflow:hidden;
}
.pf-form-head{
  display:flex;align-items:center;gap:12px;
  padding:18px 24px;border-bottom:1px solid var(--border-2);
  background:linear-gradient(180deg,#fff,#fafbfc);
}
.pf-form-head-ico{
  width:38px;height:38px;border-radius:10px;
  display:grid;place-items:center;font-size:.9rem;flex-shrink:0;
}
.pf-form-head-title{font-size:.94rem;font-weight:800;color:var(--navy-800)}
.pf-form-head-sub{font-size:.7rem;color:var(--tx-4);margin-top:1px}
.pf-form-body{padding:24px 26px}
.pf-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.pf-group{margin-bottom:16px}
.pf-group:last-child{margin-bottom:0}
.pf-label{font-size:.77rem;font-weight:700;color:var(--tx-2);margin-bottom:6px;display:block}
.pf-input{
  width:100%;padding:11px 14px;
  border:1.5px solid var(--border);border-radius:10px;
  font-size:.84rem;color:var(--tx-1);background:#fff;
  font-family:'Inter',sans-serif;
  transition:border-color .18s,box-shadow .18s;
}
.pf-input:focus{outline:none;border-color:var(--crimson);box-shadow:0 0 0 3px rgba(237,27,59,.1)}
.pf-input:disabled{background:#f8fafc;color:var(--tx-4)}
.pf-input-hint{font-size:.7rem;color:var(--tx-4);margin-top:4px}
.pf-error{color:#ef4444;font-size:.72rem;margin-top:3px;display:block}
.pf-btn-save{
  display:inline-flex;align-items:center;gap:8px;
  padding:11px 24px;border-radius:11px;
  background:linear-gradient(135deg,var(--crimson),var(--crimson-dark));
  color:#fff;font-size:.84rem;font-weight:700;border:none;cursor:pointer;
  transition:.22s;box-shadow:0 4px 14px rgba(237,27,59,.28);
  font-family:'Inter',sans-serif;
}
.pf-btn-save:hover{background:linear-gradient(135deg,var(--crimson-dark),#a01228);transform:translateY(-2px) scale(1.02);box-shadow:0 6px 20px rgba(237,27,59,.38)}
.pf-btn-gold{
  background:linear-gradient(135deg,#ca8a04,#a16207);
  box-shadow:0 4px 14px rgba(202,138,4,.22);
}
.pf-btn-gold:hover{background:linear-gradient(135deg,#a16207,#854d0e);box-shadow:0 6px 20px rgba(202,138,4,.32)}

/* ── Alerts ── */
.pf-alert{
  display:flex;align-items:center;gap:10px;
  padding:13px 16px;border-radius:11px;margin-bottom:18px;
  font-size:.83rem;font-weight:600;
}
.pf-alert-success{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);color:#065f46;box-shadow:0 2px 8px rgba(16,185,129,.1)}
.pf-alert-danger{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);color:#991b1b;box-shadow:0 2px 8px rgba(239,68,68,.08)}

/* ── Responsive ── */
@media(max-width:920px){
  .pf-grid{grid-template-columns:1fr;gap:20px}
  .pf-side-card{max-width:100%}
  .pf-row{grid-template-columns:1fr}
  .pf-hero{flex-direction:column;align-items:flex-start;gap:16px;padding:22px 20px}
}
@media(max-width:576px){
  .pf-hero{padding:18px 16px}
  .pf-form-head{padding:16px 20px}
  .pf-form-body{padding:20px}
  .pf-side-header{padding:24px 18px}
  .pf-meta-row{padding:12px 16px}
  .pf-btn-save,.pf-btn-gold{justify-content:center;width:100%}
}
</style>

<div class="pf-wrap">

  {{-- Flash --}}
  @if(session('success'))
  <div class="pf-alert pf-alert-success">
    <i class="bi bi-check-circle-fill" style="font-size:1.1rem;flex-shrink:0"></i> {{ session('success') }}
  </div>
  @endif

  {{-- Hero Bar --}}
  <div class="pf-hero">
    @if($anggota->foto)
      <img src="{{ Storage::url($anggota->foto) }}" alt="{{ $anggota->nama }}" class="pf-hero-ava">
    @else
      <div class="pf-hero-ava-ph">{{ strtoupper(substr($anggota->nama,0,1)) }}</div>
    @endif
    <div class="pf-hero-info">
      <div class="pf-hero-kicker"><span></span> Profil Anggota</div>
      <h1>{{ $anggota->nama }}</h1>
      <div class="pf-hero-chips">
        <span class="pf-chip"><i class="bi bi-credit-card-2-front" style="font-size:.7rem"></i> {{ $anggota->nis }}</span>
        <span class="pf-chip"><i class="bi bi-mortarboard" style="font-size:.7rem"></i> {{ $anggota->kelas }}</span>
        <span class="pf-chip active"><i class="bi bi-circle-fill" style="font-size:.4rem"></i> Anggota Aktif</span>
      </div>
    </div>
  </div>

  {{-- Main Grid --}}
  <div class="pf-grid">

    {{-- Left: Profile summary card --}}
    <div>
      <div class="pf-side-card">
        <div class="pf-side-header">
          <div class="pf-side-ava-wrap">
            @if($anggota->foto)
              <img src="{{ Storage::url($anggota->foto) }}" alt="{{ $anggota->nama }}" class="pf-side-ava">
            @else
              <div class="pf-side-ava-ph">{{ strtoupper(substr($anggota->nama,0,1)) }}</div>
            @endif
            <label for="foto_quick" class="pf-ava-edit" title="Ganti foto">
              <i class="bi bi-camera-fill" style="font-size:.6rem;color:#fff"></i>
            </label>
          </div>
          <div class="pf-side-name">{{ $anggota->nama }}</div>
          <div class="pf-side-nis">NIS: {{ $anggota->nis }}</div>
          <span class="pf-side-status">
            <i class="bi bi-circle-fill" style="font-size:.42rem"></i> {{ ucfirst($anggota->status) }}
          </span>
        </div>

        <div class="pf-meta">
          @foreach([
            ['bi-envelope-fill','Email',$user->email],
            ['bi-mortarboard-fill','Kelas',$anggota->kelas],
            ['bi-telephone-fill','Telepon',$anggota->telepon ?: '—'],
            ['bi-geo-alt-fill','Alamat',\Illuminate\Support\Str::limit($anggota->alamat ?: '—',40)],
            ['bi-calendar3','Terdaftar',$anggota->created_at->isoFormat('D MMM YYYY')],
          ] as [$ico,$lbl,$val])
          <div class="pf-meta-row">
            <div class="pf-meta-ico"><i class="bi {{ $ico }}"></i></div>
            <div style="min-width:0">
              <div class="pf-meta-label">{{ $lbl }}</div>
              <div class="pf-meta-value">{{ $val }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Right: Forms --}}
    <div style="display:flex;flex-direction:column;gap:20px">

      {{-- Edit Data Diri --}}
      <div class="pf-form-card">
        <div class="pf-form-head">
          <div class="pf-form-head-ico" style="background:rgba(237,27,59,.08)">
            <i class="bi bi-person-fill" style="color:var(--crimson)"></i>
          </div>
          <div>
            <div class="pf-form-head-title">Data Diri</div>
            <div class="pf-form-head-sub">Update informasi profil kamu</div>
          </div>
        </div>
        <div class="pf-form-body">
          <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Hidden file input for quick foto upload --}}
            <input type="file" id="foto_quick" name="foto" accept="image/*" style="display:none" onchange="this.form.submit()">

            @if($errors->has('foto'))
              <div class="pf-alert pf-alert-danger">
                <i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first('foto') }}
              </div>
            @endif

            <div class="pf-row">
              <div class="pf-group">
                <label class="pf-label">Nama Lengkap <span style="color:var(--crimson)">*</span></label>
                <input type="text" name="nama" class="pf-input" value="{{ old('nama',$anggota->nama) }}" required>
                @error('nama')<span class="pf-error">{{ $message }}</span>@enderror
              </div>
              <div class="pf-group">
                <label class="pf-label">NIS</label>
                <input type="text" class="pf-input" value="{{ $anggota->nis }}" disabled>
              </div>
            </div>

            <div class="pf-row">
              <div class="pf-group">
                <label class="pf-label">Kelas <span style="color:var(--crimson)">*</span></label>
                <input type="text" name="kelas" class="pf-input" value="{{ old('kelas',$anggota->kelas) }}" required>
                @error('kelas')<span class="pf-error">{{ $message }}</span>@enderror
              </div>
              <div class="pf-group">
                <label class="pf-label">No. Telepon</label>
                <input type="text" name="telepon" class="pf-input" value="{{ old('telepon',$anggota->telepon) }}" placeholder="08xxxxxxxxx">
              </div>
            </div>

            <div class="pf-group">
              <label class="pf-label">Alamat</label>
              <textarea name="alamat" class="pf-input" rows="2" placeholder="Alamat lengkap" style="resize:vertical">{{ old('alamat',$anggota->alamat) }}</textarea>
            </div>

            <div class="pf-group">
              <label class="pf-label">Email</label>
              <input type="email" class="pf-input" value="{{ $user->email }}" disabled>
              <span class="pf-input-hint">Email tidak dapat diubah.</span>
            </div>

            <div style="display:flex;gap:10px;margin-top:4px;flex-wrap:wrap">
              <button type="submit" class="pf-btn-save">
                <i class="bi bi-check-lg"></i> Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- Ganti Password --}}
      <div class="pf-form-card">
        <div class="pf-form-head">
          <div class="pf-form-head-ico" style="background:rgba(234,179,8,.08)">
            <i class="bi bi-shield-lock-fill" style="color:#ca8a04"></i>
          </div>
          <div>
            <div class="pf-form-head-title">Ganti Password</div>
            <div class="pf-form-head-sub">Pastikan password minimal 6 karakter</div>
          </div>
        </div>
        <div class="pf-form-body">
          <form method="POST" action="{{ route('siswa.profil.password') }}">
            @csrf @method('PUT')

            @error('password_lama')
              <div class="pf-alert pf-alert-danger">
                <i class="bi bi-exclamation-circle-fill"></i>{{ $message }}
              </div>
            @enderror

            <div class="pf-group">
              <label class="pf-label">Password Lama <span style="color:var(--crimson)">*</span></label>
              <input type="password" name="password_lama" class="pf-input" placeholder="••••••••" required>
            </div>

            <div class="pf-row">
              <div class="pf-group">
                <label class="pf-label">Password Baru <span style="color:var(--crimson)">*</span></label>
                <input type="password" name="password" class="pf-input" placeholder="Min. 6 karakter" required>
                @error('password')<span class="pf-error">{{ $message }}</span>@enderror
              </div>
              <div class="pf-group">
                <label class="pf-label">Konfirmasi Password <span style="color:var(--crimson)">*</span></label>
                <input type="password" name="password_confirmation" class="pf-input" placeholder="Ulangi password baru" required>
              </div>
            </div>

            <div style="display:flex;gap:10px;margin-top:4px;flex-wrap:wrap">
              <button type="submit" class="pf-btn-save pf-btn-gold">
                <i class="bi bi-lock-fill"></i> Ganti Password
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
/* ── pf-btn-save (Simpan Perubahan): crimson glow + checkmark bounce ── */
.pf-btn-save{
  position:relative;overflow:hidden;
  animation:pfSaveGlow 2.6s ease-in-out infinite;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s ease !important;
}
@keyframes pfSaveGlow{
  0%,100%{box-shadow:0 4px 14px rgba(237,27,59,.28)}
  50%{box-shadow:0 8px 24px rgba(237,27,59,.52),0 0 0 5px rgba(237,27,59,.1)}
}
.pf-btn-gold.pf-btn-save{
  animation:pfGoldGlow 2.6s ease-in-out infinite;
}
@keyframes pfGoldGlow{
  0%,100%{box-shadow:0 4px 14px rgba(202,138,4,.22)}
  50%{box-shadow:0 8px 24px rgba(202,138,4,.45),0 0 0 5px rgba(202,138,4,.1)}
}
.pf-btn-save:hover{
  animation:none;
  transform:translateY(-3px) scale(1.04) !important;
}
.pf-btn-save::before{
  content:'';position:absolute;top:0;left:-110%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-20deg);pointer-events:none;
}
.pf-btn-save:hover::before{animation:pfShimmer .5s ease forwards;}
@keyframes pfShimmer{0%{left:-110%}100%{left:120%}}
.pf-btn-save i{display:inline-block;}
.pf-btn-save:hover i{animation:pfCheckBounce .45s ease;}
@keyframes pfCheckBounce{
  0%{transform:scale(1) rotate(0)}
  30%{transform:scale(1.5) rotate(-12deg)}
  55%{transform:scale(.85) rotate(6deg)}
  75%{transform:scale(1.15) rotate(-4deg)}
  100%{transform:scale(1) rotate(0)}
}
/* Lock icon for password btn */
.pf-btn-gold:hover i.bi-lock-fill{animation:pfLockShake .4s ease !important;}
@keyframes pfLockShake{
  0%,100%{transform:translateX(0) rotate(0)}
  20%{transform:translateX(-3px) rotate(-5deg)}
  40%{transform:translateX(3px) rotate(4deg)}
  60%{transform:translateX(-2px) rotate(-3deg)}
  80%{transform:translateX(1px) rotate(2deg)}
}
.pf-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:pfRipple .4s linear;pointer-events:none;}
@keyframes pfRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.pf-btn-save').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='pf-ripple';
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

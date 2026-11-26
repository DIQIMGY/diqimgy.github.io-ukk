<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Semua Ulasan — Perpustakaan Sekolah Digital</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
  --crimson:#ED1B3B;--navy:#14284B;--gold:#F4B942;
  --tx1:#1F2937;--tx2:#374151;--tx3:#6B7280;--tx4:#9CA3AF;
  --bg:#F5F7FA;--surface:#fff;--border:#E5E7EB;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--tx1)}
a{text-decoration:none;color:inherit}

.all-header{
  background:linear-gradient(135deg,#06101F,#14284B 60%,#1e3a6b);
  padding:60px 24px 48px;text-align:center;position:relative;overflow:hidden;
}
.all-header::before{
  content:'';position:absolute;width:500px;height:500px;border-radius:50%;
  background:radial-gradient(circle,rgba(237,27,59,.12),transparent 70%);
  top:-200px;left:50%;transform:translateX(-50%);pointer-events:none;
}
.all-header-tag{
  display:inline-flex;align-items:center;gap:7px;
  background:rgba(244,185,66,.15);border:1px solid rgba(244,185,66,.3);
  color:#f4b942;font-size:.72rem;font-weight:800;letter-spacing:.08em;
  padding:6px 16px;border-radius:99px;margin-bottom:18px;
  text-transform:uppercase;
}
.all-header h1{
  font-family:'Playfair Display',serif;
  font-size:clamp(1.8rem,5vw,2.6rem);font-weight:800;color:#fff;
  margin-bottom:10px;
}
.all-header p{font-size:.92rem;color:rgba(255,255,255,.55);max-width:480px;margin:0 auto 24px}
.all-header-stats{
  display:flex;justify-content:center;gap:32px;flex-wrap:wrap;
  position:relative;z-index:1;
}
.all-header-stat{text-align:center}
.all-header-stat-val{font-size:1.6rem;font-weight:900;color:#fff;line-height:1}
.all-header-stat-lbl{font-size:.7rem;color:rgba(255,255,255,.45);font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-top:4px}

.all-body{max-width:1200px;margin:0 auto;padding:40px 24px}
.all-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(340px,1fr));
  gap:20px;
}

.rev-card{
  background:var(--surface);border-radius:14px;
  border:1px solid var(--border);
  padding:22px;
  box-shadow:0 3px 14px rgba(20,40,75,.06);
  display:flex;flex-direction:column;gap:15px;
  transition:transform .22s,box-shadow .22s,border-color .22s;
}
.rev-card:hover{
  transform:translateY(-3px);
  box-shadow:0 12px 28px rgba(20,40,75,.12);
  border-color:rgba(237,27,59,.28);
}

.rev-top{display:flex;align-items:center;gap:12px}
.rev-ava{
  width:44px;height:44px;border-radius:50%;
  background:linear-gradient(135deg,var(--crimson),#c41630);
  display:flex;align-items:center;justify-content:center;
  font-size:.88rem;font-weight:800;color:#fff;flex-shrink:0;
  overflow:hidden;box-shadow:0 3px 10px rgba(237,27,59,.25);
}
.rev-ava img{width:100%;height:100%;object-fit:cover}
.rev-name{font-size:.88rem;font-weight:800;color:var(--navy)}
.rev-class{font-size:.72rem;color:var(--tx3)}
.rev-stars{display:flex;gap:2px;margin-top:3px}
.rev-star{font-size:.9rem}
.rev-star.on{color:#f59e0b}
.rev-star.off{color:#e5e7eb}

.rev-book{display:flex;gap:12px;align-items:center;background:#f5f7fa;border:1px solid #edf0f4;border-radius:10px;padding:12px}
.rev-book-cover{width:44px;height:66px;border-radius:8px;object-fit:cover;flex-shrink:0;box-shadow:0 3px 10px rgba(0,0,0,.15)}
.rev-book-cover-ph{width:44px;height:66px;border-radius:8px;background:linear-gradient(135deg,#0c4a6e,#0284c7);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.rev-book-title{font-size:.82rem;font-weight:700;color:var(--navy);line-height:1.3;margin-bottom:3px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.rev-book-author{font-size:.72rem;color:var(--tx3)}
.rev-book-kat{display:inline-block;font-size:.62rem;font-weight:700;color:var(--crimson);background:rgba(237,27,59,.08);padding:2px 8px;border-radius:99px;margin-top:4px;text-transform:uppercase;letter-spacing:.04em}

.rev-comment{font-size:.84rem;color:var(--tx2);line-height:1.65;background:#fff8f1;border-left:3px solid var(--gold);border-radius:0 8px 8px 0;padding:11px 13px}
.rev-no-comment{font-size:.78rem;color:var(--tx3);background:#f5f7fa;border-radius:8px;padding:10px 12px;display:flex;align-items:center;gap:8px}
.rev-no-comment i{color:var(--tx4)}
.rev-date{font-size:.7rem;color:var(--tx4);margin-top:auto;padding-top:2px}

.empty-state{text-align:center;padding:80px 24px;color:var(--tx4)}
.empty-state i{font-size:3rem;opacity:.25;display:block;margin-bottom:16px}

/* Pagination */
.all-pagination{display:flex;justify-content:center;margin-top:40px;gap:6px}
.all-pagination a,.all-pagination span{
  width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;
  font-size:.82rem;font-weight:600;border:1.5px solid var(--border);background:var(--surface);color:var(--tx2);transition:all .2s;
}
.all-pagination a:hover{border-color:var(--crimson);color:var(--crimson)}
.all-pagination span.active{background:var(--crimson);border-color:var(--crimson);color:#fff}
</style>
</head>
<body>

{{-- Header --}}
<div class="all-header">
  <div class="all-header-tag"><i class="bi bi-star-fill"></i> Ulasan Pembaca</div>
  <h1>Apa Kata Mereka?</h1>
  <p>Ulasan jujur dari siswa yang telah membaca koleksi perpustakaan kami</p>
  <div class="all-header-stats">
    <div class="all-header-stat">
      <div class="all-header-stat-val">{{ $totalUlasan }}</div>
      <div class="all-header-stat-lbl">Total Ulasan</div>
    </div>
    <div class="all-header-stat">
      <div class="all-header-stat-val" style="color:#f4b942">{{ number_format($rataRata,1) }} ★</div>
      <div class="all-header-stat-lbl">Rata-rata Rating</div>
    </div>
  </div>
</div>

<div class="all-body">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px">
    <div>
      <h2 style="font-size:1.1rem;font-weight:800;color:var(--navy);margin-bottom:2px">Semua Ulasan</h2>
      <p style="font-size:.8rem;color:var(--tx3)">{{ $ulasan->total() }} ulasan ditemukan</p>
    </div>
    <a href="{{ route('landing') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:.82rem;font-weight:600;color:var(--tx3);border:1.5px solid var(--border);padding:8px 16px;border-radius:10px;background:var(--surface);transition:all .2s"
       onmouseover="this.style.borderColor='var(--crimson)';this.style.color='var(--crimson)'"
       onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--tx3)'">
      <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>
  </div>

  @if($ulasan->count())
  <div class="all-grid">
    @foreach($ulasan as $u)
    <div class="rev-card">
      {{-- Reviewer --}}
      <div class="rev-top">
        <div class="rev-ava">
          @if($u->anggota->foto)
            <img src="{{ Storage::url($u->anggota->foto) }}" alt="{{ $u->anggota->nama }}">
          @else
            {{ strtoupper(substr($u->anggota->nama,0,1)) }}
          @endif
        </div>
        <div>
          <div class="rev-name">{{ $u->anggota->nama }}</div>
          <div class="rev-class">{{ $u->anggota->kelas }}</div>
          <div class="rev-stars">
            @for($s=1;$s<=5;$s++)
              <span class="rev-star {{ $s<=$u->rating?'on':'off' }}">★</span>
            @endfor
          </div>
        </div>
        <div style="margin-left:auto">
          <div class="rev-date">{{ $u->created_at->isoFormat('D MMM YYYY') }}</div>
        </div>
      </div>

      {{-- Buku --}}
      <div class="rev-book">
        @if($u->buku->cover)
          <img src="{{ Storage::url($u->buku->cover) }}" alt="{{ $u->buku->judul }}" class="rev-book-cover">
        @else
          <div class="rev-book-cover-ph"><i class="bi bi-book-fill" style="font-size:.9rem;color:rgba(255,255,255,.7)"></i></div>
        @endif
        <div style="min-width:0">
          <div class="rev-book-title">{{ $u->buku->judul }}</div>
          <div class="rev-book-author">{{ $u->buku->pengarang }}</div>
          <span class="rev-book-kat">{{ $u->buku->kategori }}</span>
        </div>
      </div>

      {{-- Komentar --}}
      @if(filled($u->komentar))
      <div class="rev-comment">{{ $u->komentar }}</div>
      @else
      <div class="rev-no-comment"><i class="bi bi-chat-square"></i> Memberi rating tanpa komentar</div>
      @endif
      <div class="rev-date">{{ $u->created_at->isoFormat('D MMM YYYY') }}</div>
    </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  @if($ulasan->hasPages())
  <div class="all-pagination">
    @if($ulasan->onFirstPage())
      <span style="opacity:.35"><i class="bi bi-chevron-left"></i></span>
    @else
      <a href="{{ $ulasan->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
    @endif

    @foreach($ulasan->getUrlRange(max(1,$ulasan->currentPage()-2), min($ulasan->lastPage(),$ulasan->currentPage()+2)) as $page => $url)
      @if($page == $ulasan->currentPage())
        <span class="active">{{ $page }}</span>
      @else
        <a href="{{ $url }}">{{ $page }}</a>
      @endif
    @endforeach

    @if($ulasan->hasMorePages())
      <a href="{{ $ulasan->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
    @else
      <span style="opacity:.35"><i class="bi bi-chevron-right"></i></span>
    @endif
  </div>
  @endif

  @else
  <div class="empty-state">
    <i class="bi bi-chat-square-text"></i>
    <h3 style="font-weight:700;margin-bottom:8px">Belum Ada Ulasan</h3>
    <p>Jadilah yang pertama memberikan ulasan setelah meminjam buku!</p>
  </div>
  @endif
</div>

</body>
</html>

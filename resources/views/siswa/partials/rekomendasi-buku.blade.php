@if($rekomendasiBuku->isNotEmpty())
<style>
.recommendation-section {
  margin-top:28px;
  padding-top:24px;
  border-top:1px solid #e5e7eb;
}
.recommendation-heading {
  display:flex;
  align-items:end;
  justify-content:space-between;
  gap:16px;
  margin-bottom:14px;
}
.recommendation-kicker {
  color:var(--crimson);
  font-size:.65rem;
  font-weight:900;
  letter-spacing:.14em;
  text-transform:uppercase;
  margin-bottom:4px;
}
.recommendation-title {
  color:var(--navy-800);
  font-size:1.08rem;
  font-weight:850;
  margin:0;
}
.recommendation-caption { color:var(--tx-3); font-size:.76rem; margin:4px 0 0; }
.recommendation-link {
  color:var(--crimson);
  font-size:.76rem;
  font-weight:750;
  white-space:nowrap;
}
.recommendation-link:hover { color:var(--crimson-dark); }
.recommendation-scroller {
  display:grid;
  grid-template-columns:repeat(5,minmax(0,1fr));
  gap:12px;
}
.recommendation-card {
  min-width:0;
  overflow:hidden;
  background:#fff;
  border:1px solid #e5e7eb;
  border-radius:10px;
  box-shadow:0 3px 12px rgba(20,40,75,.05);
  transition:transform .2s ease,box-shadow .2s ease,border-color .2s ease;
}
.recommendation-card:hover {
  transform:translateY(-4px);
  border-color:rgba(237,27,59,.35);
  box-shadow:0 10px 22px rgba(20,40,75,.11);
}
.recommendation-cover {
  position:relative;
  aspect-ratio:2 / 2.75;
  overflow:hidden;
  background:#dbe4ef;
}
.recommendation-cover img { width:100%; height:100%; object-fit:cover; transition:transform .35s ease; }
.recommendation-card:hover .recommendation-cover img { transform:scale(1.05); }
.recommendation-placeholder {
  display:flex;
  align-items:center;
  justify-content:center;
  height:100%;
  color:rgba(255,255,255,.82);
  background:linear-gradient(145deg,#0f1f3d,#2055a5);
  font-size:1.55rem;
}
.recommendation-stock {
  position:absolute;
  left:7px;
  top:7px;
  padding:3px 7px;
  border-radius:5px;
  background:rgba(16,185,129,.92);
  color:#fff;
  font-size:.59rem;
  font-weight:800;
}
.recommendation-body { padding:10px; }
.recommendation-category {
  color:var(--crimson);
  font-size:.58rem;
  font-weight:850;
  letter-spacing:.06em;
  text-transform:uppercase;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}
.recommendation-book-title {
  display:-webkit-box;
  overflow:hidden;
  -webkit-box-orient:vertical;
  -webkit-line-clamp:2;
  min-height:2.35em;
  margin:4px 0 2px;
  color:var(--navy-800);
  font-size:.77rem;
  font-weight:750;
  line-height:1.25;
}
.recommendation-author {
  overflow:hidden;
  color:var(--tx-4);
  font-size:.65rem;
  text-overflow:ellipsis;
  white-space:nowrap;
}
.recommendation-action {
  display:flex;
  align-items:center;
  justify-content:center;
  gap:5px;
  width:100%;
  margin-top:9px;
  padding:7px 8px;
  border:1px solid rgba(237,27,59,.25);
  border-radius:7px;
  background:#fff5f6;
  color:var(--crimson);
  font-size:.67rem;
  font-weight:800;
  text-decoration:none;
  transition:background .2s,color .2s;
}
.recommendation-action:hover { background:var(--crimson); color:#fff; }
@media(max-width:992px) { .recommendation-scroller { grid-template-columns:repeat(4,minmax(0,1fr)); } }
@media(max-width:768px) {
  .recommendation-section { margin-top:22px; padding-top:20px; }
  .recommendation-scroller { display:flex; overflow-x:auto; gap:10px; padding:2px 2px 8px; scroll-snap-type:x mandatory; }
  .recommendation-card { flex:0 0 142px; scroll-snap-align:start; }
  .recommendation-heading { align-items:flex-start; }
  .recommendation-caption { max-width:230px; }
}
@media(prefers-reduced-motion:reduce) {
  .recommendation-card,.recommendation-cover img { transition:none; }
}
</style>

<section class="recommendation-section" aria-labelledby="recommendation-title">
  <div class="recommendation-heading">
    <div>
      <div class="recommendation-kicker">Pilihan untukmu</div>
      <h2 id="recommendation-title" class="recommendation-title">Rekomendasi Buku</h2>
      <p class="recommendation-caption">Koleksi lain yang mungkin cocok untuk bacaanmu.</p>
    </div>
    <a href="{{ route('siswa.peminjaman.create') }}" class="recommendation-link">Lihat semua <i class="bi bi-arrow-right"></i></a>
  </div>

  <div class="recommendation-scroller">
    @foreach($rekomendasiBuku as $bukuRekomendasi)
      <article class="recommendation-card">
        <div class="recommendation-cover">
          @if($bukuRekomendasi->cover)
            <img src="{{ Storage::url($bukuRekomendasi->cover) }}" alt="{{ $bukuRekomendasi->judul }}" loading="lazy">
          @else
            <div class="recommendation-placeholder"><i class="bi bi-book-fill"></i></div>
          @endif
          <span class="recommendation-stock"><i class="bi bi-check-circle-fill"></i> Tersedia</span>
        </div>
        <div class="recommendation-body">
          <div class="recommendation-category">{{ $bukuRekomendasi->kategori ?: 'Koleksi umum' }}</div>
          <h3 class="recommendation-book-title">{{ $bukuRekomendasi->judul }}</h3>
          <div class="recommendation-author"><i class="bi bi-person"></i> {{ $bukuRekomendasi->pengarang ?: 'Pengarang tidak tersedia' }}</div>
          <a href="{{ route('siswa.peminjaman.create', ['search' => $bukuRekomendasi->judul]) }}" class="recommendation-action">
            <i class="bi bi-book"></i> Pinjam buku
          </a>
        </div>
      </article>
    @endforeach
  </div>
</section>
@endif

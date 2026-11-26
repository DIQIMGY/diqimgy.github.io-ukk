@extends('layouts.app')
@section('title','Detail Buku')
@section('page-title','Detail Buku')
@section('content')
<style>
    body {
        background: #eaf4fc;
        color: #14284B;
    }

    .detail-book-page {
        max-width: 1260px;
        margin: 0 auto;
        padding: 18px 12px 48px;
        animation: fadeInUp 0.45s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .back-btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 22px;
        padding: 10px 16px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(237,27,59,0.08), rgba(237,27,59,0.02));
        border: 1px solid rgba(237,27,59,0.14);
        color: #ED1B3B;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.25s ease;
    }

    .back-btn-modern:hover {
        transform: translateX(-3px);
        box-shadow: 0 8px 18px rgba(237,27,59,0.12);
        color: #ED1B3B;
    }

    .hero-shell {
        position: relative;
        background: linear-gradient(180deg, #ffffff 0%, #f9fbff 100%);
        border: 1px solid rgba(20,40,75,0.08);
        border-radius: 8px;
        box-shadow: 0 10px 26px rgba(20,40,75,0.07);
        overflow: hidden;
    }

    .hero-shell::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(237,27,59,0.04), transparent 32%, transparent 68%, rgba(20,40,75,0.03));
        pointer-events: none;
    }

    .hero-layout {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 230px minmax(0, 1fr);
        gap: 26px;
        padding: 22px 24px;
    }

    .cover-panel {
        position: relative;
        padding: 8px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(237,27,59,0.04), rgba(20,40,75,0.02));
        border: 1px solid rgba(20,40,75,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cover-frame {
        width: 100%;
        max-width: 196px;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 22px 42px rgba(20,40,75,0.16);
        background: #edf2ff;
        border: 1px solid rgba(20,40,75,0.08);
    }

    .cover-frame img {
        display: block;
        width: 100%;
        aspect-ratio: 2 / 3;
        object-fit: cover;
    }

    .cover-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        aspect-ratio: 2 / 3;
        background: linear-gradient(135deg, #14284B 0%, #ED1B3B 100%);
        color: white;
        text-align: center;
        padding: 22px;
    }

    .cover-placeholder i {
        font-size: 54px;
        opacity: 0.9;
    }

    .cover-placeholder strong {
        font-size: 1.02rem;
        line-height: 1.35;
    }

    .cover-placeholder small {
        opacity: 0.8;
    }

    .stock-pill {
        position: absolute;
        right: 12px;
        bottom: 18px;
        padding: 10px 14px;
        border-radius: 999px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.04em;
        box-shadow: 0 10px 18px rgba(22,163,74,0.16);
    }

    .stock-pill.habis {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 10px 18px rgba(239,68,68,0.16);
    }

    .book-copy {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(237,27,59,0.08);
        border: 1px solid rgba(237,27,59,0.1);
        color: #ED1B3B;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .book-title {
        margin-top: 18px;
        font-size: clamp(2rem, 3vw, 3rem);
        line-height: 1.06;
        font-weight: 900;
        color: #14284B;
        letter-spacing: -0.05em;
    }

    .book-author {
        margin-top: 10px;
        color: #64748b;
        font-size: 1.05rem;
    }

    .book-author strong {
        color: #14284B;
    }

    .book-signal {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-top: 18px;
        color: #64748b;
        font-size: 0.86rem;
    }

    .book-signal strong {
        color: #14284B;
        font-size: 1rem;
    }

    .signal-divider {
        width: 1px;
        height: 20px;
        background: rgba(20,40,75,0.16);
    }

    .signal-item {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .signal-item i {
        color: #ED1B3B;
    }

    .cta-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 22px;
    }

    .btn-primary-large,
    .btn-soft-large {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-primary-large {
        background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
        color: white;
        border: none;
        box-shadow: 0 12px 22px rgba(237,27,59,0.18);
    }

    .btn-primary-large:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 28px rgba(237,27,59,0.25);
        color: white;
    }

    .btn-soft-large {
        background: #f8fafc;
        border: 1px solid rgba(20,40,75,0.08);
        color: #14284B;
    }

    .btn-soft-large:hover {
        background: #eef3f9;
        color: #14284B;
    }

    .summary-box {
        margin-top: 20px;
        padding: 18px 18px;
        border-radius: 4px;
        background: linear-gradient(135deg, rgba(237,27,59,0.02), rgba(20,40,75,0.02));
        border: 1px solid rgba(20,40,75,0.06);
        color: #475569;
        line-height: 1.85;
        font-size: 0.98rem;
    }

    .meta-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(120px, 1fr));
        gap: 12px;
        margin-top: 22px;
    }

    .meta-item {
        padding: 12px 14px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(20,40,75,0.06);
    }

    .meta-item .label {
        display: block;
        margin-bottom: 8px;
        color: #64748b;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .meta-item .value {
        color: #14284B;
        font-size: 0.96rem;
        font-weight: 800;
        line-height: 1.4;
    }

    .lower-grid {
        display: grid;
        grid-template-columns: 1.4fr 0.8fr;
        gap: 20px;
        margin: 0 24px 22px;
        position: relative;
        z-index: 1;
    }

    .info-card,
    .author-card {
        background: #ffffff;
        border: 1px solid rgba(20,40,75,0.08);
        border-radius: 8px;
        padding: 18px;
        box-shadow: 0 10px 24px rgba(20,40,75,0.05);
    }

    .info-card h3,
    .author-card h3,
    .recommend-header h3 {
        margin: 0 0 16px;
        color: #14284B;
        font-size: 0.82rem;
        font-weight: 900;
        letter-spacing: 0.09em;
        text-transform: uppercase;
    }

    .info-card h3::after,
    .author-card h3::after {
        content: '';
        display: block;
        width: 34px;
        height: 3px;
        margin-top: 9px;
        border-radius: 999px;
        background: #ED1B3B;
    }

    .info-card p {
        margin: 0;
        color: #475569;
        line-height: 1.9;
        font-size: 0.98rem;
    }

    .author-card {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .author-box {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .author-avatar {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #14284B, #ED1B3B);
        color: white;
        font-weight: 900;
    }

    .author-meta strong {
        display: block;
        font-size: 1rem;
        color: #14284B;
        margin-bottom: 4px;
    }

    .author-meta span {
        color: #64748b;
        font-size: 0.8rem;
    }

    .mini-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .mini-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid rgba(20,40,75,0.06);
        color: #475569;
        font-size: 0.88rem;
    }

    .mini-item strong {
        color: #14284B;
        font-weight: 800;
    }

    .recommend-panel {
        position: relative;
        z-index: 1;
        margin-top: 26px;
    }

    .detail-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 16px;
        margin: 0 0 18px;
    }

    .detail-heading h2 {
        margin: 0;
        color: #14284B;
        font-size: clamp(1.5rem, 2.2vw, 2rem);
        font-weight: 900;
        letter-spacing: -0.04em;
    }

    .detail-heading p {
        margin: 0;
        color: #64748b;
        font-size: .8rem;
    }

    .recommend-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 248px;
        gap: 24px;
        align-items: start;
    }

    .latest-panel {
        position: sticky;
        top: 22px;
        padding: 18px 16px;
        border-radius: 18px;
        background: #ffffff;
        color: #14284B;
        border: 1px solid rgba(20,40,75,.08);
        box-shadow: 0 12px 28px rgba(20,40,75,0.08);
    }

    .latest-kicker {
        margin-bottom: 5px;
        color: #ED1B3B;
        font-size: .64rem;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .latest-title {
        margin: 0 0 16px;
        font-size: 1.05rem;
        font-weight: 900;
    }

    .latest-book {
        display: grid;
        grid-template-columns: 46px minmax(0, 1fr);
        gap: 10px;
        padding: 12px 0;
        border-top: 1px solid rgba(20,40,75,.08);
        color: #14284B;
        text-decoration: none;
    }

    .latest-book:first-of-type {
        border-top: 0;
    }

    .latest-cover,
    .latest-placeholder {
        width: 46px;
        height: 66px;
        border-radius: 3px 6px 6px 3px;
        object-fit: cover;
        box-shadow: 2px 4px 10px rgba(0,0,0,.25);
    }

    .latest-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ED1B3B, #8f1328);
        color: rgba(255,255,255,.8);
        font-size: 1.2rem;
    }

    .latest-book-name {
        display: -webkit-box;
        overflow: hidden;
        color: #14284B;
        font-size: .76rem;
        font-weight: 800;
        line-height: 1.35;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .latest-book-author {
        display: block;
        overflow: hidden;
        margin-top: 4px;
        color: #64748b;
        font-size: .66rem;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .latest-book-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 7px;
        color: #ED1B3B;
        font-size: .65rem;
        font-weight: 800;
    }

    .recommend-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .recommend-header span {
        color: #ED1B3B;
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .recommend-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .rec-card {
        background: #ffffff;
        border: 1px solid rgba(20,40,75,0.08);
        border-radius: 5px;
        padding: 10px;
        transition: all 0.25s ease;
        box-shadow: 0 10px 24px rgba(20,40,75,0.04);
    }

    .rec-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 30px rgba(20,40,75,0.08);
    }

    .rec-cover {
        width: 100%;
        aspect-ratio: 2 / 3;
        border-radius: 3px;
        overflow: hidden;
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
    }

    .rec-cover img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rec-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #14284B, #ED1B3B);
        color: white;
        font-size: 2rem;
    }

    .rec-title {
        margin-top: 12px;
        font-size: 0.94rem;
        font-weight: 800;
        color: #14284B;
        line-height: 1.4;
    }

    .rec-author {
        margin-top: 4px;
        color: #64748b;
        font-size: 0.76rem;
    }

    .rec-action {
        display: inline-flex;
        margin-top: 10px;
        width: 100%;
        justify-content: center;
        padding: 8px 10px;
        border-radius: 10px;
        background: linear-gradient(135deg, #ED1B3B, #C41630);
        color: white;
        font-size: 0.78rem;
        font-weight: 800;
        text-decoration: none;
    }

    @media (max-width: 991px) {
        .hero-layout,
        .lower-grid,
        .recommend-layout {
            grid-template-columns: 1fr;
        }

        .latest-panel {
            position: static;
        }

        .recommend-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 576px) {
        .hero-layout {
            padding: 18px 16px;
        }

        .detail-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }

        .lower-grid {
            margin: 0 16px 18px;
        }

        .book-title {
            font-size: 2.2rem;
        }

        .signal-divider {
            display: none;
        }

        .cta-row {
            display: grid;
            grid-template-columns: 1fr;
        }

        .meta-grid {
            grid-template-columns: 1fr;
        }

        .recommend-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>

<div class="detail-book-page">
    <a href="{{ route('siswa.peminjaman.create') }}" class="back-btn-modern">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke katalog</span>
    </a>

    <div class="detail-heading">
        <div>
            <h2>We recommend</h2>
            <p>Temukan bacaan pilihan untuk perjalanan literasimu.</p>
        </div>
        <p><i class="bi bi-book-half"></i> Koleksi perpustakaan sekolah</p>
    </div>

    <div class="hero-shell">
        <div class="hero-layout">
            <div class="cover-panel">
                <div class="cover-frame">
                    @if($buku->cover)
                        <img src="{{ Storage::url($buku->cover) }}" alt="{{ $buku->judul }}">
                    @else
                        <div class="cover-placeholder">
                            <i class="bi bi-book-fill"></i>
                            <strong>{{ Str::limit($buku->judul, 28) }}</strong>
                            <small>{{ $buku->pengarang }}</small>
                        </div>
                    @endif
                </div>
                <div class="stock-pill {{ $buku->stok > 0 ? '' : 'habis' }}">
                    <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                    {{ $buku->stok > 0 ? 'Tersedia dipinjam' : 'Sedang tidak tersedia' }}
                </div>
            </div>

            <div class="book-copy">
                <div class="eyebrow">{{ $buku->kategori }}</div>
                <h1 class="book-title">{{ $buku->judul }}</h1>
                <div class="book-author">oleh <strong>{{ $buku->pengarang }}</strong></div>

                <div class="book-signal">
                    <span class="signal-item"><i class="bi bi-bookmark-heart-fill"></i> <strong>{{ $buku->kategori }}</strong></span>
                    <span class="signal-divider"></span>
                    <span class="signal-item"><i class="bi bi-box-seam-fill"></i> {{ $buku->stok }} eksemplar</span>
                    <span class="signal-divider"></span>
                    <span class="signal-item"><i class="bi bi-calendar3"></i> {{ $buku->tahun_terbit }}</span>
                </div>

                <div class="cta-row">
                    @if($buku->stok > 0)
                        <form method="POST" action="{{ route('siswa.peminjaman.store') }}" style="margin:0;" onsubmit="return confirm('Pinjam buku ini?\nBatas pengembalian 7 hari.')">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                            <button type="submit" class="btn-primary-large">
                                <i class="bi bi-book"></i>
                                <span>Pinjam Sekarang</span>
                            </button>
                        </form>
                    @else
                        <button type="button" class="btn-primary-large" style="opacity:0.7; cursor:not-allowed;" disabled>
                            <i class="bi bi-clock"></i>
                            <span>Tidak Tersedia</span>
                        </button>
                    @endif

                    <a href="{{ route('siswa.peminjaman.create') }}" class="btn-soft-large">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>

                <div class="summary-box">
                    {{ $buku->deskripsi ? Str::limit($buku->deskripsi, 260) : 'Buku ini menyajikan kisah yang menggugah, kaya makna, dan cocok untuk memperluas wawasan serta menumbuhkan rasa ingin tahu siswa.' }}
                </div>

                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="label">Penerbit</span>
                        <span class="value">{{ $buku->penerbit }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="label">Tahun</span>
                        <span class="value">{{ $buku->tahun_terbit }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="label">Stok</span>
                        <span class="value">{{ $buku->stok }} tersedia</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lower-grid">
            <div class="info-card">
                <h3>Tentang Buku</h3>
                <p>{{ $buku->deskripsi ?: 'Buku ini menghadirkan pengalaman membaca yang menarik, ringan dibaca, dan penuh makna. cocok untuk siswa yang ingin menemukan inspirasi, mengasah literasi, dan menikmati karya yang memberi pesan positif.' }}</p>
            </div>

            <div class="author-card">
                <h3>Penulis</h3>
                <div class="author-box">
                    <div class="author-avatar">{{ strtoupper(substr($buku->pengarang, 0, 1)) }}</div>
                    <div class="author-meta">
                        <strong>{{ $buku->pengarang }}</strong>
                        <span>Penulis</span>
                    </div>
                </div>

                <div class="mini-list">
                    <div class="mini-item"><span>Kategori</span> <strong>{{ $buku->kategori }}</strong></div>
                    <div class="mini-item"><span>Kode</span> <strong>{{ $buku->kode_buku }}</strong></div>
                    <div class="mini-item"><span>Status</span> <strong>{{ $buku->stok > 0 ? 'Ready' : 'Habis' }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="recommend-panel">
        <div class="recommend-layout">
            <section>
                <div class="recommend-header">
                    <h3>More books to explore</h3>
                    <span>Untukmu</span>
                </div>

                @if($rekomendasiBuku->isEmpty())
                    <div class="info-card">
                        Belum ada rekomendasi buku saat ini.
                    </div>
                @else
                    <div class="recommend-grid">
                        @foreach($rekomendasiBuku as $rekomendasi)
                            <div class="rec-card">
                                <div class="rec-cover">
                                    @if($rekomendasi->cover)
                                        <img src="{{ Storage::url($rekomendasi->cover) }}" alt="{{ $rekomendasi->judul }}">
                                    @else
                                        <div class="rec-placeholder"><i class="bi bi-book-fill"></i></div>
                                    @endif
                                </div>
                                <div class="rec-title">{{ $rekomendasi->judul }}</div>
                                <div class="rec-author">{{ $rekomendasi->pengarang }}</div>
                                <a href="{{ route('siswa.peminjaman.detail', $rekomendasi) }}" class="rec-action">Lihat Detail</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <aside class="latest-panel">
                <div class="latest-kicker">New releases</div>
                <h2 class="latest-title">Buku Terbaru</h2>
                @forelse($bukuTerbaru as $terbaru)
                    <a href="{{ route('siswa.peminjaman.detail', $terbaru) }}" class="latest-book">
                        @if($terbaru->cover)
                            <img class="latest-cover" src="{{ Storage::url($terbaru->cover) }}" alt="{{ $terbaru->judul }}" loading="lazy">
                        @else
                            <div class="latest-placeholder"><i class="bi bi-book-fill"></i></div>
                        @endif
                        <span>
                            <span class="latest-book-name">{{ $terbaru->judul }}</span>
                            <span class="latest-book-author">{{ $terbaru->pengarang }}</span>
                            <span class="latest-book-link">Lihat buku <i class="bi bi-arrow-right"></i></span>
                        </span>
                    </a>
                @empty
                    <p style="margin:0;color:#cbd5e1;font-size:.78rem;">Belum ada buku terbaru.</p>
                @endforelse
            </aside>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ── back-btn-modern: arrow slides ── */
.back-btn-modern{position:relative;overflow:hidden;transition:all .25s cubic-bezier(.34,1.56,.64,1) !important;}
.back-btn-modern i{display:inline-block;}
.back-btn-modern:hover i{animation:detBackSlide .4s ease;}
@keyframes detBackSlide{
  0%{transform:translateX(0) scale(1)}
  35%{transform:translateX(-7px) scale(1.15)}
  65%{transform:translateX(-3px) scale(1.08)}
  100%{transform:translateX(0) scale(1)}
}
/* ── btn-primary-large (Pinjam Sekarang): glow + book bounce ── */
.btn-primary-large{
  position:relative;overflow:hidden;
  animation:detPinjamGlow 2.5s ease-in-out infinite;
  transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .28s ease !important;
}
@keyframes detPinjamGlow{
  0%,100%{box-shadow:0 4px 14px rgba(237,27,59,.25)}
  50%{box-shadow:0 10px 28px rgba(237,27,59,.52),0 0 0 5px rgba(237,27,59,.1)}
}
.btn-primary-large[disabled]{animation:none !important;}
.btn-primary-large:not([disabled]):hover{
  animation:none;
  transform:translateY(-4px) scale(1.04) !important;
  box-shadow:0 14px 36px rgba(237,27,59,.48) !important;
}
.btn-primary-large::before{
  content:'';position:absolute;top:0;left:-110%;width:55%;height:100%;
  background:linear-gradient(100deg,transparent,rgba(255,255,255,.28),transparent);
  transform:skewX(-20deg);pointer-events:none;
}
.btn-primary-large:not([disabled]):hover::before{animation:detShimmer .5s ease forwards;}
@keyframes detShimmer{0%{left:-110%}100%{left:120%}}
.btn-primary-large i{display:inline-block;}
.btn-primary-large:not([disabled]):hover i{animation:detBookBounce .5s ease;}
@keyframes detBookBounce{
  0%{transform:translateY(0) rotate(0) scale(1)}
  25%{transform:translateY(-7px) rotate(-8deg) scale(1.2)}
  50%{transform:translateY(-3px) rotate(4deg) scale(1.1)}
  75%{transform:translateY(-5px) rotate(-5deg) scale(1.15)}
  100%{transform:translateY(0) rotate(0) scale(1)}
}
.det-ripple{position:absolute;border-radius:50%;background:rgba(255,255,255,.4);transform:scale(0);animation:detRipple .4s linear;pointer-events:none;}
@keyframes detRipple{to{transform:scale(4);opacity:0}}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.back-btn-modern,.btn-primary-large:not([disabled])').forEach(function(btn){
    btn.addEventListener('click',function(e){
      const r=document.createElement('span');r.className='det-ripple';
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

@endsection

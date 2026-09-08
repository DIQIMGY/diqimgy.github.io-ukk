@extends('layouts.app')
@section('title','Koleksi Series')
@section('page-title','Koleksi Series')
@section('content')

<style>
.page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px}
.page-header>div:first-child::before{content:'MANAJEMEN SERIES';display:block;color:var(--crimson);font-size:.64rem;font-weight:900;letter-spacing:.16em;margin-bottom:7px}
.btn-add{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--crimson),#c41630);color:#fff;font-weight:700;font-size:.85rem;padding:10px 20px;border-radius:10px;border:none;text-decoration:none;transition:all .2s}
.btn-add:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(237,27,59,.35);color:#fff}

.series-table{width:100%;border-collapse:separate;border-spacing:0;background:#fff;border-radius:14px;overflow:hidden;border:1px solid #f0f0f0;box-shadow:0 4px 20px rgba(20,40,75,.06)}
.series-table thead tr{background:linear-gradient(110deg,#0b1730,#14284b)}
.series-table thead th{color:#fff;font-size:.76rem;font-weight:700;letter-spacing:.07em;padding:13px 16px;text-transform:uppercase;border:none}
.series-table tbody tr{transition:background .15s;border-bottom:1px solid #f5f5f5}
.series-table tbody tr:last-child{border-bottom:none}
.series-table tbody tr:hover{background:#fafbff}
.series-table td{padding:14px 16px;vertical-align:middle;font-size:.85rem;color:#374151}

.badge-count{display:inline-flex;align-items:center;gap:5px;background:#eff6ff;color:#1d4ed8;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:99px}
.btn-edit{display:inline-flex;align-items:center;gap:5px;background:#f0f4ff;color:#3b4fd4;font-size:.75rem;font-weight:700;padding:6px 12px;border-radius:8px;text-decoration:none;transition:all .18s}
.btn-edit:hover{background:#3b4fd4;color:#fff}
.btn-del{display:inline-flex;align-items:center;gap:5px;background:#fff0f0;color:var(--crimson);font-size:.75rem;font-weight:700;padding:6px 12px;border-radius:8px;border:none;cursor:pointer;transition:all .18s}
.btn-del:hover{background:var(--crimson);color:#fff}

.empty-state{text-align:center;padding:60px 20px;color:#9ca3af}
.empty-state i{font-size:3rem;margin-bottom:12px;display:block;opacity:.3}
</style>

<div class="page-header">
  <div>
    <h1 style="font-size:1.6rem;font-weight:800;color:#0b1730;margin:0">Koleksi Series</h1>
    <p style="color:#6b7280;font-size:.84rem;margin-top:4px">Kelola semua series buku perpustakaan</p>
  </div>
  <a href="{{ route('admin.series.create') }}" class="btn-add">
    <i class="bi bi-plus-lg"></i> Tambah Series
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:10px;border:none;background:#ecfdf5;color:#065f46;font-weight:600">
  <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<table class="series-table">
  <thead>
    <tr>
      <th style="width:48px">#</th>
      <th>Nama Series</th>
      <th>Penulis</th>
      <th style="text-align:center">Jumlah Buku</th>
      <th>Deskripsi</th>
      <th style="text-align:center;width:160px">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($series as $i => $s)
    <tr>
      <td style="color:#9ca3af;font-weight:600">{{ $series->firstItem() + $i }}</td>
      <td>
        <div style="font-weight:800;color:#0b1730;font-size:.9rem">{{ $s->nama_series }}</div>
        <div style="font-size:.73rem;color:#9ca3af;margin-top:2px">{{ $s->slug }}</div>
      </td>
      <td>{{ $s->penulis }}</td>
      <td style="text-align:center">
        <span class="badge-count">
          <i class="bi bi-book-fill" style="font-size:.65rem"></i>
          {{ $s->buku_count }} buku
        </span>
      </td>
      <td style="color:#6b7280;max-width:220px">
        <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
          {{ $s->deskripsi ?: '—' }}
        </div>
      </td>
      <td style="text-align:center">
        <div style="display:flex;gap:8px;justify-content:center">
          <a href="{{ route('admin.series.edit', $s) }}" class="btn-edit">
            <i class="bi bi-pencil-fill"></i> Kelola
          </a>
          <form action="{{ route('admin.series.destroy', $s) }}" method="POST"
                onsubmit="return confirm('Hapus series \"{{ $s->nama_series }}\"? Semua data buku dalam series akan dilepas.')">
            @csrf @method('DELETE')
            <button class="btn-del">
              <i class="bi bi-trash-fill"></i>
            </button>
          </form>
        </div>
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="6">
        <div class="empty-state">
          <i class="bi bi-collection"></i>
          <p style="font-weight:600;margin-bottom:8px">Belum ada series</p>
          <a href="{{ route('admin.series.create') }}" class="btn-add" style="display:inline-flex">
            <i class="bi bi-plus-lg"></i> Tambah Series Pertama
          </a>
        </div>
      </td>
    </tr>
    @endforelse
  </tbody>
</table>

@if($series->hasPages())
<div style="margin-top:20px">{{ $series->links() }}</div>
@endif

@endsection

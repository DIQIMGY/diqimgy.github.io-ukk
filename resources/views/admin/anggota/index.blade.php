@extends('layouts.app')
@section('title','Kelola Anggota')
@section('page-title','Kelola Anggota')
@section('content')
<div class="toolbar">
  <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Tambah Anggota</a>
  <div class="toolbar-right">
    <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
      <div class="input-group" style="width:210px">
        <span class="input-group-text"><i class="bi bi-search" style="font-size:.78rem"></i></span>
        <input type="text" name="search" class="form-control" placeholder="Nama / NIS / Kelas…" value="{{ request('search') }}">
      </div>
      <select name="status" class="form-select" style="width:130px">
        <option value="">Semua Status</option>
        <option value="aktif" {{ request('status')==='aktif'?'selected':'' }}>Aktif</option>
        <option value="nonaktif" {{ request('status')==='nonaktif'?'selected':'' }}>Non-aktif</option>
      </select>
      <button class="btn btn-ghost"><i class="bi bi-funnel"></i></button>
      @if(request()->hasAny(['search','status']))<a href="{{ route('admin.anggota.index') }}" class="btn btn-ghost"><i class="bi bi-x-lg"></i></a>@endif
    </form>
  </div>
</div>

<div class="data-card">
  <div class="data-card-header">
    <h6><i class="bi bi-people-fill" style="color:var(--green-500)"></i> Daftar Anggota</h6>
    <span class="count-badge">{{ $anggota->total() }} anggota</span>
  </div>
  <div class="table-responsive">
    <table class="dt">
      <thead><tr><th style="width:42px">#</th><th>Anggota</th><th>NIS</th><th>Kelas</th><th>Email</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($anggota as $a)
        <tr>
          <td style="color:var(--tx-4);font-size:.78rem">{{ $anggota->firstItem()+$loop->index }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div class="ava">{{ strtoupper(substr($a->nama,0,1)) }}</div>
              <span style="font-weight:700;font-size:.85rem">{{ $a->nama }}</span>
            </div>
          </td>
          <td><span class="pill">{{ $a->nis }}</span></td>
          <td style="font-size:.83rem">{{ $a->kelas }}</td>
          <td style="font-size:.81rem;color:var(--tx-3)">{{ $a->user->email??'-' }}</td>
          <td>
            @if($a->status==='aktif')<span class="status-badge sb-aktif"><i class="bi bi-circle-fill" style="font-size:.45rem"></i>Aktif</span>
            @else<span class="status-badge sb-nonaktif"><i class="bi bi-circle" style="font-size:.45rem"></i>Non-aktif</span>@endif
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <a href="{{ route('admin.anggota.show',$a) }}" class="btn btn-xs btn-ico bv" title="Detail"><i class="bi bi-eye"></i></a>
              <a href="{{ route('admin.anggota.edit',$a) }}" class="btn btn-xs btn-ico be" title="Edit"><i class="bi bi-pencil"></i></a>
              <form method="POST" action="{{ route('admin.anggota.destroy',$a) }}" onsubmit="return confirm('Hapus anggota ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-xs btn-ico bd"><i class="bi bi-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7"><div class="empty"><span class="empty-ico"><i class="bi bi-people"></i></span><h6>Tidak ada anggota</h6><p>Coba ubah filter pencarian.</p></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($anggota->hasPages())<div class="dt-pager">{{ $anggota->links() }}</div>@endif
</div>
@endsection

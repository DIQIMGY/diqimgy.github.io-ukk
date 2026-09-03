@extends('layouts.app')
@section('title','Tambah Transaksi')
@section('page-title','Tambah Transaksi')
@section('content')
<style>
.form-page-modern {
  animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.form-header-modern {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 28px;
  padding-bottom: 20px;
  border-bottom: 2px solid rgba(237,27,59,0.1);
}
.back-btn-form {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 10px 18px;
  background: linear-gradient(135deg, rgba(237,27,59,0.08) 0%, rgba(237,27,59,0.02) 100%);
  border: 1.5px solid rgba(237,27,59,0.2);
  border-radius: 12px;
  color: #ED1B3B;
  font-weight: 600;
  font-size: 0.875rem;
  text-decoration: none;
  transition: all 0.3s ease;
}
.back-btn-form:hover {
  background: linear-gradient(135deg, rgba(237,27,59,0.15) 0%, rgba(237,27,59,0.05) 100%);
  border-color: rgba(237,27,59,0.4);
  transform: translateX(-4px);
  color: #ED1B3B;
}
.form-title-modern {
  font-size: 1.5rem;
  font-weight: 800;
  color: #14284B;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 12px;
}
.form-title-modern i {
  color: #ED1B3B;
  font-size: 1.8rem;
}
.form-card-modern {
  background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
  border-radius: 24px;
  padding: 36px;
  box-shadow: 0 8px 32px rgba(20,40,75,0.08),
              0 2px 8px rgba(20,40,75,0.04);
  border: 1px solid rgba(20,40,75,0.06);
}
.alert-modern {
  background: linear-gradient(135deg, rgba(220,38,38,0.1) 0%, rgba(220,38,38,0.05) 100%);
  border: 1.5px solid rgba(220,38,38,0.3);
  border-radius: 16px;
  padding: 20px;
  margin-bottom: 28px;
}
.alert-modern ul {
  margin: 0;
  padding-left: 20px;
  color: #dc2626;
  font-size: 0.9rem;
  font-weight: 600;
}
.form-section-title {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1.1rem;
  font-weight: 800;
  color: #ED1B3B;
  margin-bottom: 24px;
  padding-bottom: 12px;
  border-bottom: 2px solid rgba(237,27,59,0.15);
}
.form-section-title i {
  font-size: 1.4rem;
}
.form-label-modern {
  font-weight: 700;
  font-size: 0.875rem;
  color: #14284B;
  margin-bottom: 8px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.required-mark {
  color: #ED1B3B;
  font-weight: 800;
}
.form-control-modern, .form-select-modern {
  width: 100%;
  padding: 12px 16px;
  border: 1.5px solid rgba(20,40,75,0.12);
  border-radius: 10px;
  font-size: 0.88rem;
  color: #14284B;
  background: white;
  transition: all 0.3s ease;
  font-weight: 500;
}
.form-control-modern:focus, .form-select-modern:focus {
  outline: none;
  border-color: #ED1B3B;
  box-shadow: 0 0 0 4px rgba(237,27,59,0.1);
  background: white;
}
.form-select-modern {
  cursor: pointer;
}
.form-actions-modern {
  margin-top: 32px;
  padding-top: 28px;
  border-top: 2px solid rgba(237,27,59,0.1);
  display: flex;
  gap: 12px;
}
.btn-submit-modern {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 16px 32px;
  background: linear-gradient(135deg, #ED1B3B 0%, #C41630 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 16px rgba(237,27,59,0.3);
}
.btn-submit-modern:hover {
  background: linear-gradient(135deg, #C41630 0%, #A01228 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 24px rgba(237,27,59,0.4);
}
.btn-cancel-modern {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 16px 28px;
  background: linear-gradient(135deg, rgba(20,40,75,0.08) 0%, rgba(20,40,75,0.02) 100%);
  border: 2px solid rgba(20,40,75,0.15);
  border-radius: 12px;
  color: #14284B;
  font-weight: 700;
  font-size: 1rem;
  text-decoration: none;
  transition: all 0.3s ease;
}
.btn-cancel-modern:hover {
  background: linear-gradient(135deg, rgba(20,40,75,0.12) 0%, rgba(20,40,75,0.04) 100%);
  border-color: rgba(20,40,75,0.25);
  color: #14284B;
}
</style>

<div class="form-page-modern">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
      <div class="form-header-modern">
        <a href="{{ route('admin.transaksi.index') }}" class="back-btn-form">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali</span>
        </a>
        <h1 class="form-title-modern">
          <i class="bi bi-arrow-left-right"></i>
          <span>Tambah Transaksi Peminjaman</span>
        </h1>
      </div>

      <div class="form-card-modern">
        @if($errors->any())
        <div class="alert-modern">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.transaksi.store') }}">
          @csrf

          <div class="form-section-title">
            <i class="bi bi-journal-text"></i>
            <span>Detail Peminjaman</span>
          </div>

          <div class="row g-4">
            <div class="col-12">
              <label class="form-label-modern">
                Anggota
                <span class="required-mark">*</span>
              </label>
              <select name="anggota_id" class="form-select-modern" required>
                <option value="">— Pilih Anggota —</option>
                @foreach($anggota as $a)
                <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                  {{ $a->nis }} — {{ $a->nama }} ({{ $a->kelas }})
                </option>
                @endforeach
              </select>
            </div>

            <div class="col-12">
              <label class="form-label-modern">
                Buku
                <span class="required-mark">*</span>
              </label>
              <select name="buku_id" class="form-select-modern" required>
                <option value="">— Pilih Buku —</option>
                @foreach($buku as $b)
                <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                  {{ $b->kode_buku }} — {{ $b->judul }} (Stok: {{ $b->stok }})
                </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label-modern">
                Tanggal Pinjam
                <span class="required-mark">*</span>
              </label>
              <input type="date" name="tanggal_pinjam" class="form-control-modern" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
            </div>

            <div class="col-md-6">
              <label class="form-label-modern">
                Batas Kembali
                <span class="required-mark">*</span>
              </label>
              <input type="date" name="tanggal_kembali_rencana" class="form-control-modern" value="{{ old('tanggal_kembali_rencana', date('Y-m-d', strtotime('+7 days'))) }}" required>
            </div>
          </div>

          <div class="form-actions-modern">
            <button type="submit" class="btn-submit-modern">
              <i class="bi bi-check-circle-fill"></i>
              <span>Simpan Transaksi</span>
            </button>
            <a href="{{ route('admin.transaksi.index') }}" class="btn-cancel-modern">
              <i class="bi bi-x-circle"></i>
              <span>Batal</span>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('title','Edit Buku')
@section('page-title','Edit Buku')
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
  font-size: 1.3rem;
  font-weight: 800;
  color: #14284B;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 12px;
}
.form-title-modern i {
  color: #ED1B3B;
  font-size: 1.4rem;
}
.form-card-modern {
  background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
  border-radius: 20px;
  padding: 28px;
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
.form-control-modern {
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
.form-control-modern:focus {
  outline: none;
  border-color: #ED1B3B;
  box-shadow: 0 0 0 4px rgba(237,27,59,0.1);
  background: white;
}
.form-control-modern::placeholder {
  color: #94a3b8;
  font-weight: 400;
}
.current-cover-wrap {
  margin-bottom: 16px;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(237,27,59,0.2);
  background: linear-gradient(135deg, #14284B 0%, #0B1730 100%);
  aspect-ratio: 2/3;
  position: relative;
}
.current-cover-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.current-cover-label {
  font-size: 0.75rem;
  color: #64748b;
  font-weight: 600;
  margin-bottom: 12px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.current-cover-label i {
  color: #ED1B3B;
}
.cover-preview-modern {
  margin-top: 16px;
  border-radius: 16px;
  overflow: hidden;
  background: linear-gradient(135deg, #14284B 0%, #0B1730 100%);
  box-shadow: 0 8px 24px rgba(20,40,75,0.2);
  aspect-ratio: 2/3;
  position: relative;
  display: none;
}
.cover-preview-modern.active {
  display: block;
}
.cover-preview-modern img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
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
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 16px rgba(245,158,11,0.3);
}
.btn-submit-modern:hover {
  background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 24px rgba(245,158,11,0.4);
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
    <div class="col-lg-10 col-xl-9">
      <div class="form-header-modern">
        <a href="{{ route('admin.buku.index') }}" class="back-btn-form">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali</span>
        </a>
        <h1 class="form-title-modern">
          <i class="bi bi-pencil-square"></i>
          <span>Edit Buku</span>
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

        <form method="POST" action="{{ route('admin.buku.update', $buku) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-section-title">
            <i class="bi bi-card-heading"></i>
            <span>Identitas Buku</span>
          </div>

          <div class="row g-4 mb-5">
            <div class="col-md-4">
              <label class="form-label-modern">
                Kode Buku
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="kode_buku" class="form-control-modern" value="{{ old('kode_buku', $buku->kode_buku) }}" required>
            </div>

            <div class="col-md-4">
              <label class="form-label-modern">
                Kategori
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="kategori" class="form-control-modern" value="{{ old('kategori', $buku->kategori) }}" required>
            </div>

            <div class="col-md-4">
              <label class="form-label-modern">
                Stok
                <span class="required-mark">*</span>
              </label>
              <input type="number" name="stok" class="form-control-modern" value="{{ old('stok', $buku->stok) }}" min="0" required>
            </div>

            <div class="col-12">
              <label class="form-label-modern">
                Judul Buku
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="judul" class="form-control-modern" value="{{ old('judul', $buku->judul) }}" required>
            </div>

            <div class="col-md-6">
              <label class="form-label-modern">
                Pengarang
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="pengarang" class="form-control-modern" value="{{ old('pengarang', $buku->pengarang) }}" required>
            </div>

            <div class="col-md-4">
              <label class="form-label-modern">
                Penerbit
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="penerbit" class="form-control-modern" value="{{ old('penerbit', $buku->penerbit) }}" required>
            </div>

            <div class="col-md-2">
              <label class="form-label-modern">
                Tahun
                <span class="required-mark">*</span>
              </label>
              <input type="number" name="tahun_terbit" class="form-control-modern" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="{{ date('Y') }}" required>
            </div>
          </div>

          <div class="form-section-title">
            <i class="bi bi-image-fill"></i>
            <span>Cover & Deskripsi</span>
          </div>

          <div class="row g-4">
            <div class="col-md-4">
              <label class="form-label-modern">Cover Buku</label>
              
              @if($buku->cover)
                <div class="current-cover-label">
                  <i class="bi bi-image"></i>
                  <span>Cover saat ini</span>
                </div>
                <div class="current-cover-wrap">
                  <img src="{{ Storage::url($buku->cover) }}" alt="cover saat ini">
                </div>
              @endif

              <input type="file" name="cover" class="form-control-modern" accept="image/*" onchange="previewCover(this)" style="margin-top: 16px">
              
              <div class="cover-preview-modern" id="coverPreview">
                <img id="coverImage" src="" alt="preview">
              </div>
            </div>

            <div class="col-md-8">
              <label class="form-label-modern">Deskripsi</label>
              <textarea name="deskripsi" class="form-control-modern" rows="12">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
            </div>
          </div>

          <div class="form-actions-modern">
            <button type="submit" class="btn-submit-modern">
              <i class="bi bi-check-circle-fill"></i>
              <span>Perbarui Buku</span>
            </button>
            <a href="{{ route('admin.buku.index') }}" class="btn-cancel-modern">
              <i class="bi bi-x-circle"></i>
              <span>Batal</span>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function previewCover(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('coverImage').src = e.target.result;
      document.getElementById('coverPreview').classList.add('active');
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush
@endsection

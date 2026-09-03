@extends('layouts.app')
@section('title','Edit Anggota')
@section('page-title','Edit Anggota')
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
.label-hint {
  font-weight: 400;
  color: #64748b;
  font-size: 0.8rem;
  margin-left: 4px;
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
.form-select-modern {
  width: 100%;
  padding: 12px 16px;
  border: 1.5px solid rgba(20,40,75,0.12);
  border-radius: 10px;
  font-size: 0.88rem;
  color: #14284B;
  background: white;
  transition: all 0.3s ease;
  font-weight: 500;
  cursor: pointer;
}
.form-select-modern:focus {
  outline: none;
  border-color: #ED1B3B;
  box-shadow: 0 0 0 4px rgba(237,27,59,0.1);
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
    <div class="col-lg-9 col-xl-8">
      <div class="form-header-modern">
        <a href="{{ route('admin.anggota.index') }}" class="back-btn-form">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali</span>
        </a>
        <h1 class="form-title-modern">
          <i class="bi bi-pencil-square"></i>
          <span>Edit Anggota</span>
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

        <form method="POST" action="{{ route('admin.anggota.update', $anggota) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="form-section-title">
            <i class="bi bi-person-vcard"></i>
            <span>Data Pribadi</span>
          </div>

          <div class="row g-4 mb-5">
            <div class="col-12">
              <label class="form-label-modern">
                Nama Lengkap
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="name" class="form-control-modern" value="{{ old('name', $anggota->nama) }}" required>
            </div>

            <div class="col-12">
              <label class="form-label-modern">
                <i class="bi bi-image"></i> Foto Profil
              </label>
              @if($anggota->foto)
                <div style="margin-bottom: 16px;">
                  <img src="{{ Storage::url($anggota->foto) }}" alt="Foto" 
                       style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 3px solid #f0f0f0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                  <div style="margin-top: 8px;">
                    <label style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.8rem; color: #64748b;">
                      <input type="checkbox" name="hapus_foto" value="1" style="width: 16px; height: 16px;">
                      Hapus foto saat ini
                    </label>
                  </div>
                </div>
              @endif
              <input type="file" name="foto" class="form-control-modern" accept="image/jpeg,image/png,image/jpg" style="padding: 10px 16px;">
              <small style="display: block; margin-top: 6px; color: #64748b; font-size: 0.8rem;">
                <i class="bi bi-info-circle"></i> Format: JPG, JPEG, PNG (Max 2MB){{ $anggota->foto ? ' — Upload file baru untuk mengganti' : '' }}
              </small>
            </div>

            <div class="col-md-4">
              <label class="form-label-modern">
                NIS
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="nis" class="form-control-modern" value="{{ old('nis', $anggota->nis) }}" required>
            </div>

            <div class="col-md-4">
              <label class="form-label-modern">
                Kelas
                <span class="required-mark">*</span>
              </label>
              <input type="text" name="kelas" class="form-control-modern" value="{{ old('kelas', $anggota->kelas) }}" required>
            </div>

            <div class="col-md-4">
              <label class="form-label-modern">
                Status
                <span class="required-mark">*</span>
              </label>
              <select name="status" class="form-select-modern" required>
                <option value="aktif" {{ old('status', $anggota->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', $anggota->status) === 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label-modern">No. Telepon</label>
              <input type="text" name="telepon" class="form-control-modern" value="{{ old('telepon', $anggota->telepon) }}" placeholder="08xxxxxxxxxx">
            </div>

            <div class="col-md-6">
              <label class="form-label-modern">Alamat</label>
              <input type="text" name="alamat" class="form-control-modern" value="{{ old('alamat', $anggota->alamat) }}" placeholder="Alamat lengkap">
            </div>
          </div>

          <div class="form-section-title">
            <i class="bi bi-shield-lock-fill"></i>
            <span>Data Akun Login</span>
          </div>

          <div class="row g-4">
            <div class="col-12">
              <label class="form-label-modern">
                Email
                <span class="required-mark">*</span>
              </label>
              <input type="email" name="email" class="form-control-modern" value="{{ old('email', $anggota->user->email) }}" required>
            </div>

            <div class="col-md-6">
              <label class="form-label-modern">
                Password Baru
                <span class="label-hint">(kosongkan jika tidak diubah)</span>
              </label>
              <input type="password" name="password" class="form-control-modern" placeholder="Minimal 6 karakter">
            </div>
          </div>

          <div class="form-actions-modern">
            <button type="submit" class="btn-submit-modern">
              <i class="bi bi-check-circle-fill"></i>
              <span>Perbarui Anggota</span>
            </button>
            <a href="{{ route('admin.anggota.index') }}" class="btn-cancel-modern">
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

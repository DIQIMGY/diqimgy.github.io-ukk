<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Siswa\ProfilController
 * ──────────────────────────────────────────────────────────────
 * Menangani halaman profil siswa — siswa bisa mengelola
 * data dirinya sendiri tanpa perlu ke admin.
 *
 * FITUR:
 *   - Lihat profil (nama, kelas, kontak, foto)
 *   - Edit profil (termasuk upload/ganti foto)
 *   - Ganti password
 *
 * CATATAN:
 *   Perubahan nama di sini juga mengupdate tabel users (kolom name)
 *   agar nama tampil konsisten di semua tempat.
 * ──────────────────────────────────────────────────────────────
 */
class ProfilController extends Controller
{
    /**
     * index()
     * Tampilkan halaman profil siswa yang sedang login.
     * Redirect ke dashboard jika data anggota tidak ditemukan
     * (kasus edge: user ada tapi record anggota belum dibuat).
     */
    public function index()
    {
        $user    = Auth::user();
        $anggota = $user->anggota;

        if (!$anggota) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data anggota tidak ditemukan.');
        }

        return view('siswa.profil.index', compact('user', 'anggota'));
    }

    /**
     * update()
     * Simpan perubahan data profil siswa.
     *  1. Validasi input (nama, kelas, kontak, foto)
     *  2. Upload foto baru jika ada (hapus foto lama dulu)
     *  3. Update data anggota
     *  4. Sinkronisasi nama ke tabel users
     */
    public function update(Request $request)
    {
        $user    = Auth::user();
        $anggota = $user->anggota;

        $request->validate([
            'nama'    => 'required|string|max:100',
            'kelas'   => 'required|string|max:20',
            'telepon' => 'nullable|string|max:20',
            'alamat'  => 'nullable|string|max:255',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // maks 2MB
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        // ── Proses foto baru ──────────────────────────────────────
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage sebelum simpan yang baru
            if ($anggota->foto) {
                Storage::disk('public')->delete($anggota->foto);
            }
            // Simpan foto baru ke storage/public/anggota/foto/
            $path = $request->file('foto')->store('anggota/foto', 'public');
            $anggota->foto = $path;
        }

        // Update data anggota
        $anggota->nama    = $request->nama;
        $anggota->kelas   = $request->kelas;
        $anggota->telepon = $request->telepon;
        $anggota->alamat  = $request->alamat;
        $anggota->save();

        // Sinkronisasi nama ke tabel users agar nama tampil konsisten
        // (navbar, avatar, dsb biasanya ambil dari users.name)
        $user->name = $request->nama;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * updatePassword()
     * Ganti password siswa yang sedang login.
     *  1. Validasi: password lama harus benar, password baru min 6 karakter, konfirmasi cocok
     *  2. Cek password lama menggunakan Hash::check()
     *  3. Simpan password baru yang sudah di-hash
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password_lama'         => 'required',
            'password'              => 'required|min:6|confirmed', // confirmed = butuh field password_confirmation
            'password_confirmation' => 'required',
        ], [
            'password_lama.required'  => 'Password lama wajib diisi.',
            'password.required'       => 'Password baru wajib diisi.',
            'password.min'            => 'Password minimal 6 karakter.',
            'password.confirmed'      => 'Konfirmasi password tidak cocok.',
        ]);

        // Verifikasi password lama — Hash::check() membandingkan plain text dengan hash
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                ->withInput();
        }

        // Simpan password baru dengan di-hash (jangan pernah simpan plain text)
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
}

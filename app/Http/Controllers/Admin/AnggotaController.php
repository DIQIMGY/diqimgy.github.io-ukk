<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Admin\AnggotaController
 * ──────────────────────────────────────────────────────────────
 * Mengelola data anggota perpustakaan dari sisi admin.
 * Setiap anggota terhubung ke satu akun User (untuk login).
 *
 * CATATAN ROUTE MODEL BINDING:
 *   Tabel bernama 'anggota' (bukan 'anggotas'), jadi Laravel
 *   menggunakan nama binding 'anggotum' (singular dari 'anggota')
 *   supaya route model binding bekerja dengan benar.
 * ──────────────────────────────────────────────────────────────
 */
class AnggotaController extends Controller
{
    /**
     * index()
     * Tampilkan daftar semua anggota dengan fitur:
     *  - Tab terpisah untuk Siswa dan Admin
     *  - Pencarian berdasarkan nama, NIS, atau kelas (untuk siswa) / nama atau email (untuk admin)
     *  - Filter berdasarkan status (aktif / nonaktif) untuk siswa
     *  - Paginasi 10 data per halaman
     *  - Ringkasan statistik: total anggota & total yang aktif
     */
    public function index(Request $request)
    {
        // Tab aktif (default: siswa)
        $tab = $request->get('tab', 'siswa');

        if ($tab === 'admin') {
            // ─── Tab Admin ───────────────────────────────────────
            $query = User::where('role', 'admin');

            // Filter pencarian (nama / email)
            if ($request->filled('search')) {
                $q = $request->search;
                $query->where(function ($q2) use ($q) {
                    $q2->where('name',  'like', "%{$q}%")
                       ->orWhere('email', 'like', "%{$q}%");
                });
            }

            $admins     = $query->latest()->paginate(10)->withQueryString();
            $totalAdmin = User::where('role', 'admin')->count();

            return view('admin.anggota.index', compact('admins', 'totalAdmin', 'tab'));
        }

        // ─── Tab Siswa (default) ─────────────────────────────
        $query = Anggota::with('user');

        // Filter pencarian (nama / NIS / kelas)
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama',  'like', "%{$q}%")
                   ->orWhere('nis',  'like', "%{$q}%")
                   ->orWhere('kelas','like', "%{$q}%");
            });
        }

        // Filter berdasarkan status anggota
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $anggota    = $query->latest()->paginate(10)->withQueryString();
        $totalAktif = Anggota::where('status', 'aktif')->count();
        $totalSemua = Anggota::count();

        return view('admin.anggota.index', compact('anggota', 'totalAktif', 'totalSemua', 'tab'));
    }

    /**
     * create()
     * Tampilkan form tambah anggota baru.
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * store()
     * Simpan anggota baru ke database.
     *  1. Validasi semua input
     *  2. Buat akun User terlebih dahulu (untuk login)
     *  3. Upload foto jika ada
     *  4. Buat data Anggota yang terhubung ke User
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',  // email login harus unik
            'password' => 'required|min:6',
            'nis'      => 'required|string|unique:anggota,nis', // NIS harus unik
            'kelas'    => 'required|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:20',
            'status'   => 'required|in:aktif,nonaktif',
            'foto'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // maks 2MB
        ]);

        // Buat akun user untuk login
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa', // anggota yang dibuat admin juga berperan sebagai siswa
        ]);

        // Upload foto jika ada file yang diunggah
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('anggota', 'public');
        }

        // Buat data anggota yang terhubung ke user di atas
        Anggota::create([
            'user_id'  => $user->id,
            'nis'      => $request->nis,
            'nama'     => $request->name,
            'kelas'    => $request->kelas,
            'alamat'   => $request->alamat,
            'telepon'  => $request->telepon,
            'foto'     => $fotoPath,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * edit()
     * Tampilkan form edit data anggota.
     * Parameter $anggotum = nama binding Laravel untuk tabel 'anggota'.
     */
    public function edit(Anggota $anggotum)
    {
        // Kirim dengan alias 'anggota' supaya view tidak perlu tahu soal binding
        return view('admin.anggota.edit', ['anggota' => $anggotum]);
    }

    /**
     * update()
     * Simpan perubahan data anggota.
     *  1. Validasi input
     *  2. Update nama & email di tabel users
     *  3. Update password jika diisi (opsional)
     *  4. Handle foto: upload baru, hapus foto, atau biarkan sama
     *  5. Update data anggota
     */
    public function update(Request $request, Anggota $anggotum)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            // unique kecuali untuk user_id anggota ini sendiri (biar tidak konflik saat tidak diubah)
            'email'   => 'required|email|unique:users,email,' . $anggotum->user_id,
            'nis'     => 'required|string|unique:anggota,nis,' . $anggotum->id,
            'kelas'   => 'required|string|max:20',
            'alamat'  => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'status'  => 'required|in:aktif,nonaktif',
            'foto'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Update data akun login (nama tampil & email)
        $anggotum->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update password hanya jika diisi di form
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $anggotum->user->update(['password' => Hash::make($request->password)]);
        }

        // ── Proses foto ──────────────────────────────────────────
        $fotoPath = $anggotum->foto; // default = foto lama

        // Jika admin centang "Hapus Foto"
        if ($request->has('hapus_foto')) {
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath); // hapus file fisik
            }
            $fotoPath = null; // set null di database
        }

        // Jika ada foto baru diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama dulu sebelum simpan yang baru
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('anggota', 'public');
        }

        // Update data anggota
        $anggotum->update([
            'nis'     => $request->nis,
            'nama'    => $request->name,
            'kelas'   => $request->kelas,
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
            'foto'    => $fotoPath,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * destroy()
     * Hapus anggota beserta akun User-nya.
     *  1. Hapus file foto dari storage jika ada
     *  2. Hapus record anggota
     *  3. Hapus record user yang terhubung
     *
     * CATATAN: Hapus anggota dulu sebelum user karena ada FK dari anggota ke users.
     */
    public function destroy(Anggota $anggotum)
    {
        // Hapus foto dari storage jika ada
        if ($anggotum->foto && \Storage::disk('public')->exists($anggotum->foto)) {
            \Storage::disk('public')->delete($anggotum->foto);
        }

        $user = $anggotum->user; // simpan referensi user sebelum anggota dihapus
        $anggotum->delete();     // hapus anggota dulu (ada FK ke users)
        $user->delete();         // baru hapus user-nya

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * show()
     * Tampilkan detail profil satu anggota beserta riwayat peminjamannya.
     * Eager load peminjaman → buku supaya tidak N+1 query.
     */
    public function show(Anggota $anggotum)
    {
        $anggotum->load(['peminjaman.buku']);
        return view('admin.anggota.show', ['anggota' => $anggotum]);
    }

    // =========================================================
    //  ADMIN MANAGEMENT
    // =========================================================

    /**
     * editAdmin()
     * Tampilkan form edit data admin.
     */
    public function editAdmin(User $user)
    {
        // Pastikan user yang diedit adalah admin
        if ($user->role !== 'admin') {
            return redirect()->route('admin.anggota.index', ['tab' => 'admin'])
                ->with('error', 'User yang dipilih bukan admin.');
        }

        return view('admin.anggota.edit-admin', compact('user'));
    }

    /**
     * updateAdmin()
     * Simpan perubahan data admin.
     *  1. Validasi input
     *  2. Update nama & email
     *  3. Update password jika diisi (opsional)
     *  4. Update foto jika diunggah
     */
    public function updateAdmin(Request $request, User $user)
    {
        // Pastikan user yang diedit adalah admin
        if ($user->role !== 'admin') {
            return redirect()->route('admin.anggota.index', ['tab' => 'admin'])
                ->with('error', 'User yang dipilih bukan admin.');
        }

        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Update data admin
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update password hanya jika diisi di form
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        // ── Proses foto ──────────────────────────────────────────
        $fotoPath = $user->foto; // default = foto lama

        // Jika admin centang "Hapus Foto"
        if ($request->has('hapus_foto')) {
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath); // hapus file fisik
            }
            $fotoPath = null; // set null di database
        }

        // Jika ada foto baru diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama dulu sebelum simpan yang baru
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('admin', 'public');
        }

        // Update foto
        $user->update(['foto' => $fotoPath]);

        return redirect()->route('admin.anggota.index', ['tab' => 'admin'])
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * destroyAdmin()
     * Hapus admin dari sistem.
     * Catatan: Tidak bisa menghapus diri sendiri.
     */
    public function destroyAdmin(User $user)
    {
        // Pastikan user yang dihapus adalah admin
        if ($user->role !== 'admin') {
            return redirect()->route('admin.anggota.index', ['tab' => 'admin'])
                ->with('error', 'User yang dipilih bukan admin.');
        }

        // Cegah admin menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.anggota.index', ['tab' => 'admin'])
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus foto dari storage jika ada
        if ($user->foto && \Storage::disk('public')->exists($user->foto)) {
            \Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('admin.anggota.index', ['tab' => 'admin'])
            ->with('success', 'Admin berhasil dihapus.');
    }

    // =========================================================
    //  PERSETUJUAN SISWA
    // =========================================================

    /**
     * pendingSiswa()
     * Tampilkan daftar siswa yang menunggu persetujuan pendaftaran.
     */
    public function pendingSiswa()
    {
        $pendingSiswa = Anggota::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $totalPending = $pendingSiswa->count();

        return view('admin.anggota.pending-siswa', compact('pendingSiswa', 'totalPending'));
    }

    /**
     * approveSiswa()
     * Setujui pendaftaran siswa — ubah status pending → aktif.
     */
    public function approveSiswa(Anggota $anggotum)
    {
        if ($anggotum->status !== 'pending') {
            return back()->with('error', 'Anggota ini tidak dalam status menunggu persetujuan.');
        }

        $anggotum->update(['status' => 'aktif']);

        return back()->with('success', '"' . $anggotum->nama . '" berhasil disetujui dan sekarang bisa login.');
    }

    /**
     * rejectSiswa()
     * Tolak pendaftaran siswa — hapus data anggota dan akun user-nya.
     */
    public function rejectSiswa(Anggota $anggotum)
    {
        if ($anggotum->status !== 'pending') {
            return back()->with('error', 'Anggota ini tidak dalam status menunggu persetujuan.');
        }

        $nama = $anggotum->nama;

        // Hapus foto jika ada
        if ($anggotum->foto && \Storage::disk('public')->exists($anggotum->foto)) {
            \Storage::disk('public')->delete($anggotum->foto);
        }

        $user = $anggotum->user;
        $anggotum->delete();
        if ($user) $user->delete();

        return back()->with('success', 'Pendaftaran "' . $nama . '" telah ditolak dan dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController
 * ──────────────────────────────────────────────────────────────
 * Mengurus semua proses autentikasi:
 *   - Tampilkan & proses form login
 *   - Tampilkan & proses form registrasi siswa baru
 *   - Logout
 *   - Redirect otomatis berdasarkan role (admin / siswa)
 * ──────────────────────────────────────────────────────────────
 */
class AuthController extends Controller
{
    // =========================================================
    //  LOGIN
    // =========================================================

    /**
     * showLogin()
     * Tampilkan halaman form login.
     * Kalau user sudah login, langsung redirect ke dashboard sesuai role.
     */
    public function showLogin()
    {
        // Kalau sudah login, tidak perlu ke halaman login lagi
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    /**
     * login()
     * Proses submit form login.
     *  1. Validasi input email & password
     *  2. Coba Auth::attempt() dengan email + password
     *  3. Kalau berhasil → regenerate session → redirect ke dashboard
     *  4. Kalau gagal → kembali ke form dengan pesan error
     */
    public function login(Request $request)
    {
        // Validasi input — pesan error dalam Bahasa Indonesia
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // Ambil hanya email & password untuk percobaan login
        $credentials = $request->only('email', 'password');

        // remember = centang "Ingat Saya" di form
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session ID untuk mencegah session fixation attack
            $request->session()->regenerate();

            // Blokir siswa yang anggotanya masih pending
            $user = Auth::user();
            if ($user->isSiswa()) {
                $anggota = $user->anggota;
                if ($anggota && $anggota->status === 'pending') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect()->route('login')
                        ->with('warning', 'Akun kamu masih menunggu persetujuan admin. Silakan coba lagi setelah disetujui.');
                }
            }

            return $this->redirectByRole();
        }

        // Login gagal → kembalikan ke form dengan error
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // =========================================================
    //  REGISTER (Siswa)
    // =========================================================

    /**
     * showRegister()
     * Tampilkan halaman form registrasi siswa baru.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * register()
     * Proses submit form registrasi siswa.
     *  1. Validasi semua input (nama, email, password, NIS, kelas, dll)
     *  2. Buat User baru dengan role 'siswa'
     *  3. Buat data Anggota yang terhubung ke User tersebut
     *  4. Login otomatis setelah registrasi berhasil
     *  5. Redirect ke dashboard siswa
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',     // email harus unik di tabel users
            'password' => 'required|min:6|confirmed',              // confirmed = harus ada field password_confirmation
            'nis'      => 'required|string|unique:anggota,nis',    // NIS harus unik di tabel anggota
            'kelas'    => 'required|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:20',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'nis.unique'   => 'NIS sudah terdaftar.',
        ]);

        // Buat akun user (untuk login)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // hash password sebelum disimpan
            'role'     => 'siswa',                        // role default saat daftar sendiri = siswa
        ]);

        // Buat data anggota perpustakaan yang terhubung ke user
        Anggota::create([
            'user_id'  => $user->id,
            'nis'      => $request->nis,
            'nama'     => $request->name,
            'kelas'    => $request->kelas,
            'alamat'   => $request->alamat,
            'telepon'  => $request->telepon,
            'status'   => 'pending', // menunggu persetujuan admin sebelum bisa login
        ]);

        // TIDAK auto-login — akun harus disetujui admin dulu
        return redirect()->route('login')
            ->with('info', 'Pendaftaran berhasil! Akun kamu sedang menunggu persetujuan admin. Kamu akan bisa login setelah disetujui.');
    }

    // =========================================================
    //  LOGOUT
    // =========================================================

    /**
     * logout()
     * Proses logout user.
     *  1. Hapus sesi Auth
     *  2. Invalidate session lama (cegah session reuse)
     *  3. Regenerate CSRF token
     *  4. Redirect ke halaman login
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();       // hapus semua data session
        $request->session()->regenerateToken();  // buat CSRF token baru
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    // =========================================================
    //  HELPER PRIVATE
    // =========================================================

    /**
     * redirectByRole()
     * Tentukan kemana user diarahkan setelah login/register,
     * berdasarkan role-nya (admin → admin.dashboard, selainnya → siswa.dashboard).
     */
    private function redirectByRole()
    {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('siswa.dashboard');
    }
}

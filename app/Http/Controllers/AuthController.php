<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ─── Login ──────────────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    // ─── Register (Siswa) ────────────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nis'      => 'required|string|unique:anggota,nis',
            'kelas'    => 'required|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:20',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'nis.unique'   => 'NIS sudah terdaftar.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        Anggota::create([
            'user_id'  => $user->id,
            'nis'      => $request->nis,
            'nama'     => $request->name,
            'kelas'    => $request->kelas,
            'alamat'   => $request->alamat,
            'telepon'  => $request->telepon,
            'status'   => 'aktif',
        ]);

        Auth::login($user);

        return redirect()->route('siswa.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // ─── Logout ─────────────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    // ─── Helper ─────────────────────────────────────────────────────────────

    private function redirectByRole()
    {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('siswa.dashboard');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with('user');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('nama', 'like', "%{$q}%")
                   ->orWhere('nis', 'like', "%{$q}%")
                   ->orWhere('kelas', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $anggota = $query->latest()->paginate(10)->withQueryString();

        return view('admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nis'      => 'required|string|unique:anggota,nis',
            'kelas'    => 'required|string|max:20',
            'alamat'   => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:20',
            'status'   => 'required|in:aktif,nonaktif',
            'foto'     => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('anggota', 'public');
        }

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

    public function edit(Anggota $anggotum)
    {
        return view('admin.anggota.edit', ['anggota' => $anggotum]);
    }

    public function update(Request $request, Anggota $anggotum)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:users,email,' . $anggotum->user_id,
            'nis'     => 'required|string|unique:anggota,nis,' . $anggotum->id,
            'kelas'   => 'required|string|max:20',
            'alamat'  => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'status'  => 'required|in:aktif,nonaktif',
            'foto'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $anggotum->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $anggotum->user->update(['password' => Hash::make($request->password)]);
        }

        // Handle foto upload
        $fotoPath = $anggotum->foto;
        
        if ($request->has('hapus_foto')) {
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = null;
        }
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($fotoPath && \Storage::disk('public')->exists($fotoPath)) {
                \Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('anggota', 'public');
        }

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

    public function destroy(Anggota $anggotum)
    {
        // Hapus foto jika ada
        if ($anggotum->foto && \Storage::disk('public')->exists($anggotum->foto)) {
            \Storage::disk('public')->delete($anggotum->foto);
        }
        
        $user = $anggotum->user;
        $anggotum->delete();
        $user->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    public function show(Anggota $anggotum)
    {
        $anggotum->load(['peminjaman.buku']);
        return view('admin.anggota.show', ['anggota' => $anggotum]);
    }
}

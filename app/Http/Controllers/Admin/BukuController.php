<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('judul', 'like', "%{$q}%")
                   ->orWhere('pengarang', 'like', "%{$q}%")
                   ->orWhere('kode_buku', 'like', "%{$q}%")
                   ->orWhere('kategori', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku      = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');

        return view('admin.buku.index', compact('buku', 'kategoris'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'    => 'required|string|unique:buku,kode_buku',
            'judul'        => 'required|string|max:200',
            'pengarang'    => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kategori'     => 'required|string|max:50',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi'    => 'nullable|string',
        ]);

        $data = $request->except('cover');

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kode_buku'    => 'required|string|unique:buku,kode_buku,' . $buku->id,
            'judul'        => 'required|string|max:200',
            'pengarang'    => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'kategori'     => 'required|string|max:50',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi'    => 'nullable|string',
        ]);

        $data = $request->except('cover');

        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function show(Buku $buku)
    {
        return view('admin.buku.show', compact('buku'));
    }
}

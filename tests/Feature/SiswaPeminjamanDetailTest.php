<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaPeminjamanDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_can_view_book_detail_page_with_recommendations(): void
    {
        $user = User::factory()->create([
            'role' => 'siswa',
        ]);

        Anggota::create([
            'user_id' => $user->id,
            'nis' => 'SIS-001',
            'nama' => 'Siswa Test',
            'kelas' => 'XII IPA 1',
            'alamat' => 'Jl. Test',
            'telepon' => '08123456789',
            'status' => 'aktif',
        ]);

        $book = Buku::create([
            'kode_buku' => 'BK-DETAIL-001',
            'judul' => 'Detail Buku Test',
            'pengarang' => 'Penulis Test',
            'penerbit' => 'Penerbit Test',
            'tahun_terbit' => 2024,
            'kategori' => 'Fiksi',
            'stok' => 4,
            'deskripsi' => 'Deskripsi buku testing detail page.',
        ]);

        Buku::create([
            'kode_buku' => 'BK-DETAIL-002',
            'judul' => 'Rekomendasi 1',
            'pengarang' => 'Penulis Lain',
            'penerbit' => 'Penerbit Lain',
            'tahun_terbit' => 2025,
            'kategori' => 'Fiksi',
            'stok' => 2,
            'deskripsi' => 'Buku rekomendasi untuk siswa.',
        ]);

        $response = $this->actingAs($user)->get('/siswa/peminjaman/pinjam/' . $book->id);

        $response->assertOk();
        $response->assertSee('Detail Buku');
        $response->assertSee($book->judul);
        $response->assertSee('Rekomendasi untukmu');
    }
}

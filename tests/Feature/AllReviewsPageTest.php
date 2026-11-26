<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllReviewsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_reviews_page_includes_ratings_without_comments(): void
    {
        $anggota = Anggota::create([
            'user_id' => User::factory()->create()->id,
            'nis' => 'S-1001',
            'nama' => 'Siswa Tanpa Komentar',
            'kelas' => '7A',
        ]);
        $buku = Buku::create([
            'kode_buku' => 'BK-1001',
            'judul' => 'Buku Uji Ulasan',
            'pengarang' => 'Penulis Uji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => 2025,
            'kategori' => 'Fiksi',
            'stok' => 1,
        ]);
        $peminjaman = Peminjaman::create([
            'kode_pinjam' => 'PJ-1001',
            'anggota_id' => $anggota->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali_rencana' => now()->addWeek()->toDateString(),
            'status' => 'dikembalikan',
        ]);

        Ulasan::create([
            'peminjaman_id' => $peminjaman->id,
            'buku_id' => $buku->id,
            'anggota_id' => $anggota->id,
            'rating' => 5,
            'komentar' => null,
        ]);

        $response = $this->get('/ulasan');

        $response->assertOk();
        $response->assertSee('Siswa Tanpa Komentar');
        $response->assertSee('Memberi rating tanpa komentar');
        $response->assertSee('Buku Uji Ulasan');
    }
}
<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaPengembalianWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_request_is_visible_to_admin_and_fine_payment_can_be_completed(): void
    {
        $this->travelTo(Carbon::parse('2026-10-19 09:00:00'));

        $student = User::factory()->create(['role' => 'siswa']);
        $anggota = Anggota::create([
            'user_id' => $student->id,
            'nis' => 'SIS-RET-001',
            'nama' => 'Siswa Pengembalian',
            'kelas' => 'XII IPA 1',
            'status' => 'aktif',
        ]);
        $admin = User::factory()->create(['role' => 'admin']);
        $book = Buku::create([
            'kode_buku' => 'BK-RET-001',
            'judul' => 'Buku Pengembalian',
            'pengarang' => 'Penulis Test',
            'penerbit' => 'Penerbit Test',
            'tahun_terbit' => 2024,
            'kategori' => 'Fiksi',
            'stok' => 3,
            'deskripsi' => 'Buku untuk tes alur pengembalian.',
        ]);
        $peminjaman = Peminjaman::create([
            'kode_pinjam' => 'TRX-RET-001',
            'anggota_id' => $anggota->id,
            'buku_id' => $book->id,
            'tanggal_pinjam' => '2026-10-01',
            'tanggal_kembali_rencana' => '2026-10-16',
            'status' => Peminjaman::STATUS_DIPINJAM,
        ]);

        $this->actingAs($student)
            ->post(route('siswa.pengembalian.proses', $peminjaman))
            ->assertRedirect(route('siswa.pengembalian.index'));

        $peminjaman->refresh();
        $this->assertSame(Peminjaman::STATUS_PENDING_KEMBALI, $peminjaman->status);
        $this->assertNotNull($peminjaman->return_requested_at);
        $this->assertSame(3, $book->fresh()->stok);

        $this->actingAs($admin)
            ->get(route('admin.transaksi.index'))
            ->assertOk()
            ->assertSee('Riwayat Transaksi')
            ->assertSee($book->judul)
            ->assertDontSee('Selesaikan Pembayaran');

        $this->get(route('admin.transaksi.index', ['page' => 2]))
            ->assertRedirect(route('admin.transaksi.index', ['page' => 1]));

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Pengembalian Menunggu Persetujuan')
            ->assertSee('Siswa Pengembalian')
            ->assertSee('Konfirmasi');

        $this->travelTo(Carbon::parse('2026-10-22 13:00:00'));
        $this->post(route('admin.transaksi.approve-kembali', $peminjaman))
            ->assertRedirect();

        $peminjaman->refresh();
        $this->assertSame(Peminjaman::STATUS_DIKEMBALIKAN, $peminjaman->status);
        $this->assertSame('2026-10-19', $peminjaman->tanggal_kembali_aktual->toDateString());
        $this->assertSame(3000, $peminjaman->denda);
        $this->assertFalse($peminjaman->denda_dibayar);
        $this->assertSame(4, $book->fresh()->stok);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Denda Belum Lunas')
            ->assertSee('Selesaikan Pembayaran');

        $this->post(route('admin.transaksi.denda.lunas', $peminjaman))
            ->assertRedirect();

        $peminjaman->refresh();
        $this->assertTrue($peminjaman->denda_dibayar);
        $this->assertNotNull($peminjaman->denda_dibayar_at);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel peminjaman (struktur awal)
 * ──────────────────────────────────────────────────────
 * Menyimpan setiap transaksi peminjaman buku.
 * Ini migration AWAL — hanya 3 status: dipinjam, dikembalikan, terlambat.
 *
 * PERUBAHAN STATUS di migration berikutnya:
 *   2026_10_07_000001 → kolom status diubah ke VARCHAR(20)
 *                        dan ditambah: pending, ditolak
 *                        + kolom: tanggal_pengajuan, approved_at, rejected_at, rejection_reason
 *   2026_10_07_000002 → tanggal_pinjam & tanggal_kembali_rencana dibuat nullable
 *                        (karena peminjaman pending belum punya tanggal)
 *   2026_10_07_000003 → tambah kolom return_requested_at
 *                        + status pending_kembali mulai bisa dipakai
 *
 * KOLOM PENTING:
 *   kode_pinjam            → ID unik transaksi, format TRX-XXXXXXXX
 *   tanggal_pinjam         → diisi saat admin approve (awalnya NOT NULL, lalu nullable)
 *   tanggal_kembali_rencana → batas waktu kembali (awalnya NOT NULL, lalu nullable)
 *   tanggal_kembali_aktual  → diisi saat admin konfirmasi pengembalian
 *   denda                   → rupiah, dihitung Rp 1.000/hari keterlambatan
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pinjam')->unique();  // format: TRX-XXXXXXXX
            $table->foreignId('anggota_id')
                  ->constrained('anggota')
                  ->onDelete('cascade');
            $table->foreignId('buku_id')
                  ->constrained('buku')
                  ->onDelete('cascade');
            $table->date('tanggal_pinjam');           // akan dibuat nullable di migration 2026_10_07_000002
            $table->date('tanggal_kembali_rencana');  // akan dibuat nullable di migration 2026_10_07_000002
            $table->date('tanggal_kembali_aktual')->nullable(); // diisi saat buku dikembalikan
            // Status awal hanya 3 — akan diubah ke VARCHAR di migration 2026_10_07_000001
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->integer('denda')->default(0);     // dalam rupiah
            $table->text('keterangan')->nullable();   // catatan admin opsional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};

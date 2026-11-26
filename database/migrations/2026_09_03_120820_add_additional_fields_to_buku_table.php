<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tambah kolom tambahan ke tabel buku
 * ──────────────────────────────────────────────────────
 * Kolom-kolom ini ditambahkan untuk fitur lanjutan:
 *
 *   isbn           → nomor ISBN buku (opsional, untuk referensi)
 *   rating         → cache rata-rata rating dari tabel ulasan
 *                    (disimpan di sini agar tidak perlu join setiap saat)
 *   is_featured    → tandai buku pilihan untuk tampil di section khusus
 *   returned_at    → timestamp terakhir kali buku ini dikembalikan
 *                    (untuk section "Baru Kembali" di landing page)
 *   waitlist_count → jumlah siswa yang antre saat stok = 0
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('isbn')->nullable()->after('kode_buku');         // setelah kode_buku
            $table->decimal('rating', 2, 1)->default(0)->after('deskripsi'); // max 9.9 bintang
            $table->boolean('is_featured')->default(false)->after('rating');
            $table->timestamp('returned_at')->nullable()->after('is_featured');
            $table->integer('waitlist_count')->default(0)->after('returned_at');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'rating', 'is_featured', 'returned_at', 'waitlist_count']);
        });
    }
};

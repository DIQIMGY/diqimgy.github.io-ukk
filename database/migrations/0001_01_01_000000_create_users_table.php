<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Tabel users, password_reset_tokens, sessions
 * ──────────────────────────────────────────────────────
 * Ini migration pertama — dibuat otomatis oleh Laravel.
 * Tiga tabel sekaligus karena semuanya berkaitan dengan autentikasi.
 *
 * TABEL users:
 *   Menyimpan akun login semua pengguna (admin + siswa).
 *   Kolom 'role' membedakan admin dan siswa.
 *
 * TABEL password_reset_tokens:
 *   Untuk fitur "lupa password" (belum dipakai, tapi disiapkan).
 *
 * TABEL sessions:
 *   Menyimpan session login di database (bukan file/cookie).
 *   Dikonfigurasi di config/session.php: SESSION_DRIVER=database.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── Tabel utama akun login ──────────────────────────────
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                    // nama tampil
            $table->string('email')->unique();                         // login identifier
            $table->timestamp('email_verified_at')->nullable();        // untuk fitur verifikasi email
            $table->string('password');                                // bcrypt hash
            $table->enum('role', ['admin', 'siswa'])->default('siswa'); // role akses
            $table->rememberToken();                                   // untuk fitur "ingat saya"
            $table->timestamps();
        });

        // ── Token reset password ────────────────────────────────
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();   // email sebagai primary key
            $table->string('token');               // token unik reset
            $table->timestamp('created_at')->nullable();
        });

        // ── Session database ────────────────────────────────────
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();          // session ID
            $table->foreignId('user_id')->nullable()->index(); // null = guest
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');              // data session ter-serialize
            $table->integer('last_activity')->index(); // untuk garbage collection
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

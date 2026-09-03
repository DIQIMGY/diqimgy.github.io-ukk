<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding database...');
        
        // ─── Admin ────────────────────────────────────────────────────────
        $this->command->info('👤 Membuat user admin...');
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@perpus.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // ─── Siswa ────────────────────────────────────────────────────────
        $this->command->info('👥 Membuat user siswa & anggota...');
        $siswa1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@siswa.sch.id',
            'password' => Hash::make('siswa123'),
            'role'     => 'siswa',
        ]);
        Anggota::create([
            'user_id' => $siswa1->id,
            'nis'     => '2024001',
            'nama'    => 'Budi Santoso',
            'kelas'   => 'XI-RPL-1',
            'telepon' => '081234567890',
            'status'  => 'aktif',
        ]);

        $siswa2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@siswa.sch.id',
            'password' => Hash::make('siswa123'),
            'role'     => 'siswa',
        ]);
        Anggota::create([
            'user_id' => $siswa2->id,
            'nis'     => '2024002',
            'nama'    => 'Siti Rahayu',
            'kelas'   => 'XI-RPL-2',
            'telepon' => '082345678901',
            'status'  => 'aktif',
        ]);

        // ─── Buku dengan Data REAL ────────────────────────────────────────
        $this->command->info('📚 Menjalankan BukuSeeder...');
        $this->call(BukuSeeder::class);

        // ─── Peminjaman ───────────────────────────────────────────────────
        $this->command->info('📋 Menjalankan PeminjamanSeeder...');
        $this->call(PeminjamanSeeder::class);
        
        $this->command->info('');
        $this->command->info('✨ Seeding selesai!');
        $this->command->line('');
        $this->command->line('Login credentials:');
        $this->command->line('Admin  → admin@perpus.sch.id / admin123');
        $this->command->line('Siswa1 → budi@siswa.sch.id / siswa123');
        $this->command->line('Siswa2 → siti@siswa.sch.id / siswa123');
    }
}

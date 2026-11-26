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
        
        // ─── Admin (LKPD: username=admin, password=password) ──────────────
        $this->command->info('👤 Membuat user admin...');
        User::firstOrCreate(
            ['email' => 'admin@perpus.sch.id'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@perpus.sch.id',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // ─── Siswa (LKPD: username=siswa, password=password) ─────────────
        $this->command->info('👥 Membuat user siswa & anggota...');
        $siswa1 = User::firstOrCreate(
            ['email' => 'siswa@perpus.sch.id'],
            [
                'name'     => 'Budi Santoso',
                'email'    => 'siswa@perpus.sch.id',
                'password' => Hash::make('password'),
                'role'     => 'siswa',
            ]
        );
        if (!$siswa1->anggota) {
            Anggota::create([
                'user_id' => $siswa1->id,
                'nis'     => '2024001',
                'nama'    => 'Budi Santoso',
                'kelas'   => 'XI-RPL-1',
                'telepon' => '081234567890',
                'status'  => 'aktif',
            ]);
        }

        $siswa2 = User::firstOrCreate(
            ['email' => 'budi@siswa.sch.id'],
            [
                'name'     => 'Siti Rahayu',
                'email'    => 'budi@siswa.sch.id',
                'password' => Hash::make('password'),
                'role'     => 'siswa',
            ]
        );
        if (!$siswa2->anggota) {
            Anggota::create([
                'user_id' => $siswa2->id,
                'nis'     => '2024002',
                'nama'    => 'Siti Rahayu',
                'kelas'   => 'XI-RPL-2',
                'telepon' => '082345678901',
                'status'  => 'aktif',
            ]);
        }

        // ─── Buku dengan Data REAL ────────────────────────────────────────
        $this->command->info('📚 Menjalankan BukuSeeder...');
        $this->call(BukuSeeder::class);

        // ─── Series Buku ──────────────────────────────────────────────────
        $this->command->info('📖 Menjalankan SeriesSeeder...');
        $this->call(SeriesSeeder::class);

        // ─── Peminjaman ───────────────────────────────────────────────────
        $this->command->info('📋 Menjalankan PeminjamanSeeder...');
        $this->call(PeminjamanSeeder::class);
        
        $this->command->info('');
        $this->command->info('✨ Seeding selesai!');
        $this->command->line('');
        $this->command->line('╔══════════════════════════════════════════╗');
        $this->command->line('║         LOGIN CREDENTIALS (LKPD)         ║');
        $this->command->line('╠══════════════════════════════════════════╣');
        $this->command->line('║ Admin  → admin@perpus.sch.id / password  ║');
        $this->command->line('║ Siswa  → siswa@perpus.sch.id / password  ║');
        $this->command->line('╚══════════════════════════════════════════╝');
    }
}

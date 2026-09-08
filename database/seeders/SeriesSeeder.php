<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Series;
use App\Models\SeriesBuku;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    public function run(): void
    {
        // ── Buat 17 buku series Bumi ──────────────────────────────────────
        $daftarBuku = [
            ['kode'=>'SR001','judul'=>'Bumi',            'tahun'=>2014,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/20610389.jpg'],
            ['kode'=>'SR002','judul'=>'Bulan',           'tahun'=>2015,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1442753901i/26228765.jpg'],
            ['kode'=>'SR003','judul'=>'Matahari',        'tahun'=>2016,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1472754444i/31934842.jpg'],
            ['kode'=>'SR004','judul'=>'Bintang',         'tahun'=>2017,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1513004566i/37554186.jpg'],
            ['kode'=>'SR005','judul'=>'Ceros dan Batozar','tahun'=>2018,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1543054374i/42972960.jpg'],
            ['kode'=>'SR006','judul'=>'Komet',           'tahun'=>2018,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1543054374i/42972960.jpg'],
            ['kode'=>'SR007','judul'=>'Komet Minor',     'tahun'=>2019,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1571299374i/48245453.jpg'],
            ['kode'=>'SR008','judul'=>'Selena',          'tahun'=>2020,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1589893832i/53154349.jpg'],
            ['kode'=>'SR009','judul'=>'Nebula',          'tahun'=>2021,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR010','judul'=>'Si Putih',        'tahun'=>2021,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR011','judul'=>'Lumpu',           'tahun'=>2022,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR012','judul'=>'Bibi Gill',       'tahun'=>2022,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR013','judul'=>'SagaraS',         'tahun'=>2023,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR014','judul'=>'Matahari Minor',  'tahun'=>2023,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR015','judul'=>'ILY',             'tahun'=>2024,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR016','judul'=>'Aldebaran',       'tahun'=>2024,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
            ['kode'=>'SR017','judul'=>'Hana-Tara-Hata',  'tahun'=>2025,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1628566990i/58436753.jpg'],
        ];

        $bukuIds = [];
        foreach ($daftarBuku as $i => $d) {
            $buku = Buku::create([
                'kode_buku'        => $d['kode'],
                'isbn'             => null,
                'judul'            => $d['judul'],
                'pengarang'        => 'Tere Liye',
                'penerbit'         => 'Gramedia Pustaka Utama',
                'tahun_terbit'     => $d['tahun'],
                'kategori'         => 'Fiksi Petualangan',
                'stok'             => rand(2, 6),
                'cover'            => $d['cover'],
                'deskripsi'        => 'Bagian dari series Bumi karya Tere Liye — kisah petualangan Raib, Seli, dan Ali di dunia paralel yang menakjubkan.',
                'rating'           => round(4.2 + ($i % 3) * 0.1, 1),
                'is_featured'      => $i === 0,
                'waitlist_count'   => 0,
                'status_launching' => 'tersedia',
                'tanggal_rilis'    => null,
            ]);
            $bukuIds[] = $buku->id;
        }

        // ── Buat Series "Bumi" ────────────────────────────────────────────
        $series = Series::create([
            'nama_series'  => 'Bumi Series',
            'penulis'      => 'Tere Liye',
            'slug'         => 'bumi-series',
            'cover_series' => $daftarBuku[0]['cover'],
            'deskripsi'    => 'Serial fiksi ilmiah petualangan karya Tere Liye yang mengisahkan tiga remaja — Raib, Seli, dan Ali — yang memiliki kekuatan tersembunyi dan menjelajahi dunia-dunia paralel. Salah satu seri terlaris di Indonesia dengan total 17 buku.',
        ]);

        // ── Hubungkan buku ke series (17 buku, urutan 1-17) ───────────────
        foreach ($bukuIds as $idx => $bukuId) {
            SeriesBuku::create([
                'series_id'     => $series->id,
                'buku_id'       => $bukuId,
                'urutan_baca'   => $idx + 1,
                'urutan_terbit' => $idx + 1,
                'is_penutup'    => ($idx === 16), // buku ke-17 = Hana-Tara-Hata
            ]);
        }

        $this->command->info('📚 Series "Bumi" (17 buku) berhasil ditambahkan!');
    }
}

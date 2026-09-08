<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Series;
use App\Models\SeriesBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeriesTambahanSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📚 Menambahkan 5 series baru...');

        // ══════════════════════════════════════════════════════════════
        // 1. TETRALOGI LASKAR PELANGI – Andrea Hirata
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Laskar Pelangi Series (4 buku)');
        $laskarBuku = [
            [
                'kode'   => 'LP001',
                'judul'  => 'Laskar Pelangi',
                'tahun'  => 2005,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/1362193.jpg',
                'sinopsis' => 'Mengisahkan perjuangan 10 anak (Laskar Pelangi) dan dua guru hebat di sekolah Muhammadiyah Belitung yang reyot. Penuh kebersamaan, kemiskinan, dan keajaiban tekad.',
            ],
            [
                'kode'   => 'LP002',
                'judul'  => 'Sang Pemimpi',
                'tahun'  => 2006,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/1362195.jpg',
                'sinopsis' => 'Ikal, Arai, dan Jimbron merantau ke Manggar untuk SMA. Hidup mandiri dan berani memimpikan kuliah di Sorbonne, Prancis.',
            ],
            [
                'kode'   => 'LP003',
                'judul'  => 'Edensor',
                'tahun'  => 2007,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/1362196.jpg',
                'sinopsis' => 'Mimpi terwujud. Ikal dan Arai kuliah di Eropa dan berpetualangan menjelajahi Eropa hingga Afrika demi menemukan jati diri.',
            ],
            [
                'kode'   => 'LP004',
                'judul'  => 'Maryamah Karpov',
                'tahun'  => 2008,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/3744753.jpg',
                'sinopsis' => 'Ikal pulang ke Belitung setelah studi. Berjuang membantu Maryamah dan mencari cinta pertamanya, A Ling.',
            ],
        ];
        $this->buatSeries(
            nama: 'Laskar Pelangi Series',
            penulis: 'Andrea Hirata',
            deskripsi: 'Tetralogi semi-otobiografi yang mengikuti perjalanan Ikal dari masa kecil penuh keterbatasan di Belitung hingga kuliah di Eropa. Salah satu novel Indonesia paling berpengaruh sepanjang masa.',
            daftarBuku: $laskarBuku
        );

        // ══════════════════════════════════════════════════════════════
        // 2. TRILOGI NEGERI 5 MENARA – A. Fuadi
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Negeri 5 Menara Series (3 buku)');
        $negeriBuku = [
            [
                'kode'   => 'N5M001',
                'judul'  => 'Negeri 5 Menara',
                'tahun'  => 2009,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/6771898.jpg',
                'sinopsis' => 'Alif masuk Pondok Madani di Jawa Timur. Bersama Sahibul Menara, mereka memimpikan dunia dengan mantra "Man jadda wajada".',
            ],
            [
                'kode'   => 'N5M002',
                'judul'  => 'Ranah 3 Warna',
                'tahun'  => 2011,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/10558223.jpg',
                'sinopsis' => 'Alif berjuang masuk universitas negeri dan meraih beasiswa pertukaran pelajar ke Kanada. Mantra: "Man shabara zhafira".',
            ],
            [
                'kode'   => 'N5M003',
                'judul'  => 'Rantau 1 Muara',
                'tahun'  => 2013,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/17333350.jpg',
                'sinopsis' => 'Alif merantau ke New York sebagai wartawan. Mencari tempat melabuhkan hidup, karier, dan cinta. Mantra: "Man saara ala darbi washala".',
            ],
        ];
        $this->buatSeries(
            nama: 'Negeri 5 Menara Series',
            penulis: 'A. Fuadi',
            deskripsi: 'Trilogi inspiratif terinspirasi pengalaman nyata penulis di Pondok Modern Gontor. Fokus pada filosofi kerja keras dan kekuatan merantau untuk mengejar cita-cita.',
            daftarBuku: $negeriBuku
        );

        // ══════════════════════════════════════════════════════════════
        // 3. DUOLOGI ORANG-ORANG BIASA – Andrea Hirata
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Orang-Orang Biasa Series (2 buku)');
        $orangBuku = [
            [
                'kode'   => 'OOB001',
                'judul'  => 'Orang-Orang Biasa',
                'tahun'  => 2019,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1553615938i/44525432.jpg',
                'sinopsis' => 'Sekelompok orang miskin yang jujur di kota kecil merencanakan "perampokan" demi membiayai kuliah anak genius matematika. Komedi satir penuh kehangatan.',
            ],
            [
                'kode'   => 'OOB002',
                'judul'  => 'Guru Aini',
                'tahun'  => 2020,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1581000000i/50202929.jpg',
                'sinopsis' => 'Prekuel Orang-Orang Biasa. Kisah Bu Desi, guru matematika yang mencari murid jenius matematika bernama Aini di pelosok Sumatra.',
            ],
        ];
        $this->buatSeries(
            nama: 'Orang-Orang Biasa Series',
            penulis: 'Andrea Hirata',
            deskripsi: 'Duologi Andrea Hirata tentang perjuangan pendidikan yang dibalut komedi satir dan kehangatan. Lebih pendek dari Laskar Pelangi tapi sama menyentuhnya.',
            daftarBuku: $orangBuku
        );

        // ══════════════════════════════════════════════════════════════
        // 4. TRILOGI RAPIJALI – Dee Lestari
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Rapijali Series (3 buku)');
        $rapilajiBuku = [
            [
                'kode'   => 'RPJ001',
                'judul'  => 'Rapijali 1: Mencari',
                'tahun'  => 2021,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1621000000i/57901234.jpg',
                'sinopsis' => 'Ping, remaja genius musik dari pinggir Sungai Ciliwung, harus pindah ke Jakarta dan menghadapi konflik keluarga, persahabatan baru, dan kompetisi band remaja.',
            ],
            [
                'kode'   => 'RPJ002',
                'judul'  => 'Rapijali 2: Menjadi',
                'tahun'  => 2021,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1630000000i/58901234.jpg',
                'sinopsis' => 'Perjalanan Ping semakin dalam di dunia musik Jakarta. Ia mulai menemukan siapa dirinya di tengah tekanan politik dan persahabatan yang rumit.',
            ],
            [
                'kode'   => 'RPJ003',
                'judul'  => 'Rapijali 3: Kembali',
                'tahun'  => 2022,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1640000000i/59901234.jpg',
                'sinopsis' => 'Penyelesaian perjalanan Ping menemukan rumahnya — dalam musik, keluarga, dan cintanya.',
            ],
        ];
        $this->buatSeries(
            nama: 'Rapijali Series',
            penulis: 'Dee Lestari',
            deskripsi: 'Trilogi remaja dari Dee Lestari yang ringan, segar, dan berfokus pada dunia musik. Berbeda dari Supernova yang berat, Rapijali cocok untuk semua kalangan.',
            daftarBuku: $rapilajiBuku
        );

        // ══════════════════════════════════════════════════════════════
        // 5. DUOLOGI LEILA S. CHUDORI – Leila S. Chudori
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Leila S. Chudori Series (2 buku)');
        $leilaBuku = [
            [
                'kode'   => 'LSC001',
                'judul'  => 'Pulang',
                'tahun'  => 2012,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/15840593.jpg',
                'sinopsis' => 'Kisah para aktivis Indonesia yang terjebak di Paris saat tragedi 1965. Mereka hidup di pengasingan sambil merindukan tanah air yang tak bisa diinjak kembali.',
            ],
            [
                'kode'   => 'LSC002',
                'judul'  => 'Laut Bercerita',
                'tahun'  => 2017,
                'cover'  => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1503000000i/35422618.jpg',
                'sinopsis' => 'Laut, mahasiswa aktivis, diculik dan dieksekusi oleh rezim Orde Baru tahun 1998. Diceritakan melalui dua sudut pandang: Laut dari alam baka dan adiknya yang mencari kebenaran.',
            ],
        ];
        $this->buatSeries(
            nama: 'Leila S. Chudori Series',
            penulis: 'Leila S. Chudori',
            deskripsi: 'Dua novel sejarah paling berpengaruh karya Leila S. Chudori. Keduanya berdiri sendiri namun sering dibaca bersama karena sama-sama mengangkat tema perjuangan aktivis Indonesia.',
            daftarBuku: $leilaBuku
        );

        $this->command->info('✅ 5 series berhasil ditambahkan ke database!');
    }

    // ── Helper: buat series + buku sekaligus ──────────────────────────────
    private function buatSeries(string $nama, string $penulis, string $deskripsi, array $daftarBuku): void
    {
        // Buat buku-buku
        $bukuIds = [];
        foreach ($daftarBuku as $i => $d) {
            // Skip jika kode sudah ada (idempotent)
            $buku = Buku::firstOrCreate(
                ['kode_buku' => $d['kode']],
                [
                    'judul'            => $d['judul'],
                    'pengarang'        => $penulis,
                    'penerbit'         => 'Gramedia Pustaka Utama',
                    'tahun_terbit'     => $d['tahun'],
                    'kategori'         => 'Fiksi',
                    'stok'             => rand(2, 5),
                    'cover'            => $d['cover'],
                    'deskripsi'        => $d['sinopsis'],
                    'status_launching' => 'tersedia',
                ]
            );
            $bukuIds[] = $buku->id;
        }

        // Buat series (skip jika sudah ada)
        $series = Series::firstOrCreate(
            ['slug' => Str::slug($nama)],
            [
                'nama_series' => $nama,
                'penulis'     => $penulis,
                'deskripsi'   => $deskripsi,
                'slug'        => Str::slug($nama),
                'cover_series'=> $daftarBuku[0]['cover'],
            ]
        );

        // Hubungkan buku ke series (skip jika sudah terhubung)
        foreach ($bukuIds as $idx => $bukuId) {
            SeriesBuku::firstOrCreate(
                ['series_id' => $series->id, 'buku_id' => $bukuId],
                [
                    'urutan_baca'   => $idx + 1,
                    'urutan_terbit' => $idx + 1,
                    'is_penutup'    => ($idx === count($bukuIds) - 1),
                ]
            );
        }
    }
}

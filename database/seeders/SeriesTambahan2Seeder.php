<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Series;
use App\Models\SeriesBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeriesTambahan2Seeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📚 Menambahkan 4 series baru...');

        // ══════════════════════════════════════════════════════════════
        // 1. THE RANGER'S APPRENTICE – John Flanagan (11 buku)
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → The Ranger\'s Apprentice (11 buku)');
        $this->buatSeries(
            nama: 'The Ranger\'s Apprentice Series',
            penulis: 'John Flanagan',
            deskripsi: 'Serial fantasi abad pertengahan yang mengikuti petualangan Will, seorang yatim piatu yang menjadi murid seorang Ranger misterius. Penuh aksi, persahabatan, dan keberanian melawan kejahatan di dunia fiksi Araluen.',
            kategori: 'Fantasi',
            penerbit: 'Gramedia Pustaka Utama',
            coverBase: 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/',
            daftarBuku: [
                ['kode'=>'RA001','judul'=>'Reruntuhan Gorlan','tahun'=>2006,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/60700.jpg','sinopsis'=>'Will, seorang anak yatim, ditolak masuk sekolah ksatria. Ia malah terpilih menjadi murid Halt, seorang Ranger misterius yang ditakuti semua orang. Petualangan pertama Will dimulai saat ancaman Morgarath mengancam kerajaan.'],
                ['kode'=>'RA002','judul'=>'Jembatan yang Terbakar','tahun'=>2006,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/60697.jpg','sinopsis'=>'Will dan Horace bergabung dalam misi militer ke kerajaan tetangga. Mereka harus menghancurkan jembatan strategis sebelum musuh menggunakannya untuk menyerang.'],
                ['kode'=>'RA003','judul'=>'Tanah yang Tertutup Es','tahun'=>2007,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/60698.jpg','sinopsis'=>'Will dan Evanlyn ditangkap dan dibawa ke utara jauh sebagai budak. Di negeri dingin Skandia, mereka harus bertahan hidup sambil mencari jalan pulang.'],
                ['kode'=>'RA004','judul'=>'Pertempuran untuk Skandia','tahun'=>2007,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/60699.jpg','sinopsis'=>'Will dan kawan-kawan bergabung dengan pasukan Skandia untuk melawan invasi Temujai. Persekutuan tak terduga terbentuk demi bertahan hidup.'],
                ['kode'=>'RA005','judul'=>'Penyihir dari Utara','tahun'=>2008,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/1757286.jpg','sinopsis'=>'Will kini Ranger muda yang bertugas sendiri di distrik terpencil. Ia menemukan konspirasi gelap yang melibatkan seorang "penyihir" yang menebar ketakutan.'],
                ['kode'=>'RA006','judul'=>'Pengepungan Macindaw','tahun'=>2008,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/1757287.jpg','sinopsis'=>'Horace datang membantu Will menyelidiki Kastil Macindaw yang dikuasai pengkhianat. Mereka harus merebut kembali kastil sebelum musuh dari utara tiba.'],
                ['kode'=>'RA007','judul'=>'Tebusan Erak','tahun'=>2010,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/3332588.jpg','sinopsis'=>'Prequel seru: Halt dan Will pergi ke gurun Arrida untuk menyelamatkan Erak, kepala Skandia, yang ditangkap bandit gurun dan diminta tebusan besar.'],
                ['kode'=>'RA008','judul'=>'Raja-Raja Clonmel','tahun'=>2010,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/5765885.jpg','sinopsis'=>'Halt harus menghadapi masa lalunya di tanah kelahirannya, Clonmel. Seorang nabi palsu menghasut rakyat, dan hanya Halt yang tahu kebenaran di baliknya.'],
                ['kode'=>'RA009','judul'=>'Bahaya Halt','tahun'=>2010,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/6563503.jpg','sinopsis'=>'Halt terkena panah beracun saat mengejar anggota kultus berbahaya. Will berjuang melawan waktu mencari penawar racun sebelum sahabatnya gugur.'],
                ['kode'=>'RA010','judul'=>'Kaisar Nihon-Ja','tahun'=>2011,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/8665421.jpg','sinopsis'=>'Horace terjebak di negeri jauh Nihon-Ja dan harus membantu kaisar yang diserang pemberontak. Sementara Will dan Alyss berlomba waktu untuk menyelamatkannya.'],
                ['kode'=>'RA011','judul'=>'Kisah-Kisah yang Hilang','tahun'=>2011,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/11250898.jpg','sinopsis'=>'Kumpulan 12 kisah pendek yang mengisi celah antara novel-novel utama. Kisah-kisah yang selama ini tidak pernah diceritakan tentang Will, Halt, Horace, dan kawan-kawan.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 2. THE CHRONICLES OF AUDY – Orizuka (8 buku)
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → The Chronicles of Audy (8 buku)');
        $this->buatSeries(
            nama: 'The Chronicles of Audy Series',
            penulis: 'Orizuka',
            deskripsi: 'Serial lokal bertema keluarga dan romansa remaja yang hangat dan menghibur. Mengisahkan kehidupan keluarga besar 4R bersaudara dan dunia sekitar mereka yang penuh warna.',
            kategori: 'Romance',
            penerbit: 'Gramedia Pustaka Utama',
            coverBase: '',
            daftarBuku: [
                ['kode'=>'AUDY001','judul'=>'The Chronicles of Audy: 4R','tahun'=>2011,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/13610205.jpg','sinopsis'=>'Audy, gadis tomboi yang canggung, tiba-tiba harus tinggal bersama 4 kakak tiri yang semuanya tampan dan populer. Awal mula kekacauan dan kehangatan keluarga barunya.'],
                ['kode'=>'AUDY002','judul'=>'The Chronicles of Audy: 21','tahun'=>2012,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/15797892.jpg','sinopsis'=>'Audy kini berusia 21 tahun. Ia harus menghadapi dunia dewasa, cinta yang lebih rumit, dan hubungannya dengan keempat kakak tirinya yang semakin kompleks.'],
                ['kode'=>'AUDY003','judul'=>'The Chronicles of Audy: 4/4','tahun'=>2013,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/18667652.jpg','sinopsis'=>'Kisah terus berkembang: konflik keluarga memuncak saat rahasia masa lalu ayah mereka terungkap. Audy harus menjadi jembatan penghubung antar saudara-saudaranya.'],
                ['kode'=>'AUDY004','judul'=>'The Chronicles of Audy: O2','tahun'=>2014,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/22609168.jpg','sinopsis'=>'Penyelesaian tetralogi utama. Semua benang cerita terjalin menjadi satu ending yang manis dan mengharukan untuk keluarga besar 4R.'],
                ['kode'=>'AUDY005','judul'=>'Rex','tahun'=>2015,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/25654321.jpg','sinopsis'=>'Spin-off fokus ke Rex, si anak genius di antara saudara-saudaranya. Kisah masa lalunya yang tersembunyi dan bagaimana ia menjadi seperti sekarang.'],
                ['kode'=>'AUDY006','judul'=>'Regan','tahun'=>2016,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/30123456.jpg','sinopsis'=>'Sudut pandang Regan, kakak tertua yang selalu tampil sempurna. Di balik citra sempurnanya, tersimpan perjuangan dan luka yang tak pernah ia tunjukkan.'],
                ['kode'=>'AUDY007','judul'=>'Romeo','tahun'=>2017,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/34567890.jpg','sinopsis'=>'Romeo si playboy keluarga akhirnya mendapat giliran bercerita. Kisah cintanya yang sebenarnya jauh lebih dalam dari yang terlihat dari luar.'],
                ['kode'=>'AUDY008','judul'=>'Rafael','tahun'=>2018,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/38901234.jpg','sinopsis'=>'Si bungsu Rafael tumbuh dewasa. Petualangan dan pencarian jati dirinya sebagai anggota termuda keluarga 4R yang penuh tokoh-tokoh kuat.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 3. HAKIM DEE – Robert van Gulik (9 buku)
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Hakim Dee Series (9 buku)');
        $this->buatSeries(
            nama: 'Hakim Dee Series',
            penulis: 'Robert van Gulik',
            deskripsi: 'Serial detektif klasik berlatar Tiongkok kuno Dinasti Tang. Hakim Dee, hakim genius yang terinspirasi tokoh nyata Di Renjie, memecahkan tiga kasus kriminal sekaligus dalam setiap buku.',
            kategori: 'Misteri',
            penerbit: 'Gramedia Pustaka Utama',
            coverBase: '',
            daftarBuku: [
                ['kode'=>'HD001','judul'=>'Pembunuhan di Labirin Cina','tahun'=>1998,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416349.jpg','sinopsis'=>'Hakim Dee menyelidiki tiga kasus misterius di sebuah kota terpencil: kematian seorang pedagang kaya, seorang wanita yang menghilang, dan teror di labirin kuno.'],
                ['kode'=>'HD002','judul'=>'Mutiara Kaisar','tahun'=>1998,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416350.jpg','sinopsis'=>'Mutiara berharga milik kaisar dicuri. Hakim Dee harus menelusuri jaringan pedagang licik dan dunia bawah tanah kota pelabuhan untuk menemukan pencurinya.'],
                ['kode'=>'HD003','judul'=>'Pembunuhan di Danau','tahun'=>1999,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416351.jpg','sinopsis'=>'Sebuah mayat ditemukan mengambang di danau indah. Di balik ketenangan kota tepi danau tersimpan intrik, pengkhianatan, dan kejahatan yang mengejutkan.'],
                ['kode'=>'HD004','judul'=>'Misteri Pemisah Ruang','tahun'=>1999,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416352.jpg','sinopsis'=>'Seseorang terbunuh di dalam ruangan yang terkunci dari dalam. Hakim Dee menghadapi teka-teki mustahil yang menantang logika dan kecerdasannya.'],
                ['kode'=>'HD005','judul'=>'Pembunuhan di Biara Tao','tahun'=>2000,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416353.jpg','sinopsis'=>'Pembunuhan terjadi di biara Tao yang tertutup. Di balik ritual dan mistisisme, Hakim Dee menemukan keserakahan dan ambisi yang mematikan.'],
                ['kode'=>'HD006','judul'=>'Misteri Lonceng Perunggu','tahun'=>2000,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416354.jpg','sinopsis'=>'Lonceng kuno berusia ratusan tahun dikaitkan dengan serangkaian kematian misterius. Hakim Dee menyelidiki apakah ini kutukan atau kejahatan terencana.'],
                ['kode'=>'HD007','judul'=>'Pembunuhan Emas','tahun'=>2001,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416355.jpg','sinopsis'=>'Seorang penambang emas ditemukan tewas dengan cara brutal. Penyelidikan Hakim Dee membawanya ke dunia serakah para pemburu kekayaan.'],
                ['kode'=>'HD008','judul'=>'Misteri Kostum Merah Kuno','tahun'=>2001,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416356.jpg','sinopsis'=>'Sebuah kostum merah berumur ratusan tahun muncul kembali bersamaan dengan serangkaian teror. Hakim Dee menggali sejarah kelam di balik kain merah itu.'],
                ['kode'=>'HD009','judul'=>'Misteri Siluet Kain Sutra','tahun'=>2002,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/416357.jpg','sinopsis'=>'Siluet misterius di balik kain sutra tipis menjadi petunjuk utama dalam kasus pembunuhan yang melibatkan keluarga bangsawan dan rahasia selama puluhan tahun.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 4. ARTEMIS FOWL – Eoin Colfer (8 buku)
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Artemis Fowl Series (8 buku)');
        $this->buatSeries(
            nama: 'Artemis Fowl Series',
            penulis: 'Eoin Colfer',
            deskripsi: 'Serial fantasi komedi kriminal tentang Artemis Fowl II, remaja genius 12 tahun yang memimpin kejahatan kelas kakap. Ia menemukan dunia peri bawah tanah yang berteknologi tinggi dan mencoba memeras mereka demi mengembalikan kejayaan keluarganya.',
            kategori: 'Fantasi',
            penerbit: 'Gramedia Pustaka Utama',
            coverBase: '',
            daftarBuku: [
                ['kode'=>'AF001','judul'=>'Artemis Fowl','tahun'=>2002,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/249747.jpg','sinopsis'=>'Artemis Fowl II, jenius kriminal berusia 12 tahun, berhasil mencuri buku rahasia peri dan menyandera seorang kapten polisi peri demi mendapatkan emas tebusan senilai satu ton.'],
                ['kode'=>'AF002','judul'=>'Insiden di Kutub Utara','tahun'=>2003,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/249748.jpg','sinopsis'=>'Ayah Artemis yang hilang ditemukan di Rusia oleh mafia. Artemis terpaksa meminta bantuan musuh lamanya, para peri bawah tanah, untuk menyelamatkan sang ayah.'],
                ['kode'=>'AF003','judul'=>'Sandi Keabadian','tahun'=>2004,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/249749.jpg','sinopsis'=>'Artemis mencuri teknologi peri dan mengenkripsinya dengan sandi tak terpecahkan. Ketika laptop berisi sandi itu dicuri kriminal, Artemis dan peri harus bekerja sama.'],
                ['kode'=>'AF004','judul'=>'Tipuan Opal','tahun'=>2005,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/249750.jpg','sinopsis'=>'Opal Koboi, jenius peri yang dipenjarakan, melarikan diri dan melancarkan rencana balas dendam terhadap Artemis dan para peri yang pernah menghentikannya.'],
                ['kode'=>'AF005','judul'=>'Koloni yang Hilang','tahun'=>2006,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/249751.jpg','sinopsis'=>'Artemis menemukan koloni demon yang terjebak dalam dimensi waktu. Misi penyelamatan membawanya berhadapan dengan ancaman lintas waktu yang membahayakan dunia.'],
                ['kode'=>'AF006','judul'=>'Paradoks Waktu','tahun'=>2008,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/2900923.jpg','sinopsis'=>'Ibu Artemis terserang penyakit misterius. Obatnya hanya bisa didapat dari masa lalu. Artemis dan Holly melakukan perjalanan waktu yang penuh paradoks berbahaya.'],
                ['kode'=>'AF007','judul'=>'Kompleks Atlantis','tahun'=>2010,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/7667220.jpg','sinopsis'=>'Artemis mengidap gangguan obsesif kompulsif akibat penggunaan sihir. Di saat kondisinya lemah, Opal Koboi melancarkan serangan ke kota peri bawah laut Atlantis.'],
                ['kode'=>'AF008','judul'=>'Penjaga Terakhir','tahun'=>2012,'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/9703775.jpg','sinopsis'=>'Pertarungan final. Opal Koboi berencana membuka portal ke dunia iblis yang akan menghancurkan kedua dunia. Artemis menghadapi pengorbanan terbesar dalam hidupnya.'],
            ]
        );

        $this->command->info('✅ 4 series berhasil ditambahkan!');
    }

    // ── Helper ────────────────────────────────────────────────────────────
    private function buatSeries(
        string $nama,
        string $penulis,
        string $deskripsi,
        string $kategori,
        string $penerbit,
        string $coverBase,
        array  $daftarBuku
    ): void {
        $bukuIds = [];
        foreach ($daftarBuku as $d) {
            $buku = Buku::firstOrCreate(
                ['kode_buku' => $d['kode']],
                [
                    'judul'        => $d['judul'],
                    'pengarang'    => $penulis,
                    'penerbit'     => $penerbit,
                    'tahun_terbit' => $d['tahun'],
                    'kategori'     => $kategori,
                    'stok'         => rand(2, 5),
                    'cover'        => $d['cover'],
                    'deskripsi'    => $d['sinopsis'],
                ]
            );
            $bukuIds[] = $buku->id;
        }

        $series = Series::firstOrCreate(
            ['slug' => Str::slug($nama)],
            [
                'nama_series'  => $nama,
                'penulis'      => $penulis,
                'deskripsi'    => $deskripsi,
                'slug'         => Str::slug($nama),
                'cover_series' => $daftarBuku[0]['cover'],
            ]
        );

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

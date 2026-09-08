<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Series;
use App\Models\SeriesBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeriesTambahan3Seeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📚 Menambahkan 16 serial baru...');

        // ══════════════════════════════════════════════════════════════
        // 1. HARRY POTTER – J.K. Rowling (7 buku)
        //    BK013 sudah ada → pakai updateOrCreate by kode
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Harry Potter Series (7 buku)');
        $this->buatSeries(
            nama: 'Harry Potter Series',
            penulis: 'J.K. Rowling',
            deskripsi: 'Serial fantasi legendaris tentang Harry Potter, seorang bocah penyihir yang menemukan jati dirinya di Hogwarts School of Witchcraft and Wizardry, dan pertarungannya melawan penyihir jahat Lord Voldemort.',
            kategori: 'Fantasy',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK013', 'judul'=>'Harry Potter and the Philosopher\'s Stone', 'tahun'=>1997, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1474154022i/3.jpg', 'sinopsis'=>'Harry Potter menemukan dirinya adalah seorang penyihir dan memulai petualangan di Hogwarts, sekolah sihir, berteman dengan Ron dan Hermione, dan menghadapi misteri Batu Bertuah.'],
                ['kode'=>'HP002', 'judul'=>'Harry Potter and the Chamber of Secrets', 'tahun'=>1998, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1474169725i/15881.jpg', 'sinopsis'=>'Tahun kedua Harry di Hogwarts. Sebuah suara misterius hanya bisa didengar Harry, dan murid-murid ditemukan membatu. Kamar Rahasia telah dibuka kembali.'],
                ['kode'=>'HP003', 'judul'=>'Harry Potter and the Prisoner of Azkaban', 'tahun'=>1999, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1499277281i/5.jpg', 'sinopsis'=>'Seorang tahanan berbahaya bernama Sirius Black kabur dari penjara Azkaban. Harry belajar tentang masa lalu orang tuanya yang lebih gelap dari yang ia bayangkan.'],
                ['kode'=>'HP004', 'judul'=>'Harry Potter and the Goblet of Fire', 'tahun'=>2000, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1554006152i/6.jpg', 'sinopsis'=>'Harry terpilih sebagai peserta keempat Triwizard Tournament meski belum cukup umur. Di balik kompetisi berbahaya itu, Voldemort sedang merencanakan kebangkitannya.'],
                ['kode'=>'HP005', 'judul'=>'Harry Potter and the Order of the Phoenix', 'tahun'=>2003, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1546910265i/2.jpg', 'sinopsis'=>'Kementerian Sihir menyangkal kembalinya Voldemort. Harry membentuk Laskar Dumbledore, kelompok rahasia untuk belajar bertahan melawan kekuatan jahat.'],
                ['kode'=>'HP006', 'judul'=>'Harry Potter and the Half-Blood Prince', 'tahun'=>2005, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1587697303i/1.jpg', 'sinopsis'=>'Dumbledore membimbing Harry mempelajari masa lalu Voldemort. Sementara itu, ancaman Horcrux terungkap sebagai kunci kekalahan sang Tuan Kegelapan.'],
                ['kode'=>'HP007', 'judul'=>'Harry Potter and the Deathly Hallows', 'tahun'=>2007, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1474171184i/136251.jpg', 'sinopsis'=>'Pertarungan final. Harry, Ron, dan Hermione meninggalkan Hogwarts untuk mencari dan menghancurkan semua Horcrux Voldemort, menuju konfrontasi terakhir yang menentukan nasib dunia sihir.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 2. THE LORD OF THE RINGS – J.R.R. Tolkien (3 buku)
        //    BK014 sudah ada tapi judulnya "The Lord of the Rings" (edisi gabungan)
        //    → update jadi buku 1, tambah buku 2 & 3
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → The Lord of the Rings Series (3 buku)');
        // Update judul BK014 menjadi buku pertama yang spesifik
        Buku::where('kode_buku', 'BK014')->update([
            'judul'     => 'The Fellowship of the Ring',
            'deskripsi' => 'Frodo Baggins mewarisi Cincin Satu yang berbahaya dari pamannya Bilbo. Bersama Fellowship of the Ring, ia memulai perjalanan epik untuk menghancurkan cincin tersebut di Gunung Doom.',
        ]);
        $this->buatSeries(
            nama: 'The Lord of the Rings Series',
            penulis: 'J.R.R. Tolkien',
            deskripsi: 'Trilogi epik fantasi karya J.R.R. Tolkien yang mengisahkan perjuangan Frodo Baggins dan kawan-kawannya untuk menghancurkan Cincin Satu dan menyelamatkan Middle-earth dari kekuasaan Sauron yang jahat.',
            kategori: 'Fantasy',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK014', 'judul'=>'The Fellowship of the Ring', 'tahun'=>1954, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1298411339i/34.jpg', 'sinopsis'=>'Frodo Baggins mewarisi Cincin Satu yang berbahaya. Bersama Fellowship, ia memulai perjalanan epik menuju Mordor untuk menghancurkan cincin tersebut.'],
                ['kode'=>'LOTR002', 'judul'=>'The Two Towers', 'tahun'=>1954, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1347606442i/15241.jpg', 'sinopsis'=>'Fellowship terpecah. Frodo dan Sam melanjutkan perjalanan ke Mordor ditemani Gollum, sementara Aragorn, Legolas, dan Gimli berjuang di medan perang Helm\'s Deep.'],
                ['kode'=>'LOTR003', 'judul'=>'The Return of the King', 'tahun'=>1955, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1347260188i/18512.jpg', 'sinopsis'=>'Pertempuran terakhir untuk Middle-earth. Frodo dan Sam mencapai Gunung Doom sementara Aragorn memimpin pasukan untuk mengalihkan perhatian Sauron. Takdir dunia ditentukan di sini.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 3. A SONG OF ICE AND FIRE – George R.R. Martin (5 buku terbit)
        //    BK015 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → A Song of Ice and Fire Series (5 buku)');
        $this->buatSeries(
            nama: 'A Song of Ice and Fire Series',
            penulis: 'George R.R. Martin',
            deskripsi: 'Serial fantasi epik berlatar dunia Westeros yang brutal dan kompleks. Mengikuti perebutan Tahta Besi oleh berbagai keluarga bangsawan, sementara ancaman dari Utara semakin mendekat.',
            kategori: 'Fantasy',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK015', 'judul'=>'A Game of Thrones', 'tahun'=>1996, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1562726234i/13496.jpg', 'sinopsis'=>'Keluarga Stark, Lannister, dan Targaryen bersaing memperebutkan Tahta Besi Westeros. Intrik politik, pengkhianatan, dan kematian mengejutkan menandai awal kisah epik ini.'],
                ['kode'=>'ASOIAF002', 'judul'=>'A Clash of Kings', 'tahun'=>1998, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1358254974i/10572.jpg', 'sinopsis'=>'Lima raja memperebutkan kekuasaan Westeros setelah kematian Raja Robert. Perang semakin meluas sementara kekuatan magis mulai bangkit kembali di dunia.'],
                ['kode'=>'ASOIAF003', 'judul'=>'A Storm of Swords', 'tahun'=>2000, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1571318786i/62291.jpg', 'sinopsis'=>'Perang mencapai puncaknya dengan pertempuran dan pengkhianatan yang mengubah segalanya. Termasuk salah satu adegan paling mengejutkan dalam sejarah sastra fantasi.'],
                ['kode'=>'ASOIAF004', 'judul'=>'A Feast for Crows', 'tahun'=>2005, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327885352i/13497.jpg', 'sinopsis'=>'Pasca perang, Westeros mencoba bangkit dari puing-puing. Cersei mencengkeram kekuasaan di King\'s Landing sementara Arya dan Brienne mencari tujuan mereka.'],
                ['kode'=>'ASOIAF005', 'judul'=>'A Dance with Dragons', 'tahun'=>2011, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327885206i/10664113.jpg', 'sinopsis'=>'Daenerys memerintah di Meereen sementara Jon Snow menghadapi ancaman dari Utara. Tyrion dalam pelarian mencari sekutu. Naga-naga semakin sulit dikendalikan.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 4. LETTERS OF ENCHANTMENT – Rebecca Ross (2 buku)
        //    BK020 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Letters of Enchantment Series (2 buku)');
        $this->buatSeries(
            nama: 'Letters of Enchantment Series',
            penulis: 'Rebecca Ross',
            deskripsi: 'Duologi romantis berlatar dunia fantasi dengan peperangan abadi antara dua kerajaan. Mengisahkan dua musuh yang bertukar surat dan jatuh cinta tanpa pernah bertemu langsung.',
            kategori: 'Romance',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK020', 'judul'=>'Divine Rivals', 'tahun'=>2023, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1673143041i/62027358.jpg', 'sinopsis'=>'Iris dan Roman adalah jurnalis rival di koran yang sama. Keduanya tanpa sadar bertukar surat paling intim lewat mesin tik ajaib — tanpa tahu siapa penerima di ujung sana.'],
                ['kode'=>'LOE002', 'judul'=>'Ruthless Vows', 'tahun'=>2023, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1690000000i/75657359.jpg', 'sinopsis'=>'Iris dan Roman kembali bertemu di garis depan perang yang makin sengit. Kenangan Roman terhapus, dan Iris harus memilih antara tugasnya sebagai jurnalis atau menyelamatkan pria yang ia cintai.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 5. THE EMPYREAN – Rebecca Yarros (3 buku terbit)
        //    BK024 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → The Empyrean Series (3 buku)');
        $this->buatSeries(
            nama: 'The Empyrean Series',
            penulis: 'Rebecca Yarros',
            deskripsi: 'Serial romantis fantasi berlatar akademi militer penyihir berkendara naga. Mengisahkan Violet Sorrengail yang terpaksa memasuki War College meski tubuhnya lemah, di dunia di mana naga memilih pengendaranya — atau membunuh mereka.',
            kategori: 'Romance',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK024', 'judul'=>'Fourth Wing', 'tahun'=>2023, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1681379173i/61431922.jpg', 'sinopsis'=>'Violet Sorrengail terpaksa masuk Rider Quadrant di Basgiath War College. Di sana naga memilih pengendaranya atau membunuh mereka. Lalu Xaden Riorson, musuh terbesarnya, menjadi instrukturnya.'],
                ['kode'=>'EMP002', 'judul'=>'Iron Flame', 'tahun'=>2023, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1692837808i/90202655.jpg', 'sinopsis'=>'Violet selamat dari tahun pertamanya. Namun rahasia yang ia temukan mengancam seluruh fondasi kerajaan. Sementara hubungannya dengan Xaden semakin rumit dengan rahasia yang memisahkan mereka.'],
                ['kode'=>'EMP003', 'judul'=>'Onyx Storm', 'tahun'=>2025, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1700000000i/199682826.jpg', 'sinopsis'=>'Violet dan Xaden menghadapi ancaman yang lebih besar dari yang pernah mereka bayangkan. Batas antara sekutu dan musuh semakin kabur saat kebenaran tentang perang terungkap.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 6. A GOOD GIRL'S GUIDE TO MURDER – Holly Jackson (3 buku + 1 novella)
        //    BK025 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → A Good Girl\'s Guide to Murder Series (4 buku)');
        $this->buatSeries(
            nama: 'A Good Girl\'s Guide to Murder Series',
            penulis: 'Holly Jackson',
            deskripsi: 'Serial misteri YA tentang Pippa "Pip" Fitz-Amobi yang menyelidiki kasus pembunuhan di kotanya sendiri sebagai proyek sekolah — dan menemukan kebenaran yang lebih gelap dari yang siapa pun duga.',
            kategori: 'Mystery',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK025', 'judul'=>'A Good Girl\'s Guide to Murder', 'tahun'=>2019, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1561632498i/40597520.jpg', 'sinopsis'=>'Pip menyelidiki kasus pembunuhan lima tahun lalu sebagai proyek sekolah. Semua bukti menunjuk pada satu orang — tapi Pip yakin ia tidak bersalah. Penyelidikannya membuka kotak pandora.'],
                ['kode'=>'AGGG002', 'judul'=>'Good Girl, Bad Blood', 'tahun'=>2020, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1571612374i/49684884.jpg', 'sinopsis'=>'Pip berjanji tidak akan menyelidiki kasus lagi. Tapi ketika seorang teman menghilang dan polisi tidak bertindak, ia kembali menjadi detektif amatir — kali ini dengan podcasting.'],
                ['kode'=>'AGGG003', 'judul'=>'As Good as Dead', 'tahun'=>2021, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1613665736i/55867274.jpg', 'sinopsis'=>'Pip menerima ancaman dari serial killer. Kasus-kasus sebelumnya yang ia selesaikan kini menghantui balik. Penyelidikan terakhirnya menjadi paling berbahaya — dan paling personal.'],
                ['kode'=>'AGGG004', 'judul'=>'Kill Joy', 'tahun'=>2021, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1611091543i/56587687.jpg', 'sinopsis'=>'Novella prequel. Pip remaja bermain murder mystery game di pesta ulang tahun — tapi misteri mainan itu berubah menjadi nyata ketika rahasia gelap terungkap.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 7. THE HUNGER GAMES – Suzanne Collins (5 buku)
        //    BK038 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → The Hunger Games Series (5 buku)');
        $this->buatSeries(
            nama: 'The Hunger Games Series',
            penulis: 'Suzanne Collins',
            deskripsi: 'Serial dystopia tentang Katniss Everdeen di negara Panem yang mewajibkan setiap distrik mengorbankan dua remaja untuk bertarung sampai mati di acara televisi tahunan bernama The Hunger Games.',
            kategori: 'Young Adult',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK038', 'judul'=>'The Hunger Games', 'tahun'=>2008, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1586722975i/2767052.jpg', 'sinopsis'=>'Katniss Everdeen menggantikan adiknya dan menjadi tribut Distrik 12 di Hunger Games ke-74. Untuk bertahan hidup, ia harus membunuh — atau menemukan cara lain yang lebih cerdas.'],
                ['kode'=>'HG002',  'judul'=>'Catching Fire', 'tahun'=>2009, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1586722941i/6148028.jpg', 'sinopsis'=>'Katniss menjadi simbol pemberontakan yang tidak diinginkan Capitol. Presiden Snow mengancamnya — dan mengirimnya kembali ke arena dalam Hunger Games edisi khusus Quarter Quell.'],
                ['kode'=>'HG003',  'judul'=>'Mockingjay', 'tahun'=>2010, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1586722545i/7260188.jpg', 'sinopsis'=>'Katniss menjadi Mockingjay, simbol revolusi melawan Capitol. Perang terbuka antara distrik-distrik dan Capitol dimulai. Harga kemenangan jauh lebih mahal dari yang dibayangkan.'],
                ['kode'=>'HG004',  'judul'=>'The Ballad of Songbirds and Snakes', 'tahun'=>2020, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1578966998i/51901147.jpg', 'sinopsis'=>'Prekuel: kisah muda Coriolanus Snow sebelum menjadi Presiden yang kejam. Ia menjadi mentor tribut Distrik 12 dalam Hunger Games ke-10 dan menghadapi pilihan yang membentuk karakternya.'],
                ['kode'=>'HG005',  'judul'=>'Sunrise on the Reaping', 'tahun'=>2025, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1700000000i/200765780.jpg', 'sinopsis'=>'Prekuel kedua: kisah Haymitch Abernathy, mentor Katniss, saat ia sendiri menjadi tribut dalam Hunger Games ke-50 — Quarter Quell yang memiliki aturan sangat berbeda.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 8. TWILIGHT SAGA – Stephenie Meyer (5 buku)
        //    BK039 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Twilight Saga (5 buku)');
        $this->buatSeries(
            nama: 'Twilight Saga',
            penulis: 'Stephenie Meyer',
            deskripsi: 'Serial romance paranormal tentang Bella Swan yang jatuh cinta dengan Edward Cullen, seorang vampir berusia ratusan tahun. Kisah cinta yang rumit di antara dunia manusia, vampir, dan werewolf.',
            kategori: 'Young Adult',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK039', 'judul'=>'Twilight', 'tahun'=>2005, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1361039443i/41865.jpg', 'sinopsis'=>'Bella Swan pindah ke Forks dan jatuh cinta pada Edward Cullen yang ternyata seorang vampir. Kisah cinta terlarang mereka diuji ketika vampir berbahaya mulai mengincar Bella.'],
                ['kode'=>'TW002', 'judul'=>'New Moon', 'tahun'=>2006, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1361038355i/41347.jpg', 'sinopsis'=>'Edward meninggalkan Bella untuk melindunginya. Bella jatuh dalam depresi dan menemukan kedekatan dengan Jacob Black — yang ternyata menyimpan rahasianya sendiri sebagai werewolf.'],
                ['kode'=>'TW003', 'judul'=>'Eclipse', 'tahun'=>2007, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1361038277i/428263.jpg', 'sinopsis'=>'Bella harus memilih antara Edward dan Jacob. Sementara itu, tentara vampir baru diciptakan di Seattle dan ancaman Victoria semakin mendekat ke Forks.'],
                ['kode'=>'TW004', 'judul'=>'Breaking Dawn', 'tahun'=>2008, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1361038024i/1162543.jpg', 'sinopsis'=>'Bella dan Edward menikah. Kehamilan Bella yang mengancam nyawanya mengubah segalanya. Konfrontasi besar dengan Volturi menjadi ujian terakhir keluarga Cullen.'],
                ['kode'=>'TW005', 'judul'=>'Midnight Sun', 'tahun'=>2020, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1588173933i/53287484.jpg', 'sinopsis'=>'Retelling novel pertama dari sudut pandang Edward Cullen. Membaca pikiran semua orang kecuali Bella membuat Edward terpesona sekaligus frustrasi — dan jatuh cinta tanpa bisa dicegah.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 9. DIVERGENT SERIES – Veronica Roth (4 buku)
        //    BK040 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Divergent Series (4 buku)');
        $this->buatSeries(
            nama: 'Divergent Series',
            penulis: 'Veronica Roth',
            deskripsi: 'Serial dystopia berlatar Chicago masa depan yang terbagi menjadi lima faksi berdasarkan nilai utama masing-masing. Beatrice "Tris" Prior menemukan dirinya tidak cocok di satu faksi — ia adalah Divergent.',
            kategori: 'Young Adult',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK040', 'judul'=>'Divergent', 'tahun'=>2011, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1328559506i/13335037.jpg', 'sinopsis'=>'Tris Prior meninggalkan faksi Abnegation dan bergabung dengan Dauntless. Ia menyembunyikan identitasnya sebagai Divergent sembari menemukan konspirasi besar yang mengancam seluruh sistem faksi.'],
                ['kode'=>'DIV002', 'judul'=>'Insurgent', 'tahun'=>2012, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1328553570i/11735983.jpg', 'sinopsis'=>'Pasca serangan terhadap Abnegation, Tris berjuang dengan rasa bersalah dan mencari kebenaran tentang apa yang sedang disembunyikan para pemimpin faksi dari seluruh warga.'],
                ['kode'=>'DIV003', 'judul'=>'Allegiant', 'tahun'=>2013, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1395582745i/18710190.jpg', 'sinopsis'=>'Tris dan Four melampaui tembok kota dan menemukan dunia yang sesungguhnya. Kebenaran tentang asal-usul mereka menghancurkan segala sesuatu yang mereka percaya — dan meminta pengorbanan tertinggi.'],
                ['kode'=>'DIV004', 'judul'=>'Four: A Divergent Collection', 'tahun'=>2014, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1390411208i/22081709.jpg', 'sinopsis'=>'Kumpulan empat cerita dari sudut pandang Four/Tobias. Mengisi latar belakang karakter sebelum dan selama peristiwa di novel Divergent.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 10. DUNE CHRONICLES – Frank Herbert (6 buku)
        //     BK043 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Dune Chronicles (6 buku)');
        $this->buatSeries(
            nama: 'Dune Chronicles',
            penulis: 'Frank Herbert',
            deskripsi: 'Serial sci-fi epik berlatar planet gurun Arrakis, satu-satunya sumber "spice" paling berharga di alam semesta. Mengikuti Paul Atreides yang menjadi pemimpin suku Fremen dan mengubah takdir galaksi.',
            kategori: 'Science Fiction',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK043',  'judul'=>'Dune', 'tahun'=>1965, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1555447414i/44767458.jpg', 'sinopsis'=>'Paul Atreides tiba di Arrakis, planet gurun penghasil spice. Setelah pengkhianatan menghancurkan keluarganya, ia bergabung dengan suku Fremen dan memimpin perlawanan.'],
                ['kode'=>'DUNE002', 'judul'=>'Dune Messiah', 'tahun'=>1969, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1317793257i/44492285.jpg', 'sinopsis'=>'Dua belas tahun setelah mengambil kekuasaan, Paul memerintah sebagai Kaisar. Namun jihad atas namanya telah membunuh miliaran orang dan konspirasi mengancam dari segala sisi.'],
                ['kode'=>'DUNE003', 'judul'=>'Children of Dune', 'tahun'=>1976, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1555440481i/44492290.jpg', 'sinopsis'=>'Anak kembar Paul, Leto dan Ghanima, menghadapi konspirasi yang mengancam nyawa mereka. Leto membuat pilihan mengerikan yang akan mengubah nasib umat manusia selama ribuan tahun.'],
                ['kode'=>'DUNE004', 'judul'=>'God Emperor of Dune', 'tahun'=>1981, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1405546838i/44492291.jpg', 'sinopsis'=>'3.500 tahun kemudian, Leto II memerintah sebagai Tuhan-Kaisar setengah manusia setengah cacing pasir. Tiraninya yang brutal adalah harga yang dibayar untuk menyelamatkan masa depan manusia.'],
                ['kode'=>'DUNE005', 'judul'=>'Heretics of Dune', 'tahun'=>1984, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1405546839i/44492292.jpg', 'sinopsis'=>'1.500 tahun setelah kematian Leto II. Manusia menyebar ke seluruh galaksi. Ghola Duncan Idaho ke-22 menjadi pusat perhatian berbagai kekuatan yang bersaing memperebutkan masa depan.'],
                ['kode'=>'DUNE006', 'judul'=>'Chapterhouse: Dune', 'tahun'=>1985, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1405546840i/44492293.jpg', 'sinopsis'=>'Bene Gesserit menghadapi kepunahan dari Honoured Matres yang fanatik. Meles Atreides dan Duncan Idaho yang terakhir membuat keputusan yang menentukan kelangsungan hidup spesies manusia.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 11. FOUNDATION SERIES – Isaac Asimov (7 buku)
        //     BK044 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Foundation Series (7 buku)');
        $this->buatSeries(
            nama: 'Foundation Series',
            penulis: 'Isaac Asimov',
            deskripsi: 'Serial sci-fi klasik tentang Hari Seldon yang mengembangkan "psychohistory" — ilmu yang memprediksi masa depan peradaban. Ia mendirikan Foundation untuk mempersingkat masa kegelapan setelah keruntuhan Galactic Empire.',
            kategori: 'Science Fiction',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'FD006',  'judul'=>'Prelude to Foundation', 'tahun'=>1988, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/29579.jpg', 'sinopsis'=>'Kisah muda Hari Seldon di Trantor saat ia pertama kali mengembangkan konsep psychohistory. Ia diburu oleh berbagai faksi yang ingin memanfaatkan ilmunya.'],
                ['kode'=>'FD007',  'judul'=>'Forward the Foundation', 'tahun'=>1993, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/29580.jpg', 'sinopsis'=>'Tahun-tahun terakhir Hari Seldon. Ia menyaksikan satu per satu orang-orang terkasihnya pergi sementara ia terus menyempurnakan psychohistory untuk menyelamatkan peradaban.'],
                ['kode'=>'BK044',  'judul'=>'Foundation', 'tahun'=>1951, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1417900846i/29579.jpg', 'sinopsis'=>'Hari Seldon mendirikan Foundation di ujung galaksi. Setelah kematiannya, para ilmuwan Foundation harus menghadapi berbagai krisis menggunakan akal budi, bukan senjata.'],
                ['kode'=>'FD002',  'judul'=>'Foundation and Empire', 'tahun'=>1952, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/29581.jpg', 'sinopsis'=>'Foundation menghadapi ancaman dari sisa-sisa Galactic Empire yang masih kuat. Lalu muncul ancaman yang tidak diprediksi Seldon: Mule, seorang mutant dengan kekuatan psikis luar biasa.'],
                ['kode'=>'FD003',  'judul'=>'Second Foundation', 'tahun'=>1953, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/29582.jpg', 'sinopsis'=>'Mule mencari Second Foundation yang misterius untuk dihancurkan. Sementara Foundation sendiri tidak yakin apakah Second Foundation adalah sekutu atau ancaman bagi kemerdekaan mereka.'],
                ['kode'=>'FD004',  'judul'=>'Foundation\'s Edge', 'tahun'=>1982, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/29583.jpg', 'sinopsis'=>'Lima ratus tahun setelah Seldon. Golan Trevize meragukan rencana Seldon dan melakukan perjalanan ke ujung galaksi mencari jawaban — menemukan kebenaran yang lebih mengejutkan dari yang diperkirakan.'],
                ['kode'=>'FD005',  'judul'=>'Foundation and Earth', 'tahun'=>1986, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/29584.jpg', 'sinopsis'=>'Trevize mencari planet Bumi yang legendaris — yang telah menghilang dari semua catatan sejarah. Perjalanannya membawanya pada jawaban tentang masa depan seluruh umat manusia.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 12. ENDER'S SAGA – Orson Scott Card (4 buku)
        //     BK045 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Ender\'s Saga (4 buku)');
        $this->buatSeries(
            nama: 'Ender\'s Saga',
            penulis: 'Orson Scott Card',
            deskripsi: 'Serial sci-fi filosofis tentang Andrew "Ender" Wiggin, bocah jenius yang dilatih sejak kecil untuk memimpin perang melawan alien Formics. Seri ini mengeksplorasi tema empati, kekerasan, dan apa artinya menjadi manusia.',
            kategori: 'Science Fiction',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK045',  'judul'=>'Ender\'s Game', 'tahun'=>1985, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1408303130i/375802.jpg', 'sinopsis'=>'Ender Wiggin direkrut ke Battle School sejak usia 6 tahun. Ia dilatih untuk memimpin perang melawan Formics — tanpa menyadari bahwa seluruh "latihan" itu adalah pertempuran nyata.'],
                ['kode'=>'ENDER002', 'judul'=>'Speaker for the Dead', 'tahun'=>1986, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1316636170i/7967.jpg', 'sinopsis'=>'3.000 tahun kemudian, Ender menjadi "Speaker for the Dead" yang menceritakan kebenaran tentang kehidupan seseorang setelah kematiannya. Ia menemukan planet dengan spesies alien baru.'],
                ['kode'=>'ENDER003', 'judul'=>'Xenocide', 'tahun'=>1991, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1316636286i/7969.jpg', 'sinopsis'=>'Virus mematikan mengancam pemusnahan spesies alien Piggies dan Buggers. Ender dan keluarganya harus menemukan cara menghentikan virus — sambil menghindari armada pemusnah dari Bumi.'],
                ['kode'=>'ENDER004', 'judul'=>'Children of the Mind', 'tahun'=>1996, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1316636388i/9552.jpg', 'sinopsis'=>'Ender sekarat. Dua versi jiwanya diwujudkan dalam tubuh orang lain untuk menyelesaikan misinya. Penyelesaian epik dari perjalanan tiga ribu tahun seorang bocah yang menanggung beban dunia.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 13. SPRAWL TRILOGY – William Gibson (3 buku)
        //     BK048 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Sprawl Trilogy (3 buku)');
        $this->buatSeries(
            nama: 'Sprawl Trilogy',
            penulis: 'William Gibson',
            deskripsi: 'Trilogi cyberpunk klasik yang mendefinisikan genre. Berlatar dunia masa depan di mana teknologi dan manusia menyatu, korporasi berkuasa, dan hacker adalah pahlawan bawah tanah.',
            kategori: 'Science Fiction',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK048',    'judul'=>'Neuromancer', 'tahun'=>1984, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1554437249i/888628.jpg', 'sinopsis'=>'Case, seorang hacker yang kemampuannya dihancurkan, mendapat kesempatan terakhir. Ia direkrut untuk melakukan heist terbesar di cyberspace — menyusup ke AI paling kuat yang pernah ada.'],
                ['kode'=>'SPRAWL002', 'judul'=>'Count Zero', 'tahun'=>1986, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/22200.jpg', 'sinopsis'=>'Tujuh tahun setelah Neuromancer. Tiga karakter berbeda — seorang hacker, seorang tentara bayaran, dan seorang agen seni — jalur hidup mereka bersilangan dalam misteri di cyberspace.'],
                ['kode'=>'SPRAWL003', 'judul'=>'Mona Lisa Overdrive', 'tahun'=>1988, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388495687i/22220.jpg', 'sinopsis'=>'Penyelesaian trilogi. Molly kembali, Angie Mitchell terjebak dalam jaring AI, dan Mona Lisa adalah kunci dari semuanya. Batas antara dunia nyata dan cyberspace semakin tipis.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 14. MILLENNIUM – Stieg Larsson dkk. (8 buku)
        //     BK049 sudah ada
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Millennium Series (8 buku)');
        $this->buatSeries(
            nama: 'Millennium Series',
            penulis: 'Stieg Larsson',
            deskripsi: 'Serial thriller kriminal Swedia tentang jurnalis Mikael Blomkvist dan hacker jenius Lisbeth Salander. Tiga buku pertama karya Stieg Larsson, dilanjutkan David Lagercrantz dan Karin Smirnoff.',
            kategori: 'Thriller',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'BK049',    'judul'=>'The Girl with the Dragon Tattoo', 'tahun'=>2005, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327868566i/2429135.jpg', 'sinopsis'=>'Mikael Blomkvist menyelidiki hilangnya seorang wanita dari keluarga industri kaya 40 tahun lalu. Ia dibantu Lisbeth Salander, hacker dengan ingatan fotografis dan masa lalu kelam.'],
                ['kode'=>'MIL002',   'judul'=>'The Girl Who Played with Fire', 'tahun'=>2006, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327868586i/5060378.jpg', 'sinopsis'=>'Lisbeth menjadi tersangka utama pembunuhan tiga orang. Mikael yakin ia tidak bersalah dan menyelidiki masa lalu Lisbeth yang tersembunyi selama bertahun-tahun.'],
                ['kode'=>'MIL003',   'judul'=>'The Girl Who Kicked the Hornets\' Nest', 'tahun'=>2007, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327868702i/6892870.jpg', 'sinopsis'=>'Lisbeth di rumah sakit pasca cedera parah. Ia menghadapi persidangan atas pembunuhan yang tidak dilakukannya, sementara Mikael membongkar konspirasi tingkat tinggi yang melindungi penjahat.'],
                ['kode'=>'MIL004',   'judul'=>'The Girl in the Spider\'s Web', 'tahun'=>2015, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1412282451i/22318484.jpg', 'sinopsis'=>'Lanjutan oleh David Lagercrantz. Lisbeth dan Mikael terlibat dalam kasus pencurian data kecerdasan buatan yang melibatkan NSA, hacker kelas dunia, dan saudara kembar Lisbeth yang jahat.'],
                ['kode'=>'MIL005',   'judul'=>'The Girl Who Takes an Eye for an Eye', 'tahun'=>2017, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1481831485i/32886721.jpg', 'sinopsis'=>'Lisbeth di penjara menghadapi gangster berbahaya. Di luar, ia menyelidiki eksperimen ilmiah kejam yang dilakukan pada anak-anak di panti asuhan — termasuk dirinya sendiri.'],
                ['kode'=>'MIL006',   'judul'=>'The Girl Who Lived Twice', 'tahun'=>2019, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1551913839i/43565069.jpg', 'sinopsis'=>'Lisbeth menghadapi kakaknya Camilla dalam konfrontasi terakhir mereka. Sementara Mikael menyelidiki kematian seorang tunawisma yang ternyata menyimpan rahasia diplomatik besar.'],
                ['kode'=>'MIL007',   'judul'=>'The Girl in the Eagle\'s Talons', 'tahun'=>2023, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1680000000i/75657360.jpg', 'sinopsis'=>'Karya Karin Smirnoff. Lisbeth dan Mikael menyelidiki hilangnya seorang gadis remaja di kota kecil Norrland yang menyimpan rahasia gelap tentang kekerasan dan kelompok supremasi.'],
                ['kode'=>'MIL008',   'judul'=>'The Girl with Ice in Her Veins', 'tahun'=>2025, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1700000000i/200765781.jpg', 'sinopsis'=>'Lanjutan terbaru oleh Karin Smirnoff. Lisbeth menghadapi kasus yang menyentuh akar paling gelap dari masa lalunya sendiri.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 15. ROBERT LANGDON – Dan Brown (5 buku)
        //     BK050 sudah ada (buku ke-2)
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Robert Langdon Series (5 buku)');
        $this->buatSeries(
            nama: 'Robert Langdon Series',
            penulis: 'Dan Brown',
            deskripsi: 'Serial thriller tentang profesor simbologi Harvard, Robert Langdon, yang selalu terseret dalam konspirasi besar menyangkut sejarah, seni, dan agama. Setiap buku berlatar kota berbeda dengan misteri yang mendebarkan.',
            kategori: 'Thriller',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'RL001',  'judul'=>'Angels & Demons', 'tahun'=>2000, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1303994556i/960.jpg', 'sinopsis'=>'Langdon menyelidiki pembunuhan ilmuwan CERN dan ancaman bom antimateri di Vatikan. Ia harus mengungkap konspirasi Illuminati sebelum empat kardinal dibunuh satu per satu.'],
                ['kode'=>'BK050',  'judul'=>'The Da Vinci Code', 'tahun'=>2003, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1579621267i/968.jpg', 'sinopsis'=>'Pembunuhan di Louvre meninggalkan pesan rahasia. Langdon dan kriptograf Sophie Neveu mengikuti jejak yang mengarah pada rahasia Holy Grail yang tersembunyi oleh Opus Dei selama berabad-abad.'],
                ['kode'=>'RL003',  'judul'=>'The Lost Symbol', 'tahun'=>2009, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1316638394i/6411961.jpg', 'sinopsis'=>'Langdon diundang ke Capitol Hill tapi justru terperangkap dalam konspirasi Freemason. Ia harus memecahkan kode simbol kuno untuk menyelamatkan mentor dan temannya.'],
                ['kode'=>'RL004',  'judul'=>'Inferno', 'tahun'=>2013, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1529596797i/17675462.jpg', 'sinopsis'=>'Langdon terbangun tanpa ingatan di Florence dengan seseorang mengejarnya. Ia harus memecahkan kode dari karya Dante sebelum virus mematikan dirilis untuk mengontrol populasi dunia.'],
                ['kode'=>'RL005',  'judul'=>'Origin', 'tahun'=>2017, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1481183563i/32283133.jpg', 'sinopsis'=>'Seorang futurist akan mengumumkan penemuan yang akan mengguncang fondasi agama dunia — sebelum dibunuh. Langdon harus menemukan pesannya sebelum dimusnahkan oleh kekuatan religius.'],
            ]
        );

        // ══════════════════════════════════════════════════════════════
        // 16. HOLLY GIBNEY / BILL HODGES – Stephen King (6 buku)
        //     BK051 sudah ada (buku ke-6)
        // ══════════════════════════════════════════════════════════════
        $this->command->info('  → Holly Gibney Series (6 buku)');
        $this->buatSeries(
            nama: 'Holly Gibney Series',
            penulis: 'Stephen King',
            deskripsi: 'Serial thriller tentang detektif Bill Hodges dan asistennya Holly Gibney yang menyelidiki kasus-kasus kriminal yang kompleks. Holly, yang awalnya karakter pendukung, berkembang menjadi protagonis utama yang sangat dicintai pembaca.',
            kategori: 'Thriller',
            penerbit: 'Gramedia Pustaka Utama',
            daftarBuku: [
                ['kode'=>'HG_SK001', 'judul'=>'Mr. Mercedes', 'tahun'=>2014, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1398707023i/18775247.jpg', 'sinopsis'=>'Mantan detektif Bill Hodges ditantang oleh Brady Hartsfield, pembunuh yang pernah menabrak kerumunan dengan Mercedes curian. Hartsfield mengancam akan melakukan serangan lebih besar lagi.'],
                ['kode'=>'HG_SK002', 'judul'=>'Finders Keepers', 'tahun'=>2015, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1421106809i/23529094.jpg', 'sinopsis'=>'Seorang penggemar fanatik membunuh penulis favoritnya dan mencuri naskah unpublished. Tiga puluh tahun kemudian, seorang remaja menemukan naskah itu — dan menjadi sasaran.'],
                ['kode'=>'HG_SK003', 'judul'=>'End of Watch', 'tahun'=>2016, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1456095028i/25541230.jpg', 'sinopsis'=>'Brady Hartsfield dalam koma tapi masih bisa membunuh — menggunakan kekuatan psikis misterius. Hodges dan Holly harus menghentikannya sebelum gelombang bunuh diri menyebar lebih luas.'],
                ['kode'=>'HG_SK004', 'judul'=>'The Outsider', 'tahun'=>2018, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1524596540i/36124936.jpg', 'sinopsis'=>'Seorang anak terbunuh dan semua bukti menunjuk pada satu orang — yang memiliki alibi sempurna. Holly Gibney membantu menyelidiki kemungkinan yang tidak masuk akal.'],
                ['kode'=>'HG_SK005', 'judul'=>'If It Bleeds', 'tahun'=>2020, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1578682799i/46015758.jpg', 'sinopsis'=>'Kumpulan novella. Cerita utama: Holly menyelidiki reporter TV yang terlihat sangat muda dan sehat untuk usianya — kecurigaannya membawanya ke kebenaran yang mengerikan.'],
                ['kode'=>'BK051',    'judul'=>'Holly', 'tahun'=>2023, 'cover'=>'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1675385876i/61714633.jpg', 'sinopsis'=>'Holly menyelidiki hilangnya beberapa orang dari berbagai latar belakang. Jejak mengarah ke pasangan akademisi yang menyimpan rahasia paling gelap. Novel pertama dengan Holly sebagai satu-satunya protagonis.'],
            ]
        );

        $this->command->info('');
        $this->command->info('✅ 16 serial berhasil ditambahkan!');
    }

    // ── Helper ────────────────────────────────────────────────────────────
    private function buatSeries(
        string $nama,
        string $penulis,
        string $deskripsi,
        string $kategori,
        string $penerbit,
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
                    'stok'         => rand(2, 6),
                    'cover'        => $d['cover'],
                    'deskripsi'    => $d['sinopsis'],
                ]
            );
            // Update judul jika buku sudah ada (kode existing)
            $buku->update(['judul' => $d['judul'], 'deskripsi' => $d['sinopsis']]);
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

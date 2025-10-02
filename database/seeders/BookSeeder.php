<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample books for each category
        $categories = \App\Models\Category::all();
        $users = \App\Models\User::all();
        $azmiUser = \App\Models\User::where('email', 'azmifauzan@gmail.com')->first();
        $meilatiUser = \App\Models\User::where('email', 'meilati.fanita@gmail.com')->first();

        if ($categories->isEmpty() || $users->isEmpty()) {
            return;
        }

        $sampleBooks = [
            [
                'judul' => 'Bunga Aira yang Sabar',
                'slug' => \App\Models\Book::generateSlug('Bunga Aira yang Sabar'),
                'pengarang' => 'Fauzan Azmi',
                'sinopsis' => 'Aira mendapat hadiah biji bunga dari Kakeknya. Dengan penuh semangat, ia menanam dan merawatnya setiap hari. Namun, ketika bunga tak kunjung tumbuh, Aira merasa kecewa. Kakek pun mengajarkannya bahwa bunga membutuhkan waktu dan kesabaran. Aira pun belajar menyiram, merawat, dan menunggu dengan sabar. Hingga akhirnya, tunas kecil muncul dan tumbuh menjadi bunga besar nan indah. Dari pengalaman itu, Aira memahami bahwa kesabaran selalu menghadirkan kebahagiaan dan keindahan.',
                'cover' => 'https://is3.cloudhost.id/bukucerita/cover/bunga-aira.png',
                'link' => 'https://gemini.google.com/share/9433d7beed08',
                'youtube_link' => 'https://www.youtube.com/watch?v=gS_6-ov447U',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'petualangan')->first()?->id ?? $categories->first()->id,
                'user_id' => $azmiUser?->id ?? $users->first()->id,
                'age_min' => 3,
                'age_max' => 12,
                'views' => 20,
            ],
            [
                'judul' => 'Kelinci Putih dan Teman-Temannya',
                'slug' => \App\Models\Book::generateSlug('Kelinci Putih dan Teman-Temannya'),
                'pengarang' => 'Fauzan Azmi',
                'sinopsis' => 'Kelinci Putih adalah hewan yang ramah dan suka bermain dengan teman-teman hewannya di halaman rumah. Namun, kegembiraannya terganggu ketika ia menjadi sasaran ejekan dari Kucing Hitam dan hewan-hewan lain karena ciri fisiknya, yang membuatnya sedih, murung, dan kehilangan rasa percaya diri. Kakek Anjing yang bijak menyadari kesedihan Kelinci Putih. Ia menasihati Kelinci dan menjelaskan bahwa mengolok-olok adalah tindakan bullying yang harus dihentikan. Kakek Anjing kemudian mengumpulkan semua hewan untuk mengajarkan pentingnya saling menghargai. Setelah mendengarkan nasihat tersebut, Kucing Hitam menyadari kesalahannya dan meminta maaf kepada Kelinci Putih. Kelinci Putih pun memaafkannya. Sejak saat itu, semua hewan kembali bermain bersama dalam suasana gembira, penuh tawa, dan persahabatan, menegaskan bahwa hidup menjadi indah tanpa bullying.',
                'cover' => 'https://is3.cloudhost.id/bukucerita/cover/kelinci.png',
                'link' => 'https://gemini.google.com/share/3b832ae0e198',
                'youtube_link' => 'https://www.youtube.com/watch?v=xV5KhJILdww',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'edukatif')->first()?->id ?? $categories->first()->id,
                'user_id' => $azmiUser?->id ?? $users->first()->id,
                'age_min' => 3,
                'age_max' => 12,
                'views' => 10,
            ],
            [
                'judul' => 'Aku Bisa Menghindari Bully',
                'slug' => \App\Models\Book::generateSlug('Aku Bisa Menghindari Bully'),
                'pengarang' => 'Meilati Putri Fanita',
                'sinopsis' => 'Cerita "Aku Bisa Menghindari Bully" ini berfokus pada Faris (5 tahun) dan adiknya, Farras (1 tahun), yang mendapatkan pelajaran penting dari Bunda mereka. Suatu pagi, Faris menanyakan tentang adegan sedih di televisi, yang kemudian dijelaskan Bunda sebagai tindakan bully (perundungan). Bunda menjelaskan apa itu bully (membuat orang lain sakit hati atau sedih) dan mengajarkan Faris cara untuk menghadapinya: menjauh atau meminta bantuan orang dewasa, sambil mengingatkan bahwa setiap anak itu hebat. Keesokan harinya, cerita beralih ke tema rasa terima kasih dan menghargai ketika Faris berinisiatif meminjamkan mainannya kepada Farras. Bunda menggunakan momen ini untuk mengajarkan Faris pentingnya mengucapkan terima kasih sebagai tanda menghargai orang lain dan bersyukur kepada Allah, mengakhiri cerita dengan pesan positif dan momen kehangatan keluarga. Cerita ini ditujukan untuk pembaca berusia 5 tahun.',
                'cover' => 'https://is3.cloudhost.id/bukucerita/cover/bully.png',
                'link' => 'https://gemini.google.com/share/a211f213587e',
                'youtube_link' => 'https://www.youtube.com/watch?v=nujezQRMcKY',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'persahabatan')->first()?->id ?? $categories->first()->id,
                'user_id' => $meilatiUser?->id ?? $users->first()->id,
                'age_min' => 5,
                'age_max' => 10,
                'views' => 5,
            ],
            [
                'judul' => 'Zidan Anak Disiplin',
                'slug' => \App\Models\Book::generateSlug('Zidan Anak Disiplin'),
                'pengarang' => 'Fauzan Azmi',
                'sinopsis' => 'Cerita ini berkisah tentang Zidan, seorang balita ceria yang sangat disiplin dalam kegiatan sehari-harinya, mulai dari merapikan tempat tidur, makan dengan rapi, menyikat gigi, hingga membereskan mainan. Kedisiplinan Zidan membuatnya memiliki hidup yang teratur dan menyenangkan. Namun, suatu hari Zidan merasa malas dan mengabaikan kebiasaan baiknya. Akibatnya, ia merasakan konsekuensi yang tidak nyaman: gigi yang sakit dan mainan yang hilang. Dari pengalaman ini, Zidan menyadari bahwa disiplin adalah kunci untuk hidup rapi, sehat, dan bahagia. Cerita ini memiliki target pembaca balita dan bertujuan untuk mengajarkan pentingnya tanggung jawab dan kebiasaan baik sejak usia dini.',
                'cover' => 'https://is3.cloudhost.id/bukucerita/cover/zidan.png',
                'link' => 'https://gemini.google.com/share/be3e8bc2b0bc',
                'youtube_link' => 'https://www.youtube.com/watch?v=0fN7nUutEkY',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'edukatif')->first()?->id ?? $categories->first()->id,
                'user_id' => $azmiUser?->id ?? $users->first()->id,
                'age_min' => 3,
                'age_max' => 12,
                'views' => 10,
            ],
            [
                'judul' => 'Petualangan Gigi Melawan Si Kuman',
                'slug' => \App\Models\Book::generateSlug('Petualangan Gigi Melawan Si Kuman'),
                'pengarang' => 'Fauzan Azmi',
                'sinopsis' => 'Cerita ini menceritakan tentang Gigi, gigi kecil yang ceria dan suka tersenyum, yang tinggal di dalam Mulut Ajaib yang hangat. Suatu hari, kedamaian Gigi terganggu oleh kedatangan Si Kuman dan Geng Kuman, sekelompok bakteri jahat yang lengket dan asam, yang ingin berpesta sisa makanan dan membuat Gigi menjadi kusam. Tepat saat Gigi merasa lemah dan hampir menyerah, muncul pahlawan penyelamat: Super Sikat, Sikat Gigi Pemberani!. Dengan busa ajaibnya dan gerakan menggosok yang lincah, Super Sikat membersihkan semua permukaan Gigi. Si Kuman dan gengnya menjerit ketakutan karena tidak suka disikat, dan akhirnya terlempar keluar dari Mulut Ajaib. Gigi pun kembali putih, kuat, dan bersinar, sambil tersenyum lebar. Pesan penting dari cerita ini adalah agar anak-anak selalu menggosok gigi pagi dan malam, supaya Gigi tetap sehat dan Si Kuman tidak berani kembali.',
                'cover' => 'https://is3.cloudhost.id/bukucerita/cover/gigi.png',
                'link' => 'https://gemini.google.com/share/6aa9ab89f9ed',
                'youtube_link' => 'https://www.youtube.com/watch?v=0fN7nUutEkY',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'dongeng')->first()?->id ?? $categories->first()->id,
                'user_id' => $azmiUser?->id ?? $users->first()->id,
                'age_min' => 3,
                'age_max' => 6,
                'views' => 10,
            ],
        ];

        foreach ($sampleBooks as $book) {
            \App\Models\Book::create($book);
        }
    }
}

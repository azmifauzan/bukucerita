<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'pengarang' => 'Fauzan Azmi',
                'sinopsis' => 'Aira mendapat hadiah biji bunga dari Kakeknya. Dengan penuh semangat, ia menanam dan merawatnya setiap hari. Namun, ketika bunga tak kunjung tumbuh, Aira merasa kecewa. Kakek pun mengajarkannya bahwa bunga membutuhkan waktu dan kesabaran. Aira pun belajar menyiram, merawat, dan menunggu dengan sabar. Hingga akhirnya, tunas kecil muncul dan tumbuh menjadi bunga besar nan indah. Dari pengalaman itu, Aira memahami bahwa kesabaran selalu menghadirkan kebahagiaan dan keindahan.',
                'cover' => 'https://i.ibb.co.com/s9rWkrHV/Screenshot-2025-09-26-225856.png',
                'link' => 'https://gemini.google.com/share/9433d7beed08',
                'youtube_link' => 'https://www.youtube.com/watch?v=gS_6-ov447U',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'edukatif')->first()?->id ?? $categories->first()->id,
                'user_id' => $azmiUser?->id ?? $users->first()->id,
                'age_min' => 3,
                'age_max' => 12,
                'views' => 0,
            ],
            [
                'judul' => 'Putri Bulan dan Bintang-Bintang',
                'pengarang' => 'AI Gemini',
                'sinopsis' => 'Dongeng tentang seorang putri yang tinggal di bulan dan berteman dengan bintang-bintang. Mengajarkan tentang kebaikan dan kasih sayang.',
                'cover' => 'https://picsum.photos/400/600?random=2',
                'link' => 'https://gemini.google.com/share/d4f8e2a6b9c1',
                'youtube_link' => null,
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'dongeng')->first()?->id ?? $categories->first()->id,
                'user_id' => $users->first()->id,
                'age_min' => 3,
                'age_max' => 7,
                'views' => 89,
            ],
            [
                'judul' => 'Belajar Angka dengan Gajah Cerdas',
                'pengarang' => 'AI Gemini',
                'sinopsis' => 'Gajah cerdas mengajarkan angka 1-10 kepada teman-teman hewan di savana. Cerita edukatif yang menyenangkan untuk belajar matematika dasar.',
                'cover' => 'https://picsum.photos/400/600?random=3',
                'link' => 'https://gemini.google.com/share/7a5b3c9d2e4f',
                'youtube_link' => 'https://youtu.be/9bZkp7q19f0',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'edukatif')->first()?->id ?? $categories->first()->id,
                'user_id' => $users->first()->id,
                'age_min' => 4,
                'age_max' => 6,
                'views' => 203,
            ],
        ];

        foreach ($sampleBooks as $book) {
            \App\Models\Book::create($book);
        }
    }
}

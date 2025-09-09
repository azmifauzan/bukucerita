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

        if ($categories->isEmpty() || $users->isEmpty()) {
            return;
        }

        $sampleBooks = [
            [
                'judul' => 'Petualangan Kancil di Hutan Ajaib',
                'pengarang' => 'AI Gemini',
                'sinopsis' => 'Kancil yang cerdik bertualang di hutan ajaib dan bertemu dengan berbagai teman baru. Cerita ini mengajarkan tentang kecerdikan dan persahabatan.',
                'cover' => 'https://picsum.photos/400/600?random=1',
                'link' => 'https://notebooklm.google.com/notebook/sample-1',
                'status' => 'approved',
                'category_id' => $categories->where('slug', 'petualangan')->first()?->id ?? $categories->first()->id,
                'user_id' => $users->first()->id,
                'age_min' => 4,
                'age_max' => 8,
                'views' => 150,
            ],
            [
                'judul' => 'Putri Bulan dan Bintang-Bintang',
                'pengarang' => 'AI Gemini',
                'sinopsis' => 'Dongeng tentang seorang putri yang tinggal di bulan dan berteman dengan bintang-bintang. Mengajarkan tentang kebaikan dan kasih sayang.',
                'cover' => 'https://picsum.photos/400/600?random=2',
                'link' => 'https://notebooklm.google.com/notebook/sample-2',
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
                'link' => 'https://notebooklm.google.com/notebook/sample-3',
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

        // Create additional random books
        \App\Models\Book::factory(15)->create([
            'category_id' => fn() => $categories->random()->id,
            'user_id' => fn() => $users->random()->id,
        ]);
    }
}

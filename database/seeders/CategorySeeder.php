<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Petualangan',
                'slug' => 'petualangan',
                'description' => 'Cerita seru tentang petualangan dan eksplorasi dunia'
            ],
            [
                'name' => 'Dongeng',
                'slug' => 'dongeng',
                'description' => 'Dongeng klasik dan modern yang menghibur'
            ],
            [
                'name' => 'Edukatif',
                'slug' => 'edukatif',
                'description' => 'Cerita yang mengajarkan nilai-nilai dan pengetahuan'
            ],
            [
                'name' => 'Fantasi',
                'slug' => 'fantasi',
                'description' => 'Dunia magis penuh dengan makhluk fantasi'
            ],
            [
                'name' => 'Persahabatan',
                'slug' => 'persahabatan',
                'description' => 'Cerita tentang persahabatan dan kebersamaan'
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

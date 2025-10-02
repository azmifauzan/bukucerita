<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Petualangan' => 'Cerita seru tentang petualangan dan eksplorasi',
            'Dongeng' => 'Dongeng klasik dan modern untuk anak-anak',
            'Edukatif' => 'Cerita yang mengajarkan nilai-nilai dan pengetahuan',
            'Fantasi' => 'Dunia magis dan makhluk fantasi',
            'Persahabatan' => 'Cerita tentang persahabatan dan kebersamaan',
        ];

        $categoryName = fake()->randomElement(array_keys($categories));

        return [
            'name' => $categoryName,
            'slug' => \Illuminate\Support\Str::slug($categoryName),
            'description' => $categories[$categoryName],
        ];
    }
}

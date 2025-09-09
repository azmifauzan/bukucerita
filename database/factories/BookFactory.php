<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'pengarang' => fake()->name(),
            'sinopsis' => fake()->paragraph(3),
            'cover' => 'https://picsum.photos/400/600?random=' . fake()->numberBetween(1, 100),
            'link' => 'https://notebooklm.google.com/notebook/' . fake()->uuid(),
            'status' => fake()->randomElement(['approved', 'pending', 'draft']),
            'category_id' => \App\Models\Category::factory(),
            'user_id' => \App\Models\User::factory(),
            'views' => fake()->numberBetween(0, 1000),
            'age_min' => fake()->numberBetween(3, 5),
            'age_max' => fake()->numberBetween(6, 12),
        ];
    }
}

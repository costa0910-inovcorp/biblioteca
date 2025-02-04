<?php

namespace Database\Factories;

use App\Models\Publisher;
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
            //
            'id' => $this->faker->uuid(),
            'isbn' => $this->faker->isbn13(),
            'name' => $this->faker->name(),
            'bibliography' => $this->faker->text(),
            'cover_image' => $this->faker->imageUrl(),
            'price' => $this->faker->numberBetween(100, 500),
            'publisher_id' => Publisher::factory(),
        ];
    }
}

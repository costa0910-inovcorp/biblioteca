<?php

namespace Database\Factories;

use App\Enums\RolesEnum;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookRequest>
 */
class BookRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $book = Book::factory()->create();
        $book->is_available = false;
        $user = User::factory()->create();
        $user->assignRole(RolesEnum::CITIZEN);
        return [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->name,
        ];
    }
}

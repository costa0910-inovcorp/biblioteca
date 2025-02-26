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
        $user->books_request_count++;

        $user->save();
        $book->save();
        return [
            'book_id' => $book->id,
            'user_id' => $user->id,
            'is_reviewed' => false,
            'predicted_return_date' => now()->addDays(5),
            'return_date' => null,
            'user_email' => $user->email,
            'user_name' => $user->name,
        ];
    }
}

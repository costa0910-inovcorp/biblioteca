<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RequestBook extends Component
{
    public array $availableToBorrow = [];
    public array $booksToBorrow = [];

    public function mount(): void
    {
        $this->availableToBorrow = Book::query()
            ->get()
            ->take(5)
            ->toArray();
    }


    public function borrow(): void {
        $maxToBorrow = 3 - auth()->user()->books_request_count; //Max 3 books
        $this->validate(rules: [
            'booksToBorrow' => "required|array|min:1|max:$maxToBorrow",
        ], messages: [
            'booksToBorrow.required' => 'You must select at least one book to borrow.',
            'booksToBorrow.min' => 'You must select at least one book.',
            'booksToBorrow.max' => 'You can only borrow up to 3 books.',
        ]);


        dd($this->booksToBorrow);
    }

    public function add(string $bookId): void
    {
        $book = Book::findOrFail($bookId);

        $this->booksToBorrow[] = [
            'user_id' => auth()->user()->id,
            'book' => $book
        ];
    }

    public function render()
    {
        return view('livewire.request-book');
    }
}

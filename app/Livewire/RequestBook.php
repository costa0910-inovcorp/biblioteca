<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RequestBook extends Component
{
    public array $availableToBorrow = [];
    public array $booksToBorrow = [];

    public string $searchBookByName = '';

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
        $book = Book::findOrFail($bookId)->toArray();

        $this->booksToBorrow[] = $book;
        $this->availableToBorrow = $this->filterBooks($this->availableToBorrow, $bookId);
    }

    public function remove(string $bookId): void
    {
        $books = array_filter($this->booksToBorrow, function ($item) use ($bookId) {
            return $item['id'] == $bookId;
        });
        $this->booksToBorrow = $this->filterBooks($this->booksToBorrow, $bookId);
        $this->availableToBorrow[] = array_pop($books);
    }

    protected function filterBooks($collection, string $bookId): array
    {
        return collect($collection)->filter(function ($book) use ($bookId) {
            return $book['id'] != $bookId;
        })->toArray();
    }

    public function render()
    {
        if (empty($this->searchBookByName)) {
            $this->availableToBorrow = Book::query()
                ->where('is_available', true)
                ->get()
                ->take(5)
                ->toArray();
        } else {
            $this->availableToBorrow = Book::query()
                ->where('is_available', true)
                ->where('name', 'like', '%' . $this->searchBookByName . '%')
                ->get()
                ->take(5)
                ->toArray();
        }

        //filter out book that already added
        $this->availableToBorrow = array_filter($this->availableToBorrow, function ($item) {
            return !collect($this->booksToBorrow)
                ->pluck('id')
                ->contains($item['id']);
        });
//        dd($this->availableToBorrow);

        return view('livewire.request-book');
    }
}

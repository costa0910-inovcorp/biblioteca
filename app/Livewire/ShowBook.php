<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowBook extends Component
{
    public Book $book;

    public function mount(Book $book)
    {
        $this->book = $book;
    }

    #[On('book-returned')]
    public function returnBook() {
        $this->book->refresh();
    }

    public function render()
    {
        return view('livewire.show-book', [
            'bookRequests' => $this->book->requests()->latest()->paginate(3),
        ])->layout('layouts.app');
    }
}

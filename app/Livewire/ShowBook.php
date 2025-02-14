<?php

namespace App\Livewire;

use App\Livewire\Forms\ReturnRequestMethod;
use App\Models\Book;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBook extends Component
{
    use ReturnRequestMethod, WithPagination;

    public Book $book;

    public function mount(Book $book)
    {
        $this->book = $book;
    }

    #[On('book-returned')]
    public function returnBook(): void {
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.show-book', [
            'bookRequests' => $this->book->requests()->latest()->paginate(3),
        ])->layout('layouts.app');
    }
}

<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class ShowBook extends Component
{
    use WithoutUrlPagination;

    public Book $book;

    public function mount(Book $book)
    {
        $this->book = $book;
    }

    //TODO: THIS SUPPOSE TO LISTEN TO THIS CHILD EVENT WHEN BOOK RETURN,
    // THEN REFRESH TO SHOW THAT THE BOOK IS AVAILABLE,
    // BUT IS NOT WORKING AS INTENDED,
    // SAME PROBLEM AS USER'S SHOWN POST ON REQUEST-BOOKS ENDPOINT
//    #[On('book-returned')]
//    public function returnBook() {
//        $this->dispatch('refresh');
//    }

    public function render()
    {
        return view('livewire.show-book', [
            'bookRequests' => $this->book->requests()->latest()->paginate(3),
        ])->layout('layouts.app');
    }
}

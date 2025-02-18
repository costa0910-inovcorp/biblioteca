<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PublicBooks extends Component
{
    use WithPagination;
//    protected $books;
//
//    #[On('search-box')]
//    public function updateBook($results)
//    {
//        dd($results);
//        $this->books = $results;
////        $this->dispatch('ref')
//    }

    public function render()
    {
        $books = Book::query()->paginate(8);

        return view('livewire.public-books', compact('books'));
    }
}

<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class PublicBooks extends Component
{
    use WithPagination;


    public function render()
    {
        $books = Book::query()->paginate(8);

        return view('livewire.public-books', compact('books'));
    }
}

<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Books extends Component
{
    /** @var Book[] */
    public Collection|null $books = null;

    public array $booksHeader = ['Nome', 'ISBN', 'Bibliografia', 'Preço'];

    public function mount():void {
        $this->books = Book::all()->sortBy('name');
    }

    public function render()
    {
        return view('livewire.books');
    }
}

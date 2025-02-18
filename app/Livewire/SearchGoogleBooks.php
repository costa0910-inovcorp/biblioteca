<?php

namespace App\Livewire;

use App\Repositories\SearchGoogleBooksRepository;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchGoogleBooks extends Component
{
//    private SearchGoogleBooksRepository $searchGoogleBooks;

    #[Url(as: 'q')]
    public string $search;

    /**
     * @param  SearchGoogleBooks  $searchGoogleBooks
     * @return void
     */
//Not working as intended
//    public function mount(SearchGoogleBooksRepository $searchGoogleBooks)
//    {
////        $this->searchGoogleBooks = $searchGoogleBooks;
////        $this->searchGoogleBooks = app(SearchGoogleBooksRepository::class);
////        dd($this->searchGoogleBooks);
//    }

    public function searchBooks()
    {
//        dd($this->searchGoogleBooks);
        $this->validate(['search' => 'required']);
        $searchGoogleBooks = app(SearchGoogleBooksRepository::class);
        $books = $searchGoogleBooks->searchFromGoogleBooks($this->search);
        dd($books);
    }

    public function render()
    {
        return view('livewire.search-google-books')->layout('layouts.app');
    }
}

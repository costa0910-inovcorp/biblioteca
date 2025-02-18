<?php

namespace App\Livewire;

use App\Repositories\SearchGoogleBooksRepository;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SearchGoogleBooks extends Component
{
//    private SearchGoogleBooksRepository $searchGoogleBooks;
    protected array $searchResult = [];

    #[Url(as: 'q')]
    public string $search;
    protected int $itemsPosition = 0;
    #[Validate('required|max:40|min:5')]
    public int $pageSize = 5;

    public bool $isActualPageBooksSaved = false;

    //TODO: RESET ITEM POSITION WHEN PAGE SIZE CHANGE(ON UPDATE HOOK)
    //TODO: UPDATE $isActualPageBooksSaved TO BE ARRAY SO CAN ADD PAGE NUMBER THAT'S ALREADY SAVED


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
        $this->itemsPosition = 0;
        $this->validate(['search' => 'required']);
        $this->fetchBooks();
//        $this->itemPosition+= $this->pageSize;
    }

    public function nextPage(): void
    {
        if ($this->searchResult['totalItems'] > $this->itemsPosition + $this->pageSize) {
            //TODO: FETCH NEXT PAGE
            $this->fetchBooks();
            $this->itemsPosition += $this->pageSize;
        }
    }

    public function previousPage(): void
    {
        if ($this->itemsPosition - $this->pageSize >= 0) {
            //TODO: GO BACK TO PREV PAGE
            $this->fetchBooks();
            $this->itemsPosition -= $this->pageSize;
        }
    }

    public function saveBooks(): void {


        $this->isActualPageBooksSaved = true;
    }

    protected function fetchBooks(): void
    {
        $searchGoogleBooks = app(SearchGoogleBooksRepository::class);
        $this->searchResult = $searchGoogleBooks->searchFromGoogleBooks($this->search, $this->itemsPosition, $this->pageSize);
        $this->isActualPageBooksSaved = false;
    }

    public function render()
    {
        return view('livewire.search-google-books', [
            'books' => $this->searchResult['items'],
        ])->layout('layouts.app');
    }
}

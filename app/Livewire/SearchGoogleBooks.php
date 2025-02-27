<?php

namespace App\Livewire;

use App\Events\SaveBooksToDB;
use App\Repositories\LogRepository;
use App\Repositories\SearchGoogleBooksRepository;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SearchGoogleBooks extends Component
{
//    private SearchGoogleBooksRepository $searchGoogleBooks;
    public array $searchResult = [];

    #[Url(as: 'q')]
    public string $search;
    public int $itemsPosition = 0;
    #[Validate('required|max:40|min:5')]
    #[Url(as: 'ps')]
    public int $pageSize = 5;

    public string $errorMessage = '';
//    public bool $isActualPageBooksSaved = false;

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

    public function updating($property, $value): void
    {
        //Reset startIndex, return items from the start
        if ($property === 'pageSize') {
            if ($value >= 5 && $value <= 40) {
                $this->pageSize = $value;
                $this->itemsPosition = 0;
            }
        }
    }

    public function searchBooks()
    {
        $this->itemsPosition = 0;
        $this->validate(['search' => 'required']);
        $this->fetchBooks();
    }

    public function getPage(int $page) {
        $this->itemsPosition = $this->pageSize * ($page - 1);
        $this->fetchBooks();
    }

    private function pageNumbers(): array {
        //Add 1 because page count start on 0


        if (empty($this->searchResult)) {
            return [];
        }

        $page = $this->itemsPosition / $this->pageSize;
        $total = $this->searchResult['totalItems'];

        if ($page == 0) {
//            dd($this->searchResult, $total, $this->itemsPosition, $this->pageSize, $page);
            return [
                'currentPage' => ++$page, //pages start on zero
                'totalItems' => $total,
                'prevPage' => null,
                'nextPage' => ++$page,
                'pageSize' => $this->pageSize,
            ];
        }

        $prevNum = $page - 1;
        $nextNum = $page + 1;
        $maxItems = $this->itemsPosition * $nextNum;
//        dd([
//            'currentPage' => $page,
//            'totalItems' => $total,
//            'prevPage' => $prevNum,
//            'nextPage' => $nextNum,
//            'maxItems' => $maxItems,
//            'm' => $total - $maxItems,
//        ]);

        if ($total - $maxItems <= 0 && abs($total - $maxItems) >= $this->pageSize) {
            return [
                'currentPage' => ++$page,
                'totalItems' => $total,
                'prevPage' => ++$prevNum,
                'nextPage' => null,
                'pageSize' => $this->pageSize,
            ];
        }

        return [
            'currentPage' => ++$page,
            'totalItems' => $total,
            'prevPage' => ++$prevNum,
            'nextPage' => ++$nextNum,
            'pageSize' => $this->pageSize,
        ];
    }

    public function nextPage(): void
    {
        if ($this->search && ($this->searchResult['totalItems'] >= $this->itemsPosition + $this->pageSize)) {
            //TODO: FETCH NEXT PAGE
            $this->itemsPosition += $this->pageSize;
            $this->fetchBooks();
        }
    }

    public function previousPage(): void
    {
        if ($this->search && ($this->itemsPosition - $this->pageSize >= 0)) {
            //TODO: GO BACK TO PREV PAGE
            $this->itemsPosition -= $this->pageSize;
            $this->fetchBooks();
        }
    }

    public function saveBooks(LogRepository $logRepository): void {
        //TODO: Do something before dispatch event to save books
        $userId = auth()->id();
        $newProcessId = Str::uuid()->toString();
        SaveBooksToDB::dispatch($userId, $this->searchResult['items'], $newProcessId);
        $this->dispatch('save-books-to-db-start', data: [
            'status' => 'START',
            'totalBooks' => count($this->searchResult['items']),
            'id' => $newProcessId,
        ]);
        $logRepository->addRequestAction([
            'object_id' => 'process id: ' . $newProcessId,
            'app_section' => 'SearchGoogleBooks livewire component action saveBooks',
            'alteration_made' => 'it dispatch (SaveBooksToDB) event, it\'s will create passed books to database: ' . count($this->searchResult['items'])
        ]);
//        $this->isActualPageBooksSaved = true;
    }

    public function tryAgain(): void
    {
        $this->fetchBooks(); //Keep prev state, query,items to return...
    }

    protected function fetchBooks(): void
    {
        $searchGoogleBooks = app(SearchGoogleBooksRepository::class);
        $result = $searchGoogleBooks->searchFromGoogleBooks($this->search, $this->itemsPosition, $this->pageSize);
        if ($result['isSuccess']) {
            $this->searchResult = $result['books'];
            $this->errorMessage = '';
        } else {
            $this->searchResult = [];
            $this->errorMessage = $result['message'];
        }
    }

    public function render()
    {
        return view('livewire.search-google-books', [
            'books' => empty($this->searchResult) ? [] : $this->searchResult['items'],
            'pages' => $this->pageNumbers(),
        ])->layout('layouts.app');
    }
}

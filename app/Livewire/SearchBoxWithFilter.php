<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchBoxWithFilter extends Component
{
    public string $queryTable;
    #[Url(as: 'search')]
    public ?string $searchTerm = null;

    #[Url(as: 'by')]
    public string $filterBy = 'all';

//    public function mount(string $queryTable)
//    {
//        $this->queryTable = $queryTable;
//    }

    public function filterOrSearch() {
        $results = $this->queryTable();
        $this->dispatch('search-box', ['results' => $results]);
    }

    protected function queryTable() {
        if (!$this->queryTable) {
            abort(404, 'Query table not found');
        }

       if ($this->searchTerm) {
           return match ($this->queryTable) {
               'book' => $this->query('books')
                   ->whereAny(['name', 'bibliography'], 'like', '%' . $this->searchTerm . '%')
                   ->get(),
               'book_request_user' => $this->query('book_requests')
                   ->whereAny(['user_name', 'user_email'], 'like', '%' . $this->searchTerm . '%')->get(),
               'book_request' => $this->query('book_requests')
                   ->whereHas('book', function ($query) {
                   $query->whereAny(['name', 'bibliography'], 'like', '%' . $this->searchTerm . '%')->get();
               }),
               default => $this->queryTable,
           };
       }

        return match ($this->queryTable) {
            'book' => $this->query('books')->get(),
            'book_request_user, book_request' => $this->query('book_requests')->get(),
            default => $this->queryTable,
        };
    }

    public function render()
    {
        return view('livewire.search-box-with-filter');
    }

    private function query(string $string)
    {
        if ($string == 'books') {
            return match ($this->filterBy) {
                'not-returned' =>  DB::table($string)->where('is_available', false),
                'returned' =>  DB::table($string)->where('is_available', true),
                default => DB::table($string),
            };
        }
        return match ($this->filterBy) {
            'not-returned' =>  DB::table($string)->whereNull('return_date'),
            'returned' =>  DB::table($string)->whereNotNull('return_date'),
            default => DB::table($string),
        };
    }
}

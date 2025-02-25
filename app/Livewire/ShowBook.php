<?php

namespace App\Livewire;

use App\Livewire\Forms\ReturnRequestMethod;
use App\Models\Book;
use App\Repositories\RelevantBooksRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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
            'bookRequests' => $this->getRequestsBaseOnPermission(),
            'relevantBooks' => $this->relatedBooks(),
        ])->layout('layouts.app');
    }
    protected function getRequestsBaseOnPermission(): LengthAwarePaginator
    {
        if (auth()->user()->can('view all requests')) {
            return $this->book->requests()->with(['user'])->latest()->paginate(3);
        } else {
            return $this->book->requests()
                ->where('user_id', auth()->id())
                ->with(['user'])->latest()->paginate(3);
        }
    }

    protected function relatedBooks(): array
    {
        $repository = app(RelevantBooksRepository::class);
        return $repository->getSimilarBooks($this->book);
    }
}

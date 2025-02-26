<?php

namespace App\Livewire;

use App\Events\BookRequested;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\BookWaitList;
use App\Models\User;
use App\Repositories\RequestBookRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class RequestBook extends Component
{
    public array $availableToBorrow = [];
    public array $booksToBorrow = [];

    public string $searchBookByName = '';

    public int $maxToBorrow = 0;
    protected const LIMIT_TO_BORROW = 3;

    public function mount()
    {
        $this->maxToBorrow = self::LIMIT_TO_BORROW - auth()->user()->books_request_count;
    }

    public function borrow(RequestBookRepository $repository): void {
        $this->validate(rules: [
            'booksToBorrow' => "required|array|min:1|max:$this->maxToBorrow",
        ], messages: [
            'booksToBorrow.required' => 'You must select at least one book to borrow.',
            'booksToBorrow.min' => 'You must select at least one book.',
            'booksToBorrow.max' => $this->maxToBorrow ?
                "You can only borrow up to $this->maxToBorrow books at a time." :
                "You are not allowed to borrow books.",
        ]);

        $toBorrow = array_filter($this->booksToBorrow, function($book) {
            return $book['is_available'];
        });

        $forWaitList = array_filter($this->booksToBorrow, function($book) {
            return $book['is_available'] == false;
        });

        if (!empty($toBorrow)) {
            $this->maxToBorrow = $repository->borrowBooks($toBorrow);
            $this->dispatch('books-borrowed');
        }

        if (!empty($forWaitList)) {
            $repository->addBooksToWaitList($forWaitList);
            //TODO: DISPATCH EVENT FOR WAIT LIST COMPONENT
        }

        $this->reset('searchBookByName', 'booksToBorrow');
    }

    public function add(string $bookId): void
    {
        $book = Book::findOrFail($bookId)->toArray();

        $this->booksToBorrow[] = $book;
        $this->availableToBorrow = $this->filterBooks($this->availableToBorrow, $bookId);
    }

    public function remove(string $bookId): void
    {
        $books = array_filter($this->booksToBorrow, function ($item) use ($bookId) {
            return $item['id'] == $bookId;
        });
        $this->booksToBorrow = $this->filterBooks($this->booksToBorrow, $bookId);
        $this->availableToBorrow[] = array_pop($books);
    }

    protected function filterBooks($collection, string $bookId): array
    {
        return collect($collection)->filter(function ($book) use ($bookId) {
            return $book['id'] != $bookId;
        })->toArray();
    }
    #[On('book-returned')]
    public function updateMaxBorrow($id) {
        if ($id == auth()->id()) {
            //if i's same user, update it's max books to borrow
            $user = User::query()->findOrFail($id);
            $this->maxToBorrow = self::LIMIT_TO_BORROW - $user->books_request_count;
        }
    }

    protected function getAvailableBooksToBorrowOrAddToWaitList(): Builder
    {
        $inWaitList = BookWaitList::query()
            ->where('user_id', auth()->id())
            ->pluck('book_id')->toArray();

        return Book::query()->whereNotIn('id', $inWaitList);
    }

    public function render()
    {
        if (empty($this->searchBookByName)) {
            $this->availableToBorrow = $this->getAvailableBooksToBorrowOrAddToWaitList()
                ->get()
                ->take(5)
                ->toArray();
        } else {
            $this->availableToBorrow = $this->getAvailableBooksToBorrowOrAddToWaitList()
                ->where('name', 'like', '%' . $this->searchBookByName . '%')
                ->get()
                ->take(5)
                ->toArray();
        }

        //filter out book that already added
        $this->availableToBorrow = array_filter($this->availableToBorrow, function ($item) {
            return !collect($this->booksToBorrow)
                ->pluck('id')
                ->contains($item['id']);
        });

        return view('livewire.request-book');
    }
}

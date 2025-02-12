<?php

namespace App\Livewire;

use App\Events\BookRequested;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use function Pest\Laravel\get;

class RequestBook extends Component
{
    public array $availableToBorrow = [];
    public array $booksToBorrow = [];

    public string $searchBookByName = '';

    public int $maxToBorrow = 0;
    protected const LIMIT_TO_BORROW = 10;

    public function mount()
    {
        $this->maxToBorrow = self::LIMIT_TO_BORROW - auth()->user()->books_request_count;
    }

    public function borrow(): void {
        $this->validate(rules: [
            'booksToBorrow' => "required|array|min:1|max:$this->maxToBorrow",
        ], messages: [
            'booksToBorrow.required' => 'You must select at least one book to borrow.',
            'booksToBorrow.min' => 'You must select at least one book.',
            'booksToBorrow.max' => $this->maxToBorrow ?
                "You can only borrow up to $this->maxToBorrow books at a time." :
                "You are not allowed to borrow books.",
        ]);


        DB::transaction(function() {
            $authUser = auth()->user();

            foreach ($this->booksToBorrow as $book) {
                $request = BookRequest::create([
                    //TODO: ask nuno if to let user choose return date and if to emit only one event
                    'book_id' => $book['id'],
                    'user_id' => $authUser->id,
                    'user_name' => $authUser->name,
                    'user_email' => $authUser->email,
                ]);

                Book::where('id', $book['id'])->update([
                    'is_available' => false,
                ]);

                //TODO: emit event, that's request has been made
                BookRequested::dispatch($request);
            }

            $user = User::query()->where('id', $authUser->id)->first();
            $user->books_request_count += count($this->booksToBorrow);
            $user->save();


            $this->maxToBorrow = self::LIMIT_TO_BORROW - $user->books_request_count;
        });
        $this->reset('booksToBorrow');
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

    public function render()
    {
//        dd(BookRequest::query()->where('user_id', auth()->id())->get()->toArray());
        if (empty($this->searchBookByName)) {
            $this->availableToBorrow = Book::query()
                ->where('is_available', true)
                ->get()
                ->take(5)
                ->toArray();
        } else {
            $this->availableToBorrow = Book::query()
                ->where('is_available', true)
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
//        dd(auth()->user()->books_request_count);
//        $this->maxToBorrow = $this->allowToBorrow(auth()->user()->books_request_count);

        return view('livewire.request-book');
    }
}

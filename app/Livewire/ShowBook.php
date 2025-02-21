<?php

namespace App\Livewire;

use App\Livewire\Forms\ReturnRequestMethod;
use App\Models\Book;
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
            'relevantBooks' => $this->getRelevantBooks(),
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

    protected function getRelevantBooks(): array
    {
        if ($this->book->bibliography && $this->book->name) {
            $arrByDesc = $this->appearanceInDescription($this->book->bibliography);
            $arrByName = $this->appearanceInDescription($this->book->name, false);
            $arrBooks = $this->mergeByCount($arrByDesc, $arrByName);
        }
        elseif ($this->book->bibliography) {
            $arrBooks = $this->appearanceInDescription($this->book->bibliography);
        } else {
            $arrBooks = $this->appearanceInDescription($this->book->name, false);
        }

        if (empty($arrBooks)) {
            return [];
        }

        $books = collect($arrBooks);

        return $books->sortByDesc(function ($book) {
            return $book['count'];
        })->take(10)
            ->map(fn ($arr) => $arr['book'])
            ->toArray();
    }

    private function mergeByCount(array $arrByDesc, array $arrByName)
    {
        $merge = [];
        foreach ($arrByDesc as $arr) {
            $contName = $arrByName[$arr['book']->id];
            $merge[] = [
                'count' => $arr['count'] + $contName['count'],
                'book' => $arr['book'],
            ];
        }

        return $merge;
    }

    protected function appearanceInDescription(?string $word, bool $desc= true): array
    {
        if (is_null($word)) {
            return [];
        }

        $booksWithAppearanceCount = [];

        $allBooks = $this->getBooks();
        foreach ($allBooks as $book) {
            if ($book->bibliography && $desc) {
                $descCount = $this->wordsInFirstString($word, $book->bibliography);
            } else {
                $descCount = $this->wordsInFirstString($word, $book->name);
            }

            $item = ['count' => $descCount, 'book' => $book];
            $booksWithAppearanceCount[$book->id] = $item;
        }
        return $booksWithAppearanceCount;
    }

    protected function wordsInFirstString(string $firstString, string $secondString): int
    {
        $wordsIn = 0;
        $secondStringWords = $this->returnWordsOfString($secondString);
        $passedWords = [];

        foreach ($secondStringWords as $secondStringWord) {
            $isPassed = in_array($secondStringWord, $passedWords);
            if (str_contains($firstString, $secondStringWord) && !$isPassed) {
                $passedWords[] = $secondStringWord;
                $wordsIn++;
            }
        }

        return $wordsIn;
    }

    protected function returnWordsOfString(string $string): array {
        return explode(' ', strtolower($string));
    }

    protected function getBooks(): Collection
    {
        return Book::query()->whereNot('id', $this->book->id)->get();
    }
}

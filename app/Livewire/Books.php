<?php

namespace App\Livewire;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Books extends Component
{
    use WithPagination;

    #[url(as: 'q')]
    public ?string $search = null;
    public string $selectedField = 'name'; // Default field to search by
    public array $fields = ['name', 'bibliography', 'author', 'publisher'];
    public int $pageSize = 5;
    public $alpineData = [];
    public array $booksHeader = [
        ['field' => 'Name', 'sort' => true, 'col' => 'name'],
        ['field' => 'ISBN', 'sort' => false, 'col' => 'isbn'],
        ['field' => 'Bibliografia', 'sort' => false, 'col' => 'bibliography'],
        ['field' => 'Editoras', 'sort' => true, 'col' => 'publisher'],
        ['field' => 'Preço', 'sort' => true, 'col' => 'price'],
        ['field' => 'Autores', 'sort' => false, 'col' => 'author'],
    ];

    public function deleteBook(Book $book): void {
        DB::transaction(function () use ($book) {
            $book->delete();
            Storage::delete($book->cover_image);
        });
    }
    public function render()
    {
        $books = Book::query();

        if ($this->search) {
            $this->resetPage();
            $books = $this->searchBooks();
        } else {
            $books = Book::with(['publisher', 'authors'])->orderBy('name')->paginate($this->pageSize);
        }

        // set data for alpine
        $this->alpineData = $books->toArray()['data'];
        return view('livewire.books', [
            'books' => $books,
        ]);
    }

    protected function searchBooks()  {
        return match ($this->selectedField) {
            'publisher' => $this->queryNested('publisher'),
            'author' => $this->queryNested('authors'),
            default =>  Book::query()->with(['publisher', 'authors'])
            ->where($this->selectedField, 'like', '%' . $this->search . '%')
            ->orderBy('name')->paginate($this->pageSize),
        };
    }

    //TODO: make this func generic to use in other component
    protected function queryNested(string $table)  {
        return Book::query()->with(['publisher', 'authors'])
            ->whereHas($table, function ($q)  {
                $q->where('name', 'like', '%' . $this->search . '%');
            })->orderBy('name')->paginate($this->pageSize);
    }
}

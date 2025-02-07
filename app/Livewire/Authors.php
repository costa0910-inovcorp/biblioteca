<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Authors extends Component
{
    use WithPagination;

    #[url(as: 'q')]
    public ?string $search = null;
    public int $pageSize = 5;
    public string $selectedField = 'name'; // Default field to search by
    public array $fields = ['name', 'books'];

    public array $authorsHeader = [
        ['field' => 'Nome', 'sort' => true, 'col' => 'name'],
        ['field' => 'Livros', 'sort' => false],
    ];

    public array $alpineData = [];

    public function render()
    {
        if ($this->search) {
            $this->resetPage();

            if ($this->selectedField === 'name') {
                $authors = Author::query()->with(['books'])
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->paginate($this->pageSize);
            } else {
                $authors = $this->queryNested('books');
            }
        } else {
            $authors = Author::query()
                ->with(['books'])
                ->paginate($this->pageSize);
        }

        $this->alpineData = $authors->toArray()['data'];
        return view('livewire.authors', ['authors' => $authors]);
    }

    public function deleteAuthor(Author $author): void {
        DB::transaction(function () use ($author) {
            Storage::delete($author->photo);
            $author->delete();
        });
    }

    protected function queryNested(string $table)  {
        return Author::query()->with([$table])
            ->whereHas($table, function ($q)  {
                $q->where('name', 'like', '%' . $this->search . '%');
            })->paginate($this->pageSize);
    }
}

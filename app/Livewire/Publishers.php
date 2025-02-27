<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Publisher;
use App\Repositories\LogRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Publishers extends Component
{
    use WithPagination;

    #[url(as: 'q')]
    public ?string $search = null;
    public int $pageSize = 5;
    public array $publishersHeader = [
        ['field' => 'Name', 'sort' => true, 'col' => 'name'],
        ['field' => 'Livros', 'sort' => false],
    ];

    public $alpineData = [];

    public function deletePublisher(Publisher $publisher, LogRepository $logRepository)
    {
      // include all relate books
        DB::transaction(function () use ($publisher) {
            Storage::delete($publisher->logo);
            $publisher->delete();
        });

        $logRepository->addRequestAction([
            'object_id' => $publisher->id,
            'app_section' => 'Publisher livewire component deletePublisher',
            'alteration_made' => 'delete publisher'
        ]);
    }
    public function render()
    {
//        $publishers = Publisher::query();
        if ($this->search) {
            $this->resetPage();
            $publishers = Publisher::query()->with(['books'])
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate($this->pageSize);
        } else {
            $publishers = Publisher::query()
                ->with(['books'])->paginate($this->pageSize);
        }

        $this->alpineData = $publishers->toArray()['data'];
//        dd($publishers->toArray());
        return view('livewire.publishers', [
            'publishers' => $publishers,
        ]);
    }
}

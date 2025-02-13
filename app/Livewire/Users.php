<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;
    #[url(as: 'q')]
    public ?string $search = null;
    public string $selectedField = 'name';
    public array $fields = ['name', 'email'];
    public array $usersHeader = [
        ['field' => 'Name', 'col' => 'name', 'sort' => true],
        ['field' => 'Email', 'col' => 'email', 'sort' => true],
    ];
    public int $pageSize = 5;

    public $alpineData = [];


    public function render()
    {
        if ($this->search && collect($this->fields)->contains($this->selectedField)) {
            $this->resetPage();
            $users = User::query()
                ->where($this->selectedField, 'like', '%' . $this->search . '%')
                ->paginate($this->pageSize);
        } else {
            $users = User::query()->paginate($this->pageSize);
        }

        $this->alpineData = $users->toArray()['data'];
        return view('livewire.users', compact('users'));
    }
}

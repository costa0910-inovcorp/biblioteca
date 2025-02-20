<?php

namespace App\Livewire;

use App\Enums\RolesEnum;
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
        ['field' => 'Name', 'col' => 'name', 'sort' => false],
        ['field' => 'Email', 'col' => 'email', 'sort' => false],
        ['field' => 'Role', 'col' => 'role', 'sort' => false],
    ];
    public int $pageSize = 5;

    public function add(User $user): void
    {
        $user->assignRole(RolesEnum::ADMIN);
        $user->removeRole(RolesEnum::CITIZEN);
        $user->save();
        $this->dispatch('refresh');
    }

    public function remove(User $user): void
    {
        $user->assignRole(RolesEnum::CITIZEN);
        $user->removeRole(RolesEnum::ADMIN);
        $user->save();
        $this->dispatch('refresh');
    }


    public function render()
    {
        if ($this->search && collect($this->fields)->contains($this->selectedField)) {
            $this->resetPage();
            $users = User::query()
                ->where($this->selectedField, 'like', '%' . $this->search . '%')
                ->where('id', '!=', auth()->id()) // exclude logged user
                ->paginate($this->pageSize);
        } else {
            $users = User::query()
                ->where('id', '!=', auth()->id())// exclude logged user
                ->paginate($this->pageSize);
        }

        return view('livewire.users', compact('users'));
    }
}

<?php

namespace App\Livewire;

use App\Enums\RolesEnum;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use App\Repositories\LogRepository;
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

    public function add(User $user, LogRepository $logRepository): void
    {
        $user->assignRole(RolesEnum::ADMIN);
        $user->removeRole(RolesEnum::CITIZEN);
        $user->save();

        $logRepository->addRequestAction([
            'object_id' => $user->id,
            'app_section' => 'Users livewire component action add',
            'alteration_made' => 'remove citizen role from user and add admin role'
        ]);

        $this->dispatch('refresh');
    }

    public function remove(User $user, LogRepository $logRepository): void
    {
        $user->assignRole(RolesEnum::CITIZEN);
        $user->removeRole(RolesEnum::ADMIN);
        $user->save();

        $logRepository->addRequestAction([
            'object_id' => $user->id,
            'app_section' => 'Users livewire component action remove',
            'alteration_made' => 'assign citizen role to user and remove admin role'
        ]);

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

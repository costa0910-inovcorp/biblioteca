<?php

namespace App\Livewire;

use App\Livewire\Forms\ReturnRequestMethod;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUser extends Component
{
    use ReturnRequestMethod, WithPagination;

    public User $user;

    #[On('book-returned')]
    function refreshUser(): void
    {
        $this->dispatch('refresh');
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.show-user', [
            'userRequests' => $this->user->requests()
                ->with(['book'])
                ->latest()->paginate(3)
        ])->layout('layouts.app');
    }
}

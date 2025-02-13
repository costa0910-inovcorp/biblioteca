<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowUser extends Component
{
    #[Locked]
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.show-user', [
            'userRequests' => $this->user->requests()->latest()->paginate(3)
        ])->layout('layouts.app');
    }
}

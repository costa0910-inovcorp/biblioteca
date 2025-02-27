<?php

namespace App\Livewire;

use App\Models\BookRequest;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UserWaitlist extends Component
{
    use WithPagination;
    #[On(['book-returned', 'book-added-to-waitlist'])]
    function refreshWaitlist()
    {
        $this->dispatch('refresh');
    }

    public function render()
    {
        $inWaitlist = auth()->user()->bookWaitList()
            ->with('book')->latest()->paginate(3);
        return view('livewire.user-waitlist', compact('inWaitlist'));
    }
}

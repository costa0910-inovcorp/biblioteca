<?php

namespace App\Livewire;

use App\Models\BookRequest;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class UserRequests extends Component
{
    use WithoutUrlPagination;
    protected const PAGE_SIZE = 3;

//    #[On('books-borrowed')]
////    #[On('book-returned')]
//    public function refreshBooks(): void {
//        //Not working as intended
//        $this->dispatch('refresh');
//    }

    public function render()
    {
        $userRequests = BookRequest::query()
            ->with('book')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->Paginate(self::PAGE_SIZE)->onEachSide(0);

        return view('livewire.user-requests', [
            'userRequests' => $userRequests,
        ]);
    }
}

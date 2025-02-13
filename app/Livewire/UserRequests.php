<?php

namespace App\Livewire;

use App\Models\BookRequest;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;


class UserRequests extends Component
{
//    use WithPagination;
    use WithoutUrlPagination;

    protected $userRequests = [];
    protected const PAGE_SIZE = 3;

//    #[On('books-borrowed')]
//    public function refreshBooks(): void {
//        //Not working as intended
////        $this->newData();
//    }

    public function mount(): void
    {
        $this->newData();
    }

    public function render()
    {

        return view('livewire.user-requests', [
            'userRequests' => $this->userRequests,
        ]);
    }

    public function newData()
    {
        $this->userRequests = BookRequest::query()
            ->with('book')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->Paginate(self::PAGE_SIZE)->onEachSide(0);
    }
}

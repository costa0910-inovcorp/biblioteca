<?php

namespace App\Livewire;

use App\Livewire\Forms\ReturnRequestMethod;
use App\Models\BookRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;


class UserRequests extends Component
{
    use ReturnRequestMethod, WithPagination;
    protected const PAGE_SIZE = 3;

    //Added by ReturnRequestMethod trait
//    public $returnDate = null;

    #[On('books-borrowed')]
    #[On('book-returned')]
    public function refreshRequests(): void {
        $this->dispatch('refresh');
    }

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

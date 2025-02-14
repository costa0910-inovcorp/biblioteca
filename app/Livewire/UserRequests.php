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

    //Removed this method to void duplication by extracting it to trait ReturnRequestMethod

//    public function confirmReturnDate(BookRequest $request): void
//    {
//        $createdAt = Carbon::parse($request->created_at)->toDateString();
//        $this->validate([
//            'returnDate' => "required|date|after_or_equal:$createdAt|before_or_equal:today",
//        ]);
//
//        DB::transaction(function () use ($request) {
//            $request->book()->update([
//                'is_available' => true,
//            ]);
//            $user = $request->user()->first();
//            $user->books_request_count -= 1;
//            $user->save();
//            $request->return_date = Carbon::parse($this->returnDate);
//            $request->save();
//        });
//
//        $this->reset('returnDate');
//        $this->dispatch('book-returned', id: $request->user_id);
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

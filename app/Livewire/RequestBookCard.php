<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Carbon\Carbon;

//TODO: FIND WAY TO SHOW BOTH BOOK AND USER,
// CURRENTLY ONLY BOOK HAS BEEN SHOWN
class RequestBookCard extends Component
{
    #[Locked]
    public $requestBook;
    public $returnDate = null;

    public function confirmReturnDate()
    {
        $createdAt = Carbon::parse($this->requestBook->created_at)->toDateString();
        $this->validate([
            'returnDate' => "required|date|after_or_equal:$createdAt|before_or_equal:today",
        ]);

        DB::transaction(function () {
            $this->requestBook->book()->update([
               'is_available' => true,
            ]);
            $user = $this->requestBook->user()->first();
            $user->books_request_count -= 1;
            $user->save();
            $this->requestBook->return_date = Carbon::parse($this->returnDate);
            $this->requestBook->save();
        });

        $this->reset('returnDate');
        $this->requestBook->refresh();
        $this->dispatch('book-returned', id: $this->requestBook->user_id); //If update books user listening can borrow(or other things if needed)
    }


    public function render()
    {
        return view('livewire.request-book-card');
    }
}

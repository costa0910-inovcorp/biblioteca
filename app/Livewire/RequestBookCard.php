<?php

namespace App\Livewire;

use App\Models\BookRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

//TODO: FIND WAY TO SHOW BOTH BOOK AND USER,
// CURRENTLY ONLY BOOK HAS BEEN SHOWN
class RequestBookCard extends Component
{
    public BookRequest $requestBook;
    public $returnDate = null;

    public function confirmReturnDate()
    {
        $createdAt = Carbon::parse($this->requestBook->created_at)->toDateString();
        $this->validate([
            'returnDate' => "required|date|after_or_equal:$createdAt|before_or_equal:today",
        ]);

        DB::transaction(function () {
            $request = BookRequest::query()->findOrFail($this->requestBook->id);
            $request->book()->update([
               'is_available' => true,
            ]);
            $user = $request->user()->first();
            $user->books_request_count -= 1;
            $user->save();
            $request->return_date = Carbon::parse($this->returnDate);
            $request->save();
        });

        $this->reset('returnDate');
        $this->requestBook->refresh();
        $this->dispatch('book-returned', id: $this->requestBook->user_id);
    }


    public function render()
    {
        return view('livewire.request-book-card');
    }
}

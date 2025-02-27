<?php

namespace App\Livewire;

use App\Enums\RolesEnum;
use App\Events\BookRequested;
use App\Events\BookReturned;
use App\Models\BookRequest;
use App\Repositories\LogRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;

//TODO: FIND WAY TO SHOW BOTH BOOK AND USER,
// CURRENTLY ONLY BOOK HAS BEEN SHOWN
class RequestBookCard extends Component
{
    public BookRequest $requestBook;
    public $returnDate = null;

    public function confirmReturnDate(LogRepository $logRepository)
    {
        $createdAt = Carbon::parse($this->requestBook->created_at)->toDateString();
        $this->validate([
            'returnDate' => "required|date|after_or_equal:$createdAt|before_or_equal:today",
        ]);

        if (!auth()->user()?->hasRole(RolesEnum::ADMIN)) {
            abort(401);
        }

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
//        'object_id',
//        'app_section',
//        'alteration_made'

//        BookReturned::dispatch($this->requestBook->book_id);
        $logRepository->addRequestAction([
            'object_id' => $this->requestBook->id,
            'app_section' => 'ReturnBookCard livewire component confirmReturnDate action',
            'alteration_made' => 'return book and update user request count and book availability'
        ]);

        $this->reset('returnDate');
        $this->requestBook->refresh();
        $this->dispatch('book-returned', id: $this->requestBook->user_id);

    }


    public function render()
    {
        return view('livewire.request-book-card');
    }
}

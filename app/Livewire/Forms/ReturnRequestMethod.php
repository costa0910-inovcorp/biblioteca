<?php

namespace App\Livewire\Forms;

use App\Models\BookRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait ReturnRequestMethod
{
    public $returnDate = null;

    public function confirmReturnDate(BookRequest $request): void
    {
        $createdAt = Carbon::parse($request->created_at)->toDateString();
        $this->validate([
            'returnDate' => "required|date|after_or_equal:$createdAt|before_or_equal:today",
        ]);

        DB::transaction(function () use ($request) {
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
        $this->dispatch('book-returned', id: $request->user_id);
    }
}

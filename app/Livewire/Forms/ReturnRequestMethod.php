<?php

namespace App\Livewire\Forms;

use App\Events\ReviewSubmitted;
use App\Models\BookRequest;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait ReturnRequestMethod
{
    public $returnDate = null;
    public string $comment = '';

    public float $rating = 4.5;

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

    public function reviewBook(string $requestId): void {
        $this->validate([
            'comment' => "required|string|min:10",
            'rating' => "required|numeric|between:1,5",
        ]);

        $request = BookRequest::query()
            ->with('book')
            ->findOrFail($requestId);

        if ($request->is_reviewed) {
            abort(402, 'Sorry, this book is already reviewed.');
        }

        DB::transaction(function () use ($request) {
            $review = Review::query()->create([
                'id' => Str::uuid()->toString(),
                'book_id' => $request->book_id,
                'user_id' => auth()->id(),
                'comment' => $this->comment,
                'rating' => $this->rating,
            ]);

            $request->is_reviewed = true;
            $request->save();
//            dd($review->id, Str::uuid()->toString());

            ReviewSubmitted::dispatch($review);
        });

        $this->reset('rating', 'comment');
        $this->dispatch('review-submitted');
        //TODO: VERIFY IF I NEED TO MANUALLY REFRESH THIS COMPONENT
    }
}

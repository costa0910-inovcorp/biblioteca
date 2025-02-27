<?php

namespace App\Listeners;

use App\Events\BookReturned;
use App\Mail\WaitListAlert;
use App\Models\BookWaitList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AlertUserInWaitList
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookReturned $event): void
    {
        //
        $inWaitList = BookWaitList::query()
            ->with(['user', 'book'])
            ->where('book_id', '=', $event->bookId)
            ->orderBy('created_at')->first();

        if ($inWaitList?->exists) {
            Mail::to($inWaitList->user->email)->sendNow(new WaitListAlert($inWaitList));
            $inWaitList->delete();
            BookWaitList::query()
                ->where('book_id', '=', $event->bookId)
                ->decrement('position');
            Log::info('Email sent', ['email' => $inWaitList->user->email]);
        }
    }
}

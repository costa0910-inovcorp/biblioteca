<?php

namespace App\Listeners;

use App\Events\ReviewStatusChange;
use App\Mail\ReviewStatusChangeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ReviewStatusChangeMailer
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
    public function handle(ReviewStatusChange $event): void
    {
        $review = $event->review;

        Mail::to($review->user->email)->send(New ReviewStatusChangeEmail($review));
    }
}

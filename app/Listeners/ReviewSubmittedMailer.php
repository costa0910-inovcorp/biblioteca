<?php

namespace App\Listeners;

use App\Events\ReviewSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReviewSubmittedMailer
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
    public function handle(ReviewSubmitted $event): void
    {
        //TODO 1: GET SUBMITTED REVIEW
        $review = $event->review;

        //TODO 2: GET ALL ADMINS

        //TODO 3: LOOP THROUGH ADMINS AND SEND EMAIL

        //TODO 4: LOG ALL EMAIL SENT TO ADMIN ABOUT SUBMITTED REVIEW
    }
}

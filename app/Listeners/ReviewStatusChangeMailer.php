<?php

namespace App\Listeners;

use App\Events\ReviewStatusChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //TODO 1: GET REVIEW
        $review = $event->review;

        //TODO: SEND USER EMAIL
    }
}

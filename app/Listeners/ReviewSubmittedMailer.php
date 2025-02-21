<?php

namespace App\Listeners;

use App\Enums\RolesEnum;
use App\Events\ReviewSubmitted;
use App\Mail\ReviewSubmittedEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReviewSubmittedMailer implements ShouldQueue
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
        $review = $event->review;

        $admins = User::role(RolesEnum::ADMIN)->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new ReviewSubmittedEmail($review));
        }

        Log::info('ReviewSubmitted: all emails sent to: ' . count($admins) . ' admin(s)');
    }
}

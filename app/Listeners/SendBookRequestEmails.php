<?php

namespace App\Listeners;

use App\Enums\RolesEnum;
use App\Events\BookRequested;
use App\Mail\RequestConfirmation;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookRequestEmails implements ShouldQueue
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
    public function handle(BookRequested $event): void
    {
        $requestDetails = $event->requestBook;
        //TODO: FIND USER IN DB WITH ID AND SEND EMAIL TO USER
        $user = User::query()->findOrFail($requestDetails->user_id);
        $book = Book::query()->findOrFail($requestDetails->book_id);
        $this->sendEmail($user->email, $book, $user->name);

        //TODO: LOOP TO ADMINS AND SEND THEM EMAIL
        $admins = User::role(RolesEnum::ADMIN)->get();
        foreach ($admins as $admin) {
            $this->sendEmail($admin->email, $book, $user->name);
        }
    }

    //TODO: MAKE PROTECTED METHOD TO SEND EMAIL
    protected function sendEmail(string $email, Book $requestDetails, ?string $userName): void
    {
        Mail::to($email)->send(new RequestConfirmation($requestDetails, $userName));
    }
}

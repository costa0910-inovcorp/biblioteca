<?php

namespace App\Listeners;

use App\Enums\RolesEnum;
use App\Events\BookRequested;
use App\Mail\AdminBookRequestNotification;
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
        $requestDetails = $event->requestBook->toArray();
        //TODO: FIND USER IN DB WITH ID AND SEND EMAIL TO USER
        $book = Book::query()->findOrFail($requestDetails['book_id']);
        $data = array_merge($requestDetails,[
            'book_name' => $book->name,
            'cover_image' => $book->cover_image,
        ]);

        Mail::to($data['user_email'])->send(new RequestConfirmation($data));

        //TODO: LOOP TO ADMINS AND SEND THEM EMAIL
        $admins = User::role(RolesEnum::ADMIN)->get();
        foreach ($admins as $admin) {
            $adminData = array_merge($data,[
                'admin_name' => $admin->name
            ]);

            Mail::to($admin->email)->send(new AdminBookRequestNotification($adminData));
        }
    }
}

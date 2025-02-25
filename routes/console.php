<?php

use App\Mail\NeedHelpMail;
use App\Mail\UserReturnBookRemainderNotification;
use App\Models\BookRequest;
use App\Models\CartItem;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    //Get all request with book where return date is null and predicted return date it's tomorrow
    $tomorrowDate = today()->addDay()->toDateString();
    $requestDueTomorrow = BookRequest::query()
        ->with(['book'])
        ->where('return_date', null)
        ->where('predicted_return_date', '=', $tomorrowDate)
        ->get();

    //send remainder to user
   foreach ($requestDueTomorrow as $request) {
       Mail::to($request->user_email)->send(new UserReturnBookRemainderNotification($request));
   }

   Log::info("All remainder for borrowed books that's will due tomorrow ($tomorrowDate) was sent. Remainder sent: ",
       (array) count($requestDueTomorrow->toArray()));
})->daily();

Schedule::call(function () {
    $startOfPastHour = now()->subHour()->startOfHour();
    $endOfPastHour = now()->subHour()->endOfHour();

    $addedPastHour = CartItem::with('user')
        ->whereBetween('created_at', [$startOfPastHour, $endOfPastHour])
        ->get();

    // Get unique users
    $uniqueUsers = $addedPastHour->unique('user_id');

    foreach ($uniqueUsers as $item) {
        Mail::to($item->user->email)->send(new NeedHelpMail($item->user));
    }
})->hourly();

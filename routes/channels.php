<?php

use App\Enums\RolesEnum;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('saving-books', function ($user) {
    Log::info('called: Broadcast::channel');
    return $user->hasRole(RolesEnum::ADMIN);
});

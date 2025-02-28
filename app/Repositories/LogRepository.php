<?php

namespace App\Repositories;

use App\Models\Log;
use Illuminate\Support\Str;

class LogRepository
{
    public function addRequestAction(array $data): void
    {
        Log::query()->create([
            ...$data,
            'user_id' => auth()?->id(),
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->getClientIp(),
            'date' => now()->format('Y-m-d'),
            'time' => now()->format('H:i:s'),
            'id' => Str::uuid(),
        ]);
    }
}

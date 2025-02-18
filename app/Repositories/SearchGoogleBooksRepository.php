<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SearchGoogleBooksRepository
{
    protected const url = 'https://www.googleapis.com/books/v1/volumes?q=';
    public function searchFromGoogleBooks($q): array {
        $queryStr = Str::of($q)
            ->trim()
            ->replace(' ', '+');

        $response = Http::get(self::url . $queryStr);

        if ($response->ok()) {
            return $response->json();
        }

        return [];
    }
}

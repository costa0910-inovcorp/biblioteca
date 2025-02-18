<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SearchGoogleBooksRepository
{
    protected const url = 'https://www.googleapis.com/books/v1/volumes?q=';
    public function searchFromGoogleBooks(string $q, ?int $itemsPosition = 0, ?int $pageSize = 5): array {
        $queryStr = Str::of($q)
            ->trim()
            ->replace(' ', '+');
        $params = "$queryStr&startIndex=$itemsPosition&maxResults=$pageSize";

//        dd($params);

        $response = Http::get(self::url . $params);

        if ($response->ok()) {
            return $response->json();
        }

        return [];
    }
}

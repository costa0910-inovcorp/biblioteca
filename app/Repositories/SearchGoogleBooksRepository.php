<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

class SearchGoogleBooksRepository
{
    protected const url = 'https://www.googleapis.com/books/v1/volumes?q=';
    public function searchFromGoogleBooks(string $q, ?int $itemsPosition = 0, ?int $pageSize = 5): array {
        $queryStr = Str::of($q)
            ->trim()
            ->replace(' ', '+');
        $params = "$queryStr&startIndex=$itemsPosition&maxResults=$pageSize";

        try {
            $response = Http::get(self::url . $params);

            if ($response->ok()) {
                $books = $this->parseBooks($response->json());
                return [
                    'books' => $books,
                    'isSuccess' => true,
                ];
            }

            return [
                'isSuccess' => false,
                'message' => 'Sorry, something went wrong.',
            ];
        } catch (Exception $exception) {
            return [
                'isSuccess' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }

    protected function parseBooks(array $books): array
    {
        if (!array_key_exists('items', $books)) {
            return [];
        }

        $collection = collect($books['items'])->map(function ($book) {
            return [
                'name' => array_key_exists('title', $book['volumeInfo']) ? $book['volumeInfo']['title'] : 'No title',
                'authors' => array_key_exists('authors', $book['volumeInfo']) ? $book['volumeInfo']['authors'] : [],
                'publisher' => array_key_exists('publisher', $book['volumeInfo']) ? $book['volumeInfo']['publisher'] : null,
                'price' =>  array_key_exists('saleInfo', $book) ? $this->getPrice($book['saleInfo']) : 0.0,
                'bibliography' => array_key_exists('description', $book['volumeInfo'])
                    ? $book['volumeInfo']['description'] : null,
                'isbn' => $this->getIsbn($book['volumeInfo']),
                'cover_image' => array_key_exists('imageLinks', $book['volumeInfo'])
                    ? $book['volumeInfo']['imageLinks']['thumbnail'] : null,
            ];
        });

        return [
            'totalItems' => $books['totalItems'],
            'items' => $collection->toArray(),
        ];
    }

    private function getPrice(array $saleInfo) : float
    {
        if (array_key_exists('retailPrice', $saleInfo)) {
            return $saleInfo['retailPrice']['amount'];
        }

        if (array_key_exists('listPrice', $saleInfo)) {
            return $saleInfo['listPrice']['amount'];
        }

        return 0;
    }

    private function getIsbn(array $volumeInfo): string | null
    {
        if (!array_key_exists('industryIdentifiers', $volumeInfo)) {
            return null;
        }

        $industryIdentifiers = $volumeInfo['industryIdentifiers'];

        if (empty($industryIdentifiers)) {
            return null;
        }
        return $industryIdentifiers[0]['identifier'];
    }
}

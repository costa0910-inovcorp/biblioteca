<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class RelevantBooksRepository
{
    public function getSimilarBooks(Book $book): array
    {
        if ($book->bibliography && $book->name) {
            $arrByDesc = $this->appearanceInDescription($book->id, $book->bibliography);
            $arrByName = $this->appearanceInDescription($book->id, $book->name, false);
            $arrBooks = $this->mergeByCount($arrByDesc, $arrByName);
        }
        elseif ($book->bibliography) {
            $arrBooks = $this->appearanceInDescription($book->id, $book->bibliography);
        } else {
            $arrBooks = $this->appearanceInDescription($book->id, $book->name, false);
        }

        if (empty($arrBooks)) {
            return [];
        }

        $books = collect($arrBooks);

        return $books->sortByDesc(function ($book) {
            return $book['count'];
        })->take(10)
            ->map(fn ($arr) => $arr['book'])
            ->toArray();
    }

    private function mergeByCount(array $arrByDesc, array $arrByName)
    {
        $merge = [];
        foreach ($arrByDesc as $arr) {
            $countName = $arrByName[$arr['book']->id];
            $merge[] = [
                'count' => $arr['count'] + $countName['count'],
                'book' => $arr['book'],
            ];
        }

        return $merge;
    }

    protected function appearanceInDescription(string $id, ?string $word, bool $desc= true): array
    {
        if (is_null($word)) {
            return [];
        }

        $booksWithAppearanceCount = [];

        $allBooks = $this->getBooks($id);
        foreach ($allBooks as $book) {
            if ($book->bibliography && $desc) {
                $descCount = $this->wordsInFirstString($word, $book->bibliography);
            } else {
                $descCount = $this->wordsInFirstString($word, $book->name);
            }

            $item = ['count' => $descCount, 'book' => $book];
            $booksWithAppearanceCount[$book->id] = $item;
        }
        return $booksWithAppearanceCount;
    }

    protected function wordsInFirstString(string $firstString, string $secondString): int
    {
        $wordsIn = 0;
        $secondStringWords = $this->returnWordsOfString($secondString);
        $firstString = strtolower($firstString);
        $passedWords = [];

        foreach ($secondStringWords as $secondStringWord) {
            $isPassed = in_array($secondStringWord, $passedWords);
            if (str_contains($firstString, $secondStringWord) && !$isPassed) {
                $passedWords[] = $secondStringWord;
                $wordsIn++;
            }
        }

        return $wordsIn;
    }

    protected function returnWordsOfString(string $string): array {
        return explode(' ', strtolower($string));
    }

    protected function getBooks(string $id): Collection
    {
        return Book::query()->whereNot('id', $id)->get();
    }

}

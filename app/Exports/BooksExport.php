<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Psy\Util\Str;

class BooksExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::with(['publisher', 'authors'])
            ->get()
            ->map(function ($book) {
                $authors = $book->authors->map(fn ($author) => $author->name)->toArray();
//                if(!$book->publisher){
//                    dd($book->publisher);
//                }
                return [
                    'ISBN' => $book->isbn,
                    'Nome' => $book->name,
                    'Preço' => $book->price,
                    'Autores' => join(', ', $authors),
                    'Editora' => $book?->publisher?->name ?? 'desconhecida',
                ];
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['ISBN', 'Nome', 'Preço', 'Autores', 'Editora'];
    }
}

<?php

namespace App\Exports;

use App\Models\Author;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuthorsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Author::query()
            ->with('books')
            ->get()
            ->map(function ($author) {
                $books = $author->books->map(fn ($book) => $book->name)->toArray();

                return [
                    'Nome' => $author->name,
                    'Livros' => join(', ', $books),
                ];
            });
    }
    public function headings(): array
    {
        return ['Nome', 'Livros'];
    }
}

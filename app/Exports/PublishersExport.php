<?php

namespace App\Exports;

use App\Models\Publisher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PublishersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Publisher::query()
            ->with('books')
            ->get()
            ->map(function ($publisher) {
                return [
                    'Nome' => $publisher->name,
                    'Total livros' => $publisher->books->count(),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nome', 'Total livros'];
    }
}

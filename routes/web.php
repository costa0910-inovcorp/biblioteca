<?php

use App\Exports\AuthorsExport;
use App\Exports\BooksExport;
use App\Exports\PublishersExport;
use App\Livewire\CreateAuthor;
use App\Livewire\CreateBook;
use App\Livewire\CreatePublisher;
use App\Livewire\EditBook;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('books');
    })->name('dashboard');

    //books
    Route::get('/books', function () {
        return view('books');
    })->name('books');
    Route::get('/books/create', CreateBook::class)->name('books.create');
    Route::get('/books/edit/{book}', EditBook::class)->name('books.edit');
    Route::get('/books/export', function () {
        return Excel::download(new BooksExport(), 'livros.xlsx');
    })->name('books.export');

    // publishers
    Route::get('/publishers', function () {
        return view('publishers');
    })->name('publishers');
    Route::get('/publishers/create', CreatePublisher::class)->name('publishers.create');
    Route::get('/publishers/edit/{publisher}', CreatePublisher::class)->name('publishers.edit');
    Route::get('/publishers/export', function () {
        return Excel::download(new PublishersExport(), 'editoras.xlsx');
    })->name('publishers.export');

    // authors
    Route::get('/authors', function () {
        return view('authors');
    })->name('authors');
    Route::get('/authors/create', CreateAuthor::class)->name('authors.create');
    Route::get('/authors/edit/{author}', CreateAuthor::class)->name('authors.edit');
    Route::get('/authors/export', function () {
        return Excel::download(new AuthorsExport(), 'autores.xlsx');
    })->name('authors.export');
});

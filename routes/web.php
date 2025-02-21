<?php

use App\Enums\RolesEnum;
use App\Events\BookRequested;
use App\Exports\AuthorsExport;
use App\Exports\BooksExport;
use App\Exports\PublishersExport;
use App\Livewire\CreateAuthor;
use App\Livewire\CreateBook;
use App\Livewire\CreatePublisher;
use App\Livewire\EditBook;
use App\Livewire\SearchGoogleBooks;
use App\Livewire\ShowBook;
use App\Livewire\ShowReview;
use App\Livewire\ShowUser;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\Review;
use App\Repositories\RequestBookRepository;
use Illuminate\Support\Facades\DB;
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
        if (request()->user()->hasRole(RolesEnum::ADMIN)) {
            return redirect()->route('users');
        }
        return redirect()->route('books');
        });
    });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin'
])->group(function () {
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

    //Users
    Route::get('/users', function () {
        return view('users');
    })->name('users');
    Route::get('/users/show/{user}', ShowUser::class)->name('users.show');

    //search-google-books
    Route::get('/search-google-books', SearchGoogleBooks::class)->name('search-google-books');

    //Reviews
    Route::get('/reviews', function () {
        return view('reviews');
    })->name('reviews');
    Route::get('/reviews/{id}', ShowReview::class)->name('reviews.show');
});

// request book
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'can:request books',
    'can:view books'
])->group(function () {
    Route::get('/books', function () {
        return view('books');
    })->name('books');
    Route::get('/books/show/{book}', ShowBook::class)->name('books.show');

    Route::get('/request-books', function () {
        return view('request-books');
    })->name('request-books');

    Route::get('/public-books-request/{book}', function (Book $book, RequestBookRepository $repository) {
        if (!$book->exists || !$book->is_available) {
            abort(404, 'Book not found or is not available.');
        }

        $repository->borrowBooks([$book]);

        return redirect()->route('request-books');
    })->name('public.books.request');
});

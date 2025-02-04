<?php

use App\Livewire\CreateBook;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/books', function () {
        return view('books');
    })->name('books');
    Route::get('/books/create', function () {
        return view('create-book');
    })->name('books.create');
    Route::get('/publishers', function () {
        return view('dashboard');
    })->name('publishers');
    Route::get('/authors', function () {
        return view('dashboard');
    })->name('authors');
});

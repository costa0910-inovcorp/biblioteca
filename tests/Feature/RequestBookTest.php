<?php

use App\Enums\RolesEnum;
use App\Livewire\RequestBook;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

uses()->group('library', 'create-request');

//1. Teste de Criação de Requisição de Livro
//
//Verifica se um utilizador pode criar uma requisição de um livro corretamente.
//
//Criar um utilizador e um livro na base de dados.
//Simular a submissão de uma requisição.
//Garantir que a requisição foi criada e que os dados estão corretos.
test('Citizen or Admin can request a book', function ($role) {
    $user = User::factory()->create();
    $user->hasRole($role);
    $book = Book::factory()->create();

    $this->assertEquals(0, BookRequest::count());
    Livewire::actingAs($user)
        ->test(RequestBook::class)
        ->set( 'availableToBorrow', [$book])
        ->call('add', $book->id)
        ->assertCount('availableToBorrow', 0)
        ->call('borrow');

    $book->refresh();
    $user->refresh();

    $this->assertEquals(1, $user->books_request_count);
    expect(boolval($book->is_available))->toBeFalse();
    $this->assertEquals(1, BookRequest::count());
})
    ->with([RolesEnum::ADMIN, RolesEnum::CITIZEN]);



//2. Teste de Validação de Requisição
//
//Assegura que uma requisição não pode ser criada sem um livro válido.
//
//Simular uma requisição sem um livro válido.
//Verificar se o Laravel retorna erro de validação adequado.
test('Return error when book is invalid', function ($role) {
    $user = User::factory()->create();
    $user->hasRole($role);
    $book = Book::factory()->create();

    expect(fn() => Livewire::actingAs($user)
        ->test(RequestBook::class)
        ->set( 'availableToBorrow', [$book])
        ->call('add', $book->id . 'jt6--6')
        ->assertSee('Booko not found'))
        ->toThrow(ModelNotFoundException::class);
})
    ->with([RolesEnum::ADMIN, RolesEnum::CITIZEN]);

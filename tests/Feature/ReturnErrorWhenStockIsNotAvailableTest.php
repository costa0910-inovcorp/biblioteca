<?php

use App\Enums\RolesEnum;
use App\Livewire\RequestBook;
use App\Models\Book;
use App\Models\User;
use Livewire\Livewire;

uses()->group('library', 'return-error-out-of-stock');

//5. Teste de Stock na Encomenda de Livros
//
//Confirma se não é possível requisitar um livro sem stock disponível.
//
//Criar um livro com stock = 0.
//Tentar criar uma requisição para esse livro.
//Verificar se a aplicação impede a operação com uma mensagem de erro.

test('Return error when books is not available (out of stock)', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::ADMIN);
    $book = Book::factory()->create();
    $book->is_available = false; // stock 0
    $book->save();

    $this->actingAs($user);
    $response = $this->get("/public-books-request/$book->id");

    $response->assertStatus(403)
        ->assertSeeText('This book is not available.');
});

test('Add to user\'s waitlist when books is not available (out of stock)', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::ADMIN);
    $book = Book::factory()->create();
    $book->is_available = false; // stock 0
    $book->save();

    Livewire::actingAs($user)
        ->test(RequestBook::class)
        ->set( 'availableToBorrow', [$book])
        ->call('add', $book->id)
        ->assertHasNoErrors()
        ->call('borrow')
        ->assertSuccessful();
});

test('Return error if user try to add book that\'s already in his waitlist', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::ADMIN);
    $book = Book::factory()->create();
    $book->is_available = false; // stock 0
    $book->save();

    Livewire::actingAs($user)
        ->test(RequestBook::class)
        ->set( 'availableToBorrow', [$book])
        ->call('add', $book->id)
        ->assertHasNoErrors()
        ->call('borrow')
        ->assertSuccessful();

    //Error if remove rollback(): PDOException: SQLSTATE[42000]: Syntax error or access violation: 1305 SAVEPOINT trans2 does not exist in
    \Illuminate\Support\Facades\DB::rollBack();

    $this->actingAs($user);
    $response = $this->get("public-add-to-wait-list/$book->id");

    $response->assertStatus(403)
        ->assertSeeText('You can not add same book to a wait list.');
});

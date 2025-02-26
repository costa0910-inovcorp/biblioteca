<?php

use App\Enums\RolesEnum;
use App\Livewire\RequestBookCard;
use App\Models\BookRequest;
use Livewire\Livewire;

uses()->group('library', 'return-book');

//3. Teste de Devolução de Livro
//
//Confirma se um utilizador pode devolver um livro.
//Criar uma requisição ativa na base de dados.
//Simular uma requisição para devolver o livro.
//Verificar se o estado da requisição foi atualizado corretamente.

test('Book can be returned but Citizen can not return it', function () {
    $request = BookRequest::factory()->create(); //user(citizen) and book created on bookRequest factory

    $this->assertNull($request->return_date);

    Livewire::actingAs($request->user)
        ->test(RequestBookCard::class, ['requestBook' => $request])
        ->set('returnDate', now()->toDateString())
        ->call('confirmReturnDate')
        ->assertHasNoErrors('returnDate')
        ->assertUnauthorized();
});

test('Book can be returned (by admin)', function () {
    $request = BookRequest::factory()->create();
    $this->assertNull($request->return_date);
    $request->user->assignRole(RolesEnum::ADMIN);

    expect(boolval($request->book->is_available))->toBeFalse()
        ->and($request->user->books_request_count)->toEqual(1);

    Livewire::actingAs($request->user)
        ->test(RequestBookCard::class, ['requestBook' => $request])
        ->set('returnDate', now()->toDateString())
        ->call('confirmReturnDate')
        ->assertHasNoErrors('returnDate')
        ->assertSuccessful();

    $request->refresh();

    expect(boolval($request->book->is_available))->toBeTrue()
        ->and($request->return_date)->toBe(now()->toDateString())
        ->and($request->user->books_request_count)->toEqual(0);
});

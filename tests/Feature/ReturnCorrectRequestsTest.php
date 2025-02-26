<?php

use App\Enums\RolesEnum;
use App\Livewire\BookDetails;
use App\Livewire\UserRequests;
use App\Models\BookRequest;
use App\Models\User;
use Livewire\Livewire;

uses()->group('library', 'return-correct-request');

//4. Teste de Listagem de Requisições por Utilizador
//
//Garante que um utilizador consegue ver as suas requisições corretamente.
//
//Criar múltiplas requisições para diferentes utilizadores.
//Simular um pedido para obter as requisições de um utilizador específico.
//Verificar se apenas as requisições corretas são retornadas.

test('User (citizen) can see it\'s requests', function () {
    $requests = BookRequest::factory(5)->create(); //each request create book and it's user(citizen)
    $firstRequest = $requests->first();

    Livewire::actingAs($firstRequest->user)
        ->test(UserRequests::class)
        ->assertViewHas('userRequests', function ($userRequests) use ($firstRequest) {
            return  count($userRequests) == 1 && $userRequests->contains($firstRequest);
        });
});

test('User (citizen) can only see it\'s requests', function () {
    $requests = BookRequest::factory(5)->create(); //each request create book and it's user(citizen)
    $firstRequest = $requests->first();

    $firstRequest->return_date = now()->toDateString();
    $firstRequest->book->is_available = true;
    $firstRequest->save();

    //create more request to first user's book
    $requests->skip(1)->each(function ($request) use ($firstRequest) {
       $newRequest = BookRequest::query()->create([
           'user_id' => $request->user_id,
           'book_id' => $firstRequest->book->id,
           'user_name' => $request->user->name,
           'user_email' => $request->user->email,
       ]);
        $newRequest->return_date = now()->toDateString();
    });

    // Get request of first user's book(should be 5)
    $firstUserBookRequests = $firstRequest->book->requests()->count();
    expect($firstUserBookRequests)->toBe(5);

    Livewire::actingAs($firstRequest->user)
        ->test(BookDetails::class, ['book' => $firstRequest->book])
        ->assertViewHas('bookRequests', function ($bookRequests) use ($firstRequest) {
            return count($bookRequests) == 1 && $bookRequests->contains($firstRequest);
        });
});

test('Admin can see all requests', function () {
    $requests = BookRequest::factory(5)->create(); //each request create book and it's user(citizen)
    $firstRequest = $requests->first();

    $firstRequest->return_date = now()->toDateString();
    $firstRequest->book->is_available = true;
    //Promote to admin, so he can view all requests
    $firstRequest->user->assignRole(RolesEnum::ADMIN);
    $firstRequest->save();

    //create more request to first user's book
    $requests->skip(1)->each(function ($request) use ($firstRequest) {
        $newRequest = BookRequest::query()->create([
            'user_id' => $request->user_id,
            'book_id' => $firstRequest->book->id,
            'user_name' => $request->user->name,
            'user_email' => $request->user->email
        ]);

        $newRequest->return_date = now()->toDateString();
    });

    Livewire::actingAs($firstRequest->user)
        ->test(BookDetails::class, ['book' => $firstRequest->book])
        ->assertViewHas('bookRequests', fn($bookRequests) => $bookRequests->total() == 5);
});

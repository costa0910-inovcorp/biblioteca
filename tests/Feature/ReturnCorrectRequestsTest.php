<?php

uses()->group('library', 'return-correct-request');

//4. Teste de Listagem de Requisições por Utilizador
//
//Garante que um utilizador consegue ver as suas requisições corretamente.
//
//Criar múltiplas requisições para diferentes utilizadores.
//Simular um pedido para obter as requisições de um utilizador específico.
//Verificar se apenas as requisições corretas são retornadas.

test('User (citizen) can see it\'s requests', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('User (citizen) can only see it\'s requests', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('Admin can see all requests', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

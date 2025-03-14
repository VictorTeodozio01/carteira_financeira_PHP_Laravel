<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;


Route::get('/', function () {
    return response()->file(public_path('frontend/index.html'));
});

Route::get('/frontend/login.html', function () {
    return response()->file(public_path('frontend/login.html'));
});

Route::get('/frontend/cadastro.html', function () {
    return response()->file(public_path('frontend/cadastro.html'));
});

Route::get('/frontend/dashboard.html', function () {
    return response()->file(public_path('frontend/dashboard.html'));
});

Route::get('/frontend/transacoes.html', function () {
    return response()->file(public_path('frontend/transacoes.html'));
});
Route::get('/transacoes', [UsuarioController::class, 'listarTransacoes']);

Route::get('/frontend/deposito.html', function () {
    return response()->file(public_path('frontend/deposito.html'));
});

Route::get('/frontend/transferir.html', function () {
    return response()->file(public_path('frontend/transferir.html'));

});

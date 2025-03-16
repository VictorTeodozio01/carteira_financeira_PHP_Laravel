<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;


use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\TransferenciaController;

// Rotas de Autenticação
Route::post('/cadastro', [UsuarioController::class, 'cadastrar']);
Route::post('/login', [UsuarioController::class, 'login']);

// Rotas de Transações
Route::post('/depositar', [DepositoController::class, 'depositar']);
Route::post('/transferir', [TransferenciaController::class, 'transferir']);
Route::get('/transacoes', [TransacaoController::class, 'listarTransacoes']);
Route::post('/reverter/{id}', [TransacaoController::class, 'reverter']);

// Rotas de Páginas (Front-end)
Route::view('/cadastro', 'cadastro');
Route::view('/login', 'login');
Route::view('/dashboard', 'dashboard');
Route::view('/depositar', 'depositar');
Route::view('/transferir', 'transferir');
Route::view('/transacoes', 'transacoes');
Route::view('/', 'index');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\Auth\VerifyEmailController;

// Verificação de E-mail
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed'])
    ->name('verification.verify');

// Rotas públicas
Route::middleware('web')->group(function () {
    Route::view('/cadastrar', 'cadastrar');
    Route::view('/login', 'login');
    Route::view('/', 'index');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Rotas protegidas (usuário autenticado)
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::post('/depositar', [DepositoController::class, 'depositar']);
    Route::post('/transferir', [TransferenciaController::class, 'transferir']);
    Route::get('/transacoes', [TransacaoController::class, 'listarTransacoes']);
    Route::post('/transacoes/{id}/reverter', [TransacaoController::class, 'reverter']);
    Route::view('/dashboard', 'dashboard');
    Route::view('/depositar', 'depositar');
    Route::view('/transferir', 'transferir');
    Route::view('/transacoes', 'transacoes');
});

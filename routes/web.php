<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;


use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::middleware('web')->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

Route::post('/depositar', [DepositoController::class, 'depositar']);
Route::post('/transferir', [TransferenciaController::class, 'transferir']);
Route::get('/transacoes', [TransacaoController::class, 'listarTransacoes']);
Route::post('/reverter/{id}', [TransacaoController::class, 'reverter']);

Route::view('/cadastrar', 'cadastrar');
Route::view('/login', 'login');
Route::view('/dashboard', 'dashboard');
Route::view('/depositar', 'depositar');
Route::view('/transferir', 'transferir');
Route::view('/transacoes', 'transacoes');
Route::view('/', 'index');
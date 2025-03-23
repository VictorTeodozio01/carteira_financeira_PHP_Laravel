<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\TransacaoController;

// Rotas de API
Route::middleware('auth:api')->group(function () {
    Route::post('/depositar', [DepositoController::class, 'depositar']);
    Route::post('/transferir', [TransferenciaController::class, 'transferir']);
    Route::get('/transacoes', [TransacaoController::class, 'listarTransacoes']);
    Route::post('/reverter/{id}', [TransacaoController::class, 'reverter']);
});

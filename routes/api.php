<?php


use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DepositoController;
use App\Http\Controllers\TransferenciaController;
use Illuminate\Support\Facades\Route;

Route::post('/depositar', [DepositoController::class, 'depositar']);
Route::post('/transferir', [TransferenciaController::class, 'transferir']);
Route::post('/cadastro', [UsuarioController::class, 'cadastrar']);
Route::post('/transferir', [UsuarioController::class, 'transferir']);
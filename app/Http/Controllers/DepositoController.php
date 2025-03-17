<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DepositoController extends Controller
{
    public function depositar(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric|min:1',
            'usuario_id' => 'required|exists:users,id', 
        ]);

        $usuario = User::find($request->usuario_id); 
        $valor = $request->valor;

        $usuario->saldo += $valor;
        $usuario->save();

        return response()->json([
            'message' => 'Depósito realizado com sucesso!',
            'saldo_atual' => $usuario->saldo,
        ], 200);
    }
}
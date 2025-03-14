<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class DepositoController extends Controller
{
    public function depositar(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric|min:1',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $usuario = Usuario::find($request->usuario_id);
        $valor = $request->valor;

        $usuario->saldo += $valor;
        $usuario->save();

        return response()->json([
            'message' => 'Depósito realizado com sucesso!',
            'saldo_atual' => $usuario->saldo,
        ], 200);
    }
}

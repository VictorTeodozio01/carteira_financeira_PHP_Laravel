<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    public function transferir(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric|min:1',
            'usuario_para' => 'required|exists:users,id', 
        ]);

        $usuario_de = $request->user();
        $usuario_para = User::find($request->usuario_para);
        $valor = $request->valor;

        if ($usuario_de->id === $usuario_para->id) {
            return response()->json(['message' => 'Não é possível transferir para si mesmo.'], 400);
        }

        if ($usuario_de->saldo < $valor) {
            return response()->json(['message' => 'Saldo insuficiente.'], 400);
        }

        $usuario_de->saldo -= $valor;
        $usuario_para->saldo += $valor;
        $usuario_de->save();
        $usuario_para->save();

        return response()->json([
            'message' => 'Transferência realizada com sucesso!',
            'saldo_atual' => $usuario_de->saldo,
        ], 200);
    }
}
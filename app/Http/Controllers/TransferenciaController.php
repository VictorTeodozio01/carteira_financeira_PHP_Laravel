<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    public function transferir(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric|min:1',
            'usuario_de' => 'required|exists:usuarios,id',
            'usuario_para' => 'required|exists:usuarios,id',
        ]);

        $usuario_de = Usuario::find($request->usuario_de);
        $usuario_para = Usuario::find($request->usuario_para);
        $valor = $request->valor;

        if ($usuario_de->saldo < $valor) {
            return response()->json(['message' => 'Saldo insuficiente.'], 400);
        }

        $usuario_de->saldo -= $valor;
        $usuario_para->saldo += $valor;
        $usuario_de->save();
        $usuario_para->save();

        return response()->json([
            'message' => 'Transferência realizada com sucesso!',
            'saldo_usuario_de' => $usuario_de->saldo,
            'saldo_usuario_para' => $usuario_para->saldo,
        ], 200);
    }
}

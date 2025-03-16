<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacao;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function transferir(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|min:6',
        ]);
    
        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->senha),
            'saldo' => 0,
        ]); 
        return response()->json(['message' => 'Usuário cadastrado com sucesso!'], 201);
        
        $usuarioDestino = $request->input('usuario_destino');
        $valorTransferencia = $request->input('valor_transferencia');
        $usuario = Usuario::find(auth()->id());  
        $usuarioDestino = Usuario::where('username', $usuarioDestino)->first();

        if (!$usuarioDestino) {
            return response()->json(['message' => 'Usuário destino não encontrado'], 404);
        }

        if ($usuario->saldo < $valorTransferencia) {
            return response()->json(['message' => 'Saldo insuficiente'], 400);
        }

        $usuario->saldo -= $valorTransferencia;
        $usuarioDestino->saldo += $valorTransferencia;

        $usuario->save();
        $usuarioDestino->save();

        Transacao::create([
            'usuario_id' => $usuario->id,
            'tipo' => 'Transferência',
            'valor' => $valorTransferencia,
            'usuario_destino' => $usuarioDestino->username,
            'data' => now(),
        ]);

        return response()->json(['message' => 'Transferência realizada com sucesso']);
    }

    public function listarTransacoes()
    {
        $transacoes = Transacao::where('usuario_id', auth()->id())->get();
        return response()->json(['transacoes' => $transacoes]);
    }
}

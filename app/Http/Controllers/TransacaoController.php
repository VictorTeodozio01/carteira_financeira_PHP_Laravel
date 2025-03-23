<?php

namespace App\Http\Controllers;

use App\Models\Transacao;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransacaoController extends Controller
{
    public function deposito(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id', 
            'valor' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $usuario = User::findOrFail($request->usuario_id); 
            $usuario->saldo += $request->valor;
            $usuario->save();

            Transacao::create([
                'usuario_id' => $usuario->id,
                'valor' => $request->valor,
                'tipo' => 'deposito',
            ]);
        });

        return response()->json(['mensagem' => 'Depósito realizado com sucesso']);
    }

    public function transferencia(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id', 
            'destinatario_id' => 'required|exists:users,id|different:usuario_id', 
            'valor' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($request) {
            $remetente = User::findOrFail($request->usuario_id); 
            $destinatario = User::findOrFail($request->destinatario_id); 

            if ($remetente->saldo < $request->valor) {
                abort(400, 'Saldo insuficiente para realizar a transferência');
            }

            $remetente->saldo -= $request->valor;
            $destinatario->saldo += $request->valor;

            $remetente->save();
            $destinatario->save();

            Transacao::create([
                'usuario_id' => $remetente->id,
                'destinatario_id' => $destinatario->id,
                'valor' => $request->valor,
                'tipo' => 'transferencia',
            ]);
        });

        return response()->json(['mensagem' => 'Transferência realizada com sucesso']);
    }

    public function reverter(Request $request, $id)
    {
        $transacao = Transacao::findOrFail($id);

        if ($transacao->revertida) {
            return response()->json(['erro' => 'Esta transação já foi revertida anteriormente'], 400);
        }

        DB::transaction(function () use ($transacao) {
            $usuario = User::findOrFail($transacao->usuario_id); 

            if ($transacao->tipo === 'deposito') {
                $usuario->saldo -= $transacao->valor;
            } elseif ($transacao->tipo === 'transferencia') {
                $destinatario = User::findOrFail($transacao->destinatario_id); 
                $usuario->saldo += $transacao->valor;
                $destinatario->saldo -= $transacao->valor;
                $destinatario->save();
            }

            $usuario->save();
            $transacao->revertida = true;
            $transacao->save();
        });

        return response()->json(['mensagem' => 'Transação revertida com sucesso']);
    }

    public function listarTransacoes(Request $request)
    {
        $usuario = $request->user();
        $transacoes = Transacao::where('usuario_id', $usuario->id)->get();
        return response()->json(['transacoes' => $transacoes]);
    }
}
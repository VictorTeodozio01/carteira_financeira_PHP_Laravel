<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function cadastrar(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:6',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'saldo' => 0, 
            ]);
    
            return response()->json([
                'message' => 'Usuário cadastrado com sucesso!',
                'user' => $user,
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar usuário.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
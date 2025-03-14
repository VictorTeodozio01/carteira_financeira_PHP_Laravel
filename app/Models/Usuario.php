<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'saldo'
    ];
    

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    protected $hidden = [
        'password',
    ];
    
    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'usuario_id');
    }
}
